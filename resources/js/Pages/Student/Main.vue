<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Student Profile" />

    <UserLayout>
        <div class="py-4">
            <h1> Student Profile,  {{ $page.props.auth.user.name }}</h1>
        </div>
    </UserLayout>
</template>
