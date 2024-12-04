<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    department: {
        type: Object,
        default: () => ({
            name: '',
            description: ''
        })
    },
    mode: {
        type: String,
        default: 'create'
    }
});

const emit = defineEmits(['close']);

const form = useForm({
    name: '',
    description: ''
});

onMounted(() => {
    if (props.mode === 'edit' && props.department) {
        form.name = props.department.name;
        form.description = props.department.description;
    }
});

const submit = () => {
    if (props.mode === 'create') {
        form.post(route('departments.store'), {
            onSuccess: () => {
                emit('close');
                form.reset();
            },
        });
    } else {
        form.put(route('departments.update', props.department.id), {
            onSuccess: () => {
                emit('close');
            },
        });
    }
};
</script>

<template>
    <div class="mt-6 grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
        <div class="flex flex-col gap-1">
            <label for="name" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department Name</label>
            <input
                type="text"
                v-model="form.name"
                placeholder="Department name..."
                class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
            >
            <div v-if="form.errors.name" class="text-danger text-sm">{{ form.errors.name }}</div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="description" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department Description</label>
            <input
                type="text"
                v-model="form.description"
                placeholder="Department description..."
                class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
            >
            <div v-if="form.errors.description" class="text-danger text-sm">{{ form.errors.description }}</div>
        </div>

        <div class="w-full flex justify-end gap-2 py-4 mt-4">
            <button
                @click="submit"
                :disabled="form.processing"
                class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
            >
                {{ mode === 'create' ? 'Create New Department' : 'Update Department' }}
            </button>
            <button
                @click="$emit('close')"
                class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000"
            >
                Cancel
            </button>
        </div>
    </div>
</template>
