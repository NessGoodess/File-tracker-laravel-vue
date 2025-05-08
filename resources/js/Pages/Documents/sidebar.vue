<template>
    <div class="flex h-screen">
      <!-- Sidebar -->
      <nav class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
          Mi App
        </div>
        <ul class="flex-grow">
          <li v-for="item in menuItems" :key="item.label" class="hover:bg-gray-700">
            <a
              :href="item.link"
              class="block p-4"
            >
              {{ item.label }}
            </a>
          </li>
        </ul>
        <div class="p-4 text-sm border-t border-gray-700">
          © 2025 Mi App
        </div>
      </nav>

      <!-- Main Content -->
      <div class="flex-grow bg-gray-100 p-6">

        <div>


            <div class="flex-1 flex">
                                <div class="w-full">
                                    <label for="search" class="sr-only">Search</label>
                                    <div class="relative text-gray-400 focus-within:text-gray-600">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 0a9 9 0 110 18A9 9 0 019 0zm0 1a8 8 0 100 16A8 8 0 009 1zm3.293 5.293a1 1 0 00-1.414-1.414l-2 2a1 1 0 001.414 1.414l2-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input id="search" name="search" v-model="searchQuery"
                                            class="block w-full h-full pl-10 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                                            placeholder="Buscar" type="search">
                                    </div>
                                </div>
                            </div>


        </div>

        <div>

            <div class="flex-1 flex justify-between px-4 py-6 sm:px-6 lg:px-8">
                                <div class="flex-1 flex">
                                    <input v-model="searchQuery" type="text"
                                        class="block w-full px-3 py-2 text-sm leading-5 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Buscar..." />
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <PrimaryButton>
                                        Buscar
                                    </PrimaryButton>
                                </div>
                            </div>
        </div>
        <slot />
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        menuItems: [
          { label: 'Inicio', link: '#' },
          { label: 'Servicios', link: '#' },
          { label: 'Acerca de', link: '#' },
          { label: 'Contacto', link: '#' },
        ],
      };
    },
  };
  </script>

  <style scoped>
  /* Estilos adicionales opcionales */
  </style>




<template>
    <div class="min-h-screen flex bg-gray-100">
        <!-- Navigation (Sidebar fijo) -->
        <nav class="w-64 bg-primary text-white h-screen fixed top-0 left-0">
            <div class="mx-auto h-full px-4 py-6 flex flex-col justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo class="block w-full h-auto fill-current text-gray-800" />
                    </Link>
                </div>
                <!-- Navigation Links -->
                <div class="mt-6">
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Inicio
                    </NavLink>
                </div>
            </div>
        </nav>

        <!-- Contenedor principal -->
        <div class="flex-1 min-h-screen ml-64">
            <!-- Header fijo -->
            <header class="bg-primary text-white h-16 fixed top-0 left-64 right-0 shadow-md flex items-center px-4">
                <form @submit.prevent="search" class="flex-1 flex items-center">
                    <TextInput
                        id="title"
                        ref="titleInput"
                        v-model="searchQuery"
                        type="text"
                        placeholder="Buscar..."
                        class="block w-full border rounded-full px-3 py-2 text-sm"
                    />
                    <PrimaryButton :disabled="form.processing" class="ml-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </PrimaryButton>
                </form>
                <!-- Settings -->
                <div class="relative ms-3">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center bg-white px-3 py-2 text-sm text-gray-500 rounded-md"
                            >
                                {{ $page.props.auth.user.name }}
                                <svg
                                    class="ml-2 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Salir</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Contenido principal -->
            <main class="pt-16 p-4 overflow-auto h-screen">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const searchQuery = ref('');
const form = ref({
    processing: false,
});

const search = () => {
    console.log('Searching for:', searchQuery.value);
};
</script>
