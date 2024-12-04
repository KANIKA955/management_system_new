<template>
    <div class="employee-history">
        <h2>Employee History</h2>
        <div v-for="employee in employees" :key="employee.id" class="employee-card">
            <h3>{{ employee.name }} ({{ employee.role }})</h3>
            <p><strong>Current Team:</strong> {{ employee.currentTeam }}</p>
            <p><strong>Team History:</strong></p>
            <ul>
                <li v-for="team in employee.teamHistory" :key="team">{{ team }}</li>
            </ul>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    employees: Array,
});
</script>

<style scoped>
.employee-history {
    margin-top: 20px;
}

.employee-card {
    background: #f4f4f4;
    padding: 15px;
    margin-bottom: 10px;
}
</style>
