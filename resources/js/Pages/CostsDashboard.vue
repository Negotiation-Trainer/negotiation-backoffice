<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

import ProgressBar from "primevue/progressbar";
import Divider from "primevue/divider";


const props = defineProps({
    costs: {
        type: Object,
        required: true,
    },
    /*
    'gpt3InputTokens' => $gpt3Input,
    'gpt3OutputTokens' => $gpt3Output,
    'gpt4InputTokens' => $gpt4Input,
    'gpt4OutputTokens' => $gpt4Output,
 */
});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Costs</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Budget status</h1>
                        <ProgressBar :value="costs.total" :display-value="`${costs.total} USD`" :show-value="false"
                                     :style="{height: '30px'}" class="mt-4"/>
                        <h2>Spent: $ {{ costs.total }} USD / $ {{ costs.budget }} USD</h2>
                        <Divider class="mt-4"/>
                        <h1>Cost division</h1>
                        <div class="flex flex-row">
                            <div class="w-1/4">
                                <h2>GPT-3 Input Tokens</h2>
                                <h2>${{ costs.gpt3InputTokens }} USD</h2>
                            </div>
                            <div class="w-1/4">
                                <h2>GPT-3 Output Tokens</h2>
                                <h2>${{ costs.gpt3OutputTokens }} USD</h2>
                            </div>
                            <Divider layout="vertical"/>
                            <div class="w-1/4">
                                <h2>GPT-4 Input Tokens</h2>
                                <h2>${{ costs.gpt4InputTokens }} USD</h2>
                            </div>
                            <div class="w-1/4">
                                <h2>GPT-4 Output Tokens</h2>
                                <h2>${{ costs.gpt4OutputTokens }} USD</h2>
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
}

h2 {
    font-size: 1.15rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    margin-top: 0.5rem;
}
</style>
