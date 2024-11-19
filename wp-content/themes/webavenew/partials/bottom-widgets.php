<section class="bottom-widgets">
	<div class="container">
		<div class="bottom-widgets-items">
		    
			<div class="widget widget-recent-posts">
				<h3>Recent Posts</h3>
				
                <?php
                $rquery = array(
                    'post_type' => 'post'
                    ,'posts_per_page' => 5
                    ,'orderby' => 'ID'
                    ,'order' => 'DESC'
                );
                $latest = new WP_Query($rquery);
                
                if($latest->have_posts()): ?>
                    <ul>
                        <?php while($latest->have_posts()): $latest->the_post(); 
                            if ( has_post_thumbnail() ):
                                $blogImage = webave_get_image_tag( get_post_thumbnail_id( $latest->ID ), ['objectfit blog-thumb'], true, 'thumbnail', [ 'alt' => '' ] );
                            else:
                                $blogImage = webave_get_image_tag( 368, ['objectfit blog-thumb'], true, 'thumbnail', [ 'alt' => '' ] );
                            endif; ?> 
                            <li>
                                <?php echo $blogImage; ?>
                                <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>    
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
                				
			</div>
			
			<div class="widget widget-popular-posts">
				<h3>Popular Posts</h3>
                <?php
                $pquery = array(
                    'post_type' => 'post',
                    'meta_key' => 'post_views_count',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'posts_per_page' => 5                
                );
                $popular = new WP_Query($pquery);
                
                if($popular->have_posts()): ?>
                    <ul>
                        <?php while($popular->have_posts()): $popular->the_post(); 
                            $post_count =  get_post_meta( $popular->ID, 'post_views_count', true );
                            if ( has_post_thumbnail() ):
                                $blog_Image = webave_get_image_tag( get_post_thumbnail_id( $popular->ID ), ['objectfit blog-thumb'], true, 'thumbnail', [ 'alt' => '' ] );
                            else:
                                $blog_Image = webave_get_image_tag( 368, ['objectfit blog-thumb'], true, 'thumbnail', [ 'alt' => '' ] );
                            endif; ?> 
                            <li>
                                <?php echo $blog_Image; ?>
                                <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> <span class="post-count"><?php if($post_count): echo '('.$post_count.')'; endif; ?></span> </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>    
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
			</div>
			
			<div class="widget widget-tags">
				<h3>Tags</h3><br>
                    <?php echo taglists(); ?> 
			</div>
			
		</div>
	</div>
</section>
