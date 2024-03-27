<script setup>
import {ref} from "vue";
import axios from "axios";

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import FormatDate from "@/Components/FormatDate.vue";
import Divider from "primevue/divider";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Calendar from "primevue/calendar";

import Toast from "primevue/toast";
import {useToast} from "primevue/usetoast";

const toast = useToast();

const newGame = ref({});

const onCreateClick = () => {
    if (!validateGameData(newGame.value)) {
        return;
    }

    //save data
    axios.post(route('game-session.store'), newGame.value)
        .then(response => {
            toast.add({severity: 'success', summary: 'Success', detail: 'Game session created successfully.', life: 3000});
            newGame.value = {};

            let newGameId = response.data.id;
            //wait for 3 seconds before redirecting
            setTimeout(() => {
                window.location.href = route('game-session.show', newGameId);
            }, 3000);
        })
        .catch(error => {
            toast.add({severity: 'error', summary: 'Error', detail: 'An error occurred while creating the game session.', life: 3000});
        });
}

const validateGameData = (data) => {
    //check if all fields are filled
    if (!data.name || !data.key || !data.start_date || !data.end_date) {
        toast.add({severity: 'error', summary: 'Error', detail: 'Please fill in all fields.', life: 3000});
        return false;
    }

    //check if start time is before end time
    if (data.start_date > data.end_date) {
        toast.add({severity: 'error', summary: 'Error', detail: 'Start time must be before end time.', life: 3000});
        return false;
    }

    return true;
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create new Game Session</h2>
        </template>
        <Toast/>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Create</h1>
                        <p>Fill in the form below to create a new game session.</p>
                        <Divider/>
                        <div class="w-1/3">
                            <div class="flex flex-col gap-2">
                                <label for="name">Game Session Name</label>
                                <InputText id="name" required v-model="newGame.name" aria-describedby="name-help"/>
                                <small id="name-help">Enter a descriptive name for this game session.</small>
                            </div>
                            <br>
                            <div class="flex flex-col gap-2">
                                <label for="key">Game Key</label>
                                <InputText id="key" v-model="newGame.key" aria-describedby="key-help"/>
                                <small id="key-help">Enter the passphrase players can use to access this session</small>
                            </div>
                            <br>
                            <div class="flex flex-col gap-2">
                                <label for="start">Start time</label>
                                <input type="datetime-local" id="start" v-model="newGame.start_date"
                                       aria-describedby="start-help"/>
                                <small id="start-help">Enter the start time on which the game session may be
                                    used.</small>
                            </div>
                            <br>
                            <div class="flex flex-col gap-2">
                                <label for="desc">End Time</label>
                                <input type="datetime-local" id="desc" v-model="newGame.end_date"
                                       aria-describedby="desc-help"/>
                                <small id="desc-help">Enter the end time on which the game session expires.</small>
                            </div>
                            <br>
                            <Button label="Create" @click="onCreateClick"/>
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
