		<footer class="page-footer">
			<div class="container">
				<div class="footer-links">
					<div class="footer-links-box1">
						<a href="<?php echo home_url( '/' ); ?>" class="flogo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/short-logo.png" alt="" class="img-responsive"/></a>
					</div>
					<div class="footer-links-box2">
						<h3>Services</h3>
						<ul>
							<li> Web Design & Development  </li> 
							<li> Web Maintenance  </li>
							<li> Search Engine Optimization </li>
							<li> Social Media Management  </li>
							<li> Community Management  </li>
							<li> Graphics Design  </li>
							<li> Basic Video Editing  </li>
							<li> Data Integration </li>
						</ul>
					</div>
					<div class="footer-links-box3">
						<h3>Quick Links</h3>
    				<?php
    	                // Output the main Menu
                        wp_nav_menu( array(
                            'theme_location'   => 'footer_menu'
                            ,'container'       => ''
                            ,'items_wrap'      => '<ul>%3$s</ul>'
                            ,'depth'           => 3
                        ));
    	            ?>  
					</div>
					<div class="footer-links-box4">
						<h3>Contact</h3>  
						<nav class="fcontact">
							<p><span class="icon-phone"></span> <a href="https://calendly.com/webavenew/30min" target="_blank"> Book A Call </a> </p>
							<p><span class="icon-mail"></span> Email: <a href="mailto: contact@webavenew.com">contact@webavenew.com</a></p>
						</nav>
						
						<h3 class="follow-title">Follow Us:</h3>
						<nav class="fsocials">
							<a href="https://www.facebook.com/webavenew/" target="_blank"><span class="icon-facebook-with-circle"></span></a>
							<!--<a href="/" target="_blank"><span class="icon-twitter-with-circle" ></span></a>-->
							<a href="https://www.instagram.com/webavenew/" target="_blank"><span class="icon-instagram-with-circle"></span></a>
							<!--<a href="/" target="_blank"><span class="icon-linkedin-with-circle"></span></a>-->
						</nav>

					</div>
				</div>
			</div>
			<div class="copyright"> Copyright &copy; <?php echo date('Y');?>. All Rights Reserved.  <a href="<?php the_permalink(350);?>">Site Credits</a> | <a href="<?php the_permalink(352);?>">Sitemap</a> </div>
		</footer>

		 
        <!-- Extra Check to make sure jquery gets included -->
        <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/html5lightbox/html5gallery.js"></script> 
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/html5lightbox/html5lightbox.js"></script> 

        <?php wp_footer(); ?>
    </body>
</html>
