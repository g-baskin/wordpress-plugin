/**
 * API Utilities
 */

import { ApiResponse, ApiError } from '../types';

const { apiFetch } = wp;

/**
 * Make API request
 */
export async function apiRequest<T = any>(
	path: string,
	options: Record<string, any> = {}
): Promise<ApiResponse<T>> {
	try {
		const response = await apiFetch({
			path,
			...options,
		});

		return response as ApiResponse<T>;
	} catch (error: any) {
		const apiError: ApiError = {
			message: error?.message || 'Unknown error occurred',
			code: error?.code || 'unknown_error',
			status: error?.status || 500,
		};

		throw apiError;
	}
}

/**
 * Get settings
 */
export async function getSettings() {
	return apiRequest('/wordpress-app-test/v1/settings');
}

/**
 * Update settings
 */
export async function updateSettings(settings: Record<string, any>) {
	return apiRequest('/wordpress-app-test/v1/settings', {
		method: 'POST',
		data: settings,
	});
}

/**
 * Validate license
 */
export async function validateLicense(licenseKey: string) {
	return apiRequest('/wordpress-app-test/v1/license/validate', {
		method: 'POST',
		data: { license_key: licenseKey },
	});
}

/**
 * Get license status
 */
export async function getLicenseStatus() {
	return apiRequest('/wordpress-app-test/v1/license/status');
}
