<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

const containerRef = ref(null);
const containerWidth = ref(800);

const COURT_RATIO = 15 / 28; // alto / ancho

const stageWidth = computed(() => containerWidth.value);
const stageHeight = computed(() => containerWidth.value * COURT_RATIO);

// Factor de escala para que todo se adapte al tamaño del contenedor
const scale = computed(() => containerWidth.value / 2800);

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
</script>

<template>
    <div ref="containerRef" style="width: 70%; margin: 0 auto">
        <v-stage
            :config="{
                width: stageWidth,
                height: stageHeight,
            }"
        >
            <v-layer>
                <!-- Suelo de la pista -->
                <v-rect
                    :config="{
                        x: 0,
                        y: 0,
                        width: stageWidth,
                        height: stageHeight,
                        fill: '#E8A84A',
                    }"
                />

                <!-- Líneas de la pista -->
                <!-- Perímetro -->
                <v-rect
                    :config="{
                        x: 50 * scale,
                        y: 50 * scale,
                        width: 2700 * scale,
                        height: 1400 * scale,
                        stroke: 'white',
                        strokeWidth: 4,
                        fill: 'transparent',
                    }"
                />

                <!-- Línea central -->
                <v-line
                    :config="{
                        points: [
                            1400 * scale,
                            50 * scale,
                            1400 * scale,
                            1450 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Círculo central -->
                <v-circle
                    :config="{
                        x: 1400 * scale,
                        y: 750 * scale,
                        radius: 180 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Zona izquierda (pintura) -->
                <v-rect
                    :config="{
                        x: 50 * scale,
                        y: 425 * scale,
                        width: 580 * scale,
                        height: 650 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: '#B8712A',
                    }"
                />

                <!-- Zona derecha (pintura) -->
                <v-rect
                    :config="{
                        x: 2170 * scale,
                        y: 425 * scale,
                        width: 580 * scale,
                        height: 650 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: '#B8712A',
                    }"
                />

                <!-- Círculo tiros libres izquierdo -->
                <v-arc
                    :config="{
                        x: 630 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 180 * scale,
                        angle: 360,
                        rotation: -90,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Círculo tiros libres derecho -->
                <v-arc
                    :config="{
                        x: 2170 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 180 * scale,
                        angle: 360,
                        rotation: 90,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Arco de tres izquierdo -->
                <v-path
                    :config="{
                        data: describeArc(
                            160 * scale,
                            750 * scale,
                            690 * scale,
                            -66,
                            66,
                        ),
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Línea recta esquina 3pt izquierda (arriba) -->
                <v-line
                    :config="{
                        points: [
                            50 * scale,
                            120 * scale,
                            441 * scale,
                            120 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Línea recta esquina 3pt izquierda (abajo) -->
                <v-line
                    :config="{
                        points: [
                            50 * scale,
                            1380 * scale,
                            441 * scale,
                            1380 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Arco de tres derecho -->
                <v-path
                    :config="{
                        data: describeArc(
                            2640 * scale,
                            750 * scale,
                            690 * scale,
                            114,
                            246,
                        ),
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Línea recta esquina 3pt derecha (arriba) -->
                <v-line
                    :config="{
                        points: [
                            2359 * scale,
                            120 * scale,
                            2750 * scale,
                            120 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Línea recta esquina 3pt derecha (abajo) -->
                <v-line
                    :config="{
                        points: [
                            2359 * scale,
                            1380 * scale,
                            2750 * scale,
                            1380 * scale,
                        ],
                        stroke: 'white',
                        strokeWidth: 3,
                    }"
                />

                <!-- Área restringida (no carga) izquierda -->
                <v-path
                    :config="{
                        data: describeArc(
                            160 * scale,
                            750 * scale,
                            125 * scale,
                            270,
                            90,
                        ),
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Área restringida (no carga) derecha -->
                <v-path
                    :config="{
                        data: describeArc(
                            2640 * scale,
                            750 * scale,
                            125 * scale,
                            90,
                            270,
                        ),
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Aro izquierdo -->
                <v-circle
                    :config="{
                        x: 140 * scale,
                        y: 750 * scale,
                        radius: 30 * scale,
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Tablero izquierdo -->
                <v-rect
                    :config="{
                        x: 90 * scale,
                        y: 660 * scale,
                        width: 10 * scale,
                        height: 180 * scale,
                        fill: 'white',
                    }"
                />

                <!-- Aro derecho -->
                <v-circle
                    :config="{
                        x: 2660 * scale,
                        y: 750 * scale,
                        radius: 30 * scale,
                        stroke: 'white',
                        strokeWidth: 2,
                        fill: 'transparent',
                    }"
                />

                <!-- Tablero derecho -->
                <v-rect
                    :config="{
                        x: 2700 * scale,
                        y: 660 * scale,
                        width: 10 * scale,
                        height: 180 * scale,
                        fill: 'white',
                    }"
                />

                <!-- Jugadores -->
                <v-group
                    v-for="player in players"
                    :key="player.id"
                    :config="{
                        x: player.x * stageWidth,
                        y: player.y * stageHeight,
                        draggable: true,
                    }"
                >
                    <v-circle
                        :config="{
                            x: 0,
                            y: 0,
                            radius: 40 * scale,
                            fill:
                                player.team === 'local' ? '#3B82F6' : '#EF4444',
                        }"
                    />
                    <v-text
                        :config="{
                            x: -8 * scale,
                            y: -15 * scale,
                            text: String(player.number),
                            fontSize: 30 * scale,
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
