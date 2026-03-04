<script setup>
import Header from '@/Components/Shared/Header.vue';

// Tu lógica aquí
</script>

<template>
    <Header class="fixed top-0 left-0 w-full z-50"/>

    <main>
        <slot />
    </main>
</template>

<style scoped>
/* Estilos locales */
</style>