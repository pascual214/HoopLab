<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    trainings: {
        type: Array,
        default: () => [],
    },
});

const formatDuration = (minutes) => {
    if (!minutes) return "Sin duración";
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    if (hours > 0) {
        return `${hours}h ${mins}m`;
    }
    return `${mins} minutos`;
};
</script>

<template>
    <div class="space-y-4">
        <div v-if="trainings.length === 0" class="text-center py-16">
            <div class="text-slate-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-600 mb-2">No tienes entrenamientos creados</h3>
            <p class="text-slate-400">¡Crea tu primer entrenamiento desde el dashboard!</p>
        </div>

        <div v-else class="grid gap-4">

            <Link
                v-for="training in trainings"
                :key="training.id_training"
                :href="route('trainings.show', training.id_training)"
                class="block bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200 text-left"
            >
                <h3 class="text-base font-bold text-gray-900 leading-snug mb-2">
                    {{ training.name }}
                </h3>

                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                    {{ training.description || "Sin descripción" }}
                </p>

                <div class="flex items-center gap-1.5 justify-end">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs text-gray-400 font-medium">Duración:</span>
                    <span class="text-xs text-gray-700 font-medium">{{ formatDuration(training.duration) }}</span>
                </div>
            </Link>
        </div>
    </div>
</template>