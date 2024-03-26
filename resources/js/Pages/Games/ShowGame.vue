<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import FormatDate from "@/Components/FormatDate.vue";
import Divider from "primevue/divider";

import Button from "primevue/button";

const props = defineProps({
    session: {
        type: Object,
        required: true
    },
    tokenList: {
        type: Object,
        required: false
    },
    costs: {
        type: Number,
        required: true
    }

})

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Game Session {{ session.id }} -
                {{ session.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>{{ session.name }}</h1>
                        <div class="flex flex-row">
                            <div class="w-1/3">
                                <h2>Details</h2>
                                <p>Name: {{ session.name }}</p>
                                <p>Key: {{ session.key }}</p>
                                <p>Starts on:
                                    <FormatDate :timestamp="session.start_date"/>
                                </p>
                                <p>Ends on:
                                    <FormatDate :timestamp="session.end_date"/>
                                </p>
                                <Button label="Edit" class="p-button-primary mt-4"/>
                                <Divider/>
                                <br>
                                <h1>Total costs: $ {{ costs }} USD</h1>
                            </div>
                            <div class="w-2/3">
                                <h2>Session tokens ({{ tokenList.length }})</h2>
                                <DataTable :value="tokenList" paginator :rows="5" class="w-full">
                                    <Column field="token" header="Token"/>
                                    <Column field="created_at" header="Created at">
                                        <template #body="slotProps">
                                            <FormatDate :timestamp="slotProps.data.created_at"/>
                                        </template>
                                    </Column>
                                    <Column header="Actions">
                                        <template #body="slotProps">
                                            <Button label="Revoke" class="p-button-danger"/>
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>
                        </div>
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
    margin-top: 0.5rem;
}

h2 {
    font-size: 1.15rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    margin-top: 0.5rem;
}
</style>
