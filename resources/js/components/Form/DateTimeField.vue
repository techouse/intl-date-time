<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div class="flex items-center">
                <intl-date-time-picker :field="field"
                                       :value="localizedValue"
                                       :date-format="dateFormat"
                                       :time-format="timeFormat"
                                       :enable-time="enableTime"
                                       :enable-seconds="enableSeconds"
                                       :placeholder="placeholder"
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
                        return DateTimeFormatConverter.momentToFlatpickr(`${this.field.dateFormat} ${this.timeFormat}`.trim())
                    } catch (e) {
                        console.warn(e)
                    }
                }

                return this.defaultFlatpickrFormat
            },

            timeFormat() {
                if (this.field.timeFormat) {
                    if (this.field.timeFormat.match(/^[Hh]{1,2}:[m]{1,2}(:[s]{1,2})?$/)) {
                        return this.field.timeFormat
                    }
                }

                return ''
            },

            enableTime() {
                return !!this.timeFormat
            },

            enableSeconds() {
                return !!(this.timeFormat && this.timeFormat.match(/:[s]{1,2}$/))
            },

            locale() {
                return this.field.locale || 'en-gb'
            },

            momentjsFormat() {
                return `${locales.momentjs[this.locale].L} ${this.timeFormat}`.replace(/[^ -~]+/g, '').trim()
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
                return this.field.dateFormat ? `${this.field.dateFormat} ${this.timeFormat}`.trim() : this.momentjsFormat
            },

            placeholder() {
                if ('placeholder' in this.field) {
                    if (this.field.placeholder) {
                        return this.field.placeholder
                    } else if (this.field.placeholder === false) {
                        return ''
                    }
                }
                return this.momentjsFormat
            }
        },

        methods: {
            /**
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
                this.$set(this, 'value', value ? moment(value, this.format).format(this.defaultMomentJSFormat) : '')
            },
        },
    }
</script>
