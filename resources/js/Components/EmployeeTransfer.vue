<template>
    <div class="transfer-form">
        <label>Select Employee:</label>
        <select v-model="selectedEmployee">
            <option v-for="employee in availableEmployees" :value="employee.id" :key="employee.id">
                {{ employee.name }}
            </option>
        </select>

        <label>Select New Team:</label>
        <select v-model="selectedTeam">
            <option v-for="team in teams" :value="team.name" :key="team.id">
                {{ team.name }}
            </option>
        </select>

        <button @click="handleTransfer">Transfer Employee</button>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    teams: Array,
    employees: Array,
    team: Object,
});

const emit = defineEmits(['transfer']);

const selectedEmployee = ref(null);
const selectedTeam = ref(null);

// Filter out employees that are already in the current team
const availableEmployees = computed(() => {
    return props.employees.filter(e => e.currentTeam !== props.team.name);
});

function handleTransfer() {
    if (selectedEmployee.value && selectedTeam.value) {
        emit('transfer', selectedEmployee.value, selectedTeam.value);
        selectedEmployee.value = null;
        selectedTeam.value = null;
    }
}
</script>

<style scoped>
.transfer-form {
    margin-top: 20px;
}

select {
    margin: 5px;
    padding: 5px;
}

button {
    margin-top: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
</style>
