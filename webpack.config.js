const path                      = require("path"),
      outputPath                = path.resolve(__dirname, "dist"),
      { CleanWebpackPlugin }    = require("clean-webpack-plugin"),
      MiniCssExtractPlugin      = require("mini-css-extract-plugin"),
      { VueLoaderPlugin }       = require("vue-loader"),
      CssMinimizerPlugin        = require("css-minimizer-webpack-plugin"),
      TerserPlugin              = require("terser-webpack-plugin"),
      { WebpackManifestPlugin } = require("webpack-manifest-plugin"),
      env                       = process.env.NODE_ENV,
      isWatch                   = process.env.npm_lifecycle_event === "watch",
      sourceMap                 = env !== "production",
      production                = env === "production",
      webpack                   = require("webpack")

const config = {
    mode: env,
    target: "web",
    entry: {
        field: [
            "./resources/js/field.js",
            "./resources/sass/field.scss"
        ]
    },
    output: {
        path: outputPath,
        publicPath: "/nova-vendor/intl-date-time/",
        filename: "js/[name].js",
        chunkFilename: "js/[name].js",
    },
    optimization: {},
    resolve: {
        alias: {
            "vue$": "vue/dist/vue.esm.js"
        },
        extensions: ["*", ".js", ".vue", ".json"],
        modules: [
            "./node_modules",
            "./resources/js/components",
        ],
    },
    stats: {
        colors: true
    },
    devtool: sourceMap ? "eval-cheap-module-source-map" : undefined,
    module: {
        rules: [
            {
                test: /\.m?js$/,
                loader: "babel-loader"
            },
            {
                test: /\.vue$/,
                loader: "vue-loader"
            },
            {
                test: /\.(sa|sc|c)ss$/i,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap,
                            importLoaders: 2
                        }
                    },
                    { loader: "postcss-loader", options: { sourceMap } },
                    { loader: "resolve-url-loader", options: { sourceMap } },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap,
                            implementation: require("sass"),
                            sassOptions: {
                                indentWidth: 4,
                                includePaths: [path.resolve(__dirname, "resources/scss")],
                            },
                        }
                    },]
            }
        ]
    },
    plugins: [
        new webpack.ProgressPlugin(),
        new VueLoaderPlugin(),
        new CleanWebpackPlugin({ cleanStaleWebpackAssets: !isWatch }),
        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "css/[name].css"
        }),
        new WebpackManifestPlugin({
            fileName: "mix-manifest.json"
        })
    ]
}

if (production) {
    config.optimization.minimizer = [
        new CssMinimizerPlugin(),
        new TerserPlugin({
            parallel: true,
            extractComments: true,
        }),
    ]
}

module.exports = config
