<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const departments = props.departments;

// Ref for toggling the form visibility
const isFormVisible = ref(false);

// Function to toggle form visibility
const crateDepartmentForm = () => {
    isFormVisible.value = !isFormVisible.value;
};
</script>



<template>
    <AppLayout title="Employee">
        <!--       heading and create/edit department form div here-->
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Departments</span>
                <button v-show="!isFormVisible" @click="crateDepartmentForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    Add New Department
                </button>
                <button v-show="isFormVisible" @click="crateDepartmentForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class=" fa fa-xmark"></i>
                </button>
            </div>

            <div v-if="isFormVisible" class="mt-6 grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6 ">
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department Name</label>
                    <input type="text" placeholder="Department name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department Description</label>
                    <input type="text" placeholder="Department description..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <div class="w-full flex  justify-end gap-2  py-4 mt-4">
                    <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Create New Department </button>
                    <button @click="crateDepartmentForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
                </div>
            </div>

        </div>
        <!--        department list table div here-->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESCRIPTION</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                </tr>
                <tr v-for="(department, index) in departments" :key="department.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ index + 1 }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ department.name }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ department.description }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex">
                            <button @click="crateDepartmentForm()" class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa fa-trash text-md"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>
