<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Login from '@/Pages/Auth/Login.vue'
import Register from '@/Pages/Auth/Register.vue'

const headerVisible = ref(true)
let lastScroll = 0

function handleScroll() {
    const currentScroll = window.scrollY
    if (currentScroll < 150) {
        headerVisible.value = true
    } else {
        headerVisible.value = false
    }
    lastScroll = currentScroll
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))

const showModal = ref(false)
const activeTab = ref('login')

function openModal(tab) {
    activeTab.value = tab
    showModal.value = true
}

//Autenticación
const page = usePage();
const user = computed(() => !!page.props.auth.user);
</script>

<template>
    <div class="navbar bg-white/30 backdrop-blur-md border-b border-white/20 shadow-lg px-10 fixed top-0 w-full z-50 transition-transform duration-400"
        :class="{ '-translate-y-full': !headerVisible }">        
        <div class="flex-none">
            <a href="/" class="inline-block">
                <img src="/images/logo/HoopLab_recortada.png" alt="Logo HoopLab" class="h-15">
            </a>
        </div>

        <div class="flex-1"></div>

        <div v-if="user" class="flex gap-2">
            <Link href="logout" method="post" as="button" class="btn btn-soft btn-primary">
                Cerrar Sesión
            </Link>
            <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                <img
                    alt="Tailwind CSS Navbar component"
                    src="images/logo/usuario_logo.jpg" />
                </div>
            </div>
            <ul
                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                <a class="justify-between">
                    Profile
                    <span class="badge">New</span>
                </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
            </div>
        </div>

        <div v-else class="flex-none">
            <ul class="menu menu-horizontal p-0 gap-5">
                <li>
                    <button class="btn btn-primary" @click="openModal('register')">Registrarse</button>
                </li>
                <li>
                    <button class="btn btn-primary" @click="openModal('login')">Iniciar sesión</button>
                </li>
            </ul>
        </div>
    </div>

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
</style>