<script setup>
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref, computed } from "vue";
import draggable from "vuedraggable";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const allExercises = ref([...page.props.individualExercises]); // ref local para sortable

const props = defineProps({
    filter: {
        type: Object,
        default: () => ({ filterType: "", filterValue: "" }),
    },
});

const exercises = computed(() => {
    if (!props.filter.filterType || !props.filter.filterValue) {
        return allExercises.value;
    }

    return allExercises.value.filter((exercise) => {
        if (props.filter.filterType === "tipo") {
            return exercise.type === props.filter.filterValue;
        } else if (props.filter.filterType === "dificultad") {
            return exercise.difficulty === props.filter.filterValue;
        }
        return true;
    });
});
</script>

<template>
    <div class="relative overflow-hidden p-8">

        <!-- Cabecera -->
        <div class="mb-5 text-center">
            <h3 class="text-base font-bold text-slate-700 tracking-wide uppercase">
                Ejercicios individuales
            </h3>
            <div class="mx-auto mt-1.5 h-0.5 w-10 rounded-full bg-blue-500"></div>
        </div>

        <!-- Lista draggable -->
        <draggable
            :list="exercises"
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

        <!-- Decoración fondo -->
        <div class="pointer-events-none absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-100/50 blur-2xl"></div>
    </div>
</template>
<style scoped>
/* Estilos locales */
</style>