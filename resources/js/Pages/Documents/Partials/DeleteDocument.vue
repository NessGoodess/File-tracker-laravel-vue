<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const { document } = usePage().props;

const confirmingDocumentDeletion = ref(false);

const form = useForm({
    password: '',
});

const confirmDocumentDeletion = () => {
    confirmingDocumentDeletion.value = true;
};

const deleteDocument = () => {
    form.delete(route('documents.destroy', document.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => form.reset(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDocumentDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <DangerButton @click="confirmDocumentDeletion">Borrar</DangerButton>

        <Modal :show="confirmingDocumentDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que deseas eliminar el Documento?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Una vez que se elimine no se podraa recuperar el registro del documento.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteDocument">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zm-6 8a8 8 0 100-16 8 8 0 000 16zm-1-4a1 1 0 112 0v2a1 1 0 11-2 0v-2zm0-8a1 1 0 112 0v4a1 1 0 11-2 0V4z" clip-rule="evenodd" />
                                </svg>
                        Borrar Registro
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
