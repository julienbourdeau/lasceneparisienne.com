<template>
    <card class="flex flex-col center justify-center">
        <div class="text-xl">
            <div class="px-3 py-2">
                <span class="text-80 font-light">Fb Token:</span> <span class=" font-mono">{{ card.token }}</span>
            </div>
            <div class="px-3 py-2">
                <span class="text-80 font-light">Last updated:</span> <span class="font-semibold">{{ card.date }}</span> <span class="text-base">({{ card.diff }})</span>
            </div>
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    mounted() {
        //
    },
}
</script>
