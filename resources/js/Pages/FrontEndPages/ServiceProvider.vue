<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const providers = props.providers;

// Ref for toggling the form visibility
const isFormVisible = ref(false);

// Function to toggle form visibility
const createNewClientForm = () => {
    isFormVisible.value = !isFormVisible.value;
};
</script>



<template>
    <AppLayout title="Provider">
        <!--       heading and create/edit provider form div here-->
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Service Providers</span>
                <button v-show="!isFormVisible" @click="createNewClientForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    Add New Provider
                </button>
                <button v-show="isFormVisible" @click="createNewClientForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">
                    <i class=" fa fa-xmark"></i>
                </button>
            </div>

            <div v-if="isFormVisible" class="mt-6 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
                <div class="w-full grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">First Name</label>
                        <input type="text"  placeholder="provider first name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Middle Name</label>
                        <input type="text"  placeholder="provider middle name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Last Name</label>
                        <input type="text"  placeholder="provider last name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
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

                <div class="w-full flex  justify-end gap-2  py-4 mt-4">
                    <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Create New Provider </button>
                    <button @click="createNewClientForm()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
                </div>
            </div>



        </div>
        <!--        provider list table div here-->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DATE OF SIGNUP</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">EMAIL</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">MOBILE NUMBER</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">COMMUNICATION HISTORY</th>
                </tr>
                <tr v-for="(provider, index) in providers" :key="provider.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ index + 1 }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ provider.name }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ provider.date_of_signup }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ provider.email }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ provider.mobile }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <a :href="route('chats')">
                            <button type="button" class="px-2 flex items-center gap-2 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa-regular fa-eye text-md"></i> Communication History
                            </button>
                        </a>


                    </td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>
