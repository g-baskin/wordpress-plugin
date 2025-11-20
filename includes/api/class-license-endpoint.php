<?php
/**
 * License REST Endpoint
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Api;

use WordPress_App_Test\Licensing\License_Manager;

/**
 * License endpoint class
 */
class License_Endpoint extends REST_Controller {
	/**
	 * Route
	 *
	 * @var string
	 */
	protected $route = '/license';

	/**
	 * Register routes
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			$this->route . '/validate',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'validate_license' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
					'args'                => array(
						'license_key' => array(
							'required'          => true,
							'type'              => 'string',
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			$this->route . '/status',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_license_status' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
				),
			)
		);
	}

	/**
	 * Validate license
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function validate_license( \WP_REST_Request $request ) {
		$license_key = $request->get_param( 'license_key' );

		if ( empty( $license_key ) ) {
			return $this->prepare_error( 'License key is required', 'missing_license', 400 );
		}

		$manager = new License_Manager();
		$result  = $manager->validate( $license_key );

		if ( $result['valid'] ) {
			return $this->prepare_response(
				array(
					'valid'   => true,
					'message' => 'License is valid',
				)
			);
		}

		return $this->prepare_error( 'Invalid license key', 'invalid_license', 400 );
	}

	/**
	 * Get license status
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function get_license_status( \WP_REST_Request $request ) {
		$manager = new License_Manager();
		$status  = $manager->get_status();

		return $this->prepare_response( $status );
	}
}
