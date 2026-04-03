<script setup>
import ExerciseCard from "../Training/ExerciseCard.vue";
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const exercises = computed(() => page.props.individualExercises);

// Tu lógica aquí
</script>

<template>
    <div class="bg-gray-100 p-4 rounded">
        <h3 class="text-lg font-semibold mb-2">Ejercicios individuales</h3>
        <div class="grid gap-4">
            <ExerciseCard
                v-for="exercise in exercises"
                :key="exercise.id_exercise"
                :exercise="exercise"
            />
        </div>
    </div>
</template>

<style scoped>
/* Estilos locales */
</style>
