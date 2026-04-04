<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import { inject } from "vue";

const isLanding = computed(() => page.url === "/");
const headerVisible = ref(true);
let lastScroll = 0;

function handleScroll() {
    if (!isLanding.value) {
        headerVisible.value = true;
        return;
    }

    const currentScroll = window.scrollY;
    if (currentScroll < 150) {
        headerVisible.value = true;
    } else {
        headerVisible.value = false;
    }
    lastScroll = currentScroll;
}

onMounted(() => window.addEventListener("scroll", handleScroll));
onUnmounted(() => window.removeEventListener("scroll", handleScroll));

const openModal = inject("openModal");

//Autenticación
const page = usePage();
const auth = computed(() => page.props.auth);
</script>

<template>
    <div
        class="navbar bg-white/30 backdrop-blur-md border-b border-white/20 shadow-lg px-10 fixed top-0 w-full z-50 transition-transform duration-400"
        :class="{ '-translate-y-full': !headerVisible }"
    >
        <div class="flex-none">
            <a href="/" class="inline-block">
                <img
                    src="/images/logo/HoopLab_recortada.png"
                    alt="Logo HoopLab"
                    class="h-15"
                />
            </a>
        </div>

        <div class="flex-1"></div>

        <div v-if="auth.user" class="flex items-center gap-3">
            <p class="text-sm text-gray-500 hidden md:block">
                Hola, <span class="font-semibold text-gray-800"> {{ auth.user.name }}</span>
            </p>

            <!-- Dropdown -->
            <div class="dropdown dropdown-end">
                <div
                    tabindex="0"
                    role="button"
                    class="btn btn-ghost btn-circle avatar w-12 h-12"
                >
                    <div class="w-auto rounded-full">
                        <img
                            alt="User logo"
                            src="images/logo/usuario_logo.jpg"
                        />
                    </div>
                </div>

                <ul
                    tabindex="0"
                    class="dropdown-content z-50 mt-3 w-52 origin-top-right rounded-2xl bg-white shadow-xl ring-1 ring-black/5 p-1.5 flex flex-col gap-0.5"
                >
                    <!-- Perfil -->
                    <li>
                        <a
                            href="#"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150 group"
                        >
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors cursor-pointer"
                            >
                                <svg
                                    class="w-3.5 h-3.5 text-gray-500 group-hover:text-blue-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                            Perfil
                        </a>
                    </li>

                    <li class="my-1 border-t border-gray-100"></li>

                    <!-- Cerrar sesión -->
                    <li>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 transition-colors duration-150 group  cursor-pointer"
                        >
                            <div
                                class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors"
                            >
                                <svg
                                    class="w-3.5 h-3.5 text-red-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                            </div>
                            Cerrar sesión
                        </Link>
                    </li>
                </ul>
            </div>
        </div>

        <div v-else class="flex-none">
            <ul class="menu menu-horizontal p-0 gap-5">
                <li>
                    <button
                        class="btn btn-primary"
                        @click="openModal('register')"
                    >
                        Registrarse
                    </button>
                </li>
                <li>
                    <button class="btn btn-primary" @click="openModal('login')">
                        Iniciar sesión
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
