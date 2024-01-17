<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";

defineProps({
    terms: String,
});
</script>

<template>
    <Head title="Terms of Service" />

    <div class="font-sans text-gray-900 antialiased">
        <div class="bg-gray-100 pt-4">
            <div class="flex min-h-screen flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div
                    class="prose mt-6 w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-2xl sm:rounded-lg"
                    v-html="terms"
                />
            </div>
        </div>
    </div>
</template>
