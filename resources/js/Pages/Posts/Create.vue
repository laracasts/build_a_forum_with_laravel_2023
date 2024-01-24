<template>
    <AppLayout title="Create a Post">
        <Container>
            <PageHeading>Create a Post</PageHeading>

            <form @submit.prevent="createPost" class="mt-6">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput
                        id="title"
                        class="w-full"
                        v-model="form.title"
                        placeholder="Give it a great title…"
                    />
                    <InputError :message="form.errors.title" class="mt-1" />
                </div>

                <div class="mt-3">
                    <InputLabel for="topic_id">Select a Topic</InputLabel>
                    <select v-model="form.topic_id" id="topic_id" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option v-for="topic in topics" :key="topic.id" :value="topic.id">
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-1" />
                </div>

                <div class="mt-3">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <MarkdownEditor v-model="form.body">
                        <template #toolbar="{ editor }">
                            <li v-if="!isInProduction()">
                                <button
                                    @click="autofill"
                                    type="button"
                                    class="px-3 py-2"
                                    title="Autofill"
                                >
                                    <i class="ri-article-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
                    <InputError :message="form.errors.body" class="mt-1" />
                </div>

                <div class="mt-3">
                    <PrimaryButton type="submit">Create Post</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import { isInProduction } from "@/Utilities/environment.js";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(['topics']);

const form = useForm({
    title: "",
    topic_id: props.topics[0].id,
    body: "",
});

const createPost = () => form.post(route("posts.store"));

const autofill = async () => {
    if (isInProduction()) {
        return;
    }

    const response = await axios.get("/local/post-content");

    form.title = response.data.title;
    form.body = response.data.body;
};
</script>
