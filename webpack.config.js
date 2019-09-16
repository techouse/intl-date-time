const path                    = require("path"),
      outputPath              = path.resolve(__dirname, "dist"),
      {CleanWebpackPlugin}    = require("clean-webpack-plugin"),
      MiniCssExtractPlugin    = require("mini-css-extract-plugin"),
      Fiber                   = require("fibers"),
      {VueLoaderPlugin}       = require("vue-loader"),
      OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin"),
      TerserPlugin            = require("terser-webpack-plugin"),
      ManifestPlugin          = require("webpack-manifest-plugin"),
      env                     = process.env.NODE_ENV,
      npm_config_argv         = JSON.parse(process.env.npm_config_argv),
      isWatch                 = npm_config_argv.remain.some(el => el.startsWith("--watch")),
      sourceMap               = env !== "production",
      production              = env === "production",
      webpack                 = require("webpack")

const config = {
    mode:         env,
    target:       "web",
    entry:        {
        field: [
            "./resources/js/field.js",
            "./resources/sass/field.scss"
        ]
    },
    output:       {
        path:          outputPath,
        publicPath:    "/nova-vendor/intl-date-time/",
        filename:      "js/[name].js",
        chunkFilename: "js/[name].js",
    },
    optimization: {},
    resolve:      {
        alias:      {
            "vue$": "vue/dist/vue.esm.js"
        },
        extensions: ["*", ".js", ".vue", ".json"],
        modules:    ["./node_modules",
                     "./resources/js/components",]
    },
    stats:        {
        colors: true
    },
    devtool:      sourceMap ? "cheap-module-eval-source-map" : undefined,
    module:       {
        rules: [
            {
                test:    /\.m?js$/,
                exclude: /node_modules/,
                loader:  "babel-loader"
            },
            {
                test:    /\.vue$/,
                exclude: /node_modules/,
                loader:  "vue-loader"
            },
            {
                test: /\.(sa|sc|c)ss$/i,
                use:  [
                    {
                        loader:  MiniCssExtractPlugin.loader,
                        options: {sourceMap}
                    },
                    {
                        loader:  "css-loader",
                        options: {
                            sourceMap,
                            importLoaders: 2
                        }
                    },
                    {loader: "postcss-loader", options: {sourceMap}},
                    "resolve-url-loader",
                    {
                        loader:  "sass-loader",
                        options: {
                            sourceMap,
                            implementation: require("sass"),
                            sassOptions:    {
                                fiber:        Fiber,
                                indentWidth:  4,
                                includePaths: [path.resolve(__dirname, "resources/scss")],
                            },
                        }
                    },]
            }
        ]
    },
    plugins:      [
        new webpack.ProgressPlugin(),
        new VueLoaderPlugin(),
        new CleanWebpackPlugin({cleanStaleWebpackAssets: !isWatch}),
        new MiniCssExtractPlugin({
            path:          outputPath + "/css",
            filename:      "css/[name].css",
            chunkFilename: "css/[name].css"
        }),
        new ManifestPlugin({
            fileName: "mix-manifest.json"
        })
    ]
}

if (production) {
    config.optimization.minimizer = [
        new OptimizeCSSAssetsPlugin(),
        new TerserPlugin({
            cache:         true,
            parallel:      true,
        }),
    ]
}

module.exports = config