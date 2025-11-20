<?php
/**
 * Admin Class
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Admin;

/**
 * Admin class
 */
class Admin {
	/**
	 * Initialize admin
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Enqueue admin assets
	 */
	public function enqueue_admin_assets() {
		if ( ! isset( $_GET['page'] ) || 'wordpress-app-test' !== $_GET['page'] ) {
			return;
		}

		// Register admin script
		wp_register_script(
			'wordpress-app-test-admin',
			WORDPRESS_APP_TEST_PLUGIN_URL . 'build/admin/index.js',
			array( 'wp-element', 'wp-components', 'wp-api-fetch' ),
			WORDPRESS_APP_TEST_VERSION,
			true
		);

		// Localize script
		wp_localize_script(
			'wordpress-app-test-admin',
			'wordPressAppTestData',
			array(
				'apiUrl'  => rest_url( 'wordpress-app-test/v1/' ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
				'version' => WORDPRESS_APP_TEST_VERSION,
			)
		);

		wp_enqueue_script( 'wordpress-app-test-admin' );

		// Enqueue admin styles
		wp_enqueue_style(
			'wordpress-app-test-admin',
			WORDPRESS_APP_TEST_PLUGIN_URL . 'build/admin/index.css',
			array(),
			WORDPRESS_APP_TEST_VERSION
		);
	}
}
