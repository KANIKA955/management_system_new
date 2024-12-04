<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ChatList from './ChatList.vue';
import ChatContent from './ChatContent.vue';

const page = usePage();
const selectedChat = ref(null);
const messages = ref([]);

// Watch for currentChat in props
watch(() => page.props.currentChat, (newChat) => {
    if (newChat) {
        selectedChat.value = newChat.id;
        messages.value = page.props.currentMessages || [];
    }
}, { immediate: true });

const handleChatSelected = (chatId) => {
    router.get(route('chats.index'), {
        chatId: chatId
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['currentChat', 'currentMessages']
    });
};

const handleSendMessage = (data) => {
    router.post(route('chats.messages.store', selectedChat.value), data, {
        onSuccess: () => {
            data.content = '';
            data.attachment = null;
        },
    });
};
</script>

<template>
    <AppLayout title="Chats">
        <div class="w-full flex gap-4 h-[83vh]">
            <ChatList
                :chats="page.props.chats"
                :selected-chat-id="selectedChat"
                @chat-selected="handleChatSelected"
            />

            <ChatContent
                v-if="selectedChat"
                :chat-id="selectedChat"
                :messages="messages"
                :permissions="page.props.permissions"
                @send-message="handleSendMessage"
            />

            <div
                v-else
                class="grow flex items-center justify-center text-dark/50 dark:text-light/50"
            >
                Select a chat to start messaging
            </div>
        </div>
    </AppLayout>
</template>
