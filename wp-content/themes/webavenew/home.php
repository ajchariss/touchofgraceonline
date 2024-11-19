
<section class="featured">
	<div class="container">
		<div class="featured-blog">
		    
			<div class="featured-blog-recent">  
            <?php
                $args = array( 'numberposts' => '1','post_status' => 'publish');
                $recent_post = wp_get_recent_posts( $args );
                
                foreach( $recent_post as $recent ): ?>
                    
					<a href="<?php the_permalink($recent["ID"]); ?>" class="featured-img">  
  						<?php if ( has_post_thumbnail($recent->ID) ):
                            echo webave_get_image_tag( get_post_thumbnail_id( $recent->ID ), ['lazyload objectfit blog-img'], true, 'large', [ 'alt' => '' ] );
                        else:
                            echo webave_get_image_tag( 368, ['lazyload objectfit blog-img'], true, 'large', [ 'alt' => '' ] );
                        endif; ?>
				    </a>
				    
				    <div class="featured-info"> 
					 
						<div class="blog-info">  
							<div class="blog-meta">
								<span class="blog-meta-author"> <span class="icon-user"> </span> <?php the_author();?>  </span>
								<span class="blog-meta-date"> <span class="icon-clock"> </span> <?php the_date('F d, Y'); ?>   </span>
							</div>	

							<article>
								<h3 class="blog-title"><?php echo $recent["post_title"]; ?></h3> 
								<?php the_excerpt(); ?>
								<a href="<?php the_permalink($recent["ID"]); ?>" class="btn-red btn">Read more </a>  
							</article>

							<div class="blog-meta bottom">
								<span class="blog-meta-cat"> <span class="icon-tag"> </span> <?php the_category( ', ' ); ?> </span>
							</div>	
						</div>
					 
				    </div>
                    
                <?php endforeach; 
                wp_reset_query();
            ?>					
			</div>
			
			<aside class="featured-blog-widget"> 
				<?php get_template_part('partials/blog-widgets');?>
			</aside>
			
		</div>
	</div>
</section>

<section class="blogs">
	<div class="container">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $bquery = array(
            'post_type' => 'post'
            ,'posts_per_page' => 7
            ,'orderby' => 'ID'
            ,'order' => 'DESC'
            ,'paged' => $paged
        );
        $num = 1;
        $blogpost = new WP_Query($bquery); ?>

		<div class="blog-items">
		    <?php if($blogpost->have_posts()): while($blogpost->have_posts()): $blogpost->the_post(); 
		        if($num > 1): ?>
			    <div class="blog-item">   
				    <a href="<?php the_permalink($recent["ID"]); ?>" class="blog-item-img">
    					<?php if ( has_post_thumbnail($blogpost->ID) ):
                            echo get_the_post_thumbnail( $blogpost->ID, 'large', array( 'class' => 'lazyload objectfit blog-img' ) );
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
			<?php endif; $num++; endwhile; endif; ?>
		</div>
		
        <?php if ( function_exists( 'wp_pagenavi' ) ) : ?>
        	<?php wp_pagenavi( array( 'query' => $blogpost)); ?>
        <?php endif; ?>

		<?php wp_reset_postdata();?>
	</div> 
</section>

<?php get_template_part( 'partials/bottom-widgets' ); ?>

