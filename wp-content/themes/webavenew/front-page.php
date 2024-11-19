<main class="<?php post_class( 'page-body' ); ?>" id="home-body"> 

    <?php echo get_template_part('partials/home-banner');?>

    <div class="page-content">
        
        <?php echo get_template_part('partials/intro-text');?>
        
        <?php echo get_template_part('partials/services');?>        
        
			<section class="counters">
				<div class="container">
					<div class="counters-items">
						<div> <span class="count-num">1500+</span> Accomplished Projects </div>
						<div> <span class="count-num">15+</span>  Strong Years of Experience </div>
					</div>
				</div>
			</section>

            <?php echo get_template_part('partials/testimonials'); ?>
			
            <?php echo get_template_part('partials/portfolio'); ?>
            
            <?php echo get_template_part('partials/cta-banner'); ?>
        
    </div>
</main>