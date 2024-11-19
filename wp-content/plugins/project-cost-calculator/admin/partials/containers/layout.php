<div class="pro_rate_cal-main-right-content" id="pro_rate_cal_admin">   
	<?php 
		if( isset( $_REQUEST['id'] ) &&  !empty( sanitize_text_field( $_REQUEST['id'] ) ) ){
			$form = $this->get_form( sanitize_text_field($_REQUEST['id']) );
			if( !empty( $form ) ){
				$FormLayout = new PRC_FormLayout( $form->ID );
				if( isset( $_POST['page_action'] ) && sanitize_text_field( $_POST['page_action'] ) == "form_layout_settings" ){			
					$FormLayout->update_settings( $_POST );
				}
	?>
			<div id="pro_rate_cal_message" class="pro_rate_cal_message_container pro_rate_cal_custom_form_message">
				<?php
					foreach ( $FormLayout->getMessage() as $key => $value ) {
						printf( "<p>%s</p>", $value );
					}
				?>
			</div>
			<div class="pro_rate-cal_card rate-cal_no-pad">
				<div class="pro_rate-cal_card_header rate-cal_no-pad">
					<?php  printf( "<h4>%s</h4>", __( "Layout", "project-cost-calculator" ) );  ?>
					<a class="rate_cal_button rate_cal_button_primary" href="<?php echo esc_url(self::get_admin_main_page_url()); ?>" title="Calculator Form Lists"><?php esc_html_e( "All calculators", "project-cost-calculator" ); ?></a>	       
				</div>
				<div class="pro_rate-cal_card-body">
					<form method="POST" action="<?php echo  esc_url(self::get_admin_main_page_url(
							array(
								"submenu" => "layout",
								"id" => $form->ID,
							)
						)); ?>" class="pro_rate-cal_form_layout">
						<input type="hidden" name="page_action" value="form_layout_settings">
						<div class="pro_rate-cal_list_card_group">
							<div class="pro_rate-cal_list_card">
								<div class="pro_rate-cal_list_title">
									<?php printf( "<label>%s</label>", __( "Layout Type", "project-cost-calculator" ) ); ?>
								</div>	
								<div class="pro_rate-cal_list_content">
									<div class="pro_rate_cal_field_radio_group">
										<?php 	 
												$layout_type = $FormLayout->get_layout_type();
										?>
										<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
											<input type="radio" name="layout_type" value="classic-view" <?php echo $layout_type == "classic-view" ? esc_attr('checked'):''; ?> /> 
											<?php printf( "<label>%s</label>", __( "Classic View", "project-cost-calculator" ) ); ?>
										</div>
										<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
											<input type="radio" name="layout_type" value="step-view" <?php echo $layout_type == "step-view" ? esc_attr('checked'):''; ?> />   
											<?php printf( "<label>%s</label>", __( "Step View", "project-cost-calculator" ) ); ?>
										</div>
										<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
											<input type="radio" name="layout_type" value="tab-view" <?php echo $layout_type == "tab-view" ? esc_attr('checked'):''; ?> />   
											<?php printf( "<label>%s</label>", __( "Tab View", "project-cost-calculator" ) ); ?>
										</div>
									</div>
								</div>
							</div>	
							<div class="pro_rate-cal_list_card">
								<div class="pro_rate-cal_list_title">
									<?php printf( "<label>%s</label>", __( " Design  Layout", "project-cost-calculator" ) ); ?>
								</div>	
								<div class="pro_rate-cal_list_content">
									<div class="pro_rate_cal_field_radio_group">
										<?php 	 
												$design_type = $FormLayout->get_design_type();
										?>
										<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
											<input type="radio" name="design_type" value="default-view" <?php echo $design_type == "default-view" ? esc_attr('checked'): esc_attr('checked'); ?> /> 
											<?php printf( "<label>%s</label>", __( "Default View", "project-cost-calculator" ) ); ?>
										</div>
										<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
											<input type="radio" name="design_type" value="fancy-view" <?php echo $design_type == "fancy-view" ? esc_attr('checked'):''; ?> />   
											<?php printf( "<label>%s</label>", __( "Fancy View", "project-cost-calculator" ) ); ?>
										</div>
									</div>
								</div>
							</div>	
						
							<div class="pro_rate-cal_list_card classic_view_layout ">
								<div class="pro_rate-cal_list_title">
									<?php printf( "<label>%s</label>", __( "Layout Css", "project-cost-calculator" ) ); ?>
								</div>	
								<div class="pro_rate-cal_list_content">
									<textarea class="pro_rate-cal_css_textarea" name="layout_css" cols="100" placeholder="Add CSS here"  style="height:300px; width:100%;" ><?php echo esc_attr($FormLayout->get_css()); ?></textarea>
								</div>
							</div>
						</div>	
						<div class="pro_rate-cal_list_action_bar">
							<input class="rate_cal_button rate_cal_button_primary" type="submit" value="Save Changes">
						</div>
						<?php printf( 
								"<p class='layout-desc'>%s </p>", 
								__( "This plugin offers three layouts for the calculator form. The classic layout will have all fields stacked on one page while the stepped layout will take the user through step process to complete the form and receive an estimate. Each category would be a step of its own. And the third layout tab layout will have a dynamic summary.", "project-cost-calculator" )
						);  ?>
					</form>
				</div> 
			</div>
		<?php 
			}else{
				?><div class="pro_rate_cal_die_mesage"><?php _e("Sorry, Requested Form are invalid.", "project-cost-calculator" ); ?></div><?php
			}
		}
		?>
</div>
