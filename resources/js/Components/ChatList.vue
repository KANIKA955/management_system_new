<template>
    <div class="p-6">
        <ul>
            <li v-for="chat in chats" :key="chat.id" class="mb-4">
                <Link :href="route('chats.show', chat.id)" class="block hover:bg-gray-100 p-4 rounded">
                    <div class="flex justify-between">
                        <span class="font-bold">Chat #{{ chat.id }}</span>
                        <span :class="statusClass(chat.status)">{{ chat.status }}</span>
                    </div>
                    <div class="text-sm text-gray-600">Client: {{ chat.client.name }}</div>
                    <div class="text-sm text-gray-600">Priority: {{ chat.priority }}</div>
                </Link>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    chats: Array,
})

function statusClass(status) {
    const classes = {
        pending: 'bg-yellow-200 text-yellow-800',
        active: 'bg-green-200 text-green-800',
        on_hold: 'bg-orange-200 text-orange-800',
        transferred: 'bg-blue-200 text-blue-800',
        closed: 'bg-red-200 text-red-800',
        reopened: 'bg-purple-200 text-purple-800',
    }
    return `px-2 py-1 rounded text-xs font-bold ${classes[status]}`
}
</script>
