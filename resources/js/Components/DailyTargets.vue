<<template>
    <div class="p-6 bg-white shadow-lg rounded-lg dark:bg-gray-800">
        <h3 class="mb-6 text-xl font-semibold text-gray-800 dark:text-gray-100">Daily Targets</h3>

        <div class="grid gap-6 sm:grid-cols-2">
            <!-- Calls Target Section -->
            <div class="p-4 bg-gray-100 rounded-lg flex flex-col items-center dark:bg-gray-700">
                <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ callsTarget }}</span>
                <span class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-300">Calls</span>
                <span class="mt-2 text-xs font-semibold text-yellow-600 dark:text-yellow-400">
                    {{ callPercentage }}% <i class="fa fa-check"></i>
                </span>
            </div>

            <!-- Time Left in Shift Section -->
            <div class="p-4 bg-gray-100 rounded-lg flex flex-col items-center dark:bg-gray-700">
                <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ formattedTimeLeft }}</span>
                <span class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-300">Time Left in Shift</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DailyTargetsCard",
    data() {
        return {
            callsTarget: 75,
            callPercentage: 45,
            countdownInterval: null,
            remainingMinutes: 0, // Initially set to 0, calculated in startCountdown
        };
    },
    computed: {
        formattedTimeLeft() {
            const hours = Math.floor(this.remainingMinutes / 60);
            const minutes = this.remainingMinutes % 60;
            return `${hours} hr ${minutes} mins`;
        },
    },
    mounted() {
        this.startCountdown();
    },
    beforeDestroy() {
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
        }
    },
    methods: {
        startCountdown() {
            this.updateRemainingMinutes();

            this.countdownInterval = setInterval(() => {
                this.updateRemainingMinutes();
            }, 60000); // Update every minute
        },
        updateRemainingMinutes() {
            const now = new Date();
            const startShift = new Date(now);
            startShift.setHours(9, 0, 0, 0); // Set to 9:00 AM

            const endShift = new Date(now);
            endShift.setHours(18, 0, 0, 0); // Set to 6:00 PM

            if (now >= startShift && now <= endShift) {
                // Calculate remaining time in minutes
                this.remainingMinutes = Math.floor((endShift - now) / 60000);
            } else {
                // If it's outside shift hours, set remaining time to 0
                this.remainingMinutes = 0;
            }
        },
    },
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
