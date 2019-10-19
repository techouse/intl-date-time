import { format as formatDate, isValid, parse } from "date-fns"

export default function parseDate(date, format) {
    if (typeof date !== "string") {
        return isValid(date) ? date : null
    }

    const parsed = parse(date, format, new Date())

    // if date is not valid or the formatted output after parsing does not match
    // the string value passed in (avoids overflows)
    if (!isValid(parsed) || formatDate(parsed, format) !== date) {
        return null
    }

    return parsed
}
