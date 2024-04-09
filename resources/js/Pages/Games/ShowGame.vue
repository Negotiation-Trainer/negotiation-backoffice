<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import FormatDate from "@/Components/FormatDate.vue";
import Divider from "primevue/divider";

import Button from "primevue/button";
import {ref} from "vue";
import InputText from "primevue/inputtext";
import {useToast} from "primevue/usetoast";

const toast = useToast();

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

const isEditing = ref(false);

const session = ref({...props.session});

const updatedSession = ref({...props.session});

const saveUpdatedSession = () => {
    console.log('Saving session');

    isEditing.value = false;

    axios.patch(route('game-session.update', props.session.id), updatedSession.value)
        .then(response => {
            session.value = {...response.data.data};
            updatedSession.value = {...response.data.data};

            toast.add({severity: 'success', summary: 'Success', detail: 'Session updated successfully.', life: 3000});
        })
        .catch(error => {
            console.error(error);
        });
}

const startEditing = () => {
    isEditing.value = true;
    updatedSession.value = {...props.session};
}

const cancelEditing = () => {
    isEditing.value = false;
    updatedSession.value = {...props.session};
}


const hasExpired = (token) => {
    return new Date(token.expires_at) < new Date();
}

const revokeToken = (tokenId) => {
    axios.delete(route('token.revoke', tokenId))
        .then(response => {
            toast.add({severity: 'success', summary: 'Success', detail: 'Token revoked successfully.', life: 3000});
        })
        .catch(error => {
            console.error(error);
            toast.add({severity: 'error', summary: 'Error', detail: 'Failed to revoke token.', life: 3000});
        });
}

</script>

<template>
    <Head title="Dashboard"/>
    <Toast/>

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
                            <div class="w-1/3 mr-4">
                                <div v-if="!isEditing">
                                    <h2>Details</h2>
                                    <p>Name: {{ session.name }}</p>
                                    <p>Key: {{ session.key }}</p>
                                    <p>Starts on:
                                        <FormatDate :timestamp="session.start_date"/>
                                    </p>
                                    <p>Ends on:
                                        <FormatDate :timestamp="session.end_date"/>
                                    </p>
                                    <Button label="Edit" @click="startEditing" class="p-button-primary mt-4"/>
                                </div>
                                <div v-else>
                                    <h2>Edit session</h2>
                                    <div class="flex flex-col gap-2">
                                        <label for="name">Game Session Name</label>
                                        <InputText id="name" required
                                                   v-model="updatedSession.name" aria-describedby="name-help"/>
                                        <small id="name-help">Enter a descriptive name for this game session.</small>
                                    </div>
                                    <br>
                                    <div class="flex flex-col gap-2">
                                        <label for="name">Game Session Name</label>
                                        <h1>{{ updatedSession.key }}</h1>
                                        <small class="text-red-600" id="name-help">Keys cannot be updated. Create a new
                                            session instead.</small>
                                    </div>
                                    <br>
                                    <div class="flex flex-col gap-2">
                                        <label for="start">Start time</label>
                                        <input type="datetime-local" id="start" v-model="updatedSession.start_date"
                                               aria-describedby="start-help"/>
                                        <small id="start-help">Enter the start time on which the game session may be
                                            used.</small>
                                    </div>
                                    <br>
                                    <div class="flex flex-col gap-2">
                                        <label for="desc">End Time</label>
                                        <input type="datetime-local" id="desc" v-model="updatedSession.end_date"
                                               aria-describedby="desc-help"/>
                                        <small id="desc-help">Enter the end time on which the game session
                                            expires.</small>
                                    </div>
                                    <Button label="Save" @click="saveUpdatedSession"
                                            class="p-button-primary mt-4 mr-4"/>
                                    <Button label="Cancel" @click="cancelEditing" class="p-button-secondary mt-4"/>
                                </div>
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
                                    <Column field="expires_at" header="Expires at">
                                        <template #body="slotProps">
                                            <FormatDate :timestamp="slotProps.data.expires_at"/>
                                        </template>
                                    </Column>
                                    <Column header="Actions">
                                        <template #body="slotProps">
                                            <Button v-if="!hasExpired(slotProps.data)"
                                                    @click="revokeToken(slotProps.data.id)" label="Revoke"
                                                    class="p-button-danger"/>
                                            <Button disabled v-else label="Expired" class="p-button-secondary"/>
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
