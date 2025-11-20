const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
	...defaultConfig,
	entry: {
		admin: path.resolve(process.cwd(), 'src/admin', 'index.tsx'),
		public: path.resolve(process.cwd(), 'src/public', 'index.tsx'),
	},
	output: {
		path: path.resolve(process.cwd(), 'build'),
		filename: '[name]/index.js',
	},
	resolve: {
		...defaultConfig.resolve,
		alias: {
			'@shared': path.resolve(process.cwd(), 'src/shared'),
		},
	},
};
