<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const page = usePage();
const roles = ref(page.props.roles);

const refreshRoles = () => {
    router.reload({ only: ['roles'] });
};

watch(() => page.props.roles, (newRoles) => {
    roles.value = newRoles;
}, { deep: true });
</script>

<template>
    <AppLayout title="Roles">
        <div class="flex justify-between gap-1">
            <span class="text-2xl text-dark/80 dark:text-light/80 font-semibold">Roles</span>
            <div>
                <ModalLink :href="route('roles.create')" :close-explicitly="true" @role-created="refreshRoles"
                           panel-classes="bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark p-4"
                           class="bg-primary dark:bg-info text-white px-4 py-2 rounded hover:bg-primary/80"> Add New Role
                </ModalLink>
            </div>
        </div>

        <div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 mt-6">

            <div v-for="role in roles"
                 :key="role.id"
                class="w-full lg:h-52 md:h-52 sm:h-52 h-32 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6">
                <div class="flex justify-between"><span class="text-[13px] font-[600] text-dark/60 dark:text-light/60">Total 7 Users</span>
                    <div class="w-max flex">
                        <div
                            class="h-10 w-10 rounded-full border-[2px] border-dark/50 dark:border-light/70 hover:scale-110 transition ease-in duration-2000 cursor-pointer">
                            <img class="w-full h-full rounded-full object-cover"
                                 src="https://media.istockphoto.com/id/1372281808/photo/woman-face-profile-young-girl-portrait-with-smooth-healthy-skin-model-facial-side-view-over.jpg?s=612x612&amp;w=0&amp;k=20&amp;c=0sycwPGkFcwXL75kdHCy52c2jX7r9qJwPXqS4J3PZb8="
                                 alt=""></div>
                        <div
                            class="h-10 w-10 rounded-full border-[2px] border-dark/50 dark:border-light/70 -ml-4 hover:scale-110 transition ease-in duration-2000 cursor-pointer">
                            <img class="w-full h-full rounded-full object-cover"
                                 src="https://plus.unsplash.com/premium_photo-1673866484792-c5a36a6c025e?fm=jpg&amp;q=60&amp;w=3000&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
                                 alt=""></div>
                        <div
                            class="h-10 w-10 rounded-full border-[2px] border-dark/50 dark:border-light/70 -ml-4 hover:scale-110 transition ease-in duration-2000 cursor-pointer">
                            <img class="w-full h-full rounded-full object-cover"
                                 src="https://plus.unsplash.com/premium_photo-1661866803933-17fc0cf78150?fm=jpg&amp;q=60&amp;w=3000&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZmFjZSUyMHByb2ZpbGV8ZW58MHx8MHx8fDA%3D"
                                 alt=""></div>
                        <div
                            class="h-10 w-10 rounded-full border-[2px] border-dark/50 dark:border-light/70 -ml-4 bg-light text-sm dark:bg-darkTrans text-dark/80 dark:text-light/80 hover:scale-110 transition ease-in duration-2000 cursor-pointer flex justify-center items-center">
                            <span>4+</span></div>
                    </div>
                </div>
                <div class="flex flex-col"><span class="text-[18px] font-[600] text-dark/90 dark:text-light/90">{{ role.name }}</span>
                    <ModalLink :href="route('roles.edit',role)" :close-explicitly="true" #default="{ loading }"
                                  panel-classes="bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark p-4"
                               class="text-[13px] font-[600] text-primary dark:text-info cursor-pointer">
                        <span v-if="loading"><i class="fa fa-spinner animate-spin"></i> <span class="animate-pulse">Loading..</span></span>
                            <span v-else>Edit Role</span>
                        </ModalLink>
                </div>
            </div>

        </div>


        <div class="flex flex-col gap-1 mt-12">
            <span class="text-2xl text-dark/80 dark:text-light/80 font-semibold">Total users with their roles</span>
            <p class="text-dark/80 dark:text-light/80 lg:text-sm md:text-sm sm:text-sm text-xs">Find all of your
                company’s administrator accounts and their associate roles.</p>
        </div>

        <div
            class="mt-6 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-normal">
                        <input type="checkbox"
                               class="rounded-sm text-primary dark:text-info bg-transparent border-[2px] border-dark/30 dark:border-light/30 focus:ring-0 focus:outline-none">
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        USER
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        ROLE
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        PLAN
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        BILLING
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        STATUS
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">
                        ACTION
                    </th>
                </tr>
                <tr>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-normal">
                        <input type="checkbox"
                               class="rounded-sm text-primary dark:text-info bg-transparent border-[2px] border-dark/30 dark:border-light/30 focus:ring-0 focus:outline-none">
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col ">
                            <span class="text-sm font-bold cursor-pointer">Beverlie Krabbe</span>
                            <p class="text-xs ">bkrabbe1d@gmail.com</p>
                        </div>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Editor</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Team</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Manual-Cash</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <span
                            class="px-2 py-0.5 text-success bg-success/20 rounded-sm text-md font-semibold cursor-pointer">Active</span>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex ">
                            <button
                                class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                ttitle="View">
                                <i class="fa-regular fa-eye text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Edit">
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Delete">
                                <i class="fa-regular fa-trash-can text-md"></i>
                            </button>
                        </div>
                    </th>
                </tr>
                <tr class="bg-lightTrans/40 dark:bg-dark/40">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-normal">
                        <input type="checkbox"
                               class="rounded-sm text-primary dark:text-info bg-transparent border-[2px] border-dark/30 dark:border-light/30 focus:ring-0 focus:outline-none">
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col ">
                            <span class="text-sm font-bold cursor-pointer">Beverlie Krabbe</span>
                            <p class="text-xs ">bkrabbe1d@gmail.com</p>
                        </div>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Editor</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Team</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Manual-Cash</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal ">
                        <span
                            class="px-2 py-0.5 text-warning bg-warning/20 rounded-sm text-md font-semibold cursor-pointer">Pending</span>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex ">
                            <button
                                class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                ttitle="View">
                                <i class="fa-regular fa-eye text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Edit">
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Delete">
                                <i class="fa-regular fa-trash-can text-md"></i>
                            </button>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-normal">
                        <input type="checkbox"
                               class="rounded-sm text-primary dark:text-info bg-transparent border-[2px] border-dark/30 dark:border-light/30 focus:ring-0 focus:outline-none">
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col ">
                            <span class="text-sm font-bold cursor-pointer">Beverlie Krabbe</span>
                            <p class="text-xs ">bkrabbe1d@gmail.com</p>
                        </div>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Editor</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Team</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>Manual-Cash</p>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <span
                            class="px-2 py-0.5 text-light/50 bg-light/10 rounded-sm text-md font-semibold cursor-pointer">Inactive</span>
                    </th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex ">
                            <button
                                class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                ttitle="View">
                                <i class="fa-regular fa-eye text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Edit">
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button
                                class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Delete">
                                <i class="fa-regular fa-trash-can text-md"></i>
                            </button>
                        </div>
                    </th>
                </tr>

            </table>
        </div>


    </AppLayout>
</template>
