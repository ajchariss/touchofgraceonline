<?php get_header(); ?>

<?php get_template_part( 'partials/masthead' ); ?>

    <main id="main-body" <?php post_class( 'page-body' ); ?>>
        <div class="page-content">
            <?php webave_layout_content(); ?>
        </div>	
    </main>
    
<?php get_footer(); ?>
