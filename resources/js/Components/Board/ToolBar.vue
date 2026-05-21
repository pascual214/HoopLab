<script setup>
const emit = defineEmits(["add-player", "undo"]);

const props = defineProps({
    canUndo: { type: Boolean, default: false },
});
</script>

<template>
    <div class="relative flex items-center justify-center gap-4 p-4 bg-white border-t border-slate-100">
        <span class="text-sm font-medium text-gray-500 mr-2">Añadir jugador:</span>

        <button
            @click="emit('add-player', 'local')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition-colors"
        >
            <span class="w-7 h-7 rounded-full bg-white text-blue-500 font-bold flex items-center justify-center text-xs">
                L
            </span>
            Equipo local
        </button>

        <button
            @click="emit('add-player', 'visitante')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors"
        >
            <span class="w-7 h-7 rounded-full bg-white text-red-500 font-bold flex items-center justify-center text-xs">
                V
            </span>
            Equipo visitante
        </button>

        <button
            @click="emit('undo')"
            :disabled="!canUndo"
            title="Deshacer última acción"
            class="absolute right-4 flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition-colors"
            :class="canUndo
                ? 'bg-slate-100 hover:bg-slate-200 text-slate-600'
                : 'bg-slate-50 text-slate-300 cursor-not-allowed'"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a5 5 0 0 1 0 10H9M3 10l4-4M3 10l4 4" />
            </svg>
            <span class="hidden sm:inline">Deshacer</span>
        </button>
    </div>
</template>