<script setup>
// Tu lógica aquí

const props = defineProps({
    mode: String,
});

const emit = defineEmits(["update:mode"]);
</script>

<template>
    <!-- IMPORTANTE: el margen top para que el contenido empieze despues del header y debajo de él -->
    <div class="bg-blue-200 mt-20">
        <h2 class="text-center">Diseña tu entrenamiento</h2>
    </div>

    <div class="sticky top-20 z-20 bg-gray-100 border-b">
        <div class="flex w-full">
            <div
                class="w-1/2 text-center py-4 cursor-pointer transition"
                :class="
                    mode === 'individual' &&
                    'border-b-4 border-black font-semibold'
                "
                @click="emit('update:mode', 'individual')"
            >
                Ejercicios individuales
            </div>

            <div
                class="w-1/2 text-center py-4 cursor-pointer transition"
                :class="
                    mode === 'team' && 'border-b-4 border-black font-semibold'
                "
                @click="emit('update:mode', 'team')"
            >
                Ejercicios de equipo
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>
