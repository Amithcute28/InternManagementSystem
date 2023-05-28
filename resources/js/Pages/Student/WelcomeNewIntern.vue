<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import {  Link } from '@inertiajs/vue3';
    
import { ref } from 'vue';



const props = defineProps({
  users: {
    type: Object,
    required: true,
  },
});

    </script>

<template>
    <h1>
        Welcome!
    </h1>

    <Link v-for="user in users" :key="user.id" :href="route('user.editNewIntern', user.id)" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">Edit Information</Link>
</template>