<script setup>
import IndividualEx from "@/Components/MainPage/IndividualEx.vue";
import RightPanel from "@/Components/MainPage/RightPanel.vue";
import TeamEx from "@/Components/MainPage/TeamEx.vue";
import TopSection from "@/Components/MainPage/TopSection.vue";
import FullLayout from "@/Layouts/FullLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const mode = ref("individual");
const trainingExercises = ref([]);
const currentFilter = ref({ filterType: "", filterValue: "" });

const clearTrainingExercises = () => {
    trainingExercises.value = [];
};

const handleFilterChange = (filterData) => {
    currentFilter.value = filterData;
};

// Extraer tipos únicos según el modo
const availableTypes = computed(() => {
    const exercises = mode.value === "individual" 
        ? page.props.individualExercises 
        : page.props.teamExercises;
    
    const typesSet = new Set(exercises.map(ex => ex.type).filter(Boolean));
    return Array.from(typesSet).sort();
});

</script>

<template>
    <Head title="Dashboard" />

    <FullLayout>
        <TopSection 
            :mode="mode" 
            :available-types="availableTypes"
            @update:mode="mode = $event; currentFilter = { filterType: '', filterValue: '' }" 
            @filter-change="handleFilterChange" 
        />

        <div class="px-20 py-9">
            <div class="flex w-full flex-col lg:flex-row ">
                <div
                    class="card bg-base-300 rounded-box grid grow place-items-center lg:basis-4/7"
                >
                    <TeamEx v-if="mode === 'team'" :filter="currentFilter" />
                    <IndividualEx v-else :filter="currentFilter" />
                </div>
                <div class="divider lg:divider-horizontal"></div>
                <div
                    class="card bg-gray-200 rounded-box grid grow place-items-center lg:basis-3/7 min-h-[80vh] "
                >
                    <RightPanel
                        :trainingExercises="trainingExercises"
                        @saved="clearTrainingExercises"
                    />
                </div>
            </div>
        </div>
    </FullLayout>
</template>
