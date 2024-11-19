<div id="pro_rate_cal-store-main" class="pro_rate_cal_heading">
	<div class="pro_rate-cal_box">
		<div class="pro_rate-cal_logo">
      <a href="<?php echo esc_url( self::get_admin_main_page_url());?>">
         <img src="<?php echo esc_url(PRC_ADMIN_IMAGE_PATH_URL.'logo-main.png');?>">
      </a>
		</div>
    <?php 
    $requestpage = isset( $_REQUEST['page'] ) && !empty( sanitize_text_field ( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : null;
    $action = isset( $_REQUEST['action'] ) && !empty( sanitize_text_field ( $_REQUEST['action'] ) ) ? sanitize_text_field( $_REQUEST['action'] ) : null;
    $requestpageid = isset( $_REQUEST['id'] ) && !empty( sanitize_text_field ( $_REQUEST['id'] ) ) ? sanitize_text_field( $_REQUEST['id'] ) : null;
    ?>
    <?php  if( $requestpage == 'rate_calculator_main' || $requestpage == 'rate_calculator_how_to_use' ){ ?>
       <div class="pro_rate-cal_header_menu">
        <?php  if( $requestpage != 'rate_calculator_how_to_use' ){  ?>
          <a href="<?php echo esc_url(admin_url( 'admin.php?page=rate_calculator_how_to_use'));?>" class="rate_cal_button rate_cal_button_primary how-to-use-btn"> <?php esc_html_e("How to use?", "project-cost-calculator" ); ?> </a>
        <?php } ?>
          <!-- mobile view show in toggle menu  -->
          <ul>
            <?php if( ( $requestpage == 'rate_calculator_main' &&  $action == 'edit' ) ){?>
            <li><a href="#" class="rate_cal_add_element rate_cal_button rate_cal_button_primary" title="<?php esc_attr_e("Add Element", "project-cost-calculator" ); ?>" ><?php esc_html_e("Add Element", "project-cost-calculator" ); ?></a></li>
            <?php } ?>
            <?php if( $requestpage == 'rate_calculator_main' && $action == 'edit'  || !empty( $requestpageid ) ){?>
              <li><span class="pro_rate-cal_mobile_menu_toggle"><svg xmlns="http://www.w3.org/2000/svg" width="36.511" height="26.332" viewBox="0 0 36.511 26.332"><g transform="translate(-1441.23 -17.728)"><text transform="translate(1454.741 24.728)" fill="#051d53" font-size="7.106" font-family="Montserrat-Medium, Montserrat" font-weight="500"><tspan x="0" y="0">MENU</tspan></text><rect width="10.66" height="2.13" transform="translate(1441.23 21.32)" fill="#06205c"/><rect width="35.53" height="2.13" transform="translate(1441.23 41.93)" fill="#06205c"/><rect width="35.53" height="2.13" transform="translate(1441.23 31.27)" fill="#06205c"/></g></svg></span></li>
            <?php } ?>
            <?php
              if(  $requestpage == 'rate_calculator_how_to_use' ){?>
                <li><a href="<?php echo esc_url(self::get_admin_main_page_url()); ?>" class="rate_cal_add_element rate_cal_button rate_cal_button_primary" title="<?php esc_attr_e("All Calculators", "project-cost-calculator" ); ?>" ><?php esc_html_e("All Calculators", "project-cost-calculator" ); ?></a></li>
              <?php } 
            ?>
          </ul>	
          <!-- mobile view show in toggle menu  -->
        </div>
    <?php } ?>
    <!-- mobile view show in toggle menu  -->
	</div>
</div>	
<div class="pro_rate-cal_screen_overlay"></div>