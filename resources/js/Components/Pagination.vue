<template>
    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link :href="previousUrl"
                  :only="only"
               class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</Link>
            <Link :href="nextUrl"
                  :only="only"
               class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm bg-white" aria-label="Pagination">
                    <Link v-for="link in meta.links"
                          :only="only"
                          :href="link.url"
                          class="relative inline-flex items-center first-of-type:rounded-l-md last-of-type:rounded-r-md px-3 py-2"
                          :class="{
                           'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.active,
                           'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0': !link.active
                       }"
                          v-html="link.label"
                    >
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    meta: {
        type: Object,
        required: true
    },
    only: {
        type: Array,
        default: () => []
    }
});

const previousUrl = computed(() => props.meta.links[0].url);
const nextUrl = computed(() => [...props.meta.links].reverse()[0].url);
</script>
