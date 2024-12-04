<template>
    <AppLayout title="Break Report">
        <div class="p-6">
            <!-- Date Picker Tab for Start and End Dates -->
            <div class="mb-6">
                <label for="start_date" class="block text-lg font-medium mb-2">Choose Start Date</label>
                <input
                    type="date"
                    id="start_date"
                    v-model="startDate"
                    @change="fetchBreakData"
                    class="border border-gray-300 p-2 rounded-md"
                />
            </div>

            <div class="mb-6">
                <label for="end_date" class="block text-lg font-medium mb-2">Choose End Date</label>
                <input
                    type="date"
                    id="end_date"
                    v-model="endDate"
                    @change="fetchBreakData"
                    class="border border-gray-300 p-2 rounded-md"
                />
            </div>
            <!-- Total Break Time Display -->
            <div v-if="breakRecords.length > 0" class="mb-4">
                <h3 class="text-lg font-medium">
                    Total Break Time: {{ totalBreakTime }}
                </h3>
            </div>

            <!-- Break Records Table -->
            <div>
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium">S.No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Employee Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Break Duration</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(record, index) in breakRecords" :key="record.id">
                        <td class="px-4 py-2 text-sm">{{ index + 1 }}</td>
                        <td class="px-4 py-2 text-sm">{{ record.id }}</td>
                        <td class="px-4 py-2 text-sm">{{ record.employee_name }}</td>
                        <td class="px-4 py-2 text-sm">{{ record.total_break_time }}</td>
                        <td class="px-4 py-2 text-sm">
                            <button
                                @click="viewDetails(record.id)"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                            >
                                View Details
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Full Details Table (Visible on View Details) -->
            <div v-if="showDetails" class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Break Details for Employee</h3>
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Start Time</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">End Time</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Break Duration</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(detail, index) in fullDetails" :key="index">
                        <td class="px-4 py-2 text-sm">{{ detail.date }}</td>
                        <td class="px-4 py-2 text-sm">{{ detail.start_time }}</td>
                        <td class="px-4 py-2 text-sm">{{ detail.end_time }}</td>
                        <td class="px-4 py-2 text-sm">{{ detail.total_break_time }}</td>
                        <td class="px-4 py-2 text-sm">{{ detail.details }}</td>
                    </tr>
                    </tbody>
                </table>
                <button
                    @click="closeDetails"
                    class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                >
                    Close Details
                </button>
            </div>

            <!-- Download Button -->
            <div class="mt-4">
                <button
                    @click="downloadReport('csv')"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                >
                    Download as CSV
                </button>
                <button
                    @click="downloadReport('excel')"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Download as Excel
                </button>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";
import * as XLSX from "xlsx"; // Add this for Excel export

export default {
    components: { AppLayout },
    data() {
        return {
            selectedDate: new Date().toISOString().split("T")[0], // Default selected date (today)
            breakRecords: [], // Data for break records
            showDetails: false, // Flag to show full details
            fullDetails: [], // Full details for the selected employee
        };
    },
    computed: {
        // Calculate total break time from the break records
        totalBreakTime() {
            return this.breakRecords.reduce((total, record) => {
                const time = this.parseDuration(record.total_break_time);
                return total + time;
            }, 0);
        },
    },
    methods: {
        // Parse break time from string format (e.g., "30 mins")
        parseDuration(duration) {
            const match = duration.match(/(\d+)\s*mins/);
            return match ? parseInt(match[1], 10) : 0;
        },

        // Fetch break data for the selected date
        fetchBreakData() {
            const selectedDate = this.selectedDate; // Date in YYYY-MM-DD format

            // Sample data for testing
            this.breakRecords = [
                {
                    id: 1,
                    employee_name: "John Doe",
                    total_break_time: "30 mins",
                },
                {
                    id: 2,
                    employee_name: "Jane Smith",
                    total_break_time: "45 mins",
                },
                {
                    id: 3,
                    employee_name: "Emily Johnson",
                    total_break_time: "20 mins",
                },
            ];
        },

        // View details of a selected employee's break record
        viewDetails(recordId) {
            // Sample data for details (replace this with actual API call)
            this.fullDetails = [
                {
                    date: "2024-11-19",
                    start_time: "10:00 AM",
                    end_time: "10:30 AM",
                    total_break_time: "30 mins",
                    details: "Short break",
                },
                {
                    date: "2024-11-19",
                    start_time: "02:00 PM",
                    end_time: "02:15 PM",
                    total_break_time: "15 mins",
                    details: "Coffee break",
                },
            ];

            this.showDetails = true;
        },

        // Close the details modal
        closeDetails() {
            this.showDetails = false;
            this.fullDetails = [];
        },

        // Download the report in CSV or Excel format
        downloadReport(type) {
            if (type === "csv") {
                this.downloadCSV();
            } else if (type === "excel") {
                this.downloadExcel();
            }
        },

        // Export data as CSV
        downloadCSV() {
            const headers = ["ID", "Employee Name", "Total Break Time"];
            const rows = this.breakRecords.map((record) => [
                record.id,
                record.employee_name,
                record.total_break_time,
            ]);
            const csvContent =
                "data:text/csv;charset=utf-8," +
                headers.join(",") +
                "\n" +
                rows.map((e) => e.join(",")).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "break_report.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        // Export data as Excel
        downloadExcel() {
            const ws = XLSX.utils.json_to_sheet(this.breakRecords, {
                header: ["id", "employee_name", "total_break_time"],
            });
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Break Report");
            XLSX.writeFile(wb, "break_report.xlsx");
        },
    },

    mounted() {
        this.fetchBreakData();
    },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
