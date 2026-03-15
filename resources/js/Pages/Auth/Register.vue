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
            <input
                v-model="form.name"
                type="text"
                placeholder="Nombre"
                class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            />
            <InputError class="mt-1" :message="form.errors.name" />
        </div>

        <div>
            <input
                v-model="form.email"
                type="email"
                placeholder="Correo electrónico"
                class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
            />
            <InputError class="mt-1" :message="form.errors.email" />
        </div>

        <div>
            <div class="relative">
                <input
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Contraseña"
                    class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 pr-12"
                />
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" @click="showPassword = !showPassword">
                    <span v-if="showPassword">
                        <img src="/images/logo/ojo.png" alt="" class="w-5">
                    </span>
                    <span v-else>
                        <img src="/images/logo/invisible.png" alt="" class="w-5">
                    </span>
                </button>
            </div>
            <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div>
            <div class="relative">
                <input
                    v-model="form.password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    placeholder="Repita su contraseña"
                    class="w-full border border-gray-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 pr-12"
                />
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" @click="showConfirm = !showConfirm">
                    <span v-if="showConfirm">
                        <img src="/images/logo/ojo.png" alt="" class="w-5">
                    </span>
                    <span v-else>
                        <img src="/images/logo/invisible.png" alt="" class="w-5">
                    </span>
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