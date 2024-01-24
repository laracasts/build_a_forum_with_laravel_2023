<template>
    <Link
        :href="href"
        class="whitespace-nowrap mb-2 rounded-full border border-pink-500 px-2 py-0.5 text-pink-500 hover:bg-indigo-500 hover:text-indigo-50"
        :class="{ 'bg-indigo-500 !text-indigo-50': filled }"
    >
        <slot></slot>
    </Link>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        required: true,
    },
    filled: {
        default: false,
    },
});
</script>
