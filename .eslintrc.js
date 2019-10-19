module.exports = {
    parserOptions: {
        "ecmaVersion": 2018,
        "parser": "babel-eslint",
        "sourceType": "module"
    },
    extends: [
        "airbnb-base",
        "eslint:recommended",
        "plugin:vue/recommended",
    ],
    globals: {
        "process": true,
        "require": true,
        "moment": true,
        "Nova": true,
        "Vue": true,
    },
    env: {
        browser: true,
        es6: true,
        node: true
    },
    settings: {
        "import/resolver": {
            node: {
                extensions: [".mjs", ".js", ".json", ".vue"]
            }
        },
        "import/extensions": [
            ".js",
            ".mjs",
            ".jsx",
            ".vue"
        ],
        "import/core-modules": [],
        "import/ignore": [
            "node_modules",
            "\\.(coffee|scss|css|less|hbs|svg|json)$",
        ]
    },
    rules: {
        "no-multi-spaces": 0,
        "no-debugger": process.env.NODE_ENV === "production" ? 2 : 0,
        "no-console": 0,
        "camelcase": "off",
        "indent": "off",
        "linebreak-style": ["error", "unix"],
        "quotes": ["error", "double"],
        "semi": ["error", "never"],
        "max-len": ["error", 120, 2, {
            ignoreUrls: true,
            ignoreComments: false,
            ignoreRegExpLiterals: true,
            ignoreStrings: true,
            ignoreTemplateLiterals: true,
        }],
        "no-param-reassign": ["error", { "props": false }],
        "no-shadow": ["error", { "allow": ["state"] }],
        "object-curly-newline": "off",
        "vue/html-indent": ["error", 4],
        "vue/max-attributes-per-line": 0,
        "import/extensions": ["error", "always", {
            js: "never",
            mjs: "never",
            jsx: "never",
            ts: "never",
            tsx: "never",
            vue: "never"
        }],
        "no-new": "off",
    },
    plugins: [
        "import",
        "vue"
    ]
}
