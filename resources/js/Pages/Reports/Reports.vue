<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Reports</h1>

        <!-- Tabs -->
        <div class="flex space-x-4 mb-6">
            <button
                @click="activeTab = 'breaks'"
                :class="activeTab === 'breaks' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'"
                class="py-2 px-6 rounded-lg shadow hover:bg-blue-400 transition"
            >
                Break Report
            </button>
            <button
                @click="activeTab = 'other'"
                :class="activeTab === 'other' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'"
                class="py-2 px-6 rounded-lg shadow hover:bg-blue-400 transition"
            >
                Other Reports
            </button>
        </div>

        <!-- Conditional Rendering -->
        <div
            v-if="activeTab === 'breaks'"
            class="bg-white shadow-md rounded-lg p-6"
        >
            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Break Report
            </h2>
            <p class="text-gray-600">Break reports content goes here...</p>
        </div>
        <div
            v-if="activeTab === 'other'"
            class="bg-white shadow-md rounded-lg p-6"
        >
            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Other Reports
            </h2>
            <p class="text-gray-600">Other reports content goes here...</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Reports",
    data() {
        return {
            activeTab: "breaks", // Default tab
        };
    },
};
</script>

<style scoped>
/* You can add any specific styles if needed */
</style>
