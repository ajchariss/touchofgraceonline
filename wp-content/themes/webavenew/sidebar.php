<aside class="page-sidebar"> 

    <?php  
	if(is_page('112')):
		dynamic_sidebar( 'post-sidebar' ); 
	else:
		dynamic_sidebar( 'sidebar' ); 
	endif;
	?>

</aside>
