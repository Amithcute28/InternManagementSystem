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
        ? 'relative px-3 py-2.5 mx-4 flex items-center space-x-4 rounded-xl text-white bg-gold hover:bg-yellow-400 transition duration-200 ease-in-out'
        : 'px-3 py-2.5 mx-4 flex items-center space-x-4 rounded-xl text-white text-sm group hover:bg-gold/60 hover:text-gray-800 transition duration-300 ease-in '
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
