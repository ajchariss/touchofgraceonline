<div class="pro_rate_cal_shortcode_main">
    <?php 
        $field_settings = new PRC_FormField( $this->form_id );
    ?>
    <!-- Custom Post Title -->
    <?php 
    if( $this->isFormNameShowState ){
        // add action form title before hooks 
        do_action('pro_rate_cal_form_before_title', $this);
        ?>
            <div class="pro_rate-cal_step_card_header">
                <?php
                    printf("<h4>%s</h4>", get_the_title( $this->form_id ) );
                ?>
            </div>
        <?php
        // add action form title after hooks 
        do_action('pro_rate_cal_form_after_title', $this);
    }

    // add action form before hooks 
    do_action('pro_rate_cal_form_before',$this);
    ?>
    <!-- Custom Post Title End-->
    <form action="" id="<?php echo esc_attr($this->current_form_id); ?>" form="<?php echo esc_attr($this->form_id); ?>" class="">
            <div class="table_data">
                    <?php
                    $formSettings = new PRC_FormLayout( $this->form_id );
                    $quotationSettings = new PRC_FormQuotation( $this->form_id ); 
                    $layout  = $formSettings->get_layout_type();
                    if( !empty( $this->sort_array_by_order() ) ):
                        if( $layout == "step-view" ) {
                            include_once PRC_TEMPLATE_DIR.'/view/step-view-template.php';
                        }else if ($layout == "tab-view" ){
                            include_once PRC_TEMPLATE_DIR.'/view/tab-view-template.php';
                        }else{
                            include_once PRC_TEMPLATE_DIR.'/view/classic-view-template.php';
                        }
                    endif;
                    ?>
            </div> 

            <?php
            /**
             * For Quoatation
             */
            $userQuote = $quotationSettings->get_properties( "send_quot_to_user" );
            if( !empty( $userQuote ) && $userQuote == "active" ){
                do_action("pro_rate_cal_quotation_form_before", $this);
                ?>
                    <div class="pro_rate_cal_qoute_form" style="display:none;">
                        <div class="pro_rate_cal_qoute_show_btn">
                            <input type="button" class="rate_cal_button rate_cal_button_primary show_quote_form" value="<?php echo !empty( $quotationSettings->get_properties( "open_form_quotation_btn_text" ) ) ? esc_attr($quotationSettings->get_properties( "open_form_quotation_btn_text" )) : esc_attr( "Send Quotation") ; ?>"  />
                        </div>
                        <div class="pro_rate_cal_user_mail_content">
                                <?php echo esc_html($quotationSettings->get_properties( "quatation_message" )); ?>
                        </div>
                        <div class="pro_rate_cal_user_quote_form" style="display:none;" >
                            <div class="pro_rate_cal_user_quote_form_input_group">
                                <input type="email" name="proratecal_user_mail" placeholder="Enter email" /> 
                                <input type="button" name="pro_rate_cal_send_qout_to_user" class="rate_cal_button rate_cal_button_primary show_quote_form pro_rate_cal_send_qout_to_user" value="<?php echo !empty( $quotationSettings->get_properties( "send_quotation_btn_text" ) ) ? esc_attr($quotationSettings->get_properties( "send_quotation_btn_text" )) : esc_attr("Send" ); ?>" />
                                <div class="pro_rate_cal_quot_message"></div>
                            </div>
                        </div>
                    </div>
                <?php
                do_action("pro_rate_cal_quotation_form_after", $this );
            }
            ?>
    </form>
    <?php 
        // add action form after hooks 
        do_action('pro_rate_cal_form_after',$this);
        $custom_css = $formSettings->get_css();
        if( !empty( $custom_css) ){
        ?>
            <style>
                <?php echo esc_html( $custom_css ); ?>
            </style>
        <?php 
         }
    ?>
    <script>
        var form<?php echo esc_html("_".$this->current_form_id); ?> = new ProRateCalFormFront( "<?php echo esc_html($this->current_form_id); ?>", <?php echo wp_kses_data(json_encode($this->get_label_and_field_name())); ?>, <?php echo wp_kses_data(json_encode($this->get_rate_of_field())); ?>, <?php echo wp_kses_data(json_encode($this->form_properties));  ?> );
    
        <?php
    	$layout_inner = $formSettings->get_design_type();
        if( $layout_inner  == "fancy-view" ){
            $classes = "fancy-layout";
        } else{
            $classes = "default-layout";
        }
        if( $layout == "step-view" ) {
            $classe = "pro_rate_cal_body_step_view";
        }else if ($layout == "tab-view" ){
            $classe = "pro_rate_cal_body_tab_view";
        }else{
            $classe = "pro_rate_cal_body_classic_view";
        }

        ?>
        jQuery('body').addClass('<?php echo esc_html($classe);?>');
        jQuery('body').addClass('<?php echo esc_html($classes);?>');

        <?php 
        $sendQuote = $quotationSettings->get_properties( "quatation_notification" );
        if( !empty( $sendQuote ) && $sendQuote == "active" ){
            ?>form<?php echo esc_html("_".$this->current_form_id); ?>.isSendQuote(true);<?php
        }

        $userQuote = $quotationSettings->get_properties( "send_quot_to_user" );
        if( !empty( $userQuote ) && $userQuote == "active" ){
            ?>form<?php echo esc_html("_".$this->current_form_id); ?>.isSendQuoteToUser(true);<?php
        }

        if( trim($layout) == "classic-view"){
            ?>form<?php echo esc_html("_".$this->current_form_id); ?>.autoUpdateResult(false);<?php
        }
        ?>

    </script>  
    <?php
    $custom_form = $this->get_custom_form();
    $setFormState = $custom_form ->getFormState();
    $introduction = $custom_form -> get_intro_paragraph();
    $form_fields = $custom_form -> get_form_fields();
    $submitbtn = $custom_form -> get_form_submit_btn();
    $valeditonary_text = $custom_form -> get_form_valeditonary_text();
    $form_title = $custom_form -> get_form_name();
    $form_submittion_id = $this->current_form_id."_submittion";
    $timeout = $custom_form->get_form_timeout();
    printf('<script>var ProRateCalFormtimeout = %s; </script>',$timeout);
    //check cookie set or not
    $isCookieNotSet = true;
    if( isset( $_COOKIE['pro_rate_cal_form_id_'.$this->get_form_id()] ) && $_COOKIE['pro_rate_cal_form_id_'.$this->get_form_id()] == "true" ){
        $isCookieNotSet = false;
    }
    if( $this->form_state == "activated" && $isCookieNotSet ){
        ?>
        <div class="pro_cale_sticky_form_overly"></div>
            <div class="sticky_form" >
                <div class="sticky_form_container">
                <?php
                    echo !empty( $form_title ) ? "<h3>".esc_html($form_title)."</h3>" : null;
                if( !empty($introduction) ) {
                 ?>
                    <div class="pro_rate_cal_form_intro">
                        <?php echo wp_kses_post($introduction); ?> 
                    </div>
                <?php 
                } 

                if( count($form_fields) != 0 || !empty($form_fields) ){
                    // add action stickty form after hooks 
                    do_action('pro_rate_cal_sticky_form_before',$this);
                    ?> <form id="<?php echo esc_html($form_submittion_id); ?>">
                            <div class="pro_rate-cal_row ">
                                <?php
                                    $row_count = 0;
                                    foreach ($form_fields as $key => $value) {
                                        if( $value['enabled'] ){  
                                            $row_count ++;
                                        }
                                    }
                                    foreach ($form_fields as $key => $value) {
                                        if( $value['enabled'] ){   
                                            if( $key == "description" ){
                                                ?>
                                                    <div class="pro_rate-cal_col_12 pro_rate_cal_form_fields  pro_rate-cal_sticky_col_md_<?php echo esc_html($row_count);?>  <?php echo $value['required'] == 1 ? esc_html("pro_rate_cal_custom_fields_required") : null;  ?>">
                                                        <label for="<?php echo esc_html($key); ?>"><?php echo esc_html($value['label']); ?><?php echo $value['required'] == 1 ? wp_kses_post("<span class='pro_rate_cal_astric'>*</span>") : null;  ?></label>
                                                        <textarea name="<?php echo esc_html($key); ?>" 
                                                        data-validation="<?php echo esc_html($value['validation_message']); ?>" ></textarea>
                                                        <span class="pro_rate_cal_valdation" style="display:none;"><?php echo esc_html($value['validation_message']); ?></span>
                                                    </div>
                                                <?php        
                                            }else{
                                                ?>
                                                <div class="pro_rate-cal_col_12 pro_rate_cal_form_fields  pro_rate-cal_sticky_col_md_<?php echo esc_html($row_count);?>  <?php echo $value['required'] == 1 ? esc_html("pro_rate_cal_custom_fields_required") : null;  ?>">
                                                    <label for="<?php echo esc_html($key); ?>"><?php echo esc_html($value['label']); ?><?php echo $value['required'] == 1 ? wp_kses_post("<span class='pro_rate_cal_astric'>*</span>") : null;  ?></label>
                                                    <input type="text" name="<?php echo esc_html($key); ?>" 
                                                    data-validation="<?php echo esc_html($value['validation_message']); ?>" >
                                                    <span class="pro_rate_cal_valdation" style="display:none;"><?php echo esc_html($value['validation_message']); ?></span>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?> 
                            </div>
                            <div class="pro_rate_cal_sticky_submit">
                                <input type="submit" value="<?php echo !empty($submitbtn) ? esc_attr($submitbtn) : esc_attr("Submit"); ?>" class="rate_cal_button rate_cal_button_primary">
                            </div>
                            <p class="pro_rate_cal_message"></p>
                            <p class="pro_rate_cal_form_validtionary_text"><?php echo wp_kses_post($valeditonary_text); ?></p>
                        </form> 
                <?php
                    // add action stickty form after hooks 
                    do_action('pro_rate_cal_sticky_form_after',$this);
                }

                ?>
                </div>
            </div>
            <script>
                new ProRateCalSubmmitionForm( <?php echo esc_html($this->get_form_id()); ?>, "<?php echo esc_html($form_submittion_id); ?>", "<?php echo esc_html($this->current_form_id); ?>" );
            </script>
        <?php
         }
    ?>  
         
</div>  
      