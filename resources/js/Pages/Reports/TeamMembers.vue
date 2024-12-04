<template>
    <AppLayout title="TeamMember Report">
        <div class="p-6">
            <div class="flex h-screen">
                <!-- Left Column: Teams -->
                <div class="w-1/4 p-4 bg-gray-100">
                    <h2 class="text-xl font-bold mb-4">Teams</h2>
                    <ul>
                        <li
                            v-for="team in teams"
                            :key="team.id"
                            class="cursor-pointer p-2 rounded mb-2 bg-white shadow hover:bg-blue-100"
                            @click="selectTeam(team)"
                        >
                            {{ team.name }}
                        </li>
                    </ul>
                </div>

                <!-- Middle Column: Members -->
                <div class="w-1/4 p-4 bg-gray-50">
                    <h2 class="text-xl font-bold mb-4" v-if="selectedTeam">
                        Members of {{ selectedTeam.name }}
                    </h2>
                    <ul>
                        <li
                            v-for="member in selectedTeam?.members || []"
                            :key="member.employee_id"
                            class="cursor-pointer p-2 rounded mb-2 bg-white shadow hover:bg-green-100"
                            @click="selectMember(member)"
                        >
                            {{ member.first_name }} {{ member.last_name }} - {{ member.role }}
                        </li>
                    </ul>
                </div>

                <!-- Right Column: Member History -->
                <div class="w-1/2 p-4">
                    <h2 class="text-xl font-bold mb-4" v-if="selectedMember">
                        History of {{ selectedMember.first_name }} {{ selectedMember.last_name }}
                    </h2>
                    <ul>
                        <li
                            v-for="entry in selectedMember?.history || []"
                            :key="entry.id"
                            class="p-2 rounded mb-2 bg-white shadow"
                        >
                            <p><strong>Team:</strong> {{ entry.team }}</p>
                            <p><strong>Role:</strong> {{ entry.role }}</p>
                            <p><strong>Period:</strong> {{ entry.start_date }} - {{ entry.end_date || "Present" }}</p>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
     </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            teams: [
                {
                    id: 1,
                    name: "Team Alpha",
                    members: [
                        {
                            employee_id: 101,
                            first_name: "John",
                            last_name: "Doe",
                            role: "executive",
                            history: [
                                {
                                    id: 1,
                                    team: "Team Alpha",
                                    role: "executive",
                                    start_date: "2023-01-01",
                                    end_date: null,
                                },
                            ],
                        },
                        {
                            employee_id: 102,
                            first_name: "Jane",
                            last_name: "Smith",
                            role: "team_lead",
                            history: [
                                {
                                    id: 1,
                                    team: "Team Beta",
                                    role: "executive",
                                    start_date: "2022-01-01",
                                    end_date: "2022-12-31",
                                },
                                {
                                    id: 2,
                                    team: "Team Alpha",
                                    role: "team_lead",
                                    start_date: "2023-01-01",
                                    end_date: null,
                                },
                            ],
                        },
                    ],
                },
                {
                    id: 2,
                    name: "Team Beta",
                    members: [
                        {
                            employee_id: 201,
                            first_name: "Alice",
                            last_name: "Brown",
                            role: "manager",
                            history: [
                                {
                                    id: 1,
                                    team: "Team Beta",
                                    role: "manager",
                                    start_date: "2020-01-01",
                                    end_date: null,
                                },
                            ],
                        },
                    ],
                },
            ],
            selectedTeam: null,
            selectedMember: null,
        };
    },
    methods: {
        selectTeam(team) {
            this.selectedTeam = team;
            this.selectedMember = null; // Reset member selection when team changes
        },
        selectMember(member) {
            this.selectedMember = member;
        },
    },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
