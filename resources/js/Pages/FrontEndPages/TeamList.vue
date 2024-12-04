<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const teams = props.teams;

// Ref for toggling the form visibility
const isFormVisible = ref(false);
const isTeamMembersTableVisible = ref(false);

// Function to toggle form visibility
const createTeamFrom = () => {
    isFormVisible.value = !isFormVisible.value;
};
const showTeamMemberTable = () => {
    isTeamMembersTableVisible.value = !isTeamMembersTableVisible.value;
};
</script>



<template>
    <AppLayout title="Teams">

<!--        heading and create/edit team form div -->
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Team</span>
                <button v-show="!isFormVisible" @click="createTeamFrom()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    Add New Team
                </button>
                <button v-show="isFormVisible" @click="createTeamFrom()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class=" fa fa-xmark"></i>
                </button>
            </div>

            <div v-if="isFormVisible" class="mt-6 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6 ">
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Team Name</label>
                    <input type="text" placeholder="Team name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Team Description</label>
                    <input type="text" placeholder="Team description..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department</label>
                    <select
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                        <option value="">--Select Department--</option>
                        <option value="customer_care">Customer Care</option>
                        <option value="accountant">Accountant</option>
                        <option value="technical">Technical</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Members</label>
                    <select
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                        <option value="">--Select members--</option>
                        <option value="">John Doe</option>
                        <option value="">Jane Smith</option>
                        <option value="">Michael Johnson</option>
                        <option value="">Emily Davis</option>
                        <option value="">Chris Lee</option>
                        <option value="">Jessica Brown</option>
                    </select>
                </div>

                <div class="w-full flex  justify-end gap-2  py-4 mt-4 lg:col-span-4 md:col-span-3 sm:col-span-2">
                    <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Create New Team </button>
                    <button @click="createTeamFrom()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
                </div>
            </div>

        </div>

<!--        team list table div here-->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESCRIPTION</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DEPARTMENT</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">MEMBERS</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                </tr>
                <tr v-for="(teams, index) in teams" :key="teams.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ index + 1 }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ teams.name }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ teams.description }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ teams.department }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex pl-2">
                            <div @click="showTeamMemberTable()" class="h-8 w-8 rounded-full border-[2px] border-primary/70 dark:border-info/70 bg-light text-sm dark:bg-darkTrans text-primary dark:text-info font-semiold hover:scale-110 transition ease-in duration-2000 cursor-pointer flex justify-center items-center -ml-2">
                                <span>
                                    {{teams.members.length}}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex">
                            <button @click="createTeamFrom()" class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Delete">
                                <i class="fa-regular fa-trash-can text-md"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

<!--        members list in a particular team div here-->
        <div class="mt-6" v-if="isTeamMembersTableVisible">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between px-4 py-2">
                <span class="text-md font-bold text-dark/80 dark:text-light/80">Members in Team A</span>
                <button  @click="showTeamMemberTable()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class=" fa fa-xmark"></i>
                </button>
            </div>
            <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">


                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                    <tr class="bg-lightTrans dark:bg-dark">
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">EMAIL</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">PHONE</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ADDRESS</th>
                    </tr>
                    <tr>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>1</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold cursor-pointer">William Smith</span>
                            </div>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>william@gmail.com</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>0123456789</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>London</p>
                        </td>
                    </tr>
                    <tr class="bg-lightTrans/40 dark:bg-dark/40">
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>2</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold cursor-pointer">Jonothon</span>
                            </div>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>jonothon@gmail.com</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>8546256255</p>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <p>UK</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </AppLayout>
</template>
