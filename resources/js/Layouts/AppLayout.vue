<script setup>
import {computed, onBeforeUnmount, onMounted, ref} from 'vue';
import { ModalRoot } from '@inertiaui/modal-vue'
import Sidebar from "@/Components/Sidebar.vue";
import TopBar from "@/TopBar.vue";
import Footer from "@/Components/footer.vue";
import { usePage } from '@inertiajs/vue3'
// import ChatList from '@/Pages/Chats/ChatList.vue';
import Toast from "@/Utils/toast.js";

defineProps({
    title: String,
});
//define page
const $page = usePage();
const notify = () => {
    const toast = $page.props.toast || [];
    if (toast.message) {
        const { type, message } = toast;
        Toast[type](message);
    }
}


const page = usePage()

const user = computed(() => page.props.auth.user)

onMounted(() => {
    notify();
    window.Echo.private('App.Models.User.' + user.value.id)
        .listen('Example', (e) => {
            // fire a browser event
            window.dispatchEvent(new CustomEvent('new-chat', {detail: e}));
        });
})

onBeforeUnmount(() => {
    window.Echo.leave('App.Models.User.' + user.value.id);
})
</script>
<style>
/* Custom Scrollbar - Hidden by Default */
::-webkit-scrollbar {
    width: 0px;
}
</style>
<template>
    <body style="font-family: Public Sans;" class="bg-lightTrans dark:bg-dark h-[100vh] overflow-hidden relative w-full flex ">
    <Sidebar />
    <div class=" h-screen overflow-y-auto grow pb-12">
     <TopBar/>
      <div class="w-full xl:px-4 p-2">
            <main>
                <slot />
            </main>
<!--          <ChatList />-->
        </div>
    </div>
    <Footer/>


    <div id="searchModel" class="absolute top-0 lg:pt-0 md:pt-0 sm:pt-0 pt-64 pb-40 left-0 w-full h-screen overflow-y-auto bg-dark/40 dark:bg-dark/90 z-50 flex justify-center items-center hidden">
        <div class="lg:w-[600px] md:w-[500px] sm:w-[500px] w-[300px] bg-light dark:bg-darkTrans rounded-[10px] shadow-lg shadow-dark/20 dark:shadow-dark">
            <div class="w-full p-4 border-b-[1px] border-b-dark/20 dark:border-b-light/20 flex justify-between gap-2">
                <div class="grow flex items-center text-dark/80 dark:text-light/80 gap-2">
                    <i class="fa fa-search cursor-pointer hover:scale-1100"></i>
                    <input type="text" class="w-full bg-light border-0 dark:bg-darkTrans focus:border-0 focus:outline-none focus:ring-0 text-xs" placeholder="Search.....">
                </div>
                <div class="flex items-center text-dark/80 dark:text-light/80 gap-4">
                    <span class="text-xs">[ESC]</span>
                    <i class="fa fa-xmark cursor-pointer hover:scale-110 transition ease-in duration-2000"
                       onclick="document.getElementById('searchModel').classList.toggle('hidden')"></i>
                </div>
            </div>

            <div class="w-full p-8 grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-x-2 gap-y-8">
                <div class="w-full flex flex-col">
                    <span class="text-xs font-semibold text-dark/50 dark:text-light/50"> POPULAR SEARCHES</span>
                    <div class="flex flex-col mt-4 gap-3">
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-house mr-1"></i>
                            View Dashboard
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-chart-simple mr-1"></i>
                            Show Analytics
                        </a>
                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <span class="text-xs font-semibold text-dark/50 dark:text-light/50">APP & PAGES</span>
                    <div class="flex flex-col mt-4 gap-3">
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-users mr-1"></i>
                            Create Users
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-file mr-1"></i>
                            Download Reports
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-envelope mr-1"></i>
                            Check Emails
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-comment mr-1"></i>
                            Live Chat
                        </a>
                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <span class="text-xs font-semibold text-dark/50 dark:text-light/50">OTHERS</span>
                    <div class="flex flex-col mt-4 gap-3">
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-headphones mr-1"></i>
                            Support
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-phone mr-1"></i>
                            Contact Us
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-message mr-1"></i>
                            Query
                        </a>

                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <span class="text-xs font-semibold text-dark/50 dark:text-light/50">SETTINGS</span>
                    <div class="flex flex-col mt-4 gap-3">
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-user mr-1"></i>
                            View Profile
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-key mr-1"></i>
                            Update Password
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa-regular fa-edit mr-1"></i>
                            Update Details
                        </a>
                        <a href="" class="text-md text-dark/90 dark:text-light/90 hover:text-danger dark:hover:text-info transition ease-in duration-2000">
                            <i class="fa fa-right-from-bracket mr-1"></i>
                            Logout
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
</template>
