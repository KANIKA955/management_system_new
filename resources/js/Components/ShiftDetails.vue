<template>
    <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6">
        <div class="flex flex-col">
            <span class="text-[20px] font-[600] text-dark/90 dark:text-light/90">Shift Details</span>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="flex flex-col items-center">
                <span class="text-[16px] font-[700] text-primary">{{ shiftStart }}</span>
                <span class="text-[10px] font-[700] text-dark/90 dark:text-light/90">Shift Start</span>
            </div>

            <div class="flex flex-col items-center">
                <span class="text-[16px] font-[700] text-success">{{ shiftEnd }}</span>
                <span class="text-[10px] font-[700] text-dark/90 dark:text-light/90">Shift End</span>
            </div>
        </div>

        <div v-if="isShiftActive" class="text-center mt-4">
            <div class="font-mono text-2xl font-bold text-blue-600">
                {{ timeUntilShiftEnd }}
            </div>
            <p class="text-sm text-dark/70 dark:text-light/70 mt-1">
                Time Remaining in Shift
            </p>
        </div>

        <div v-else class="text-center mt-4">
            <p class="text-lg font-medium text-danger">
                Shift has ended
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Define shift times (set 9:00 AM and 6:00 PM using 24-hour time)
const shiftStart = '9:00 AM';
const shiftEnd = '6:00 PM';
const isShiftActive = ref(false);
const timeUntilShiftEnd = ref('');

// Function to calculate time remaining until shift end
const calculateTimeRemaining = () => {
    const now = new Date();

    // Set the shift end time to 6:00 PM today, using the current date
    const endTime = new Date();
    endTime.setHours(18, 0, 0, 0); // 6:00 PM with 0 milliseconds

    // Check if the current time is after the shift end time
    if (now >= endTime) {
        isShiftActive.value = false;
        timeUntilShiftEnd.value = '00:00:00';
    } else {
        isShiftActive.value = true;
        const diff = endTime - now; // Calculate difference in milliseconds

        // Calculate remaining hours, minutes, seconds
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24).toString().padStart(2, '0');
        const minutes = Math.floor((diff / (1000 * 60)) % 60).toString().padStart(2, '0');
        const seconds = Math.floor((diff / 1000) % 60).toString().padStart(2, '0');
        timeUntilShiftEnd.value = `${hours}:${minutes}:${seconds}`;
    }
};

// On mounted, start the interval and calculate the time immediately
onMounted(() => {
    calculateTimeRemaining();
    const interval = setInterval(calculateTimeRemaining, 1000); // Update every second

    // Clean up the interval when the component is unmounted
    onUnmounted(() => {
        clearInterval(interval);
    });
});
</script>

<style scoped>
/* Add custom styles if necessary */
</style>

