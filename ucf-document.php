<?php
/*
Plugin Name: UCF Document Plugin
Description: Provides a custom post type and taxonomies for managing documents
Version: 0.1.0
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: UCF/UCF-Document-Plugin
*/

namespace UCFDocument;
use UCFDocument\PostTypes\Document;

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Constants
 */
define( 'UCF_DOCUMENT__PLUGIN_FILE', __FILE__ );
define( 'UCF_DOCUMENT__PLUGIN_PATH', dirname( __FILE__ ) );

/**
 * Includes
 */
require_once 'includes/document-post-type.php';
require_once 'includes/directory-taxonomy.php';
require_once 'includes/utilities.php';

/**
 * Activation/Deactivation Hooks
 */

/**
 * Function that runs when the plugin
 * is activated.
 * @author Jim Barnes
 * @since 1.0.0
 * @return void
 */
function activate() {
	$doc = new Document();
	$doc->register();
	flush_rewrite_rules();
}

register_activation_hook( UCF_DOCUMENT__PLUGIN_FILE, __NAMESPACE__ . '\activate' );

/**
 * Function that runs when the plugin
 * is deactivated
 * @author Jim Barnes
 * @since 1.0.0
 * @return void
 */
function deactivate() {
	flush_rewrite_rules();
}

register_deactivation_hook( UCF_DOCUMENT__PLUGIN_FILE, __NAMESPACE__ . '\deactivate' );
