<script setup>
// Tu lógica aquí
import ExerciseCard from "../Training/ExerciseCard.vue";
import { ref } from "vue";
import draggable from "vuedraggable";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const exercises = ref([...page.props.teamExercises]); // ref local para sortable
</script>

<template>
    <div class="relative overflow-hidden p-6">

        <!-- Cabecera -->
        <div class="mb-5 text-center">
            <h3 class="text-base font-bold text-slate-700 tracking-wide uppercase">
                Ejercicios de equipo
            </h3>
            <div class="mx-auto mt-1.5 h-0.5 w-10 rounded-full bg-blue-500"></div>
        </div>

        <!-- Lista draggable -->
        <draggable
            :list="exercises"
            :group="{ name: 'exercises', pull: 'clone', put: false }"
            item-key="id_exercise"
            :sort="false"
            class="grid gap-3"
        >
            <template #item="{ element }">
                <div class="group cursor-grab active:cursor-grabbing transition-transform duration-150 hover:-translate-y-0.5">
                    <ExerciseCard :exercise="element" />
                </div>
            </template>
        </draggable>

        <!-- Decoración fondo -->
        <div class="pointer-events-none absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-100/50 blur-2xl"></div>
    </div>
</template>
<style scoped>
/* Estilos locales */
</style>
