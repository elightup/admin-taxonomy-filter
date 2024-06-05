<?php
/**
 * Plugin Name: Admin Taxonomy Filter
 * Plugin URI:  https://elightup.com
 * Description: Filter posts or custom post types by taxonomy in the admin area.
 * Version:     1.0.4
 * Author:      eLightUp
 * Author URI:  https://elightup.com
 * License:     GPL2+
 * Text Domain: admin-taxonomy-filter
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || die;

if ( is_admin() ) {
	require __DIR__ . '/inc/controller.php';
	require __DIR__ . '/inc/settings.php';

	new ATF_Controller;
	new ATF_Settings;
}