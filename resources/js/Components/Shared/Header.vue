<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue'

const headerVisible = ref(true)
let lastScroll = 0

function handleScroll() {
    const currentScroll = window.scrollY

    if (currentScroll < 100) {
        // Si está cerca de arriba del todo, siempre visible
        headerVisible.value = true
    } else if (currentScroll > lastScroll) {
        // Scrolleando hacia abajo, ocultar
        headerVisible.value = false
    } else {
        // Scrolleando hacia arriba, mostrar
        headerVisible.value = true
    }

    lastScroll = currentScroll
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))

// Tu lógica aquí
</script>

<template>
    <div class="navbar bg-white/30 backdrop-blur-md border-b border-white/20 shadow-lg px-10 fixed top-0 w-full z-50 transition-transform duration-400"
        :class="{ '-translate-y-full': !headerVisible }">        
        <div class="flex-none">
            <a href="/" class="inline-block">
                <img src="/images/logo/HoopLab_recortada.png" alt="Logo HoopLab" class="h-15">
            </a>
        </div>

        <div class="flex-none ml-15">
            <ul class="menu menu-horizontal gap-3">
                <li>
                    <button class="btn btn-ghost font-bold">Home</button>
                </li>
                <li>
                    <button class="btn btn-ghost">Pizzara</button>
                </li>
            </ul>

            <!-- Implementación de más botones si fuese necesario (contacto, sobre nosotros...) -->
        </div>

        <!-- Gracias a este div vacío el ancla de la imagen no ocupa toda la largura del div hasta los botones, solo la imágen  -->
        <div class="flex-1"></div>

        <div class="flex-none">
            <ul class="menu menu-horizontal p-0 gap-5">
                <li>
                    <Link href="register" class="p-0">
                        <button class="btn btn-primary" @click="">Registrarse</button>
                    </Link>
                </li>
                <li>
                    <Link href="login" class="p-0">
                        <button class="btn btn-primary">Iniciar sesión</button>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
/* Estilos locales */
.header {
    position: fixed;
    top: 0;
    width: 100%;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 50;
}

.header-hidden {
    transform: translateY(-100%);
}
</style>