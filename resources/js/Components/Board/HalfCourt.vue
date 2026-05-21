<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

const emit = defineEmits(["add-line"]);

const containerRef = ref(null);
const containerWidth = ref(800);

const COURT_RATIO = 14 / 15;

const stageWidth = computed(() => containerWidth.value);
const stageHeight = computed(() => containerWidth.value * COURT_RATIO);
const scale = computed(() => containerWidth.value / 1500);

const updateSize = () => {
    if (containerRef.value) {
        containerWidth.value = containerRef.value.offsetWidth;
    }
};

onMounted(() => {
    updateSize();
    window.addEventListener("resize", updateSize);
});

onUnmounted(() => {
    window.removeEventListener("resize", updateSize);
});

const props = defineProps({
    players: {
        type: Array,
        default: () => [],
    },
    lines: {
        type: Array,
        default: () => [],
    },
    activeTool: {
        type: String,
        default: null,
    },
});

// Quitar unión en las semicircunferencias
const describeArc = (x, y, radius, startAngle, endAngle) => {
    const toRad = (deg) => (deg * Math.PI) / 180;
    const x1 = x + radius * Math.cos(toRad(startAngle));
    const y1 = y + radius * Math.sin(toRad(startAngle));
    const x2 = x + radius * Math.cos(toRad(endAngle));
    const y2 = y + radius * Math.sin(toRad(endAngle));
    const largeArc = endAngle - startAngle > 180 ? 1 : 0;
    return `M ${x1} ${y1} A ${radius} ${radius} 0 ${largeArc} 1 ${x2} ${y2}`;
};

// --- Lógica de dibujo ---

const isDrawing = ref(false);
const drawStart = ref({ x: 0, y: 0 });
const previewEnd = ref({ x: 0, y: 0 });

const getStagePos = (e) => {
    const stage = e.target.getStage();
    const pos = stage.getPointerPosition();
    return {
        x: pos.x / stageWidth.value,
        y: pos.y / stageHeight.value,
    };
};

const handleMouseDown = (e) => {
    if (!props.activeTool) return;
    const pos = getStagePos(e);
    isDrawing.value = true;
    drawStart.value = pos;
    previewEnd.value = pos;
};

const handleMouseMove = (e) => {
    if (!isDrawing.value) return;
    previewEnd.value = getStagePos(e);
};

const handleMouseUp = (e) => {
    if (!isDrawing.value) return;
    isDrawing.value = false;
    const pos = getStagePos(e);
    const dx = pos.x - drawStart.value.x;
    const dy = pos.y - drawStart.value.y;
    if (Math.sqrt(dx * dx + dy * dy) > 0.01) {
        emit("add-line", {
            id: Date.now(),
            type: props.activeTool.replace("line-", ""),
            x1: drawStart.value.x,
            y1: drawStart.value.y,
            x2: pos.x,
            y2: pos.y,
        });
    }
};

const handleMouseLeave = () => {
    isDrawing.value = false;
};

// --- Helpers para renderizar líneas ---

const getLineConfig = (line) => {
    const config = {
        points: [
            line.x1 * stageWidth.value,
            line.y1 * stageHeight.value,
            line.x2 * stageWidth.value,
            line.y2 * stageHeight.value,
        ],
        stroke: "#111",
        strokeWidth: 3,
        lineCap: "round",
    };
    if (line.type === "dashed") {
        config.dash = [15, 8];
    }
    return config;
};

const getArrowConfig = (line) => ({
    points: [
        line.x1 * stageWidth.value,
        line.y1 * stageHeight.value,
        line.x2 * stageWidth.value,
        line.y2 * stageHeight.value,
    ],
    stroke: "#111",
    fill: "#111",
    strokeWidth: 3,
    pointerLength: 12,
    pointerWidth: 10,
});

const getBlockEndConfig = (line) => {
    const x2 = line.x2 * stageWidth.value;
    const y2 = line.y2 * stageHeight.value;
    const dx = x2 - line.x1 * stageWidth.value;
    const dy = y2 - line.y1 * stageHeight.value;
    const len = Math.sqrt(dx * dx + dy * dy);
    if (len < 1) return { points: [0, 0, 0, 0], stroke: "transparent" };
    const px = (-dy / len) * 18;
    const py = (dx / len) * 18;
    return {
        points: [x2 - px, y2 - py, x2 + px, y2 + py],
        stroke: "#111",
        strokeWidth: 3,
        lineCap: "round",
    };
};

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
    lineCap: "round",
}));
</script>

<template>
    <div
        ref="containerRef"
        :style="{
            width: '50%',
            margin: '0 auto',
            cursor: activeTool ? 'crosshair' : 'default',
        }"
    >
        <v-stage
            :config="{ width: stageWidth, height: stageHeight }"
            @mousedown="handleMouseDown"
            @mousemove="handleMouseMove"
            @mouseup="handleMouseUp"
            @mouseleave="handleMouseLeave"
        >
            <v-layer>
                <!-- Suelo -->
                <v-rect
                    :config="{
                        x: 0,
                        y: 0,
                        width: stageWidth,
                        height: stageHeight,
                        fill: '#E8A84A',
                    }"
                />

                <!-- Perímetro -->
                <v-rect
                    :config="{
                        x: 50 * scale,
                        y: 50 * scale,
                        width: 1400 * scale,
                        height: 1300 * scale,
                        stroke: 'white',
                        strokeWidth: 4,
                        fill: 'transparent',
                    }"
                />

                <!-- Línea de medio campo (arriba, discontinua) -->
                <v-line
                    :config="{
                        points: [
                            50 * scale,
                            50 * scale,
                            1450 * scale,
                            50 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                        dash: [10, 8],
                    }"
                />

                <!-- Zona (pintura) centrada horizontalmente, abajo -->
                <v-rect
                    :config="{
                        x: 425 * scale,
                        y: 770 * scale,
                        width: 650 * scale,
                        height: 580 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: '#B8712A',
                    }"
                />

                <!-- Círculo tiros libres (encima de la zona) -->
                <v-arc
                    :config="{
                        x: 750 * scale,
                        y: 770 * scale,
                        innerRadius: 0,
                        outerRadius: 180 * scale,
                        angle: 360,
                        rotation: 180,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Arco de tres -->
                <v-path
                    :config="{
                        data: describeArc(
                            750 * scale,
                            1210 * scale,
                            690 * scale,
                            204,
                            336,
                        ),
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Área restringida (no carga) -->
                <v-path
                    :config="{
                        data: describeArc(
                            750 * scale,
                            1210 * scale,
                            125 * scale,
                            180,
                            360,
                        ),
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Línea recta esquina 3pt izquierda -->
                <v-line
                    :config="{
                        points: [
                            120 * scale,
                            929 * scale,
                            120 * scale,
                            1350 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Línea recta esquina 3pt derecha -->
                <v-line
                    :config="{
                        points: [
                            1380 * scale,
                            929 * scale,
                            1380 * scale,
                            1350 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Tablero -->
                <v-rect
                    :config="{
                        x: 660 * scale,
                        y: 1260 * scale,
                        width: 180 * scale,
                        height: 10 * scale,
                        fill: 'white',
                    }"
                />

                <!-- Aro -->
                <v-circle
                    :config="{
                        x: 750 * scale,
                        y: 1220 * scale,
                        radius: 30 * scale,
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Líneas dibujadas por el usuario -->
                <template v-for="line in lines" :key="line.id">
                    <v-arrow
                        v-if="line.type === 'arrow'"
                        :config="getArrowConfig(line)"
                    />
                    <v-line
                        v-if="line.type !== 'arrow'"
                        :config="getLineConfig(line)"
                    />
                    <v-line
                        v-if="line.type === 'block'"
                        :config="getBlockEndConfig(line)"
                    />
                </template>

                <!-- Preview mientras se dibuja -->
                <v-line v-if="isDrawing" :config="previewConfig" />

                <!-- Jugadores -->
                <v-group
                    v-for="player in players"
                    :key="player.id"
                    :config="{
                        x: player.x * stageWidth,
                        y: player.y * stageHeight,
                        draggable: !activeTool,
                    }"
                >
                    <v-circle
                        :config="{
                            x: 0,
                            y: 0,
                            radius: 16,
                            fill:
                                player.team === 'local' ? '#3B82F6' : '#EF4444',
                            stroke:
                                player.team === 'local' ? '#1D4ED8' : '#B91C1C',
                            strokeWidth: 3,
                        }"
                    />
                    <v-text
                        :config="{
                            x: -6 * scale,
                            y: -12 * scale,
                            text: String(player.number),
                            fontSize: 14,
                            fill: 'white',
                            fontStyle: 'bold',
                        }"
                    />
                </v-group>
            </v-layer>
        </v-stage>
    </div>
</template>

<style scoped>
canvas {
    display: block;
}
</style>
