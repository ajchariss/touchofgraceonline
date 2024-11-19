<?php if(get_field('cta_banner_image') || get_field('cta_banner_texts') || get_field('cta_banner_form')): ?>

    <section class="cta-banner section-padding">
    				
    	<?php if(get_field('cta_banner_image')):
    	    echo webave_get_image_tag( get_field('cta_banner_image'), ['lazyload cta-banner-image'], true, 'full', [ 'alt' => '' ] ); 
    	endif; ?>
    	<div class="container">
    		<article class="cta-banner-text">  
    			<?php if(get_field('cta_banner_title')): ?>
                    <h2><?php the_field('cta_banner_title'); ?></h2>
                <?php endif; ?>
    		
    		    <?php if(get_field('cta_banner_texts')): ?>
                    <?php the_field('cta_banner_texts'); ?>
                <?php endif; ?>
    		</article>	
    		<div class="cta-banner-graph ">
    			<div class="intakeform">
    				<?php if(get_field('cta_banner_form')): 
                        echo do_shortcode( get_field('cta_banner_form') );
                    endif; ?>
    			</div>  
    		</div>				 
    	</div>
    </section>
    
<?php endif; ?>