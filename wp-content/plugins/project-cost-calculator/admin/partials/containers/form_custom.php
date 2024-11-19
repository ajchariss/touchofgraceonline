
    <div class="pro_rate_cal-main-right-content" id="pro_rate_cal_admin"> 
		<?php
			if( isset( $_REQUEST['id'] ) &&  !empty( sanitize_text_field($_REQUEST['id']) ) ){
				$form = $this->get_form( sanitize_text_field( $_REQUEST['id'] ) );
				if( $form ){
					$form_field = new PRC_FormField($form->ID );
					$notifi_form_field = new PRC_NotificationField( $form->ID );
					if( isset($_POST['page_action']) && sanitize_text_field( $_POST['page_action'] ) == "pro_rat_cal_form_fields" ){
						$form_field->update_settings( $_POST );
					}
					if( isset($_POST['page_action']) && sanitize_text_field( $_POST['page_action'] ) == "pro_rat_cal_notifi_form_fields" ){
						$notifi_form_field->update_settings( $_POST );
					}
					$formProperties = $form_field->getProperties();
					$NotifiFormProperties = $notifi_form_field->getProperties();
				?>
				<div id="pro_rate_cal_message" class="pro_rate_cal_message_container pro_rate_cal_custom_form_message">
					<?php
					foreach ($form_field->get_message() as $key => $value) {
						printf('<p>%s</p>', $value);
					}
					foreach ($notifi_form_field->get_message() as $key => $value) {
						printf('<p>%s</p>',$value);
					}
					?>
				</div>
				<div class="pro_rate-cal_card rate-cal_no-pad">
					<div class="pro_rate-cal_card_header rate-cal_no-pad">
						<h4><?php esc_html_e( "Form", "project-cost-calculator" ); ?></h4> 	
						<a class="rate_cal_button rate_cal_button_primary" href="<?php echo esc_url( self::get_admin_main_page_url()); ?>" title="Calculator Form Lists"><?php esc_html_e( "All calculators", "project-cost-calculator" ); ?></a>       
					</div>
					<div class="pro_rate-cal_card-body">
						<form method="post" id="pro_rate_cal_custom_fields_form" action="<?php echo esc_url(self::get_admin_main_page_url(array("submenu" => "form_custom","id" => $form->ID))); ?>" >
							<input type="hidden" name="page_action" value="<?php echo esc_attr($formProperties[ 'page_action' ]);?>">
							<input type="hidden" name="form_id" value="<?php echo esc_attr($form_field->form_id); ?>">
							<div class="pro_rate-cal_row">
								<div class="pro_rate-cal_col_md_12">
									<div class="pro_rate-cal_list_card">
										<div class="pro_rate-cal_list_title">
											<label><?php esc_html_e( "Form Enable/Disable", "project-cost-calculator" ); ?></label>
										</div>	
										<div class="pro_rate-cal_list_content">
											<div class="pro_rate_cal_field_radio_group">
												<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="form_state" value="active" <?php
														if( $formProperties['form_state'] == "active" ){ echo esc_attr( "checked" ); }
													?>> 
													<label><?php esc_html_e("Enable", "project-cost-calculator"); ?></label>
												</div>
												<div class="pro_rate_cal_field_radio_item pro_rate_cal_field_radio_group_inline">
													<input type="radio" name="form_state" value="deactive" <?php
														if( $formProperties['form_state'] == "deactive" ){ echo esc_attr( "checked" ); }
													?>>
													<label><?php esc_html_e("Disable", "project-cost-calculator"); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
							<!-- Tab Start -->
							<div class="pro_rate-cal_panel_tab" style="<?php if( $formProperties['form_state'] == "deactive" ){ echo esc_attr("display:none;"); } ?>">
								<div class="pro_rate-cal_tab_nav">
									<ul>
										<li class="pro_rate-cal_tab_nav_tablinks active" onclick="pro_rate_cal_tab_notification(event, 'tab_form_ields')" id="defaultOpen"><?php esc_html_e( "Form Fields", "project-cost-calculator" ); ?></li>
										<li class="pro_rate-cal_tab_nav_tablinks " id="notification-tab" onclick="pro_rate_cal_tab_notification(event, 'tab_notification')"><?php esc_html_e( "Notification", "project-cost-calculator" ); ?></li>
									</ul>
								</div>
								<div class="pro_rate-cal_tab-cantent-main">
								<div id="tab_form_ields" class="pro_rate-cal_tabcontent">
								<div class="pro_rate-cal_list_card_group">
									<div class="pro_rate-cal_row">	
										<div class="pro_rate-cal_col_md_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Form Title", "project-cost-calculator" ); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<input type="text" name="form_name" placeholder="<?php esc_attr_e("Form Title", "project-cost-calculator"); ?>" value="<?php
														echo esc_attr($formProperties['form_name']);
													?>" required>
												</div>
											</div>
										</div>	
									</div>
									<div class="pro_rate-cal_row">	
										<div class="pro_rate-cal_col_md_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Open Form Delay", "project-cost-calculator" ); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<input type="number" name="form_timeout" min="0" max="900" step="1" list="form_timeout_values" placeholder="<?php esc_attr_e("Form Timeout", "project-cost-calculator"); ?>" value="<?php
															echo esc_attr($formProperties['form_timeout']);
													?>" required>&nbsp;<span class="pro_rate-cal-seconds-label"><?php esc_html_e( "Seconds", "project-cost-calculator" ); ?></span>
												</div>
											</div>
										</div>	
									</div>
									<div class="pro_rate-cal_row">
										<div class="pro_rate-cal_col_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e("Introduction Paragraph", "project-cost-calculator"); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<?php wp_editor( $formProperties['intro_paragraph'], "intro_paragraph", array("textarea_rows" => 7, 'tinymce' => true, ) ); ?>
												</div>
											</div>
										</div>	
									</div>
									<div class="pro_rate-cal_row">
										<div class="pro_rate-cal_col_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Form fields", "project-cost-calculator" ); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<div class="pro_rate_cal_table_responsive">
														<table id='table-draggable2'> 
															<thead>
																<tr>
																	<th align="left"><?php esc_html_e("Name", "project-cost-calculator"); ?></th>
																	<th align="left"><?php esc_html_e("Label", "project-cost-calculator"); ?></th>
																	<th align="left"><?php esc_html_e("Enabled", "project-cost-calculator"); ?></th>
																	<th align="left"><?php esc_html_e("Required", "project-cost-calculator"); ?></th>
																	<th align="left"><?php esc_html_e("Validation", "project-cost-calculator"); ?></th>
																</tr>
															</thead>
															<?php $fields = [
																'firstname' => ['key_label'=>$formProperties['fields']['firstname']['key_label'] ,'label' => $formProperties['fields']['firstname']['label'] ,'validation_message' => $formProperties['fields']['firstname']['validation_message'] , 'readonly' => 'false','required' => $formProperties['fields']['firstname']['required'], 'order' => $formProperties['fields']['firstname']['order'], 'enabled'=> $formProperties['fields']['firstname']['enabled'] ],
																'lastname' => ['key_label'=>$formProperties['fields']['lastname']['key_label'] , 'label' => $formProperties['fields']['lastname']['label'] ,'validation_message' => $formProperties['fields']['lastname']['validation_message'] , 'readonly' => 'false', 'required' => $formProperties['fields']['lastname']['required'], 'order' => $formProperties['fields']['lastname']['order'],  'enabled'=> $formProperties['fields']['lastname']['enabled'] ],
																'email' => ['key_label'=>$formProperties['fields']['email']['key_label'] , 'label' =>  $formProperties['fields']['email']['label'] ,'validation_message' =>  $formProperties['fields']['email']['validation_message'] , 'readonly' => 'false', 'required' => $formProperties['fields']['email']['required'], 'order' => $formProperties['fields']['email']['order'] ,  'enabled'=> $formProperties['fields']['email']['enabled'] ],
																'phone' => ['key_label'=>$formProperties['fields']['phone']['key_label'] , 'label' => $formProperties['fields']['phone']['label'] ,'validation_message' => $formProperties['fields']['phone']['validation_message'] , 'readonly' => 'false', 'required' => $formProperties['fields']['phone']['required'], 'order' => $formProperties['fields']['phone']['order'] ,  'enabled'=>$formProperties['fields']['phone']['enabled'] ],
																'address' => ['key_label'=>$formProperties['fields']['address']['key_label'] , 'label' => $formProperties['fields']['address']['label'] ,'validation_message' => $formProperties['fields']['address']['validation_message'] , 'readonly' => 'false', 'required' => $formProperties['fields']['address']['required'], 'order' => $formProperties['fields']['address']['order'] , 'enabled'=>$formProperties['fields']['address']['enabled'] ],
															];
															//sort fields as per orders
															$order = array();
															foreach ($fields as $key => $value) {
																$order[$value['order']] = $value;
																$order[$value['order']]['key'] = $key;
															}
															ksort($order);
															?>
															<tbody class="pro_rate_cal_sortable">
																<?php  foreach ($order as $key => $fvalue) {
																?>
																	<tr class="rental_inputline clearfix">
																		<td >
																			<label style="width: 100px !important"><?php echo esc_html( $fvalue['key_label'] ) ?></label>
																		</td>
																		<td>
																			<?php $value = $fvalue['label']; ?>
																			<input type="text" name="fields[<?php echo esc_attr($fvalue['key']); ?>][label]" value="<?php echo esc_attr( $value ); ?>" /></td>
																		<td>
																		<?php $checked = $fvalue['enabled'] == true ? esc_html("checked"): ""; ?>
																		<input class="show_enabled" type="checkbox" <?php echo $fvalue['readonly']=='true'? esc_attr("disabled=''"):"" ?> name="fields[<?php echo esc_html($fvalue['key']); ?>][enabled]" value="1" <?php echo esc_attr($checked); ?> /><?php esc_html_e('Show',"project-cost-calculator")?></td>
																		<td>
																			<?php $checked = (isset($fvalue['required']) && $fvalue['required'] == 1) ? esc_html("checked"):""; ?>
																			<span class="show_required" >
																				<input  type="checkbox"  <?php echo $fvalue['readonly']=='true'? esc_html("disabled=''"):"" ?> name="fields[<?php echo esc_attr($fvalue['key']); ?>][required]" value="1" <?php echo  esc_attr($checked); ?> />
																				<?php esc_html_e("Required", "project-cost-calculator"); ?>
																			</span>
																		</td>
																		<td>									
																			<input type="text" name="fields[<?php echo esc_attr($fvalue['key']); ?>][validation_message]" value="<?php echo esc_attr( $fvalue['validation_message'] ); ?>" />
																			<input type="hidden" class="pro_rate_cal_field_order_input" name="fields[<?php echo esc_attr($fvalue['key']); ?>][order]" value="<?php echo esc_attr($fvalue['order']); ?>" />
																		</td>			
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</div>	
												</div>
											</div>
										</div>	
									</div>
									<div class="pro_rate-cal_row">
										<div class="pro_rate-cal_col_md_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Button Text", "project-cost-calculator" ); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<input type="text" name="btn_text" placeholder="<?php esc_attr_e("Button Text", "project-cost-calculator"); ?>" value="<?php
														echo esc_attr( $formProperties['btn_text'] );								
													?>">
												</div>
											</div>
										</div>	
									</div>	
									<div class="pro_rate-cal_row">
										<div class="pro_rate-cal_col_md_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Description", "project-cost-calculator"); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<?php wp_editor( $formProperties['valeditonary_text'], "valeditonary_text", array("textarea_rows" => 7, 'tinymce' => true,) ); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="pro_rate-cal_row">
										<div class="pro_rate-cal_col_md_12">
											<div class="pro_rate-cal_list_card">
												<div class="pro_rate-cal_list_title">
													<label><?php esc_html_e( "Webhook Settings", "project-cost-calculator"); ?></label>
												</div>	
												<div class="pro_rate-cal_list_content">
													<label for="iswebhook"><?php esc_html_e( "Send to Webhook", "project-cost-calculator"); ?> : </label>
													<input type="checkbox" name="iswebhook" value="1" <?php
														if( $formProperties['iswebhook'] == 1 ){
															echo esc_attr("checked");
														}
													?> >
												</div>
												<div class="pro_rate-cal_list_content">
													<label for="webhookurl"><?php esc_html_e( "Webhook URL", "project-cost-calculator"); ?> : </label>
													<input type="url" name="webhookurl"  placeholder="https://example.com" value=<?php 
														echo esc_url($formProperties['webhookurl']);
													?> >
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="pro_rate_cal_row">
									<div>
										<input type="submit" value="Save" class="rate_cal_button rate_cal_button_primary">
									</div>
								</div>   
						</form>	
						</div>
						<div id="tab_notification" class="pro_rate-cal_tabcontent" style="display:none;">
							<div class="pro_rate-cal_notification_form">
								<form method="post" action="<?php echo esc_url(self::get_admin_main_page_url(array("submenu" => "form_custom","id" => $form->ID,"tab" => 'NotificationTab'))); ?>" >
									<input type="hidden" name="page_action" value="<?php echo esc_html($NotifiFormProperties['page_action']);?>">
									<div class="pro_rate_cal_form_fields" id="">
										<label><?php esc_html_e("Admin Email", "project-cost-calculator"); ?></label>
										<input name="notifi_admin_email" type="email" placeholder="Enter Admin Email" required="true" class="simple_input_setting_field" value="<?php echo esc_attr($NotifiFormProperties['notifi_admin_email']); ?>" multiple>
									</div>	
									<div class="pro_rate_cal_form_fields" id="">
										<label><?php esc_html_e("Subject", "project-cost-calculator"); ?></label>
										<input name="notifi_subject" type="text" placeholder="Enter Subject" required="true" class="simple_input_setting_field" value="<?php echo esc_attr($NotifiFormProperties['notifi_subject']); ?>">
									</div>
									<div class="pro_rate_cal_form_fields" id="">
										<label><?php esc_html_e("Email Template", "project-cost-calculator"); ?></label>
										<div class="pro_rate_cal_keyword_row">
											<?php 
												foreach ( $form_field->get_form_fields() as $key => $value) {
													if( $value['enabled'] == true ){
														?>
														<span class="rate_cal_tooltip pro_rate_cal_keyword_generate" style="cursor: copy;">
															<span class="rate_cal_tooltiptext" id="myTooltip"><?php esc_html_e("Copy ","project-cost-calculator"); echo esc_html("{{$key}}"); ?></span>
															<p class='pro_rate_cal_tooltip-label'>
																	<?php echo esc_html("{{".$key."}}"); ?>
															</p>
														</span>
														<?php
													}
												}
											?>
										</div>
										<?php wp_editor( $NotifiFormProperties['notifi_email_template'] , "notifi_email_template", array("textarea_rows" => 7, 'tinymce' => true,) ); ?>
									</div>
									<div>
										<input type="submit" value="Save" class="rate_cal_button rate_cal_button_primary">
									</div>
								</form>										
							</div>
							</div>
						</div>
					</div>
					<!-- tab End -->
				</div>
			</div>             
				<?php
			}else{
				?><div class="pro_rate_cal_die_mesage"><?php _e("Sorry, Requested Form are invalid.", "project-cost-calculator"); ?></div><?php
			}
		}
	?>
    </div>
<script>							
	//notification tab open for submit notification form
	<?php
		if( isset($_REQUEST['tab'])){
			if( sanitize_text_field( $_REQUEST['tab'] )  =='NotificationTab' ){
				?>
					jQuery( document ).ready(function() {
						setTimeout(function() { document.getElementById("notification-tab").click();},10);
					});
				
			<?php
			}
		}
	?>
</script>