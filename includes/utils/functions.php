<?php
/**
 * Plugin Helper Functions
 *
 * @package WordPress_App_Test
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get plugin option
 *
 * @param string $option Option name.
 * @param mixed  $default Default value.
 * @return mixed
 */
function wordpress_app_test_get_option( $option, $default = null ) {
	$options = get_option( 'wordpress_app_test_settings', array() );

	if ( isset( $options[ $option ] ) ) {
		return $options[ $option ];
	}

	return $default;
}

/**
 * Update plugin option
 *
 * @param string $option Option name.
 * @param mixed  $value Option value.
 * @return bool
 */
function wordpress_app_test_update_option( $option, $value ) {
	$options = get_option( 'wordpress_app_test_settings', array() );

	$options[ $option ] = $value;

	return update_option( 'wordpress_app_test_settings', $options );
}

/**
 * Log plugin message
 *
 * @param string $message Message to log.
 * @param string $level Log level (info, warning, error).
 * @return void
 */
function wordpress_app_test_log( $message, $level = 'info' ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( '[WordPress App Test] [' . strtoupper( $level ) . '] ' . $message );
	}
}
