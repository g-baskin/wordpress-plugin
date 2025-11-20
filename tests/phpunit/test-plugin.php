<?php
/**
 * Plugin Tests
 *
 * @package WordPress_App_Test
 */

class Plugin_Tests extends WP_UnitTestCase {
	/**
	 * Test plugin activation
	 */
	public function test_plugin_activation() {
		$this->assertTrue( defined( 'WORDPRESS_APP_TEST_VERSION' ) );
		$this->assertTrue( defined( 'WORDPRESS_APP_TEST_PLUGIN_DIR' ) );
		$this->assertTrue( defined( 'WORDPRESS_APP_TEST_PLUGIN_URL' ) );
	}

	/**
	 * Test plugin constants
	 */
	public function test_plugin_constants() {
		$this->assertIsString( WORDPRESS_APP_TEST_VERSION );
		$this->assertIsString( WORDPRESS_APP_TEST_PLUGIN_DIR );
		$this->assertIsString( WORDPRESS_APP_TEST_PLUGIN_URL );
	}
}
