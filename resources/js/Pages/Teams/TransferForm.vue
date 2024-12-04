<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    member: {
        type: Object,
        required: true
    },
    currentTeam: {
        type: Object,
        required: true
    },
    teams: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['close']);

const form = useForm({
    employee_id: props.member.id,
    to_team_id: '',
    new_position: props.member.pivot?.position || 'executive',
    reason: '',
    transfer_date: new Date().toISOString().split('T')[0]
});

const submit = () => {
    form.post(route('team-transfers.store'), {
        onSuccess: () => {
            emit('close');
        },
    });
};
</script>

<template>
    <div class="fixed inset-0 bg-dark/50 dark:bg-light/20 flex items-center justify-center z-50">
        <div class="w-full max-w-2xl bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-dark/80 dark:text-light/80">
                    Transfer {{ member.first_name }}
                </h3>
                <button
                    @click="$emit('close')"
                    class="h-8 w-8 rounded-full text-dark/60 dark:text-light/60 hover:bg-dark/10 dark:hover:bg-light/10"
                >
                    <i class="fa fa-xmark"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Current Team -->
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Current Team</label>
                    <input
                        type="text"
                        :value="currentTeam.name"
                        disabled
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 opacity-70 rounded-[3px]"
                    >
                </div>

                <!-- New Team -->
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-sm text-dark/80 dark:text-light/80">New Team</label>
                    <select
                        v-model="form.to_team_id"
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                    >
                        <option value="">Select Team</option>
                        <option
                            v-for="team in teams"
                            :key="team.id"
                            :value="team.id"
                            :disabled="team.id === currentTeam.id"
                        >
                            {{ team.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.to_team_id" class="text-danger text-sm">{{ form.errors.to_team_id }}</div>
                </div>

                <!-- New Position -->
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-sm text-dark/80 dark:text-light/80">New Position</label>
                    <select
                        v-model="form.new_position"
                        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                    >
                        <option value="manager">Manager</option>
                        <option value="team_lead">Team Lead</option>
                        <option value="executive">Executive</option>
                    </select>
                    <div v-if="form.errors.new_position" class="text-danger text-sm">{{ form.errors.new_position }}</div>
                </div>

                <!-- Transfer Date -->
                <div class="flex flex-col gap-1">
                    <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Transfer Date</label>
                    <input
                        type="date"
                        v-model="form.transfer_date"
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0"
                    >
                    <div v-if="form.errors.transfer_date" class="text-danger text-sm">{{ form.errors.transfer_date }}</div>
                </div>

                <!-- Transfer Reason -->
                <div class="flex flex-col gap-1 md:col-span-2">
                    <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Transfer Reason</label>
                    <textarea
                        v-model="form.reason"
                        rows="3"
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0"
                    ></textarea>
                    <div v-if="form.errors.reason" class="text-danger text-sm">{{ form.errors.reason }}</div>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button
                    @click="submit"
                    :disabled="form.processing"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    Transfer Employee
                </button>
                <button
                    @click="$emit('close')"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>
