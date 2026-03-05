<script setup>
import Footer from '@/Components/Shared/Footer.vue';
import Header from '@/Components/Shared/Header.vue';

// Tu lógica aquí
</script>

<template>
    <Header class="top-0 left-0 w-full z-50" />

    <main class="h-300">
        <slot />
    </main>

    <Footer />
</template>

<style scoped>
/* Estilos locales */
</style>