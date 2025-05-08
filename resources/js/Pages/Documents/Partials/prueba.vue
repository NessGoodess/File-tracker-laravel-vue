<template>
    <div class="w-full max-w-sm">
      <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
          <LockClosedIcon class="h-5 w-5" />
        </span>
        <input
          id="password"
          :type="showPassword ? 'text' : 'password'"
          v-model="password"
          class="w-full px-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your password"
        />
        <span
          class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer"
          @click="togglePassword"
        >
          <EyeIcon v-if="!showPassword" class="h-5 w-5" />
          <EyeOffIcon v-else class="h-5 w-5" />
        </span>
      </div>
      <div class="mt-2 text-sm" :class="passwordStrength.color">
        {{ passwordStrength.text }}
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';
  import { LockClosedIcon, EyeIcon, EyeOffIcon } from '@heroicons/vue/solid';

  const password = ref('');
  const showPassword = ref(false);

  const togglePassword = () => {
    showPassword.value = !showPassword.value;
  };

  const passwordStrength = computed(() => {
    if (password.value.length > 8 && /[A-Z]/.test(password.value) && /\d/.test(password.value) && /[^A-Za-z0-9]/.test(password.value)) {
      return { text: 'Strong', color: 'text-green-600' };
    } else if (password.value.length > 5) {
      return { text: 'Medium', color: 'text-yellow-500' };
    } else {
      return { text: 'Weak', color: 'text-red-600' };
    }
  });
  </script>

  <style scoped>
  input {
    padding-left: 2.5rem;
    padding-right: 2.5rem;
  }
  </style>





//************* */


<template>
    <div class="min-h-screen bg-gray-100 p-6">
        <!-- Encabezado -->
        <header class="bg-white shadow-md p-6 rounded-lg mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Bienvenido, {{ userName }}</h1>
            <p class="text-gray-600">Este es tu panel de administración</p>
        </header>

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sección de Miembros Activos -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Miembros Activos</h2>
                <ul class="space-y-2">
                    <li v-for="user in activeUsers" :key="user.id" class="flex items-center space-x-3">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-gray-800">{{ user.name }}</span>
                    </li>
                </ul>
            </div>

            <!-- Gráfica -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Estadísticas</h2>

            </div>

            <!-- Seguimientos / Actividades -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Actividades Recientes</h2>
                <ul class="space-y-3">
                    <li v-for="activity in recentActivities" :key="activity.id" class="text-gray-700">
                        <span class="font-semibold">{{ activity.user }}</span> {{ activity.action }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';


const userName = ref('Administrador');

// Lista de usuarios activos (ejemplo)
const activeUsers = ref([
    { id: 1, name: 'Carlos Pérez' },
    { id: 2, name: 'Ana Gómez' },
    { id: 3, name: 'Luis Rodríguez' },
]);

// Datos de la gráfica (ejemplo)
const chartData = ref({
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
    datasets: [
        {
            label: 'Documentos Seguimiento',
            backgroundColor: '#3490dc',
            data: [10, 20, 15, 25],
        },
    ],
});

// Actividades recientes (ejemplo)
const recentActivities = ref([
    { id: 1, user: 'Carlos Pérez', action: 'subió un nuevo documento' },
    { id: 2, user: 'Ana Gómez', action: 'modificó un archivo' },
    { id: 3, user: 'Luis Rodríguez', action: 'eliminó un registro' },
]);
</script>
