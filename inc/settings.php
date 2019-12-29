<?php
class ATF_Settings {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function add_menu_page() {
		add_options_page(
			__( 'Taxonomy Filter', 'admin-taxonomy-filter' ),
			__( 'Taxonomy Filter', 'admin-taxonomy-filter' ),
			'manage_options',
			'admin-taxonomy-filter',
			array( $this, 'render' )
		);
	}

	public function render() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Admin Taxonomy Filter', 'admin-taxonomy-filter' ); ?></h1>
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<form method="post" action="options.php" id="post-body-content">
						<?php
						settings_fields( 'admin_taxonomy_filter' );
						do_settings_sections( 'admin-taxonomy-filter' );
						submit_button();
						?>
					</form>
					<div id="postbox-container-1" class="postbox-container">
						<div class="postbox">
							<h3 class="hndle">
								<span><?php esc_html_e( 'Our WordPress Plugins', 'falcon' ) ?></span>
							</h3>
							<div class="inside">
								<p><?php esc_html_e( 'Like this plugin? Check out our other WordPress plugins:', 'falcon' ) ?></p>
								<p><a href="https://wordpress.org/plugins/meta-box/" target="_blank">Meta Box</a> - <?php esc_html_e( 'Lightweight yet powerful WordPress custom fields plugin', 'falcon' ) ?></p>
								<p><a href="https://wordpress.org/plugins/slim-seo/" target="_blank">Slim SEO</a> - <?php esc_html_e( 'Automated & fast SEO plugin for WordPress', 'falcon' ) ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

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
