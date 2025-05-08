<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm, Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    users: Array,
});

const form = useForm({
    message: '',
});

const formatDate = (date) => {
    return dayjs(date).format('DD/MM/YYYY');
};
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="sm:rounded-lg sm:pt-2 sm:pb-2 sm:pl-8 sm:pr-8 flex justify-end">
                    <LinkButton :href="route('users.create')" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Agregar Usuario
                    </LinkButton>
                </div>

                <div class="overflow-x-auto sm:rounded-lg sm:pt-2 sm:pb-2 sm:pl-8 sm:pr-8 bg-white shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Correo Electrónico
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de Creación
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in users" :key="user.id" @click="editUser(user.id)" class="cursor-pointer hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ user.email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDate(user.created_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
