<script setup>
import { ref } from 'vue'

defineProps({
    isOpen: Boolean,
    activeTab: {
        type: String,
        default: 'login'
    }
})
defineEmits(['close', 'switchTab'])

const showPassword = ref(false)
</script>

<template>
    <Teleport to="body">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Fondo -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="$emit('close')"></div>

            <!-- Modal -->
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[95vh] flex overflow-hidden">

                <!-- Columna izquierda: imagen -->
                <div class="hidden md:block w-2/5 relative rounded-3xl overflow-hidden m-3">
                    <img
                        src="/images/background/pelota en el suelo.jpg"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-linear-to-t from-black/70 to-transparent rounded-3xl"></div>
                    <div class="absolute bottom-8 left-6 text-white">
                        <h2 class="text-3xl font-bold leading-tight">Sube tu nivel,<br>transforma tu juego</h2>
                        <p class="text-white/70 mt-2 text-sm">Entrena, mejora y comparte tus sesiones.</p>
                    </div>
                </div>

                <!-- Columna derecha: formulario -->
                <div class="flex-1 flex flex-col justify-center px-10 py-8 overflow-y-auto">

                    <!-- Logo -->
                    <div class="flex justify-center mb-6">
                        <img src="/images/logo/HoopLab_recortada.png" class="h-12">
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Bienvenido a HoopLab</h2>

                    <!-- Tabs -->
                    <div class="flex bg-blue-50 rounded-full p-1 mb-6">
                        <button
                            class="flex-1 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                            :class="activeTab === 'login' ? 'bg-blue-500 text-white shadow' : 'text-blue-400'"
                            @click="$emit('switchTab', 'login')"
                        >
                            Iniciar Sesión
                        </button>
                        <button
                            class="flex-1 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                            :class="activeTab === 'register' ? 'bg-blue-500 text-white shadow' : 'text-blue-400'"
                            @click="$emit('switchTab', 'register')"
                        >
                            Registrarse
                        </button>
                    </div>

                    <!-- Contenido del formulario -->
                    <div class="form-wrapper" :class="activeTab">
                        <slot />
                    </div>
                </div>

                <!-- Cerrar -->
                <button
                    class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 text-xl"
                    @click="$emit('close')"
                >✕</button>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.form-wrapper {
    animation: enterFromRight 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.form-wrapper.login {
    animation: enterFromLeft 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.form-wrapper.register {
    animation: enterFromRight 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes enterFromRight {
    from { transform: translateX(40px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes enterFromLeft {
    from { transform: translateX(-40px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>