'use strict';

const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const AssetsPlugin = require('assets-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const path = require('path');
const fs = require('fs');

// Make sure any symlinks in the project folder are resolved:
// https://github.com/facebookincubator/create-react-app/issues/637
const appDirectory = fs.realpathSync(process.cwd());

function resolveApp(relativePath) {
  return path.resolve(appDirectory, relativePath);
}

const paths = {
  appSrc: resolveApp('app/resources/js'),
  appBuild: resolveApp('build'),
  appIndexJs: resolveApp('app/resources/js/index.js'),
  appNodeModules: resolveApp('node_modules'),
};

const DEV = process.env.NODE_ENV === 'development';

module.exports = {
  bail: !DEV,
  // We generate sourcemaps in production. This is slow but gives good results.
  // You can exclude the *.map files from the build during deployment.
  target: 'web',
  devtool: DEV ? 'eval-cheap-source-map' : 'source-map',
  entry: [paths.appIndexJs],
  output: {
    path: paths.appBuild,
    filename: 'bundle.[hash:8].js',
  },
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin()],
  },
  module: {
    rules: [
      // Disable require.ensure as it's not a standard language feature.
      { parser: { requireEnsure: false } },
      // Transform ES6 with Babel
      {
        test: /\.js?$/,
        loader: 'babel-loader',
        include: paths.appSrc,
      },
      {
        test: /\.(css)$/,
        use: [MiniCssExtractPlugin.loader,'css-loader']
      },
      {
        test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'fonts/'
          }
        }]
      },
      {
        test: /\.s[ac]ss$/i,
        use: [
          // Creates `style` nodes from JS strings
          "style-loader",
          // Translates CSS into CommonJS
          "css-loader",
          // Compiles Sass to CSS
          "sass-loader",
        ],
      },
    ],
  },
  plugins: [
    !DEV && new CleanWebpackPlugin(['build']),
    new MiniCssExtractPlugin({filename: 'bundle.[hash:8].css'}),
    new webpack.EnvironmentPlugin({
      NODE_ENV: 'development', // use 'development' unless process.env.NODE_ENV is defined
      DEBUG: false,
    }),
    new AssetsPlugin({
      path: paths.appBuild,
      filename: 'assets.json',
    }),
  ].filter(Boolean),
};
