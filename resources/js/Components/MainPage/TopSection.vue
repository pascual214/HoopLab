<script setup>
// Tu lógica aquí

const props = defineProps({
    mode: String,
});

const emit = defineEmits(["update:mode"]);
</script>

<template>
    <div class="bg-blue-200">
        <h2 class="text-center">Diseña tu entrenamiento</h2>
    </div>

    <div class="border-b border-slate-200 bg-white sticky top-0 z-20">
    <div class="max-full mx-auto flex w-full">
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
</template>

<style scoped>
/* Estilos locales */
</style>
