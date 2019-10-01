<?php
/**
 * Code related to the directory
 * custom taxonomy
 */

namespace UCFDocument\Taxonomies;

class Directory {
	public
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
	 * Registers the custom taxonomy
	 * @author Jim Barnes
	 * @since 0.1.0
	 */
	public function register() {
		$labels = array(
			'singular'    => 'Directory',
			'plural'      => 'Directories',
			'text_domain' => 'ucf_document'
		);

		$labels = apply_filters( 'ucf_directory_label_defaults', $labels );

		$this->singular    = $labels['singular'];
		$this->plural      = $labels['plural'];
		$this->text_domain = $labels['text_domain'];

		register_taxonomy( 'directory', array( 'document' ), $this->args() );
	}

	/**
	 * Returns the labels used to register
	 * the custom taxonomy
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @return array
	 */
	private function labels() {
		$singular_lower = strtolower( $this->singular );
		$plural_lower   = strtolower( $this->plural );

		$retval = array(
			'name'                       => _x( $this->plural, 'Taxonomy General Name', $this->text_domain ),
			'singular_name'              => _x( $this->singular, 'Taxonomy Singular Name', $this->text_domain ),
			'menu_name'                  => __( $this->plural, $this->text_domain ),
			'all_items'                  => __( "All $this->plural", $this->text_domain ),
			'parent_item'                => __( "Parent $this->singular", $this->text_domain ),
			'parent_item_colon'          => __( "Parent $this->singular:", $this->text_domain ),
			'new_item_name'              => __( "New $this->singular Name", $this->text_domain ),
			'add_new_item'               => __( "Add New $this->singular", $this->text_domain ),
			'edit_item'                  => __( "Edit $this->singular", $this->text_domain ),
			'update_item'                => __( "Update $this->singular", $this->text_domain ),
			'view_item'                  => __( "View $this->singular", $this->text_domain ),
			'separate_items_with_commas' => __( "Separate $plural_lower with commas", $this->text_domain ),
			'add_or_remove_items'        => __( "Add or remove $plural_lower", $this->text_domain ),
			'choose_from_most_used'      => __( "Choose from the most used", $this->text_domain ),
			'popular_items'              => __( "Popular $this->plural", $this->text_domain ),
			'search_items'               => __( "Search $this->plural", $this->text_domain ),
			'not_found'                  => __( "Not Found", $this->text_domain ),
			'no_terms'                   => __( "No $plural_lower", $this->text_domain ),
			'items_list'                 => __( "$this->plural list", $this->text_domain ),
			'items_list_navigation'      => __( "$this->plural list navigation", $this->text_domain )
		);

		$retval = apply_filters( 'ucf_directory_labels', $retval );

		return $retval;
	}

	/**
	 * Returns the arguments used
	 * to register the custom taxonomy
	 * @author Jim Barnes
	 * @since 0.1.0
	 * @return array
	 */
	private function args() {
		$retval = array(
			'labels'                => $this->labels(),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
			'show_tagcloud'         => true,
			'show_in_rest'          => true,
			'rest_base'             => 'directories',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rewrite'               => array( 'slug' => 'directory' )
		);

		$retval = apply_filters( 'ucf_directory_args', $retval );

		return $retval;
	}
}

new Directory();
