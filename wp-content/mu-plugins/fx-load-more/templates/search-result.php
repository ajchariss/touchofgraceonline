<?php
	$title 		= apply_filters( 'the_title', get_the_title() );
	$excerpt 	= apply_filters( 'the_excerpt', get_the_excerpt() );

	// highlight search query if in text
	$query 		= esc_html( $args['query'] );
	$pattern 	= sprintf( '/\b(%s)\b/i', $query );
	$replace 	= '<mark class="search-highlighted">$0</mark>';

	$title 		= preg_replace( $pattern, $replace, $title );
	$excerpt 	= preg_replace( $pattern, $replace, $excerpt );
?>


<a class="search-result" href="<?php the_permalink(); ?>">
	<div class="search-result__img-container">
		<?php echo fx_get_image_tag( get_post_thumbnail_id(), 'search-result__img', 'thumbnail' ); ?>
	</div>
	<h2 class="search-result__title"><?php echo wp_kses_post( $title ); ?></h2>
	<div class="search-result__excerpt">
		<?php echo wp_kses_post( $excerpt ); ?>
	</div>
	<span class="btn btn--primary search-result__link">Read more</span>
</a>