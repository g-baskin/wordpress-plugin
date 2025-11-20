<?php
/**
 * License Manager
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Licensing;

/**
 * License manager class
 */
class License_Manager {
	/**
	 * License storage
	 *
	 * @var License_Storage
	 */
	private $storage;

	/**
	 * License API
	 *
	 * @var License_API
	 */
	private $api;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->storage = new License_Storage();
		$this->api     = new License_API();
	}

	/**
	 * Validate license
	 *
	 * @param string $license_key License key.
	 * @return array
	 */
	public function validate( $license_key ) {
		// Validate license format
		if ( empty( $license_key ) ) {
			return array(
				'valid' => false,
				'error' => 'License key is empty',
			);
		}

		// Check local cache
		$cached = $this->storage->get_cached_license( $license_key );
		if ( ! empty( $cached ) && ! $this->is_cache_expired( $cached ) ) {
			return array(
				'valid' => true,
				'cache' => true,
				'data'  => $cached,
			);
		}

		// Validate against remote API
		$result = $this->api->validate( $license_key );

		if ( $result['valid'] ) {
			// Cache the result
			$this->storage->save_license( $license_key, $result );
		}

		return $result;
	}

	/**
	 * Get license status
	 *
	 * @return array
	 */
	public function get_status() {
		$license_key = $this->storage->get_active_license();

		if ( empty( $license_key ) ) {
			return array(
				'active'      => false,
				'license_key' => '',
				'message'     => 'No active license',
			);
		}

		$license = $this->storage->get_license( $license_key );

		if ( empty( $license ) ) {
			return array(
				'active'      => false,
				'license_key' => $license_key,
				'message'     => 'License not found in cache',
			);
		}

		return array(
			'active'       => true,
			'license_key'  => $license_key,
			'license_data' => $license,
		);
	}

	/**
	 * Activate license
	 *
	 * @param string $license_key License key.
	 * @return bool
	 */
	public function activate( $license_key ) {
		$validation = $this->validate( $license_key );

		if ( ! $validation['valid'] ) {
			return false;
		}

		return $this->storage->set_active_license( $license_key );
	}

	/**
	 * Deactivate license
	 *
	 * @return bool
	 */
	public function deactivate() {
		return $this->storage->set_active_license( '' );
	}

	/**
	 * Check if cache expired
	 *
	 * @param array $cached Cached license data.
	 * @return bool
	 */
	private function is_cache_expired( $cached ) {
		if ( empty( $cached['timestamp'] ) ) {
			return true;
		}

		// Cache expires after 24 hours
		$expiration = 24 * HOUR_IN_SECONDS;

		return ( time() - $cached['timestamp'] ) > $expiration;
	}
}
