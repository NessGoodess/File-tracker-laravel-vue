<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { formatDateTimeEs } from '@/Utils/dateFormater';
import { actionUser } from '@/Utils/ActivityUser';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { activities } = usePage().props;
const activitiesRef = ref(activities);

const refreshActivities = () => {
    router.get(route('activities.index'), {}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            activitiesRef.value = page.props.activities;
        },
        onError: (errors) => {
            console.error("Validation errors:", errors);
        },
    });
};

</script>

<template>
    <head title="Actividades" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Actividades
            </h2>
        </template>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="sm:rounded-lg sm:pt-2 sm:pb-2 sm:pl-8 sm:pr-8 flex justify-end">
                    <PrimaryButton @click.prevent="refreshActivities()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm3.707 4.293a1 1 0 00-1.414 1.414A3.978 3.978 0 0114 10a4 4 0 11-4-4 1 1 0 000-2 6 6 0 106 6 5.978 5.978 0 00-1.293-3.707z" clip-rule="evenodd" />
                        </svg>
                        Actualizar
                    </PrimaryButton>
                </div>
                <div class="overflow-x-auto sm:rounded-lg sm:pt-2 sm:pb-2 sm:pl-8 sm:pr-8 bg-white shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acción
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Documento Afectado
                                </th>
                                <!--<th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descripcion
                                    </th>-->
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cambios
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Y Hora
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="activity in activitiesRef" :key="activity.id"
                                class="cursor-pointer hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ activity.user_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ actionUser(activity.action) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">
                                    {{ activity.document_name ? activity.document_name : 'N/A' }}
                                </td>
                                <!--<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">
                                        {{ activity.description }}  {{ activity.user_name }}
                                    </td>-->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">
                                    <ul v-if="activity.changes && activity.changes.after">
                                        <li v-for="(change, key) in activity.changes.after" :key="key"
                                            v-if="key !== 'updated_at' && key !== 'status_id'">
                                            <strong>{{ key }}:</strong> {{ change }}
                                        </li>
                                    </ul>
                                    <span v-else>Sin cambios</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDateTimeEs(activity.created_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
