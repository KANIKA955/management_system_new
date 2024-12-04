<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const tasks = props.tasks;
</script>



<template>
    <AppLayout title="Employee">
        <!--       heading and create/edit task form div here-->
        <div class="flex flex-col py-2">
            <div class="w-full  bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Tasks</span>
            </div>
        </div>
        <!--        task list table div here-->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DATE</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">CLIENT NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">MOBILE NUMBER</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESCRIPTION</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ASSIGN TO</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ASSIGNED TO </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">STATUS</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ATTACHMENTS</th>
                </tr>
                <tr v-for="(task, index) in tasks" :key="task.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ index + 1 }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ task.date }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ task.client_name }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ task.mobile_number }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ task.description }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <select
                            class="w-[200px] px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans">
                            <option value="">--Select employee--</option>
                            <option value="James" :selected="task.assigned_to === 'James'">James</option>
                            <option value="William" :selected="task.assigned_to === 'William'">William</option>
                            <option value="Robort" :selected="task.assigned_to === 'Robort'">Robort</option>
                            <option value="Alice" :selected="task.assigned_to === 'Alice'">Alice</option>
                            <option value="John" :selected="task.assigned_to === 'John'">John</option>
                            <option value="Emily" :selected="task.assigned_to === 'Emily'">Emily</option>
                            <option value="David" :selected="task.assigned_to === 'David'">David</option>
                            <option value="Sophia" :selected="task.assigned_to === 'Sophia'">Sophia</option>
                            <option value="Michael" :selected="task.assigned_to === 'Michael'">Michael</option>
                            <option value="Sarah" :selected="task.assigned_to === 'Sarah'">Sarah</option>

                        </select>
                    </td>

                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <template v-if="task.assigned_to">
                            <p>{{ task.assigned_to }}</p>
                        </template>
                        <template v-else>
                            <p>-</p>
                        </template>
                    </td>

                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <button :class="{'bg-danger/20 text-danger': task.status === 'pending', 'bg-warning/20 text-warning': task.status === 'incomplete', 'bg-success/20 text-success': task.status === 'complete'}" class="px-2 rounded-sm">
                            {{ task.status.charAt(0).toUpperCase() + task.status.slice(1) }}
                        </button>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <a :href="'/assets/images/loginBg.jpg'" target="_blank">
                            <button type="button" class="px-2 flex items-center gap-2 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                                <i class="fa-regular fa-eye text-md"></i> Attachment
                            </button>
                        </a>


                    </td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>
