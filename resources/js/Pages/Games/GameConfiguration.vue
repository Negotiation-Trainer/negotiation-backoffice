<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import FormatDate from "@/Components/FormatDate.vue";
import Divider from "primevue/divider";
import Dropdown from "primevue/dropdown";

import Button from "primevue/button";
import {ref} from "vue";
import InputText from "primevue/inputtext";
import {useToast} from "primevue/usetoast";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import NavLink from "@/Components/NavLink.vue";

const toast = useToast();

const props = defineProps({
    game: Object,
});

const data = ref({
    tribe_b: {
        speakerStyle: '',
    },
    tribe_c: {
        speakerStyle: '',
    },
});

const setJsonData = () => {
    const {tribe_b, tribe_c} = JSON.parse(props.game.game_configuration) ?? {};

    if (tribe_b?.speakerStyle) data.value.tribe_b.speakerStyle = tribe_b.speakerStyle;
    if (tribe_c?.speakerStyle) data.value.tribe_c.speakerStyle = tribe_c.speakerStyle;
};

setJsonData();

const submitData = () => {

    axios.patch(route('game-session.config.update', props.game.id), {
        game_configuration: JSON.stringify(data.value),
    }).then((response) => {
        console.log('response', response.data);
        toast.add({severity: 'success', summary: 'Success', detail: 'Game Configuration Updated', life: 3000});
    }).catch(() => {
        toast.add({severity: 'error', summary: 'Error', detail: 'Failed to update game configuration', life: 3000});
    });
}

const speakerOptions = ref([
    'Happy',
    'Sad',
    'Angry',
    'Doubtful',
    'Lunatic',
    'Calm',
    'Excited',
    'Confused',
    'Bored',
    'Tired',
]);
</script>

<template>
    <Head title="Dashboard"/>
    <Toast/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center gap-5">
                <NavLink :href="route('game-session.show', game.id)" class="text-blue-500">
                    <i class="pi pi-arrow-left mr-5"/>
                    Back
                </NavLink>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configure AI - "{{ game.name }}"</h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2>Set Game Configuration</h2>
                        <p>Here, you can configure the AI settings for the session. All these settings will be applied
                            to players using the game code "{{ game.key }}".</p>
                        <br>
                        <div class="flex flex-row">
                            <div class="w-1/2">
                                <h1>Tribe B</h1>
                                <Divider/>
                                <label for="speakerStyle">Speaker Style</label><br>
                                <Dropdown id="speakerStyle" :options="speakerOptions" placeholder="Select a Speaker"
                                          class="w-full"
                                          v-model="data.tribe_b.speakerStyle"/>
                            </div>
                            <Divider layout="vertical"/>
                            <div class="w-1/2">
                                <h1>Tribe C</h1>
                                <Divider/>
                                <label for="speakerStyle">Speaker Style</label><br>
                                <Dropdown id="speakerStyle" :options="speakerOptions" placeholder="Select a Speaker"
                                          class="w-full"
                                          v-model="data.tribe_c.speakerStyle"/>
                            </div>
                        </div>
                        <br>
                        <Button label="Save configuration" @click="submitData"/>
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
