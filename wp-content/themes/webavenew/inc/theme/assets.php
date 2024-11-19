<?php

/**
 * Register and enqueue theme styles
 *
 * @return void
 */
function webave_styles() {
    global $wp_styles;

    $dev     = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ! is_dir( ABSPATH . 'dist' ) );
    $version = $dev ? filemtime( get_template_directory() . '/assets/css/style.css' ) : filemtime( ABSPATH . 'dist/style.min.css' );

     
    wp_register_style(
        'default',
        $dev ? get_template_directory_uri() . '/assets/css/default.css' : site_url() . '/dist/default.min.css',
        array(),
        $version
    );
     
    wp_register_style(
        'normalize',
        $dev ? get_template_directory_uri() . '/assets/css/normalize.css' : site_url() . '/dist/normalize.min.css',
        array(),
        $version
    );

    // need to pull in a google font? consider using the WebFontConfig in header.php
    // if the text flash is too annoying, try using a default font closer to your custom font
    // all else fails, enqueue the google font like usual!

    // Add Main Stylesheet File
    wp_register_style(
        'site-main',
        $dev ? get_template_directory_uri() . '/assets/css/style.css' : site_url() . '/dist/style.min.css',
        array( 'default','normalize' ),
        $version
    );

    if ( ! is_admin() )
    {
        wp_enqueue_style( 'site-main' );
    }
}
add_action( 'wp_enqueue_scripts', 'webave_styles' );


/**
 * Register and enqueue theme scripts
 *
 * @return void
 */
function webave_scripts() {
    $dev     = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ! is_dir( ABSPATH . 'dist' ) );
    $version = $dev ? filemtime( get_template_directory() . '/assets/js/main.js' ) : filemtime( ABSPATH . 'dist/main.min.js' );

    // Add Modernizr js File
    wp_register_script(
        'modernizr',
        get_template_directory_uri() . '/assets/js/vendor/modernizr.min.js',
        false,
        '2.8.2',
        false
    );

    // Add Plugins js File
    wp_register_script(
        'site-plugins',
        $dev ? get_template_directory_uri() . '/assets/js/plugins.js' : site_url() . '/dist/plugins.min.js',
        array( 'jquery' ),
        $version,
        true
    );

    // Add Global js File
    wp_register_script(
        'site-main',
        $dev ? get_template_directory_uri() . '/assets/js/main.js' : site_url() . '/dist/main.min.js',
        array( 'jquery', 'site-plugins' ),
        $version,
        true
    );

    if ( ! is_admin() ) {
        wp_enqueue_script( 'modernizr' );
        wp_enqueue_script( 'site-main' );
        wp_localize_script( 'site-main', 'WEBAVE', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'siteurl' => site_url() ) );
    }
}
add_action( 'wp_enqueue_scripts', 'webave_scripts' );
