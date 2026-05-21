<script setup>
import { ref } from "vue";
import FullLayout from "@/Layouts/FullLayout.vue";
import BoardTopSection from "@/Components/Board/BoardTopSection.vue";
import FullCourt from "@/Components/Board/FullCourt.vue";
import HalfCourt from "@/Components/Board/HalfCourt.vue";
import ToolBar from "@/Components/Board/ToolBar.vue";

const courtMode = ref("full"); // 'full' | 'half'

const players = ref([]);
const localCount = ref(0);
const visitorCount = ref(0);

const history = ref([]); // pila de acciones para deshacer

const addPlayer = (team) => {
    if (team === "local") {
        localCount.value++;
        players.value.push({
            id: Date.now(),
            team: "local",
            number: localCount.value,
            x: 0.15 + Math.random() * 0.2,
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
    history.value.push({ type: "player", team });
};

const undo = () => {
    const last = history.value.pop();
    if (!last) return;
    if (last.type === "player") {
        players.value.pop();
        if (last.team === "local") localCount.value--;
        else visitorCount.value--;
    }
};
</script>

<template>
    <FullLayout>
        <BoardTopSection />

        <!-- Toggle pista -->
        <div class="bg-white sticky top-0 z-20 pt-10">
            <div class="max-full mx-auto flex w-full border-b border-slate-200">
                <button
                    @click="courtMode = 'full'"
                    :class="[
                        'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2 text-center',
                        courtMode === 'full'
                            ? 'border-slate-800 text-slate-800 bg-slate-100'
                            : 'border-transparent text-slate-500 hover:text-slate-700',
                    ]"
                >
                    Pista completa
                </button>
                <button
                    @click="courtMode = 'half'"
                    :class="[
                        'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2 text-center',
                        courtMode === 'half'
                            ? 'border-slate-800 text-slate-800 bg-slate-100'
                            : 'border-transparent text-slate-500 hover:text-slate-700',
                    ]"
                >
                    Media pista
                </button>
            </div>
        </div>

        <FullCourt v-if="courtMode === 'full'" :players="players" class="pt-10"/>
        <HalfCourt v-else :players="players" class="pt-10"/>

        <ToolBar
            @add-player="addPlayer"
            @undo="undo"
            :can-undo="history.length > 0"
        />
    </FullLayout>
</template>
