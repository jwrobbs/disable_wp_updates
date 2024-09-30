<?php
/**
Plugin Name: Disable WP Updates
Plugin URI: http://wpmasterbuilder.com
Description: A plugin to disable WordPress updates.
Version: 1.0.8
Author: Josh Robbs
License: GPL2

@package Disable_WP_Updates
 */

namespace Disable_WP_Updates;

defined( 'ABSPATH' ) || die();

// test 8.
$x = 1;

add_filter( 'automatic_updater_disabled', '__return_true' );
add_filter( 'pre_site_transient_update_core', '__return_null' );
add_filter( 'pre_site_transient_update_plugins', '__return_null' );
add_filter( 'pre_site_transient_update_themes', '__return_null' );
add_filter( 'screen_options_show_update', '__return_false' );
define( 'DISALLOW_FILE_MODS', true );

// Hide the pages.
add_action( 'admin_menu', __NAMESPACE__ . '\restrict_plugin_theme_installation' );

/**
 * Remove the ability to install plugins and themes completely.
 *
 * @return void
 */
function restrict_plugin_theme_installation() {
	remove_menu_page( 'plugins.php' ); // Remove the Plugins menu.
	remove_submenu_page( 'themes.php', 'theme-editor.php' ); // Remove Theme Editor.
	remove_menu_page( 'themes.php' ); // Remove the Themes menu.
}
