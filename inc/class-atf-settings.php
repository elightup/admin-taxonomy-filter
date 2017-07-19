<?php
/**
 * The main controller that filter posts by taxonomies.
 *
 * @package Admin Taxonomy Filter
 */

/**
 * Settings class.
 */
class ATF_Settings {
	/**
	 * Add hooks.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add new menu page under Settings.
	 */
	public function add_menu_page() {
		add_options_page(
			__( 'Taxonomy Filter', 'admin-taxonomy-filter' ),
			__( 'Taxonomy Filter', 'admin-taxonomy-filter' ),
			'manage_options',
			'admin-taxonomy-filter',
			array( $this, 'render' )
		);
	}

	/**
	 * Render settings page.
	 */
	public function render() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Admin Taxonomy Filter', 'admin-taxonomy-filter' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'admin_taxonomy_filter' );
				do_settings_sections( 'admin-taxonomy-filter' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register plugin settings.
	 */
	public function register_settings() {
		add_settings_section(
			'general',
			'',
			'__return_null',
			'admin-taxonomy-filter'
		);

		add_settings_field(
			'taxonomies',
			__( 'Select Taxonomies To Filter', 'admin-taxonomy-filter' ),
			array( $this, 'list_taxonomies' ),
			'admin-taxonomy-filter',
			'general'
		);

		register_setting( 'admin_taxonomy_filter', 'admin_taxonomy_filter' );
	}

	/**
	 * Render list of taxonomies.
	 */
	public function list_taxonomies() {
		$option     = get_option( 'admin_taxonomy_filter' );
		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {

			// Do not include menu item.
			if ( 'nav_menu_item' === $post_type ) {
				continue;
			}

			$post_type_object = get_post_type_object( $post_type );
			$taxonomies       = get_object_taxonomies( $post_type, 'objects' );
			if ( empty( $taxonomies ) ) {
				continue;
			}

			$selected = isset( $option[ $post_type ] ) ? $option[ $post_type ] : array();

			echo '<p><strong>', esc_html( $post_type_object->label ), '</strong></p>';
			echo '<ul>';
			foreach ( $taxonomies as $taxonomy ) {

				// Do not include category for post.
				if ( 'post' === $post_type && 'category' === $taxonomy->name ) {
					continue;
				}

				printf(
					'<li><label><input type="checkbox" name="admin_taxonomy_filter[%s][]" value="%s"%s> %s</label></li>',
					esc_attr( $post_type ),
					esc_attr( $taxonomy->name ),
					checked( in_array( $taxonomy->name, $selected, true ), true, false ),
					esc_html( $taxonomy->label )
				);
			}
			echo '</ul>';
		}
	}
}
