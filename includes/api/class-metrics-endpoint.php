<?php
/**
 * Metrics REST Endpoint
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Api;

/**
 * Metrics endpoint class
 */
class Metrics_Endpoint extends REST_Controller {

	/**
	 * Route name
	 *
	 * @var string
	 */
	protected $route = 'metrics';

	/**
	 * Register routes
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->route,
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_metrics' ),
				'permission_callback' => array( $this, 'check_read_permission' ),
			)
		);
	}

	/**
	 * Get site metrics
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function get_metrics( \WP_REST_Request $request ) {
		global $wpdb;

		// Get post counts
		$posts_count = wp_count_posts();
		$pages_count = wp_count_posts( 'page' );

		// Get user count
		$users_count = count_users();

		// Get comments count
		$comments_count = wp_count_comments();

		// Prepare metrics data
		$metrics = array(
			array(
				'label' => 'Total Posts',
				'value' => intval( $posts_count->publish ?? 0 ),
				'icon'  => '📝',
				'color' => '#3b82f6',
			),
			array(
				'label' => 'Total Users',
				'value' => intval( $users_count['total_users'] ?? 0 ),
				'icon'  => '👥',
				'color' => '#10b981',
			),
			array(
				'label' => 'Total Pages',
				'value' => intval( $pages_count->publish ?? 0 ),
				'icon'  => '📄',
				'color' => '#f59e0b',
			),
			array(
				'label' => 'Total Comments',
				'value' => intval( $comments_count->total_comments ?? 0 ),
				'icon'  => '💬',
				'color' => '#ef4444',
			),
		);

		return $this->prepare_response( $metrics );
	}
}
