<?php
/**
 * Main Plugin Class
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test;

/**
 * Plugin class
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @var Plugin
	 */
	private static $instance;

	/**
	 * Get instance
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
		$this->load_dependencies();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * Load plugin textdomain
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wordpress-app-test',
			false,
			dirname( WORDPRESS_APP_TEST_PLUGIN_BASENAME ) . '/languages/'
		);
	}

	/**
	 * Load plugin dependencies
	 */
	private function load_dependencies() {
		// Load admin class
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/admin/class-admin.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/admin/class-settings.php';

		// Load API classes
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/api/class-rest-controller.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/api/class-settings-endpoint.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/api/class-license-endpoint.php';

		// Load licensing classes
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/licensing/class-license-manager.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/licensing/class-license-storage.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/licensing/class-license-api.php';

		// Load utilities
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/utils/functions.php';
		require_once WORDPRESS_APP_TEST_PLUGIN_DIR . 'includes/utils/class-logger.php';
	}

	/**
	 * Register admin menu
	 */
	public function register_admin_menu() {
		if ( ! is_admin() ) {
			return;
		}

		add_menu_page(
			__( 'WordPress App Test', 'wordpress-app-test' ),
			__( 'App Test', 'wordpress-app-test' ),
			'manage_options',
			'wordpress-app-test',
			array( $this, 'render_admin_page' ),
			'dashicons-admin-generic',
			30
		);
	}

	/**
	 * Render admin page
	 */
	public function render_admin_page() {
		echo '<div id="wordpress-app-test-admin"></div>';
	}

	/**
	 * Register REST routes
	 */
	public function register_rest_routes() {
		$settings_endpoint = new Api\Settings_Endpoint();
		$settings_endpoint->register_routes();

		$license_endpoint = new Api\License_Endpoint();
		$license_endpoint->register_routes();
	}

	/**
	 * Plugin activation
	 */
	public static function activate() {
		// Create plugin tables or initialize settings
		$license_storage = new Licensing\License_Storage();
		$license_storage->init();
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivate() {
		// Cleanup code if needed
	}
}
