<script setup>
import FullLayout from '@/Layouts/FullLayout.vue';
import Hero from '@/Components/Landing/Hero.vue';
import BoardInfo from '@/Components/Landing/BoardInfo.vue';
import TrainingInfo from '@/Components/Landing/TrainingInfo.vue';
import CallToAction from '@/Components/Landing/CallToAction.vue';
import Lenis from 'lenis';

const lenis = new Lenis ({
    duration: 1.4,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // curva de animación
    smooth: true,
})

function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
}

requestAnimationFrame(raf)


// Tu lógica aquí
</script>

<template>
    <FullLayout>
        <Hero />

        <BoardInfo />

        <TrainingInfo />

        <CallToAction />
    </FullLayout>
</template>

<style scoped>
/* Estilos locales */
html{
    scroll-behavior: smooth;
}
</style>