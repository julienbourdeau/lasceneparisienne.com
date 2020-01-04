<template>
    <card class="flex flex-col justify-center px-4 text-2xl">
        <div class="py-2">
            <span class="font-bold">{{ card.total }}</span> <span class="text-80">total events</span>
        </div>
        <div class="py-2">
            <span class="font-bold">{{ card.upcoming }}</span> <span class="text-80">upcoming events</span>
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
