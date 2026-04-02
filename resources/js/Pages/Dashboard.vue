<script setup>
import IndividualEx from "@/Components/MainPage/IndividualEx.vue";
import RightPanel from "@/Components/MainPage/RightPanel.vue";
import TeamEx from "@/Components/MainPage/TeamEx.vue";
import TopSection from "@/Components/MainPage/TopSection.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FullLayout from "@/Layouts/FullLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const mode = ref("individual");
</script>

<template>
    <Head title="Dashboard" />

    <FullLayout>
        <TopSection :mode="mode" @update:mode="mode = $event" />

        <div class="px-20 py-9">
            <div class="flex w-full flex-col lg:flex-row ">
                <div
                    class="card bg-base-300 rounded-box grid grow place-items-center lg:basis-4/7"
                >
                    <TeamEx v-if="mode === 'team'" />
                    <IndividualEx v-else />
                </div>
                <div class="divider lg:divider-horizontal"></div>
                <div
                    class="card bg-gray-200 rounded-box grid grow place-items-center lg:basis-3/7 min-h-[80vh] "
                >
                    <RightPanel />
                </div>
            </div>
        </div>
    </FullLayout>
</template>
