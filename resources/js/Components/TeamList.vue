<template>
    <div class="team-list">
        <h2>Teams</h2>
        <div v-for="team in teams" :key="team.id" class="team-card">
            <h3>{{ team.name }}</h3>
            <p><strong>Manager:</strong> {{ team.manager }}</p>
            <p><strong>Lead:</strong> {{ team.lead }}</p>
            <p><strong>Executives:</strong></p>
            <ul>
                <li v-for="exec in team.executives" :key="exec">{{ exec }}</li>
            </ul>

            <EmployeeTransferForm
                :team="team"
                :employees="employees"
                @transfer="transferEmployee"
            />
        </div>
    </div>
</template>

<script setup>
import EmployeeTransferForm from './EmployeeTransferForm.vue';

const props = defineProps({
    teams: Array,
    employees: Array,
});

const emit = defineEmits(['transfer']);

// Transfer employee from one team to another
function transferEmployee(employeeId, newTeam) {
    emit('transfer', employeeId, newTeam);
}
</script>

<style scoped>
.team-list {
    margin-top: 20px;
}

.team-card {
    background: #f4f4f4;
    padding: 15px;
    margin-bottom: 20px;
}
</style>

