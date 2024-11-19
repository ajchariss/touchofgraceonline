<masthead class="masthead masthead-banner"> 
	<?php if(is_page()):
		if ( has_post_thumbnail() ) :
	    		the_post_thumbnail('full', array( 'class' => 'objectfit banner-img' ) );
		else:  
			echo wp_get_attachment_image( '275', 'large', false, [ 'class' => 'objectfit banner-img'] );
	    endif;
	else:
		echo wp_get_attachment_image( '354', 'large', false, [ 'class' => 'objectfit banner-img'] );
	endif; ?>
	
	<div class="container">
		<div class="masthead-banner-info">
            <?php if (is_day()) { ?>
                 <h1> <?php _e( 'Archive for', 'fx' ); ?> <?php the_time('F jS Y'); ?></h1>
            <?php } elseif (is_month()) { ?>
                 <h1> <?php _e( 'Archive for', 'fx' ); ?> <?php the_time('F Y'); ?></h1>
            <?php } elseif (is_category()) { ?>
                 <h1> <?php _e( 'Archive for', 'fx' ); ?> <?php echo single_cat_title(); ?></h1>
            <?php } elseif (is_tax()) { ?>
                 <h1> <?php _e( 'Archive for', 'fx' ); ?> <?php echo single_tag_title(); ?></h1>
            <?php } elseif (is_author()) { ?>
                 <h1> <?php _e( 'Author Archive', 'fx' ); ?></h1>
            <?php } elseif (is_tag()) { ?>
                 <h1> <?php _e( 'Tag Archive', 'fx' ); ?></h1>
            <?php } elseif (is_year()) { ?>
                 <h1> <?php _e( 'Archive for', 'fx' ); ?> <?php the_time('Y'); ?></h1> 
    	    <?php } elseif( is_search() ) { ?>
    	        <h3 class="h1">Search Results</h1>
    	    <?php } elseif ( is_home() || is_singular('post') ) { ?>
    			<h3 class="h1">Blog</h1> 
    	    <?php } elseif ( is_singular('news-events') ) { ?>
    			<h3 class="h1">News & Events</h1> 
    	    <?php } elseif ( is_404() ) { ?>
    	        <h1>Sorry We can't find the page you're looking for.</h1> 
    	    <?php } elseif ( is_page(141) ) { ?> 
    	     
    	    <?php } else { ?>
    	        <h1><?php the_title(); ?></h1>
    	    <?php } ?>
		</div>
	</div>
</masthead>	


<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<div class="breadcrumbs"><div class="container"><ul class="clearfix hidden-sm-down">', '</ul></div></div>' );
} ?>
  
