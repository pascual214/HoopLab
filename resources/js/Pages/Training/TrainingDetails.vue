<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import FullLayout from "@/Layouts/FullLayout.vue";
import ExerciseCard from "@/Components/Training/ExerciseCard.vue";

const props = defineProps({
    training: {
        type: Object,
        required: true,
    },
});

const form = useForm();

const goBack = () => {
    window.history.back();
};

const deleteTraining = () => {
    form.delete(route('trainings.destroy', props.training.id_training));
};

const formatDuration = (minutes) => {
    if (!minutes) return "Sin duración";
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    if (hours > 0) return `${hours}h ${mins}m`;
    return `${mins} minutos`;
};
</script>

<template>
    <Head title="Detalles del entrenamiento" />

    <FullLayout>
        <!-- Botón volver -->
        <div class="bg-blue-100 px-12 pt-6">
            <button @click="goBack" class="btn btn-soft btn-primary btn-md">
                ← Volver
            </button>
        </div>

        <!-- Cabecera azul igual que el perfil -->
        <div class="bg-blue-100 px-6 py-10">
            <div class="max-w-4xl mx-auto flex flex-col items-center gap-4 text-center">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/60 border border-white px-4 py-1.5 text-sm font-semibold text-blue-700">
                    Detalles del entrenamiento
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900">
                    {{ training.name }}
                </h1>
                <p class="max-w-2xl text-sm leading-7 text-slate-600">
                    {{ training.description || "Sin descripción" }}
                </p>
                <!-- Duración destacada -->
                <div class="mt-2 rounded-2xl bg-white/70 border border-white px-6 py-3 shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-slate-400">Duración aproximada</p>
                    <p class="text-2xl font-bold text-slate-900">{{ formatDuration(training.duration) }}</p>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="max-w-4xl mx-auto px-6 py-10 grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">

            <!-- Ejercicios -->
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Ejercicios</h2>
                        <p class="text-sm text-slate-500"></p>
                    </div>
                </div>

                <div class="grid gap-4">
                    <div
                        v-for="(trainingExercise, index) in training.exercises"
                        :key="trainingExercise.id_exercise + '-' + trainingExercise.order"
                    >
                        <ExerciseCard :exercise="trainingExercise.exercise" />
                    </div>
                </div>
            </div>

            <!-- Sidebar información -->
            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Información</h2>
                    <div class="space-y-3 text-sm text-slate-700">
                        <div class="flex justify-between rounded-2xl bg-blue-50 px-4 py-3">
                            <span class="text-slate-500">Creado por</span>
                            <span class="font-semibold">{{ training.created_by || 'Usuario' }}</span>
                        </div>
                        <div class="flex justify-between rounded-2xl bg-blue-50 px-4 py-3">
                            <span class="text-slate-500">Fecha</span>
                            <span class="font-semibold">{{ new Date(training.created_at).toLocaleDateString('es-ES') }}</span>
                        </div>
                        <div class="flex justify-between rounded-2xl bg-blue-50 px-4 py-3">
                            <span class="text-slate-500">Ejercicios</span>
                            <span class="font-semibold">{{ training.exercises.length }}</span>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button
                        @click="deleteTraining"
                        type="button"
                        class="btn btn-soft btn-error w-full hover:text-white"
                    >
                        Eliminar entrenamiento
                    </button>
                </div>
            </aside>
        </div>
    </FullLayout>
</template>