<div class="blog-widgets">
    <?php //get_sidebar('sidebar');?>
    
	<div class="widget blog-widget-search">
		<h3>Blog Search</h3>
		<?php get_search_form(); ?>
	</div>
	
	<div class="widget blog-widget-categories">
		<h3>Categories</h3>
		<?php wp_dropdown_categories( 'hide_empty=0' ); ?>
        <script type="text/javascript">
        	<!--
        	var dropdown = document.getElementById("cat");
        	function onCatChange() {
        		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
        			location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
        		}
        	}
        	dropdown.onchange = onCatChange;
        	-->
        </script>		
	</div>
	
	<div class="widget blog-widget-archives">
		<h3>Archives</h3>
        <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
        	<option value=""><?php esc_attr( _e( 'Select Month', 'textdomain' ) ); ?></option> 
        	<?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
        </select>
	</div>
	
</div>