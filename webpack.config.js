const path = require("path");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
module.exports = {
    entry: {
        app: path.resolve(__dirname, "resources/ts/app.ts"),
    },

    output: {
        path: path.resolve(__dirname, "public/assets"),
        filename: "[name].bundle.js"
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                parallel: true,
                sourceMap: true // set to true if you want JS source maps
            }),
            new OptimizeCSSAssetsPlugin({})
        ]
    },
    resolve: {
        extensions: [".ts", ".json", ".js"]
    },
    module: {
        rules: [
            {
                test: /\.(ts|tsx)$/,
                use: [
                    'babel-loader',
                    'ts-loader'
                ],
                exclude: /node_modules/
            },
            {
                test: /\.s?css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader"
                ]
            },
            {
                test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader: "file-loader"
            },
            {
                test: /\.ico$/,
                use: [
                    {
                        loader: "file-loader",
                        options: {
                            name: "[name].[ext]"
                        }
                    }
                ]
            },
            {
                test: /\.(jpg|jpeg|gif|png)$/,
                exclude: /node_modules/,
                loader: 'url-loader?limit=1024&name=images/[name].[ext]'
            },
            {
                test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: "url-loader",
                        options: {
                            limit: 1000,
                            mimetype: "application/font-woff"
                        }
                    }
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css",
        })
    ]
};