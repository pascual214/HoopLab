<script setup>
import BallIcon from '../BallIcon.vue';

// Tu lógica aquí
</script>

<template>
    <footer class="flex flex-col items-center justify-around w-full py-16 text-sm bg-white text-gray-800/70">
        <div class="flex flex-row items-center gap-2">
            <BallIcon />
            <p class="icon">HoopLab</p>
        </div>
        <p class="mt-4 text-center">Copyright © 2026 <a href="#">HoopLab</a>. Todos los derechos reservados.</p>
        <div class="flex items-center gap-4 mt-6">
            <a href="#" class="font-medium text-gray-800 hover:text-black transition-all">
                Enlace 1
            </a>
            <div class="h-4 w-px bg-black/20"></div>
            <a href="#" class="font-medium text-gray-800 hover:text-black transition-all">
                Enlace 2
            </a>
        </div>
    </footer>
</template>

<style scoped>
.icon {
    font-size: large;
    font-weight: 700;
    color: black;
}
</style>