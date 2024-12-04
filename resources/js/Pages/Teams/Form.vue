<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    team: {
        type: Object,
        default: () => ({
            name: '',
            description: '',
            department_id: '',
            members: []
        })
    },
    departments: {
        type: Array,
        required: true
    },
    employees: {
        type: Array,
        required: true
    },
    mode: {
        type: String,
        default: 'create'
    }
});

const emit = defineEmits(['close']);

const form = useForm({
    name: '',
    description: '',
    department_id: '',
    members: [{ employee_id: '', position: 'executive' }]
});

// Function to add new member field
const addMember = () => {
    form.members.push({
        employee_id: '',
        position: 'executive'
    });
};

// Function to remove member field
const removeMember = (index) => {
    form.members.splice(index, 1);
};

onMounted(() => {
    if (props.mode === 'edit' && props.team) {
        form.name = props.team.name;
        form.description = props.team.description;
        form.department_id = props.team.department_id;
        form.members = props.team.members.map(member => ({
            employee_id: member.id,
            position: member.pivot.position
        }));
    }
});

const submit = () => {
    if (props.mode === 'create') {
        form.post(route('teams.store'), {
            onSuccess: () => {
                emit('close');
                form.reset();
            },
        });
    } else {
        form.put(route('teams.update', props.team.id), {
            onSuccess: () => {
                emit('close');
            },
        });
    }
};
</script>

<template>
    <div class="mt-6 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] p-6">
        <!-- Basic Information -->
        <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
            <div class="flex flex-col gap-1">
                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Team Name</label>
                <input
                    type="text"
                    v-model="form.name"
                    placeholder="Team name..."
                    class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                >
                <div v-if="form.errors.name" class="text-danger text-sm">{{ form.errors.name }}</div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Team Description</label>
                <input
                    type="text"
                    v-model="form.description"
                    placeholder="Team description..."
                    class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                >
                <div v-if="form.errors.description" class="text-danger text-sm">{{ form.errors.description }}</div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Department</label>
                <select
                    v-model="form.department_id"
                    class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                >
                    <option value="">--Select Department--</option>
                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                        {{ dept.name }}
                    </option>
                </select>
                <div v-if="form.errors.department_id" class="text-danger text-sm">{{ form.errors.department_id }}</div>
            </div>

            <!-- Add Member Button -->
            <div class="flex items-end">
                <button
                    @click="addMember"
                    type="button"
                    class="text-sm px-4 py-1.5 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
                >
                    Add Member
                </button>
            </div>
        </div>

        <!-- Team Members -->
        <div class="mt-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
            <div class="w-full lg:col-span-4 md:col-span-3 sm:col-span-2 col-span-1">
                   <label class="font-semibold text-lg text-dark/80 dark:text-light/80">Team Members</label>
            </div>
            <div v-for="(member, index) in form.members" :key="index">
               <div class="w-full flex flex-col gap-2 bg-lightTrans dark:bg-dark p-4 rounded-md shadow-md shadow-dark/10 dark:shadow-light/10">
                   <div class="flex items-center justify-between border-b-[1px] border-b-dark/10 dark:border-b-light/10 pb-2">
                       <span class="text-dark/80 dark:text-light/80 font-bold">Employee {{index+1}}</span>
                       <button
                           @click="removeMember(index)"
                           type="button"
                           class="h-6 w-6 rounded-full text-danger hover:bg-danger/20 text-sm font-semibold cursor-pointer transition ease-in duration-2000"
                       >
                           <i class="fa fa-trash"></i>
                       </button>
                   </div>


                   <div class="flex flex-col gap-1">
                       <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Employee</label>
                       <select
                           v-model="member.employee_id"
                           class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                       >
                           <option value="">--Select Employee--</option>
                           <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                               {{ emp.first_name }}
                           </option>
                       </select>
                   </div>

                   <div class="flex flex-col gap-1">
                       <label class="font-semibold text-sm text-dark/80 dark:text-light/80">Position</label>
                       <select
                           v-model="member.position"
                           class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans"
                       >
                           <option value="manager">Manager</option>
                           <option value="team_lead">Team Lead</option>
                           <option value="executive">Executive</option>
                       </select>
                   </div>

               </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="w-full flex justify-end gap-2 py-4 mt-4">
            <button
                @click="submit"
                :disabled="form.processing"
                class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
            >
                {{ mode === 'create' ? 'Create New Team' : 'Update Team' }}
            </button>
            <button
                @click="$emit('close')"
                class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000"
            >
                Cancel
            </button>
        </div>
    </div>
</template>
