Nova.booting((Vue) => {
    Vue.component("IndexIntlDateTime", () => import(/* webpackChunkName: "index-intl-date-time" */ "./components/Index"))
    Vue.component("DetailIntlDateTime", () => import(/* webpackChunkName: "detail-intl-date-time" */ "./components/Detail"))
    Vue.component("FormIntlDateTime", () => import(/* webpackChunkName: "form-intl-date-time" */ "./components/Form"))
})
