<script setup>
import { ref, defineEmits } from 'vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import IconUser from '@/Components/Icons/IconUser.vue';
import { timeElapsed } from '@/Utils/dateFormater';
import { useForm, router } from '@inertiajs/vue3';

const emit = defineEmits(['commentAdded']);

const props = defineProps({
    comment: Object,
    comments: Array,
    document_id: Number,
});

const activeReplyForm = ref(null);
const showAllReplies = ref({}); // Controlar qué comentarios tienen respuestas expandidas

const form = useForm({
    document_id: props.document_id,
    comment: '',
    parent_id: null,
});

const setParentId = (id) => {
    form.parent_id = id;
    activeReplyForm.value = id;
};

const submitComment = () => {
    if (!form.comment.trim()) {
        form.errors.comment = 'El comentario no puede estar vacío.';
        return;
    }
    form.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: (page) => {
            form.reset();
            activeReplyForm.value = null;
            emit('commentAdded', page.props.comments);
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};

const deleteComment = (id) => {
    router.delete(route('comments.destroy', id), {
        preserveScroll: true,
    });
};

// Función corregida: Alternar el estado de "Ver más respuestas"
const toggleShowReplies = (commentId) => {
    showAllReplies.value[commentId] = !showAllReplies.value[commentId];
};
</script>

<template>
    <div class="bg-white p-3 rounded-lg shadow-sm mb-2">
        <div class="flex mb-2">
            <IconUser class="w-8 h-8 rounded-full mr-2"/>
            <div>
                <p class="text-sm font-medium text-gray-700">
                    {{ comment.user.name }}
                    <span class="text-sm font-medium text-gray-400"> - {{ timeElapsed(comment.created_at) }}</span>
                </p>
                <p class="text-gray-800 text-md">{{ comment.comment }}</p>
                <button @click="setParentId(comment.id)" class="text-gray-500 text-sm hover:text-blue-500">
                    Responder
                </button>
                <button @click="deleteComment(comment.id)" class="text-gray-500 text-sm hover:text-red-500 ml-2">
                    Eliminar
                </button>
            </div>
        </div>

        <div v-if="activeReplyForm === comment.id" class="ml-10 mt-2">
            <form @submit.prevent="submitComment">
                <TextArea v-model="form.comment" placeholder="Responde aquí..." class="block w-full"></TextArea>
                <InputError :message="form.errors.comment" class="text-red-500 text-sm" />
                <PrimaryButton :disabled="form.processing">Enviar</PrimaryButton>
            </form>
        </div>

        <div v-if="comment.replies && comment.replies.length" class="ml-10 mt-2 border-l-2 border-gray-200 pl-2">
            <CommentsForm
                v-for="reply in comment.replies.slice(0, showAllReplies[comment.id] ? comment.replies.length : 3)"
                :key="reply.id"
                :comment="reply"
                :comments="comments"
                :document_id="document_id"
                @commentAdded="emit('commentAdded', $event)"
            />
            <button
                v-if="comment.replies.length > 3"
                @click="toggleShowReplies(comment.id)"
                class="text-blue-500 mt-2"
            >
                {{ showAllReplies[comment.id] ? "Ver menos respuestas" : "Ver más respuestas" }}
            </button>
        </div>
    </div>
</template>
