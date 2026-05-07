<script setup>
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref, computed, watch } from "vue";
import draggable from "vuedraggable";
import { usePage } from "@inertiajs/vue3";
import Pagination from "../Shared/Pagination.vue";


const page = usePage();
const allExercises = ref([...page.props.individualExercises]);

const props = defineProps({
    filter: {
        type: Object,
        default: () => ({ filterType: "", filterValue: "", filterName: "" }),
    },
});

const PAGE_SIZE = 10; // Elementos por página
const currentPage = ref(1);

const exercises = computed(() => {
    return allExercises.value.filter((exercise) => {
        const matchesName =
            !props.filter.filterName ||
            exercise.title
                .toLowerCase()
                .includes(props.filter.filterName.toLowerCase());

        const matchesTypeOrDifficulty =
            !props.filter.filterType ||
            !props.filter.filterValue ||
            (props.filter.filterType === "tipo" &&
                exercise.type === props.filter.filterValue) ||
            (props.filter.filterType === "dificultad" &&
                exercise.difficulty === props.filter.filterValue);

        return matchesName && matchesTypeOrDifficulty;
    });
});

const totalPages = computed(() =>
    Math.ceil(exercises.value.length / PAGE_SIZE),
);

const paginatedExercises = computed(() => {
    const start = (currentPage.value - 1) * PAGE_SIZE;
    return exercises.value.slice(start, start + PAGE_SIZE);
});

watch(exercises, () => {
    currentPage.value = 1;
});
</script>

<template>
    <div class="relative overflow-hidden p-8 self-start w-full">
        <!-- Cabecera -->
        <div class="mb-5 text-center">
            <h3
                class="text-base font-bold text-slate-700 tracking-wide uppercase"
            >
                Ejercicios individuales
            </h3>
            <div
                class="mx-auto mt-1.5 h-0.5 w-10 rounded-full bg-blue-500"
            ></div>
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
                <div
                    class="group cursor-grab active:cursor-grabbing transition-transform duration-150 hover:-translate-y-0.5"
                >
                    <ExerciseCard :exercise="element" />
                </div>
            </template>
        </draggable>

        <!-- Paginación -->
        <Pagination
            :currentPage="currentPage"
            :totalPages="totalPages"
            @prev="currentPage--"
            @next="currentPage++"
        />

        <!-- Decoración fondo -->
        <div
            class="pointer-events-none absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-100/50 blur-2xl"
        ></div>
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>
