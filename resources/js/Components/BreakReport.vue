<template>
    <div class="report-container">
        <h1>Breaks Report</h1>

        <!-- Filter Section -->
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" v-model="filters.start_date" />
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" v-model="filters.end_date" />
            <button @click="fetchBreaks">Fetch Report</button>
        </div>

        <!-- Report Data Table -->
        <table v-if="breaks.length">
            <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(breakRecord, index) in breaks" :key="breakRecord.id">
                <td>{{ index + 1 }}</td>
                <td>{{ breakRecord.employee_name }}</td>
                <td>{{ breakRecord.start_time }}</td>
                <td>{{ breakRecord.end_time }}</td>
                <td>{{ breakRecord.duration }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filters: {
                start_date: "",
                end_date: "",
            },
            breaks: [],
        };
    },
    methods: {
        fetchBreaks() {
            // Call the backend API
            this.$axios
                .get("/api/breaks-report", { params: this.filters })
                .then((response) => {
                    this.breaks = response.data; // Adjust data structure if needed
                })
                .catch((error) => {
                    console.error("Error fetching breaks report:", error);
                });
        },
    },
};
</script>

<style>
.report-container {
    padding: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border: 1px solid #ddd;
}
</style>
