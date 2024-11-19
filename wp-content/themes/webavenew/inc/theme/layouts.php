<?php

function webave_layout_content() {
    load_template( WEBAVE_Layouts::$main_template );
}

function webave_layout_base() {
    return WEBAVE_Layouts::$base;
}

class WEBAVE_Layouts {
    /**
     * Stores the full path to the main template file
     * @var string
     */
    public static $main_template;

    /**
     * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
     * @var  string
     */
    public static $base;

    public static function wrap( $template ) {
        // stash the main template
        self::$main_template = $template;
        self::$base          = substr( basename( self::$main_template ), 0, -4 );

        if ( 'index' === self::$base ) {
            self::$base = false;
        }

        /**
         * Create template hierarchy layouts/{type}.php, layouts/master.php
         */
        $templates = array( 'layouts/default.php' );

        if ( is_archive() || is_post_type_archive() || is_search() || is_tax() ) {
            //array_unshift( $templates, 'layouts/archive.php' );
        }

        if ( self::$base ) {
            array_unshift( $templates, sprintf( 'layouts/%s.php', self::$base ) );
        }

         
        if ( is_front_page() ) {
            array_unshift( $templates, 'layouts/frontpage.php' );
        }
        
       
        return locate_template( $templates );
    }
}
add_filter( 'template_include', array( 'WEBAVE_Layouts', 'wrap' ), 99 );
