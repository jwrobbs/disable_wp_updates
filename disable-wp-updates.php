<?php
/**
Plugin Name: Disable WP Updates
Plugin URI: http://wpmasterbuilder.com
Description: A plugin to disable WordPress updates.
Version: 1.1.0
Author: Josh Robbs
License: GPL2

This plugin was built to disable almost all WordPress updates.

Blocked:
- automatic updates
- updates page
- theme installation, updates, and activation
- plugin page in its entirety

Not blocked:
- composer
- wp cli

@package Disable_WP_Updates
 */

namespace Disable_WP_Updates;

defined( 'ABSPATH' ) || die();

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
}


/**
 * Remove the ability to activate themes.
 */
function restrict_theme_activation() {
	$roles = wp_roles()->roles;
	foreach ( $roles as $role_name => $role_info ) {
		$role = get_role( $role_name );
		if ( $role ) {
			$role->remove_cap( 'switch_themes' );   // Remove ability to activate themes.
			$role->remove_cap( 'install_themes' );  // Remove ability to install themes.
			$role->remove_cap( 'delete_themes' );   // Remove ability to delete themes.
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\restrict_theme_activation', 11 );
