<script setup>
defineProps({
    currentPage: {
        type: Number,
        required: true,
    },
    totalPages: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["prev", "next"]);
</script>

<template>
    <div
        v-if="totalPages > 1"
        class="flex items-center justify-center gap-2 mt-4"
    >
        <button
            @click="emit('prev')"
            :disabled="currentPage === 1"
            class="btn btn-primary btn-sm disabled:opacity-30 disabled:cursor-not-allowed"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </button>
        <span class="text-sm text-gray-500"
            >{{ currentPage }} / {{ totalPages }}</span
        >
        <button
            @click="emit('next')"
            :disabled="currentPage === totalPages"
            class="btn btn-primary btn-sm disabled:opacity-30 disabled:cursor-not-allowed"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>
    </div>
</template>
