<script setup>
import {onMounted, ref} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// script for default bottom scroll for the chat box
window.onload = function() {
    var chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;
};


// script to open and close chat box for the page chat section
// (left side all chat and right side particular chat)
const openChat = () => {
    const sideBar = document.getElementById('chatSection');
    sideBar.classList.remove('hidden');
};
const closeChat = () => {
    const sideBar = document.getElementById('chatSection');
    sideBar.classList.add('hidden');
};
// Ref for toggling the form visibility
const isTranferChatModelOpen = ref(false);
const isChatMediaModelOpen = ref(false);

// Function to toggle form visibility
const openTransferChatModel = () => {
    isTranferChatModelOpen.value = !isTranferChatModelOpen.value;
};
const openChatMediaModel = () => {
    isChatMediaModelOpen.value = !isChatMediaModelOpen.value;
};



// script for the drag and drop option for the chat section

// Reactive reference to store the dropped file
const droppedFile = ref(null);

// Drag and drop handler functions
function handleDragOver(event) {
    event.preventDefault(); // Prevent default behavior to allow drop
    event.dataTransfer.dropEffect = 'copy';
}

function handleDrop(event) {
    event.preventDefault(); // Prevent default browser behavior
    const file = event.dataTransfer.files[0]; // Get the first dropped file
    droppedFile.value = file;

    if (file) {
        console.log('File dropped successfully:', file);
    }
}


</script>

<style>
  #messagesModal{
      transition: all ease-in-out 0.5s;
  }
</style>

<template>
    <AppLayout title="Chats">
<!--        this is the code for page chat section -->


<!--        transfer chat model code here-->
        <div v-if="isTranferChatModelOpen"  class="mt-6 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6 mb-6">
            <div class="mb-4">
                <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Transfer Chat</span>
            </div>
            <div class="w-full grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4 ">
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Department</label>
                    <select
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                        <option value="">--Select--</option>
                        <option value="">Customer Care</option>
                        <option value="">Technical</option>
                    </select>

                </div>
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Manager</label>
                    <select
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                        <option value="">--Select--</option>
                        <option value="">James </option>
                        <option value="">William</option>
                    </select>

                </div>
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Employee</label>
                    <select
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
                        <option value="">--Select--</option>
                        <option value="">John Smith </option>
                        <option value="">Robert</option>
                        <option value="">Hammer</option>
                    </select>

                </div>

                <div class="w-full lg:col-span-4 md:col-span-3 sm:col-span-2 flex  justify-end gap-2 py-4 mt-4">
                    <button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Transfer Chat</button>
                    <button @click="openTransferChatModel()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
                </div>

            </div>

        </div>

<!--        show all media right slide over code here-->
        <div v-if="isChatMediaModelOpen"  class="mt-6 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6 mb-6">
            <div class="mb-4">
                <span class="font-semibold text-2xl text-dark/80 dark:text-light/80">Media</span>
            </div>
<!--            <div class="w-full flex gap-2">-->
<!--&lt;!&ndash;                  tab 1 button&ndash;&gt;-->
<!--                  <button class="w-max bg-primary dark:bg-info text-light/80 dark:text-dark/80 px-4 py-1  text-sm rounded-sm  hover:bg-primary hover:dark:bg-info hover:text-light hover:dark:text-dark transition ease-in duration-2000">Photos</button>-->
<!--            </div>-->

             <div class="w-full flex gap-4 flex-wrap mt-4">
                  <div class="w-24 h-24 rounded-md">
                      <img class="w-full h-full object-cover rounded-md" src="/assets/images/loginBg.jpg" alt="">
                  </div>
                 <div class="w-24 h-24 rounded-md">
                     <img class="w-full h-full object-cover rounded-md" src="/assets/images/loginBg.jpg" alt="">
                 </div> <div class="w-24 h-24 rounded-md">
                 <img class="w-full h-full object-cover rounded-md" src="/assets/images/loginBg.jpg" alt="">
             </div> <div class="w-24 h-24 rounded-md">
                 <img class="w-full h-full object-cover rounded-md" src="/assets/images/loginBg.jpg" alt="">
             </div>
             </div>
            <div class="w-full lg:col-span-4 md:col-span-3 sm:col-span-2 flex  justify-end gap-2 py-4 mt-4">
                <button @click="openChatMediaModel()" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>
            </div>

        </div>


        <div class="w-full flex lg:flex-row md:flex-row flex-col gap-4 h-[83vh] ">
            <div class="w-[300px] md:w-[300px] w-full h-full overflow-y-auto  gap-4 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px]">
                 <div class="w-full h-12 p-2  border-b-[1px] border-b-light dark:border-b-dark">
                     <span class="text-lg font-semibold text-black/80 dark:text-light/80">Chats</span>
                 </div>


                <!--add (bg-dark/10 dark:bg-light/10) this class for the active chat in the outer div-->
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                       <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                           <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                            <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                                <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                                <div class="w-full h-full rounded-full bg-success"></div>
                            </div>
                       </div>
                        <div class="grow w-full flex flex-col overflow-hidden">
                            <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                            <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                             <div class="flex justify-end">
                                 <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                             </div>
                        </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 bg-dark/10 dark:bg-light/10 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                       <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                           <img class="w-full h-full object-cover rounded-[3px]" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXNlcnxlbnwwfHwwfHx8MA%3D%3D" alt="">
                            <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                                 <div class="w-full h-full rounded-full bg-dark"></div>
                            </div>
                       </div>
                        <div class="grow w-full flex flex-col overflow-hidden">
                            <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Diksha <span class="font-normal">@ 154diksha</span></span>
                            <p class="truncate text-dark/50 dark:text-light/50 text-sm">Will get back to you soon </p>
                            <div class="flex justify-end">
                                <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                            </div>
                        </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                       <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                           <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                            <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                                 <div class="w-full h-full rounded-full bg-dark"></div>
                            </div>
                       </div>
                        <div class="grow w-full flex flex-col overflow-hidden">
                            <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                            <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                            <div class="flex justify-end">
                                <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                            </div>
                        </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>

                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcg4Y51XjQ-zSf87X4nUPTQzsF83eFdZswTg&s" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <div class="w-full h-full rounded-full bg-dark"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">Ramesh Singh <span class="font-normal">@ rameshsingh</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">June 27, 2024</p>
                        </div>
                    </div>

                </div>
                <div @click="openChat()" class="flex gap-2 p-2 h-20 hover:bg-dark/10 hover:dark:bg-light/10 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000">
                    <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                        <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                        <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                            <!--                 add (bg-success) this class for the online user other wise add (bg-dark)-->

                            <div class="w-full h-full rounded-full bg-success"></div>
                        </div>
                    </div>
                    <div class="grow w-full flex flex-col overflow-hidden">
                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">User Name <span class="font-normal">@ User Id</span></span>
                        <p class="truncate text-dark/50 dark:text-light/50 text-sm">Hello! We currently have tasks available to complete that require your immediate attention. Your expertise and dedication are crucial for its successful completion.</p>
                        <div class="flex justify-end">
                            <p class="truncate text-primary dark:text-info text-xs">Yesterday</p>
                        </div>
                    </div>

                </div>

            </div>
            <div @dragover="handleDragOver"
                 @drop="handleDrop" id="chatSection" class=" lg:static md:static absolute  lg:h-full md:h-full h-full top-0 left-0 grow lg:w-max md:w-max w-full lg:flex md:flex flex-col  hidden gap-4 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px]">
                        <div class="w-full relative">
                            <div class=" w-full h-12 absolute top-0 left-0 px-4 border-b-[1px] border-b-dark/20 dark:border-b-dark">
                                <div class="flex items-center  h-full relative" >
                                    <div class="flex lg:w-full md:w-full w-max lg:flex-row md:flex-row justify-between lg:items-center md:items-center items-start flex-col">
                                        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">John Morison <span class="font-normal">@4656@john</span></span>
                                         <div class="flex gap-4 items-center">
                                             <div @click="openTransferChatModel()"  class="rounded-full overflow-hidden relative flex items-center justify-center text-dark/80 dark:text-light/80  cursor-pointer">
                                                 <i class="fa fa-share"></i>
                                             </div>
                                             <div @click="openChatMediaModel()" class=" rounded-full overflow-hidden relative flex items-center justify-center text-dark/80 dark:text-light/80  cursor-pointer">
                                                 <i class="fa fa-photo-film"></i>
                                             </div>
                                         </div>
                                    </div>

                                    <div @click="closeChat()" class="w-6 lg:hidden md:hidden flex items-center text-lg text-dark/80 dark:text-light/80 cursor-pointer group h-full absolute right-0 top-0">
                                        <i class="fa fa-xmark group-hover:rotate-90 transition ease-in duration-2000 "></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="chatContainer" class="w-full lg:h-full md:h-full  h-[75vh] overflow-y-auto px-4 mt-12 mb-12">

                       <!-- Left side chat -->
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <!-- Right side chat -->
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>

<!--                       remove extra chats-->
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>
                       <div class="flex ">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 ">
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-start gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Hey, how's it going?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:45 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Are you free today?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:46 PM</p>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="flex justify-end mt-2">
                           <div class="lg:w-[80%] md:w-[80%] w-full flex gap-2 justify-end">
                               <div class="lg:w-[700px] md:w-[500px] w-full flex flex-col items-end gap-2">
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">I'm good! Just finishing some work.</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:47 PM</p>
                                       </div>
                                   </div>
                                   <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark ">
                                       <p class=" text-dark/50 dark:text-light/50 text-sm">Maybe later this evening?</p>
                                       <div class="flex justify-end">
                                           <p class="truncate text-primary dark:text-info text-xs">12:48 PM</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                                   <img class="w-full h-full object-cover rounded-[3px]" src="https://www.shutterstock.com/image-photo/head-shot-portrait-close-smiling-600nw-1714666150.jpg" alt="">
                               </div>
                           </div>
                       </div>

                   </div>

                <div class="w-full relative ">
                    <div class=" w-full h-12 absolute bottom-0 left-0 px-2   border-t-[1px] border-t-dark/20 dark:border-t-dark flex items-center justify-between">
                        <div class="flex items-center grow">
                            <div class="h-10 w-10 rounded-full overflow-hidden relative flex items-center justify-center text-dark/80 dark:text-light/80 hover:bg-dark/10 hover:dark:bg-light/10">
                                <i class="fa fa-paperclip"></i>
                                <input type="file" class="absolute top-0 left-0 opacity-0">
                            </div>
                            <input type="text"  placeholder="Type a message...." class="w-full focus:border-0 focus:outline-none focus:ring-0 border-0 bg-transparent text-dark/80 dark:text-light/80">
                        </div>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full overflow-hidden relative flex items-center justify-center text-dark/80 dark:text-light/80 hover:bg-dark/10 hover:dark:bg-light/10">
                                <i class="fa fa-microphone"></i>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </AppLayout>

</template>
