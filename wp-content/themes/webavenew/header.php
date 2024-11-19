<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<!--<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:ital,wght@0,300:0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">-->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto+Condensed:wght@400;700&family=Roboto+Slab:wght@300;400;700&display=swap" rel="stylesheet">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>> 
         
		<header class="page-header">
		    
			<div class="page-header-top">
				<div class="container">
					<div class="top-left">
						<a href="mailto: contact@webavenew.com"> <span class="icon-mail"></span>   contact@webavenew.com </a>
						<a href="https://calendly.com/webavenew/30min" target="_blank"> <span class="icon-phone"></span>  Book a Call </a>
					</div>
					<div class="top-right">
						<div class="site-search">   	   
							<form method="get" id="search" action="/" class="searchbox--form"> 
								<span class="searchbox--fields">                                 
									<input type="text" name="s" 
										class="searchbox--text" 
										value="" 
										onFocus="if (this.value == '') {this.value = '';}" 
										onBlur="if (this.value == '') {this.value = ';}" 
									/>                                        
									<input type="submit" value="Search" class="searchbox--submit" name="searchbox-submit" />  
								</span> 
							</form>               
						</div> <!--site search end -->      

						<a href="https://www.facebook.com/webavenew/" target="_blank"> <span class="icon-facebook-with-circle"></span> </a>
						<a href="https://www.instagram.com/webavenew/" target="_blank"> <span class="icon-instagram-with-circle"></span>  </a>
					</div>	
				</div>
			</div>

			<div class="container">
				<a href="<?php echo home_url( '/' ); ?>" class="logo">
				    <?php //echo webave_get_image_tag( 321, ['lazyload logo-img'], true, 'full', [ 'alt' => '' ] ); ?> 
				    <img src=<?php echo get_template_directory_uri(); ?>/assets/img/long-logo.jpg" alt="" class="logo-img" height="50"/>
				</a>
				<div class="mainmenu">
					<button class="menu-btn hidden-md-up"><span class="icon-menu"> </span></button>
					
			    	<ul class="nav-primary">
    				<?php
    	                // Output the main Menu
                        wp_nav_menu( array(
                            'theme_location'   => 'main_menu'
                            ,'container'       => ''
                            ,'items_wrap'      => '%3$s'
                            ,'depth'           => 3
                        ));
    	            ?>  
			    	</ul>
			    	
		    	</div>
			</div>
    	</header>
