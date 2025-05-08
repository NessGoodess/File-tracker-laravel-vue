<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Transition } from 'vue';
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const searchTerm = ref('');
const form = ref({
    processing: false,
    recentlySuccessful: false,
});

const search = () => {
    form.value.processing = true;
    router.get(route('documents.search'), { query: searchTerm.value }, {
        onFinish: () => {
            form.value.processing = false;
        },
        onError: () => {
            form.value.recentlySuccessful = false;
            searchTerm.value = '';
            console.log('Error');
        },
        onSuccess: () => {
            form.value.recentlySuccessful = true;
        }
    });
};

</script>

<template>
    <div>
        <div class="min-h-screen flex bg-gray-100">
            <nav class="w-64 bg-primary text-white h-screen fixed top-0 left-0 z-10 shadow-lg"><!--Aqui fue-->
                <!-- Primary Navigation Menu -->
                <div class="mx-auto h-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center mt-4 bg-white">
                        <Link :href="route('dashboard')">
                        <ApplicationLogo class="block h-full w-full fill-current text-gray-800" />
                        </Link>
                    </div>

                    <div class="flex h-auto justify-between flex-col">
                        <div class="flex flex-col">

                            <!-- Navigation Links -->
                            <hr class="border-t border-gray-200 my-4">
                            <div class="mt-6 px-2 py-2">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    <!--<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 20v-6h4v6h5v-8h3L10 0 2 12h3v8z"/>
                                    </svg>-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M12 3L4 9v12h16V9l-8-6zm6 16h-3v-6H9v6H6v-9l6-4.5 6 4.5v9z" />
                                    </svg>
                                    Inicio
                                </NavLink>
                            </div>
                            <div class="mt-6 px-2 py-2 px-2">
                                <NavLink :href="route('documents.index')" :active="route().current('documents.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4h16v2H4V4zm0 4h16v2H4V8zm0 4h16v2H4v-2zm0 4h16v2H4v-2z" />
                                    </svg>
                                    Documentos
                                </NavLink>
                            </div>
                            <div class="mt-6 px-2 py-2 px-2">
                                <NavLink :href="route('documents.create')"
                                    :active="route().current('documents.create')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M4 2h12a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v12h12V4H4zm2 2h8v2H6V6zm0 4h8v2H6v-2z" />
                                    </svg>
                                    Registrar Documento
                                </NavLink>
                            </div>

                            <div class="mt-6 px-2 py-2 px-2">
                                <NavLink :href="route('documents.filters')"
                                    :active="route().current('documents.filters')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Consultas
                                </NavLink>
                            </div>

                            <div v-if="$page.props.auth.user.role === 'admin'" class="mt-6 px-2 py-2 px-2">
                                <NavLink :href="route('users.index')" :active="route().current('users.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 0114 0H3z" />
                                    </svg>
                                    Usuarios
                                </NavLink>
                            </div>

                            <!--v-if="$page.props.auth.user.role === 'admin'-->
                            <div v-if="$page.props.auth.user.role === 'admin'" class="mt-6 px-2 py-2 px-2">
                                <NavLink :href="route('activities.index') "
                                    :active="route().current('activities.index') ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z" />
                                    </svg>
                                    Actividades
                                </NavLink>
                            </div>
                        </div>
                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden bg-black-300">
                            <button @click="
                                showingNavigationDropdown =
                                !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }" class="sm:hidden">
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex-1 min-h-screen ml-64">

                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-gray-100 stiky top-0 left-64 right-0 h-16">
                    <!--Aqui fue-->
                    <div
                        class="bg-primary hidden sm:flex sm:items-center flex justify-between px-4 py-6 sm:px-6 lg:px-8">

                        <!--Search-->
                        <form @submit.prevent="search" class="flex-1 flex">
                            <div class="w-full max-w-md flex">
                                <TextInput id="search" ref="searchInput" v-model="searchTerm" type="text"
                                    placeholder="Buscar..."
                                    class="block w-full border-none rounded-l-3xl rounded-r-none px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" />

                                <div class="flex items-center gap-4">
                                    <PrimaryButton :disabled="form.processing"
                                        class="bg-white hover:bg-primary text-primary hover:text-white rounded-r-3xl rounded-l-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-primary hover:text-white" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </PrimaryButton>

                                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                            Exito!!
                                        </p>
                                    </Transition>
                                </div>
                            </div>
                        </form>

                        <!-- Settings Dropdown -->
                        <div class="relative ms-3 flex">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 0114 0H3z" />
                                </svg>
                            </div>
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                            {{ $page.props.auth.user.name }}

                                            <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                    </div>
                    <!-- Header
                    <div class="mx-auto w-full px-4 py-6 sm:px-6 lg:px-8 bg-gray-100 shadow-md">
                        <slot name="header" />
                    </div>-->
                </header>

                <!-- Page Content -->
                <main class=" overflow-auto h-screen">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
