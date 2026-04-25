<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import FullLayout from "@/Layouts/FullLayout.vue";
import { ref, computed } from "vue";
import AccountDetails from "@/Components/Profile/AccountDetails.vue";
import ProfileTabs from "@/Components/Profile/ProfileTabs.vue";

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
    trainings: { type: Array, default: () => [] },
});

const goBack = () => {
    window.history.back();
};

const page = usePage();
const user = computed(() => page.props.auth.user);

const fileInput = ref(null);

const pictureForm = useForm({ picture: null });

function triggerFileInput() {
    fileInput.value.click();
}

function handleFileChange(e) {
    const file = e.target.files[0];
    if (file) {
        pictureForm.picture = file;
        pictureForm.post(route("profile.picture.update"), {
            forceFormData: true,
            onSuccess: () => pictureForm.reset("picture"),
        });
    }
}
</script>

<template>
    <Head title="Perfil" />

    <FullLayout>
        <div class="bg-blue-100 px-12 pt-6">
            <button @click="goBack" class="btn btn-soft btn-primary btn-md">
                ← Volver
            </button>
        </div>

        <!-- Sección superior -->
        <div class="bg-blue-100 px-6 py-10">
            <div class="max-w-4xl mx-auto flex flex-col items-center gap-8">
                <!-- Avatar -->
                <div class="flex flex-col items-center gap-3">
                    <div
                        @click="triggerFileInput"
                        class="relative group w-36 h-36 rounded-full bg-white/60 border-2 border-white shadow flex items-center justify-center cursor-pointer overflow-hidden"
                    >
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
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                        >
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

                <!-- Detalles cuenta -->
                <AccountDetails :user="user" />
            </div>
        </div>

        <!-- Tabs sticky + contenido -->
        <ProfileTabs :trainings="trainings" />
    </FullLayout>
</template>
