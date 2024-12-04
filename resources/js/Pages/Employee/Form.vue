<script setup>
import { ref } from 'vue';
import { useForm, router, usePage, Head } from '@inertiajs/vue3';
import Toast from '@/Utils/toast.js';

const page = usePage();
const props = defineProps({
    employee: {
        type: Object,
        default: () => ({})
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    departments: {
        type: Array,
        default: () => []
    }
});
const loading = ref(false);
const isSubmitting = ref(false);

const form = useForm({
    first_name: props.employee?.first_name ?? '',
    middle_name: props.employee?.middle_name ?? '',
    last_name: props.employee?.last_name ?? '',
    father_name: props.employee?.father_name ?? '',
    mother_name: props.employee?.mother_name ?? '',
    date_of_birth: props.employee?.date_of_birth ?? '',
    gender: props.employee?.gender ?? '',
    marital_status: props.employee?.marital_status ?? '',
    blood_group: props.employee?.blood_group ?? '',
    disability: props.employee?.disability ?? '',
    city: props.employee?.city ?? '',
    country: props.employee?.country ?? '',
    email: props.employee?.email ?? '',
    phone: props.employee?.phone ?? '',
    mobile: props.employee?.mobile ?? '',
    alternate_number: props.employee?.alternate_number ?? '',
    address: props.employee?.address ?? '',
    department: props.employee?.department ?? '',
    designation: props.employee?.designation ?? '',
    reporting_manager: props.employee?.reporting_manager ?? '',
    shift_start_time: props.employee?.shift_start_time ?? '',
    shift_end_time: props.employee?.shift_end_time ?? ''
});
const EmployeeModal = ref(null);

const submit = () => {
    if (isSubmitting.value) return;

    loading.value = true;
    isSubmitting.value = true;

    const requestMethod = props.isEditing ? 'put' : 'post';
    const url = props.isEditing ? `/employees/${props.employee.id}` : '/employees';

    form.clearErrors();

    router[requestMethod](url, form, {
        preserveScroll: true,
        onSuccess: () => {
            Toast.success(page.props.toast.message ||
                (props.isEditing ? 'Employee updated successfully' : 'Employee created successfully'));
            EmployeeModal.value.emit('employee-created');
            EmployeeModal.value.close();
            form.reset();
            form.clearErrors();
        },
        onError: (errors) => {
            form.errors = errors;
            console.log(errors);
            Toast.error(errors.message || 'Check and Fix the errors!');
        },
        onFinish: () => {
            loading.value = false;
            isSubmitting.value = false;
        }
    });
};
</script>

<template>
    <Head :title="isEditing ? 'Edit Employee' : 'Create Employee'" />

    <Modal ref="EmployeeModal" v-slot="{ close }">
        <div class="flex flex-col py-2 border-b-[1px] border-b-dark/20 dark:border-b-light/20   ">
            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">
                {{ isEditing ? 'Edit Employee' : 'Create Employee' }}
            </span>
        </div>
        <form @submit.prevent="submit" class="flex flex-col py-2">
            <div class="">
                <!-- Personal Information -->
                <div class="mb-4">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Personal Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                    <!-- First Name -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">First Name</label>
                        <input
                            v-model="form.first_name"
                            type="text"
                            placeholder="Enter first name"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.first_name }"
                        >
                        <div v-if="form.errors.first_name" class="text-red-500 text-xs mt-1">
                            {{ form.errors.first_name }}
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Middle Name</label>
                        <input
                            v-model="form.middle_name"
                            type="text"
                            placeholder="Enter middle name"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.middle_name }"
                        >
                        <div v-if="form.errors.middle_name" class="text-red-500 text-xs mt-1">
                            {{ form.errors.middle_name }}
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Last Name</label>
                        <input
                            v-model="form.last_name"
                            type="text"
                            placeholder="Enter last name"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.last_name }"
                        >
                        <div v-if="form.errors.last_name" class="text-red-500 text-xs mt-1">
                            {{ form.errors.last_name }}
                        </div>
                    </div>

                    <!-- Father Name -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Father Name</label>
                        <input
                            v-model="form.father_name"
                            type="text"
                            placeholder="Enter father name"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.father_name }"
                        >
                        <div v-if="form.errors.father_name" class="text-red-500 text-xs mt-1">
                            {{ form.errors.father_name }}
                        </div>
                    </div>

                    <!-- Mother Name -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Mother Name</label>
                        <input
                            v-model="form.mother_name"
                            type="text"
                            placeholder="Enter mother name"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.mother_name }"
                        >
                        <div v-if="form.errors.mother_name" class="text-red-500 text-xs mt-1">
                            {{ form.errors.mother_name }}
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Date of Birth</label>
                        <input
                            v-model="form.date_of_birth"
                            type="date"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.date_of_birth }"
                        >
                        <div v-if="form.errors.date_of_birth" class="text-red-500 text-xs mt-1">
                            {{ form.errors.date_of_birth }}
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Gender</label>
                        <select
                            v-model="form.gender"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.gender }"
                        >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <div v-if="form.errors.gender" class="text-red-500 text-xs mt-1">
                            {{ form.errors.gender }}
                        </div>
                    </div>

                    <!-- Marital Status -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Marital Status</label>
                        <select
                            v-model="form.marital_status"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.marital_status }"
                        >
                            <option value="">Select Status</option>
                            <option value="unmarried">Unmarried</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                        </select>
                        <div v-if="form.errors.marital_status" class="text-red-500 text-xs mt-1">
                            {{ form.errors.marital_status }}
                        </div>
                    </div>

                    <!-- Blood Group -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Blood Group</label>
                        <select
                            v-model="form.blood_group"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.blood_group }"
                        >
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                        <div v-if="form.errors.blood_group" class="text-red-500 text-xs mt-1">
                            {{ form.errors.blood_group }}
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-4 mt-6">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Contact Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                    <!-- Email -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Email</label>
                        <input
                            v-model="form.email"
                        type="email"
                        placeholder="Enter email address"
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                        :class="{ 'border-red-500': form.errors.email }"
                        >
                        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Phone</label>
                        <input
                            v-model="form.phone"
                            type="text"
                            placeholder="Enter phone number"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.phone }"
                        >
                        <div v-if="form.errors.phone" class="text-red-500 text-xs mt-1">
                            {{ form.errors.phone }}
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Mobile Number</label>
                        <input
                            v-model="form.mobile"
                            type="text"
                            placeholder="Enter mobile number"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.mobile }"
                        >
                        <div v-if="form.errors.mobile" class="text-red-500 text-xs mt-1">
                            {{ form.errors.mobile }}
                        </div>
                    </div>

                    <!-- Alternate Number -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Alternate Number</label>
                        <input
                            v-model="form.alternate_number"
                            type="text"
                            placeholder="Enter alternate number"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.alternate_number }"
                        >
                        <div v-if="form.errors.alternate_number" class="text-red-500 text-xs mt-1">
                            {{ form.errors.alternate_number }}
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Address</label>
                        <input
                            v-model="form.address"
                            type="text"
                            placeholder="Enter address"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.address }"
                        >
                        <div v-if="form.errors.address" class="text-red-500 text-xs mt-1">
                            {{ form.errors.address }}
                        </div>
                    </div>

                    <!-- City -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">City</label>
                        <input
                            v-model="form.city"
                            type="text"
                            placeholder="Enter city"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.city }"
                        >
                        <div v-if="form.errors.city" class="text-red-500 text-xs mt-1">
                            {{ form.errors.city }}
                        </div>
                    </div>

                    <!-- Country -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Country</label>
                        <input
                            v-model="form.country"
                            type="text"
                            placeholder="Enter country"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.country }"
                        >
                        <div v-if="form.errors.country" class="text-red-500 text-xs mt-1">
                            {{ form.errors.country }}
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="mb-4 mt-6">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Professional Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                    <!-- Employee ID (Read-only for editing) -->
                    <div v-if="isEditing" class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Employee ID</label>
                        <input
                            type="text"
                            :value="employee?.employee_id"
                            disabled
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 rounded-[3px] focus:outline-none focus:ring-0"
                        >
                    </div>

                    <!-- Department -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Department</label>
                        <select
                            v-model="form.department"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.department }"
                        >
                            <option value="">Select Department</option>
                            <option
                                v-for="department in departments"
                                :key="department.id"
                                :value="department.id"
                            >
                                {{ department.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.department" class="text-red-500 text-xs mt-1">
                            {{ form.errors.department }}
                        </div>
                    </div>

                    <!-- Designation -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Designation</label>
                        <select
                            v-model="form.designation"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.designation }"
                        >
                            <option value="">Select Designation</option>
                            <option value="Employee">Employee</option>
                            <option value="Team Lead">Team Lead</option>
                            <option value="Manager">Manager</option>
                            <option value="Senior Manager">Senior Manager</option>
                        </select>
                        <div v-if="form.errors.designation" class="text-red-500 text-xs mt-1">
                            {{ form.errors.designation }}
                        </div>
                    </div>

                    <!-- Reporting Manager -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Reporting Manager</label>
                        <select
                            v-model="form.reporting_manager"
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                            :class="{ 'border-red-500': form.errors.reporting_manager }"
                        >
                            <option value="">Select Manager</option>
                            <option value="William Johns">William Johns</option>
                            <option value="George Clark">George Clark</option>
                            <option value="David Wilson">David Wilson</option>
                            <option value="Sophia Clark">Sophia Clark</option>
                        </select>
                        <div v-if="form.errors.reporting_manager" class="text-red-500 text-xs mt-1">
                            {{ form.errors.reporting_manager }}
                        </div>
                    </div>

                    <!-- Shift Start Time -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Shift Start Time</label>
                        <input
                            v-model="form.shift_start_time"
                            type="time"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.shift_start_time }"
                        >
                        <div v-if="form.errors.shift_start_time" class="text-red-500 text-xs mt-1">
                            {{ form.errors.shift_start_time }}
                        </div>
                    </div>

                    <!-- Shift End Time -->
                    <div class="flex flex-col gap-1">
                        <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Shift End Time</label>
                        <input
                            v-model="form.shift_end_time"
                            type="time"
                            class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                            :class="{ 'border-red-500': form.errors.shift_end_time }"
                        >
                        <div v-if="form.errors.shift_end_time" class="text-red-500 text-xs mt-1">
                            {{ form.errors.shift_end_time }}
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="w-full flex justify-end gap-2 py-4 mt-4">
                    <button
                        type="submit"
                        class="w-full text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="isSubmitting || form.processing"
                    >
                       <span v-if="isSubmitting" class="flex items-center justify-center gap-2">
                            <i class="fas fa-spinner fa-spin"></i>
                            {{ isEditing ? 'Updating...' : 'Creating...' }}
                        </span>
                        <span v-else>
                            {{ isEditing ? 'Update Employee' : 'Create Employee' }}
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped>
/* Optional: Add custom styles for select dropdowns arrow */
select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Disable default browser styling for number input spinners */
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}

/* Custom styling for date and time inputs */
input[type='date'],
input[type='time'] {
    position: relative;
}

input[type='date']::-webkit-calendar-picker-indicator,
input[type='time']::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>

