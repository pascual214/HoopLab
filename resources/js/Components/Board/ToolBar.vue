<script setup>
const emit = defineEmits(["add-player", "clear-board"]);

const props = defineProps({
    localCount: { type: Number, default: 0 },
    visitorCount: { type: Number, default: 0 },
});

const addPlayer = (team) => {
    emit("add-player", team);
};
</script>

<template>
    <div
        class="relative flex items-center justify-center gap-4 p-4 bg-white border-t border-slate-100"
    >
        <span class="text-sm font-medium text-gray-500 mr-2"
            >Añadir jugador:</span
        >

        <button
            @click="emit('add-player', 'local')"
            class="w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-600 border-2 border-blue-700 text-white font-bold text-sm transition-colors flex items-center justify-center"
        >
            {{ localCount + 1 }}
        </button>

        <button
            @click="emit('add-player', 'visitante')"
            class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 border-2 border-red-700 text-white font-bold text-sm transition-colors flex items-center justify-center"
        >
            {{ visitorCount + 1 }}
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
    </div>
</template>
