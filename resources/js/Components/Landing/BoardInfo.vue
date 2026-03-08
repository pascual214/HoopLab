<script setup>
// Tu lógica aquí
</script>

<template>
    <div class="grid bg-gray-200 min-h-screen px-6 py-10 items-center justify-center md:px-20 gap-12">
        <div class="flex flex-col items-center max-w-5xl mx-auto md:flex-row">
            <div class="flex flex-col gap-5 pt-3 text-center mb-10 md:text-left md:mb-0 md:pr-10">
                <h1 class="text-3xl font-bold leading-tight md:text-4xl">Crea tus jugadas con la pizarra</h1>
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
        <div class="flex flex-col items-center justify-center gap-15 md:flex-row">
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