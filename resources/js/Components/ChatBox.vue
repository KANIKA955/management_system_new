<template>
    <div class="p-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold">Chat Details</h3>
            <p>Status: <span :class="statusClass(chat.status)">{{ chat.status }}</span></p>
            <p>Priority: {{ chat.priority }}</p>
            <p>Client: {{ chat.client.name }}</p>
            <p>Assigned to: {{ chat.assigned_to ? chat.assigned_agent.name : 'Unassigned' }}</p>
        </div>

        <div class="mb-4">
            <select v-model="newStatus" @change="updateStatus" class="border-gray-300 focus:ring-indigo-300 rounded-md shadow-sm">
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="on_hold">On Hold</option>
                <option value="closed">Closed</option>
                <option value="reopened">Reopened</option>
            </select>
            <button @click="showTransferModal = true" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Transfer
            </button>
        </div>

        <MessageList :messages="chat.messages" />
        <MessageInput :chat-id="chat.id" @message-sent="addMessage" />

        <div v-if="showTransferModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 bg-white rounded-md shadow-lg">
                <h3 class="text-lg font-bold mb-4">Transfer Chat</h3>
                <select v-model="transferTo" class="w-full mb-4 rounded-md shadow-sm border-gray-300 focus:ring-indigo-300">
                    <option v-for="agent in availableAgents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
                </select>
                <textarea v-model="transferReason" placeholder="Reason for transfer" class="w-full mb-4 rounded-md shadow-sm border-gray-300 focus:ring-indigo-300"></textarea>
                <div class="flex justify-end">
                    <button @click="showTransferModal = false" class="mr-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Cancel
                    </button>
                    <button @click="transferChat" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 rounded">
                        Transfer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import axios from 'axios'
import Echo from 'laravel-echo'
import MessageList from '@/Components/MessageList.vue'
import MessageInput from '@/Components/MessageInput.vue'

// Props
const props = defineProps({
    chat: Object,
})

// Reactive state
const state = reactive({
    newStatus: props.chat.status,
    showTransferModal: false,
    transferTo: '',
    transferReason: '',
    availableAgents: [], // This should be populated with actual agent data
})

// Methods
const statusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-200 text-yellow-800',
        active: 'bg-green-200 text-green-800',
        on_hold: 'bg-orange-200 text-orange-800',
        transferred: 'bg-blue-200 text-blue-800',
        closed: 'bg-red-200 text-red-800',
        reopened: 'bg-purple-200 text-purple-800',
    }
    return `px-2 py-1 rounded text-xs font-bold ${classes[status] || ''}`
}

const updateStatus = async () => {
    try {
        const { data } = await axios.patch(`/chats/${props.chat.id}/status`, { status: state.newStatus })
        props.chat.status = data.status
        // Add a success message if necessary
    } catch (error) {
        console.error('Failed to update status:', error)
        // Add an error message if necessary
    }
}

const transferChat = async () => {
    try {
        const { data } = await axios.post(`/chats/${props.chat.id}/transfer`, {
            to_user_id: state.transferTo,
            transfer_type: 'agent_to_agent',
            reason: state.transferReason,
        })
        props.chat.assigned_to = data.to_user_id
        props.chat.status = 'transferred'
        state.showTransferModal = false
    } catch (error) {
        console.error('Failed to transfer chat:', error)
        // Add an error message if necessary
    }
}

const addMessage = (message) => {
    props.chat.messages.push(message)
}

// Echo setup for real-time updates
onMounted(() => {
    Echo.private(`chat.${props.chat.id}`)
        .listen('.new-message', (e) => {
            props.chat.messages.push(e.message)
        })
        .listen('.chat-status-updated', (e) => {
            props.chat.status = e.newStatus
        })
        .listen('.chat-transferred', (e) => {
            props.chat.assigned_to = e.transfer.to_user_id
            props.chat.status = 'transferred'
        })
})
</script>
