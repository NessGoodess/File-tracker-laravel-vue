<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const { statusCounts, users, notifications, totalDocuments } = usePage().props;

const statusCountsRef = ref(statusCounts);
const notificationsRef = ref(notifications);
const totalDocumentsRef = ref(totalDocuments);
const usersRef = ref(users);
const messages = notificationsRef.value.map(notification => {
  const data = JSON.parse(notification.data);
  return data.message;
});
</script>

<template>

    <Head title="Secretaria Administrativa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                Inicio

            </h2>
            <p class="text-sm text-gray-700">Bienvenido al panel de control. Aquí puedes gestionar tus actividades y documentos.</p>
        </template>

        <div class="py-12 ">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-gray-100 min-h-screen">

                        <!-- main principal -->
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                            <!-- Actividad Reciente -->
                            <div class="col-span-2 row-span-2 bg-white p-6 shadow-lg rounded-2xl transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold mb-4 text-center text-blue-600">Actividad Reciente</h2>
                                <hr class="border-blue-500 mb-2">

                                <ul v-for="(activity, index) in notificationsRef" :key="index">
                                    <li class="mb-2">
                                        <span class="text-green-700">✔</span>
                                        {{ JSON.parse(activity.data).message }}
                                    </li>
                                </ul>
                                <Link :href="route('activities.index')"
                                    class="text-blue-600 hover:underline text-sm">
                                        Ver más
                                </Link>
                            </div>

                            <!-- Información General -->
                            <div
                                class="col-span-2 bg-yellow-400 text-black font-bold p-6 shadow-lg rounded-2xl text-center transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold p-4">Información General</h2>
                                <div class="grid grid-cols-1 lg:grid-cols-4">
                                    <div class="text-sm col-span-4">Documentos Registrados</div>
                                    <div class="text-3xl font-bold my-4 col-span-4">{{ totalDocumentsRef }}</div>
                                    <div class="col-span-2 mt-4">
                                        <div class="text-2xl">{{ statusCountsRef[0].total }} <span class="text-sm text-center block">Documentos {{ statusCountsRef[0].status.name }} </span></div>
                                    </div>
                                    <div class="col-span-2 mt-4">
                                        <!--<div class="text-2xl"> {{ statusCountsRef[1].total }} <span class="text-sm text-center block">Documentos {{ statusCountsRef[1].status.name }} </span></div>
                                    --></div>
                                </div>
                            </div>

                            <!-- Lista de Usuarios -->
                            <div class="row-span-2 bg-white p-6 shadow-lg rounded-2xl transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold mb-4 text-blue-600">Lista de Usuarios</h2>
                                <ul v-for="(user, index) in usersRef" :key="index">
                                    <li class="mb-2">
                                        <span class="mr-2">👤</span>{{ user.name }}
                                    </li>
                                </ul>
                                <Link :href="route('users.index')"
                                    class="text-blue-600 hover:underline text-sm">
                                        Ver más
                                </Link>
                            </div>

                            <!-- Usuarios Activos -->
                            <div class="bg-teal-400 text-white p-6 shadow-lg rounded-2xl text-center transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold">Usuarios Activos</h2>
                                <div class="text-4xl font-bold my-4">3</div>
                            </div>

                            <!-- Alertas -->
                            <div class="col-span-1 bg-white p-6 shadow-lg rounded-2xl transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold text-red-500 mb-4 text-center">Alertas</h2>
                                <hr class="border-red-500 mb-2">
                                <ul>
                                    <li class="mb-2">El documento "Oficio No. 125" está pendiente de firma.</li>
                                    <li>El documento "Acta de reunión" ha superado el tiempo límite para su
                                        modificación.</li>
                                </ul>
                                <a href="#" class="text-blue-600 hover:underline text-sm">Ver más</a>
                            </div>

                            <!-- Historial de Actividad -->
                            <div class="col-span-1 bg-white p-6 shadow-lg rounded-2xl transition-transform transform hover:scale-105">
                                <h2 class="text-lg font-semibold mb-4 text-center text-blue-600">Historial de Actividad</h2>
                                <hr class="border-blue-500 mb-2">
                                <ul>
                                    <li class="mb-2">El documento "Oficio No. 125" está pendiente de firma.</li>
                                    <li>El documento "Acta de reunión" ha superado el tiempo límite para su
                                        modificación.</li>
                                </ul>
                                <a href="#" class="text-blue-600 hover:underline text-sm">Ver más</a>
                            </div>

                            <!-- Gestionar Usuarios -->
                            <div class="bg-white p-6 shadow-lg rounded-2xl text-center transition-transform transform hover:scale-105">
                                <div class="text-6xl mb-4">👤</div>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Gestionar Usuarios
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
