// ChatList.vue
<script setup>
import { ref } from 'vue';

const props = defineProps({
    chats: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['chatSelected']);
const selectedChatId = ref(null);

const selectChat = (chatId) => {
    selectedChatId.value = chatId;
    emit('chatSelected', chatId);
};
</script>

<template>
    <div class="w-[300px] h-full overflow-y-auto bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px]">
        <div class="w-full h-12 p-2 border-b-[1px] border-b-light dark:border-b-dark">
            <span class="text-lg font-semibold text-black/80 dark:text-light/80">Chats</span>
        </div>

        <div
            v-for="chat in chats"
            :key="chat.chat_id"
            @click="selectChat(chat.chat_id)"
            :class="[
        'flex gap-2 p-2 h-20 border-b-[1px] border-b-dark/20 dark:border-b-dark cursor-pointer transition ease-in duration-2000',
        selectedChatId === chat.chat_id ? 'bg-dark/10 dark:bg-light/10' : 'hover:bg-dark/10 hover:dark:bg-light/10'
      ]"
        >
            <div class="h-12 w-16 border-[1px] border-dark/50 dark:border-light/50 rounded-[3px] relative">
                <img class="w-full h-full object-cover rounded-[3px]" :src="chat.client_avatar" alt="User avatar">
                <div class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-[1px] border-dark/80 dark:border-light/80">
                    <div :class="[
            'w-full h-full rounded-full',
            chat.status === 'active' ? 'bg-success' : 'bg-dark'
          ]"></div>
                </div>
            </div>

            <div class="grow w-full flex flex-col overflow-hidden">
        <span class="text-md text-dark/80 dark:text-light/80 font-semibold truncate">
          {{ chat.client_name }}
          <span class="font-normal">@ {{ chat.chat_id }}</span>
        </span>
                <p class="truncate text-dark/50 dark:text-light/50 text-sm">
                    {{ chat.last_message?.content || 'No messages' }}
                </p>
                <div class="flex justify-end">
                    <p class="truncate text-primary dark:text-info text-xs">
                        {{ chat.last_activity_at }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
