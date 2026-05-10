<script setup>
import { ref } from "vue";

const emit = defineEmits(["add-player"]);

const addPlayer = (team) => {
    emit("add-player", team);
};
</script>

<template>
    <div class="flex items-center justify-center gap-4 p-4 bg-white">
        <span class="text-sm font-medium text-gray-500 mr-2">Añadir jugador:</span>

        <button
            @click="addPlayer('local')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition-colors"
        >
            <span class="w-7 h-7 rounded-full bg-white text-blue-500 font-bold flex items-center justify-center text-xs">
                L
            </span>
            Equipo local
        </button>

        <button
            @click="addPlayer('visitante')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors"
        >
            <span class="w-7 h-7 rounded-full bg-white text-red-500 font-bold flex items-center justify-center text-xs">
                V
            </span>
            Equipo visitante
        </button>
    </div>
</template>