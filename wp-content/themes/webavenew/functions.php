<?php
/**
 * Bootstrap File
 * File is only used to load in the necessary files for the theme - no
 * functions should be added here directly.
 *
 * Please keep in mind that only presentation functionality should be added 
 * inside the theme. Any additional functionality - custom post types, 
 * taxonomies, etc. - should be added in plugins or mu-plugins to allow 
 * the theme to be changed without affecting site functionality.
 */

// Remove unnecessary items from head
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );

// Grab path for includes
$theme_path = get_template_directory();

/**
 * Include the theme support file
 * Contains logic for setting up theme support items
 */
require_once $theme_path . '/inc/theme/support.php';

/**
 * Include the theme assets file
 * Contains logic for enqueueing styles and scripts
 */
require_once $theme_path . '/inc/theme/assets.php';

/**
 * Include class to create layouts
 */
require_once $theme_path . '/inc/theme/layouts.php';

/**
 * Include whitelabel
 */
require_once $theme_path . '/inc/theme/whitelabel.php';
