<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingCommentDeletion = ref(false);
const passwordInput = ref(null);
let commentIdToDelete = null;

const form = useForm({
    password: '',
});

const confirmCommentDeletion = (id) => {
    confirmingCommentDeletion.value = true;
    commentIdToDelete = id;

    nextTick(() => passwordInput.value.focus());
};

const deleteComment = () => {
    form.delete(route('comments.destroy', commentIdToDelete), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingCommentDeletion.value = false;
    commentIdToDelete = null;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Eliminar Comentario
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez que se elimine el comentario, no se podrá recuperar. Asegúrese de que desea eliminar este comentario.
            </p>
        </header>

        <DangerButton @click="confirmCommentDeletion(comment.id)">Eliminar Comentario</DangerButton>

        <Modal :show="confirmingCommentDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que deseas eliminar este comentario?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Una vez que se elimine el comentario, no se podrá recuperar. Ingrese su contraseña para confirmar que desea eliminar este comentario.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-3/4" placeholder="Contraseña" @keyup.enter="deleteComment" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteComment">
                        Eliminar Comentario
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
