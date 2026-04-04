<script setup>
import draggable from "vuedraggable";
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref, watch } from "vue";

const props = defineProps({
    trainingExercises: Array,
});

// Creamos un ref local que será el v-model real
const localTraining = ref([...props.trainingExercises]);

// Sincronizamos con la prop si cambia desde afuera
watch(
    () => props.trainingExercises,
    (newVal) => {
        localTraining.value = [...newVal];
    },
);
</script>

<template>
    <div class="flex flex-col gap-3 p-8 text-center h-full w-full">
        <draggable
            v-model="localTraining"
            group="exercises"
            item-key="id_exercise"
            class="space-y-2 border p-2 w-full flex-1"
        >
            <template #item="{ element, index }">
                <ExerciseCard :exercise="element" />
            </template>
        </draggable>
    </div>
</template>
