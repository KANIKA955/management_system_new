<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TeamForm from './Form.vue';
import TransferForm from './TransferForm.vue';
import TransferHistory from './TransferHistory.vue';

const props = defineProps({
    teams: {
        type: Array,
        required: true
    },
    departments: {
        type: Array,
        required: true
    },
    employees: {
        type: Array,
        required: true
    }
});

const isFormVisible = ref(false);
const isTeamMembersTableVisible = ref(false);
const isTransferFormVisible = ref(false);
const showTransferHistoryModal = ref(false);
const selectedTeam = ref(null);
const selectedMember = ref(null);
const editingTeam = ref(null);

const toggleForm = (team = null) => {
    editingTeam.value = team;
    isFormVisible.value = !isFormVisible.value;
};

const showTeamMemberTable = (team) => {
    selectedTeam.value = team;
    isTeamMembersTableVisible.value = !isTeamMembersTableVisible.value;
};

const showTransferForm = (member, team) => {
    selectedMember.value = member;
    selectedTeam.value = team;
    isTransferFormVisible.value = true;
};

const closeTransferForm = () => {
    isTransferFormVisible.value = false;
    selectedMember.value = null;
};

const showTransferHistory = (member) => {
    selectedMember.value = member;
    showTransferHistoryModal.value = true;
};

const closeTransferHistory = () => {
    showTransferHistoryModal.value = false;
    selectedMember.value = null;
};

const deleteTeam = (id) => {
    if (confirm('Are you sure you want to delete this team?')) {
        router.delete(route('teams.destroy', id));
    }
};

const getPositionClass = (position) => {
    switch (position) {
        case 'manager':
            return 'text-primary dark:text-info';
        case 'team_lead':
            return 'text-success';
        case 'executive':
            return 'text-warning';
        default:
            return 'text-dark/80 dark:text-light/80';
    }
};
</script>

<template>
    <AppLayout title="Teams">
        <!-- Heading and Create/Edit Team Form -->
        <div class="flex flex-col py-2">
            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between p-4">
                <span class="text-xl font-bold text-dark/80 dark:text-light/80">Teams</span>
                <button
                    v-show="!isFormVisible"
                    @click="toggleForm()"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    Add New Team
                </button>
                <button
                    v-show="isFormVisible"
                    @click="toggleForm()"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    <i class="fa fa-xmark"></i>
                </button>
            </div>

            <!-- Team Form Component -->
            <TeamForm
                v-if="isFormVisible"
                :team="editingTeam"
                :departments="departments"
                :employees="employees"
                :mode="editingTeam ? 'edit' : 'create'"
                @close="toggleForm()"
            />
        </div>

        <!-- Teams Table -->
        <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
            <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                <thead>
                <tr class="bg-lightTrans dark:bg-dark">
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DESCRIPTION</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DEPARTMENT</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">MEMBERS</th>
                    <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(team, index) in teams" :key="team.id" :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}">
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        {{ index + 1 }}
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold cursor-pointer">{{ team.name }}</span>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ team.description }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <p>{{ team.department.name }}</p>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex pl-2">
                            <div
                                @click="showTeamMemberTable(team)"
                                class="h-8 w-8 rounded-full border-[2px] border-primary/70 dark:border-info/70 bg-light text-sm dark:bg-darkTrans text-primary dark:text-info font-semibold hover:scale-110 transition ease-in duration-2000 cursor-pointer flex justify-center items-center -ml-2"
                            >
                                <span>{{ team.members.length }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                        <div class="flex gap-2">
                            <button
                                @click="toggleForm(team)"
                                class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Edit Team"
                            >
                                <i class="fa-regular fa-edit text-md"></i>
                            </button>
                            <button
                                @click="deleteTeam(team.id)"
                                class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                title="Delete Team"
                            >
                                <i class="fa-regular fa-trash-can text-md"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Team Members Modal/Table -->
        <div class="mt-6" v-if="isTeamMembersTableVisible && selectedTeam">
            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex justify-between px-4 py-2">
                <span class="text-md font-bold text-dark/80 dark:text-light/80">Members in {{ selectedTeam.name }}</span>
                <button
                    @click="showTeamMemberTable(null)"
                    class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    <i class="fa fa-xmark"></i>
                </button>
            </div>
            <div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                    <thead>
                    <tr class="bg-lightTrans dark:bg-dark">
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.NO.</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">EMAIL</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">POSITION</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">PHONE</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">DEPARTMENT</th>
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="(member, index) in selectedTeam.members"
                        :key="member.id"
                        :class="{'bg-lightTrans/40 dark:bg-dark/40': index % 2 !== 0}"
                    >
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ index + 1 }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold cursor-pointer">{{ member.first_name }}</span>
                            </div>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ member.email }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                                <span
                                    :class="[getPositionClass(member.pivot.position), 'font-semibold capitalize']"
                                >
                                    {{ member.pivot.position }}
                                </span>
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ member.phone }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ member.department?.name }}
                        </td>
                        <td class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            <div class="flex gap-2">
                                <button
                                    @click="showTransferForm(member, selectedTeam)"
                                    class="h-8 w-8 rounded-full text-warning hover:bg-warning/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                    title="Transfer Member"
                                >
                                    <i class="fa fa-exchange-alt"></i>
                                </button>
                                <button
                                    @click="showTransferHistory(member)"
                                    class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000"
                                    title="View Transfer History"
                                >
                                    <i class="fa fa-history"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Team Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="p-4 rounded-lg bg-lightTrans/40 dark:bg-dark/40">
                        <div class="text-lg font-semibold text-primary dark:text-info mb-2">
                            Managers
                        </div>
                        <div class="text-3xl font-bold text-dark/80 dark:text-light/80">
                            {{ selectedTeam.members.filter(m => m.pivot.position === 'manager').length }}
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-lightTrans/40 dark:bg-dark/40">
                        <div class="text-lg font-semibold text-success mb-2">
                            Team Leads
                        </div>
                        <div class="text-3xl font-bold text-dark/80 dark:text-light/80">
                            {{ selectedTeam.members.filter(m => m.pivot.position === 'team_lead').length }}
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-lightTrans/40 dark:bg-dark/40">
                        <div class="text-lg font-semibold text-warning mb-2">
                            Executives
                        </div>
                        <div class="text-3xl font-bold text-dark/80 dark:text-light/80">
                            {{ selectedTeam.members.filter(m => m.pivot.position === 'executive').length }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Form Modal -->
        <TransferForm
            v-if="isTransferFormVisible"
            :member="selectedMember"
            :current-team="selectedTeam"
            :teams="teams.filter(t => t.id !== selectedTeam?.id)"
            @close="closeTransferForm"
        />

        <!-- Transfer History Modal -->
        <TransferHistory
            v-if="showTransferHistoryModal"
            :member="selectedMember"
            @close="closeTransferHistory"
        />

        <!-- Empty State for No Teams -->
        <div
            v-if="teams.length === 0 && !isFormVisible"
            class="mt-6 text-center py-12 bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px]"
        >
            <div class="text-dark/60 dark:text-light/60 mb-4">
                <i class="fa fa-users text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-dark/80 dark:text-light/80 mb-2">
                No Teams Created Yet
            </h3>
            <p class="text-dark/60 dark:text-light/60 mb-4">
                Get started by creating your first team
            </p>
            <button
                @click="toggleForm()"
                class="text-sm px-6 py-2 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
            >
                Create Team
            </button>
        </div>
    </AppLayout>
</template>
