<?php
/**
 * Output style to change logo on login
 *
 * @return void
 */
function webave_login_logo() {
    ?>
    <style type="text/css">
        h1 a {
            background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/long-logo.jpg') !important;
            background-size: 400px 67px !important;
            height: 67px !important;
            width: 400px !important;
            margin-bottom: 20px !important;
            padding-bottom: 0 !important;
            margin-left: -10% !important;
        }
        
        .login form { margin-top: 25px !important; }

        #nav {
            float: right !important;
            width: 50%;
            padding: 0 !important;
            text-align: right !important;
        }

        #backtoblog {
            float: left !important;
            width: 50%;
            padding: 0 !important;
            margin-top: 24px;
        }
    </style>
    <?php
}
add_action( 'login_head', 'webave_login_logo' );


/**
 * Change logo url on login
 *
 * @return void
 */
function webave_login_url() {
    return get_bloginfo('url');
}
add_filter('login_headerurl','webave_login_url');


/**
 * Change logo title on login
 *
 * @return void
 */
function webave_login_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'webave_login_title');


/**
 * Removes Items from the sidebar that aren't need
 *
 * @return void
 */
function webave_remove_admin_menu_items() {
    global $menu;

    // array of item names to remove
    $remove_menu_items = array(
        __('Comments')
    );

    end( $menu );
    while ( prev( $menu ) ) {
        $item = explode( ' ', $menu[ key( $menu ) ][0] );
        if ( in_array( null !== $item[0] ? $item[0] : '', $remove_menu_items, true ) ) {
            unset( $menu[ key( $menu ) ] );
        }
    }
}
add_action( 'admin_menu', 'webave_remove_admin_menu_items' );

/**
 * Removes nodes from admin bar to make for white labeled
 *
 * @param  class $wp_toolbar the WordPress toolbar instance
 * @return class             returns the modifies
 */
function webave_remove_admin_bar_menus( $wp_toolbar ) {
    $wp_toolbar->remove_node( 'wp-logo' );
    return $wp_toolbar;
}
add_action( 'admin_bar_menu', 'webave_remove_admin_bar_menus', 999 );

/**
 * Remove the defualt dashboard widgets for orgs
 *
 * @return null
 */
function webave_remove_dashboard_widgets() {
    // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'webave_remove_dashboard_widgets', 0 );

/**
 * Remove the WordPress text at the bottom of the admin
 *
 * @param  string $text current footer text
 * @return string the changed footer text
 */
function webave_remove_footer_text( $text ) {
    return '';
}
add_filter( 'update_footer', 'webave_remove_footer_text', 999 );
add_filter( 'admin_footer_text', 'webave_remove_footer_text' );
