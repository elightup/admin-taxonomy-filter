<?php
/**
 * Plugin Name: Admin Taxonomy Filter
 * Plugin URI:  https://elightup.com
 * Description: Filter posts or custom post types by taxonomy in the admin area.
 * Version:     1.0.5
 * Author:      eLightUp
 * Author URI:  https://elightup.com
 * License:     GPL2+
 * Text Domain: admin-taxonomy-filter
 * Domain Path: /languages/
 *
 * Copyright (C) 2010-2025 Tran Ngoc Tuan Anh. All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

defined( 'ABSPATH' ) || die;

if ( is_admin() ) {
	require __DIR__ . '/inc/controller.php';
	require __DIR__ . '/inc/settings.php';

	new ATF_Controller;
	new ATF_Settings;
}