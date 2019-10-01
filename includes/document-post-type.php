<?php
/**
 * Provides the logic around the
 * Document Custom Post Type
 */
namespace UCFDocument\Document;

/**
 * Function that registers the custom post type
 * @author Jim Barnes
 * @since 0.1.0
 */
function register() {
	$defaults = array(
		'singular'    => 'Document',
		'plural'      => 'Documents',
		'text_domain' => 'ucf_document'
	);

	$labels = apply_filters( 'ucf_document_label_defaults', $defaults );

	register_post_type( 'document', args( $labels ) );
}

/**
 * Returns an array of labels for the custom post type
 * @author Jim Barnes
 * @since 0.1.0
 * @param array $labels The labels array
 * 						Defaults:
 * 							( 'singular'    => 'Location' ),
 * 							( 'plural'      => 'Locations' ),
 * 							( 'text_domain' => 'ucf_location' )
 * @return array
 */
function labels( $labels ) {
	$singular       = isset( $labels['singular'] ) ? $labels['singular'] : 'Document';
	$singular_lower = strtolower( $singular );
	$plural         = isset( $labels['plural'] ) ? $labels['plural'] : 'Documents';
	$plural_lower   = strtolower( $plural );
	$text_domain    = isset( $labels['text_domain'] ) ? $labels['text_domain'] : 'ucf_document';

	$retval = array(
		"name"                  => _x( $plural, "Post Type General Name", $text_domain ),
		"singular_name"         => _x( $singular, "Post Type Singular Name", $text_domain ),
		"menu_name"             => __( $plural, $text_domain ),
		"name_admin_bar"        => __( $singular, $text_domain ),
		"archives"              => __( "$singular Archives", $text_domain ),
		"parent_item_colon"     => __( "Parent $singular:", $text_domain ),
		"all_items"             => __( "All $plural", $text_domain ),
		"add_new_item"          => __( "Add New $singular", $text_domain ),
		"add_new"               => __( "Add New", $text_domain ),
		"new_item"              => __( "New $singular", $text_domain ),
		"edit_item"             => __( "Edit $singular", $text_domain ),
		"update_item"           => __( "Update $singular", $text_domain ),
		"view_item"             => __( "View $singular", $text_domain ),
		"search_items"          => __( "Search $plural", $text_domain ),
		"not_found"             => __( "Not found", $text_domain ),
		"not_found_in_trash"    => __( "Not found in Trash", $text_domain ),
		"featured_image"        => __( "Featured Image", $text_domain ),
		"set_featured_image"    => __( "Set featured image", $text_domain ),
		"remove_featured_image" => __( "Remove featured image", $text_domain ),
		"use_featured_image"    => __( "Use as featured image", $text_domain ),
		"insert_into_item"      => __( "Insert into $singular_lower", $text_domain ),
		"uploaded_to_this_item" => __( "Uploaded to this $singular_lower", $text_domain ),
		"items_list"            => __( "$plural list", $text_domain ),
		"items_list_navigation" => __( "$plural list navigation", $text_domain ),
		"filter_items_list"     => __( "Filter $plural_lower list", $text_domain ),
	);

	$retval = apply_filters( 'ucf_document_labels', $retval );

	return $retval;
}

/**
 * Returns the arguments for registering
 * the custom post type
 * @author Jim Barnes
 * @since 0.1.0
 * @param array $labels The labels array
 * 						Defaults:
 * 							( 'singular'    => 'Location' ),
 * 							( 'plural'      => 'Locations' ),
 * 							( 'text_domain' => 'ucf_location' )
 * @return array
 */
function args( $labels ) {
	$taxonomies = apply_filters(
		'ucf_document_taxonomies',
		array()
	);

	$text_domain = isset( $labels['text_domain'] ) ? $labels['text_domain'] : 'ucf_document';

	$args = array(
		'label'               => __( 'Document', $text_domain ),
		'description'         => __( 'Documents', $text_domain ),
		'labels'              => labels( $labels ),
		'supports'            => array( 'title' ),
		'taxonomies'          => $taxonomies,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'rest_base'           => 'documents',
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-media-text',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post'
	);

	$args = apply_filters( 'ucf_document_args', $args );

	return $args;
}

add_action( 'init', __NAMESPACE__ . '\register', 10, 0 );