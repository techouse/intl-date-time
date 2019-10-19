Nova.booting((Vue) => {
    Vue.component("index-intl-date-time", () => import(/* webpackChunkName: "index-intl-date-time" */ "./components/Index"))
    Vue.component("detail-intl-date-time", () => import(/* webpackChunkName: "detail-intl-date-time" */ "./components/Detail"))
    Vue.component("form-intl-date-time", () => import(/* webpackChunkName: "form-intl-date-time" */ "./components/Form"))
})
