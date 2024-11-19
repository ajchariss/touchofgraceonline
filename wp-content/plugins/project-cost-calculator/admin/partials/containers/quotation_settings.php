

<div class="pro_rate_cal-main-right-content" id="pro_rate_cal_admin">   
	<?php 
	if( isset( $_REQUEST['id'] ) &&  !empty( sanitize_text_field( $_REQUEST['id'] ) ) ){
		$form = $this->get_form( sanitize_text_field( $_REQUEST['id'] ) );
		if( !empty( $form ) ){
			$quotationSettings = new PRC_FormQuotation( $form->ID );
			if( isset( $_POST['page_action'] ) && sanitize_text_field( $_POST['page_action'] ) == "quotation_settings" ){			
				$quotationSettings->update_settings( $_POST );
			}
	?>
	<div id="pro_rate_cal_message" class="pro_rate_cal_message_container pro_rate_cal_custom_form_message">
		<?php
			foreach ( $quotationSettings->getMessage() as $key => $value ) {
				printf( "<p>%s</p>", $value );
			}
		?>
	</div>
	<div class="pro_rate-cal_card rate-cal_no-pad">
		<div class="pro_rate-cal_card_header rate-cal_no-pad">
			<?php  printf( "<h4>%s</h4>", __( "Quotation Notification Settings", "project-cost-calculator" ) );  ?>
			<a class="rate_cal_button rate_cal_button_primary" href="<?php echo esc_url(self::get_admin_main_page_url()); ?>" title="Calculator Form Lists"><?php _e( "All calculators", "project-cost-calculator" ); ?></a>	       
		</div>
		<div class="pro_rate-cal_card-body">
			<form method="POST" action="<?php echo esc_url(self::get_admin_main_page_url(
					array(
						"submenu" => "quotation_settings",
						"id" => $form->ID,
					)
				)); ?>" class="pro_rate-cal_form_layout">
				<input type="hidden" name="page_action" value="quotation_settings">
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php _e( "Send notification to admin", "project-cost-calculator"); ?></label>
										</div>	
										<?php
											$quatation_notification = $quotationSettings->get_properties( "quatation_notification" );
											$quatation_notification_state = "deactive";
											if( !empty( $quatation_notification ) && $quatation_notification == "active" ){
												$quatation_notification_state = "active";
											}
										?>
										<div class="pro_rate-cal_list_content">
											<div class="pro_rate_cal_field_radio_group">
												<div class="pro_rate_cal_field_radio_items pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="quatation_notification" value="active" <?php 
														if( $quatation_notification_state == "active" ){
															echo esc_attr("checked");
														}        
													?> > 
													<label><?php _e( "Yes", "project-cost-calculator"); ?></label>
												</div>
												<div class="pro_rate_cal_field_radio_items pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="quatation_notification" value="deactive" <?php 
														if( $quatation_notification_state == "deactive" ){
															echo esc_attr("checked");
														}        
													?> >
													<label><?php _e( "No", "project-cost-calculator"); ?></label>
												</div>
											</div>
										</div>
										<?php
											unset( $quatation_notification );
											unset( $quatation_notification_state );
										?>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Send notification to user", "project-cost-calculator"); ?></label>
										</div>	
										<?php
											$send_quot_to_user = $quotationSettings->get_properties( "send_quot_to_user" );
											$send_quot_to_user_state = "deactive";
											if( !empty( $send_quot_to_user ) && $send_quot_to_user == "active" ){
												$send_quot_to_user_state = "active";
											}
										?>
										<div class="pro_rate-cal_list_content">
											<div class="pro_rate_cal_field_radio_group">
												<div class="pro_rate_cal_field_radio_items pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="send_quot_to_user" value="active" <?php 
														if( $send_quot_to_user_state == "active" ){
															echo esc_attr("checked");
														}        
													?> > 
													<label><?php esc_html_e( "Yes", "project-cost-calculator"); ?></label>
												</div>
												<div class="pro_rate_cal_field_radio_items pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="send_quot_to_user" value="deactive" <?php 
														if( $send_quot_to_user_state == "deactive" ){
															echo esc_attr("checked");
														}        
													?> >
													<label><?php esc_html_e( "No", "project-cost-calculator"); ?></label>
												</div>
											</div>
										</div>
										<?php
											unset( $quatation_notification );
											unset( $quatation_notification_state );
										?>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Send quotation CTA text", "project-cost-calculator"); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
										<input type="text" name="open_form_quotation_btn_text" value="<?php echo !empty( $quotationSettings->get_properties( "open_form_quotation_btn_text" ) ) ?  esc_attr($quotationSettings->get_properties( "open_form_quotation_btn_text" ))  : esc_attr("Send Quotation") ?>" multiple> 
										</div>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Default message to be displayed while sending the quotation", "project-cost-calculator"); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
											<?php wp_editor(  $quotationSettings->get_properties( "quatation_message" ) , "quatation_message", array("textarea_rows" => 7, 'tinymce' => true,) ); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Send quotation button text ", "project-cost-calculator"); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
										<input type="text" name="send_quotation_btn_text" value="<?php echo !empty( $quotationSettings->get_properties( "send_quotation_btn_text" ) ) ?  esc_attr($quotationSettings->get_properties( "send_quotation_btn_text" ))  : esc_attr("Send") ?>" multiple> 
										</div>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Admin email address", "project-cost-calculator"); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
										<input type="email" name="quatation_email" value="<?php echo !empty( $quotationSettings->get_properties( "quatation_email" ) ) ?  esc_attr($quotationSettings->get_properties( "quatation_email" ) ) : esc_attr(get_bloginfo('admin_email')); ?>" multiple> 
										</div>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Email subject", "project-cost-calculator"); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
										<input type="text" name="quatation_email_subject" value="<?php echo !empty( $quotationSettings->get_properties( "quatation_email_subject" ) ) ?  esc_attr($quotationSettings->get_properties( "quatation_email_subject" ))  : esc_attr("Your Quotation") ?>" multiple> 
										</div>
									</div>
								</div>
							</div>
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php _e( "Email template for both admin and user", "project-cost-calculator"); ?></label>
											<div class="pro_rate_cal_keyword_row">
													<span class="rate_cal_tooltip pro_rate_cal_keyword_generate" style="cursor: copy;">
													<span class="rate_cal_tooltiptext" id="myTooltip">Copy {{quotation}}</span>
														<p class="pro_rate_cal_tooltip-label">
															{{quotation}}
														</p>
													</span>
											</div>
										</div>	
										<div class="pro_rate-cal_list_content">
											<?php wp_editor(  $quotationSettings->get_properties( "quatation_email_template" )  , "quatation_email_template", array("textarea_rows" => 7, 'tinymce' => true,) ); ?>
										</div>
									</div>
								</div>
							</div>
				<div class="pro_rate-cal_list_action_bar">
					<input class="rate_cal_button rate_cal_button_primary" type="submit" value="<?php esc_html_e("Save Changes", "project-cost-calculator" ); ?>">
				</div>
			</form>
		</div> 
	</div>
	<?php 
		}else{
			?><div class="pro_rate_cal_die_mesage"><?php esc_html_e("Sorry, Requested Form are invalid.", "project-cost-calculator" ); ?></div><?php
		}
	}
	?>
</div>
