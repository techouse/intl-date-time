import {parseDate as parse} from "../utils/date"

const validate = (value, {format}) => !!parse(value, format)

const params = [
    {
        name: "format"
    }
]

export {
    validate,
    params
}

export default {
    validate,
    params
}