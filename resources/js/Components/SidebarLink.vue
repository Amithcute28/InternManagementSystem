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
        ? 'relative px-4 py-3 flex items-center space-x-4 rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition duration-200 ease-in-out'
        : 'px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group hover:bg-yellow-300 transition duration-300 ease-in '
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
