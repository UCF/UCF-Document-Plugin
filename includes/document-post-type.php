<?php
/**
 * Provides the logic around the
 * Document Custom Post Type
 */
namespace UCFDocument\PostTypes;

class Document {
	private
		$singular,
		$plural,
		$text_domain;

	/**
	 * Default constructor. Adds init hook
	 * @author Jim Barnes
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
	}

	/**
	 * Function that registers the custom post type
	 * @author Jim Barnes
	 * @since 0.1.0
	 */
	public function register() {
		$defaults = array(
			'singular'    => 'Document',
			'plural'      => 'Documents',
			'text_domain' => 'ucf_document'
		);

		$labels = apply_filters( 'ucf_document_label_defaults', $defaults );

		$this->singular    = $labels['singular'];
		$this->plural      = $labels['plural'];
		$this->text_domain = $labels['text_domain'];

		register_post_type( 'document', $this->args() );
	}

	/**
	 * Returns an array of labels for the custom post type
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @return array
	 */
	public function labels() {
		$singular_lower = strtolower( $this->singular );
		$plural_lower   = strtolower( $this->plural );

		$retval = array(
			"name"                  => _x( $this->plural, "Post Type General Name", $this->text_domain ),
			"singular_name"         => _x( $this->singular, "Post Type Singular Name", $this->text_domain ),
			"menu_name"             => __( $this->plural, $this->text_domain ),
			"name_admin_bar"        => __( $this->singular, $this->text_domain ),
			"archives"              => __( "$this->singular Archives", $this->text_domain ),
			"parent_item_colon"     => __( "Parent $this->singular:", $this->text_domain ),
			"all_items"             => __( "All $this->plural", $this->text_domain ),
			"add_new_item"          => __( "Add New $this->singular", $this->text_domain ),
			"add_new"               => __( "Add New", $this->text_domain ),
			"new_item"              => __( "New $this->singular", $this->text_domain ),
			"edit_item"             => __( "Edit $this->singular", $this->text_domain ),
			"update_item"           => __( "Update $this->singular", $this->text_domain ),
			"view_item"             => __( "View $this->singular", $this->text_domain ),
			"search_items"          => __( "Search $this->plural", $this->text_domain ),
			"not_found"             => __( "Not found", $this->text_domain ),
			"not_found_in_trash"    => __( "Not found in Trash", $this->text_domain ),
			"featured_image"        => __( "Featured Image", $this->text_domain ),
			"set_featured_image"    => __( "Set featured image", $this->text_domain ),
			"remove_featured_image" => __( "Remove featured image", $this->text_domain ),
			"use_featured_image"    => __( "Use as featured image", $this->text_domain ),
			"insert_into_item"      => __( "Insert into $singular_lower", $this->text_domain ),
			"uploaded_to_this_item" => __( "Uploaded to this $singular_lower", $this->text_domain ),
			"items_list"            => __( "$this->plural list", $this->text_domain ),
			"items_list_navigation" => __( "$this->plural list navigation", $this->text_domain ),
			"filter_items_list"     => __( "Filter $plural_lower list", $this->text_domain ),
		);

		$retval = apply_filters( 'ucf_document_labels', $retval );

		return $retval;
	}

	/**
	 * Returns the arguments for registering
	 * the custom post type
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @return array
	 */
	public function args() {
		$taxonomies = apply_filters(
			'ucf_document_taxonomies',
			array(
				'post_tag'
			)
		);

		$args = array(
			'label'               => __( 'Document', $this->text_domain ),
			'description'         => __( 'Documents', $this->text_domain ),
			'labels'              => $this->labels(),
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
}

new Document();