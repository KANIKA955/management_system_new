<template>
    <div class="bg-[#0009] xl:w-max w-0 h-screen overflow-y-auto shadow-lg shadow-dark/20 xl:static absolute top-0 left-0 z-20"
         id="SideBar">
        <div :class="[
            'bg-lightTrans dark:bg-darkTrans relative min-h-screen pt-2 transition-all duration-300',
            collapsed ? 'w-16' : 'w-[260px]'
        ]" id="navlistDiv">
            <div class="bg-lightTrans dark:bg-darkTrans w-full flex justify-between items-center h-12 sticky top-0 py-4">
                <div class="flex items-center text-dark dark:text-light gap-4 pl-2">
                    <div class="h-10 w-10 flex items-center justify-center text-dark/90 dark:text-light/90">
                        <svg class="w-8" viewBox="0 0 34 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M0.00183571 0.3125V7.59485C0.00183571 7.59485 -0.141502 9.88783 2.10473 11.8288L14.5469 23.6837L21.0172 23.6005L19.9794 10.8126L17.5261 7.93369L9.81536 0.3125H0.00183571Z"
                                  fill="currentColor"></path>
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.17969 17.7762L13.3027 3.75173L17.589 8.02192L8.17969 17.7762Z"
                                  fill="#161616"></path>
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.58203 17.2248L14.8129 5.24231L17.6211 8.05247L8.58203 17.2248Z"
                                  fill="#161616"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.25781 17.6914L25.1339 0.3125H33.9991V7.62657C33.9991 7.62657 33.8144 10.0645 32.5743 11.3686L21.0179 23.6875H14.5487L8.25781 17.6914Z"
                                  fill="currentColor"></path>
                        </svg>
                    </div>
                    <div :class="['overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                        <span class="font-bold text-2xl">App Name</span>
                    </div>
                </div>
                <div class="xl:flex hidden">
                    <div class="text-dark dark:text-light overflow-x-hidden cursor-pointer justify-end"
                         @click="collapseSideBar">
                        <div v-if="!collapsed">
                            <i class="fa fa-caret-left"></i>
                        </div>
                        <div v-else>
                            <i class="fa fa-caret-right"></i>
                        </div>
                    </div>
                </div>
                <div class="text-dark/80 dark:text-light/80 text-xl xl:hidden flex ml-4"
                     @click="toggleMobileSidebar">
                    <i class="fa fa-xmark"></i>
                </div>
            </div>
            <div class="w-full flex flex-col py-2 px-2 pb-12">
                <!-- Menu items -->
                <div :class="['overflow-x-hidden w-full text-dark/30 dark:text-light/30 mb-1 mt-4 transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                    <span class="text-[13px] font-[600] ml-2">DASHBOARD</span>
                </div>
                <Link :href="route('dashboard')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('dashboard') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa fa-house"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Dashboard</span>
                        </div>
                    </div>
                </Link>

                <div :class="['overflow-x-hidden w-full text-dark/30 dark:text-light/30 mb-1 mt-4 transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                    <span class="text-[13px] font-[600] ml-2">TEAM & TASK</span>
                </div>
                <Link :href="route('employees.index')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('employeeList') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa fa-person"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Employees</span>
                        </div>
                    </div>
                </Link>
                <Link :href="route('departments.index')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('departments.index') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa fa-database"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Departments</span>
                        </div>
                    </div>
                </Link>
                <Link :href="route('teams.index')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('teams.show') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa fa-people-group"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Teams</span>
                        </div>
                    </div>
                </Link>
                <Link :href="route('task')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('task') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa fa-clipboard-check"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Tasks</span>
                        </div>
                    </div>
                </Link>

                <div :class="['overflow-x-hidden w-full text-dark/30 dark:text-light/30 mb-1 mt-4 transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                    <span class="text-[13px] font-[600] ml-2">CLIENTS</span>
                </div>
                <Link :href="route('clients')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('clients') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Clients</span>
                        </div>
                    </div>
                </Link>
                <Link :href="route('serviceProvider')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('serviceProvider') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Service Provider</span>
                        </div>
                    </div>
                </Link>
                <Link :href="route('chats.index')">
                    <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('chats.index') }
                    ]">
                        <div class="h-10 w-10 flex items-center justify-center">
                            <i class="fa-regular fa-message"></i>
                        </div>
                        <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                            <span class="text-[15px] font-[500]">Chats</span>
                        </div>
                    </div>
                </Link>



                <div :class="['overflow-x-hidden w-full text-dark/30 dark:text-light/30 mb-1 mt-4 transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                    <span class="text-[13px] font-[600] ml-2">ROLES & PERMISSIONS</span>
                </div>
                <div class="group">
                    <div
                        class="w-full text-dark/90 dark:text-light/90  group-hover:bg-darkTrans/10 dark:group-hover:bg-lightTrans/10 hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex flex-col px-2 rounded-[7px] mb-1">
                        <div class="w-full flex items-center">
                            <div class=" h-10 w-10 flex items-center justify-center">
                                <i class="fa fa-lock"></i>
                            </div>
                            <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                                <span class="text-[15px] font-[500]">Users & Roles</span>
                                <span class="text-[15px] font-[500]"><i class="fa fa-chevron-down"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-max hidden group-hover:flex flex-col">
                        <Link :href="route('roles.index')">
                            <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex pl-6 pr-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('roles.index') }
                    ]">
                                <div class="h-10 w-10 flex items-center justify-center">
                                    <i class="fa-regular fa-circle text-xs"></i>
                                </div>
                                <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                                    <span class="text-[15px] font-[500]">Roles</span>
                                </div>
                            </div>
                        </Link>
                        <Link :href="route('users.index')">
                            <div :class="[
                        'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex pl-6 pr-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                        { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('users.index') }
                    ]">
                                <div class="h-10 w-10 flex items-center justify-center">
                                    <i class="fa-regular fa-circle text-xs"></i>
                                </div>
                                <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                                    <span class="text-[15px] font-[500]">Users</span>
                                </div>
                            </div>
                        </Link>
                    </div>

                    <div :class="['overflow-x-hidden w-full text-dark/30 dark:text-light/30 mb-1 mt-4 transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                        <span class="text-[13px] font-[600] ml-2">REPORTS</span>
                    </div>

                    <div class="group">
                        <div class="w-full text-dark/90 dark:text-light/90 group-hover:bg-darkTrans/10 dark:group-hover:bg-lightTrans/10 hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex flex-col px-2 rounded-[7px] mb-1">
                            <div class="w-full flex items-center">
                                <div class="h-10 w-10 flex items-center justify-center">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex justify-between']">
                                    <span class="text-[15px] font-[500]">Reports</span>
                                    <span class="text-[15px] font-[500]">
                    <i class="fa fa-chevron-down"></i>
                </span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-max hidden group-hover:flex flex-col">
                            <!-- Break Report Link -->
                            <Link :href="route('report.break.index')">
                                <div :class="[
                'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex pl-6 pr-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('report.break.index') }
            ]">
                                    <div class="h-10 w-10 flex items-center justify-center">
                                        <i class="fa-regular fa-circle text-xs"></i>
                                    </div>
                                    <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                                        <span class="text-[15px] font-[500]">Break Report</span>
                                    </div>
                                </div>
                            </Link>

                            <!-- Team Report Link -->
                            <Link :href="route('report.teams.members')">
                                <div :class="[
                'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex pl-6 pr-2 items-center rounded-[7px] mb-1 text-dark/80 dark:text-light/80',
                { 'bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80': route().current('report.teams.members') }
            ]">
                                    <div class="h-10 w-10 flex items-center justify-center">
                                        <i class="fa-regular fa-circle text-xs"></i>
                                    </div>
                                    <div :class="['grow-1 overflow-x-hidden transition-all duration-300', collapsed ? 'w-0 hidden' : 'w-full flex']">
                                        <span class="text-[15px] font-[500]">Team Report</span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
});

const collapsed = ref(JSON.parse(localStorage.getItem('sidebarCollapsed')) || false);

const collapseSideBar = () => {
    collapsed.value = !collapsed.value;
};

watch(collapsed, (newValue) => {
    localStorage.setItem('sidebarCollapsed', JSON.stringify(newValue));
});

onMounted(() => {
    const sideBar = document.getElementById('SideBar');
    if (collapsed.value) {
        sideBar.classList.add('collapsed');
    } else {
        sideBar.classList.remove('collapsed');
    }
});

const toggleMobileSidebar = () => {
    const sideBar = document.getElementById('SideBar');
    sideBar.classList.toggle('w-0');
    sideBar.classList.toggle('w-full');
};
</script>

