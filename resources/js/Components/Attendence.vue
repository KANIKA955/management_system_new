<template>
    <div class="attendance-card p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Attendance Overview</h3>

        <div class="flex flex-col gap-4">
            <!-- Present Days Section -->
            <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex flex-col items-center">
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ presentDays }}</span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Present Days</span>
                </div>
            </div>

            <!-- Absent Days Section -->
            <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex flex-col items-center">
                    <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ absentDays }}</span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Absent Days</span>
                </div>
            </div>

            <!-- Last Status Section -->
            <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <div class="flex flex-col items-center">
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ lastStatus }}</span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Last Status</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AttendanceCard',
    data() {
        return {
            totalDays: 30,
            presentDays: 0,
            absentDays: 0,
            lastStatus: 'N/A',
            attendanceInterval: null, // Store interval for attendance updates
        };
    },
    mounted() {
        this.startAttendanceFiller();
    },
    beforeDestroy() {
        clearInterval(this.attendanceInterval); // Clean up interval on component destruction
    },
    methods: {
        startAttendanceFiller() {
            this.attendanceInterval = setInterval(() => {
                if (this.presentDays + this.absentDays >= this.totalDays) {
                    clearInterval(this.attendanceInterval); // Stop when total days are filled
                    return;
                }

                // Randomly decide if the day is "Present" or "Absent"
                const isPresent = Math.random() > 0.3; // 70% chance of being present

                if (isPresent) {
                    this.presentDays++;
                    this.lastStatus = 'Present';
                } else {
                    this.absentDays++;
                    this.lastStatus = 'Absent';
                }

                // Emit data update event
                this.$emit('attendanceDataUpdated', {
                    presentDays: this.presentDays,
                    absentDays: this.absentDays,
                    lastStatus: this.lastStatus,
                });
            }, 1000); // Update every second to simulate daily attendance
        },
    },
};
</script>

<style scoped>
/* Additional styles if needed */
</style>

