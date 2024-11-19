<?php if(get_field('portfolio_headline') || get_field('portfolio_short_description') || get_field('portfolio_item_1') || get_field('portfolio_item_2') || get_field('portfolio_item_3')): ?>	
	<section class="portfolio section-padding" id="portfolio-section">
		<div class="container">
		    
			<article class="intro-text">
				<h2 class="styled-title"><?php the_field('portfolio_headline'); ?> </h2> 
				<?php the_field('portfolio_short_description'); ?>
			</article>

            <?php if(get_field('portfolio_item_1') || get_field('portfolio_item_2') || get_field('portfolio_item_3')): ?>	
			    <div class="portfolio-items">
				<div class="row">
				    <?php for($i=1;$i<=3;$i++){ 
				        $field = "portfolio_item_".$i;
				        $p = get_field($field); 
				    ?>
						<div class="col-xxs-12 col-xs-6 col-md-4"> 
							<article class="portfolio-item">
								<div class="portfolio-item-image"> 
									<?php echo webave_get_image_tag($p['portfolio_project_image'], ['portfolio-item-image-obj objectfit'], true, 'full', [ 'alt' => '' ] ); ?>
								</div>  
								<h4><?php echo $p['portfolio_project_type']; ?></h4>									
							</article>
						</div>
				    <?php }?> 
				</div>
			</div>
            <?php endif;
            
            $plink = get_field('portfolio_button');
            if( $plink ): ?>
			    <p class="text-center"><a href="<?php echo esc_url( $plink['url']); ?>" class="btn btn-black"> <?php echo $plink['title']; ?> </a></p>
            <?php endif; ?> 
			
		</div> 
	</section> 
<?php endif;?>
