<script setup>
// Tu lógica aquí
</script>

<template>
    <div class="bg-gray-200 py-16 px-6 md:py-24 md:px-20 lg:px-40">
        <div class="flex flex-col md:flex-row items-center max-w-7xl mx-auto">
            <div class="flex flex-col gap-5 pt-3 md:pr-10 text-center md:text-left mb-10 md:mb-0">
                <h1 class="text-3xl md:text-5xl font-bold leading-tight">Crea tus jugadas con la pizarra</h1>
                <p class="text-gray-700 max-w-lg mx-auto md:mx-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cursus imperdiet sed id elementum. Quam vel aliquam sit vulputate.
                </p>
                <button class="btn btn-soft btn-primary w-40 self-center md:self-start">Empezar</button>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                <img 
                src="/images/background/Pizarra digital.png" 
                class="w-full max-w-md md:max-w-full h-auto object-contain" 
                />
            </div>
        </div>
        <div class="flex flex-row gap-10 pt-20 justify-center">
            <!-- Primera tarjeta -->
            <div class="card w-75 bg-base-100 card-md shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Medium Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>

            <!-- Segunda tarjeta -->
            <div class="card w-75 bg-base-100 card-md shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Medium Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>

            <!-- Tercera tarjeta -->
            <div class="card w-75 bg-base-100 card-md shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Medium Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Estilos locales */

</style>