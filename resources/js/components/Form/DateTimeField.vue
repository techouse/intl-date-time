<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div class="flex items-center">
                <intl-date-time-picker :field="field"
                                       :value="localizedValue"
                                       :date-format="dateFormat"
                                       :time-format="timeFormat"
                                       :locale="locale"
                                       class="w-full form-control form-input form-input-bordered"
                                       @change="handleChange"/>
                <span class="text-80 text-sm ml-2">({{ userTimezone }})</span>
            </div>
        </template>
    </default-field>
</template>

<script>
    import IntlDateTimePicker                                       from '../IntlDateTimePicker'
    import DateTimeFormatConverter                                  from '../../DateTimeFormatConverter'
    import {locale as locales}                                      from '../../Locale'
    import {FormField, HandlesValidationErrors, InteractsWithDates} from 'laravel-nova'

    export default {

        components: {
            IntlDateTimePicker
        },

        mixins: [HandlesValidationErrors,
                 FormField,
                 InteractsWithDates],

        data() {
            return {
                defaultMomentJSFormat: 'YYYY-MM-DD HH:mm:ss',
                localizedValue:        ''
            }
        },

        computed: {
            dateFormat() {
                if (this.field.dateFormat) {
                    try {
                        return DateTimeFormatConverter.momentToFlatpickr(`${this.field.dateFormat} ${this.timeFormat}`)
                    } catch (e) {
                        console.warn(e)
                    }
                }

                return this.defaultFlatpickrFormat
            },
            timeFormat() {
                return this.field.timeFormat || 'HH:mm:ss'
            },
            locale() {
                return this.field.locale || 'en-gb'
            },
            momentjsFormat() {
                return `${locales.momentjs[this.locale].L} ${this.timeFormat}`.replace(/[^ -~]+/g, '')
            },
            defaultFlatpickrFormat() {
                try {
                    return DateTimeFormatConverter.momentToFlatpickr(this.momentjsFormat)
                } catch (e) {
                    console.warn(e)
                }

                return 'd/m/Y H:i:S'
            },
            format() {
                return this.field.dateFormat ? `${this.field.dateFormat} ${this.timeFormat}` : this.momentjsFormat
            }
        },

        methods: {
            /*
             * Set the initial value for the field
             */
            setInitialValue() {
                // Set the initial value of the field
                this.$set(this, 'value', this.field.value || '')

                // If the field has a value let's convert it from the app's timezone
                // into the user's local time to display in the field
                if (this.value !== '') {
                    this.$set(this, 'localizedValue', moment(this.value, this.defaultMomentJSFormat).format(this.format))
                }
            },

            /**
             * Update the field's internal value when it's value changes
             */
            handleChange(value) {
                this.$set(this, 'value', moment(value, this.format).format(this.defaultMomentJSFormat))
            },
        },
    }
</script>
