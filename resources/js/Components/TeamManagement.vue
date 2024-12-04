<template>
    <div class="team-management bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] mb-6">
        <h2 class="font-semibold text-xl">Team Management</h2>

        <!-- Employee Selection Dropdown -->
        <div class="mt-4">
            <label class="block">Select Employee</label>
            <select v-model="selectedEmployeeId" class="w-full p-2 border rounded-md">
                <option disabled value="">-- Select an Employee --</option>
                <option v-for="employee in employeeList" :key="employee.id" :value="employee.id">
                    {{ employee.name }} ({{ employee.role }})
                </option>
            </select>
        </div>

        <!-- Team Selection Dropdown -->
        <div class="mt-4">
            <label class="block">Select Team</label>
            <select v-model="selectedTeamId" class="w-full p-2 border rounded-md">
                <option disabled value="">-- Select a Team --</option>
                <option v-for="team in teamList" :key="team.id" :value="team.id">
                    {{ team.name }}
                </option>
            </select>
        </div>

        <!-- Team Designation Dropdown (Initially Hidden) -->
        <div class="mt-4" v-if="actions.addToTeam">
            <label class="block">Select Designation</label>
            <select v-model="teamDesignation" class="w-full p-2 border rounded-md">
                <option disabled value="">-- Select a Designation --</option>
                <option value="manager">Manager</option>
                <option value="team_lead">Team Lead</option>
                <option value="executive">Executive</option>
            </select>
        </div>

        <!-- Action Radio Buttons -->
        <div class="mt-4">
            <label class="block mb-2">Actions</label>
            <div class="flex flex-wrap gap-4">
                <label class="flex items-center mb-2">
                    <input type="radio" v-model="selectedAction" value="addToTeam" class="mr-2" />
                    Add to Team
                </label>
                <label class="flex items-center mb-2">
                    <input type="radio" v-model="selectedAction" value="deleteFromTeam" class="mr-2" />
                    Delete from Team
                </label>
                <label class="flex items-center mb-2">
                    <input type="radio" v-model="selectedAction" value="transferToTeam" class="mr-2" />
                    Transfer to Team
                </label>
                <label class="flex items-center mb-2">
                    <input type="radio" v-model="selectedAction" value="makeTeamLead" class="mr-2" />
                    Make Team Lead
                </label>
            </div>
        </div>

        <div class="mt-4">
            <button
                @click="manageTeam"
                :disabled="!selectedEmployeeId || !selectedAction || (actions.addToTeam && !teamDesignation) || !selectedTeamId"
                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed"
            >
                Submit
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

// Destructure props
const props = defineProps({
    employeeList: {
        type: Array,
        required: true,
    },
    teamList: {
        type: Array,
        required: true,
    },
});

// Reactive Variables
const selectedEmployeeId = ref('');
const selectedTeamId = ref('');
const teamDesignation = ref('');
const selectedAction = ref('');

// Computed state for visibility of teamDesignation dropdown
const actions = {
    get addToTeam() {
        return selectedAction.value === 'addToTeam';
    },
    get deleteFromTeam() {
        return selectedAction.value === 'deleteFromTeam';
    },
    get transferToTeam() {
        return selectedAction.value === 'transferToTeam';
    },
    get makeTeamLead() {
        return selectedAction.value === 'makeTeamLead';
    },
};

// Manage Team Action Function
const manageTeam = async () => {
    if (!selectedEmployeeId.value || !selectedAction.value) {
        alert('Please select an employee and an action.');
        return;
    }

    try {
        switch (selectedAction.value) {
            case 'addToTeam':
                if (!selectedTeamId.value || !teamDesignation.value) {
                    alert('Please select a team and a designation.');
                    return;
                }
                await axios.post('/api/teams/add', {
                    employee_id: selectedEmployeeId.value,
                    team_id: selectedTeamId.value,
                    position: teamDesignation.value,
                });
                break;

            case 'deleteFromTeam':
                if (!selectedTeamId.value) {
                    alert('Please select a team.');
                    return;
                }
                await axios.delete('/api/teams/remove', {
                    data: { employee_id: selectedEmployeeId.value, team_id: selectedTeamId.value },
                });
                break;

            case 'transferToTeam':
                if (!selectedTeamId.value) {
                    alert('Please select a new team.');
                    return;
                }
                await axios.post('/api/teams/transfer', {
                    employee_id: selectedEmployeeId.value,
                    current_team_id: selectedTeamId.value, // Assume `current_team_id` is set elsewhere
                    new_team_id: selectedTeamId.value,
                });
                break;

            case 'makeTeamLead':
                if (!selectedTeamId.value) {
                    alert('Please select a team.');
                    return;
                }
                await axios.post('/api/teams/make-lead', {
                    employee_id: selectedEmployeeId.value,
                    team_id: selectedTeamId.value,
                });
                break;

            default:
                alert('Invalid action selected.');
        }

        alert('Action completed successfully.');
    } catch (error) {
        console.error(error);
        alert('An error occurred while processing your request.');
    }
};
</script>

<style scoped>
.team-management {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

button:disabled {
    cursor: not-allowed;
}
</style>
