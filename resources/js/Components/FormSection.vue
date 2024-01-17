<script setup>
import { computed, useSlots } from "vue";
import SectionTitle from "./SectionTitle.vue";

defineEmits(["submitted"]);

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5 md:col-span-2 md:mt-0">
            <form @submit.prevent="$emit('submitted')">
                <div
                    class="bg-white px-4 py-5 shadow sm:p-6"
                    :class="
                        hasActions
                            ? 'sm:rounded-tl-md sm:rounded-tr-md'
                            : 'sm:rounded-md'
                    "
                >
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form" />
                    </div>
                </div>

                <div
                    v-if="hasActions"
                    class="flex items-center justify-end bg-gray-50 px-4 py-3 text-right shadow sm:rounded-bl-md sm:rounded-br-md sm:px-6"
                >
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </div>
</template>
