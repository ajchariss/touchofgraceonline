<?php
    $temp = null;
    $rowspan = 0;
    $category_column = $this->category_column($this->sort_array_by_order());
    $count = $this->sort_array_by_order();
    $array_c = count($count);
    $final_array = [];
    $cate_id = []; 
    // this loop in all category  post
    foreach ($count as $count_cate ) {
        $cate_id[] = $count_cate['settings']['category_field'];
    } 
    $cate_id =  array_unique($cate_id);
    // This loop in all category  post END
    // category new array create
    foreach ($cate_id as $count_new ) {
            $push_array = [];
            for($x = 0; $x < $array_c; $x++  ){
                if($count_new == $count[$x]['settings']['category_field']){
                    $push_array[] = $count[$x];
                } 
            }
            $final_array[] = $push_array;
    }
    ?>
    <div class="pro_rate_cale_tab_view">
        <div class="pro_rate_cale_tab_view_container">
            <div class="pro_rate_cale_tab_view_row pro_rate-cal_row">
                 <div class="pro_rate-cal_tab_left-col">   
                    <ul class="pro_rate_tabs">
                        <?php
                        // list of categoary
                        $tb = 1;
                        foreach($final_array as $value_top){
                                if(count($value_top) > 1){
                                            $j = 1;
                                            foreach($value_top as $value){
                                                if($j == 1){ 
                                                $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                                ?>
                                                <li class="pro_rate-cal_tab <?php if($tb == 1){ echo esc_html('pro_rate_tab_active'); } ?> " rel="pro_rate_tab<?php echo esc_html($tb);?>" >
                                                        <?php
                                                            if(!empty( $name ) ) {
                                                                printf( "<span>%s</span>", $name['name']);
                                                            }
                                                        ?>
                                                </li>
                                                <?php  }
                                                $j++;
                                                } 
                                } else { 
                                    $j = 1; 
                                        foreach($value_top as $value){ 
                                        if($j == 1){ 
                                            $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                            ?>
                                            <li class="pro_rate-cal_tab <?php if($tb == 1){echo esc_html('pro_rate_tab_active'); } ?> " rel="pro_rate_tab<?php echo esc_html($tb);?>">
                                                <?php
                                                    if(!empty( $name )) {
                                                        printf( "<span>%s</span>", $name['name']);
                                                    }
                                                ?>
                                            </li>
                                            <?php  
                                        } 
                                        $j++; 
                                    }
                                } 
                                $tb++;
                        } 
                        // list of categoary End
                        ?>
                    </ul>
                </div>
                <div class="pro_rate-cal_tab_center-col">
                    <div class="pro_rate_tab_container">
                        <?php
                        $tbc = 1;
                        foreach($final_array as $value_top){
                        // mobile view tab title
                            $j = 1;
                            ?>
                                <?php
                                foreach($value_top as $value){
                                    if($j == 1){ 
                                        $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                    ?>
                                        <h3 class="pro_rate_tab_drawer_heading <?php if($tbc == 1){echo esc_html('pro_rate_tab_d_active'); } ?> " rel="pro_rate_tab<?php  echo esc_html($tbc);?>">
                                            <?php
                                                if(!empty( $name ) ) {
                                                    printf( '<a href="%s">%s</a>', 'javscript:void(0)',$name['name']);
                                                }
                                            ?>
                                        </h3>
                                    <?php  }
                                    $j++;
                                } 
                            // Mobile view tab title End
                            // render field
                                ?>
                                <div id="pro_rate_tab<?php  echo esc_html($tbc);?>" class="pro_rate_tab_content">
                                    <table class="pro_rate-cal_step_table">
                                            <tbody>
                                                <?php  
                                                foreach($value_top as $value){ ?>
                                                    <tr class="pro_rate_cal_front_field" id="<?php echo esc_html($value['element_id']); ?>"> 
                                                        <?php  echo $this->render_field( $value );  ?>
                                                    </tr> 
                                                <?php 
                                                } 
                                                ?>
                                            </tbody>
                                    </table>
                                </div> 
                    
                        <?php
                        $tbc++;
                        // render field
                        }
                        ?>
                    </div> 
                </div>
                <div class="pro_rate-cal_tab_center-col">   
                    <div class="pro_rate-cal_total_summary_block">  
                        <h3> <?php  esc_html_e("Total Summary","project-cost-calculator"); ?></h3> 
                        <?php
                        // pricing before hooks
                        do_action('pro_rate_cal_tab_pricing_before', $this);
                        ?>
                        <table class="pricing_table">
                                                        
                        </table>
                        <?php
                        // pricing after hooks
                        do_action('pro_rate_cal_tab_pricing_after', $this);
                        ?>
                        <input type="submit" style="display:none;" value=" <?php esc_html_e( "view pricing","project-cost-calculator" ); ?>" class="rate_cal_button  tab_view_tigger_event rate_cal_button_primary">
                    </div>
                </div>
            </div>
        </div>
    </div>
  