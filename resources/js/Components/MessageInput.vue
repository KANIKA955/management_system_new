<template>
    <div class="flex">
        <input v-model="newMessage" @keyup.enter="sendMessage" type="text" placeholder="Type your message..." class="flex-grow mr-2 border-gray-300 rounded-md shadow-sm">
        <button @click="sendMessage" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">Send</button>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

defineProps({
    chatId: Number,
})

const newMessage = ref('')

async function sendMessage() {
    if (!newMessage.value.trim()) return

    try {
        const response = await axios.post(`/chats/${chatId}/messages`, { content: newMessage.value })
        newMessage.value = ''
        emit('message-sent', response.data)
    } catch (error) {
        console.error('Failed to send message:', error)
    }
}
</script>
