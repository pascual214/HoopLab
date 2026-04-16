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

const removeExercise = (id) => {
    localTraining.value = localTraining.value.filter(
        (ex) => ex.id_exercise !== id,
    );
};
</script>

<template>
    <div class="flex flex-col gap-3 p-8 text-center h-full w-full">
        <div class="mb-5 text-center">
            <h3 class="text-base font-bold text-slate-700 tracking-wide uppercase">
                Entrenamiento
            </h3>
            <div class="mx-auto mt-1.5 h-0.5 w-10 rounded-full bg-blue-500"></div>
        </div>
        <draggable
            v-model="localTraining"
            group="exercises"
            item-key="id_exercise"
            class="space-y-2 w-full flex-1"
        >
            <template #item="{ element }">
                <ExerciseCard
                    :exercise="element"
                    :isInTraining="true"
                    @remove="removeExercise"
                />
            </template>
        </draggable>
        <button class="btn btn-primary">Guardar entrenamiento</button>
    </div>
</template>
