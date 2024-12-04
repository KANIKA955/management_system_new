<template>
    <div class="employee-performance-card mt-4 w-full bg-white dark:bg-gray-800 shadow-lg rounded-md p-4">
        <!-- Header Section with Filter and Sort Controls -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Employee Performance</h3>
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Today</span>
        </div>

        <!-- Filters Section -->
        <div class="mb-4 flex space-x-4">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by Name"
                class="w-full px-2 py-1 border rounded dark:bg-gray-900 dark:text-gray-200"
            />

            <select v-model="selectedDepartment" class="px-2 py-1 border rounded dark:bg-gray-900 dark:text-gray-200">
                <option value="">All Departments</option>
                <option v-for="dept in uniqueDepartments" :key="dept" :value="dept">{{ dept }}</option>
            </select>

            <select v-model="selectedSort" class="px-2 py-1 border rounded dark:bg-gray-900 dark:text-gray-200">
                <option value="employeeId">Employee ID</option>
                <option value="inboundCalls">Inbound Calls</option>
                <option value="outboundCalls">Outbound Calls</option>
            </select>
        </div>

        <!-- Employee Performance Table with Scroll -->
        <div class="overflow-y-auto max-h-[70vh]">
            <table class="min-w-full bg-gray-100 dark:bg-gray-700 rounded-lg">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-left text-sm">
                    <th class="py-2 px-4 font-semibold">SR.NO.</th>
                    <th class="py-2 px-4 font-semibold">Employee ID</th>
                    <th class="py-2 px-4 font-semibold">Name</th>
                    <th class="py-2 px-4 font-semibold">Department</th>
                    <th class="py-2 px-4 font-semibold">Designation</th>
                    <th class="py-2 px-4 font-semibold">Reporting Manager</th>
                    <th class="py-2 px-4 font-semibold">Shift Time</th>
                    <th class="py-2 px-4 font-semibold">Inbound Calls</th>
                    <th class="py-2 px-4 font-semibold">Outbound Calls</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(employee, index) in filteredAndSortedEmployees"
                    :key="employee.employeeId"
                    class="text-sm text-gray-800 dark:text-gray-200 border-t border-gray-300 dark:border-gray-600"
                    :class="{
                            'bg-green-100 dark:bg-green-700': employee.inboundCalls > highPerformanceThreshold || employee.outboundCalls > highPerformanceThreshold
                        }"
                >
                    <td class="py-2 px-4">{{ index + 1 }}</td>
                    <td class="py-2 px-4">{{ employee.employeeId }}</td>
                    <td class="py-2 px-4">{{ employee.name }}</td>
                    <td class="py-2 px-4">{{ employee.department }}</td>
                    <td class="py-2 px-4">{{ employee.designation }}</td>
                    <td class="py-2 px-4">{{ employee.reportingManager }}</td>
                    <td class="py-2 px-4">{{ formatShiftTime(employee.shiftTime) }}</td>
                    <td class="py-2 px-4 text-blue-600 dark:text-blue-400 font-semibold">{{ employee.inboundCalls }}</td>
                    <td class="py-2 px-4 text-green-600 dark:text-green-400 font-semibold">{{ employee.outboundCalls }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "EmployeePerformanceCard",
    props: {
        employees: {
            type: Array,
            required: true,
            default: () => [],
            validator(value) {
                return value.every(employee =>
                    'employeeId' in employee &&
                    'name' in employee &&
                    'department' in employee &&
                    'designation' in employee &&
                    'reportingManager' in employee &&
                    'shiftTime' in employee &&
                    'inboundCalls' in employee &&
                    'outboundCalls' in employee
                );
            },
        },
    },
    data() {
        return {
            searchQuery: "",
            selectedDepartment: "",
            selectedSort: "employeeId",
            highPerformanceThreshold: 50, // Threshold for highlighting high performance
        };
    },
    computed: {
        uniqueDepartments() {
            return [...new Set(this.employees.map(employee => employee.department))];
        },
        filteredAndSortedEmployees() {
            // Filtering by department and search query
            let filtered = this.employees.filter(employee => {
                const matchesDepartment = this.selectedDepartment === "" || employee.department === this.selectedDepartment;
                const matchesSearch = employee.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                return matchesDepartment && matchesSearch;
            });

            // Sorting
            filtered.sort((a, b) => {
                if (this.selectedSort === "employeeId") {
                    return a.employeeId - b.employeeId;
                } else if (this.selectedSort === "inboundCalls") {
                    return b.inboundCalls - a.inboundCalls;
                } else if (this.selectedSort === "outboundCalls") {
                    return b.outboundCalls - a.outboundCalls;
                }
                return 0;
            });

            return filtered;
        },
    },
    methods: {
        formatShiftTime(shiftTime) {
            // Placeholder: Assuming shiftTime is in "HH:mm-HH:mm" format; adjust if necessary
            return shiftTime;
        },
    },
};
</script>

<style scoped>
.employee-performance-card {
    max-width: 100%;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .employee-performance-card {
        padding: 2px;
    }
    th, td {
        font-size: 0.875rem;
    }
}
</style>
