<script setup>
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

const showPassword = ref(false)
const showConfirm = ref(false)

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <p class="text-gray-400 text-sm mb-6">Crea tu cuenta y empieza a entrenar.</p>

    <form @submit.prevent="submit" class="flex flex-col gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700 mb-1 block">Nombre</label>
            <input
                v-model="form.name"
                type="text"
                placeholder="Tu nombre"
                class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            />
            <InputError class="mt-1" :message="form.errors.name" />
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 mb-1 block">Correo electrónico</label>
            <input
                v-model="form.email"
                type="email"
                placeholder="Enter your email"
                class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            />
            <InputError class="mt-1" :message="form.errors.email" />
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 mb-1 block">Contraseña</label>
            <div class="relative">
                <input
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Enter your Password"
                    class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 pr-12"
                />
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" @click="showPassword = !showPassword">
                    <span v-if="showPassword">👁️</span>
                    <span v-else>🙈</span>
                </button>
            </div>
            <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 mb-1 block">Confirmar contraseña</label>
            <div class="relative">
                <input
                    v-model="form.password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    placeholder="Confirm your Password"
                    class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 pr-12"
                />
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" @click="showConfirm = !showConfirm">
                    <span v-if="showConfirm">👁️</span>
                    <span v-else>🙈</span>
                </button>
            </div>
            <InputError class="mt-1" :message="form.errors.password_confirmation" />
        </div>

        <button
            type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-full transition-colors duration-300 mt-2"
            :disabled="form.processing"
            :class="{ 'opacity-50': form.processing }"
        >
            Registrarse
        </button>
    </form>
</template>