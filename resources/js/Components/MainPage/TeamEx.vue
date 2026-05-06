<script setup>
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref, computed, watch } from "vue";
import draggable from "vuedraggable";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const allExercises = ref([...page.props.teamExercises]);

const props = defineProps({
    filter: {
        type: Object,
        default: () => ({ filterType: "", filterValue: "", filterName: "" }),
    },
});

const PAGE_SIZE = 10;
const currentPage = ref(1);

const exercises = computed(() => {
    return allExercises.value.filter((exercise) => {
        const matchesName = !props.filter.filterName ||
            exercise.name.toLowerCase().includes(props.filter.filterName.toLowerCase());

        const matchesTypeOrDifficulty =
            !props.filter.filterType || !props.filter.filterValue ||
            (props.filter.filterType === "tipo" && exercise.type === props.filter.filterValue) ||
            (props.filter.filterType === "dificultad" && exercise.difficulty === props.filter.filterValue);

        return matchesName && matchesTypeOrDifficulty;
    });
});

const totalPages = computed(() => Math.ceil(exercises.value.length / PAGE_SIZE));

const paginatedExercises = computed(() => {
    const start = (currentPage.value - 1) * PAGE_SIZE;
    return exercises.value.slice(start, start + PAGE_SIZE);
});

watch(exercises, () => {
    currentPage.value = 1;
});
</script>

<template>
    <div class="relative overflow-hidden p-8 self-start">

        <!-- Cabecera -->
        <div class="mb-5 text-center">
            <h3 class="text-base font-bold text-slate-700 tracking-wide uppercase">
                Ejercicios de equipo
            </h3>
            <div class="mx-auto mt-1.5 h-0.5 w-10 rounded-full bg-blue-500"></div>
        </div>

        <!-- Lista draggable -->
        <draggable
            :list="paginatedExercises"
            :group="{ name: 'exercises', pull: 'clone', put: false }"
            item-key="id_exercise"
            :sort="false"
            class="grid gap-3"
        >
            <template #item="{ element }">
                <div class="group cursor-grab active:cursor-grabbing transition-transform duration-150 hover:-translate-y-0.5">
                    <ExerciseCard :exercise="element" />
                </div>
            </template>
        </draggable>

        <!-- Paginación -->
        <div v-if="totalPages > 1" class="flex items-center justify-center gap-2 mt-4">
            <button
                @click="currentPage--"
                :disabled="currentPage === 1"
                class="px-2 py-1 rounded text-sm text-gray-600 hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
            >
                ‹
            </button>
            <span class="text-sm text-gray-500">{{ currentPage }} / {{ totalPages }}</span>
            <button
                @click="currentPage++"
                :disabled="currentPage === totalPages"
                class="px-2 py-1 rounded text-sm text-gray-600 hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
            >
                ›
            </button>
        </div>

        <!-- Decoración fondo -->
        <div class="pointer-events-none absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-100/50 blur-2xl"></div>
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>
