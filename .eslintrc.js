module.exports = {
    parserOptions: {
        "parser":      "babel-eslint",
        "ecmaVersion": 2017,
        "sourceType":  "module"
    },
    extends:       [
        "eslint:recommended",
        "plugin:vue/recommended"
    ],
    globals:       {
        "Nova":    true,
        "moment":  true,
        "require": true,
        "Vue":     true
    },
    env:           {
        browser: true
    },
    // add your custom rules here
    rules:         {
        // allow paren-less arrow functions
        "arrow-parens":                0,
        // allow async-await
        "generator-star-spacing":      0,
        // allow debugger during development
        "no-debugger":                 process.env.NODE_ENV === "production" ? 2 : 0,
        "no-tabs":                     2,
        "no-console":                  0,
        "linebreak-style":             ["error", "unix"],
        "quotes":                      ["error", "double"],
        "semi":                        ["error", "never"],
        "vue/html-indent":             ["error", 4],
        "vue/max-attributes-per-line": 0
    }
}