<script setup>
// Tu lógica aquí
</script>

<template>
    <div class="flex flex-row bg-white justify-center items-center h-screen py-16">
        <div class="flex flex-col pr-10 max-w-100 lg:mr-57">
            <h1 class="text-3xl font-bold leading-tight lg:text-4xl mb-5">Diseña los entrenamientos a tu gusto</h1>
            <p class="text-gray-700 max-w-lg mx-auto lg:mx-0">Accede a cientos de ejercicios de todo tipo y crea el entrenamiento que necesitas</p>

            <!-- Primera tarjeta -->
            <div class="card w-100 lg:w-130 bg-base-100 card-lg shadow-sm my-10 transition-transform duration-300 hover:-translate-y-2">
                <div class="card-body">
                    <h2 class="card-title">Large Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>

        <!-- Segunda tarjeta -->
            <div class="card card-delay-2 w-100 lg:w-130 bg-base-100 card-lg shadow-sm transition-transform duration-300 hover:-translate-y-2">
                <div class="card-body">
                    <h2 class="card-title">Large Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>
        </div>
        <img src="/images/background/team practice.jpg" class="max-h-150 rounded-3xl hidden lg:block" />
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>