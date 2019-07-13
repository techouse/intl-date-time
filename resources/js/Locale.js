import {flatpickrLocaleMapping, momentjsLocaleMapping} from "./InternationalMapper"
import {locales}                                       from "moment/src/locale/extracted"

let flatpickrLocales = {},
    momentjsLocales  = {}

for (const code in flatpickrLocaleMapping) {
    flatpickrLocales[code] = require(`flatpickr/dist/l10n/${code}.js`)[flatpickrLocaleMapping[code].name]
}

for (const code in momentjsLocaleMapping) {
    momentjsLocales[code] = locales[code]
}

export const locale = {
    "flatpickr": flatpickrLocales,
    "momentjs":  momentjsLocales
}
