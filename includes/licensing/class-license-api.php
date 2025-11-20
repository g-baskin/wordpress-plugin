<?php
/**
 * License API
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Licensing;

/**
 * License API class
 */
class License_API {
	/**
	 * API endpoint
	 *
	 * @var string
	 */
	private $endpoint = 'https://api.example.com/license';

	/**
	 * API timeout
	 *
	 * @var int
	 */
	private $timeout = 10;

	/**
	 * Validate license with remote API
	 *
	 * @param string $license_key License key.
	 * @return array
	 */
	public function validate( $license_key ) {
		$response = wp_remote_post(
			$this->endpoint . '/validate',
			array(
				'timeout' => $this->timeout,
				'body'    => array(
					'license_key' => $license_key,
					'site_url'    => home_url(),
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'valid' => false,
				'error' => $response->get_error_message(),
			);
		}

		$body   = wp_remote_retrieve_body( $response );
		$status = wp_remote_retrieve_response_code( $response );

		if ( 200 !== $status ) {
			return array(
				'valid' => false,
				'error' => 'API returned status ' . $status,
			);
		}

		$data = json_decode( $body, true );

		if ( ! is_array( $data ) ) {
			return array(
				'valid' => false,
				'error' => 'Invalid API response',
			);
		}

		return array(
			'valid' => isset( $data['valid'] ) ? (bool) $data['valid'] : false,
			'data'  => $data,
		);
	}

	/**
	 * Revoke license
	 *
	 * @param string $license_key License key.
	 * @return bool
	 */
	public function revoke( $license_key ) {
		$response = wp_remote_post(
			$this->endpoint . '/revoke',
			array(
				'timeout' => $this->timeout,
				'body'    => array(
					'license_key' => $license_key,
					'site_url'    => home_url(),
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$status = wp_remote_retrieve_response_code( $response );

		return 200 === $status;
	}

	/**
	 * Check license status
	 *
	 * @param string $license_key License key.
	 * @return array
	 */
	public function check_status( $license_key ) {
		$response = wp_remote_get(
			$this->endpoint . '/status',
			array(
				'timeout' => $this->timeout,
				'headers' => array(
					'X-License-Key' => $license_key,
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'active' => false,
				'error'  => $response->get_error_message(),
			);
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( ! is_array( $data ) ) {
			return array(
				'active' => false,
				'error'  => 'Invalid API response',
			);
		}

		return $data;
	}
}
