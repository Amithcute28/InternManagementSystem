<template>
    <button
        class="items-center px-3 py-2 text-sm font-medium text-center text-white bg-indigo-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5"
    >
        <slot />
        <slot name="icon"></slot>
    </button>
</template>
