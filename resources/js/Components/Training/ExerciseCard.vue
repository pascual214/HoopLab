<script setup>
// Tu lógica aquí
const props = defineProps({
    exercise: Object
});

</script>

<template>
    <div class="card bg-white shadow p-4 rounded">
        <h3 class="font-bold">{{ exercise.title }}</h3>
        <p>{{ exercise.description }}</p>
        <p class="text-sm text-gray-500">
            {{ exercise.type }} - {{ exercise.difficulty }}
        </p>
    </div>
</template>
<style scoped>
/* Estilos locales */
</style>
