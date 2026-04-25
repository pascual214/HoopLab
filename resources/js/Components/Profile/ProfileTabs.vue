<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import TrainingCard from "@/Components/Training/TrainingCard.vue";

const props = defineProps({
    trainings: {
        type: Array,
        default: () => [],
    },
});

const tabs = ["Ejercicios", "Entrenamientos", "Jugadas"];
const activeTab = ref("entrenamientos");

// Sticky logic
const tabsRef = ref(null);
const isSticky = ref(false);

function handleScroll() {
    if (!tabsRef.value) return;
    const rect = tabsRef.value.getBoundingClientRect();
    isSticky.value = rect.top <= 0;
}

onMounted(() => window.addEventListener("scroll", handleScroll));
onUnmounted(() => window.removeEventListener("scroll", handleScroll));
</script>

<template>
    <div>
        <!-- Tabs -->
        <div
            ref="tabsRef"
            :class="[
                'border-b border-slate-200 bg-white z-40 transition-shadow duration-200',
                isSticky ? 'sticky top-0 shadow-md' : '',
            ]"
        >
            <div class="max-w-full mx-auto flex">
                <button
                    v-for="tab in tabs"
                    :key="tab"
                    @click="activeTab = tab.toLowerCase()"
                    :class="[
                        'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2',
                        activeTab === tab.toLowerCase()
                            ? 'border-slate-800 text-slate-800 bg-slate-100'
                            : 'border-transparent text-slate-500 hover:text-slate-700',
                    ]"
                >
                    {{ tab }}
                </button>
            </div>
        </div>

        <!-- Contenido -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div v-if="activeTab === 'ejercicios'" class="text-center text-slate-400 py-16">
                Próximamente — Ejercicios
            </div>
            <div v-if="activeTab === 'entrenamientos'">
                <TrainingCard :trainings="trainings" />
            </div>
            <div v-if="activeTab === 'jugadas'" class="text-center text-slate-400 py-16">
                Próximamente — Jugadas
            </div>
        </div>
    </div>
</template>