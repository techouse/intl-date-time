const flatpickrFormatMapping = {
    d: 'DD',
    D: 'ddd',
    l: 'dddd',
    j: 'D',
    J: 'Do',
    w: 'e',
    F: 'MMMM',
    m: 'MM',
    n: 'M',
    M: 'MMM',
    U: 'X',
    y: 'YY',
    Y: 'YYYY',
    Z: 'YYYY-MM-DDTHH:mm:ss.SSSZ',
    H: 'HH',
    h: 'H',
    i: 'mm',
    S: 'ss',
    s: 's',
    K: 'A'
}

const momentFormatMapping = {
    dddd: 'l',
    ddd:  'D',
    DD:   'd',
    Do:   'J',
    D:    'j',
    e:    'w',
    MMMM: 'F',
    MMM:  'M',
    MM:   'm',
    M:    'n',
    X:    'U',
    YYYY: 'Y',
    YY:   'y',
    HH:   'H',
    H:    'h',
    mm:   'i',
    ss:   'S',
    s:    's',
    A:    'K'
}

const delimiters = ['.', '-', '/', ':', ' ', '年', '日']

export default class DateTimeFormatConverter {
    static convertFormat(mapping, string) {
        string = string.replace(/[^ -~]+/g, '')

        let format = ''

        while (string.length > 0) {
            let advance = false

            for (let f in mapping) {
                if (mapping.hasOwnProperty(f)) {
                    if (string.startsWith(f)) {
                        // translate the format
                        format += mapping[f]
                        // remove the just parsed format
                        string = string.slice(f.length)

                        advance = true
                    } else if (delimiters.indexOf(string.slice(0, 1)) > -1) {
                        // add the delimiter which is usually the next character
                        format += string.slice(0, 1)
                        // trim it away from the string
                        string = string.slice(1)

                        advance = true
                    }
                }
            }

            if (!advance) {
                break;
            }
        }

        return format
    }

    /**
     * Converts a Moment.js datetime format to a Flatpickr format
     *
     * @param string
     * @returns {string}
     */
    static momentToFlatpickr(string) {
        if (string) {
            return this.convertFormat(momentFormatMapping, string)
        } else {
            throw "Empty input string provided!"
        }
    }

    /**
     * Converts a Flatpickr datetime format to a Moment.js format
     *
     * @param string
     * @returns {string}
     */
    static flatpickrToMoment(string) {
        if (string) {
            return this.convertFormat(flatpickrFormatMapping, string)
        } else {
            throw "Empty input string provided!"
        }
    }
}