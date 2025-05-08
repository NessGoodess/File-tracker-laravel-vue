<script setup>
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import { timeElapsed } from '@/Utils/dateFormater';
import { ref } from 'vue';
import { usePage, router, useForm } from '@inertiajs/vue3';
function getImageUrl(path) {
    return `${window.location.origin}/${path}`;
}

const { document, comments } = usePage().props;
const commentsAll = ref(comments);

const form = useForm({
    document_id: document.id,
    comment: '',
    parent_id: null,
    processing: false,
    errors: {},
});


const showModal = ref(false);
const commentIdToDelete = ref(null);
const replyFormVisible = ref(false);
const activeReplyForm = ref(null);

const setParentId = (id) => {
    form.parent_id = id;
    activeReplyForm.value = id;
    replyFormVisible.value = true;
};

const submitComment = () => {
    if (!form.comment.trim()) {
        form.errors.comment = 'El comentario no puede estar vacío.';
        return;
    }
    form.post(route('comments.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            commentsAll.value = page.props.comments;
            form.reset();
            replyFormVisible.value = false;
            activeReplyForm.value = null;
        },
    });
};

const confirmCommentDeletion = (id)=> {
    showModal.value = true;
    commentIdToDelete.value = id;
}

const closeModal = () => {
    showModal.value = false;
    commentIdToDelete.value = null;
}

const deleteComment = () => {
    router.delete(route('comments.destroy',commentIdToDelete.value),{
        preserveScroll: true,
        onSuccess: (page) =>{
            commentsAll.value = page.props.comments;
            closeModal();
        }
    });
};

</script>

<template>
    <div class="bg-gray-100 p-4 rounded-lg shadow-md">

        <h2 class="text-xl font-bold mb-2">Comentarios</h2>
        <div v-if="commentsAll.length > 0" class="mb-4 bg-gray-200 p-4 rounded-lg">
            <div v-for="comment in commentsAll.filter(c => !c.parent_id)" :key="comment.id" class="bg-white p-3 rounded-lg shadow-sm mb-2">

                <div class="flex mb-2">
                    <img :src="getImageUrl('images/Logo.png')" alt="Foto de perfil" class="w-8 h-8 rounded-full mr-2">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ comment.user.name }}
                            <span class="text-sm font-medium text-gray-400">
                                {{ ' - ' }}{{ timeElapsed(comment.created_at) }}
                            </span></p>
                        <p class="text-gray-800 text-md">{{ comment.comment }} </p>
                        <button @click="setParentId(comment.id)" class="text-gray-500 text-sm hover:text-blue-500">
                            Responder
                        </button>
                        <button @click="confirmCommentDeletion(comment.id)" class="text-gray-500 text-sm hover:text-red-500 ml-2">
                            Eliminar
                        </button>
                    </div>
                </div>
                <div v-if="activeReplyForm === comment.id" class="flex flex-col items-center w-full">
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

                <div v-for="reply in commentsAll.filter(c => c.parent_id === comment.id)" :key="reply.id"
                    class="bg-blue-50 p-2 rounded-lg shadow-inner ml-10 mt-2">
                    <div class="flex mb-2">
                        <img :src="getImageUrl('images/Logo.png')" alt="Foto de perfil" class="w-6 h-6 rounded-full mr-2">
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                {{ reply.user.name }}
                                <span class="text-sm font-medium text-gray-400">
                                    {{ ' - ' }}{{ timeElapsed(reply.created_at) }}
                                </span></p>
                            <p class="text-gray-800 text-md">
                                {{ reply.comment }}
                            </p>
                            <button @click="confirmCommentDeletion(reply.id)" class="text-gray-500 text-sm  hover:text-red-500">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="mb-4  p-4 rounded-lg">
            <h2 class="px-6 py-4 text-sm text-gray-500">No hay comentarios</h2>
        </div>

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

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-transparent">
            <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="mb-4">¿Eliminar Comentario?</p>
            <div class="flex justify-end">
                <DangerButton @click="deleteComment" class="mr-2">Sí</DangerButton>
                <SecondaryButton @click="closeModal">No</SecondaryButton>
            </div>
            </div>
        </div>
    </div>
</template>
