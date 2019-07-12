// webpack.config.js

const path = require('path');
var CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
  entry: './assets/build/js/app.js',
  output: {
    path: path.resolve(__dirname, 'assets/dist/js'),
    filename: 'bundle.js'
  },
  plugins: [
	  new CopyWebpackPlugin([
          {from:path.resolve(__dirname, 'assets/build/img'),to:path.resolve(__dirname, 'assets/dist/img')} ,
          {from:path.resolve(__dirname, 'assets/build/fonts'),to:path.resolve(__dirname, 'assets/dist/fonts')} 
      ])
  ],
  module: {
        rules: [
        {
            test: /\.scss$/,
            use: [
                "style-loader", // creates style nodes from JS strings
                "css-loader", // translates CSS into CommonJS
                "sass-loader" // compiles Sass to CSS, using Node Sass by default
            ]
        },
        { 
        	test: /\.(png|jpe?g|gif)(\?\S*)?$/,
	        use: [{
	            loader: 'file-loader',
	            options: {
	            name: '[name].[ext]',
	            outputPath: '../../build/img/',  
	            publicPath: './app/themes/wp-theme/assets/dist/img' 
	            }
	        }]
	    },
	    { 
        	test: /\.(eot|woff|woff2|ttf|svg)(\?\S*)?$/,
	        use: [{
	            loader: 'file-loader',
	            options: {
	            name: '[name].[ext]',
	            outputPath: '../../build/fonts/',  
	            publicPath: './app/themes/wp-theme/assets/dist/fonts' 
	            }
	        }]
	    }
	    ]
    },
    watch: true
};