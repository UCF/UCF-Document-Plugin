<?php
/**
 * Provides utility functions used throughout
 * the plugin.
 */
namespace UCFDocument\Utils;

/**
 * Determines if the Advanced Custom Fields
 * plugin is installed and active.
 * @author Jim Barnes
 * @since 0.1.0
 * @param string $required_version The version the plugin must be
 */
function acf_is_active( $required_version = '5.0.0' ) {
	$acf_pro_path  = \apply_filters( 'ucf_document_acf_pro_path', 'advanced-custom-fields-pro/acf.php' );
	$acf_free_path = \apply_filters( 'ucf_document_acf_free_path', 'advanced-custom-fields/acf.php' );
	$plugin_path   = ABSPATH . 'wp-content/plugins/';

	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	// See if the pro version is installed
	if ( \class_exists( 'acf_pro' ) || safe_is_plugin_active( $acf_pro_path ) ) {
		$plugin_data = \get_plugin_data( $plugin_path . $acf_pro_path );

		if ( is_above_version( $plugin_data['Version'], $required_version ) ) {
			return true;
		}
	}
	if ( \class_exists( 'ACF' ) || safe_is_plugin_active( $acf_free_path ) ) {
		$plugin_data = \get_plugin_data( $plugin_path . $acf_free_path );

		if ( is_above_version( $plugin_data['Version'], $required_version ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Returns a boolean indicating if the plugin is active.
 * @author Jim Barnes
 * @since 0.2.3
 * @param string The path of the plugin to check for.
 * @return bool
 */
function safe_is_plugin_active( $plugin_path ) {
	return in_array( $plugin_path, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/**
 * Determines if a provided version is higher
 * than the provided required version.
 * @author Jim Barnes
 * @since 0.1.0
 * @param string $version The version to be compared
 * @param string $required_version The requirement that must be met
 * @return bool
 */
function is_above_version( $version, $required_version ) {
	if ( version_compare( $version, $required_version ) >= 0 ) {
		return true;
	}

	return false;
}
