(function( $ ) {
	'use strict';
	 jQuery( document ).ready( function(){
		// click the next button in step view
		jQuery('.next_row').click(function(){
			jQuery(this).closest('.pro_rate_cal_step_main').hide();
			jQuery(this).closest('.pro_rate_cal_step_main').next().show();
			jQuery(this).closest('.pro_rate_cal_step_main').next().find('tbody').find('.notice').remove();
			var index = 0;
			var count_tr = jQuery(this).closest('.pro_rate_cal_step_main').next().find('tbody tr').length
			jQuery(this).closest('.pro_rate_cal_step_main').next().find('tbody tr').each(function(){
				if( jQuery(this).is(":visible") == false){
					index++;
				}
			});
			var catename = jQuery(this).closest('.pro_rate_cal_step_main').next().find('.cate_name').val();
			if(catename){
				var event = "next";
				tabviewactive(catename,event);
			}	
		 })
		// click the previous button in step view
		  jQuery('.previous_row').click(function(){
				jQuery(this).closest('.pro_rate_cal_step_main').hide();
				jQuery(this).closest('.pro_rate_cal_step_main').prev().show();
				jQuery(this).closest('.pro_rate_cal_step_main').prev().find('tbody').find('.notice').remove();
				var index = 0;
				var count_tr = jQuery(this).closest('.pro_rate_cal_step_main').prev().find('tbody tr').length
				jQuery(this).closest('.pro_rate_cal_step_main').prev().find('tbody tr').each(function(){
					if( jQuery(this).is(":visible") == false){
						index++;
					}
				});
				var catename = jQuery(this).closest('.pro_rate_cal_step_main').prev().find('.cate_name').val();
				if(catename){
					var event = "prev";
					tabviewactive(catename,event);
				}
		})

		// sticky form show time out js 
		setTimeout(function(){  
			jQuery('.sticky_form').addClass('active');
			if(jQuery('.sticky_form').hasClass('active')){
				jQuery('body').addClass('pro_rate_overflow_hide');
			}
			jQuery('.pro_cale_sticky_form_overly').addClass('active');
		 }, ProRateCalFormtimeout * 1000 );
		//  step view in button click hide the category slider

		 jQuery('.view_pricing_row ').click(function(){
		   jQuery('.pro_rate_cal_step_submit_btn_block .rate_cal_button').trigger('click');
		   jQuery('.pro_step_tabs_section').hide()
		 });

		//  show category slider
		 jQuery('.rate_cal_let_me_rate_cal ').click(function(){
			jQuery('.pro_rate_cal_step_submit_btn_block .rate_cal_button').trigger('click');
			jQuery('.pro_step_tabs_section').show()
		  });
		//  tab view js added

		$(".pro_rate_tab_content").hide();
		$(".pro_rate_tab_content:first").show();
		jQuery('.tab_view_tigger_event').trigger("click");
		jQuery('.pro_rate_cale_tab_view select').on("keyup keypress  click",function(){
			jQuery(this).parents("form").trigger("submit");
		});
	
		jQuery('.pro_rate_cale_tab_view input').on("keyup keypress change click",function(){
			jQuery(this).parents("form").trigger("submit");
		});
	
		/* if in tab mode */
		$(".pro_rate_tabs li").click(function() {
			jQuery('.tab_view_tigger_event').trigger("click");
			$(".pro_rate_tab_content").hide();
			var activeTab = $(this).attr("rel"); 
			$("#"+activeTab).fadeIn();		
			$(".pro_rate_tabs li").removeClass("pro_rate_tab_active");
			$(this).addClass("pro_rate_tab_active");
			$(".pro_rate_tab_drawer_heading ").removeClass("pro_rate_tab_d_active ");
			$(".pro_rate_tab_drawer_heading[rel^='"+activeTab+"']").addClass("pro_rate_tab_d_active ");
		});

		/* if in drawer mode */
		$(".pro_rate_tab_drawer_heading").click(function() {
			jQuery('.tab_view_tigger_event').trigger("click");
			$(".pro_rate_tab_content").hide();
			var d_activeTab = $(this).attr("rel"); 
			$("#"+d_activeTab).fadeIn();
			$(".pro_rate_tab_drawer_heading").removeClass("pro_rate_tab_d_active");
			$(this).addClass("pro_rate_tab_d_active");
			$(".pro_rate_tabs li").removeClass("pro_rate_tab_active");
			$(".pro_rate_tabs li[rel^='"+d_activeTab+"']").addClass("pro_rate_tab_active");
		});
		//  tab view js

		// Custom select Start
		$('.fancy-layout select').each(function(){
			var $this = $(this), numberOfOptions = $(this).children('option').length;
			$this.addClass('select-hidden'); 
			$this.wrap('<div class="pro_rate_cal_field_custom_select"></div>');
			$this.after('<div class="pro_rate_cal_field_custom_select_styled"></div>');
			var $styledSelect = $this.next('div.pro_rate_cal_field_custom_select_styled');
			$styledSelect.text($this.children('option').eq(0).text());
			var $list = $('<ul />', {
				'class': 'pro_rate_cal_field_custom_select_options'
			}).insertAfter($styledSelect);
			for (var i = 0; i < numberOfOptions; i++) {
				$('<li />', {
					text: $this.children('option').eq(i).text(),
					rel: $this.children('option').eq(i).val(),
					key: $this.children('option').eq(i).attr("data-key"),
				}).appendTo($list);
			}
			var $listItems = $list.children('li');
			$styledSelect.click(function(e) {
				e.stopPropagation();
				$('div.pro_rate_cal_field_custom_select_styled.active').not(this).each(function(){
					$(this).removeClass('active').next('ul.pro_rate_cal_field_custom_select_options').removeClass('select-show');
				});
				$(this).toggleClass('active').next('ul.pro_rate_cal_field_custom_select_options').toggleClass('select-show');
			});
		
			$listItems.click(function(e) {
				e.stopPropagation();
				let selectedKey = jQuery( this ).attr( "key" );
				jQuery( "option", $this ).each(function(){
					let optionKey = jQuery(this).attr( "data-key" );
					console.log( optionKey );
					console.log( selectedKey == optionKey );
					if( selectedKey == optionKey ){
						jQuery(this).attr( "selected" , true );
						jQuery($list).siblings(".pro_rate_cal_field_custom_select_styled").text( jQuery(this).text() );
					}else{
						jQuery(this).attr( "selected" , false );
					}
				});
				$list.removeClass('select-show');
				if( pro_rate_cal_auto_update ){
					jQuery( $this ).trigger( "change" );
					jQuery(this).parents("form").trigger("submit");
				}
				jQuery(".pro_rate_cal_field_custom_select select").trigger("change");
			});
		
			$(document).click(function() {
				$styledSelect.removeClass('active');
				$list.removeClass('select-show');
			});

		});
		// Custom select End

		// slider category click to active step show
		 jQuery('.pro_step_tabs ').click(function(){
			var cate_name = jQuery(this).attr('data-cat');
			jQuery('.pro_step_tabs').removeClass('active')
			jQuery(this).addClass('active');
			if(cate_name){
				steptabcate(cate_name);
			}
		});

		function steptabcate(cate_name){
			jQuery('.table_data .pro_rate_cal_step_main').each(function(){
				var data = jQuery(this).find('.cate_name').val();
				if(data){
					if(data == cate_name){
						jQuery(this).show();
					}else{
						jQuery(this).hide();
					}
				}else{
					jQuery(this).hide();
				}
				return true;
			})
		
		}

		function tabviewactive (catename, event){
			jQuery('.pro_rate_cal_custom_pagination .pro_rate_cal_item-listing .pro_rate_cal_item-single').each(function(){
				var data = jQuery(this).attr('data-cat');
				if(data == catename){
					if( jQuery(this).css('display') == 'none' ){
						if(event == 'next'){
							if(jQuery('.pro_rate_cal_next').hasClass('.pagi-disabled') == false){
								jQuery('.pro_rate_cal_next').trigger('click');
							}
						}
						if(event == 'prev'){
							if(jQuery('.pro_rate_cal_prev').hasClass('.pagi-disabled') == false){
								jQuery('.pro_rate_cal_prev').trigger('click');
							}
						}
						
					}else{
						jQuery(this).addClass('active');
					}
				}else{
					jQuery(this).removeClass('active')
				}
				return true;
			})
		}

		/* PAGINATION FUNCTIONS For step view */
        if ($(window).width() <= 991) {
			jQuery('.pro_rate_cal_custom_pagination').attr("data-count",'1');
        }
		jQuery(".pro_rate_cal_custom_pagination").each(function() {
				var this_val = $(this);
				if ($('.pro_rate_cal_custom_pagination').length > 0) {
					var totalRows = this_val.find('.pro_rate_cal_item-listing .pro_rate_cal_item-single').length;
					var pageSize = this_val.attr("data-count");
					var noOfPage = totalRows / pageSize;
					noOfPage = Math.ceil(noOfPage);
					var noOfPageCount = noOfPage;
					this_val.find('.total-page-count').remove();
					this_val.find('.pro_rate_cal_item-pagination .page-count').after('<span class="total-page-count"> / ' + noOfPageCount + '</span>');
					for (var i = 1; i <= noOfPage; i++) {
						if (i == 1) {
							var classs = 'selected';
						} else {
							var classs = '';
						}
						this_val.find(".pro_rate_cal_item-pagination .page-count").append('<b class=' + classs + '>' + i + '</b>');
					}
					var totalPagenum = this_val.find(".pro_rate_cal_item-pagination .page-count b").length;
					if (totalPagenum > 1) {
						this_val.find(".pro_rate_cal_item-pagination .page-count b").hide();
						this_val.find('.pro_rate_cal_prev').addClass('pagi-disabled');
						for (var n = 1; n <= 1; n++) {
							this_val.find(".pro_rate_cal_item-pagination .page-count b:nth-child(" + n + ")").show();
						}
					} else {
						this_val.find(".pro_rate_cal_prev").hide();
						this_val.find(".pro_rate_cal_next").hide();
					}
					this_val.find('.pro_rate_cal_item-listing .pro_rate_cal_item-single').hide();
					for (var j = 1; j <= pageSize; j++) {
						this_val.find(".pro_rate_cal_item-listing .pro_rate_cal_item-single:nth-child(" + j + ")").show();
					}
					displayevent($(this));
				}
			
				$(this).find('.pro_rate_cal_next').on('click', function(ev) {
					ev.preventDefault();
					if ($(this_val).find("b.selected:last").nextAll('b').length > 1) {
						$(this_val).find("b.selected").last().nextAll(':lt(1)').show();
						$(this_val).find("b.selected").hide();
						displayevent($(this_val));
						$(this_val).find(".pro_rate_cal_prev").removeClass('pagi-disabled');
						$(this_val).find(".pro_rate_cal_next").removeClass('pagi-disabled');
					} else {
						$(this_val).find("b.selected").last().nextAll().show();
						$(this_val).find("b.selected").hide();
						displayevent($(this_val));
						$(this_val).find(".pro_rate_cal_prev").removeClass('pagi-disabled');
						$(this_val).find(".pro_rate_cal_next").addClass('pagi-disabled');
					}
					var event = 'next'
					displayRows($(this_val),event);
				});
			
				$(this).find('.pro_rate_cal_prev').on('click', function(ev) {
					ev.preventDefault();
					if ($(this_val).find("b.selected:first").prevAll('b').length > 1) {
						$(this_val).find("b.selected").first().prevAll(':lt(1)').show();
						$(this_val).find("b.selected").hide();
						$(this_val).find(".pro_rate_cal_prev").removeClass('pagi-disabled');
						$(this_val).find(".pro_rate_cal_next").removeClass('pagi-disabled');
						displayevent($(this_val));
					} else {
						$(this_val).find("b.selected").first().prevAll().show();
						$(this_val).find("b.selected").hide();
						$(this_val).find(".pro_rate_cal_prev").addClass('pagi-disabled');
						$(this_val).find(".pro_rate_cal_next").removeClass('pagi-disabled');
						displayevent($(this_val));
					}
					var event = 'prev'
					displayRows($(this_val),event);
				});
			
			})

			function displayRows(this_current,event) {
				var currentPage = $(this_current).find('b.selected').text();
				$(this_current).find(".pro_rate_cal_item-listing .pro_rate_cal_item-single").hide();
				var pageSize = $(this_current).attr("data-count");
				var count_li = 1;
				if(event == 'next'){
					var count = 1;
				}else{
					if ($(window).width() <= 991) {
						var count = 1;
					}else{
						var count = 4;
					}
				}
				for (var k = (currentPage * pageSize) - (pageSize - 1); k <= (currentPage * pageSize); k++) {
					$(this_current).find(".pro_rate_cal_item-listing .pro_rate_cal_item-single:nth-child(" + k + ")").show();
					$(this_current).find(".pro_rate_cal_item-listing .pro_rate_cal_item-single:nth-child(" + k + ")").removeClass('active');
					if(count_li == count){
						$(this_current).find(".pro_rate_cal_item-listing .pro_rate_cal_item-single:nth-child(" + k + ")").addClass('active');
						$(this_current).find(".pro_rate_cal_item-listing .pro_rate_cal_item-single:nth-child(" + k + ")").trigger('click');
					}
					count_li++;
				}
				var customPaggiOffset = $(this_current).offset().top;
				$('html, body').animate({
					scrollTop: '' + (customPaggiOffset - 200) + 'px'
				}, 800);
			}
			
			function displayevent(this_current) {
				$(this_current).find(".pro_rate_cal_item-pagination .page-count b").each(function() {
					if ($(this).css('display') === 'inline') {
						$(this).addClass('selected');
					} else {
						$(this).removeClass('selected');
					}
				});
			}	
			/* PAGINATION FUNCTIONS END */
		});	

})( jQuery );






