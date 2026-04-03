<script setup>
import { inject } from "vue";

const openModal = inject("openModal");
// Tu lógica aquí
</script>

<template>
    <div
        class="w-full py-16 lg:pl-20 max-lg:text-center mx-2 lg:mx-auto flex flex-col lg:flex-row items-center justify-center gap-x-100 text-left bg-linear-to-b from-blue-700 to-[#000000] p-10 text-white"
    >
        <div>
            <h1
                class="text-4xl lg:text-[48px] lg:leading-15 font-semibold bg-linear-to-r from-white to-[#0004ff] text-transparent bg-clip-text"
            >
                Aquí empieza tu mejor versión.
            </h1>
            <p
                class="bg-linear-to-r from-white to-[#CAABFF] text-transparent bg-clip-text text-lg"
            >
                Lleva tus entrenamientos al siguiente nivel.
            </p>
        </div>
        <button
            type="button"
            class="text-white bg-linear-to-br from-purple-400 to-blue-800 hover:bg-linear-to-bl focus:ring-1 focus:outline-none focus:ring-white dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 shrink-0"
            @click="openModal('register')"
        >
            Crear cuenta
        </button>
    </div>
</template>

<style scoped>
/* Estilos locales */
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
    font-family: "Poppins", sans-serif;
}
</style>
