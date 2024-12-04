<template>
    <div class="team-management">
        <div class="row">
            <!-- Left Column: List of Teams -->
            <div class="col-md-3">
                <h3>Teams</h3>
                <ul class="list-group">
                    <li
                        v-for="team in teams"
                        :key="team.id"
                        class="list-group-item"
                        @click="selectTeam(team)"
                    >
                        {{ team.name }}
                    </li>
                </ul>
            </div>

            <!-- Middle Column: Team Members -->
            <div class="col-md-5">
                <h3>Team Members</h3>
                <div v-if="selectedTeam">
                    <p><strong>Team:</strong> {{ selectedTeam.name }}</p>
                    <ul class="list-group">
                        <li
                            v-for="member in selectedTeam.members"
                            :key="member.id"
                            class="list-group-item"
                        >
                            {{ member.name }} - {{ member.role }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Team History -->
            <div class="col-md-4">
                <h3>Team History</h3>
                <div v-if="selectedMemberHistory">
                    <h5>{{ selectedMemberHistory.name }}'s History</h5>
                    <ul class="list-group">
                        <li
                            v-for="history in selectedMemberHistory.history"
                            :key="history.id"
                            class="list-group-item"
                        >
                            <strong>{{ history.old_team_name }}</strong> to <strong>{{ history.new_team_name }}</strong>
                            <br>
                            <small>Joined: {{ history.joined_at }} - Left: {{ history.left_at }}</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teams: [], // List of all teams
            selectedTeam: null, // Currently selected team
            selectedMemberHistory: null, // History of the selected member
        };
    },
    methods: {
        // Fetch the teams from the server
        async fetchTeams() {
            const response = await axios.get('/api/teams');
            this.teams = response.data;
        },

        // Select a team and load its members
        selectTeam(team) {
            this.selectedTeam = team;
            this.selectedMemberHistory = null; // Clear history when switching teams

            // Fetch team members
            this.fetchTeamMembers(team.id);
        },

        // Fetch members of the selected team
        async fetchTeamMembers(teamId) {
            const response = await axios.get(`/api/teams/${teamId}/members`);
            this.selectedTeam.members = response.data;
        },

        // Load team history for a selected member
        async loadMemberHistory(memberId) {
            const response = await axios.get(`/api/employee/${memberId}/history`);
            this.selectedMemberHistory = response.data;
        },
    },

    mounted() {
        this.fetchTeams(); // Fetch the teams when the component is mounted
    },
};
</script>

<style scoped>
.team-management {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.row {
    display: flex;
    flex-wrap: wrap;
}

.col-md-3,
.col-md-5,
.col-md-4 {
    margin: 10px;
}
</style>
