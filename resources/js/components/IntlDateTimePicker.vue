<template>
    <input :ref="refName"
           :disabled="disabled"
           :dusk="field.attribute"
           :class="{'!cursor-not-allowed': disabled}"
           :value="value"
           :name="field.name"
           :placeholder="placeholder"
           v-mask="maskFormat"
           type="text">
</template>

<script>
    import flatpickr               from 'flatpickr'
    import DateTimeFormatConverter from '../DateTimeFormatConverter'
    import {momentjsLocaleMapping} from '../InternationalMapper'
    import {locale as locales}     from '../Locale'
    import {mask}                  from 'vue-the-mask'
    import {Validator}             from 'vee-validate'
    import {Errors}                from 'laravel-nova'

    export default {
        props: {
            field:              {
                type:     Object,
                required: true,
            },
            value:              {
                type:     String,
                required: false,
                default:  ''
            },
            disabled:           {
                type:    Boolean,
                default: false,
            },
            dateFormat:         {
                type:    String,
                default: ''
            },
            timeFormat:         {
                type:    String,
                default: ''
            },
            twelveHourTime:     {
                type:    Boolean,
                default: false,
            },
            enableTime:         {
                type:    Boolean,
                default: false,
            },
            enableSeconds:      {
                type:    Boolean,
                default: false,
            },
            locale:             {
                type:    String,
                default: 'en-gb'
            },
            errorMessageLocale: {
                type:    String,
                default: 'en'
            },
            placeholder:        {
                type:    String,
                default: ''
            }
        },

        directives: {
            mask
        },

        data() {
            return {
                refName:          "intlDatepickerInput",
                flatpickr:        null,
                validator:        new Validator(),
                validationError:  false,
                validationErrors: new Errors()
            }
        },

        mounted() {
            this.localizeValidator(this.errorMessageLocale)

            this.$nextTick(() => {
                this.flatpickr = flatpickr(this.$refs[this.refName], {
                    enableTime:    this.enableTime,
                    enableSeconds: this.enableSeconds,
                    onChange:      this.onChange,
                    onValueUpdate: this.onChange,
                    onClose:       this.onChange,
                    dateFormat:    this.dateFormatString,
                    allowInput:    true,
                    time_24hr:     true,
                    locale:        locales.flatpickr[momentjsLocaleMapping[this.locale].translation]
                })
            })
        },

        computed: {
            momentjsFormat() {
                return `${locales.momentjs[this.locale].L} ${this.timeFormat}`.replace(/[^ -~]+/g, '').trim()
            },

            dateFormatString() {
                if (this.dateFormat) {
                    return this.dateFormat
                } else {
                    try {
                        return DateTimeFormatConverter.momentToFlatpickr(this.momentjsFormat)
                    } catch (e) {
                        console.warn(e)
                    }

                    return 'd/m/Y H:i:S'
                }
            },

            maskFormat() {
                return this.momentjsFormat.replace(/\w/g, '#')
            },

            dateValidationRule() {
                return `date_format:${DateTimeFormatConverter.momentToDateFns(this.momentjsFormat)}`
            }
        },

        methods: {
            onChange(selectedDates, dateStr, instance) {
                if (dateStr) {
                    this.validator
                        .verify(dateStr, this.dateValidationRule, {name: this.field.name})
                        .then(({valid, errors}) => {
                            if (valid) {
                                this.$set(this, 'validationErrors', new Errors())
                                this.$set(this, 'validationError', false)
                                this.$emit('change', dateStr)
                            } else {
                                this.$set(this, 'validationErrors', new Errors(errors))
                                this.$set(this, 'validationError', true)
                                this.$emit('error', this.validationErrors)
                            }
                        })
                } else {
                    this.$set(this, 'validationErrors', new Errors())
                    this.$set(this, 'validationError', false)
                    this.$emit('change', dateStr)
                }
            },

            localizeValidator(localeName) {
                /**
                 * Asynchronously load the locale file then localize the validator with it
                 *
                 * Setting __webpack_public_path__ is a hacky solution but there is no other
                 * way changing the URL from which WebPack fetches these localization files.
                 */
                __webpack_public_path__ = ("/nova-vendor/intl-date-time/" + __webpack_public_path__)
                import(`../../../node_modules/vee-validate/dist/locale/${localeName}` /* webpackChunkName: "js/validation_locales/" */)
                    .then(locale => {
                        this.validator.localize(localeName, locale)
                    })
                    .catch(error => {
                        console.warn(`The error messages do not support the '${localeName}' locale. Defaulting back to English. Please define another locale manually with errorMessageLocale().`)
                    })
            }
        },
    }
</script>

<style scoped>
    .\!cursor-not-allowed {
        cursor: not-allowed !important;
    }
</style>
