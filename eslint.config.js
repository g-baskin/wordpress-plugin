module.exports = [
	{
		ignores: ['build/**', 'vendor/**', 'node_modules/**', 'dist/**'],
	},
	{
		files: ['src/**/*.{js,jsx,ts,tsx}'],
		languageOptions: {
			parser: require('@typescript-eslint/parser'),
			ecmaVersion: 2020,
			sourceType: 'module',
			ecmaFeatures: {
				jsx: true,
			},
			globals: {
				wp: 'readonly',
				wpApiSettings: 'readonly',
				console: 'readonly',
				process: 'readonly',
			},
		},
		plugins: {
			'@typescript-eslint': require('@typescript-eslint/eslint-plugin'),
		},
		rules: {
			'@typescript-eslint/no-explicit-any': 'warn',
			'@typescript-eslint/explicit-function-return-types': 'off',
			'@typescript-eslint/no-unused-vars': [
				'error',
				{
					argsIgnorePattern: '^_',
				},
			],
			'no-console': 'warn',
			'no-debugger': 'warn',
		},
	},
	{
		files: ['tests/**/*.{js,ts}'],
		languageOptions: {
			globals: {
				describe: 'readonly',
				it: 'readonly',
				expect: 'readonly',
				beforeEach: 'readonly',
				afterEach: 'readonly',
			},
		},
	},
];
