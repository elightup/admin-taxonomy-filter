<?php
/**
 * Plugin Name: Admin Taxonomy Filter
 * Plugin URI: https://wordpress.org/plugins/admin-taxonomy-filter/
 * Description: Filter posts or custom post types by taxonomy in the admin area.
 * Version: 1.0
 * Author: Anh Tran
 * Author URI: https://metabox.io
 * License: GPL2+
 * Text Domain: admin-taxonomy-filter
 * Domain Path: /languages/
 *
 * @package Admin Taxonomy Filter
 */

defined( 'ABSPATH' ) || exit;


/**
 * Load plugin text domain.
 */
function atf_load_textdomain() {
	load_plugin_textdomain( 'admin-taxonomy-filter', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'atf_load_textdomain' );

if ( is_admin() ) {
	require_once dirname( __FILE__ ) . '/inc/class-atf-controller.php';
	require_once dirname( __FILE__ ) . '/inc/class-atf-settings.php';
	$controller = new ATF_Controller;
	$controller->init();
	$settings = new ATF_Settings;
	$settings->init();
}
