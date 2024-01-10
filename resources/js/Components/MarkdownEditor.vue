<template>
    <div v-if="editor" class="bg-white rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
        <menu class="flex divide-x border-b">
            <li>
                <button @click="() => editor.chain().focus().toggleBold().run()"
                        type="button"
                        class="px-3 py-2 rounded-tl-md "
                        :class="[editor.isActive('bold') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Bold">
                    <i class="ri-bold"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleItalic().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('italic') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Italic">
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleStrike().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('strike') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Strikethrough">
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBlockquote().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('blockquote') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Blockquote">
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBulletList().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('bulletList') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Bullet list">
                    <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleOrderedList().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('orderedList') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Numeric list">
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleOrderedList().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('orderedList') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Numeric list">
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button @click="promptUserForHref"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('link') ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Add link">
                    <i class="ri-link"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 2 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 2 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Heading 1">
                    <i class="ri-h-1"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 3 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 3 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Heading 2">
                    <i class="ri-h-2"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 4 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 4 }) ? 'bg-indigo-500 text-white' : 'hover:bg-gray-200']"
                        title="Heading 3">
                    <i class="ri-h-3"></i>
                </button>
            </li>
            <slot name="toolbar" :editor="editor" />
        </menu>
        <EditorContent :editor="editor" />
    </div>
</template>

<script setup>
import {EditorContent, useEditor} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";
import {Link} from "@tiptap/extension-link";
import {watch} from "vue";
import {Markdown} from "tiptap-markdown";
import 'remixicon/fonts/remixicon.css'
import {Placeholder} from "@tiptap/extension-placeholder";

const props = defineProps({
    modelValue: '',
    editorClass: '',
    placeholder: null,
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3, 4],
            },
            code: false,
            codeBlock: false,
        }),
        Link,
        Markdown,
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
    ],
    editorProps: {
        attributes: {
            class: `min-h-[512px] prose prose-sm max-w-none py-1.5 px-3 ${props.editorClass}`,
        },
    },
    onUpdate: () => emit('update:modelValue', editor.value?.storage.markdown.getMarkdown()),
});

defineExpose({focus: () => editor.value.commands.focus()});

watch(() => props.modelValue, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }

    editor.value?.commands.setContent(value);
}, { immediate: true });

const promptUserForHref = () => {
    if (editor.value?.isActive('link')) {
        return editor.value?.chain().unsetLink().run();
    }

    const href = prompt('Where do you want to link to?');

    if (! href) {
        return editor.value?.chain().focus().run();
    }

    return editor.value?.chain().focus().setLink({ href }).run();
};
</script>

<style scoped>
:deep(.tiptap p.is-editor-empty:first-child::before) {
    @apply text-gray-400 float-left h-0 pointer-events-none;
    content: attr(data-placeholder);
}
</style>
