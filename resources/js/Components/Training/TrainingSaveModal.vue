<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    exercises: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["close", "saved"]);

const trainingName = ref("");
const trainingDescription = ref("");
const trainingDuration = ref("");
const isSaving = ref(false);

const errors = ref({
    name: "",
    description: "",
    duration: "",
    general: "",
});

const closeModal = () => {
    if (!isSaving.value) {
        trainingName.value = "";
        trainingDescription.value = "";
        trainingDuration.value = "";
        errors.value = { name: "", description: "", duration: "", general: "" };
        emit("close");
    }
};

const validateForm = () => {
    errors.value = { name: "", description: "", duration: "", general: "" };
    let isValid = true;

    if (!trainingName.value.trim()) {
        errors.value.name = "El nombre del entrenamiento es obligatorio";
        isValid = false;
    }

    if (props.exercises.length === 0) {
        errors.value.general = "No hay ejercicios para guardar";
        isValid = false;
    }

    return isValid;
};

const saveTraining = () => {
    if (!validateForm()) return;

    isSaving.value = true;
    errors.value.general = "";

    const payload = {
        name: trainingName.value.trim(),
        description: trainingDescription.value.trim(),
        duration: trainingDuration.value
            ? parseInt(trainingDuration.value)
            : null,
        exercises: props.exercises.map((exercise, index) => ({
            id_exercise: exercise.id_exercise,
            order: index,
        })),
    };

    router.post("/trainings", payload, {
        onSuccess: () => {
            isSaving.value = false;
            trainingName.value = "";
            trainingDescription.value = "";
            trainingDuration.value = "";
            errors.value = {
                name: "",
                description: "",
                duration: "",
                general: "",
            };
            emit("saved");
        },
        onError: (backendErrors) => {
            isSaving.value = false;
            errors.value = {
                name: "",
                description: "",
                duration: "",
                general: "",
            };

            if (backendErrors.name) errors.value.name = backendErrors.name;
            if (backendErrors.description)
                errors.value.description = backendErrors.description;
            if (backendErrors.duration)
                errors.value.duration = backendErrors.duration;
            if (backendErrors.exercises)
                errors.value.general = backendErrors.exercises;

            if (
                !errors.value.name &&
                !errors.value.description &&
                !errors.value.duration &&
                !errors.value.general
            ) {
                errors.value.general =
                    "Error al guardar el entrenamiento. Inténtalo de nuevo.";
            }
        },
    });
};
</script>

<template>
    <!-- Overlay -->
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
        @click.self="closeModal"
    >
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <!-- Header -->
            <div class="mb-5">
                <h3
                    class="text-base font-bold text-gray-900 tracking-wide uppercase"
                >
                    Guardar Entrenamiento
                </h3>
                <div class="mt-1.5 h-0.5 w-10 rounded-full bg-blue-500 mx-auto"></div>
            </div>

            <!-- Campos -->
            <div class="space-y-4">
                <!-- Nombre -->
                <div>
                    <label class="text-xs text-gray-400 font-medium mb-1 block">
                        Nombre del entrenamiento *
                    </label>
                    <input
                        type="text"
                        v-model="trainingName"
                        class="w-full rounded-xl border px-4 py-2 text-sm text-gray-700 outline-none transition focus:ring-2 focus:ring-blue-400"
                        :class="
                            errors.name ? 'border-red-400' : 'border-gray-200'
                        "
                        placeholder="Ej: Trenzas"
                        :disabled="isSaving"
                    />
                    <span
                        v-if="errors.name"
                        class="text-red-500 text-xs mt-1 block"
                        >{{ errors.name }}</span
                    >
                </div>

                <!-- Descripción -->
                <div>
                    <label class="text-xs text-gray-400 font-medium mb-1 block">
                        Descripción
                    </label>
                    <textarea
                        v-model="trainingDescription"
                        class="w-full rounded-xl border px-4 py-2 text-sm text-gray-700 outline-none transition focus:ring-2 focus:ring-blue-400 resize-none"
                        :class="
                            errors.description
                                ? 'border-red-400'
                                : 'border-gray-200'
                        "
                        placeholder="Descripción opcional del entrenamiento"
                        rows="3"
                        :disabled="isSaving"
                    ></textarea>
                    <span
                        v-if="errors.description"
                        class="text-red-500 text-xs mt-1 block"
                        >{{ errors.description }}</span
                    >
                </div>

                <!-- Duración -->
                <div>
                    <label class="text-xs text-gray-400 font-medium mb-1 block">
                        Duración (minutos)
                    </label>
                    <input
                        type="number"
                        v-model="trainingDuration"
                        class="w-full rounded-xl border px-4 py-2 text-sm text-gray-700 outline-none transition focus:ring-2 focus:ring-blue-400"
                        :class="
                            errors.duration
                                ? 'border-red-400'
                                : 'border-gray-200'
                        "
                        placeholder="Ej: 60"
                        min="5"
                        :disabled="isSaving"
                    />
                    <span
                        v-if="errors.duration"
                        class="text-red-500 text-xs mt-1 block"
                        >{{ errors.duration }}</span
                    >
                </div>

                <!-- Error general -->
                <div
                    v-if="errors.general"
                    class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-600"
                >
                    {{ errors.general }}
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-2 mt-6">
                <button
                    type="button"
                    class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 border border-gray-200 hover:bg-gray-50 transition disabled:opacity-50"
                    @click="closeModal"
                    :disabled="isSaving"
                >
                    Cancelar
                </button>
                <button
                    type="button"
                    class="px-4 py-2 rounded-xl text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 transition disabled:opacity-60 flex items-center gap-2"
                    @click="saveTraining"
                    :disabled="isSaving"
                >
                    Guardar
                </button>
            </div>
        </div>
    </div>
</template>
