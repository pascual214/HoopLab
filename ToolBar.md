# Documentación del Tablero Táctico — Jugadores y Líneas

## Visión general de la arquitectura

El tablero táctico se construye con cuatro componentes Vue que se reparten responsabilidades bien diferenciadas:

```
Index.vue (Board)           ← Estado global y coordinación
├── BoardTopSection.vue     ← Cabecera
├── FullCourt.vue           ← Canvas de pista completa
├── HalfCourt.vue           ← Canvas de media pista
└── ToolBar.vue             ← Barra de herramientas
```

**`Index.vue`** es el único componente con estado. Mantiene los arrays de jugadores y líneas, y los pasa hacia abajo como props. Cuando un componente hijo necesita modificar algo, lo hace emitiendo un evento hacia arriba. Esto sigue el patrón de Vue de _flujo de datos unidireccional_ (props down, events up).

---

## Sistema de coordenadas normalizadas

Antes de entrar en jugadores y líneas, es fundamental entender el sistema de coordenadas utilizado.

**El problema:** el canvas (el `<v-stage>` de Konva) tiene un tamaño en píxeles que cambia cuando el usuario redimensiona la ventana. Si una línea se guardara en píxeles absolutos, quedaría desplazada al cambiar el tamaño.

**La solución:** todas las posiciones se guardan en **coordenadas normalizadas**, valores entre 0 y 1 que representan un porcentaje del ancho/alto del canvas. Al renderizar, se multiplica por el tamaño real del stage en ese momento.

```js
// Al capturar la posición del ratón en el canvas:
const getStagePos = (e) => {
    const pos = stage.getPointerPosition();
    return {
        x: pos.x / stageWidth.value,   // 0.0 → 1.0
        y: pos.y / stageHeight.value,  // 0.0 → 1.0
    };
};

// Al renderizar, se convierte de vuelta a píxeles:
points: [
    line.x1 * stageWidth.value,
    line.y1 * stageHeight.value,
    line.x2 * stageWidth.value,
    line.y2 * stageHeight.value,
]
```

Esto garantiza que líneas y jugadores se mantienen en la posición correcta independientemente del tamaño de pantalla.

---

## Escalado responsivo de la pista

Las pistas se dibujan sobre un sistema de coordenadas base (2800×1500 para pista completa, 1500×1400 para media pista) y se escalan al contenedor real usando un factor `scale`.

```js
// FullCourt.vue
const COURT_RATIO = 15 / 28;  // alto / ancho real de una pista de baloncesto
const stageWidth  = computed(() => containerWidth.value);
const stageHeight = computed(() => containerWidth.value * COURT_RATIO);
const scale       = computed(() => containerWidth.value / 2800);
```

Cada elemento de la pista multiplica su coordenada por `scale`. Por ejemplo, la zona de la pintura izquierda:

```js
{ x: 50 * scale, y: 425 * scale, width: 580 * scale, height: 650 * scale }
```

Cuando la ventana cambia de tamaño, un listener actualiza `containerWidth`, los computed se recalculan y Vue re-renderiza todo automáticamente.

---

## Jugadores

### Estado en Index.vue

```js
const players      = ref([]);   // array con todos los jugadores en pista
const localCount   = ref(0);    // contador para numerar al equipo local
const visitorCount = ref(0);    // contador para numerar al equipo visitante
```

### Añadir un jugador

Cuando el usuario pulsa el botón de equipo local o visitante en la `ToolBar`, se emite el evento `add-player` con el equipo como argumento. `Index.vue` lo recibe y ejecuta `addPlayer`:

```js
const addPlayer = (team) => {
    if (team === "local") {
        localCount.value++;
        players.value.push({
            id: Date.now(),          // ID único basado en timestamp
            team: "local",
            number: localCount.value,
            x: 0.15 + Math.random() * 0.2,  // posición aleatoria en la mitad izquierda
            y: 0.3 + Math.random() * 0.4,
        });
    } else {
        visitorCount.value++;
        players.value.push({
            id: Date.now(),
            team: "visitante",
            number: visitorCount.value,
            x: 0.65 + Math.random() * 0.2,  // posición aleatoria en la mitad derecha
            y: 0.3 + Math.random() * 0.4,
        });
    }
};
```

Los jugadores locales aparecen en la mitad izquierda del campo (x entre 0.15 y 0.35) y los visitantes en la mitad derecha (x entre 0.65 y 0.85), lo que facilita la disposición inicial.

El botón en `ToolBar` muestra el número que tendrá el siguiente jugador (`localCount + 1`) para que el entrenador sepa qué número va a colocar.

### Renderizado del jugador en el canvas

Cada jugador se renderiza como un `v-group` de Konva que contiene un círculo y un texto. El `v-group` tiene la propiedad `draggable: true` cuando no hay ninguna herramienta activa, lo que permite arrastrarlo directamente sobre el canvas:

```html
<v-group
    v-for="player in players"
    :key="player.id"
    :config="{
        x: player.x * stageWidth,
        y: player.y * stageHeight,
        draggable: !activeTool,   ← solo se puede arrastrar si no estás dibujando
    }"
>
    <v-circle :config="{ radius: 16, fill: player.team === 'local' ? '#3B82F6' : '#EF4444', ... }" />
    <v-text   :config="{ text: String(player.number), fill: 'white', fontStyle: 'bold', ... }" />
</v-group>
```

La distinción de equipo se hace únicamente por color:
- **Equipo local:** azul (`#3B82F6` con borde `#1D4ED8`)
- **Equipo visitante:** rojo (`#EF4444` con borde `#B91C1C`)

> **Nota importante:** el arrastre lo gestiona Konva internamente. Como las posiciones del jugador están almacenadas en coordenadas normalizadas pero el grupo se posiciona en píxeles, Konva actualiza la posición del grupo en píxeles al arrastrarlo. Las coordenadas del objeto en `players[]` no se actualizan en tiempo real durante el arrastre; eso es un comportamiento aceptado en la implementación actual.

---

## Herramientas de dibujo

### Selección de herramienta (ToolBar.vue)

La barra contiene cuatro botones de tipo de línea. El estado de la herramienta activa vive en `Index.vue` como `activeTool` (un string o `null`).

El mecanismo de selección es un **toggle**: si pulsas la herramienta que ya está activa, se desactiva (vuelve a `null`); si pulsas otra, se activa esa.

```js
// ToolBar.vue
const toggleTool = (tool) => {
    emit("set-tool", props.activeTool === tool ? null : tool);
};
```

Los cuatro tipos de línea disponibles y su identificador interno:

| Botón            | `activeTool`    | Descripción táctica                      |
|------------------|-----------------|------------------------------------------|
| Línea continua   | `line-normal`   | Movimiento sin balón                     |
| Línea discontinua| `line-dashed`   | Pase o movimiento con balón              |
| Línea de bloqueo | `line-block`    | Bloqueo (con barra perpendicular al final)|
| Flecha           | `line-arrow`    | Dirección de movimiento o pase           |

El botón activo recibe clases CSS distintas (fondo oscuro) para indicar visualmente que está seleccionado.

Cuando hay una herramienta activa, el cursor del canvas cambia a `crosshair` para indicar que el usuario está en modo dibujo.

### Flujo de dibujo de una línea

El dibujo se gestiona completamente dentro de `FullCourt.vue` o `HalfCourt.vue` mediante tres estados reactivos:

```js
const isDrawing  = ref(false);              // ¿estamos dibujando ahora mismo?
const drawStart  = ref({ x: 0, y: 0 });    // punto inicial (coordenadas normalizadas)
const previewEnd = ref({ x: 0, y: 0 });    // punto actual del cursor (para la preview)
```

El ciclo completo de un trazo ocurre en tres eventos del mouse:

```
mousedown  →  mouseMove (×N)  →  mouseup
   ↓               ↓               ↓
guarda inicio   actualiza      valida longitud
y activa flag   previewEnd     y emite la línea
```

**1. `handleMouseDown`** — solo actúa si hay una herramienta activa:
```js
const handleMouseDown = (e) => {
    if (!props.activeTool) return;
    const pos = getStagePos(e);
    isDrawing.value = true;
    drawStart.value = pos;
    previewEnd.value = pos;
};
```

**2. `handleMouseMove`** — actualiza el punto final de la preview mientras se arrastra:
```js
const handleMouseMove = (e) => {
    if (!isDrawing.value) return;
    previewEnd.value = getStagePos(e);
};
```

**3. `handleMouseUp`** — finaliza el trazo. Calcula la longitud para descartar clics accidentales (el umbral es 0.01 en coordenadas normalizadas, aproximadamente 1% del ancho del canvas). Si supera el umbral, emite el evento `add-line` hacia `Index.vue`:
```js
const handleMouseUp = (e) => {
    if (!isDrawing.value) return;
    isDrawing.value = false;
    const pos = getStagePos(e);
    const dx = pos.x - drawStart.value.x;
    const dy = pos.y - drawStart.value.y;
    if (Math.sqrt(dx * dx + dy * dy) > 0.01) {   // filtro anti-clic
        emit("add-line", {
            id: Date.now(),
            type: props.activeTool.replace("line-", ""),  // "normal", "dashed", "block", "arrow"
            x1: drawStart.value.x,
            y1: drawStart.value.y,
            x2: pos.x,
            y2: pos.y,
        });
    }
};
```

**`handleMouseLeave`** cancela el dibujo si el cursor sale del canvas.

### Preview en tiempo real

Mientras se dibuja, se muestra una línea semitransparente y discontinua que indica el trazo que se está haciendo. Esto es un computed que depende de `drawStart` y `previewEnd`:

```js
const previewConfig = computed(() => ({
    points: [
        drawStart.value.x * stageWidth.value,
        drawStart.value.y * stageHeight.value,
        previewEnd.value.x * stageWidth.value,
        previewEnd.value.y * stageHeight.value,
    ],
    stroke: "#111",
    strokeWidth: 2,
    dash: [8, 4],
    opacity: 0.5,
}));
```

En el template solo se renderiza si `isDrawing` es `true`:
```html
<v-line v-if="isDrawing" :config="previewConfig" />
```

### Renderizado de cada tipo de línea

Las líneas guardadas se renderizan iterando sobre el array `lines` con un `v-for`. Cada tipo tiene su propia lógica de renderizado:

**Línea normal:** usa `v-line` de Konva directamente.

**Línea discontinua:** igual que la normal pero con `dash: [15, 8]` en la configuración:
```js
if (line.type === "dashed") {
    config.dash = [15, 8];  // 15px de trazo, 8px de hueco
}
```

**Flecha:** usa el componente `v-arrow` de Konva, que añade automáticamente la punta de flecha:
```js
const getArrowConfig = (line) => ({
    points: [...],
    pointerLength: 12,  // longitud de la punta
    pointerWidth: 10,   // anchura de la punta
});
```

**Línea de bloqueo:** es la más elaborada. Se renderiza como dos elementos: la línea principal (con `v-line`) más una barra perpendicular en el extremo final (también con `v-line`). La barra se calcula mediante álgebra vectorial: se obtiene el vector perpendicular al trazo y se dibuja la barra centrada en el punto final:

```js
const getBlockEndConfig = (line) => {
    const dx = x2 - line.x1 * stageWidth.value;
    const dy = y2 - line.y1 * stageHeight.value;
    const len = Math.sqrt(dx * dx + dy * dy);  // longitud del trazo
    const px = (-dy / len) * 18;  // vector perpendicular unitario × 18px
    const py = (dx / len) * 18;
    return {
        points: [x2 - px, y2 - py, x2 + px, y2 + py],  // barra centrada en (x2, y2)
        ...
    };
};
```

### Almacenamiento de líneas en Index.vue

`Index.vue` simplemente añade cada línea emitida al array reactivo:

```js
const lines = ref([]);

const addLine = (line) => {
    lines.value.push(line);
};
```

---

## Borrar el tablero

El botón "Borrar todo" de `ToolBar` emite el evento `clear-board`. `Index.vue` lo recibe y resetea todos los estados a su valor inicial:

```js
const clearBoard = () => {
    players.value = [];
    lines.value = [];
    localCount.value = 0;
    visitorCount.value = 0;
};
```

Esto limpia simultáneamente jugadores, líneas y contadores de numeración.

---

## Tecnología utilizada

- **Vue 3** con Composition API (`<script setup>`) para gestión del estado y componentes.
- **Konva / vue-konva** como motor de canvas 2D. Konva abstrae la API nativa del `<canvas>` de HTML y ofrece componentes como `v-stage`, `v-layer`, `v-line`, `v-circle`, `v-arrow`, etc.
- **Tailwind CSS** para los estilos de la barra de herramientas.
- **SVG inline** en los botones de la `ToolBar` para mostrar una previsualización del tipo de línea que representa cada herramienta.
