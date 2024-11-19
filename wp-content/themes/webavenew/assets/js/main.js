/* ---------------------------------------------------------------------
Global Js
Target Browsers: All
------------------------------------------------------------------------ */

var WAS = ( function( WAS, $ ) {

	/**
	 * Doc Ready
	 */
	$( function() {
		WAS.General.init(); 
		WAS.MobileMenu.init(); 
		WAS.ImAHuman.init();
		WAS.SlickSlider.init();
		WAS.Accordion.init();
		WAS.Social.init();
		AOS.init({
		    easing: 'ease-out-back',
		    duration: 1000
		});
		
	});

	$( window ).on( 'load', function() {
		// TODO: Uncomment if using smooth scrolling anchors
		// WAS.SmoothAnchors.init();
	});

    $(window).scroll(function(){
        var fromTopPx = 100;
        var scrolledFromtop = $(window).scrollTop();
        if(scrolledFromtop > fromTopPx){
            jQuery('.page-header').addClass('js-fixed');
        }else{
            jQuery('.page-header').removeClass('js-fixed');
        }
    }); 	 

	/**
	 * General functionality — ideal for one-liners or super-duper short code blocks
	 */
	WAS.General = {
		init: function() {
			this.bind();
		},

		bind: function() {
			
            $(".menu-btn").on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                $this.toggleClass('active');
                $( ".nav-primary" ).slideToggle();
            });

            $(".icon-search-btn").on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                $this.toggleClass('active');
                $this.parent().toggleClass('active');
                $( ".searchbox--form" ).slideToggle();
            });  
			
			// Selectric
			$('select').selectric({
				arrowButtonMarkup: '<b class="button"></b>'
			});
			
			// IE CSS object-fit support
			objectFitImages();
			
			// pretty-format phone inputs
			$('[type="tel"]').phoneFormat();

			// TODO: Add additional small scripts below


			$(".cta-image-container").inlinePopup({
				itemSelector: ".cta-image-item",
				closeinnerelem: "X"
			});

			
		    var html5lightbox_options = {
		        watermark: "",
		        watermarklink: ""
		    };

		    $(".html5lightbox").html5lightbox();

			/*$('[data-fancybox]').fancybox({
			    youtube : {
			        controls : 0,
			        showinfo : 0
			    },
			    vimeo : {
			        color : 'f00'
			    }
			});*/ 

			$('[data-fancybox]').fancybox({
				playSpeed: 1000,
				autoPlay: true,
				loop: true
			});


		}
	};
	
	/**
	 * Slider/Carousel
	 * @type {Object}
	 */
	WAS.SlickSlider = {
		init: function() {
			// Fix flashing issue (first slide initially shown)
			$( '.slick-slider' ).on( 'init', function( e, slick ) {
				$( '.slideshow .slide' ).show();
			});			

            $('.portfolio-items .row').slick({
            	slidesToShow: 3,
                slidesToScroll: 1,
                dots: false,
                infinite: true,
                arrows: true,
                autoplay: false,
                rows: 0,
                responsive: [
				    {
				    	breakpoint: 1024,
				    	settings: { 
			            	slidesToShow: 2,
			                slidesToScroll: 1,
				    	}
				    },
				    {
				    	breakpoint: 600,
				    	settings: { 
			            	slidesToShow: 1,
			                slidesToScroll: 1,
				    	}
				    }
				]
            }); 

            

            $('.testi-items').slick({
            	slidesToShow: 3,
                slidesToScroll: 1,
                dots: false,
                infinite: true,
                arrows: true,
                autoplay: false,
                rows: 0,
                responsive: [
				    {
				    	breakpoint: 1024,
				    	settings: { 
			            	slidesToShow: 2,
			                slidesToScroll: 1,
				    	}
				    },
				    {
				    	breakpoint: 600,
				    	settings: { 
			            	slidesToShow: 1,
			                slidesToScroll: 1,
				    	}
				    }
				]
            });
            
			
			/* Preloader */
			$( '.js-slider-has-preloader' ).on( 'init', function( e, slick ) {
				$( '.js-slider-has-preloader' ).addClass( 'js-slider-has-preloader-init' );
			});
			
		}
	};

	/**
	 * Display scroll-to-top after a certain amount of pixels
	 * @type {Object}
	 */
	WAS.BackToTop = {

		init: function() {
			this.bind();
		},

		bind: function() {
			$( window ).on( 'scroll load', this.maybeShowButton );
			$( '#back-to-top' ).on( 'click', this.scrollToTop );
		},

		maybeShowButton: function() {
			if ( $( window ).scrollTop() > 100 ) { // TODO: Update "100" for how far down page to show button
				$( '#back-to-top' ).removeClass( 'hide' );
			} else {
				$( '#back-to-top' ).addClass( 'hide' );
			}
		},

		scrollToTop: function() {
			$( window ).scrollTop( 0 );
		}
	};
	
	/**
	 * Mobile menu script for opening/closing menu and sub menus
	 * @type {Object}
	 */
	WAS.MobileMenu = {
		init: function() {
			$( '.nav-primary li.menu-item-has-children > a' ).after( '<span class="sub-menu-toggle icon-cheveron-down hidden-md-up"></span>' );
			$( '.sub-menu-toggle' ).click( function() {
				var $this = $(this),
					$parent = $this.closest( 'li' ),
					$wrap = $parent.find( '> .sub-menu' );
				$wrap.toggleClass( 'js-toggled' );
				$this.toggleClass( 'js-toggled' );
			});
		}
	};
	
	/**
	 * Force External Links to open in new window.
	 * @type {Object}
	 */
	WAS.ExternalLinks = {
		init: function() {
			var siteUrlBase = WAS.siteurl.replace( /^https?:\/\/((w){3})?/, '' );
			$( 'a[href*="//"]:not([href*="'+siteUrlBase+'"])' )
				.not( '.ignore-external' ) // ignore class for excluding
				.addClass( 'external' )
				.attr( 'target', '_blank' )
				.attr( 'rel', 'noopener' );
		}
	};
	
	/**
	 * Responsive Tables
	 * @type {Object}
	 */
	WAS.ResponsiveTables = {

		init: function() {
			this.bind();
		},

		bind: function() {
			var self = this;

			// Add wrappers to table
			// - change ".page-content table" to appropriate class per project
			$( '.page-content table' ).wrap( '<div class="table-wrap-outer"><div class="table-wrap-inner"></div></div>' );
									
			// Make table draggable
			var mx = 0;
			$( '.table-wrap-inner' ).on({
				mousemove: function( e ) {
					var mx2 = e.pageX - this.offsetLeft;
					if ( mx ) {
						this.scrollLeft = this.sx + mx - mx2;
					}
				},
				mousedown: function( e ) {
					this.sx = this.scrollLeft;
					mx      = e.pageX - this.offsetLeft;
				}
			});

			$( document ).on( 'mouseup', function() {
				mx = 0;
			});
			
			// Add class if table is wider than parent
			$( '.table-wrap-outer' ).find( '.table-wrap-inner table' ).each( function() {
				var $table 			= $( this ),
					$table_outer 	= $table.closest( '.table-wrap-outer' );
				if ( $table.width() > $table_outer.width() ) {
					$table_outer.addClass( 'js-table-is-overflowing' );
					$( '.page-content table' ).before( '<div class="js-table-fade"></div>' );
				}
			});
			
		}
	};

	/**
	 * Custom Social Share icons open windows
	 * Generate URLs, place in a tag and use class - example: https://github.com/bradvin/social-share-urls
	 * @type {Object}
	 */
	WAS.Social = {

		init: function() {
			$( '.js-social-share' ).on( 'click', this.open );
		},

		open: function( e ) {
		  e.preventDefault();
		  WAS.Social.windowPopup( $( this ).attr( 'href' ), 500, 300 );
		},

		windowPopup: function( url, width, heigh ) {
			var left = ( screen.width / 2 ) - ( width / 2 ),
				top  = ( screen.height / 2 ) - ( height / 2 );

			window.open(
				url,
				'',
				'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left
			);
		}
	};

	/**
	 * ImAHuman
	 * Hidden Captchas for forms
	 * @type {Object}
	 */
	WAS.ImAHuman = {
		num: "0xFF9481",
		forms: void 0,

		init: function() {
			this.setup();
		},

		setup: function() {
			this.forms = document.getElementsByTagName( 'form' );
			this.bind();
		},

		bind: function() {
			for ( var i = 0; this.forms.length > i; i++ ) {
				$( this.forms[ i ] ).on( 'focus click', this.markAsHuman );
			}
		},

		markAsHuman: function() {
			$( this ).find( '.imahuman, [name="imahuman"]' ).attr( 'value', parseInt( WAS.ImAHuman.num, 16 ) );
		}
	};


	/**
	 * Affix
	 * Fixes sticky items on scroll
	 * @type {Object}
	 */
	WAS.Affix = {
		windowHeight: 0,

		init: function() {
			this.windowHeight = $( window ).height();
			this.bind();
		},

		bind: function() {
			$( window ).on( 'scroll', this.scroll );
			$( window ).on( 'resize', this.updateWindowHeight );
		},

		scroll: function( e ) {
			var scrolltop = $( this ).scrollTop(),
				fixPoint  = WAS.Affix.windowHeight - $( '#masthead' ).height();

			if ( scrolltop >= fixPoint ) {
				$( 'body' ).addClass( 'affix-head' );
			} else {
				$( 'body' ).removeClass( 'affix-head' );
			}
		},

		updateWindowHeight: function( e ) {
			WAS.Affix.windowHeight = $( window ).height();
		}
	};

	/**
	 * WAS.Parallax
	 * Parallax effect for images
	 * @type {Object}
	 */
	WAS.Parallax = {

		init: function() {
			this.bind();
		},

		bind: function() {
			$( window ).scroll( this.scroll );
		},

		scroll: function( e ) {
			$( '.js-parallax' ).each( function() {
				var $this   = $( this ),
					speed   = $this.data( 'speed' ) || 6,
					yPos    = -( $( window ).scrollTop() / speed ),
					coords  = 'center '+ yPos + 'px';

				$this.css( { backgroundPosition: coords } );
			});
		}
	};

	/**
	 * WAS.SmoothAnchors
	 * Smoothly Scroll to Anchor ID
	 * @type {Object}
	 */
	WAS.SmoothAnchors = {
		init: function() {
			this.hash = window.location.hash;
			if ( this.hash != '' ) {
				this.scrollToSmooth( this.hash );
			}
			this.bind();
		},

		bind: function() {
			$( 'a[href^="#"]' ).on( 'click', $.proxy( this.onClick, this ) );
		},

		onClick: function( e ) {
			e.preventDefault();
			var target = $( e.currentTarget ).attr( 'href' );
			this.scrollToSmooth( target );
		},

		scrollToSmooth: function( target ) {
			var $target = $( target );
			$target = ( $target.length ) ? $target : $( this.hash );

			var headerHeight = 0; // TODO: if using sticky header change 0 to
								  // $('#page-header').outerHeight(true)

			if ( $target.length ) {
				var targetOffset = $target.offset().top - headerHeight;
				$( 'html, body' ).animate( { scrollTop: targetOffset }, 600 );
				return false;
			}
		}
	};



	/**
	 * Tab Content
	 * @type {Object}
	 */
	/* HTML Formatting should follow this basic pattern:
	<ul class="js-tabs">
		<li><a href="#tab-content-1">Tab</a></li>
		<li><a href="#tab-content-2">Tab</a></li>
	</ul>
	<div id="tab-content-1">
	<!-- content -->
	</div>
	<div id="tab-content-2">
	<!-- content -->
	</div>
	*/
	WAS.Tabs = {
		init: function() {
			$( '.js-tabs' ).on( 'click touchstart', 'a', this.switchTab );
		},
		switchTab: function( e ) {
			e.preventDefault();
			var $this = $( this ),
				$tab  = $( $this.attr( 'href' ) );

			$this.parent()
				 .addClass( 'active' )
				 .siblings()
				 .removeClass( 'active' );

			$tab.addClass( 'active' )
				.siblings()
				.removeClass( 'active' );
		}
	};


   /**
	 * Accordion
	 */
	WAS.Accordion = {

		init: function() {
			this.bind();
			$('.accordion-content').hide();
		},

		bind: function() {
			$('.accordion-toggle > .accordion-title').on( 'toggle-panel', this.togglePanel );
			$('.accordion-toggle > .accordion-title').click( this.togglePanel );
		},

		togglePanel: function() {
			$this = $(this);
			$target =  $this.parent().next();

			if ( $this.hasClass('active') ) {
				$this.removeClass('active');
				$target.removeClass('active').slideUp();
			} else {
				/* Note: Uncomment this if you want to close all sections when clicked           
				$('.accordion-content').removeClass('active').slideUp();
				$('.accordion-toggle > .accordion-title').removeClass('active');
				*/
				$this.addClass('active');
				$target.addClass('active').slideDown();
			}
		}
	};
	return WAS;

}(WAS || {}, jQuery));

