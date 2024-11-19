<section class="blogs">
	<div class="container">

		<div class="blog-items">
		    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); global $post;?>
			    <div class="blog-item">   
				    <a href="<?php the_permalink($post->ID); ?>" class="blog-item-img">
    					<?php if ( has_post_thumbnail($post->ID)):
                            echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'lazyload objectfit blog-img' ) );
                        else:
                            echo wp_get_attachment_image( '9', 'large', false, [ 'class' => 'lazyload objectfit blog-img'] );
                        endif; ?>
                    </a>
					<div class="blog-meta">
						<span class="blog-meta-author"> <span class="icon-user"> </span> <?php the_author();?> </span>
						<span class="blog-meta-date"> <span class="icon-clock"> </span> <?php the_date('F d, Y'); ?> </span>
					</div>	

					<article>
						<h3 class="blog-title"><?php the_title(); ?></h3> 
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="btn-red btn">Read more </a>  
					</article>

					<div class="blog-meta bottom">
						<span class="blog-meta-cat"> <span class="icon-tag"> </span> <?php the_category( ', ' ); ?>  </span>
					</div>	
			    </div>
			<?php endwhile; endif; ?>
		</div>
		
        <?php if ( function_exists( 'wp_pagenavi' ) ) : ?>
        	<?php wp_pagenavi(); ?>
        <?php endif; ?>

		<?php wp_reset_postdata();?>
	</div> 
</section>

<?php get_template_part( 'partials/bottom-widgets' ); ?>

