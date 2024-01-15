<template>
    <AppLayout>
        <Container>
            <ul class="divide-y">
                <li v-for="post in posts.data" :key="post.id">
                    <Link
                        :href="post.routes.show"
                        class="group block px-2 py-4"
                    >
                        <span
                            class="text-lg font-bold group-hover:text-indigo-500"
                            >{{ post.title }}</span
                        >
                        <span
                            class="block pt-1 text-sm text-gray-600 first-letter:uppercase"
                            >{{ formattedDate(post) }} ago by
                            {{ post.user.name }}</span
                        >
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" :only="['posts']" class="mt-2" />
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import { formatDistance, parseISO } from "date-fns";
import { relativeDate } from "@/Utilities/date.js";

defineProps(["posts"]);

const formattedDate = (post) => relativeDate(post.created_at);
</script>
