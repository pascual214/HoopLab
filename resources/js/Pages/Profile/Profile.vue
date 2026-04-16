<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import FullLayout from "@/Layouts/FullLayout.vue";
import { ref, computed } from "vue";

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const page = usePage();
const user = computed(() => page.props.auth.user);

// Tabs
const activeTab = ref("ejercicios");
const tabs = ["Ejercicios", "Entrenamientos", "Jugadas"];

// Edición inline
const editing = ref(null); // 'name' | 'email' | 'password'

const profileForm = useForm({
    name: user.value.name,
    email: user.value.email,
    picture: null,
});

const passwordForm = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

function saveProfile(field) {
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
    profileForm.name = user.value.name;
    profileForm.email = user.value.email;
    passwordForm.reset();
}

const fileInput = ref(null);

function triggerFileInput() {
    fileInput.value.click();
}

function handleFileChange(e) {
    const file = e.target.files[0];
    if (file) {
        profileForm.picture = file;

        profileForm.post(route("profile.picture.update"), {
            forceFormData: true,
            onSuccess: () => {
                profileForm.reset("picture");
            },
        });
    }
}
</script>

<template>
    <Head title="Perfil" />

    <FullLayout>
        <!-- Sección superior: avatar + info + detalles -->
        <div class="bg-blue-100 px-6 py-10">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col items-center gap-3 min-w-45 my-10">
                    <div
                        @click="triggerFileInput"
                        class="relative group w-36 h-36 rounded-full bg-white/60 border-2 border-white shadow flex items-center justify-center cursor-pointer overflow-hidden"
                    >
                        <!-- Imagen/avatar -->
                        <img
                            v-if="user?.picture"
                            :src="`/storage/${user.picture}`"
                            class="w-full h-full object-cover"
                        />

                        <svg
                            v-else
                            class="w-20 h-20 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>

                        <!-- Overlay hover -->
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                        >
                            <!-- Icono cámara -->
                            <svg
                                class="w-10 h-10 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 7h4l2-2h6l2 2h4v12H3V7zm9 3a4 4 0 100 8 4 4 0 000-8z"
                                />
                            </svg>
                        </div>
                    </div>

                    <!-- input oculto -->
                    <input
                        type="file"
                        ref="fileInput"
                        class="hidden"
                        accept="image/*"
                        @change="handleFileChange"
                    />

                    <div class="text-center">
                        <h2 class="text-xl font-bold text-slate-800">
                            {{ user.name }}
                        </h2>
                        <p class="text-sm font-semibold text-slate-600">
                            Cuenta: {{ user.role ?? "entrenador" }}
                        </p>
                    </div>
                </div>

                <!-- Detalles de la cuenta -->
                <div
                    class="flex-1 bg-white/40 rounded-2xl px-6 py-5 backdrop-blur-sm border border-white/60 shadow-sm"
                >
                    <h3 class="text-lg font-bold text-slate-800 mb-4 text-center">
                        Detalles de la cuenta:
                    </h3>

                    <!-- Nombre -->
                    <div class="border-b border-white/60 py-3">
                        <div
                            v-if="editing !== 'name'"
                            class="flex items-center justify-between"
                        >
                            <span class="text-sm text-slate-700">
                                <span class="font-bold">Nombre:</span>
                                {{ user.name }}
                            </span>
                            <button
                                @click="editing = 'name'"
                                class="text-blue-600 text-sm font-medium hover:underline"
                            >
                                Editar
                            </button>
                        </div>
                        <div v-else class="flex flex-col gap-2">
                            <input
                                v-model="profileForm.name"
                                type="text"
                                class="input input-bordered input-sm w-full bg-white"
                            />
                            <p
                                v-if="profileForm.errors.name"
                                class="text-red-500 text-xs"
                            >
                                {{ profileForm.errors.name }}
                            </p>
                            <div class="flex gap-2 justify-end">
                                <button
                                    @click="cancelEdit"
                                    class="btn btn-ghost btn-xs"
                                >
                                    Cancelar
                                </button>
                                <button
                                    @click="saveProfile('name')"
                                    :disabled="profileForm.processing"
                                    class="btn btn-primary btn-xs"
                                >
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="border-b border-white/60 py-3">
                        <div
                            v-if="editing !== 'email'"
                            class="flex items-center justify-between"
                        >
                            <span class="text-sm text-slate-700">
                                <span class="font-bold">Correo:</span>
                                {{ user.email }}
                            </span>
                            <button
                                @click="editing = 'email'"
                                class="text-blue-600 text-sm font-medium hover:underline"
                            >
                                Editar
                            </button>
                        </div>
                        <div v-else class="flex flex-col gap-2">
                            <input
                                v-model="profileForm.email"
                                type="email"
                                class="input input-bordered input-sm w-full bg-white"
                            />
                            <p
                                v-if="profileForm.errors.email"
                                class="text-red-500 text-xs"
                            >
                                {{ profileForm.errors.email }}
                            </p>
                            <div class="flex gap-2 justify-end">
                                <button
                                    @click="cancelEdit"
                                    class="btn btn-ghost btn-xs"
                                >
                                    Cancelar
                                </button>
                                <button
                                    @click="saveProfile('email')"
                                    :disabled="profileForm.processing"
                                    class="btn btn-primary btn-xs"
                                >
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="py-3">
                        <div
                            v-if="editing !== 'password'"
                            class="flex items-center justify-between"
                        >
                            <span class="text-sm text-slate-700">
                                <span class="font-bold">Contraseña:</span>
                                ••••••••••
                            </span>
                            <button
                                @click="editing = 'password'"
                                class="text-blue-600 text-sm font-medium hover:underline"
                            >
                                Editar
                            </button>
                        </div>
                        <div v-else class="flex flex-col gap-2">
                            <input
                                v-model="passwordForm.current_password"
                                type="password"
                                placeholder="Contraseña actual"
                                class="input input-bordered input-sm w-full bg-white"
                            />
                            <input
                                v-model="passwordForm.password"
                                type="password"
                                placeholder="Nueva contraseña"
                                class="input input-bordered input-sm w-full bg-white"
                            />
                            <input
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                placeholder="Confirmar nueva contraseña"
                                class="input input-bordered input-sm w-full bg-white"
                            />
                            <p
                                v-if="passwordForm.errors.current_password"
                                class="text-red-500 text-xs"
                            >
                                {{ passwordForm.errors.current_password }}
                            </p>
                            <p
                                v-if="passwordForm.errors.password"
                                class="text-red-500 text-xs"
                            >
                                {{ passwordForm.errors.password }}
                            </p>
                            <div class="flex gap-2 justify-end">
                                <button
                                    @click="cancelEdit"
                                    class="btn btn-ghost btn-xs"
                                >
                                    Cancelar
                                </button>
                                <button
                                    @click="savePassword"
                                    :disabled="passwordForm.processing"
                                    class="btn btn-primary btn-xs"
                                >
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-slate-200 bg-white">
            <div class="max-full mx-auto flex">
                <button
                    v-for="tab in tabs"
                    :key="tab"
                    @click="activeTab = tab.toLowerCase()"
                    :class="[
                        'flex-1 py-4 text-sm font-bold tracking-wide transition-colors border-b-2',
                        activeTab === tab.toLowerCase()
                            ? 'border-slate-800 text-slate-800 bg-slate-100'
                            : 'border-transparent text-slate-500 hover:text-slate-700',
                    ]"
                >
                    {{ tab }}
                </button>
            </div>
        </div>

        <!-- Contenido tabs -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div
                v-if="activeTab === 'ejercicios'"
                class="text-center text-slate-400 py-16"
            >
                Próximamente — Ejercicios
            </div>
            <div
                v-if="activeTab === 'entrenamientos'"
                class="text-center text-slate-400 py-16"
            >
                Próximamente — Entrenamientos
            </div>
            <div
                v-if="activeTab === 'jugadas'"
                class="text-center text-slate-400 py-16"
            >
                Próximamente — Jugadas
            </div>
        </div>
    </FullLayout>
</template>
