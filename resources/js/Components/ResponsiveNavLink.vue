<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-sm bg-gradient-to-r from-primary to-primary/60 dark:from-info/60 dark:to-info text-light/80'
        : 'w-full hover:bg-darkTrans/10 dark:hover:bg-lightTrans/10 flex px-2 items-center rounded-[7px] mb-1 text-sm';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'"  class="w-full bg-gradient-to-r from-danger to-danger/80 hover:bg-danger text-light  flex px-2 items-center justify-center rounded-[7px] mb-1 transition ease-in duration-2000">
            <slot />
        </button>

        <Link v-else :href="href" >
            <div :class="classes">
                <slot />
            </div>
        </Link>
    </div>
</template>
