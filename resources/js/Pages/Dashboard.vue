<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {onMounted} from "vue";

const bundledUserData = usePage().props.bundledUserData;

onMounted(() => {
    console.log(bundledUserData)
});

const sortAndMapUserEvents = () => {

};

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            LIST HERE
            </div>
        </div>
    </AuthenticatedLayout>
</template>
