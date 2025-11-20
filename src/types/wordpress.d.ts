/**
 * WordPress Global Type Definitions
 */

interface WordPressAppTestData {
	apiUrl: string;
	nonce: string;
	version: string;
}

declare global {
	interface Window {
		wordPressAppTestData: WordPressAppTestData;
	}

	const wp: {
		api: any;
		element: any;
		components: any;
		i18n: any;
		hooks: any;
		data: any;
	};

	const wpApiSettings: {
		root: string;
		nonce: string;
	};
}

export {};
