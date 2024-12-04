<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const employees = props.employees;

// Ref for toggling the form visibility
const isFormVisible = ref(false);

// Function to toggle form visibility
const createEmployeeForm = () => {
    isFormVisible.value = !isFormVisible.value;
};
</script>



<template>
    <AppLayout title="Employee">
<!--       heading and create/edit employee form div here-->
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Employee</span>
                <button v-show="!isFormVisible" @click="createEmployeeForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    Add New Employee
                </button>
                <button v-show="isFormVisible" @click="createEmployeeForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                     <i class=" fa fa-xmark"></i>
                </button>
            </div>

            <div v-if="isFormVisible" class="mt-6 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
                <div class="mb-4">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Personal Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">First Name</label>
                        <input type="text"  placeholder="Employee first name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Middle Name</label>
                        <input type="text"  placeholder="Employee middle name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Last Name</label>
                        <input type="text"  placeholder="Employee last name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Father Name</label>
                        <input type="text" placeholder="Father name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Mother Name</label>
                        <input type="text"  placeholder="Father name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Date of Birth</label>
                        <input type="date"  class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 ">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Gender</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select Gender--</option>
                            <option value="male" >Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Martial Status</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select--</option>
                            <option value="male" >Un-married</option>
                            <option value="female" >Married</option>
                            <option value="other">Divorced</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Blood Group</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select--</option>
                            <option value="A+">A+</option>
                            <option value="A-" >A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>

                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Any Disability</label>
                        <input type="text"  placeholder="Any disability..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">City</label>
                        <input type="text"  placeholder="City..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Country</label>
                        <input type="text"  placeholder="Country..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                </div>

                <div class="mb-4 mt-6">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Contact Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Email Id</label>
                        <input type="text" value="john@gmail.com" placeholder="Email id..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Phone</label>
                        <input type="number" value="01781200705" placeholder="Phone..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Mobile Number</label>
                        <input type="number" value="0123456789" placeholder="Mobile number..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Alternate Number</label>
                        <input type="number" value="9876543210" placeholder="Alternate number..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Address</label>
                        <input type="text" value="London" placeholder="Address..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">City</label>
                        <input type="text" value="London" placeholder="City..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Country</label>
                        <input type="text" value="United Kindom" placeholder="Country..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                </div>

                <div class="mb-4 mt-6">
                    <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Professional Information</span>
                </div>
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Employee id</label>
                        <input type="text" value="CR012M" disabled placeholder="Employee id..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select Department--</option>
                            <option value="" >Customer Care</option>
                            <option value="" >Accountant</option>
                            <option value="" selected>Technical</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Designation</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select Designation--</option>
                            <option value="" >Employee</option>
                            <option value="" >Accountant</option>
                            <option value="" selected>Team Lead</option>
                            <option value="" >Manager</option>
                            <option value="" >Senior Accountant</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Reporting Manager</label>
                        <select
                            class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                            <option value="">--Select Manager--</option>
                            <option value="" >William Johns</option>
                            <option value="" >George Clark</option>
                            <option value="" selected>David Wilson</option>
                            <option value="" >Sophia Clark</option>
                            <option value="" >John Adams</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Shift Start Time</label>
                        <input type="time" class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Shift End Time</label>
                        <input type="time" class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                </div>

                <div class="w-full flex  justify-end gap-2  py-4 mt-4">
                    <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Create New Employee </button>
                    <button @click="createEmployeeForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
                </div>
            </div>



        </div>
<!--        employee list table div here-->
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
                        <p>{{ index + 1 }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ employee.employee_id }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ employee.name }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ employee.department }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ employee.designation }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ employee.reporting_manager }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ employee.shift_time }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <button
                            :class="[employee.profile_status === 1 ? 'bg-success' : 'bg-danger', 'text-light px-4 py-1 rounded-full font-semibold']">
                            {{ employee.profile_status === 1 ? 'Active' : 'Inactive' }}
                        </button>
                    </td>


                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex items-center">
                            <a :href="route('employeeDetail')">
                                <button type="button" class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                    <i class="fa-regular fa-eye text-md"></i>
                                </button>
                            </a>

                            <button @click="createEmployeeForm()"  class="h-8 w-8  rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa-regular fa-edit text-md m-auto"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>
