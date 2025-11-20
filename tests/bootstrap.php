<?php
/**
 * PHPUnit Bootstrap File
 *
 * @package WordPress_App_Test
 */

defined( 'ABSPATH' ) || define( 'ABSPATH', dirname( __DIR__ ) . '/' );

// Define test environment
define( 'WP_TESTS_DIR', getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib' );
define( 'WP_TESTS_SITE_URL', 'http://localhost' );
define( 'WP_TESTS_DOMAIN', 'localhost' );

// Load WordPress test environment
if ( ! file_exists( WP_TESTS_DIR . '/includes/functions.php' ) ) {
	wp_die( 'WordPress test environment not found. Run bin/install-wp-tests.sh' );
}

require_once WP_TESTS_DIR . '/includes/functions.php';

// Define plugin file
define( 'WORDPRESS_APP_TEST_PLUGIN_FILE', ABSPATH . 'wordpress-app-test.php' );

// Load plugin
function _manually_load_plugin() {
	require_once WORDPRESS_APP_TEST_PLUGIN_FILE;
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start WordPress test environment
require_once WP_TESTS_DIR . '/includes/bootstrap.php';

// Autoload Composer dependencies
if ( file_exists( ABSPATH . 'vendor/autoload.php' ) ) {
	require_once ABSPATH . 'vendor/autoload.php';
}
