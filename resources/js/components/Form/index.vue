<template>
    <default-field :field="field" :errors.sync="errors">
        <template slot="field">
            <div class="flex items-center">
                <intl-date-time-picker :field="field"
                                       :value="localizedValue"
                                       :date-format="dateFormat"
                                       :time-format="timeFormat"
                                       :enable-time="enableTime"
                                       :enable-seconds="enableSeconds"
                                       :min-date="minDate"
                                       :max-date="maxDate"
                                       :placeholder="placeholder"
                                       :locale="locale"
                                       :error-message-locale="errorMessageLocale"
                                       :class="validationError ? errorClass : null"
                                       class="w-full form-control form-input form-input-bordered"
                                       @change="handleChange"
                                       @error="handleError"
                />
                <span v-if="field.displayUserTimeZone" class="text-80 text-sm ml-2">({{ __(userTimezone) }})</span>
            </div>
            <help-text v-if="firstError" class="error-text mt-2 text-danger">
                {{ firstError }}
            </help-text>
        </template>
    </default-field>
</template>

<script>
    import { Errors, FormField, HandlesValidationErrors, InteractsWithDates } from "laravel-nova"
    import IntlDateTimePicker                                                 from "../IntlDateTimePicker"
    import DateTimeFormatConverter                                            from "../../DateTimeFormatConverter"
    import locales                                                            from "../../Locale"

    export default {
        components: {
            IntlDateTimePicker,
        },

        mixins: [HandlesValidationErrors,
                 FormField,
                 InteractsWithDates],

        data() {
            return {
                defaultMomentJSFormat: "YYYY-MM-DD HH:mm:ss",
                localizedValue: "",
                validationError: false,
                validationErrors: new Errors(),
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

            enableTime() {
                return !!this.timeFormat
            },

            enableSeconds() {
                return !!(this.timeFormat && this.timeFormat.match(/:[s]{1,2}$/))
            },

            locale() {
                return this.field.locale || "en-gb"
            },

            errorMessageLocale() {
                return this.field.errorMessageLocale || "en"
            },

            momentjsFormat() {
                return `${locales.momentjs[this.locale].L} ${this.timeFormat}`.replace(/[^ -~]+/g, "")
                                                                              .trim()
            },

            defaultFlatpickrFormat() {
                try {
                    return DateTimeFormatConverter.momentToFlatpickr(this.momentjsFormat)
                } catch (e) {
                    console.warn(e)
                }

                return "d/m/Y H:i:S"
            },

            format() {
                return this.field.dateFormat ? `${this.field.dateFormat} ${this.timeFormat}`.trim() : this.momentjsFormat
            },

            placeholder() {
                if ("placeholder" in this.field) {
                    if (this.field.placeholder) {
                        return this.field.placeholder
                    }
                    if (this.field.placeholder === false) {
                        return ""
                    }
                }
                return this.momentjsFormat
            },

            firstError() {
                if (this.validationErrors.errors.length) {
                    return this.field.errorMessage || this.validationErrors.errors[0]
                }
                return null
            },

            minDate() {
                return this.field.minDate ? moment(this.field.minDate) : null
            },

            maxDate() {
                return this.field.maxDate ? moment(this.field.maxDate) : null
            },
        },

        methods: {
            /**
             * Set the initial value for the field
             */
            setInitialValue() {
                // Set the initial value of the field
                this.$set(this, "value", this.field.value || "")

                // If the field has a value let's convert it from the app's timezone
                // into the user's local time to display in the field
                if (this.value !== "") {
                    this.$set(
                        this,
                        "localizedValue",
                        // fromAppTimezone
                        moment.tz(this.value, this.defaultMomentJSFormat, this.systemTimeZone)
                              .clone()
                              .tz(this.userTimezone)
                              .format(this.format),
                    )
                }
            },

            /**
             * Update the field's internal value when it's value changes and is valid at the same time
             */
            handleChange(value) {
                this.$set(this, "validationErrors", new Errors())
                this.$set(this, "validationError", false)

                this.$set(
                    this,
                    "value",
                    // toAppTimezone
                    value ? moment.tz(value, this.format, this.userTimezone)
                                  .clone()
                                  .tz(this.systemTimeZone)
                                  .toISOString()
                          : "",
                )
            },

            handleError({ errors }) {
                this.$set(this, "validationErrors", new Errors(errors))
                this.$set(this, "validationError", true)
            },
        },
    }
</script>
