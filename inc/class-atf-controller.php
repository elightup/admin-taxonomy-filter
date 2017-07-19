<?php
/**
 * The main controller that filter posts by taxonomies.
 *
 * @package Admin Taxonomy Filter
 */

/**
 * Main controller class.
 */
class ATF_Controller {
	/**
	 * Current post type.
	 *
	 * @var string
	 */
	public $post_type;

	/**
	 * Add hooks.
	 */
	public function init() {
		add_action( 'restrict_manage_posts', array( $this, 'output_filters' ) );
	}

	/**
	 * Output filters in the All Posts screen.
	 *
	 * @param string $post_type The current post types.
	 */
	public function output_filters( $post_type ) {
		$this->post_type = $post_type;
		$taxonomies      = get_object_taxonomies( $post_type, 'objects' );
		$taxonomies      = array_filter( $taxonomies, array( $this, 'is_filterable' ) );
		array_walk( $taxonomies, array( $this, 'output_filter_for' ) );
	}

	/**
	 * Check if we have some taxonomies to filter.
	 *
	 * @param \WP_Taxonomy $taxonomy The taxonomy object.
	 *
	 * @return bool
	 */
	protected function is_filterable( $taxonomy ) {
		// Post category is filterable by default.
		if ( 'post' === $this->post_type && 'category' === $taxonomy->name ) {
			return false;
		}

		$option = get_option( 'admin_taxonomy_filter' );
		return isset( $option[ $this->post_type ] ) && in_array( $taxonomy->name, (array) $option[ $this->post_type ], true );
	}

	/**
	 * Output filter for a taxonomy.
	 *
	 * @param \WP_Taxonomy $taxonomy The taxonomy object.
	 */
	protected function output_filter_for( $taxonomy ) {
		wp_dropdown_categories( array(
			'show_option_all' => sprintf( __( 'All %s', 'admin-taxonomy-filter' ), $taxonomy->label ),
			'orderby'         => 'name',
			'order'           => 'ASC',
			'hide_empty'      => false,
			'hide_if_empty'   => true,
			'selected'        => filter_input( INPUT_GET, $taxonomy->query_var, FILTER_SANITIZE_STRING ),
			'hierarchical'    => true,
			'name'            => $taxonomy->query_var,
			'taxonomy'        => $taxonomy->name,
			'value_field'     => 'slug',
		) );
	}
}
