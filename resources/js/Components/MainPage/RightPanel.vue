<script setup>
import draggable from "vuedraggable";
import ExerciseCard from "../Training/ExerciseCard.vue";
import TrainingSaveModal from "../Training/TrainingSaveModal.vue";
import { ref, watch } from "vue";

const props = defineProps({
    trainingExercises: Array,
});

const emit = defineEmits(["saved"]);

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

// Estado del modal
const showModal = ref(false);

const openSaveModal = () => {
    if (localTraining.value.length === 0) {
        return;
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const handleSave = () => {
    localTraining.value = [];
    emit("saved");
    showModal.value = false;
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

        <div class="relative flex-1 w-full">
            <draggable
                v-model="localTraining"
                group="exercises"
                item-key="id_exercise"
                class="space-y-2 w-full h-full"
            >
                <template #item="{ element }">
                    <ExerciseCard
                        :exercise="element"
                        :isInTraining="true"
                        @remove="removeExercise"
                    />
                </template>
            </draggable>

            <div
                v-if="localTraining.length === 0"
                class="absolute inset-0 flex items-center justify-center text-gray-400 pointer-events-none"
            >
                <p>Arrastra ejercicios aquí para crear tu entrenamiento</p>
            </div>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            :disabled="localTraining.length === 0"
            @click="openSaveModal"
        >
            Guardar entrenamiento
        </button>

        <TrainingSaveModal
            :show="showModal"
            :exercises="localTraining"
            @close="closeModal"
            @saved="handleSave"
        />
    </div>
</template>