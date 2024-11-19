<?php if(get_field('banner_image')): ?>
    <section class="banner">
		<?php echo webave_get_image_tag( get_field('banner_image'), ['objectfit banner-img'], true, 'medium', [ 'alt' => '' ] ); ?>
		<div class="container">
			<article class="banner-info" data-aos="fade-right">
				<?php if(get_field('banner_title')): ?>
				    <h2 class="banner-title"><?php echo esc_html( get_field('banner_title') ); ?></h2>
				<?php endif;
				
				if(get_field('banner_description')): ?>
				    <div class="banner_description hidden-xs-down"><?php echo esc_html( get_field('banner_description') ); ?></div>
				<?php endif;
				
				$link = get_field('banner_button');
                if( $link ): ?>
                    <p><a href="<?php echo esc_url( $link['url']); ?>" class="btn btn-red" target="_blank"><?php echo $link['title']; ?></a></p>
                <?php endif; ?> 
			</article>
		</div>
	</section>
<?php endif;?>