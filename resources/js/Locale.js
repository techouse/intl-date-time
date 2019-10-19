import { locales }                                       from "moment/src/locale/extracted"
import { flatpickrLocaleMapping, momentjsLocaleMapping } from "./InternationalMapper"

const locale = {
    flatpickr: {},
    momentjs: {},
}

// eslint-disable-next-line no-restricted-syntax
for (const code of Object.keys(flatpickrLocaleMapping)) {
    // eslint-disable-next-line import/no-dynamic-require,global-require
    locale.flatpickr[code] = require(`flatpickr/dist/l10n/${code}.js`)[flatpickrLocaleMapping[code].name]
}

// eslint-disable-next-line no-restricted-syntax
for (const code of Object.keys(momentjsLocaleMapping)) {
    locale.momentjs[code] = locales[code]
}

export default locale
