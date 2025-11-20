<?php
/**
 * Settings REST Endpoint
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Api;

use WordPress_App_Test\Admin\Settings;

/**
 * Settings endpoint class
 */
class Settings_Endpoint extends REST_Controller {
	/**
	 * Route
	 *
	 * @var string
	 */
	protected $route = '/settings';

	/**
	 * Register routes
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			$this->route,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_settings' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
				),
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'update_settings' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
					'args'                => array(
						'license_key'    => array(
							'type'      => 'string',
							'sanitize_callback' => 'sanitize_text_field',
						),
						'enable_logging' => array(
							'type' => 'boolean',
						),
						'api_endpoint'   => array(
							'type'      => 'string',
							'sanitize_callback' => 'esc_url_raw',
						),
						'debug_mode'     => array(
							'type' => 'boolean',
						),
					),
				),
			)
		);
	}

	/**
	 * Get settings
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function get_settings( \WP_REST_Request $request ) {
		$settings = new Settings();
		return $this->prepare_response( $settings->get_all() );
	}

	/**
	 * Update settings
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function update_settings( \WP_REST_Request $request ) {
		$settings = new Settings();
		$params   = $request->get_json_params();

		foreach ( $params as $key => $value ) {
			$settings->update( $key, $value );
		}

		return $this->prepare_response( $settings->get_all() );
	}
}
