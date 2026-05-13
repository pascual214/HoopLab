<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

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

defineProps({
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
    <div ref="containerRef" style="width: 50%; margin: 0 auto">
        <v-stage :config="{ width: stageWidth, height: stageHeight }">
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
