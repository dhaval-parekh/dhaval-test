// webpack.config.js
var path = require('path');
var LiveReloadPlugin = require('webpack-livereload-plugin');
var ExtractTextPlugin = require('extract-text-webpack-plugin');


var options = {
	appendScriptTag: true,
	files: [
		'./src/**/*.html',
		'./src/**/*.css'
	]
};
module.exports = {
	plugins: [
		new ExtractTextPlugin('./[name].css'),
		new LiveReloadPlugin(options)
	],
	entry: './app/index.js',
	output: {
		filename: 'bundle.js',
		path: path.resolve(__dirname, 'dist')
	}
};
