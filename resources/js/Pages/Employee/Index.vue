<script setup>
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage, router, Link, Head } from '@inertiajs/vue3';

const page = usePage();
const employees = ref(page.props.employees);

const refreshEmployees = () => {
    router.reload({ only: ['employees'] });
};

watch(() => page.props.employees, (newEmployees) => {
    employees.value = newEmployees;
}, { deep: true });
</script>


<template>
    <AppLayout title="Employee">
        <Head title="Employee" />
        <div class="flex flex-col py-2">
            <!-- Header -->
            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Employee</span>

                <ModalLink :href="route('employees.create')" :close-explicitly="true" @employee-created="refreshEmployees" max-width="6xl"
                           panel-classes="bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark p-4"
                           class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"> Add New Employee
                </ModalLink>

            </div>

            <!-- Employee Table -->
            <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                    <tr class="bg-lightTrans dark:bg-dark">
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">EMPLOYEE ID</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DEPARTMENT</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESIGNATION</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">REPORTING MANAGER</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SHIFT TIME</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">PROFILE</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                    </tr>
                    <tr v-for="(employee, index) in employees" :key="employee.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ index + 1 }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <span class="text-sm font-bold cursor-pointer">{{ employee.employee_id }}</span>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ employee.first_name }} {{ employee.last_name }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ employee.department }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ employee.designation }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ employee.reporting_manager }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ employee.shift_start_time }} - {{ employee.shift_end_time }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <button
                                :class="[employee.profile_status === 1 ? 'bg-success' : 'bg-danger', 'text-light px-4 py-1 rounded-full font-semibold']"
                            >
                                {{ employee.profile_status === 1 ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <div class="flex items-center">
                                <Link :href="route('employees.show', employee.id)">
                                    <button type="button" class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="View">
                                        <i class="fa-regular fa-eye text-md"></i>
                                    </button>
                                </Link>
                                <ModalLink :href="route('employees.edit', employee.id)" :close-explicitly="true" @employee-created="refreshEmployees" #default="{ loading }" max-width="6xl"
                                           panel-classes="bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark p-4" class="h-8 w-8 flex items-center justify-center rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                    <span v-if="loading"><i class="fa fa-spinner animate-spin"></i></span>
                                    <span v-else><i class="fa-regular fa-edit text-md"></i></span>
                                </ModalLink>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
