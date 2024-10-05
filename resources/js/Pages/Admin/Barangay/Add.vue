<script setup>
import { ref, toRefs, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    scmembers: Object,
});

</script>

<template>
    <Head title="Add Barangay" />
    <AuthenticatedLayout headerTitle="Add New Barangay">

    </AuthenticatedLayout>
</template>
