const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

const isProduction = process.env.NODE_ENV === 'production' || process.argv.includes('--mode=production');

module.exports = {
entry: {
main: ['./assets/src/js/main.js', './assets/src/scss/main.scss'],
admin: ['./assets/src/js/admin.js', './assets/src/scss/admin.scss']
},
output: {
path: path.resolve(__dirname, 'assets/dist'),
filename: 'js/[name].min.js',
clean: true
},
module: {
rules: [
// SCSS/SASS
{
test: /.(scss|sass)$/,
use: [
MiniCssExtractPlugin.loader,
'css-loader',
{
loader: 'postcss-loader',
options: {
postcssOptions: {
plugins: [
require('autoprefixer'),
require('postcss-preset-env')({
stage: 3,
features: {
'nesting-rules': true
}
})
]
}
}
},
'sass-loader'
]
},
// CSS
{
test: /.css$/,
use: [
MiniCssExtractPlugin.loader,
'css-loader',
{
loader: 'postcss-loader',
options: {
postcssOptions: {
plugins: [
require('autoprefixer'),
require('postcss-preset-env')({
stage: 3
})
]
}
}
}
]
},
// JavaScript (Babel)
{
test: /.js$/,
exclude: /node_modules/,
use: {
loader: 'babel-loader',
options: {
presets: [
['@babel/preset-env', {
targets: '> 0.25%, not dead',
modules: false
}]
]
}
}
},
// Images
{
test: /.(png|jpe?g|gif|svg|webp)$/i,
type: 'asset/resource',
generator: {
filename: 'images/[name][ext]'
}
},
// Fonts
{
test: /.(woff2?|eot|ttf|otf)$/i,
type: 'asset/resource',
generator: {
filename: 'fonts/[name][ext]'
}
}
]
},
plugins: [
new MiniCssExtractPlugin({
filename: 'css/[name].min.css',
chunkFilename: 'css/[id].min.css'
}),
new WebpackNotifierPlugin({
title: 'Container Theme Build',
alwaysNotify: true,
skipFirstNotification: true
})
],
optimization: {
minimize: true,
minimizer: [
new TerserPlugin({
extractComments: false,
terserOptions: {
compress: {
drop_console: isProduction,
drop_debugger: isProduction
},
output: {
comments: false
}
}
}),
new CssMinimizerPlugin({
minimizerOptions: {
preset: ['default', {
discardComments: { removeAll: true }
}]
}
})
],
splitChunks: {
cacheGroups: {
vendor: {
test: /[\/]node_modules[\/]/,
name: 'vendor',
chunks: 'all',
enforce: true
}
}
}
},
stats: {
colors: true,
modules: false,
children: false,
chunks: false,
chunkModules: false
}
};
