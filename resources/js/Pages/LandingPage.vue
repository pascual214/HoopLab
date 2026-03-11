<script setup>
import FullLayout from '@/Layouts/FullLayout.vue';
import Hero from '@/Components/Landing/Hero.vue';
import BoardInfo from '@/Components/Landing/BoardInfo.vue';
import TrainingInfo from '@/Components/Landing/TrainingInfo.vue';
import CallToAction from '@/Components/Landing/CallToAction.vue';
import Lenis from 'lenis';
import { onMounted, ref } from 'vue'

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

const layoutRef = ref(null)

onMounted(() => {
    const cards = layoutRef.value.querySelectorAll('.card')
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate')
            }
        })
    }, { threshold: 0.2 })

    cards.forEach(card => observer.observe(card))
})

// Tu lógica aquí
</script>

<template>
    <FullLayout>
        <div ref="layoutRef">
            <Hero />

            <BoardInfo />

            <TrainingInfo />

            <CallToAction />
        </div>
    </FullLayout>
</template>

<style scoped>
/* Estilos locales */
html{
    scroll-behavior: smooth;
}

:deep(.card) {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 3s cubic-bezier(0.16, 1, 0.3, 1), transform 3s cubic-bezier(0.16, 1, 0.3, 1);
}

:deep(.card.animate) {
    opacity: 1;
    transform: translateY(0);
}

:deep(.card-delay-1.animate) { transition-delay: 0s; }
:deep(.card-delay-2.animate) { transition-delay: 0.6s; }
:deep(.card-delay-3.animate) { transition-delay: 1.2s; }
</style>