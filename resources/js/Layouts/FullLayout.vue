<script setup>
import Footer from "@/Components/Shared/Footer.vue";
import Header from "@/Components/Shared/Header.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import { ref, provide } from "vue";

const showModal = ref(false);
const activeTab = ref("login");

function openModal(tab = "login") {
    activeTab.value = tab;
    showModal.value = true;
}

provide("openModal", openModal);

// Tu lógica aquí
</script>

<template>
    <Header class="top-0 left-0 w-full z-50" />

    <main>
        <slot />
    </main>

    <Footer />

    <GuestLayout
        :isOpen="showModal"
        :activeTab="activeTab"
        @close="showModal = false"
        @switchTab="activeTab = $event"
    >
        <Login v-if="activeTab === 'login'" />
        <Register v-else />
    </GuestLayout>
</template>

<style scoped>
/* Estilos locales */
</style>
