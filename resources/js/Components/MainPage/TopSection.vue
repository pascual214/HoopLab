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
    <!-- Hero informativo -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 px-6 pt-8 pb-6">
        <!-- Título y subtítulo -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 bg-white/10 text-white/80 text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded-full mb-3">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                HoopLab
            </div>
            <h1 class="text-2xl font-bold text-white leading-tight">
                Diseña tu entrenamiento
            </h1>
            <p class="text-slate-400 text-sm mt-1">
                Crea, organiza y comparte ejercicios de baloncesto
            </p>
        </div>

        <!-- Tarjetas de características -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-white/8 rounded-2xl p-3 text-center border border-white/10">
                <div class="w-8 h-8 rounded-xl bg-blue-500/20 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <p class="text-white text-xs font-semibold leading-tight">Individual</p>
                <p class="text-slate-500 text-[10px] mt-0.5">Técnica y habilidad</p>
            </div>
            <div class="bg-white/8 rounded-2xl p-3 text-center border border-white/10">
                <div class="w-8 h-8 rounded-xl bg-green-500/20 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-white text-xs font-semibold leading-tight">Equipo</p>
                <p class="text-slate-500 text-[10px] mt-0.5">Táctica y sistema</p>
            </div>
            <div class="bg-white/8 rounded-2xl p-3 text-center border border-white/10">
                <div class="w-8 h-8 rounded-xl bg-orange-500/20 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                    </svg>
                </div>
                <p class="text-white text-xs font-semibold leading-tight">Pizarra</p>
                <p class="text-slate-500 text-[10px] mt-0.5">Diseña jugadas</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="flex justify-center">
            <Link
                :href="route('exercises.create')"
                class="inline-flex items-center gap-2 bg-white text-slate-900 text-sm font-bold px-5 py-2.5 rounded-xl shadow-md hover:bg-slate-100 active:scale-95 transition-all duration-150"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Crear ejercicio
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
