<template>
    <div class="reports-container w-full p-4">
        <h1 class="text-2xl font-bold mb-4">Reports</h1>
        <nav class="flex space-x-4 mb-6">
            <!-- Breaks Report Button -->
            <button
                @click="activeReport = 'breaks'"
                class="px-4 py-2 rounded-lg hover:bg-primary hover:text-white transition"
                :class="{ 'bg-primary text-white': activeReport === 'breaks' }"
            >
                Breaks
            </button>

            <!-- Teams Report Button -->
            <button
                @click="activeReport = 'teams'"
                class="px-4 py-2 rounded-lg hover:bg-primary hover:text-white transition"
                :class="{ 'bg-primary text-white': activeReport === 'teams' }"
            >
                Teams
            </button>
        </nav>

        <!-- Breaks Report Section -->
        <div v-if="activeReport === 'breaks'" class="report-content border p-4 rounded-lg bg-white shadow-sm dark:bg-gray-800">
            <h2 class="text-xl font-semibold mb-4">Breaks Report</h2>
            <div class="mb-4">
                <label for="month-picker" class="block text-sm font-medium">Select Month</label>
                <input
                    type="month"
                    id="month-picker"
                    v-model="selectedMonth"
                    @change="fetchBreaksReport"
                    class="mt-1 px-3 py-2 border rounded-lg"
                />
            </div>

            <table v-if="Object.keys(breaksReport).length" class="w-full table-auto">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Number of Breaks</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(breakCount, date) in breaksReport" :key="date">
                    <td>{{ date }}</td>
                    <td>{{ breakCount }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Teams Report Section -->
        <div v-if="activeReport === 'teams'" class="report-content border p-4 rounded-lg bg-white shadow-sm dark:bg-gray-800">
            <h2 class="text-xl font-semibold mb-4">Teams Report</h2>
            <input
                v-model="teamSearchQuery"
                type="text"
                placeholder="Search teams..."
                class="p-2 border rounded-lg w-full mb-4"
            />
            <table v-if="filteredTeamsReport.length" class="w-full table-auto">
                <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Team Lead</th>
                    <th>Members</th>
                    <th>Team History</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="team in filteredTeamsReport" :key="team.id">
                    <td>{{ team.name }}</td>
                    <td>{{ team.leadName }}</td>
                    <td>
                        <ul>
                            <li v-for="member in team.members" :key="member.id">{{ member.name }} ({{ member.position }})</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li v-for="history in team.history" :key="history.id">{{ history.changeDate }} - {{ history.changeDescription }}</li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            activeReport: 'breaks', // Default active report
            selectedMonth: '', // Month selection for breaks report
            breaksReport: {}, // Data for breaks report
            teamSearchQuery: '', // Search query for teams
            teamsReport: [], // Data for teams report
        };
    },
    computed: {
        // Filtered teams report based on the search query
        filteredTeamsReport() {
            let filtered = this.teamsReport;
            if (this.teamSearchQuery) {
                const query = this.teamSearchQuery.toLowerCase();
                filtered = filtered.filter(team => team.name.toLowerCase().includes(query));
            }
            return filtered;
        },
    },
    methods: {
        // Fetch Breaks Report from API
        fetchBreaksReport() {
            if (!this.selectedMonth) {
                return; // Prevent fetching when month is not selected
            }
            // Replace this URL with your actual API endpoint
            axios.get(`/api/breaks?month=${this.selectedMonth}`)
                .then(response => {
                    console.log('Breaks data:', response.data); // Add log to verify data
                    this.breaksReport = response.data; // Assuming response contains breaks data
                })
                .catch(error => {
                    console.error('Error fetching breaks report:', error);
                });
        },

        // Fetch Teams Report from API
        fetchTeamsReport() {
            // Replace this URL with your actual API endpoint
            axios.get('/api/teams')
                .then(response => {
                    console.log('Teams data:', response.data); // Add log to verify data
                    this.teamsReport = response.data; // Assuming response contains teams data
                })
                .catch(error => {
                    console.error('Error fetching teams report:', error);
                });
        },
    },
    mounted() {
        this.fetchTeamsReport(); // Fetch teams data when the component is mounted
    },
    watch: {
        selectedMonth(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.fetchBreaksReport(); // Refetch breaks report when the month changes
            }
        },
    },
};
</script>

<style scoped>
.reports-container {
    max-width: 900px;
    margin: auto;
}
.bg-primary {
    background-color: #3498db;
}
</style>
