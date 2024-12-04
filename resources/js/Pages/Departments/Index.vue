<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DepartmentForm from './Form.vue';

const props = defineProps({
    departments: {
        type: Array,
        required: true
    }
});

const isFormVisible = ref(false);
const editingDepartment = ref(null);
const formMode = ref('create');

const toggleForm = (department = null) => {
    if (department) {
        editingDepartment.value = department;
        formMode.value = 'edit';
    } else {
        editingDepartment.value = null;
        formMode.value = 'create';
    }
    isFormVisible.value = !isFormVisible.value;
};

const deleteDepartment = (id) => {
    if (confirm('Are you sure you want to delete this department?')) {
        router.delete(route('departments.destroy', id));
    }
};
</script>

<template>
    <AppLayout title="Departments">
        <!-- Heading and form toggle -->
        <div class="flex flex-col py-2">
            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Departments</span>
                <button
                    v-show="!isFormVisible"
                    @click="toggleForm()"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    Add New Department
                </button>
                <button
                    v-show="isFormVisible"
                    @click="toggleForm()"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    <i class="fa fa-xmark"></i>
                </button>
            </div>

            <!-- Department Form -->
            <DepartmentForm
                v-if="isFormVisible"
                :department="editingDepartment"
                :mode="formMode"
                @close="toggleForm()"
            />
        </div>

        <!-- Departments Table -->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <thead>
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESCRIPTION</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(department, index) in departments" :key="department.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        {{ index + 1 }}
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <span class="text-sm font-bold cursor-pointer">{{ department.name }}</span>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        {{ department.description }}
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex">
                            <button
                                @click="toggleForm(department)"
                                class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Edit"
                            >
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button
                                @click="deleteDepartment(department.id)"
                                class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Delete"
                            >
                                <i class="fa fa-trash text-md"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
