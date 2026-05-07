<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import TrainingCard from "@/Components/Training/TrainingCard.vue";
import ExerciseCard from "@/Components/Training/ExerciseCard.vue";
import Pagination from "../Shared/Pagination.vue";

const props = defineProps({
    trainings: {
        type: Array,
        default: () => [],
    },
    exercises: {
        type: Array,
        default: () => [],
    },
});

const PAGE_SIZE = 10; // Elementos por página

const exercisePage = ref(1);
const totalExercisePages = computed(() => Math.ceil(props.exercises.length / PAGE_SIZE));
const paginatedExercises = computed(() => {
    const start = (exercisePage.value - 1) * PAGE_SIZE;
    return props.exercises.slice(start, start + PAGE_SIZE);
});

const trainingPage = ref(1);
const totalTrainingPages = computed(() => Math.ceil(props.trainings.length / PAGE_SIZE));
const paginatedTrainings = computed(() => {
    const start = (trainingPage.value - 1) * PAGE_SIZE;
    return props.trainings.slice(start, start + PAGE_SIZE);
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
            <div v-if="activeTab === 'ejercicios'">
                <div
                    v-if="exercises.length === 0"
                    class="text-center py-16 text-slate-400"
                >
                    No tienes ejercicios creados aún.
                </div>
                <div v-else class="grid gap-4">
                    <ExerciseCard
                        v-for="exercise in paginatedExercises"
                        :key="exercise.id_exercise"
                        :exercise="exercise"
                    />
                    <Pagination
                        :currentPage="exercisePage"
                        :totalPages="totalExercisePages"
                        @prev="exercisePage--"
                        @next="exercisePage++"
                    />
                </div>
            </div>
            <div v-if="activeTab === 'entrenamientos'">
                <div
                    v-if="trainings.length === 0"
                    class="text-center py-16 text-slate-400"
                >
                    No tienes entrenamientos creados aún.
                </div>
                <TrainingCard :trainings="paginatedTrainings" />
                <Pagination
                    :currentPage="trainingPage"
                    :totalPages="totalTrainingPages"
                    @prev="trainingPage--"
                    @next="trainingPage++"
                />
            </div>
            <div
                v-if="activeTab === 'jugadas'"
                class="text-center text-slate-400 py-16"
            >
                Próximamente — Jugadas
            </div>
        </div>
    </div>
</template>
