<script setup>
import { ref, onMounted, computed, onBeforeUnmount } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from "@inertiajs/vue3";
import { defineEmits } from 'vue';

// Constants
const TOTAL_BREAK_MINUTES = 60;
const MILLISECONDS_PER_MINUTE = 60000;
const UPDATE_INTERVAL = 1000;
const REFRESH_INTERVAL = 30000;
const emit = defineEmits();
// Get initial state from props
const { activeBreak: initialActiveBreak, totalBreakTimeUsed: initialTotalBreakTimeUsed } = usePage().props;

// State management
const isOnBreak = ref(!!initialActiveBreak);
const breakId = ref(initialActiveBreak?.id || null);
const timeLeft = ref(null);
const breakInterval = ref(null);
const refreshInterval = ref(null);
const activeBreak = ref(initialActiveBreak);
const totalBreakTimeUsed = ref(Math.max(0, initialTotalBreakTimeUsed || 0));

// Computed properties
const breakTimeAvailable = computed(() => {
    return Math.max(0, TOTAL_BREAK_MINUTES - totalBreakTimeUsed.value);
});

const formattedTimeLeft = computed(() => {
    if (!timeLeft.value) return formatTime(breakTimeAvailable.value);
    if (typeof timeLeft.value === 'string') return timeLeft.value;
    return formatTime(timeLeft.value);
});

const canStartBreak = computed(() => {
    return !isOnBreak.value && breakTimeAvailable.value > 0;
});

// API calls
const api = {
    async fetchBreakInfo() {
        try {
            const response = await axios.get(route('break.info'));
            return response.data;
        } catch (error) {
            console.error('Error fetching break information:', error);
            throw error;
        }
    },

    async startBreak() {
        try {
            const response = await axios.post(route('break.start'), {
                duration: breakTimeAvailable.value
            });
            return response.data;
        } catch (error) {
            console.error('Error starting break:', error);
            throw error;
        }
    },

    async endBreak(breakId) {
        try {
            const response = await axios.post(route('break.end'), { break_id: breakId });
            return response.data;
        } catch (error) {
            console.error('Error ending break:', error);
            throw error;
        }
    }
};

// Timer management
const startTimer = (startTime, duration) => {
    clearInterval(breakInterval.value);

    const endTime = new Date(startTime).getTime() + (duration * MILLISECONDS_PER_MINUTE);

    breakInterval.value = setInterval(() => {
        const now = Date.now();
        const remainingMilliseconds = Math.max(0, endTime - now);

        if (remainingMilliseconds <= 0) {
            handleBreakEnd();
            return;
        }

        const minutes = Math.floor(remainingMilliseconds / MILLISECONDS_PER_MINUTE);
        const seconds = Math.floor((remainingMilliseconds % MILLISECONDS_PER_MINUTE) / 1000);
        timeLeft.value = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }, UPDATE_INTERVAL);
};

// Break state management
const handleBreakEnd = async () => {
    clearInterval(breakInterval.value);
    if (breakId.value) {
        try {
            const response = await api.endBreak(breakId.value);
            if (response.success) {
                totalBreakTimeUsed.value = Math.max(0, response.total_break_time_used);
            }
            await refreshBreakInfo();
        } catch (error) {
            console.error('Error handling break end:', error);
        }
    }
    resetBreakState();
};

const resetBreakState = () => {
    isOnBreak.value = false;
    timeLeft.value = null;
    activeBreak.value = null;
    breakId.value = null;
    clearInterval(breakInterval.value);
};

// Main actions
const startBreak = async () => {
    if (!canStartBreak.value) return;

    try {
        const response = await api.startBreak();
        if (response.id) {
            breakId.value = response.id;
            isOnBreak.value = true;
            activeBreak.value = response;
            totalBreakTimeUsed.value = response.total_break_time_used || totalBreakTimeUsed.value;
            startTimer(response.start_time, breakTimeAvailable.value);
        }
    } catch (error) {
        console.error('Error starting break:', error);
        resetBreakState();
    }
};

const endBreak = async () => {
    if (!isOnBreak.value || !breakId.value) return;
    await handleBreakEnd();
};

const refreshBreakInfo = async () => {
    try {
        const data = await api.fetchBreakInfo();
        totalBreakTimeUsed.value = Math.max(0, data.totalBreakTimeUsed);

        const wasOnBreak = isOnBreak.value;
        const newActiveBreak = data.activeBreak;

        if (newActiveBreak) {
            activeBreak.value = newActiveBreak;
            breakId.value = newActiveBreak.id;
            isOnBreak.value = true;

            if (!wasOnBreak || breakId.value !== newActiveBreak.id) {
                const startTime = new Date(newActiveBreak.start_time);
                const remainingMinutes = breakTimeAvailable.value;

                if (remainingMinutes > 0) {
                    startTimer(startTime, remainingMinutes);
                } else {
                    await handleBreakEnd();
                }
            }
        } else if (wasOnBreak) {
            resetBreakState();
        }
    } catch (error) {
        console.error('Error refreshing break info:', error);
    }
};

// Start periodic refresh
const startPeriodicRefresh = () => {
    stopPeriodicRefresh();
    refreshInterval.value = setInterval(refreshBreakInfo, REFRESH_INTERVAL);
};

// Stop periodic refresh
const stopPeriodicRefresh = () => {
    if (refreshInterval.value) {
        clearInterval(refreshInterval.value);
        refreshInterval.value = null;
    }
};

// Utility functions
const formatTime = (minutes) => {
    if (typeof minutes === 'string') return minutes;
    const mins = Math.floor(minutes);
    const secs = Math.round((minutes - mins) * 60);
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
};

// Visibility change handler
const handleVisibilityChange = async () => {
    if (document.visibilityState === 'visible') {
        await refreshBreakInfo();
        startPeriodicRefresh();
    } else {
        stopPeriodicRefresh();
    }
};

// Lifecycle hooks
onMounted(async () => {
    await refreshBreakInfo();
    startPeriodicRefresh();

    document.addEventListener('visibilitychange', handleVisibilityChange);

    if (activeBreak.value) {
        const startTime = new Date(activeBreak.value.start_time);
        const remainingMinutes = breakTimeAvailable.value;

        if (remainingMinutes > 0) {
            startTimer(startTime, remainingMinutes);
        } else {
            await handleBreakEnd();
        }
    }
});
//Trigger start break event
const start = () => {
    if (canStartBreak.value) {
        emit('break-started', new Date());
        // Additional start logic like starting a countdown timer
    }
};

// Trigger end break event
const end = () => {
    if (isOnBreak.value) {
        emit('break-ended', new Date());
        // Additional end logic like stopping the countdown timer
    }
};

onBeforeUnmount(() => {
    clearInterval(breakInterval.value);
    stopPeriodicRefresh();
    document.removeEventListener('visibilitychange', handleVisibilityChange);
});
</script>

<template>


    <-- Break Information Card -->
    <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6">
        <div class="flex flex-col">
            <span class="text-[20px] font-[600] text-dark/90 dark:text-light/90">Break Information</span>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="flex flex-col items-center">
                <span class="text-[16px] font-[700] text-danger">{{ Math.max(0, totalBreakTimeUsed).toFixed(1) }} mins</span>
                <span class="text-[10px] font-[700] text-dark/90 dark:text-light/90">Total Break Time Used</span>
            </div>

            <div class="flex flex-col items-center">
                <span class="text-[16px] font-[700] text-success">{{ breakTimeAvailable.toFixed(1) }} mins</span>
                <span class="text-[10px] font-[700] text-dark/90 dark:text-light/90">Remaining Break Time</span>
            </div>
        </div>

        <div class="flex justify-center space-x-4 mt-4">
            <button
                @click="startBreak"
                :disabled="!canStartBreak"
                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed"
            >
                Start Break
            </button>
            <button
                @click="endBreak"
                :disabled="!isOnBreak"
                class="bg-red-500 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-red-600 disabled:bg-red-300 disabled:cursor-not-allowed"
            >
                End Break
            </button>
        </div>

        <div v-if="isOnBreak" class="text-center mt-4">
            <div class="font-mono text-2xl font-bold text-blue-600">
                {{ formattedTimeLeft }}
            </div>
            <p class="text-sm text-dark/70 dark:text-light/70 mt-1">
                Time Remaining
            </p>
        </div>

        <div v-else-if="breakTimeAvailable <= 0" class="text-center mt-4">
            <p class="text-lg font-medium text-danger">
                Break time limit reached for today
            </p>

        </div>
    </div>
</template>
