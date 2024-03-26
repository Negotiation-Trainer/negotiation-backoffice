<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import FormatDate from "@/Components/FormatDate.vue";

const props = defineProps({
    gameCodes: {
        type: Object,
        required: true
    }
})

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Game Session</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Session List</h1>
                        <DataTable :value="gameCodes" :paginator="true" :rows="10" :rowsPerPageOptions="[5,10,20]">
                            <Column field="id" header="ID" :sortable="true"></Column>
                            <Column field="name" header="Game Name"></Column>
                            <Column field="key" header="Game Key"></Column>
                            <Column field="start_date" header="Starts on" :sortable="true">
                                <template #body="slotProps">
                                    <FormatDate :timestamp="slotProps.data.start_date"/>
                                </template>
                            </Column>
                            <Column field="end_date" header="Ends on" :sortable="true">
                                <template #body="slotProps">
                                    <FormatDate :timestamp="slotProps.data.end_date"/>
                                </template>
                            </Column>
                            <Column header="Actions">
                                <template #body="slotProps">
                                    <a :href="`/game/${slotProps.data.id}`"
                                       class="text-indigo-600 hover:text-indigo-900">View</a>
                                </template>
                            </Column>
                                <template #empty>
                                    <div class="p-4 text-center">
                                        <p>No game sessions found</p>
                                    </div>
                                </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
h1 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

h2 {
    font-size: 1.15rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    margin-top: 0.5rem;
}
</style>
