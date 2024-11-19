<?php 
    $disabled = ' pro_rate_cal_disabled';
    $form_id = null;
    if( isset( $_REQUEST["id"] ) && !empty( $_REQUEST["id"] ) && $this->form_exist( sanitize_text_field( $_REQUEST['id'] ) ) ){
        $disabled = '';
        $form_id = sanitize_text_field( $_REQUEST['id'] );
    }
    $requestedSubmenu = isset( $_REQUEST["submenu"] ) && !empty( sanitize_text_field( $_REQUEST['submenu'] ) ) ? sanitize_text_field( $_REQUEST['submenu'] ) : null;
    $requestedAction = isset( $_REQUEST["action"] ) && !empty( sanitize_text_field( $_REQUEST['action'] ) ) ? sanitize_text_field( $_REQUEST['action'] ) : null;
    $requestedPage = isset( $_REQUEST["page"] ) && !empty( sanitize_text_field( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : null;
?>
<div class="pro_rate_cal_admin_menu">
	<h4 class="menu-title"> <?php esc_html_e( "Calculator Menu", "project-cost-calculator" );  ?></h4>
    <span class="pro_rate_cal_menu_sidebar_close"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg></span>
	<ul class="pro_rate_cal_main_menu" id="pro_rate_cal_form_sidebar_menu">        
        <?php
            $form_custom = array();
            $layout = array();
            $quatation_settings = array();
            $form_custom['submenu'] = "form_custom";
            $layout['submenu'] = "layout";
            $form_entries['submenu'] = "form_entries";
            $form_settings['page'] = "rate_calculator_main";
            $quatation_settings['submenu'] = "quotation_settings";
         
    
            if( !empty( $form_id ) ){
                $form_custom['id'] = $form_id;
                $layout['id'] = $form_id;
                $form_entries['id'] = $form_id;
                $form_settings['id'] = $form_id;
                $quatation_settings['id'] = $form_id;
               
            }
        ?>
        <li class="pro_rat_cal_submenus <?php echo ( ( $requestedPage == "rate_calculator_main" ) && (  $requestedAction == "edit" )) ? esc_attr("active") : null; echo esc_attr($disabled); ?>"><a href="<?php echo esc_url(self::get_admin_main_page_url(array( "action" => "edit","id" => $form_id))); ?>" title="Edit Calculator" ><?php esc_html_e("Edit Calculator", "project-cost-calculator"); ?></a></li>   
        <li class="pro_rat_cal_submenus <?php echo $requestedSubmenu == "form_custom" ? esc_attr("active") : null; echo esc_attr($disabled); ?>"><a href="<?php echo esc_url(self::get_admin_main_page_url(  $form_custom) ); ?>" title="Form Settings" ><?php esc_html_e("Form", "project-cost-calculator"); ?></a></li>   
        <li class="pro_rat_cal_submenus <?php echo $requestedSubmenu == "form_entries" ? esc_attr("active") : null; echo esc_attr($disabled); ?>"><a href="<?php echo esc_url(self::get_admin_main_page_url( $form_entries )); ?>" title="Form Entries"><?php esc_html_e("Form Entries", "project-cost-calculator"); ?></a></li>   
        <li class="pro_rat_cal_submenus <?php echo $requestedSubmenu == "layout" ? esc_attr("active") : null; echo esc_attr($disabled); ?>" ><a href="<?php echo esc_url ( self::get_admin_main_page_url($layout) ); ?>" title="Form Layout Setting"><?php esc_html_e("Layout", "project-cost-calculator" ); ?></a></li>   
        <li class="pro_rat_cal_submenus <?php echo $requestedSubmenu == "quotation_settings" ? esc_attr("active") : null; echo esc_attr($disabled); ?>" ><a href="<?php echo esc_url(self::get_admin_main_page_url( $quatation_settings )); ?>" title="Quotation Settings"><?php esc_html_e("Quotation Settings", "project-cost-calculator" ); ?></a></li>
        <li class="pro_rat_cal_submenus how-to-use-link"><a href="<?php  echo esc_url(admin_url( 'admin.php?page=rate_calculator_how_to_use')); ?>" title="How to use?"><?php esc_html_e("How to use?", "project-cost-calculator"); ?></a></li>   
    </ul>	
</div>