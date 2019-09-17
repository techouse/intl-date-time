import Index from "./components/Index"
import Detail from "./components/Detail"
import Form from "./components/Form"

Nova.booting(Vue => {
    Vue.component("index-intl-date-time", Index)
    Vue.component("detail-intl-date-time", Detail)
    Vue.component("form-intl-date-time", Form)
})
