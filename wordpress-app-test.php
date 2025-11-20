<?php
/**
 * Plugin Name: WordPress App Test
 * Plugin URI: https://example.com/wordpress-app-test
 * Description: Test WordPress plugin with TypeScript, REST API, and license system
 * Version: 1.2.0
 * Author: Developer
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wordpress-app-test
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package WordPress_App_Test
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define plugin constants
 */
define( 'WORDPRESS_APP_TEST_VERSION', '1.2.0' );
define( 'WORDPRESS_APP_TEST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WORDPRESS_APP_TEST_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WORDPRESS_APP_TEST_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Autoloader for PHP classes
 */
require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/class-plugin.php';

/**
 * Load licensing early for activation hook
 */
require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/licensing/class-license-storage.php';

/**
 * Plugin activation
 */
register_activation_hook(
	__FILE__,
	array( 'WordPress_App_Test\Plugin', 'activate' )
);

/**
 * Plugin deactivation
 */
register_deactivation_hook(
	__FILE__,
	array( 'WordPress_App_Test\Plugin', 'deactivate' )
);

/**
 * Initialize plugin
 */
add_action(
	'plugins_loaded',
	function() {
		WordPress_App_Test\Plugin::get_instance();
	}
);
