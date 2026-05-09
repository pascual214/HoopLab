<script setup>
import { ref } from "vue";
import BoardTopSection from '@/Components/Board/BoardTopSection.vue';
import FullCourt from '@/Components/Board/FullCourt.vue';
import FullLayout from '@/Layouts/FullLayout.vue';
import ToolBar from "@/Components/Board/ToolBar.vue";

const players = ref([]);
const localCount = ref(0);
const visitorCount = ref(0);

const addPlayer = (team) => {
    if (team === "local") {
        localCount.value++;
        players.value.push({
            id: Date.now(),
            team: "local",
            number: localCount.value,
            x: 0.15 + Math.random() * 0.2,  // proporción 0-1
            y: 0.3 + Math.random() * 0.4,
        });
    } else {
        visitorCount.value++;
        players.value.push({
            id: Date.now(),
            team: "visitante",
            number: visitorCount.value,
            x: 0.65 + Math.random() * 0.2,
            y: 0.3 + Math.random() * 0.4,
        });
    }
};
</script>

<template>
    <FullLayout>
        <BoardTopSection />

        <FullCourt :players="players" />

        <ToolBar @add-player="addPlayer" />
    </FullLayout>
</template>

<style scoped>
/* Estilos locales */
</style>