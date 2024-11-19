<div class="pro_rate_cal_main_section">
<?php
require_once plugin_dir_path( __FILE__ ) . '/header/header.php';
$submenu = isset( $_REQUEST["submenu"] ) && !empty( sanitize_text_field( $_REQUEST["submenu"] ) )  ? sanitize_text_field( $_REQUEST["submenu"] ) : null ;
$action = isset( $_REQUEST["action"] ) && !empty( sanitize_text_field( $_REQUEST["action"] ) ) ? sanitize_text_field( $_REQUEST["action"] ) : null ;
$requestpage = isset( $_REQUEST["page"] ) && !empty( sanitize_text_field( $_REQUEST["page"] ) ) ? sanitize_text_field( $_REQUEST["page"] ) : null ;
/* Main Container class */
//Set Class For Edit page and submenu layout
$class = " ";
if( $action == "edit" ||  $submenu == "layout"  ||  $submenu == "form_custom"  || $submenu == "form_entries" || $submenu == "quotation_settings" || $submenu == "currency_settings" ){
    $class = "pro_rate-cal_container-fluid ";
} else {
    $class = "pro_rate-cal_container ";
}
?>
<div class="<?php echo  esc_attr($class); ?>">
    <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
    <div class="pro_rate-cal_row_main" id="pro_rate_cal_admin">
        <?php
            //if action is edit page will jump to new edit form or update
            if( $action == "edit" ){
                if ( $action == "edit" ) {
                ?>
                    <div class="pro_rate_cal-sidebar-div">
                        <?php require_once plugin_dir_path( __FILE__ ) . 'sidebar/sidebar.php'; ?>
                        <div class="calculator-sidebar-banner-img"> 
                            <a href="https://unlimitedwp.com/contact/" target="_blank"><img src="<?php echo esc_url(PRC_ADMIN_IMAGE_PATH_URL.'plugin-banner-vertical.jpg');?>"/></a>
                        </div> 
                    </div>
                    <?php
                    require_once plugin_dir_path( __FILE__ ) . "/actions/edit.php";
                } else {
                    ?>  
                    <div class="pro_rate_cal-main-right-content">
                        <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
                        <?php 
                            $page = !empty( $submenu ) ? $submenu : "calculator-lists" ; 
                            $menus = array("calculator-lists");
                            if( in_array( $page, $menus ) ){ } else {
                                $page = "calculator-lists";
                            }
                            require_once plugin_dir_path( __FILE__ ) . "containers/$page.php";
                        ?>
                        <div id="pro_rate_cal_loader_container"><div id="pro_rate_cal_loader"></div></div>
                    </div>
                    <?php
                }
            // Check for submenus and current page request
            } else if (  ( $requestpage == "rate_calculator_main" ) && ( ( $submenu == "layout" ) || ( $submenu == "form_custom" ) || ( $submenu == "form_entries" )  || ( $submenu == "quotation_settings" )  ) ){
                ?>
                    <div class="pro_rate_cal-sidebar-div">
                            <?php require_once plugin_dir_path( __FILE__ ) . 'sidebar/sidebar.php'; ?>
                    </div>     
                <?php
                require_once plugin_dir_path( __FILE__ ) . "containers/".$submenu.".php";   
            // if above condition is not setisfy then page will jump to calculator list
            } else {
            ?>
            <div class="pro_rate_cal-main-right-content">
                <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
                <?php 
                    $page = !empty( $submenu ) ? $submenu : "calculator-lists" ; 
                    $menus = array("calculator-lists");
                    if( in_array( $page, $menus ) ){ } else {
                        $page = "calculator-lists";
                    }
                    require_once plugin_dir_path( __FILE__ ) . "containers/$page.php";
                ?>
            </div>
            <?php
                }
            ?>
    </div>
</div>
<div class="pro_rate_cal_loader_backdrop ">
    <div class="pro_rate_cal_loader"></div>
</div>
<!--Demo  Model Start -->
<div class="pro_rate_cal_model">
    <div class="pro_rate_cal_model_model_contain">
        <div class="pro_rate_cal_model_header">
            <h2></h2>
            <div class="pro_rate_cal_model_icon_close">
                x
            </div>  
        </div>      
        <div class="pro_rate_cal_model_model_body">
        </div>     
    </div>        
</div>    
<!--Demo  Model End -->
</div>