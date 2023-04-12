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
        ? 'relative px-4 py-3 flex items-center space-x-4 rounded-xl text-white bg-gradient-to-r from-blue-900 to-blue-500 group-hover:bg-white-100 '
        : 'px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group hover:bg-gray-100 transition duration-300 ease-in '
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
