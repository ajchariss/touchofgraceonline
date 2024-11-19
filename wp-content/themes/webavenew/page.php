<div class="container">
    
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
    
        <?php if(get_the_content() ): ?>
            <section class="main-text">
                <article><?php the_content(); ?></article>
            </section>
        <?php  endif; ?>
    
    <?php endwhile; endif; ?>

    <?php if(get_field('contact_featured_image') || get_field('contact_form_shortcode')):?> 
        <section class="contact-form-section">
            <div class="row">
                <div class="col-xxs-12 col-md-6"> 
                    <article>
                        <?php if(get_field('contact_header_title')):?>   
                            <h2><?php the_field('contact_header_title'); ?></h2> 
                        <?php endif;
                        
                        if(get_field('contact_description')):   
                            the_field('contact_description'); 
                        endif; ?>
                        
                    </article>
                    
                    <?php if(get_field('contact_featured_image')):?>   
                        <div class="contact_featured_img">
                            <?php echo webave_get_image_tag( get_field('contact_featured_image'), ['lazyload objectfit contact_featured_image'], true, 'medium', [ 'alt' => '' ] ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xxs-12 col-md-6">
                    <?php if(get_field('contact_form_shortcode')): 
                        echo do_shortcode( get_field('contact_form_shortcode') );
                    endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
</div>