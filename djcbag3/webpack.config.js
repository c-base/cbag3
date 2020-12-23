var path = require("path");
var webpack = require('webpack')
var BundleTracker = require('webpack-bundle-tracker')

module.exports = {
    context: __dirname,
    entry: {
        index: './assets/redux/index',
        bootstrap: 'bootstrap-loader'
    },
    output: {
        path: path.resolve('./assets/bundles/'),
        filename: "[name]-[hash].js",
        publicPath: '/static/bundles/',
    },
    module: {
      rules: [
        { test: /\.scss$/, 
          use: [
            'style-loader', 
            'css-loader', 
            { loader: 'postcss-loader', options: { 
                config: { path: '.', },
                plugins: () => [require('autoprefixer')]
            } },
            'sass-loader'
            ] 
        },
        { test: /\.(jpe?g|png|gif)$/i, use: [ "file-loader" ] },
        { test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/, use: "url-loader?limit=10000&mimetype=application/font-woff", },
        { test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/, use: 'file-loader', },
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          use: {
            loader: "babel-loader"
          }
        },
        {
            test: /\.css$/,
            use: [
              { loader: "style-loader" },
              { loader: "css-loader" },
              { loader: "sass-loader" }
            ]
          }
      ]
    },
    plugins: [
        new webpack.ProvidePlugin({"window.Tether": "tether"}),
        new BundleTracker({filename: './webpack-stats.json'}),
    ],
    resolve: {
        modules: [
          path.join(__dirname, "assets/redux"),
          "node_modules"
        ],
        // enforceExtension: false,
        extensions: ['*', '.js', '.jsx']
    },
    // node: {
    //   // https://github.com/webpack-contrib/css-loader/issues/447
    //   // https://github.com/request/request/issues/1529
    //   fs: 'empty',
    //   net: 'empty',
    //   tls: 'empty'
    // }
};