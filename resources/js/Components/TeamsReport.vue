<template>
    <div class="flex h-screen">
        <!-- Teams List -->
        <div class="w-1/4 border-r border-gray-300 p-4 overflow-y-auto">
            <h2 class="font-bold text-lg mb-4">Teams</h2>
            <ul>
                <li
                    v-for="team in teams"
                    :key="team.id"
                    class="mb-2 cursor-pointer"
                    :class="{'text-blue-600 font-semibold': selectedTeam?.id === team.id}"
                    @click="selectTeam(team)"
                >
                    {{ team.name }}
                </li>
            </ul>
        </div>

        <!-- Members List -->
        <div class="w-1/4 border-r border-gray-300 p-4 overflow-y-auto" v-if="selectedTeam">
            <h2 class="font-bold text-lg mb-4">{{ selectedTeam.name }} Members</h2>
            <ul>
                <li
                    v-for="member in selectedTeam.members"
                    :key="member.id"
                    class="mb-2 cursor-pointer"
                    :class="{'text-green-600 font-semibold': selectedMember?.id === member.id}"
                    @click="selectMember(member)"
                >
                    {{ member.name }} - {{ member.role }}
                </li>
            </ul>
        </div>

        <!-- Member History -->
        <div class="w-2/4 p-4 overflow-y-auto" v-if="selectedMember">
            <h2 class="font-bold text-lg mb-4">History of {{ selectedMember.name }}</h2>
            <ul>
                <li
                    v-for="(history, index) in selectedMember.history"
                    :key="index"
                    class="mb-2"
                >
                    <span class="block font-semibold">Team: {{ history.team }}</span>
                    <span class="block text-gray-600">Duration: {{ history.duration }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    setup() {
        // Sample data
        const teams = ref([
            {
                id: 1,
                name: "Team Alpha",
                members: [
                    {
                        id: 101,
                        name: "John Doe",
                        role: "Executive",
                        history: [
                            { team: "Team Alpha", duration: "Jan 2024 - Present" },
                            { team: "Team Beta", duration: "Aug 2023 - Dec 2023" },
                        ],
                    },
                    {
                        id: 102,
                        name: "Alice Smith",
                        role: "Team Lead",
                        history: [
                            { team: "Team Alpha", duration: "Feb 2024 - Present" },
                            { team: "Team Gamma", duration: "Jan 2023 - Jan 2024" },
                        ],
                    },
                ],
            },
            {
                id: 2,
                name: "Team Beta",
                members: [
                    {
                        id: 201,
                        name: "Mark Taylor",
                        role: "Executive",
                        history: [
                            { team: "Team Beta", duration: "Mar 2023 - Present" },
                            { team: "Team Alpha", duration: "Jan 2022 - Feb 2023" },
                        ],
                    },
                    {
                        id: 202,
                        name: "Emma Johnson",
                        role: "Team Lead",
                        history: [
                            { team: "Team Beta", duration: "Apr 2023 - Present" },
                            { team: "Team Delta", duration: "Jul 2022 - Mar 2023" },
                        ],
                    },
                ],
            },
        ]);

        const selectedTeam = ref(null);
        const selectedMember = ref(null);

        // Methods
        const selectTeam = (team) => {
            selectedTeam.value = team;
            selectedMember.value = null; // Reset member when team changes
        };

        const selectMember = (member) => {
            selectedMember.value = member;
        };

        return {
            teams,
            selectedTeam,
            selectedMember,
            selectTeam,
            selectMember,
        };
    },
};
</script>

<style scoped>
/* Optional: Add custom styling if needed */
</style>
