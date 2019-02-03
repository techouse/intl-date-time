<template>
    <span class="whitespace-no-wrap">{{ localizedDateTime }}</span>
</template>

<script>
    import {InteractsWithDates} from 'laravel-nova'

    export default {
        mixins: [InteractsWithDates],

        props: {
            resourceName: {
                type:     String,
                required: true
            },
            field:        {
                type:     Object,
                required: true
            }
        },

        data() {
            return {
                defaultMomentJSFormat: 'YYYY-MM-DD HH:mm:ss',
            }
        },

        computed: {
            /**
             * Get the localized date time.
             */
            localizedDateTime() {
                return moment(this.field.value, this.defaultMomentJSFormat).format(this.field.format)
            },
        },
    }
</script>
