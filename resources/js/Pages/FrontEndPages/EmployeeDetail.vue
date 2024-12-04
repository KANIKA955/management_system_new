<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
const activeTab = ref(1); // Default to the first tab
const { props } = usePage();


// Ref for toggling the form visibility
const showBreakDurationTable = ref(false);

// Function to toggle form visibility
const toggleShowBreakDurationTable = () => {
    showBreakDurationTable.value = !showBreakDurationTable.value;
};
const employeeDetailsNavToggle = () => {
    document.getElementById('employeeDetailsNavDiv').classList.toggle('hidden')
};
</script>



<template>
    <AppLayout title="Employee">
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Employee Details <span class="text-lg text-primary dark:text-info">CR012M</span> </span>
                <a :href="route('employeeList')" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
        <div  class="mt-6 w-full rounded-[10px]">
            <div class="w-full flex lg:flex-row md:flex-row sm:flex-row flex-col gap-4">
                <!-- Sidebar -->
                <div class="lg:w-[300px] md:w-[300px] sm:w-[300px] w-full h-max bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-sm flex flex-col">
                    <div class="lg:hidden md:hidden sm:hidden flex justify-end p-1">
                        <button @click="employeeDetailsNavToggle" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <div id="employeeDetailsNavDiv" class="lg:flex md:flex sm:flex flex-col hidden ">
                        <!-- Tab 1 -->
                        <div
                            @click="activeTab = 1"
                            :class="activeTab === 1 ? 'bg-primary dark:bg-info/50 text-light font-semibold' : 'text-dark dark:text-light font-normal hover:bg-primary/10 hover:dark:bg-info/10'"
                            class="w-full py-2 px-4 border-b-[1px] border-dark/20 dark:border-light/20 text-md cursor-pointer  transition ease-in duration-2000 rounded-t-sm"
                        >
                            <span>Personal Information</span>
                        </div>
                        <!-- Tab 2 -->
                        <div
                            @click="activeTab = 2"
                            :class="activeTab === 2 ? 'bg-primary dark:bg-info/50 text-light font-semibold' : 'text-dark dark:text-light font-normal hover:bg-primary/10 hover:dark:bg-info/10'"
                            class="w-full py-2 px-4 border-b-[1px] border-dark/20 dark:border-light/20 text-md cursor-pointer  transition ease-in duration-2000"
                        >
                            <span>Contact Information</span>
                        </div>
                        <!-- Tab 3 -->
                        <div
                            @click="activeTab = 3"
                            :class="activeTab === 3 ? 'bg-primary dark:bg-info/50 text-light font-semibold' : 'text-dark dark:text-light font-normal hover:bg-primary/10 hover:dark:bg-info/10'"
                            class="w-full py-2 px-4 border-b-[1px] border-dark/20 dark:border-light/20 text-md cursor-pointer  transition ease-in duration-2000"
                        >
                            <span>Professional Information</span>
                        </div>
                        <!-- Tab 4 -->
                        <div
                            @click="activeTab = 4"
                            :class="activeTab === 4 ? 'bg-primary dark:bg-info/50 text-light font-semibold' : 'text-dark dark:text-light font-normal hover:bg-primary/10 hover:dark:bg-info/10'"
                            class="w-full py-2 px-4 text-md cursor-pointer  transition ease-in duration-2000 rounded-b-sm"
                        >
                            <span>Login/Break Information</span>
                        </div>
                    </div>

                </div>

                <!-- Content Area -->
                <div class="grow bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-sm p-4">
                    <!-- Tab 1 Content -->
                    <div v-if="activeTab === 1" class="w-full">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Personal Information</span>
                        </div>
                        <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">First Name</label>
                                <input type="text" value="John" placeholder="Employee first name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Middle Name</label>
                                <input type="text" value="Willson" placeholder="Employee middle name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Last Name</label>
                                <input type="text" value="Morison" placeholder="Employee last name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Father Name</label>
                                <input type="text" value="William Smith" placeholder="Father name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Mother Name</label>
                                <input type="text" value="Enna William" placeholder="Father name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Date of Birth</label>
                                <input type="date" value="1987-10-30" class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 ">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Gender</label>
                                <select
                                    class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                                    <option value="">--Select Gender--</option>
                                    <option value="male" selected>Male</option>
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
                                    <option value="female" selected>Married</option>
                                    <option value="other">Divorced</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Blood Group</label>
                                <select
                                    class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                                    <option value="">--Select--</option>
                                    <option value="A+">A+</option>
                                    <option value="A-" selected>A-</option>
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
                                <input type="text" value="--no--" placeholder="Any disability..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">City</label>
                                <input type="text" value="London" placeholder="City..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Country</label>
                                <input type="text" value="United Kingdom" placeholder="Country..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                            </div>

                            <div class="w-full flex  justify-end gap-2  py-4 mt-4 lg:col-span-3 md:col-span-3 sm:col-span-2">
                                <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Edit Info </button>
                            </div>
                        </div>
                    </div>
                    <!-- Tab 2 Content -->
                    <div v-if="activeTab === 2" class="w-full">
                        <div class="mb-6">
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

                            <div class="w-full flex  justify-end gap-2  py-4 mt-4 lg:col-span-3 md:col-span-3 sm:col-span-2">
                                <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Edit Info </button>
                            </div>
                        </div>
                    </div>
                    <!-- Tab 3 Content -->
                    <div v-if="activeTab === 3" class="w-full">
                        <div class="mb-6">
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

                            <div class="w-full flex  justify-end gap-2  py-4 mt-4 lg:col-span-3 md:col-span-3 sm:col-span-2">
                                <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Edit Info </button>
                            </div>
                        </div>
                    </div>
                    <!-- Tab 4 Content -->
                    <div v-if="activeTab === 4" class="w-full">
                        <div class="mb-6">
                            <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Login/ Break Information</span>
                        </div>
                        <div class="mt-2 w-full bg-light dark:bg-darkTrans flex flex-col justify-between overflow-x-auto">
                            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                                <tr class="bg-lightTrans dark:bg-dark">
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.No.</th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DATE</th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">LOGIN TIME</th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">LOGOUT TIME</th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">TOTAL HOURS</th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">BREAK TIME</th>
                                </tr>

                                <tr @click="toggleShowBreakDurationTable()" class=" cursor-pointer">
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>1</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold cursor-pointer text-primary dark:text-info">10/10/2020</span>
                                        </div>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>10:00AM</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>05:00PM</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>7 Hours</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>1 Hour 15 Minutes</p>
                                    </th>

                                </tr>
                                <tr @click="toggleShowBreakDurationTable()" class="bg-lightTrans/40 dark:bg-dark/40 cursor-pointer">
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>2</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold cursor-pointer text-primary dark:text-info">11/10/2020</span>
                                        </div>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>10:00AM</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>05:00PM</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>7 Hours</p>
                                    </th>
                                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                        <p>1 Hour</p>
                                    </th>

                                </tr>
                            </table>



<!--                            break duration table starts here-->
                            <div v-if="showBreakDurationTable" class="w-full mt-8">
                                <span class="font-semibold text-dark/80 dark:text-light/80">Break Duration: <span class="italic">10/10/2024</span></span>
                                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                                    <tr class="bg-lightTrans dark:bg-dark">
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.No.</th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">START TIME</th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">END TIME</th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">BREAK DURATION</th>
                                    </tr>

                                    <tr class="">
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>1</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>10:00AM</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>11:00AM</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>1 Hour</p>
                                        </th>

                                    </tr>
                                    <tr class="bg-lightTrans/40 dark:bg-dark/40">
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>2</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>01:00PM</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>01:15PM</p>
                                        </th>
                                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                            <p>15 Minutes</p>
                                        </th>

                                    </tr>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>





            </div>
    </AppLayout>
</template>
