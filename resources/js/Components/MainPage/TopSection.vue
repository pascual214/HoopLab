<script setup>
import { Link } from "@inertiajs/vue3";
import ExerciseFilter from "@/Components/Training/ExerciseFilter.vue";

const props = defineProps({
    mode: String,
    availableTypes: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["update:mode", "filter-change"]);

const handleFilterChange = (filterData) => {
    emit("filter-change", filterData);
};
</script>

<template>
    <div class="bg-blue-200 px-4 py-6 text-center">
        <h2 class="text-center text-xl font-semibold text-slate-800">
            Diseña tu entrenamiento
        </h2>
        <div class="mt-4 flex justify-center">
            <Link
                class="btn btn-primary"
                :href="route('exercises.create')"
            >
                Crear Ejercicio
            </Link>
        </div>
    </div>

    <div class="bg-white sticky top-0 z-20">
        <div class="max-full mx-auto flex w-full border-b border-slate-200">
            <button
                @click="emit('update:mode', 'individual')"
                :class="[
                    'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2 text-center',
                    mode === 'individual'
                        ? 'border-slate-800 text-slate-800 bg-slate-100'
                        : 'border-transparent text-slate-500 hover:text-slate-700',
                ]"
            >
                Ejercicios individuales
            </button>

            <button
                @click="emit('update:mode', 'team')"
                :class="[
                    'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2 text-center',
                    mode === 'team'
                        ? 'border-slate-800 text-slate-800 bg-slate-100'
                        : 'border-transparent text-slate-500 hover:text-slate-700',
                ]"
            >
                Ejercicios de equipo
            </button>
        </div>
    </div>
    <div class="px-4 py-4 flex items-center justify-center gap-2 bg-white">
        <span class="text-sm font-medium text-gray-700">Filtrar por:</span>
        <ExerciseFilter
            :mode="mode"
            :available-types="availableTypes"
            @filter-change="handleFilterChange"
        />
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>
