<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'; // Added nextTick import
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    chatId: String,
    messages: Array,
    permissions: Object,
});

const emit = defineEmits(['sendMessage']);

const fileInput = ref(null);
const chatContainer = ref(null);
const dragging = ref(false);
let dragCounter = 0;

const form = useForm({
    content: '',
    attachment: null
});

const handleDragEnter = (event) => {
    event.preventDefault();
    dragCounter++;
    if (dragCounter === 1) {
        dragging.value = true;
    }
};

const handleDragLeave = (event) => {
    event.preventDefault();
    dragCounter--;
    if (dragCounter === 0) {
        dragging.value = false;
    }
};

const handleDragOver = (event) => {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy';
};

const handleDrop = async (event) => {
    event.preventDefault();
    dragCounter = 0;
    dragging.value = false;

    const file = event.dataTransfer.files[0];
    if (file) {
        emit('sendMessage', {
            content: `Attachment: ${file.name}`,
            attachment: file
        });
    }
};

const sendMessage = () => {
    if (!form.content && !fileInput.value?.files[0]) return;

    emit('sendMessage', {
        content: form.content,
        attachment: fileInput.value?.files[0]
    });

    form.content = '';
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) {
        emit('sendMessage', {
            content: `Attachment: ${file.name}`,
            attachment: file
        });
        event.target.value = '';
    }
};

const scrollToBottom = () => {
    if (chatContainer.value) {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }
};

onMounted(() => {
    scrollToBottom();
});

watch(() => props.messages, () => {
    nextTick(() => {
        scrollToBottom();
    });
}, { deep: true });
</script>
<template>
    <div
        class="grow h-full flex flex-col bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px]"
    >
        <!-- Header -->
        <div class="w-full h-12 px-4 border-b-[1px] border-b-dark/20 dark:border-b-dark">
            <div class="flex items-center h-full justify-between">
                <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">
                    {{ messages[0]?.sender_name }}
                    <span class="font-normal">@{{ chatId }}</span>
                </span>
                <div class="flex gap-4 items-center">
                    <button @click="isTranferChatModelOpen = true" class="text-dark/80 dark:text-light/80">
                        <i class="fa fa-share"></i>
                    </button>
                    <button @click="isChatMediaModelOpen = true" class="text-dark/80 dark:text-light/80">
                        <i class="fa fa-photo-film"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div
            ref="chatContainer"
            id="chatContainer"
            class="flex-1 overflow-y-auto px-4 py-4 relative"
            @dragenter.prevent="handleDragEnter"
            @dragleave.prevent="handleDragLeave"
            @dragover.prevent="handleDragOver"
            @drop.prevent="handleDrop"
        >
            <!-- Drag overlay with transition -->
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="dragging"
                    class="absolute inset-0 bg-dark/20 dark:bg-light/20 flex items-center justify-center z-10"
                >
                    <div class="bg-light dark:bg-dark rounded-lg p-4 shadow-lg">
                        <p class="text-dark/80 dark:text-light/80">Drop file to send</p>
                    </div>
                </div>
            </Transition>

            <template v-for="message in messages" :key="message.id">
                <div :class="[
                    'flex mb-4',
                    message.sender_type === 'client' ? '' : 'justify-end'
                ]">
                    <div :class="[
                        'flex gap-2',
                        message.sender_type === 'client' ? '' : 'flex-row-reverse'
                    ]">
                        <div class="h-12 w-12 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px]">
                            <img class="w-full h-full object-cover rounded-[3px]" :src="message.sender_avatar" alt="">
                        </div>
                        <div class="max-w-[700px] flex flex-col">
                            <!-- Sender name at the top -->
                            <span :class="[
                                'text-xs mb-1',
                                message.sender_type === 'client' ? 'text-left' : 'text-right',
                                'text-dark/60 dark:text-light/60'
                            ]">
                                {{ message.sender_name }}
                            </span>

                            <div class="p-2 rounded-[10px] bg-dark/10 dark:bg-dark">
                                <p class="text-dark/50 dark:text-light/50 text-sm">{{ message.content }}</p>
                                <div v-if="message.attachment" class="mt-2">
                                    <a
                                        :href="message.attachment.url"
                                        class="text-primary dark:text-info text-xs flex items-center gap-1"
                                        target="_blank"
                                    >
                                        <i class="fa fa-paperclip"></i>
                                        {{ message.attachment.filename }}
                                    </a>
                                </div>
                                <div class="flex justify-end">
                                    <p class="text-primary dark:text-info text-xs">{{ message.created_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Input -->
        <div class="w-full h-12 px-2 border-t-[1px] border-t-dark/20 dark:border-t-dark flex items-center">
            <div class="h-10 w-10 flex-shrink-0">
                <label class="h-10 w-10 rounded-full cursor-pointer flex items-center justify-center text-dark/80 dark:text-light/80 hover:bg-dark/10 hover:dark:bg-light/10">
                    <i class="fa fa-paperclip"></i>
                    <input
                        ref="fileInput"
                        type="file"
                        class="hidden"
                        @change="handleFileSelect"
                    >
                </label>
            </div>

            <input
                v-model="form.content"
                type="text"
                @keyup.enter="sendMessage"
                placeholder="Type a message...."
                class="w-full px-2 focus:border-0 focus:outline-none focus:ring-0 border-0 bg-transparent text-dark/80 dark:text-light/80"
            >

            <button
                @click="sendMessage"
                class="h-10 w-10 flex-shrink-0 rounded-full flex items-center justify-center text-dark/80 dark:text-light/80 hover:bg-dark/10 hover:dark:bg-light/10"
            >
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</template>
