<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://unlimitedwp.com/
 * @since             1.0.0
 * @package           Project_rate_calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Project Cost Calculator
 * Plugin URI:        https://tools.unlimitedwp.com/cost-calculator/
 * Description:       A simple and powerful Project Cost Calculator for your site visitors with readymade templates. - crafted specially for Digital Agencies by UnlimitedWP.
 * Version:           1.0.0
 * Author:            UnlimitedWP
 * Author URI:        https://unlimitedwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       project-cost-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if( ! defined( 'PRC_PLUGIN_DESHICON' ) ){
	define( 'PRC_PLUGIN_DESHICON' , 'dashicons-calculator' );
}

if( !defined( "PRC_MAIN_PAGE_URL" ) ){
	define( "PRC_MAIN_PAGE_URL" , admin_url( "admin.php?page=rate_calculator_main" ) );
}
if( !defined( "PRC_POST_TYPE" ) ){
	define( "PRC_POST_TYPE" , 'rate_calculator' );
}
if( !defined( "PRC_CATEGORY" ) ){
	define( "PRC_CATEGORY" , 'rate_calculator_category' );
}

if( !defined( "PRC_PRE_BUILT_MODULE_PATH" ) ){
	define( "PRC_PRE_BUILT_MODULE_PATH" , plugin_dir_path( __FILE__ )  . 'includes/modules/' );
}

if( !defined( "PRC_ADMIN_CAT_PAGE_URL" ) ){
	define( "PRC_ADMIN_CAT_PAGE_URL" , admin_url( "admin.php?page=rate_calculator_categories" ) );
}

if( !defined( "PRC_TEMPLATE_DIR" ) ){
	define( "PRC_TEMPLATE_DIR" , plugin_dir_path( __FILE__ ) . 'template/' );
}

if( !defined( "PRC_DB_PREFIX" ) ){
	global $wpdb;
	define( "PRC_DB_PREFIX" , $wpdb->prefix.'rate_calculator_' );
}


if( !defined( "PRC_IMAGE_PATH_URL" ) ){
	define( "PRC_IMAGE_PATH_URL" , plugin_dir_url( __FILE__ ).'/public/images/' );
}

if( !defined( "PRC_ADMIN_IMAGE_PATH_URL" ) ){
	define( "PRC_ADMIN_IMAGE_PATH_URL" , plugin_dir_url( __FILE__ ).'admin/images/' );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PROJECT_RATE_CALCULATOR_VERSION', '1.0.0' );


/*  POSTTYPE and TEXONOMY  */
if( file_exists( plugin_dir_path( __FILE__ ) . 'includes/class-project_rate_calculator_posttype_and_texonomy.php' ) ){
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-project_rate_calculator_posttype_and_texonomy.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-project_rate_calculator-activator.php
 */
function activate_project_rate_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-project_rate_calculator-activator.php';
	PRC_Activator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-project_rate_calculator-deactivator.php
 */
function deactivate_project_rate_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-project_rate_calculator-deactivator.php';
	PRC_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_project_rate_calculator' );
register_deactivation_hook( __FILE__, 'deactivate_project_rate_calculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-project_rate_calculator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_project_rate_calculator() {

	$plugin = new Project_rate_calculator();
	$plugin->run();

}
run_project_rate_calculator();
?>