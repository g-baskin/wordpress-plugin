<?php
/**
 * License Storage
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Licensing;

/**
 * License storage class
 */
class License_Storage {
	/**
	 * Option prefix
	 *
	 * @var string
	 */
	const OPTION_PREFIX = 'wordpress_app_test_license_';

	/**
	 * Active license option
	 *
	 * @var string
	 */
	const ACTIVE_LICENSE_OPTION = 'wordpress_app_test_active_license';

	/**
	 * Initialize storage
	 */
	public function init() {
		// Create any necessary database tables or initialize options
		if ( false === get_option( self::ACTIVE_LICENSE_OPTION ) ) {
			add_option( self::ACTIVE_LICENSE_OPTION, '' );
		}
	}

	/**
	 * Save license
	 *
	 * @param string $license_key License key.
	 * @param array  $data License data.
	 * @return bool
	 */
	public function save_license( $license_key, $data ) {
		$option_name = self::OPTION_PREFIX . sanitize_key( $license_key );

		$license_data = array_merge(
			$data,
			array(
				'timestamp' => time(),
				'key'       => $license_key,
			)
		);

		return update_option( $option_name, $license_data );
	}

	/**
	 * Get license
	 *
	 * @param string $license_key License key.
	 * @return array|false
	 */
	public function get_license( $license_key ) {
		$option_name = self::OPTION_PREFIX . sanitize_key( $license_key );
		return get_option( $option_name );
	}

	/**
	 * Get cached license
	 *
	 * @param string $license_key License key.
	 * @return array|false
	 */
	public function get_cached_license( $license_key ) {
		return $this->get_license( $license_key );
	}

	/**
	 * Set active license
	 *
	 * @param string $license_key License key.
	 * @return bool
	 */
	public function set_active_license( $license_key ) {
		return update_option( self::ACTIVE_LICENSE_OPTION, $license_key );
	}

	/**
	 * Get active license
	 *
	 * @return string
	 */
	public function get_active_license() {
		return get_option( self::ACTIVE_LICENSE_OPTION, '' );
	}

	/**
	 * Delete license
	 *
	 * @param string $license_key License key.
	 * @return bool
	 */
	public function delete_license( $license_key ) {
		$option_name = self::OPTION_PREFIX . sanitize_key( $license_key );
		return delete_option( $option_name );
	}
}
