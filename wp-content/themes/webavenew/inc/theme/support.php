<?php
/**
 * Set Up theme support and functionality
 *
 * @return void
 */
function webave_setup() {

     // Add our own editor style
    add_editor_style();
    add_theme_support( 'title-tag' );

    // Post Formats
    // add_theme_support( 'post-formats', array('gallery', 'image', 'video', 'audio') );

    // Theme Images
    add_theme_support( 'post-thumbnails' );
    // add_image_size( 'page-header', 1600, 396, true ); // true hard crops, false proportional

    // HTML5 Support
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'webave_setup' );

/**
 * Register functionality, initilize plugin functionality
 *
 * @return void
 */
function webave_init() {
    // Register Menu
    register_nav_menus(
        array(
            'footer_menu'  => 'Navigation items for footer links.',
            'main_menu' => 'Navigation items for the main menu.',
        )
    );
}
add_action( 'init', 'webave_init' );

/**
 *  Register sidebars and widgets
 *
 *  @return  void
 */
function webave_widget_init() {
    // Sidebar
    register_sidebar(
        array(
            'name'          => __( 'Main Sidebar Widgets' ),
            'id'            => 'sidebar',
            'description'   => __( 'Widgets for the default sidebar' ),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="widget %2$s" id="%1$s" >',
            'after_widget'  => '</div>',
        )
    );
     
    register_sidebar(
        array(
            'name'          => __( 'Single Posts' ),
            'id'            => 'post-sidebar',
            'description'   => __( 'Widgets for the news & events sidebar' ),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="widget %2$s" id="%1$s" >',
            'after_widget'  => '</div>',
        )
    );
     
}
add_action( 'widgets_init', 'webave_widget_init' );

/**
 * Add "Styles" drop-down
 *
 * @param  array $buttons current buttons to be setup
 * @return array
 */
function webave_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'webave_mce_editor_buttons' );

/**
 * Add styles/classes to the "Styles" drop-down
 *
 * @param  array $settings settings array for tiny mce
 * @return  void
 */
function webave_mce_before_init( $settings ) {
    $style_formats = array(
        array(
            'title'    => 'Button Red',
            'selector' => 'a',
            'classes'  => 'btn btn-red',
        ),
        array(
            'title'    => 'Button Black',
            'selector' => 'a',
            'classes'  => 'btn btn-black',
        ),

        array(
            'title'    => 'Styled Title',
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'classes'  => 'styled-title',
        ),
        
    );

    $settings['style_formats'] = wp_json_encode( $style_formats );

    return $settings;
}
add_filter( 'tiny_mce_before_init', 'webave_mce_before_init' );



function custom_excerpt_length( $length ) {
        return 20;
    }
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* ------------------------------------------ 
*  Add Site/Theme Options
* ------------------------------------------- */ 
 

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Sitewide Information',
        'menu_title'    => 'Sitewide Information',
        'menu_slug'     => 'sitewide-information',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

/* -- ACF Preview path -- */
add_filter( 'acf-flexible-content-preview.images_path', 'get_acf_preview_path' );
function get_acf_preview_path() {
    return 'assets/acf-preview';
}


/* Get Image Tag */
function webave_get_image_tag( $image, $classes = '', string $size = 'full', bool $skip_lazy = false, array $atts = [] ): string {
    $image_id = null;

    // determine if image ID or URL
    if( is_numeric( $image ) ) {
        $image_id = absint( $image );

    // try to find ID based on URL
    } elseif( is_string( $image ) ) {
        $image_id = attachment_url_to_postid( $image );
    }

    // if still empty, check for placeholder
    if( empty( $image_id ) ) {
        $image_id = get_field( 'placeholder_img', 'option' );
    }

    // if STILL empty, return empty string
    if( empty( $image_id ) ) {
        return '';
    }

    // if classes weren't passed as string, try to form string
    if( is_array( $classes ) ) {
        $classes = implode( ' ', $classes );
    }

    // prevent lazyloading from WP Rocket?
    if( $skip_lazy && false !== strpos( $classes, 'skip-lazy' ) ) {
        $classes .= ' skip-lazy';
    }

    // combine classes with tag attributes
    $atts = array_merge( 
        [ 
            'class' => $classes 
        ], 
        $atts 
    );
    $atts = array_filter( $atts );

    // use WP's native function to generate image element
    $tag = wp_get_attachment_image( $image_id, $size, false, $atts );

    return $tag;
}

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */

function custom_search_form( $form ) {
    $form = '<form role="search" method="get" id="search" class="search--form" action="' . home_url( '/' ) . '" >
    <input type="text" value="Search" name="s" id="s" class="search--text" onFocus="if (this.value == \'Search\') {this.value = \'\';}" onBlur="if (this.value == \'\') {this.value = \'Search\';}" />
    <input type="submit" id="searchsubmit" name="search-submit" class="search--submit" value="'. esc_attr__( 'Go' ) .'" />
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'custom_search_form' );




/*-------------------------------------------
 *  Popular Post
* ------------------------------------------- */
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//Get rid of prefetching to keep the count accurate
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    set_post_views($post_id);
}
add_action( 'wp_head', 'track_post_views');

/*-------------------------------------------
 *  Latest Post
* ------------------------------------------- */

function news_and_events($atts)
{
    global $wpdb;
    extract(
        shortcode_atts(array(
            'post_type'  => 'news-events',
            'posts_per_page' => -1 
        ),$atts)
    );

    $query = array(
        'post_type'  => $post_type,
        'posts_per_page' => $posts_per_page, 
        'orderby' => 'date',
        'order'   => 'DESC'
    );

    $postItem = new WP_Query( $query ); 

    $output = "";  
  
    if($postItem->have_posts()): 

    $output .= '<section class="latest news-events">   
        <div class="latest-wrap content-wrap"> 
            <div class="container-fluid">
                <div class="row"> <div class="col-xs-8 col-md-9"><div class="row">';  
                    while($postItem->have_posts()): $postItem->the_post(); 
                        $output .= '<div class="col-xxs-12 col-xs-6 col-md-4 aos-init aos-animate" data-aos="zoom-in"> 
                            <article class="latest-news-item">';
                                $blogimage = '';
                                if ( has_post_thumbnail() ): 
                                    $blogimage = get_the_post_thumbnail_url($postItem->ID, 'blog-thumb'); 
                                else:
                                    $blogimage = get_bloginfo('template_url').'/assets/img/noimage.jpg';
                                endif; 

                                $output .= '<img src="'.$blogimage.'" alt="" class="objectfit news-image">';
                                $output .= '<a href="'.get_the_permalink().'"><h3>'.get_the_title().'</h3></a>';

                                $output .= '<div class="news-meta">  
                                    <span class="meta-date"> <span class="icon-calendar"></span> '.get_the_time('F d, Y').'</span> 
                                    <span class="meta-cat"><span class="icon-file-text2"></span> <a href="/"> outreach </a>, <a href="/">youth</a> </span>  
                                </div>';

                                $output .= '<div class="news-texts">'.get_the_excerpt().' </div>';

                                $output .= '<a href="'.get_the_permalink().'" class="readmore"> Read More <span class="icon-arrow-right"></span></a> '; 

                            $output .= '</article>
                        </div>'; 
                    endwhile;
                $output .= '</div></div><div class="col-xs-4 col-xs-3">'; 
					//get_sidebar();
				$output .= '</div>
				</div>
            </div>
        </div>
    </section> ';
    endif; wp_reset_postdata(); 
    return $output;
    ?>
  
<?php   
}

add_shortcode('news_and_events','news_and_events');
 
function taglists() {
 
    $post_tags = get_tags(array(
        'smallest'                  => 10, 
        'largest'                   => 22,
        'unit'                      => 'px', 
        'number'                    => 10,  
        'format'                    => 'flat',
        'separator'                 => " ",
        'orderby'                   => 'count', 
        'order'                     => 'DESC',
        'show_count'                => 1,
        'echo'                      => false
    ));
    
    $output = '';
    
    if ( ! empty( $post_tags ) ) {
        foreach ($post_tags as $tag) {
            $count = $tag->count;
            $class ='';
            
            if($count > 5 &&  $count <= 10):
                $class = 'small-tag';
            elseif ($count > 10 &&  $count <= 15 ):
                $class = 'med-tag';
            elseif($count > 15):
                $class = 'big-tag';
            endif;
            
            $output .= '<a href="' . esc_attr( get_tag_link( $tag->term_id ) ) . '" class="'.$class.'">' . __( $tag->name ) . '</a>' . $separator;
        }
    } 
        
    return trim( $output, $separator );
}
    