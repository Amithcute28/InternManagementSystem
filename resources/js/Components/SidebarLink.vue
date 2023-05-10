<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'relative px-4 py-3 flex items-center space-x-4 rounded-xl text-white bg-indigo-500 hover:bg-indigo-400 transition duration-200 ease-in-out'
        : 'px-4 py-3 flex items-center space-x-4 rounded-xl text-gray-600 group hover:bg-indigo-100 transition duration-300 ease-in '
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
