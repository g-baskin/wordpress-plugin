/**
 * Shared Type Definitions
 */

export interface ApiResponse<T = any> {
	success: boolean;
	data?: T;
	message?: string;
	code?: string;
}

export interface PluginSettings {
	license_key: string;
	enable_logging: boolean;
	api_endpoint: string;
	debug_mode: boolean;
	[key: string]: string | boolean;
}

export interface LicenseStatus {
	active: boolean;
	license_key: string;
	license_data?: Record<string, any>;
	message?: string;
}

export interface ApiError {
	message: string;
	code: string;
	status: number;
}
