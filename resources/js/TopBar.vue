<script setup>
import {ref, onMounted, reactive, watch, computed,} from 'vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import BreakInfo from '@/components/BreakInfo.vue';
import {router} from "@inertiajs/vue3";

const showNotifications = ref(false);
const showProfile = ref(false);
const isDarkMode = ref(false);

const isBreakActive = ref(false);
const isPaused = ref(false); // New state for tracking pause
const breakTime = ref(60 * 60); // 60 minutes in seconds
const emit = defineEmits(['Started', 'Ended']);
let timerInterval = null;

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
    showProfile.value = false;
};

const toggleProfile = () => {
    showProfile.value = !showProfile.value;
    showNotifications.value = false;
};

const toggleSidebar = () => {
    const sidebar = document.getElementById('SideBar');
    sidebar.classList.toggle('w-0');
    sidebar.classList.toggle('w-full');
};

const toggleSearch = () => {
    const searchModel = document.getElementById('searchModel');
    searchModel.classList.toggle('hidden');
};

const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    updateTheme();
};

const updateTheme = () => {
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

const start = () => {
    if (!isBreakActive.value || isPaused.value) {
        isBreakActive.value = true;
        isPaused.value = false;
        emit('breakStarted', new Date()); // Emit break start event

        // Start countdown timer
        timerInterval = setInterval(() => {
            if (breakTime.value > 0) {
                breakTime.value -= 1;
            } else {
                end(); // Automatically end the break when the timer reaches 0
            }
        }, 1000);
    }
};

// Pause break
const pauseBreak = () => {
    isPaused.value = true;
    clearInterval(timerInterval); // Stop timer without resetting time
    emit('breakPaused', new Date()); // Emit break paused event
};

// End break
const end = () => {
    isBreakActive.value = false;
    isPaused.value = false;
    clearInterval(timerInterval);
    emit('breakEnded', new Date()); // Emit break end event

    // Reset break time to 1 hour for the next break
    breakTime.value = 60 * 60; // 60 minutes (1 hour)
};

// Format time as HH:MM:SS
const formatTime = (seconds) => {
    const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
    const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    return `${h}:${m}:${s}`;
};
// Computed property to display formatted time
const formattedTimeLeft = computed(() => formatTime(breakTime.value));


onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    isDarkMode.value = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
    updateTheme();
});


const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

</script>


<template>
    <div class="w-full xl:p-4 p-2 sticky top-0 bg-lightTrans dark:bg-dark">
    <div class="w-full px-4 bg-light dark:bg-darkTrans py-2 flex justify-between rounded-[7px] shadow-lg shadow-darkTrans/10">

    <div class="w-max flex items-center gap-6">
                <div class="text-dark/80 dark:text-light/80 text-lg xl:hidden flex" @click="toggleSidebar">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="lg:flex md:flex sm:flex hidden items-center gap-4 cursor-pointer text-dark/80 dark:text-light/80 text-lg" @click="toggleSearch">
                    <i class="fa fa-search"></i>
                    <span class="text-md lg:block md:block hidden">Search......</span>
                    <span class="text-xs">[Ctrl + K]</span>
                </div>
            </div>
            <div class="w-max flex items-center">

<!--                    break time reminder code here-->
                <div v-if="isBreakActive" class="bg-success/80 text-sm px-4 py-0.5 rounded-[3px] text-dark dark:text-light mr-2">
                    <span>{{ formatTime(breakTime) }}</span>
                </div>

                <!-- Start/Pause Button Logic -->
                <button v-if="!isBreakActive" @click="start" class="bg-primary/80 text-sm px-4 py-1 rounded-[3px] text-light mr-2">
                    Start Break
                </button>
                <button v-else-if="!isPaused" @click="pauseBreak" class="bg-warning/80 text-sm px-4 py-1 rounded-[3px] text-light mr-2">
                    Pause
                </button>
                <button v-else @click="start" class="bg-primary/80 text-sm px-4 py-1 rounded-[3px] text-light mr-2">
                    Resume
                </button>


                <div @click="toggleTheme" class="text-dark/80 dark:text-light/80 text-lg cursor-pointer h-10 w-10 rounded-full flex justify-center items-center hover:bg-dark/10 hover:dark:bg-light/10 transition ease-in duration-2000">
                    <div v-if="!isDarkMode">
                        <i class="fa-regular fa-lightbulb"></i>
                    </div>
                    <div v-else>
                        <i class="fa fa-moon"></i>
                    </div>
                </div>

                <div class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative h-10 w-10 rounded-full flex justify-center items-center hover:bg-dark/10 hover:dark:bg-light/10 transition ease-in duration-2000" @click="toggleNotifications">
                    <i class="fa-regular fa-bell"></i>
                    <div class="h-2 w-2 rounded-full absolute right-2 top-2 bg-danger"></div>

                    <div class="absolute top-[100%] lg:right-0 md:right-0 sm:right-0 -right-16 z-50 pt-4" :class="{ 'hidden': !showNotifications }" id="notificationModel">
                        <div class="lg:w-[350px] md:w-[350px] sm:w-[350px] w-[300px] bg-light dark:bg-darkTrans shadow-lg shadow-dark/20 dark:shadow-dark rounded-[7px]">
                            <div
                                class="p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex items-center justify-between gap-2 relative ">
                                <span class="font-[600]">Notifications</span>
                                <i class="fa-regular fa-envelope"></i>
                            </div>

                            <div
                                class="p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex gap-2 pr-2 relative group">
                                <div
                                    class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative w-max h-max">
                                    <img
                                        src="https://images.unsplash.com/photo-1533636721434-0e2d61030955?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="h-10 w-10 rounded-full " alt="">
                                </div>
                                <div class="flex flex-col ">
                                    <span class="text-xs font-[500] text-dark/90 dark:text-light/90">New Message Received</span>
                                    <span
                                        class="text-sm text-dark/60 dark:text-light/60">You have 10 unread messages</span>
                                    <span class="text-xs text-dark/80 dark:text-light/80 mt-2">11 Sug</span>
                                </div>
                                <div
                                    class="h-max w-max absolute right-0 top-0 p-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition ease-in duration-2000">
                                    <i class="fa fa-circle text-[10px]"></i>
                                    <i class="fa fa-xmark text-[15px] text-danger"></i>
                                </div>
                            </div>
                            <div
                                class="p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex gap-2 pr-2 relative group">
                                <div
                                    class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative w-max h-max">
                                    <img
                                        src="https://images.unsplash.com/photo-1641350625112-3b1d73c71418?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="h-10 w-10 rounded-full " alt="">
                                </div>
                                <div class="flex flex-col ">
                                    <span
                                        class="text-xs font-[500] text-dark/90 dark:text-light/90">Payment Received</span>
                                    <span class="text-sm text-dark/60 dark:text-light/60">Received Payment</span>
                                    <span class="text-xs text-dark/80 dark:text-light/80 mt-2">25 May</span>
                                </div>
                                <div
                                    class="h-max w-max absolute right-0 top-0 p-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition ease-in duration-2000">
                                    <i class="fa fa-circle text-[10px] text-success"></i>
                                    <i class="fa fa-xmark text-[15px] text-danger"></i>
                                </div>
                            </div>
                            <div
                                class="p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex gap-2 pr-2 relative group">
                                <div
                                    class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative w-max h-max">
                                    <img
                                        src="https://images.unsplash.com/photo-1533636721434-0e2d61030955?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="h-10 w-10 rounded-full " alt="">
                                </div>
                                <div class="flex flex-col ">
                                    <span class="text-xs font-[500] text-dark/90 dark:text-light/90">New Message Received</span>
                                    <span
                                        class="text-sm text-dark/60 dark:text-light/60">You have 10 unread messages</span>
                                    <span class="text-xs text-dark/80 dark:text-light/80 mt-2">11 Sug</span>
                                </div>
                                <div
                                    class="h-max w-max absolute right-0 top-0 p-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition ease-in duration-2000">
                                    <i class="fa fa-circle text-[10px]"></i>
                                    <i class="fa fa-xmark text-[15px] text-danger"></i>
                                </div>
                            </div>
                            <div class="p-2 pt-4 flex flex-col">
                                <a href="">
                                    <div
                                        class="w-full bg-gradient-to-r from-primary to-primary/90 hover:bg-primary text-light  flex px-2 items-center justify-center rounded-[7px] mb-1 transition ease-in duration-2000">
                                        <div class=" grow-1 overflow-x-hidden ">
                                            <span class="text-[14px] font-[500]">View All Notifications</span>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative ml-2" @click="toggleProfile">
                    <img src="https://images.unsplash.com/photo-1533636721434-0e2d61030955?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="h-10 w-10 rounded-full" alt="">
                    <div class="h-2 w-2 rounded-full absolute right-0 bottom-1 border-[2px] border-light dark:border-dark bg-success"></div>

                    <div class="absolute top-100 right-0 z-50 pt-4" :class="{ 'hidden': !showProfile }" id="profileModel">
                        <div class="w-[250px] bg-light dark:bg-darkTrans shadow-lg shadow-dark/20 dark:shadow-dark rounded-[7px]">
                            <div class="p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex gap-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="text-dark/80 dark:text-light/80 text-lg cursor-pointer relative w-max h-max">
                                    <img :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name" class="h-10 w-10 rounded-full ">
                                    <div class="h-2 w-2 rounded-full absolute right-0 bottom-1 border-[2px] border-light dark:border-dark bg-success"></div>
                                </div>
                                <div class="flex flex-col ">
                                    <span class="text-sm font-semibold text-dark/90 dark:text-light/90">{{ $page.props.auth.user.name }}</span>
                                    <span class="text-xs text-dark/60 dark:text-light/60">{{ $page.props.auth.user.email }}</span>
                                </div>
                            </div>
                            <div class="p-2 flex flex-col border-b-[1px] border-b-dark/20 dark:border-b-light/20">
                                <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                    <div class="h-8 w-8 flex items-center justify-center">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <div :class="['grow-1 overflow-x-hidden transition-all duration-300 w-full flex']">
                                        <span class="text-[15px] font-[500]">Profile</span>
                                    </div>
                                </ResponsiveNavLink>



                                <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">-->
                                    <div class="h-8 w-8 flex items-center justify-center">
                                        <i class="fa-regular fa-token"></i>
                                    </div>
                                    <div :class="['grow-1 overflow-x-hidden transition-all duration-300 w-full flex']">
                                        <span class="text-[15px] font-[500]">API Tokens</span>
                                    </div>
                                 </ResponsiveNavLink>

                            </div>
                            <div class="p-2 pt-4 flex flex-col">
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink as="button">
                                        <div class=" grow-1 overflow-x-hidden ">
                                            <span class="text-[14px] font-[500]">Logout</span>
                                        </div>
                                        <div class=" h-8 w-8 flex items-center justify-center">
                                            <i class="fa fa-right-from-bracket text-[14px]"></i>
                                        </div>
                                    </ResponsiveNavLink>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
