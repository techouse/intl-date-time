<template>
    <span class="whitespace-no-wrap">{{ localizedDateTime }}</span>
</template>

<script>
    import {locale as locales}  from '../../Locale'
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
            dateFormat() {
                return this.field.dateFormat || locales.momentjs[this.locale].L
            },

            timeFormat() {
                if (this.field.timeFormat) {
                    if (this.field.timeFormat.match(/^[Hh]{1,2}:[m]{1,2}(:[s]{1,2})?$/)) {
                        return this.field.timeFormat
                    }
                }

                return ''
            },

            locale() {
                return this.field.locale || 'en-gb'
            },

            momentjsFormat() {
                return `${this.dateFormat} ${this.timeFormat}`.replace(/[^ -~]+/g, '').trim()
            },

            /**
             * Get the localized date time.
             */
            localizedDateTime() {
                return moment(this.field.value, this.defaultMomentJSFormat).format(this.momentjsFormat)
            },
        },
    }
</script>
