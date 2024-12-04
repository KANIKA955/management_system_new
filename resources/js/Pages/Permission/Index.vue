<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
const props = defineProps({
    permissions: {
        type: Array,
        required: true,
    },
});
</script>


<template>
    <AppLayout title="Roles">
        <div class="flex justify-end py-2">
            <ModalLink :href="route('permissions.create')" :close-explicitly="true"
                       panel-classes="bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark p-4"
                       class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"> Add New Permission
            </ModalLink>
        </div>
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ASSIGNED TO</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">CREATED DATE</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                </tr>
                <tr v-for="(permission, index) in permissions" :key="permission.id" :class="index % 2 === 0 ? 'bg-lightTrans/40 dark:bg-dark/40' : ''">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ permission.name }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <span class="px-2 py-0.5 text-success bg-success/20 rounded-sm text-md font-semibold cursor-pointer">{{ permission.assignedTo }}</span>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ permission.createdDate }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex">
                            <button class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="View">
                                <i class="fa-regular fa-eye text-md"></i>
                            </button>
                            <button class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
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

    </AppLayout>
</template>
