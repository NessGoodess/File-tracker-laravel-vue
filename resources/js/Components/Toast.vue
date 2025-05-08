<template>
    <div>
      <!-- Tu contenido aquí -->
    </div>
  </template>

  <script>
  import { useToast } from 'vue3-toastify';
  import { usePage } from '@inertiajs/inertia-vue3';

  export default {
    mounted() {
      const { props } = usePage();  // Acceder a las propiedades pasadas desde Inertia
      const toast = useToast();     // Instancia de vue3-toastify

      // Verificar si hay un mensaje de éxito y mostrarlo
      if (props.flash.success) {
        toast.success(props.flash.success);
      }
    },
  };
  </script>
