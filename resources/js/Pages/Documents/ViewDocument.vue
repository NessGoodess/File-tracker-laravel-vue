<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ShowDocument from './Partials/ShowDocument.vue';
import CommentsList from './Partials/CommentsList.vue';
import { Head } from '@inertiajs/vue3';


</script>

<template>

    <Head title="Ver" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Perfil
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <ShowDocument class="max-w-xl" />
                </div>
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <CommentsList class="max-w-6xl" />
                </div>
                <!--
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <button @click="showComments = !showComments" class="text-black hover:text-blue-500">
                        {{ showComments ? 'Comentarios ▲' : 'Comentarios ▼' }}
                    </button>
                    <Comments v-if="showComments" class="max-w-6xl" />
                </div>
                -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
