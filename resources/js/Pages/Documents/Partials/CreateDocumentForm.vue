<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import DateInput from '@/Components/DateInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const titleInput = ref(null);
const referenceNumberInput = ref(null);
const categoryInput = ref(null);
const statusInput = ref(null);
const sourceDepartmentInput = ref(null);
const destinationDepartmentInput = ref(null);
const issueDateInput = ref(null);
const receivedDateInput = ref(null);
const priorityInput = ref(null);
const descriptionInput = ref(null);

const {props} = usePage();
const categories = ref(props.categories);
const statuses = ref(props.statuses);
const departments = ref(props.departments);

const form = useForm({
    title: '',
    reference_number: '',
    category: '',
    status: '',
    source_department: '',
    destination_department: '',
    issue_date: '',
    receivedDate: '',
    description: '',
    priority: 1,
    isPublic: false,
    processing: false,
    recentlySuccessful: false,
    errors: {},
});

const saveDocument = () => {
    form.post(route('documents.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            console.log('error', form.errors);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Crear Registro
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Cree un nuevo registro
            </p>
        </header>

        <form @submit.prevent="saveDocument" class="mt-6 grid grid-cols-2 gap-x-12 gap-y-6">

            <div class="mb-4">
                <InputLabel for="title" value="Título o Asunto" />
                <TextInput
                    id="title"
                    ref="titleInput"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"

                />
                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="number" value="Numero De referencia (Opcional)" />
                <TextInput
                    id="reference_number "
                    ref="referenceNumberInput"
                    v-model="form.reference_number"
                    type="text"
                    class="mt-1 block w-full"

                />
                <InputError :message="form.errors.reference_number" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="category" value="Tipo" />
                <SelectInput
                    id="category"
                    ref="categoryInput"
                    v-model="form.category"
                    class="mt-1 block w-full"
                    >
                    <option v-for="category in categories" :key="category.id" :value="String(category.id)">
                        {{ category.name }}
                    </option>
                </SelectInput>
                <InputError :message="form.errors.category" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="status" value="Status" />
                <SelectInput
                    id="status"
                    ref="statusInput"
                    v-model="form.status"
                    class="mt-1 block w-full"
                >
                    <option v-for="status in statuses" :key="status.id" :value="String(status.id)">
                        {{ status.name }}
                    </option>
                </SelectInput>
                <InputError :message="form.errors.status" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="source_department" value="Dependencia" />
                <SelectInput
                    id="source_department"
                    ref="sourceDepartmentInput"
                    v-model="form.source_department"
                    class="mt-1 block w-full"
                    >
                    <option v-for="department in departments" :key="department.id" :value="String(department.id)">
                        {{ department.name }}
                    </option>
                </SelectInput>
                <InputError :message="form.errors.source_department" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="destination_department" value="Dependencia destino" />
                <SelectInput
                    id="destination_department"
                    ref="destinationDepartmentInput"
                    v-model="form.destination_department"
                    class="mt-1 block w-full"
                    >
                    <option :value="null">Sin Dependencia</option>
                    <option v-for="department in departments" :key="department.id" :value="String(department.id)">
                        {{ department.name }}
                    </option>
                </SelectInput>
                <InputError :message="form.errors.destination_department" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="issue_date " value="Fecha de Emision" />
                <DateInput
                    id="issue_date "
                    ref="issueDateInput"
                    v-model="form.issue_date"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.issue_date" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="receivedDate" value="Fecha de Recepción" />
                <DateInput
                    id="receivedDate"
                    ref="receivedDateInput"
                    v-model="form.receivedDate"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.receivedDate" class="mt-2" />
            </div>

            <div class="mb-4 col-span-2">
                <InputLabel for="description" value="Descripción" />
                <TextArea
                    id="description"
                    ref="descriptionInput"
                    v-model="form.description"
                    class="mt-1 block w-full"
                ></TextArea>
                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="mb-4">
                <InputLabel for="priority" value="Prioridad (Opcional)" />
                <SelectInput
                    id="priority"
                    ref="priorityInput"
                    v-model="form.priority"
                    class="mt-1 block w-full"
                    >
                    <option value="1" selected>Ninguna Prioridad</option>
                    <option value="2">Baja</option>
                    <option value="3">Media</option>
                    <option value="4">Alta</option>
                </SelectInput>
                <InputError :message="form.errors.priority" class="mt-2" />
            </div>



            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600">
                        Guardado.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
