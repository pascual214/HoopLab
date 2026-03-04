<script setup>
// Tu lógica aquí
</script>

<template>
    <div class="navbar bg-white/30 backdrop-blur-md border-b border-white/20 shadow-lg px-10">
        <div class="flex-none">
            <a href="/" class="inline-block">
                <img src="/images/logo/HoopLab_recortada.png" alt="Logo HoopLab" class="h-15">
            </a>
        </div>

        <!-- Gracias a este div vacío el ancla de la imagen no ocupa toda la largura del div hasta los botones, solo la imágen  -->
        <div class="flex-1"></div>

        <div class="flex-none">
            <ul class="menu menu-horizontal p-0 gap-5">
                <li>
                    <button class="btn btn-primary">Iniciar sesión</button>
                </li>
                <li>
                    <button class="btn btn-primary">Registrarse</button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>