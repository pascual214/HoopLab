<script setup>
import { useForm } from '@inertiajs/vue3';
import FullLayout from '@/Layouts/FullLayout.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    title: '',
    description: '',
    type: '',
    difficulty: '',
    is_individual: true,
});

const submit = () => {
    form.post(route('exercises.store'));
};
</script>

<template>
    <FullLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear nuevo ejercicio
            </h2>
        </template>

        <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl ring-1 ring-slate-200">
                <form @submit.prevent="submit" class="card-body space-y-6">
                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Título</span>
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="Nombre del ejercicio"
                            class="input input-bordered w-full bg-white"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Descripción</span>
                        </label>
                        <textarea
                            v-model="form.description"
                            placeholder="Describe el ejercicio"
                            rows="4"
                            class="textarea textarea-bordered w-full bg-white"
                        />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="label">
                                <span class="label-text font-medium">Tipo</span>
                            </label>
                            <input
                                v-model="form.type"
                                type="text"
                                placeholder="Ej. Fuerza, Cardio, Flexibilidad"
                                class="input input-bordered w-full bg-white"
                            />
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text font-medium">Dificultad</span>
                            </label>
                            <select
                                v-model="form.difficulty"
                                class="select select-bordered w-full bg-white"
                            >
                                <option value="">Selecciona una dificultad</option>
                                <option value="facil">Fácil</option>
                                <option value="intermedio">Intermedio</option>
                                <option value="dificil">Difícil</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.difficulty" />
                        </div>
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Modalidad</span>
                        </label>
                        <select
                            v-model="form.is_individual"
                            class="select select-bordered w-full bg-white"
                        >
                            <option :value="true">Individual</option>
                            <option :value="false">Equipo</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.is_individual" />
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn btn-primary"
                        >
                            Guardar ejercicio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </FullLayout>
</template>
