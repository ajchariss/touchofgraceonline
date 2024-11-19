<div class="pro_rate-cal_card">
    <div class="pro_rate-cal_card_header">
        <?php printf( "<h4>%s</h4>", __("Calculators List","project-cost-calculator") ); ?>
        <a href="<?php 
            echo  esc_url( self::get_admin_main_page_url(
                array(
                    "action" => "edit",
                )
            ) ) ;
        ?>" 
        title = <?php esc_html_e( "Create New Calculator Form", "project-cost-calculator" ); ?> 
        class="rate_cal_button rate_cal_button_primary"><?php esc_html_e( "Add New" , "project-cost-calculator" ); ?></a>
    </div> 
    <div class="pro_rate-cal_card-body">   
        <div class="pro_rate_cal_lists">
            <div class="pro_rate_cal_pagination_action_header"></div>
            <div class="pro_rate_cal_lists">
                <table id="pro_rate_cal_list_table">
                    <thead>
                        <tr>
                            <?php 
                                printf( "<th>%s</th>", __("#","project-cost-calculator") );
                                printf( "<th>%s</th>", __("Title","project-cost-calculator") );
                                printf( "<th>%s</th>", __("Short Code","project-cost-calculator") );
                                printf( "<th>%s</th>", __("Action","project-cost-calculator") );
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            self::get_form_lists();
                        ?>  
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="calculator-list-banner-img"> 
        <a href="https://unlimitedwp.com/contact/" target="_blank"><img src="<?php echo esc_url(PRC_ADMIN_IMAGE_PATH_URL.'plugin-banner.jpg');?>"></a>
    </div>   
</div> 