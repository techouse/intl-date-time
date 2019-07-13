Nova.booting((Vue, router) => {
    Vue.component("index-intl-date-time", require("./components/Index/DateTimeField"))
    Vue.component("detail-intl-date-time", require("./components/Detail/DateTimeField"))
    Vue.component("form-intl-date-time", require("./components/Form/DateTimeField"))
})
