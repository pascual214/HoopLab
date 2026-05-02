<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    user: Object,
});

const editing = ref(null);

const profileForm = useForm({
    name: props.user.name,
    email: props.user.email,
});

const passwordForm = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

function saveProfile() {
    profileForm.patch(route("profile.update"), {
        onSuccess: () => (editing.value = null),
    });
}

function savePassword() {
    passwordForm.put(route("password.update"), {
        onSuccess: () => {
            editing.value = null;
            passwordForm.reset();
        },
    });
}

function cancelEdit() {
    editing.value = null;
    profileForm.name = props.user.name;
    profileForm.email = props.user.email;
    passwordForm.reset();
}
</script>

<template>
    <div class="w-full bg-white/40 rounded-2xl px-6 py-5 backdrop-blur-sm border border-white/60 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 mb-4 text-center">
            Detalles de la cuenta:
        </h3>

        <!-- Nombre -->
        <div class="border-b border-white/60 py-3">
            <div v-if="editing !== 'name'" class="flex items-center justify-between">
                <span class="text-sm text-slate-700">
                    <span class="font-bold">Nombre:</span> {{ user.name }}
                </span>
                <button @click="editing = 'name'" class="text-blue-600 text-sm font-medium hover:underline cursor-pointer">
                    Editar
                </button>
            </div>
            <div v-else class="flex flex-col gap-2">
                <input v-model="profileForm.name" type="text"
                    class="input input-bordered input-sm w-full bg-white" />
                <p v-if="profileForm.errors.name" class="text-red-500 text-xs">
                    {{ profileForm.errors.name }}
                </p>
                <div class="flex gap-2 justify-end">
                    <button @click="cancelEdit" class="btn btn-ghost btn-xs">Cancelar</button>
                    <button @click="saveProfile" :disabled="profileForm.processing" class="btn btn-primary btn-xs">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="border-b border-white/60 py-3">
            <div v-if="editing !== 'email'" class="flex items-center justify-between">
                <span class="text-sm text-slate-700">
                    <span class="font-bold">Correo:</span> {{ user.email }}
                </span>
                <button @click="editing = 'email'" class="text-blue-600 text-sm font-medium hover:underline cursor-pointer">
                    Editar
                </button>
            </div>
            <div v-else class="flex flex-col gap-2">
                <input v-model="profileForm.email" type="email"
                    class="input input-bordered input-sm w-full bg-white" />
                <p v-if="profileForm.errors.email" class="text-red-500 text-xs">
                    {{ profileForm.errors.email }}
                </p>
                <div class="flex gap-2 justify-end">
                    <button @click="cancelEdit" class="btn btn-ghost btn-xs">Cancelar</button>
                    <button @click="saveProfile" :disabled="profileForm.processing" class="btn btn-primary btn-xs">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- Contraseña -->
        <div class="py-3">
            <div v-if="editing !== 'password'" class="flex items-center justify-between">
                <span class="text-sm text-slate-700">
                    <span class="font-bold">Contraseña:</span> ••••••••••
                </span>
                <button @click="editing = 'password'" class="text-blue-600 text-sm font-medium hover:underline cursor-pointer">
                    Editar
                </button>
            </div>
            <div v-else class="flex flex-col gap-2">
                <input v-model="passwordForm.current_password" type="password"
                    placeholder="Contraseña actual" class="input input-bordered input-sm w-full bg-white" />
                <input v-model="passwordForm.password" type="password"
                    placeholder="Nueva contraseña" class="input input-bordered input-sm w-full bg-white" />
                <input v-model="passwordForm.password_confirmation" type="password"
                    placeholder="Confirmar nueva contraseña" class="input input-bordered input-sm w-full bg-white" />
                <p v-if="passwordForm.errors.current_password" class="text-red-500 text-xs">
                    {{ passwordForm.errors.current_password }}
                </p>
                <p v-if="passwordForm.errors.password" class="text-red-500 text-xs">
                    {{ passwordForm.errors.password }}
                </p>
                <div class="flex gap-2 justify-end">
                    <button @click="cancelEdit" class="btn btn-ghost btn-xs">Cancelar</button>
                    <button @click="savePassword" :disabled="passwordForm.processing" class="btn btn-primary btn-xs">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>