<?php
/**
 * Base REST Controller
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Api;

/**
 * Base REST controller class
 */
abstract class REST_Controller extends \WP_REST_Controller {
	/**
	 * Namespace
	 *
	 * @var string
	 */
	protected $namespace = 'wordpress-app-test/v1';

	/**
	 * Check if user can manage plugin
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return bool
	 */
	public function check_admin_permission( \WP_REST_Request $request ) {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Check if user can access public endpoints
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return bool
	 */
	public function check_read_permission( \WP_REST_Request $request ) {
		return true;
	}

	/**
	 * Prepare response
	 *
	 * @param array $data Response data.
	 * @return \WP_REST_Response
	 */
	protected function prepare_response( $data ) {
		return new \WP_REST_Response(
			array(
				'success' => true,
				'data'    => $data,
			),
			200
		);
	}

	/**
	 * Prepare error response
	 *
	 * @param string $message Error message.
	 * @param string $code Error code.
	 * @param int    $status HTTP status code.
	 * @return \WP_REST_Response
	 */
	protected function prepare_error( $message, $code = 'error', $status = 400 ) {
		return new \WP_REST_Response(
			array(
				'success' => false,
				'message' => $message,
				'code'    => $code,
			),
			$status
		);
	}
}
