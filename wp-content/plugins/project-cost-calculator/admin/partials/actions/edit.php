<?php 
    $RequestID = null;
    $RequestID = isset( $_REQUEST["id"] ) && !empty( sanitize_text_field( $_REQUEST["id"] ) ) ? sanitize_text_field( $_REQUEST["id"] ) : null;
    if( $RequestID == null ){
        $builderShowState = false;
    }else{
        $builderShowState = true;
    }
?>
<script>
    var project_rate_calculator_edit = <?php 
            if( $RequestID != NULL ){
                if( $this->get_calculator_properties( $RequestID ) ){
                    echo wp_kses_data(wp_json_encode( $this->get_calculator_properties( $RequestID ) )) ;
                }else{
                    echo esc_html( "{}" );
                }
            }else{
					echo esc_html( "{}" );
			} ?>
</script>
<div class="pro_rate_cal-main-right-content">
    <div class="pro_rate_cal_edit_main">
        <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
        <div class="pro_rate_cal_action_bar">
            <div class="pro_rate_cal_action_bar_heading_btn">
            <?php
                if( !empty( $RequestID ) ){
                    if( get_post( $RequestID ) ){
                        printf("<h4>%s</h4>" , __("Edit Calculator","project-cost-calculator") );
                        $builderShowState = true;
                    } else {
                        printf("<h4>%s</h4>" , __("Create New Calculator","project-cost-calculator") );
                    }
                } else {
                    printf("<h4>%s</h4>" , __("Create New Calculator","project-cost-calculator") );
                }
            ?>
            </div>
            <a class="rate_cal_button rate_cal_button_primary" href="<?php echo  esc_url(self::get_admin_main_page_url()); ?>" title="Calculator Form Lists"> <?php esc_html_e("All calculators ","project-cost-calculator"); ?></a>
        </div>
        <div class="pro_rate_cal_edit_form">
            <div class="pro_rate_cal_edit_form_module">
                <div class="pro_rate_cal_left_list_bar">
                    <form class="pro_rate_cal_new_form" id="pro_rate_cal_new_form" method="POST" action="pro_rate_cal_submit_calculator">
                        <div class="pro_rate_cal_form_name-save_shortcode">
                            <div class="pro_rate_cal_form_name-save">
                                <label for="form_name"><?php esc_html_e("Calculator title: ","project-cost-calculator"); ?></label>
                                <div class="pro_rate_cal_form_name-save_input">
                                    <div class="pro_rate_cal_form_input_error">
                                        <input type="text" name="form_name" value="<?php
                                            if( !empty( $RequestID ) ){
                                                echo  esc_attr( get_the_title( $RequestID ) );
                                            }

                                        ?>" placeholder="Calculator Name">
                                    </div>
                                    <input type="submit" class="rate_cal_button rate_cal_button_primary" value="<?php esc_attr_e( "Apply" , "project-cost-calculator" ); ?>" >
                                </div>
                            </div>
                            <div class="pro_rate_cal_new_form_field">
                                <span id="pro_rate_cal_shortcode_generate" class="tooltip rate_cal_tooltip" style="cursor: copy;">
                                    <span class="rate_cal_tooltiptext" id="myTooltip"><?php esc_html_e("Copy shortcode","project-cost-calculator"); ?></span>
                                    <p class="pro_rate_cal_tooltip-label"><?php 
                                        if( !empty( $RequestID ) ) :
                                            echo esc_html( self::get_form_shortcode(  $RequestID ) );
                                        endif;
                                    ?></p>
                                </span>
                            </div>
                        </div>
                        <div id="pro_rate_cal_builder" class="pro_rate_cal_builder border <?php  
                            if(!$builderShowState){
                                echo esc_attr("pro_rate_cal_disabled-section");
                            }
                        ?>" >
                            <div class="pro_rate_cal_table_responsive">
                                <table class="pro_rate_cal_builder_table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php esc_html_e( "Field Name", "project-cost-calculator" ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( "Category", "project-cost-calculator" ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( "Rate", "project-cost-calculator" ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( "Default Quantity", "project-cost-calculator" ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( "Tooltip", "project-cost-calculator" ); ?>
                                            </th>
                                            <th>
                                                <?php esc_html_e( "Action", "project-cost-calculator" ); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="pro_rate_cal_builder_fields">
                                    </tbody>
                                </table>
                            </div>
                                
                        </div>
                        <div class="pro_rate_cal_footer_form_actions_container" id="pro_rate_cal_action_new_form <?php 
                            if(!$builderShowState ){
                                echo esc_attr("pro_rate_cal_disabled-section");
                            }
                        ?>">
                            <?php wp_nonce_field(); ?>
                            <input type="hidden" name="json_values"value=''>
                            <input type="hidden" name="form_id" value="<?php
                                if( !empty( $RequestID ) ){
                                     if( $form = $this->get_form( $RequestID ) ){
                                        echo esc_attr($form->ID);
                                     }
                                }
                            ?>" >
                            <div class="pro_rate_cal_new_form_field <?php  
                            if(!$builderShowState){
                                echo esc_attr("pro_rate_cal_disabled-section");
                            }
                            ?>">
                                <input type="submit" title="<?php esc_html_e( "Save Form", "project-cost-calculator" ); ?>" class="rate_cal_button rate_cal_button_primary" name="submit_form" value="<?php esc_html_e("Save","project-cost-calculator"); ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pro_rate_cal_fields_module">
            </div>
        </div>
    </div>
</div>
<div class="pro_rate_cal_right_list_bar <?php
if(!$builderShowState){
    echo esc_attr("pro_rate_cal_disabled-section");
}
?>">
    <div class="pro_rate_cal_module_elements_box">
        <h4><?php esc_html_e("Elements","project-cost-calculator"); ?></h4>
        <em><?php esc_html_e("Click to enter new item","project-cost-calculator"); ?></em>
        <span class="pro_rate_cal_module_elements_close"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg></span>
        <div class="pro_rate_cal_module_elements">
                <?php $this->render_module_elements(); ?>
        </div>
    </div>
</div>
<script>
window.onload = (event) => {
    proRatCalBuilder.generateBuilder();
    <?php if( !$builderShowState ){ ?>
        proRateCalFormNameSaveState = false;
    <?php }else{ ?>
        proRateCalFormNameSaveState = true;
    <?php } ?>
};
</script>
