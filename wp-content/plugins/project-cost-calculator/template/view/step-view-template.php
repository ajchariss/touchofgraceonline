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
    // category new array create
    $step = count($final_array);
    $step_data = $step + 1;
    $a = 1;
    // step view loop start
    // step view  top category added 
    ?>
    <div class="pro_step_tabs_section ">
         <div class="pro_rate_cal_custom_pagination " data-count="4">
            <div class="pro_rate_cate_listing_outer">
                <ul class="pro_rate_cal_item-listing pro_step_tabs_part">
                <?php
                    $tb = 0;
                    foreach($final_array as $value_top){
                    if(count($value_top) > 1){
                     $j = 1;
                            foreach($value_top as $value){
                                if($j == 1){ 
                                $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                ?>
                                <li data-array="<?php echo esc_html($tb); ?>"  data-cat="<?php echo esc_html($name['name']); ?>"class=" pro_rate_cal_item-single pro_step_tabs <?php if($tb == 0){ echo esc_html('active'); }?>">
                                        <?php
                                            if(!empty( $name ) ) {
                                                printf( "<p>%s</p>", $name['name']);
                                            }
                                        ?>
                                </li>
                                <?php 
                                 }
                                $j++;
                            } 
                    } else { 
                        $j = 1; 
                        foreach($value_top as $value){ 
                            if($j == 1){ 
                                $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                ?>
                                <li data-array="<?php echo esc_html($tb); ?>" data-cat="<?php echo esc_html($name['name']); ?>" class="pro_rate_cal_item-single pro_step_tabs <?php if($tb == 0){ echo esc_html('active'); }?> " >
                                    <?php
                                        if(!empty( $name )) {
                                            printf( "<p>%s</p>", $name['name']);

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
            <div class="pro_rate_cal_item-pagination">
                <span class="page-count"></span>
                    <ul class="">
                        <li class="pro_rate_cal_prev"><a href="javaScript:void(0)" id="prevDealSlide"><span>...</span></a><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#CED4DA"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg></li>
                        <li class="pro_rate_cal_next"><a href="javaScript:void(0)" id="nextDealSlide"><span>...</span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#CED4DA"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg></a></li>
                    </ul>
            </div>
        </div> 
    </div>
<?php
    foreach($final_array as $value_top){
        $rowspan = count($value_top);
            if(count($value_top) > 1){
                ?>
                <div class="pro_rate_cal_step_main" style="<?php  if( $a == 1){ echo esc_html('display:block;'); }else { echo esc_html('display:none;');} ?> ">
                    <div class="pro_rate-cal_step_card">
                         <?php  
                        $j = 1;
                        // step view title section
                        foreach($value_top as $value){
                            if($j == 1){ 
                                $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                             ?>
                                    <input type="hidden" class="cate_name" value="<?php  echo esc_html($name['name']);  ?>">
                            <?php  
                            }
                            $j++;
                            } 
                        // step view title section END
                        ?>
                        <!-- step view table part -->
                         <div class="pro_rate-cal_step_card-body">
                            <table class="pro_rate-cal_step_table">
                                    <tbody>
                                        <?php  $i = 1; 
                                                foreach($value_top as $value){ ?>
                                                <tr class="pro_rate_cal_front_field" id="<?php echo esc_html($value['element_id']); ?>"> 
                                                    <?php  echo $this->render_field( $value );  ?>
                                                </tr> 
                                        <?php 
                                                $i++; 
                                                } 
                                        ?>
                                    </tbody>
                            </table>
                        </div> 
                        <!-- step view table part END -->
                        <!-- step view in step add  -->
                        <div class="pro_rate_cal_progress_bar_main">
                            <?php
                            if($a == $step ) {
                                    $progress = ($a/$step_data)*100;
                                    $progressbar = round($progress,0);
                                    if($a != 1 ){
                                    ?>
                                        <div class="pro_rate_cal_step_prev_btn_block">
                                            <a href="javascript:void(0)" class="previous_row rate_cal_link_button"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg> <?php esc_html_e("Previous","project-cost-calculator" ); ?> </a>
                                        </div>
                                    <?php } ?>
                                        <div class="pro_rate_cal_progress_bar_block_main">
                                            <div class="pro_rate_cal_progress_bar_block">
                                                 <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                            </div>
                                            <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                        </div>
                                        <div class="pro_rate_cal_step_next_btn_block">
                                            <a href="javascript:void(0)" class="next_row view_pricing_row rate_cal_link_button">  <?php esc_html_e("view pricing","project-cost-calculator" ); ?>   <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                        </div>
                                    <?php
                            } elseif($a == 1 ){
                                    $progress = ($a/$step_data)*100;
                                    $progressbar = round($progress,0);
                                    ?>	
                                        <div class="pro_rate_cal_progress_bar_block_main">
                                            <div class="pro_rate_cal_progress_bar_block">
                                                <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                            </div>
                                            <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                        </div>
                                        <div class="pro_rate_cal_step_next_btn_block">
                                            <a href="javascript:void(0)" class="next_row rate_cal_link_button"> <?php esc_html_e("Next","project-cost-calculator" ); ?>  <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                        </div> 
                                    <?php
                            }else {
                                    $progress = ($a/$step_data)*100;
                                    $progressbar = round($progress,0);
                                    ?>
                                    <div class="pro_rate_cal_step_prev_btn_block">
                                        <a href="javascript:void(0)" class="previous_row rate_cal_link_button"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg> <?php esc_html_e("Previous","project-cost-calculator" ); ?> </a>
                                    </div>
                                    <div class="pro_rate_cal_progress_bar_block_main">
                                        <div class="pro_rate_cal_progress_bar_block">
                                            <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                        </div>
                                        <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                    </div>
                                    <div class="pro_rate_cal_step_next_btn_block">
                                        <a href="javascript:void(0)" class="next_row rate_cal_link_button"><?php esc_html_e("Next","project-cost-calculator" ); ?> <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                    </div>  
                            <?php
                             } 
                            ?>
                       </div>
                         <!-- step view in step add END  --> 
                    </div>  
                </div>
            <?php
                } else { 
            ?>
                        <div class="pro_rate_cal_step_main" style="<?php  if( $a == 1){echo esc_html('display:block;');}else{echo esc_html('display:none;');} ?>">
                        <div class="pro_rate-cal_step_card">
                             <?php  
                                $j = 1; 
                                // step view title section
                                foreach($value_top as $value){ 
                                    if($j == 1){ 
                                        $name =  $this->get_category("term_id", esc_attr($value['settings']['category_field']));  
                                    ?>
                                        <input type="hidden" class="cate_name" value="<?php  echo esc_html($name['name']);  ?>">
                                    <?php  
                                    } 
                                    $j++; 
                                }
                                // step view title section END
                                ?>
                                <!-- step view table part  -->
                                <div class="pro_rate-cal_step_card-body">
                                     <table class="pro_rate-cal_step_table">
                                        <tbody>
                                            <?php 
                                                $i = 1; 
                                                    foreach($value_top as $value){ 
                                                        ?>
                                                        <tr class="pro_rate_cal_front_field" id="<?php echo esc_html($value['element_id']); ?>"> 
                                                        <?php
                                                             echo $this->render_field( $value ); 
                                                             ?>
                                                        </tr> 
                                                    <?php
                                                        $i++; 
                                                    } 
                                                    ?>
                                        </tbody>
                                    </table>
                                </div> 
                                <!-- step view table part END -->
                                <!-- step view in step add  -->
                                <div class="pro_rate_cal_progress_bar_main">
                                <?php
                                if($a == $step ) {
                                        $progress = ($a/$step_data)*100;
                                        $progressbar = round($progress,0);
                                        if($a != 1 ){
                                        ?>
                                        <div class="pro_rate_cal_step_prev_btn_block">
                                            <a href="javascript:void(0)" class="previous_row rate_cal_link_button"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg> <?php esc_html_e("Previous","project-cost-calculator" ); ?> </a>
                                        </div>
                                        <?php  } ?>
                                        <div class="pro_rate_cal_progress_bar_block_main">
                                                    <div class="pro_rate_cal_progress_bar_block">
                                                        <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                                    </div>
                                                    <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                        </div>
                                        <div class="pro_rate_cal_step_next_btn_block">
                                            <a href="javascript:void(0)" class="next_row view_pricing_row rate_cal_link_button"><?php esc_html_e("view pricing","project-cost-calculator" ); ?>   <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                        </div>
                                        <?php
                                    } elseif($a == 1 ){
                                        $progress = ($a/$step_data)*100;
                                        $progressbar = round($progress,0);
                                        ?>
                                        <div class="pro_rate_cal_progress_bar_block_main">
                                            <div class="pro_rate_cal_progress_bar_block">
                                                <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                            </div>
                                            <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                        </div>
                                        <div class="pro_rate_cal_step_next_btn_block">
                                                <a href="javascript:void(0)" class="next_row rate_cal_link_button"> <?php esc_html_e("Next","project-cost-calculator" ); ?>  <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                        </div> 
                                <?php
                                    }else {
                                        $progress = ($a/$step_data)*100;
                                        $progressbar = round($progress,0);
                                        ?>
                                        <div class="pro_rate_cal_step_prev_btn_block">
                                            <a href="javascript:void(0)" class="previous_row rate_cal_link_button"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg> <?php esc_html_e("Previous","project-cost-calculator" ); ?> </a>
                                        </div>
                                        <div class="pro_rate_cal_progress_bar_block_main">
                                            <div class="pro_rate_cal_progress_bar_block">
                                                <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="<?php echo esc_html($progressbar); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_html($progressbar); ?>%"><?php echo esc_html($progressbar); ?>%</div>
                                            </div>
                                                <div class="pro_rate_cal_progress_bar_count"> <?php echo esc_html($a);?> / <?php echo esc_html($step_data);?> </div>
                                        </div>
                                        <div class="pro_rate_cal_step_next_btn_block">
                                            <a href="javascript:void(0)" class="next_row rate_cal_link_button"><?php esc_html_e("Next","project-cost-calculator" ); ?> <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"/></svg></a>
                                        </div>  
                                <?php
                                    } 
                                    ?>
                                </div> 
                                    <!-- step view in step add  END -->
                            </div>    
                        </div>
                <?php 
             } 
        $a++;
    } 
    // step view loop start
    ?>
        <!-- step view in last step -->
    <div class="pro_rate_cal_step_main" style="display:none;">
        <div class="pro_rate-cal_step_card">
            <div class="pro_rate-cal_step_card-body">
                <div class="pro_rate_cal_pricing">
                    <?php
                    // pricing before hooks
                    do_action('pro_rate_cal_step_pricing_before', $this);
                    ?>
                    <table class="pricing_table">
                    </table>
                    <?php
                    // pricing after hooks
                    do_action('pro_rate_cal_step_pricing_after', $this);
                    ?>
                </div>
            </div>
            <div class="pro_rate_cal_progress_bar_main">
                <div class="pro_rate_cal_step_prev_btn_block">
                    <a href="javascript:void(0)" class="previous_row rate_cal_let_me_rate_cal rate_cal_link_button"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"/></svg>  <?php esc_html_e("Let me edit my response","project-cost-calculator" ); ?> </a>
                </div>
                <div class="pro_rate_cal_progress_bar_block_main">
                    <div class="pro_rate_cal_progress_bar_block">
                        <div class="pro_rate_cal_progress_bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>
                    </div> 
                </div>
            </div>  
        </div>
    </div>
        <!-- step view in last step END -->
    <div class="pro_rate_cal_step_submit_btn_block" style="display:none;">
        <input type="submit" value=" <?php esc_html_e("view pricing","project-cost-calculator" ); ?>" class="rate_cal_button rate_cal_button_primary">
    </div> 