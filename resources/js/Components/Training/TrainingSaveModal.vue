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

const emit = defineEmits(['close', 'saved']);

const trainingName = ref('');
const trainingDescription = ref('');
const trainingDuration = ref('');
const isSaving = ref(false);

// Estado para errores
const errors = ref({
    name: '',
    description: '',
    duration: '',
    general: ''
});

const closeModal = () => {
    if (!isSaving.value) {
        trainingName.value = '';
        trainingDescription.value = '';
        trainingDuration.value = '';
        errors.value = { name: '', description: '', duration: '', general: '' };
        emit('close');
    }
};

const validateForm = () => {
    errors.value = { name: '', description: '', duration: '', general: '' };
    let isValid = true;

    if (!trainingName.value.trim()) {
        errors.value.name = 'El nombre del entrenamiento es obligatorio';
        isValid = false;
    }

    if (props.exercises.length === 0) {
        errors.value.general = 'No hay ejercicios para guardar';
        isValid = false;
    }

    return isValid;
};

const saveTraining = () => {
    if (!validateForm()) {
        return;
    }

    isSaving.value = true;
    errors.value.general = '';

    const payload = {
        name: trainingName.value.trim(),
        description: trainingDescription.value.trim(),
        duration: trainingDuration.value ? parseInt(trainingDuration.value) : null,
        exercises: props.exercises.map((exercise, index) => ({
            id_exercise: exercise.id_exercise,
            order: index,
        })),
    };

    router.post('/trainings', payload, {
        onSuccess: () => {
            isSaving.value = false;
            trainingName.value = '';
            trainingDescription.value = '';
            trainingDuration.value = '';
            errors.value = { name: '', description: '', duration: '', general: '' };
            emit('saved');
        },
        onError: (backendErrors) => {
            isSaving.value = false;
            errors.value = { name: '', description: '', duration: '', general: '' };

            // Manejar errores del backend
            if (backendErrors.name) {
                errors.value.name = backendErrors.name;
            }
            if (backendErrors.description) {
                errors.value.description = backendErrors.description;
            }
            if (backendErrors.duration) {
                errors.value.duration = backendErrors.duration;
            }
            if (backendErrors.exercises) {
                errors.value.general = backendErrors.exercises;
            }

            // Si no hay errores específicos, mostrar mensaje general
            if (!errors.value.name && !errors.value.description && !errors.value.duration && !errors.value.general) {
                errors.value.general = 'Error al guardar el entrenamiento. Inténtalo de nuevo.';
            }
        },
    });
};
</script>

<template>
    <div v-if="show" class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Guardar Entrenamiento</h3>
            <div class="py-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nombre del entrenamiento *</span>
                    </label>
                    <input
                        type="text"
                        v-model="trainingName"
                        class="input input-bordered"
                        :class="{ 'input-error': errors.name }"
                        placeholder="Ej: Entrenamiento de fuerza"
                        required
                        :disabled="isSaving"
                    />
                    <span v-if="errors.name" class="text-error text-sm mt-1">{{ errors.name }}</span>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Descripción</span>
                    </label>
                    <textarea
                        v-model="trainingDescription"
                        class="textarea textarea-bordered"
                        :class="{ 'textarea-error': errors.description }"
                        placeholder="Descripción opcional del entrenamiento"
                        rows="3"
                        :disabled="isSaving"
                    ></textarea>
                    <span v-if="errors.description" class="text-error text-sm mt-1">{{ errors.description }}</span>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Duración (minutos)</span>
                    </label>
                    <input
                        type="number"
                        v-model="trainingDuration"
                        class="input input-bordered"
                        :class="{ 'input-error': errors.duration }"
                        placeholder="Ej: 60"
                        min="1"
                        :disabled="isSaving"
                    />
                    <span v-if="errors.duration" class="text-error text-sm mt-1">{{ errors.duration }}</span>
                </div>
                <div v-if="errors.general" class="alert alert-error mt-4">
                    <span>{{ errors.general }}</span>
                </div>
            </div>
            <div class="modal-action">
                <button
                    type="button"
                    class="btn"
                    @click="closeModal"
                    :disabled="isSaving"
                >
                    Cancelar
                </button>
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="saveTraining"
                    :disabled="isSaving"
                >
                    <span v-if="isSaving" class="loading loading-spinner loading-sm"></span>
                    {{ isSaving ? 'Guardando...' : 'Guardar' }}
                </button>
            </div>
        </div>
    </div>
</template>