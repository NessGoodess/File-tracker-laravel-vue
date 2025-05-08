<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import CommentsForm from './CommentsForm.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

const { document, comments } = usePage().props;
const commentsAll = ref(organizeComments(comments));
const maxComments = 5;  // Mostrar un máximo de 5 comentarios inicialmente
const maxReplies = 3;   // Mostrar un máximo de 3 respuestas inicialmente
const showAllComments = ref(false);
const showAllReplies = ref({}); // Mantener el estado de si se muestran todas las respuestas por cada comentario

const form = useForm({
    document_id: document.id,
    comment: '',
    parent_id: null,
});

const updateComments = (updatedComments) => {
    commentsAll.value = organizeComments(updatedComments);
};

const submitComment = () => {
    if (!form.comment.trim()) {
        form.errors.comment = 'El comentario no puede estar vacío.';
        return;
    }
    form.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: (page) => {
            commentsAll.value = organizeComments(page.props.comments);
            form.reset();
        },
    });
};

const toggleShowReplies = (commentId) => {
    showAllReplies.value[commentId] = !showAllReplies.value[commentId];
};

function organizeComments(comments) {
    const map = {};
    const roots = [];

    comments.forEach(comment => {
        map[comment.id] = { ...comment, replies: [] };
    });

    comments.forEach(comment => {
        if (comment.parent_id) {
            if (map[comment.parent_id]) {
                map[comment.parent_id].replies.push(map[comment.id]);
            }
        } else {
            roots.push(map[comment.id]);
        }
    });

    return roots;
}

</script>

<template>
    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-2">Comentarios</h2>

        <div v-if="commentsAll.length > 0" class="mb-4 bg-gray-200 p-4 rounded-lg">
            <CommentsForm
                v-for="comment in commentsAll.slice(0, showAllComments ? commentsAll.length : maxComments)"
                :key="comment.id"
                :comment="comment"
                :comments="commentsAll"
                :document_id="document.id"
                @commentAdded="updateComments"
            />
            <button
                v-if="!showAllComments && commentsAll.length > maxComments"
                @click="showAllComments = true"
                class="text-blue-500 mt-2"
            >
                Ver más comentarios
            </button>
        </div>

        <div v-else class="mb-4 p-4 rounded-lg text-gray-500">No hay comentarios</div>

        <div class="flex flex-col items-center w-full">
            <form @submit.prevent="submitComment" class="flex items-center w-full">
                <div class="mb-4 w-full mr-4">
                    <TextArea
                        id="comment"
                        ref="commentTextArea"
                        v-model="form.comment"
                        placeholder="Agrega un comentario"
                        class="mt-1 block w-full"
                    ></TextArea>
                    <InputError :message="form.errors.comment" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Enviar</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
