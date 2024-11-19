<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://unlimitedwp.com/
 * @since      1.0.0
 *
 * @package    Project_rate_calculator
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}
global $wpdb;
    $posts = get_posts(
        array(
            'numberposts' => -1,
            'post_type' => 'rate_calculator',
            'post_status' => 'any',
        )
    );
    foreach ( $posts as $post ) {
        wp_delete_post( $post->ID, true );
    }    
    $results= $wpdb->get_results("select * from ".$wpdb->prefix."term_taxonomy where taxonomy LIKE  'rate_calculator_category'", ARRAY_A );
    foreach ($results as $row){     
              $wpdb->query("delete from ".$wpdb->prefix."terms where term_id =  '".esc_html($row['term_id'])."'") ;
              $wpdb->query("delete from ".$wpdb->prefix."term_relationships where term_taxonomy_id = '".esc_html($row['term_taxonomy_id'])."'");    
                            }
            $wpdb->query("delete from ".$wpdb->prefix."term_taxonomy where taxonomy LIKE 'rate_calculator_category'");
    $wpdb->query( sprintf(
        "DROP TABLE IF EXISTS %s",
        $wpdb->prefix . 'rate_calculator_form_entry'
    ) );
?>