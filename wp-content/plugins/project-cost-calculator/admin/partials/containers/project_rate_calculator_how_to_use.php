<div class="pro_rate_cal_main_section">
    <?php
    $submenu = isset( $_REQUEST["submenu"] ) && !empty( sanitize_text_field( $_REQUEST["submenu"] ) )  ? sanitize_text_field( $_REQUEST["submenu"] ) : null ;
    $action = isset( $_REQUEST["action"] ) && !empty( sanitize_text_field( $_REQUEST["action"] ) ) ? sanitize_text_field( $_REQUEST["action"] ) : null ;
    $requestpage = isset( $_REQUEST["page"] ) && !empty( sanitize_text_field( $_REQUEST["page"] ) ) ? sanitize_text_field( $_REQUEST["page"] ) : null ;
    $class = " ";
    if( $action == "edit" ||  $submenu == "layout"  ||  $submenu == "form_custom"  || $submenu == "form_entries" ){
        $class = "pro_rate-cal_container-fluid ";
    } else {
        $class = "pro_rate-cal_container ";
    }
    ?>
    <div class="<?php echo esc_attr($class); ?>">
        <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
        <div class="pro_rate-cal_row_main" id="pro_rate_cal_admin">
            <div class="pro_rate_cal-main-right-content">
                <div id="pro_rate_cal_message" class="pro_rate_cal_message_container"></div>
                    <div class="pro_rate-cal_card">
                    <div class="pro_rate-cal_card_header">
                        <h4><?php printf('%s',  __("How To Use?", "project-cost-calculator")); ?></h4>
                    </div> 
                    <div class="pro_rate-cal_card-body how-to-use-content">   
                        <ol>
                            <?php printf('<li>%s <b>"%s" </b> %s</li>',__("Find", "project-cost-calculator"),__("Cost Calculator", "project-cost-calculator"), __("from the left side menu.","project-cost-calculator")); ?>
                            <?php printf('<li>%s <b>"%s"</b> %s. <ul><li>%s</li><li>%s <b>"%s"</b> %s</li><li>%s</li></ul></li>',
                            __("Go to", "project-cost-calculator"),
                            __("Calculator", "project-cost-calculator"),
                            __("where you will see a list of calculators you have created", "project-cost-calculator"),
                            __("Select any calculator from the list to edit the calculator or see form entries","project-cost-calculator"),
                            __("Click on","project-cost-calculator"),
                            __("Add New","project-cost-calculator"),
                            __("to create a new calculator","project-cost-calculator"),
                            __("Copy shortcode of any calculator you like to use on-page. Paste shortcode on any page to bring a calculator on that page.","project-cost-calculator")); ?>
                            <?php printf('<li>%s</li>', __("Once you create a new calculator the parent category will be created automatically. The parent category will be the same as the calculator name. If a calculator name is updated the parent category name will also be updated.") );?>
                            <?php printf('<li>%s <b>"%s"</b> %s <ul> <li>%s</li> <li>%s</li> <li> %s</li> </ul> </li>',
                            __("Click on", "project-cost-calculator"),
                            __("Category", "project-cost-calculator"),
                            __("and create any category you would require while creating cost calculators.", "project-cost-calculator"),
                            __("That will act as the child category.","project-cost-calculator"),
                            __("They will be unique for all the calculators.","project-cost-calculator"),
                            __("If a calculator is deleted, the parent and child will be deleted automatically.","project-cost-calculator")); ?>
                            <?php printf(' <li>%s<ul><li>%s <b>"%s"</b>.</li> <li>%s</li></ul></li>',
                            __("Build Calculator", "project-cost-calculator"),
                            __("Click on", "project-cost-calculator"),
                            __("Add New", "project-cost-calculator"),
                            __("Add the name of the calculator and apply that name to enable the calculator.","project-cost-calculator")); ?>
                            <?php printf(' <li>%s</li>',
                            __("There are six types of fields that can be used to build the calculator.","project-cost-calculator")); ?>
                            <?php printf(' <li>%s <b>“%s”</b> %s</li>',
                            __("You can enable the lead generation form from the calculator sub-menu. You can review the form entries from the ","project-cost-calculator"),
                            __("Form entry","project-cost-calculator"),
                            __("sub-menu option.","project-cost-calculator")); ?>
                            <?php printf(' <li>%s</li>',
                            __("For the lead generation form, you can select the needed form fields from the given five form fields. Everything from the introduction paragraph to the button text can be added as per your requirement.","project-cost-calculator")); ?>
                            <?php printf('<li> %s<b> “%s”</b>%s</li>',
                            __("Along with that, there is a feature of","project-cost-calculator"),
                            __("Quotation","project-cost-calculator"),
                            __(". By enabling this the user and admin both will get the quotation via email. ","project-cost-calculator")); ?>
                            <?php printf(' <li>%s</li>',
                            __("There are three different layout options classic (basic table view), step-layout and tab layout(with dynamic summary). Each layout has two looks classic and modern.","project-cost-calculator")); ?>
                            <?php printf(' <li>%s <a href="mailto:hello@unlimitedwp.com">hello@unlimitedwp.com</a></li>',
                            __("For support reach out at","project-cost-calculator") ); ?>
                        </ol>    
                    </div>
                    <div class="calculator-list-banner-img"> 
                        <a href="https://unlimitedwp.com/contact/" target="_blank"><img src="<?php echo esc_url(PRC_ADMIN_IMAGE_PATH_URL.'plugin-banner.jpg');?>"></a>
                    </div>  
                </div> 
            </div>       
        </div>
    </div>
</div>