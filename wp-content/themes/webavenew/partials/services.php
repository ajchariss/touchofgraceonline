<?php if(get_field('cta_heading_title') || get_field('cta_short_description') || get_field('cta_images') || get_field('cta_images_2') || get_field('cta_images_3')): ?>
	<section class="service" id="services-section">
		<div class="container">
		    
			<article class="intro-text">
				<h2 class="styled-title"> <?php the_field('cta_heading_title'); ?> </h2> 
			    <?php the_field('cta_short_description'); ?>						
			</article>
			
			<div class="image-buttons">
    			<?php for($a=1; $a<=3; $a++){
    			    $cta_field = "cta_images_".$a;
    			    $cta = get_field($cta_field); 
    			    ?>
    				<a href="<?php echo $cta['cta_image_link']; ?>" class="image-buttons-item"> 
    					<?php echo webave_get_image_tag($cta['cta_image'], ['lazyload objectfit img-btn'], true, 'medium', [ 'alt' => '' ] ); ?>
    					<div class="img-details">
    						<h3><?php echo $cta['cta_image_title']; ?></h3>
    						<div class="img-details-inner">
    							<?php echo $cta['cta_image_texts']; ?>
    						</div>
    					</div>
    				</a>
    			<?php } ?> 
			</div>

		</div>
	</section>
<?php endif;?>
