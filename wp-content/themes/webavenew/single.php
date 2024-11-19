<section class="blog-post">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        
            <h2 class="blog-post-title h2"> <?php the_title(); ?> </h2>
            
            <div class="blog-post-content">
                <div class="post-content">
                    <?php if ( has_post_thumbnail($recent->ID) ):
                        echo webave_get_image_tag( get_post_thumbnail_id( $recent->ID ), ['lazyload objectfit post-content-img'], true, 'large', [ 'alt' => '' ] );
                    else:
                        echo webave_get_image_tag( 368, ['lazyload objectfit post-content-img'], true, 'large', [ 'alt' => '' ] );
                    endif; ?>
                    
                    <div class="blog-meta">
                        <span class="blog-meta-author"> <span class="icon-user"> </span> <?php the_author();?>  </span>
                        <span class="blog-meta-date"> <span class="icon-clock"> </span> <?php the_date('F,d,Y'); ?>  </span>
                        <span class="blog-meta-cat"> <span class="icon-tag"> </span> <?php the_category( ', ' ); ?> </span>
                    </div>  
    
                    <article class="post-content-article">
                        <?php the_content(); ?>
                    </article>
                  
                </div>
                <div class="page-sidebar">
                    <?php get_template_part('partials/blog-widgets');?>
                    
                    <div class="adds">
                        <a href="https://my.orangehost.com/aff.php?aff=1449" target="_blank">  
                            <?php echo webave_get_image_tag( 370, ['lazyload objectfit img-responsive'], true, 'large', [ 'alt' => '' ] );?>
                        </a>
                    </div>
                </div>
            </div>
            
        <?php endwhile; endif; wp_reset_postdata(); ?>
    </div>
</section>

<?php get_template_part( 'partials/bottom-widgets' ); ?>