const path = require('path');
module.exports = {
    // entry: './resources/assets/js/main.js',
    entry: './resources/assets/js/popup.media.js',
    output: {
        path:       path.resolve(__dirname, './public/admin_assets/js/'),
        publicPath: 'public/js/',
        // filename:   'build.js'
        filename:   'popup.media.js'
    },
    module: {
        rules: [
            {
                test:    /\.js$/,
                loader:  'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    /*vue: {
        loaders: {
            js: 'babel'
        }
    },*/
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.common.js'
        }
    }
}