<template>
    <panel-item :field="field">
        <template slot="value">
            <p v-if="field.value" class="text-90">
                {{ localizedDateTime }}
                <span v-if="field.displayUserTimeZone" class="text-80 text-sm ml-2">({{ __(userTimezone) }})</span>
            </p>
            <p v-else>
                &mdash;
            </p>
        </template>
    </panel-item>
</template>

<script>
    import { InteractsWithDates } from "laravel-nova"
    import locales                from "../../Locale"

    export default {
        mixins: [InteractsWithDates],

        props: {
            resource: {
                type: Object,
                required: true,
            },
            resourceName: {
                type: String,
                required: true,
            },
            resourceId: {
                type: [Number, String],
                required: true,
            },
            field: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                defaultMomentJSFormat: "YYYY-MM-DD HH:mm:ss",
            }
        },

        computed: {
            systemTimeZone() {
                if (this.field.timeZone) {
                    return this.field.timeZone
                }
                return "UTC"
            },

            userTimezone: () => Nova.config.userTimezone || moment.tz.guess(),

            dateFormat() {
                return this.field.dateFormat || locales.momentjs[this.locale].L
            },

            timeFormat() {
                if (this.field.timeFormat) {
                    if (this.field.timeFormat.match(/^[Hh]{1,2}:[m]{1,2}(:[s]{1,2})?$/)) {
                        return this.field.timeFormat
                    }
                } else {
                    if (this.field.displayLocaleTime) {
                        return locales.momentjs[this.locale].LTS
                    }
                    if (this.field.displayLocaleTimeShort) {
                        return locales.momentjs[this.locale].LT
                    }
                }

                return ""
            },

            locale() {
                return this.field.locale || "en-gb"
            },

            momentjsFormat() {
                return `${this.dateFormat} ${this.timeFormat}`.replace(/[^ -~]+/g, "")
                                                              .trim()
            },

            /**
             * Get the localized date time.
             */
            localizedDateTime() {
                // fromAppTimezone
                return moment.tz(this.field.value, this.defaultMomentJSFormat, this.systemTimeZone)
                             .clone()
                             .tz(this.userTimezone)
                             .format(this.momentjsFormat)
            },
        },
    }
</script>
