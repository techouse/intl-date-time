import {flatpickrLocaleMapping, momentjsLocaleMapping} from './InternationalMapper'

let flatpickrLocales = {},
    momentjsLocales  = {}

for (const code in flatpickrLocaleMapping) {
    flatpickrLocales[code] = require(`flatpickr/dist/l10n/${code}.js`)[flatpickrLocaleMapping[code].name]
}

for (const code in momentjsLocaleMapping) {
    momentjsLocales[code] = require(`moment/src/locale/${code}.js`).default._longDateFormat
}

export const locale = {
    'flatpickr': flatpickrLocales,
    'momentjs':  momentjsLocales
}
