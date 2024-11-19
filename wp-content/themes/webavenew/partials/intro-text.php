<?php if(get_field('intro_heading_title') || get_field('intro_content') || get_field('intro_first_button') || get_field('intro_second_button')): ?>
	<section class="wysiwyg section-padding" id="about-section">
		<div class="container">
			<article class="intro-text"> 
				<?php if(get_field('intro_heading_title')):?>  <h2 class="styled-title"><?php the_field('intro_heading_title'); ?></h2> <?php endif; ?>
				<?php if(get_field('intro_content')): the_field('intro_content'); endif; ?>
				<?php 
				$link1 = get_field('intro_first_button');
				$link2 = get_field('intro_second_button'); 
				?>
				<?php if($link1):?> <a href="<?php echo esc_url( $link1['url'] ); ?>" class="btn-red btn"><?php echo esc_attr( $link1['title'] ); ?></a> <?php endif; ?>
				<?php if($link2):?> <a href="<?php echo esc_url( $link2['url'] ); ?>" class="btn-black btn"><?php echo esc_attr( $link2['title'] ); ?></a> <?php endif; ?>
			</article>
		</div> 
	</section> 
<?php endif;?>
