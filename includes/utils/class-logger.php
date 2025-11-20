<?php
/**
 * Logger Class
 *
 * @package WordPress_App_Test
 */

namespace WordPress_App_Test\Utils;

/**
 * Logger class
 */
class Logger {
	/**
	 * Log levels
	 *
	 * @var array
	 */
	private const LOG_LEVELS = array(
		'debug'   => 0,
		'info'    => 1,
		'warning' => 2,
		'error'   => 3,
	);

	/**
	 * Current log level
	 *
	 * @var string
	 */
	private $current_level;

	/**
	 * Constructor
	 *
	 * @param string $level Log level.
	 */
	public function __construct( $level = 'info' ) {
		$this->current_level = $level;
	}

	/**
	 * Log debug message
	 *
	 * @param string $message Message.
	 * @param array  $context Context data.
	 * @return void
	 */
	public function debug( $message, $context = array() ) {
		$this->log( 'debug', $message, $context );
	}

	/**
	 * Log info message
	 *
	 * @param string $message Message.
	 * @param array  $context Context data.
	 * @return void
	 */
	public function info( $message, $context = array() ) {
		$this->log( 'info', $message, $context );
	}

	/**
	 * Log warning message
	 *
	 * @param string $message Message.
	 * @param array  $context Context data.
	 * @return void
	 */
	public function warning( $message, $context = array() ) {
		$this->log( 'warning', $message, $context );
	}

	/**
	 * Log error message
	 *
	 * @param string $message Message.
	 * @param array  $context Context data.
	 * @return void
	 */
	public function error( $message, $context = array() ) {
		$this->log( 'error', $message, $context );
	}

	/**
	 * Log message
	 *
	 * @param string $level Level.
	 * @param string $message Message.
	 * @param array  $context Context data.
	 * @return void
	 */
	private function log( $level, $message, $context = array() ) {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}

		if ( self::LOG_LEVELS[ $level ] < self::LOG_LEVELS[ $this->current_level ] ) {
			return;
		}

		$log_message = '[WordPress App Test] [' . strtoupper( $level ) . '] ' . $message;

		if ( ! empty( $context ) ) {
			$log_message .= ' ' . wp_json_encode( $context );
		}

		error_log( $log_message );
	}
}
