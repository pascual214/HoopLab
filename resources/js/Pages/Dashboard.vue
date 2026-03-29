<script setup>
import RightPanel from '@/Components/MainPage/RightPanel.vue';
import TeamEx from '@/Components/MainPage/TeamEx.vue';
import TopSection from '@/Components/MainPage/TopSection.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FullLayout from '@/Layouts/FullLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <FullLayout>
        <TopSection />

    <div class="px-20 py-9">
        <div class="flex w-full flex-col lg:flex-row">
            <div class="card bg-base-300 rounded-box grid grow place-items-center lg:basis-4/7">
                <TeamEx />
            </div>
            <div class="divider lg:divider-horizontal"></div>
            <div class="card bg-base-300 rounded-box grid grow place-items-center lg:basis-3/7">
                <RightPanel />
            </div>
        </div>
    </div>
        
    </FullLayout>
</template>
