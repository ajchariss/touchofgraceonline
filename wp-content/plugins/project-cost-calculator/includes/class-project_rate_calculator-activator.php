<?php
/**
 * Fired during plugin activation
 *
 * @link       https://unlimitedwp.com/
 * @since      1.0.0
 *
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Project_rate_calculator
 * @subpackage Project_rate_calculator/includes
 * @author     Unlimited Wp <hello@unlimitedwp.com>
 */
class PRC_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		PRC_Post_Texonomy::wp_create_cpt_rate_calculator();
		//create pre form on activation
		PRC_Post_Texonomy::create_pre_form();
		/** Create Table for entries */ 
		global $wpdb;
		$dbprefix = PRC_DB_PREFIX;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$table_name = $dbprefix . 'form_entry';
		$table_create="CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`form_id` int(11) NOT NULL,
			`form_details` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8";
			
		dbDelta( $table_create );

	}
	
}
?>