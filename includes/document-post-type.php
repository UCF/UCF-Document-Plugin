<?php
/**
 * Provides the logic around the
 * Document Custom Post Type
 */
namespace UCFDocument\PostTypes;

use UCFDocument\Utils;

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
		add_action( 'posts_results', array( $this, 'meta' ), 10, 2 );
		add_filter( 'single_template', array( $this, 'single_template' ), 10, 1 );

		if ( Utils\acf_is_active() ) {
			add_action( 'acf/init', array( $this, 'fields' ), 10, 0 );
		}
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

	/**
	 * Adds custom fields for the document
	 * custom post type
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @return void
	 */
	public function fields() {
		// Bail out if the function doesn't exists, for whatever reason.
		if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

		$fields  = array();

		$fields[] = array(
			'key'      => 'document_type',
			'label'    => 'Type',
			'name'     => 'document_type',
			'type'     => 'radio',
			'choices'  => array(
				'uploaded' => 'Uploaded',
				'external' => 'External'
			),
			'default_choice' => array(
				'uploaded' => 'Uploaded'
			),
			'required' => 1
		);

		$fields[] = array(
			'key'               => 'document_upload',
			'label'             => 'Uploaded File',
			'name'              => 'document_upload',
			'type'              => 'file',
			'instructions'      => 'Upload the document',
			'required'          => 0,
			'save_format'       => 'object',
			'conditional_logic' => array(
				array(
					array(
						'key'      => 'document_type',
						'operator' => '==',
						'value'    => 'uploaded'
					)
				)
			)
		);

		$fields[] = array(
			'key'      => 'document_external',
			'label'    => 'External File',
			'name'     => 'document_external',
			'type'     => 'text',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'key'      => 'document_type',
						'operator' => '==',
						'value'    => 'external'
					)
				)
			)
		);

		$fields[] = array(
			'key'          => 'document_description',
			'label'        => 'Short Description',
			'name'         => 'document_description',
			'type'         => 'textarea',
			'required'     => 0,
			'instructions' => 'A short description that will be displayed with the file.'
		);

		$fields = apply_filters( 'ucf_document_fields', $fields );

		$field_group = array(
			'key'      => 'ucf_document_fields',
			'title'    => 'Document Fields',
			'fields'   => $fields,
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'document'
					)
				)
			),
			'position' => 'acf_after_title',
			'style'    => 'default'
		);

		acf_add_local_field_group( $field_group );
	}

	/**
	 * Adds the post meta fields to the
	 * WP_Post object
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @param array $posts The post objects
	 * @param WP_Query $query The query obejct
	 * @return array
	 */
	public function meta( $posts, $query ) {
		if ( $query->get( 'post_type' ) === 'document' ) {
			foreach( $posts as $post ) {
				$post = $this->append_post_meta( $post );
			}
		}

		return $posts;
	}

	/**
	 * Adds the post meta fields to an
	 * individual post
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @param WP_Post $post The post object
	 * @return WP_Post
	 */
	private function append_post_meta( $post ) {
		$meta = array();

		$type = get_field( 'document_type', $post->ID );
		$file = ( $type === 'uploaded' )
				? get_field( 'document_upload', $post->ID )
				: get_field( 'document_external', $post->ID );
		$desc = get_field( 'document_description', $post->ID );

		$meta['type'] = $type;
		$meta['file'] = $file;
		$meta['description'] = $desc;

		$meta = apply_filters( 'ucf_document_append_post_meta', $meta, $post->ID );

		$post->meta = (object)$meta;

		return $post;
	}

	public function single_template( $single ) {
		global $post;

		if ( $post->post_type === 'document' ) {
			if ( file_exists( UCF_DOCUMENT__PLUGIN_PATH . '/templates/single-document.php' ) ) {
				return UCF_DOCUMENT__PLUGIN_PATH . '/templates/single-document.php';
			}
		}

		return $single;
	}
}

new Document();
