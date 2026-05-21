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
const emit = defineEmits(["add-player", "clear-board", "set-tool"]);

const props = defineProps({
    localCount: { type: Number, default: 0 },
    visitorCount: { type: Number, default: 0 },
    activeTool: { type: String, default: null },
});

const toggleTool = (tool) => {
    emit("set-tool", props.activeTool === tool ? null : tool);
};
</script>

<template>
    <div
        class="relative flex flex-wrap items-center justify-center gap-3 p-4 bg-white border-t border-slate-100"
    >
        <span class="text-sm font-medium text-gray-500">Añadir jugador:</span>

        <button
            @click="emit('add-player', 'local')"
            class="w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-600 border-2 border-blue-700 text-white font-bold text-sm transition-colors flex items-center justify-center"
        >
            {{ localCount + 1 }}
        </button>

        <button
            @click="emit('add-player', 'visitante')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors"
            class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 border-2 border-red-700 text-white font-bold text-sm transition-colors flex items-center justify-center"
        >
            {{ visitorCount + 1 }}
        </button>

        <div class="w-px h-6 bg-slate-200"></div>

        <span class="text-sm font-medium text-gray-500">Línea:</span>

        <!-- Línea normal -->
        <button
            @click="toggleTool('line-normal')"
            :class="[
                'w-9 h-8 rounded-lg border-2 transition-colors flex items-center justify-center',
                activeTool === 'line-normal'
                    ? 'bg-slate-700 border-slate-900 text-white'
                    : 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200',
            ]"
            title="Línea normal"
        >
            <svg width="20" height="14" viewBox="0 0 20 14">
                <line x1="2" y1="7" x2="18" y2="7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>

        <!-- Línea discontinua -->
        <button
            @click="toggleTool('line-dashed')"
            :class="[
                'w-9 h-8 rounded-lg border-2 transition-colors flex items-center justify-center',
                activeTool === 'line-dashed'
                    ? 'bg-slate-700 border-slate-900 text-white'
                    : 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200',
            ]"
            title="Línea discontinua"
        >
            <svg width="20" height="14" viewBox="0 0 20 14">
                <line x1="2" y1="7" x2="18" y2="7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="4 3"/>
            </svg>
        </button>

        <!-- Línea de bloqueo (con barra al final) -->
        <button
            @click="toggleTool('line-block')"
            :class="[
                'w-9 h-8 rounded-lg border-2 transition-colors flex items-center justify-center',
                activeTool === 'line-block'
                    ? 'bg-slate-700 border-slate-900 text-white'
                    : 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200',
            ]"
            title="Línea de bloqueo"
        >
            <svg width="20" height="14" viewBox="0 0 20 14">
                <line x1="2" y1="7" x2="15" y2="7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <line x1="15" y1="2" x2="15" y2="12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>

        <!-- Flecha -->
        <button
            @click="toggleTool('line-arrow')"
            :class="[
                'w-9 h-8 rounded-lg border-2 transition-colors flex items-center justify-center',
                activeTool === 'line-arrow'
                    ? 'bg-slate-700 border-slate-900 text-white'
                    : 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200',
            ]"
            title="Flecha"
        >
            <svg width="20" height="14" viewBox="0 0 20 14">
                <line x1="2" y1="7" x2="13" y2="7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <polyline points="10,3 17,7 10,11" stroke="currentColor" stroke-width="2" fill="none" stroke-linejoin="round" stroke-linecap="round"/>
            </svg>
        </button>

        <button
            @click="emit('clear-board')"
            title="Borrar todo"
            class="absolute right-4 flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 text-sm font-medium transition-colors group"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
            </svg>
            <span class="hidden sm:inline">Borrar todo</span>
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
