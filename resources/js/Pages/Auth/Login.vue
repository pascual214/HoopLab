<script setup>
import { ref } from 'vue'
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
})

const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">{{ status }}</div>

    <p class="text-gray-400 text-sm mb-6">Accede a tus entrenamientos, pizarras y mucho más.</p>

    <form @submit.prevent="submit" class="flex flex-col gap-5">
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
                <button
                    type="button"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    @click="showPassword = !showPassword"
                >
                    <span v-if="showPassword">👁️</span>
                    <span v-else>🙈</span>
                </button>
            </div>
            <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="text-sm text-gray-500">Recordarme</span>
            </label>
            <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-gray-400 hover:text-gray-600">
                Forgot Password ?
            </Link>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-full transition-colors duration-300 mt-2"
            :disabled="form.processing"
            :class="{ 'opacity-50': form.processing }"
        >
            Iniciar sesión
        </button>
    </form>
</template>