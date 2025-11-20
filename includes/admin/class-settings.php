<?php
/**
 * Settings Class
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Admin;

/**
 * Settings handler
 */
class Settings {
	/**
	 * Option group
	 *
	 * @var string
	 */
	private $option_group = 'wordpress_app_test_settings';

	/**
	 * Settings
	 *
	 * @var array
	 */
	private $settings = array(
		'license_key'      => '',
		'enable_logging'   => false,
		'api_endpoint'     => '',
		'debug_mode'       => false,
	);

	/**
	 * Get setting value
	 *
	 * @param string $key Setting key.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
		$options = get_option( $this->option_group, $this->settings );

		if ( isset( $options[ $key ] ) ) {
			return $options[ $key ];
		}

		return $default;
	}

	/**
	 * Update setting value
	 *
	 * @param string $key Setting key.
	 * @param mixed  $value Setting value.
	 * @return bool
	 */
	public function update( $key, $value ) {
		$options = get_option( $this->option_group, $this->settings );

		$options[ $key ] = $value;

		return update_option( $this->option_group, $options );
	}

	/**
	 * Get all settings
	 *
	 * @return array
	 */
	public function get_all() {
		return get_option( $this->option_group, $this->settings );
	}

	/**
	 * Reset settings to defaults
	 *
	 * @return bool
	 */
	public function reset() {
		return delete_option( $this->option_group );
	}
}
