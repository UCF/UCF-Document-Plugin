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
	$acf_pro_path  = 'advanced-custom-fields-pro/acf.php';
	$acf_free_path = 'advanced-custom-fields/acf.php';
	$plugin_path   = ABSPATH . 'wp-content/plugins/';

	// See if the pro version is installed
	if ( class_exists( 'acf_pro' ) ) {
		$plugin_data = get_plugin_data( $plugin_path . $acf_pro_path );

		if ( is_above_version( $plugin_data['Version'], $required_version ) ) {
			return true;
		}
	}
	if ( class_exists( 'ACF' ) ) {
		$plugin_data = get_plugin_data( $plugin_path . $acf_free_path );

		if ( is_above_version( $plugin_data['Version'], $required_version ) ) {
			return true;
		}
	}

	return false;
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