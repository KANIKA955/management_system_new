<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage, Head, Link } from '@inertiajs/vue3';
import type { Employee } from 'Types/employee';

// Get the employee data from the page props
const page = usePage();
const employee = page.props.employee as Employee;

// Tab management
const activeTab = ref(1);

// Break duration table visibility
const showBreakDurationTable = ref(false);

// Toggle break duration table
const toggleShowBreakDurationTable = () => {
    showBreakDurationTable.value = !showBreakDurationTable.value;
};

// Toggle employee details nav for mobile
const employeeDetailsNavToggle = () => {
    document.getElementById('employeeDetailsNavDiv')?.classList.toggle('hidden');
};

// Form data for read-only display
const formData = ref({
    personalInfo: [
        { label: 'First Name', value: employee.first_name },
        { label: 'Middle Name', value: employee.middle_name },
        { label: 'Last Name', value: employee.last_name },
        { label: 'Father Name', value: employee.father_name },
        { label: 'Mother Name', value: employee.mother_name },
        { label: 'Date of Birth', value: employee.date_of_birth },
        { label: 'Gender', value: employee.gender },
        { label: 'Martial Status', value: employee.marital_status },
        { label: 'Blood Group', value: employee.blood_group },
        { label: 'Any Disability', value: employee.disability || '--no--' },
        { label: 'City', value: employee.city },
        { label: 'Country', value: employee.country }
    ],
    contactInfo: [
        { label: 'Email Id', value: employee.email },
        { label: 'Phone', value: employee.phone },
        { label: 'Mobile Number', value: employee.mobile },
        { label: 'Alternate Number', value: employee.alternate_number },
        { label: 'Address', value: employee.address },
        { label: 'City', value: employee.city },
        { label: 'Country', value: employee.country }
    ],
    professionalInfo: [
        { label: 'Employee id', value: employee.employee_id, disabled: true },
        { label: 'Department', value: employee.department },
        { label: 'Designation', value: employee.designation },
        { label: 'Reporting Manager', value: employee.reporting_manager },
        { label: 'Shift Start Time', value: employee.shift_start_time },
        { label: 'Shift End Time', value: employee.shift_end_time }
    ]
});

// Sample data for the break time entries
const breakTimeEntries = ref([
    {
        id: 1,
        date: '10/10/2020',
        login_time: '10:00AM',
        logout_time: '05:00PM',
        total_hours: '7 Hours',
        break_time: '1 Hour 15 Minutes'
    },
    {
        id: 2,
        date: '11/10/2020',
        login_time: '10:00AM',
        logout_time: '05:00PM',
        total_hours: '7 Hours',
        break_time: '1 Hour'
    }
]);

const breakDurations = ref([
    {
        id: 1,
        start_time: '10:00AM',
        end_time: '11:00AM',
        duration: '1 Hour'
    },
    {
        id: 2,
        start_time: '01:00PM',
        end_time: '01:15PM',
        duration: '15 Minutes'
    }
]);
</script>

<template>
    <AppLayout title="Employee">
        <Head :title="employee.first_name" />
        <!-- Header Section -->
        <div class="flex flex-col py-2">
            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">
                    <span class="text-lg text-primary dark:text-info">{{ employee.first_name +' '+employee.last_name }}</span>
                </span>
                <Link :href="route('employees.index')" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class="fa fa-arrow-left"></i>
                </Link>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mt-6 w-full rounded-[10px]">
            <div class="w-full flex lg:flex-row md:flex-row sm:flex-row flex-col gap-4">
                <!-- Sidebar -->
                <div class="lg:w-[300px] md:w-[300px] sm:w-[300px] w-full h-max bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-sm flex flex-col">
                    <div class="lg:hidden md:hidden sm:hidden flex justify-end p-1">
                        <button @click="employeeDetailsNavToggle" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Navigation Tabs -->
                    <div id="employeeDetailsNavDiv" class="lg:flex md:flex sm:flex flex-col hidden">
                        <template v-for="(tab, index) in [
                            'Personal Information',
                            'Contact Information',
                            'Professional Information',
                            'Login/Break Information'
                        ]" :key="index">
                            <div
                                @click="activeTab = index + 1"
                                :class="[
                                    activeTab === index + 1 ? 'bg-primary dark:bg-info/50 text-light font-semibold' : 'text-dark dark:text-light font-normal hover:bg-primary/10 hover:dark:bg-info/10',
                                    'w-full py-2 px-4 border-b-[1px] border-dark/20 dark:border-light/20 text-md cursor-pointer transition ease-in duration-2000',
                                    index === 0 ? 'rounded-t-sm' : '',
                                    index === 3 ? 'rounded-b-sm' : ''
                                ]"
                            >
                                <span>{{ tab }}</span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="grow bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-sm p-4">
                    <!-- Tab 1: Personal Information -->
                    <div v-if="activeTab === 1">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Personal Information</span>
                        </div>
                        <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                            <div v-for="(field, index) in formData.personalInfo" :key="index" class="flex flex-col gap-1">
                                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">{{ field.label }}</label>
                                <input
                                    type="text"
                                    :value="field.value"
                                    readonly
                                    class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 rounded-[3px] focus:outline-none focus:ring-0"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Contact Information -->
                    <div v-if="activeTab === 2">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Contact Information</span>
                        </div>
                        <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                            <div v-for="(field, index) in formData.contactInfo" :key="index" class="flex flex-col gap-1">
                                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">{{ field.label }}</label>
                                <input
                                    type="text"
                                    :value="field.value"
                                    readonly
                                    class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 rounded-[3px] focus:outline-none focus:ring-0"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Professional Information -->
                    <div v-if="activeTab === 3">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Professional Information</span>
                        </div>
                        <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                            <div v-for="(field, index) in formData.professionalInfo" :key="index" class="flex flex-col gap-1">
                                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">{{ field.label }}</label>
                                <input
                                    type="text"
                                    :value="field.value"
                                    :disabled="field.disabled"
                                    readonly
                                    class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 rounded-[3px] focus:outline-none focus:ring-0"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Login/Break Information -->
                    <div v-if="activeTab === 4">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Login/Break Information</span>
                        </div>
                        <div class="mt-2 w-full bg-light dark:bg-darkTrans flex flex-col justify-between overflow-x-auto">
                            <!-- Break Time Table -->
                            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                                <thead>
                                <tr class="bg-lightTrans dark:bg-dark">
                                    <th v-for="header in ['SR.No.', 'DATE', 'LOGIN TIME', 'LOGOUT TIME', 'TOTAL HOURS', 'BREAK TIME']"
                                        :key="header"
                                        class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal"
                                    >
                                        {{ header }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="entry in breakTimeEntries"
                                    :key="entry.id"
                                    @click="toggleShowBreakDurationTable"
                                    class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
                                >
                                    <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ entry.id }}</td>
                                    <td class="border px-2 py-1 text-primary dark:text-info font-bold">{{ entry.date }}</td>
                                    <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ entry.login_time }}</td>
                                    <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ entry.logout_time }}</td>
                                    <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ entry.total_hours }}</td>
                                    <td class="border px-2 py-1 text-danger/80 dark:text-warning/80">{{ entry.break_time }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <!-- Break Duration Details -->
                            <div v-if="showBreakDurationTable" class="w-full mt-8">
                                <span class="font-semibold text-dark/80 dark:text-light/80">
                                    Break Duration: <span class="italic">10/10/2024</span>
                                </span>
                                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full mt-2">
                                    <thead>
                                    <tr class="bg-lightTrans dark:bg-dark">
                                        <th v-for="header in ['SR.No.', 'START TIME', 'END TIME', 'BREAK DURATION']"
                                            :key="header"
                                            class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal"
                                        >
                                            {{ header }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="duration in breakDurations"
                                        :key="duration.id"
                                        class="hover:bg-gray-50 dark:hover:bg-gray-800"
                                    >
                                        <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ duration.id }}</td>
                                        <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ duration.start_time }}</td>
                                        <td class="border px-2 py-1 text-dark/80 dark:text-light/80">{{ duration.end_time }}</td>
                                        <td class="border px-2 py-1 text-danger/80 dark:text-warning/80">{{ duration.duration }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
