<script>
export default {
    name: "ExerciseCard",

    props: {
        exercise: {
            type: Object,
            required: true,
        },
        isInTraining: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        dotColor(dot) {
            const { difficulty } = this.exercise;

            if (difficulty === "facil") {
                return dot === 1 ? "bg-green-500" : "bg-gray-300";
            }

            if (difficulty === "intermedio") {
                return dot === 1 || dot === 2 ? "bg-orange-400" : "bg-gray-300";
            }

            if (difficulty === "dificil") {
                return "bg-red-500";
            }

            return "bg-gray-300";
        },

        // Devuelve la clase de color completa para las líneas
        lineColor(line) {
            const { difficulty } = this.exercise;

            if (difficulty === "facil") {
                return "bg-gray-300";
            }

            if (difficulty === "intermedio") {
                return line === "line1" ? "bg-orange-400" : "bg-gray-300";
            }

            if (difficulty === "dificil") {
                return "bg-red-500";
            }

            return "bg-gray-300";
        },
    },
};
</script>

<template>
    <div
        :class="[
            'bg-white border border-gray-200 rounded-2xl p-5 max-w-full shadow-sm relative px-10',
            isInTraining ? 'pb-10' : 'pb-5'
        ]"
    >
        <h2 class="text-base font-bold text-gray-900 leading-snug mb-2">
            {{ exercise.title }}
        </h2>

        <p class="text-sm text-gray-500 leading-relaxed mb-4">
            {{ exercise.description }}
        </p>

        <div class="flex items-center justify-between">
            <!-- Tipo -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs text-gray-400 font-medium">Tipo:</span>
                <span class="text-xs text-gray-700 font-medium">
                    {{ exercise.type }}
                </span>
            </div>

            <!-- Dificultad -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs text-gray-400 font-medium"
                    >Dificultad:</span
                >
                <div class="flex items-center">
                    <span
                        class="w-3 h-3 rounded-full shrink-0 transition-colors duration-300"
                        :class="dotColor(1)"
                    >
                    </span>
                    <span
                        class="w-3.5 h-0.5 shrink-0 transition-colors duration-300"
                        :class="lineColor('line1')"
                    >
                    </span>
                    <span
                        class="w-3 h-3 rounded-full shrink-0 transition-colors duration-300"
                        :class="dotColor(2)"
                    >
                    </span>
                    <span
                        class="w-3.5 h-0.5 shrink-0 transition-colors duration-300"
                        :class="lineColor('line2')"
                    >
                    </span>
                    <span
                        class="w-3 h-3 rounded-full shrink-0 transition-colors duration-300"
                        :class="dotColor(3)"
                    >
                    </span>
                </div>
            </div>
            
        </div><button
                v-if="isInTraining"
                @click="$emit('remove', exercise.id_exercise)"
                class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600 cursor-pointer"
            >
                Borrar
            </button>
    </div>
</template>
