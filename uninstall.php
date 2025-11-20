<?php
/**
 * Plugin Uninstall File
 *
 * Cleanup on plugin deletion
 *
 * @package WordPress_App_Test
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// Delete plugin options
delete_option( 'wordpress_app_test_settings' );
delete_option( 'wordpress_app_test_active_license' );

// Delete all license-related options
global $wpdb;
$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM $wpdb->options WHERE option_name LIKE %s",
		'wordpress_app_test_license_%'
	)
);
