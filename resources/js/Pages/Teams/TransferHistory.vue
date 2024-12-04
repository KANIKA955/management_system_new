<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    member: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close']);
const transfers = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await fetch(route('team-transfers.history', props.member.id));
        transfers.value = await response.json();
    } catch (error) {
        console.error('Failed to fetch transfer history:', error);
    } finally {
        loading.value = false;
    }
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>
    <div class="fixed inset-0 bg-dark/50 dark:bg-light/20 flex items-center justify-center z-50">
        <div class="w-full max-w-4xl bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-dark/80 dark:text-light/80">
                    Transfer History - {{ member.first_name }}
                </h3>
                <button
                    @click="$emit('close')"
                    class="h-8 w-8 rounded-full text-dark/60 dark:text-light/60 hover:bg-dark/10 dark:hover:bg-light/10"
                >
                    <i class="fa fa-xmark"></i>
                </button>
            </div>

            <div v-if="loading" class="text-center py-4">
                <i class="fa fa-spinner fa-spin text-primary dark:text-info"></i>
                Loading history...
            </div>

            <div v-else-if="transfers.length === 0" class="text-center py-4 text-dark/60 dark:text-light/60">
                No transfer history found
            </div>

            <div v-else class="overflow-x-auto">
                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                    <thead>
                    <tr class="bg-lightTrans dark:bg-dark">
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">Date</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">From Team</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">To Team</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">Previous Position</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">New Position</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-md text-dark/80 dark:text-light/80 font-normal">Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="(transfer, index) in transfers"
                        :key="transfer.id"
                        :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}"
                    >
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            {{ formatDate(transfer.transfer_date) }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            {{ transfer.from_team }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            {{ transfer.to_team }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            <span class="capitalize">{{ transfer.previous_position }}</span>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            <span class="capitalize">{{ transfer.new_position }}</span>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-4 py-2 text-sm">
                            {{ transfer.reason || '-' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
