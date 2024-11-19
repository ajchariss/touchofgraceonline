<?php
  $temp = null;
  $rowspan = 0;
  $category_column = $this->category_column($this->sort_array_by_order());
  ?>
    <div class="pro_rate_cal_table_responsive">
        <table class="classic-table">
            <thead>
                <tr>
                    <th><?php echo apply_filters( "pro_rate_cal_form_category_label", __("Category","project-cost-calculator") , $this); ?></th>
                    <th><?php echo apply_filters( "pro_rate_cal_form_particular_label", __("Particular","project-cost-calculator") , $this); ?></th>
                    <th><?php echo apply_filters( "pro_rate_cal_form_value_label", __("","project-cost-calculator") , $this); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                foreach ( $this->sort_array_by_order() as $key => $value ) {
                ?> 
                    <tr class="pro_rate_cal_front_field" id="<?php echo esc_attr($value['element_id']); ?>" data-category = "<?php echo !empty($category_column[$key]['category']) ? esc_attr("cat_".$category_column[$key]['category']) : 0; ?>"> 
                    <?php
                        if( isset( $category_column[$key]['hasCategoryChanged'] ) && $category_column[$key]['hasCategoryChanged'] ){
                            if( isset( $category_column[$key]['rowspan'] ) ){
                                $rowspan = $category_column[$key]['rowspan'];
                                echo "<td class='pro_rate_cal_rowspan' rowspan='". esc_html( $rowspan ) ."' >";
                                if( isset( $category_column[$key]['category'] )) {
                                    echo "<span class='pro_rate_cal_table_category_label'>".esc_html($this->get_category( "ID", esc_attr($category_column[$key]['category']))['name'])."<span>";
                                }
                                echo wp_kses_data("</td>");
                            }
                        }
                        if( isset($value['settings']['category_field']) ){
                            $currentCategory = $this->get_category( "ID",esc_attr($value['settings']['category_field']) )['name'];
                        }
                        echo $this->render_field( $value );
                    ?> 
                    </tr>
                <?php
                }
                ?>
                <tbody>
            </table> 
    </div>
    <div class="pro_rate_cal_step_submit_btn_block">
        <input type="submit" value="<?php esc_html_e("view pricing","project-cost-calculator"); ?> " class="rate_cal_button rate_cal_button_primary">
    </div> 
    <div class="pro_rate_cal_pricing">
        <table class="pricing_table">
        </table>
    </div>