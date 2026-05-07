<script setup>
const goBack = () => {
    window.history.back();
};
</script>

<template>
    <!-- Botón volver -->
    <div class="px-12 pt-6">
        <button @click="goBack" class="btn btn-soft btn-primary btn-md">
            ← Volver
        </button>
    </div>
    <div class="text-center pb-4">
        <h2 class="text-base font-bold text-slate-700 tracking-wide uppercase">
            Crear nuevo ejercicio
        </h2>
        <div class="mt-1.5 h-0.5 w-10 rounded-full bg-blue-500 mx-auto"></div>
        <p class="mt-2 text-sm text-gray-500">
            Rellena el formulario para añadir un nuevo ejercicio a la
            biblioteca.
        </p>
    </div>
</template>
