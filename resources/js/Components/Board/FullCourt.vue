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
                        fill: '#C68642',
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
                        fill: '#A0522D55',
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
                        fill: '#A0522D55',
                    }"
                />

                <!-- Semicírculo tiros libres izquierdo -->
                <v-arc
                    :config="{
                        x: 630 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 180 * scale,
                        angle: 180,
                        rotation: -90,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Semicírculo tiros libres derecho -->
                <v-arc
                    :config="{
                        x: 2170 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 180 * scale,
                        angle: 180,
                        rotation: 90,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Arco de tres izquierdo -->
                <v-arc
                    :config="{
                        x: 160 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 690 * scale,
                        angle: 132,
                        rotation: -66,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Arco de tres derecho -->
                <v-arc
                    :config="{
                        x: 2640 * scale,
                        y: 750 * scale,
                        innerRadius: 0,
                        outerRadius: 690 * scale,
                        angle: 132,
                        rotation: 114,
                        stroke: 'white',
                        strokeWidth: 3,
                        fill: 'transparent',
                    }"
                />

                <!-- Aro izquierdo -->
                <v-circle
                    :config="{
                        x: 160 * scale,
                        y: 750 * scale,
                        radius: 45 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
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
                        x: 2640 * scale,
                        y: 750 * scale,
                        radius: 45 * scale,
                        stroke: 'white',
                        strokeWidth: 3,
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