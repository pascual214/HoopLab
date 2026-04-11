<script setup>
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref } from "vue";
import draggable from "vuedraggable";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const exercises = ref([...page.props.individualExercises]); // ref local para sortable
</script>

<template>
    <div class="bg-gray-100 p-4 rounded text-center">
        <h3 class="text-lg font-semibold mb-2">Ejercicios individuales</h3>
        <draggable
            :list="exercises"
            :group="{ name: 'exercises', pull: 'clone', put: false }"
            item-key="id_exercise"
            :sort="false"
            class="grid gap-4"
        >
            <template #item="{ element }">
                <ExerciseCard :exercise="element" />
            </template>
        </draggable>
    </div>
</template>
