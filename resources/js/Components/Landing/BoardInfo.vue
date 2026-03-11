<script setup>
// Tu lógica aquí
</script>

<template>
    <div class="grid bg-gray-200 min-h-screen px-6 py-10 items-center justify-center lg:px-20 gap-12">
        <div class="flex flex-col items-center max-w-5xl mx-auto lg:flex-row">
            <div class="flex flex-col gap-5 pt-3 text-center mb-10 lg:text-left lg:mb-0 lg:pr-10">
                <h1 class="text-3xl font-bold leading-tight lg:text-4xl">Crea tus jugadas con la pizarra</h1>
                <p class="text-gray-700 max-w-lg mx-auto lg:mx-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cursus imperdiet sed id elementum. Quam vel aliquam sit vulputate.
                </p>
                <button class="btn btn-soft btn-primary w-40 self-center lg:self-start">Probar</button>
            </div>
            <div class="w-full lg:w-1/2 flex justify-center">
                <img 
                src="/images/background/Pizarra digital.png" 
                class="w-full max-w-lg lg:max-w-full h-auto object-contain" 
                />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-row lg:items-center lg:justify-center gap-15">
            <!-- Primera tarjeta -->
            <div class="card card-delay-1 w-75 bg-base-100 card-lg shadow-sm transition-transform duration-300 hover:-translate-y-2">
                <div class="card-body">
                    <h2 class="card-title">Medium Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>

            <!-- Segunda tarjeta -->
            <div class="card card-delay-2 w-75 bg-base-100 card-lg shadow-sm transition-transform duration-300 hover:-translate-y-2">
                <div class="card-body">
                    <h2 class="card-title">Medium Card</h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="justify-end card-actions">
                    </div>
                </div>
            </div>

            <!-- Tercera tarjeta -->
            <div class="card card-delay-3 w-75 bg-base-100 card-lg shadow-sm transition-transform duration-300 hover:-translate-y-2 sm:col-span-2 sm:justify-self-center lg:col-span-1">
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