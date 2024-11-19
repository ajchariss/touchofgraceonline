<?php 
if( !empty( $value ) ){ 
?>
    <tr class="calculator_item" data-id="<?php echo esc_attr( $value->ID ); ?>">
        <td><?php echo esc_html( $key + 1 ); ?></td>
        <td><a href="<?php echo esc_url( self::get_admin_main_page_url(
            array(
                "action" => "edit",
                "id" => $value->ID
            )
        )); ?>"><?php echo esc_html($value->post_title); ?></a></td>
        <td>
            <?php 
            $CalProperties = $this->get_calculator_properties($value->ID);
            $Propcount = 0;
            if( !empty( $CalProperties )  && is_array($CalProperties)){
                $Propcount = count($this->get_calculator_properties($value->ID));
            }
            ?>
            <?php
            if( $Propcount > 0 ){
            ?>
            <input type="text" value="<?php echo esc_attr(self::get_form_shortcode($value)); ?>"  disabled >
            <div class="tooltip rate_cal_tooltip">
                <button class="rate_cal_button rate_cal_icon_transparent_button" onClick="<?php echo esc_js( "copyShortcode( \"".esc_attr(self::get_form_shortcode($value))."\",jQuery(this) )" ); ?>" >
                    <span class="rate_cal_tooltiptext  tooltiptext" id="myTooltip"><?php esc_html_e( "Copy shortcode", "project-cost-calculator"); ?></span>
                    <span class="dashicons dashicons-admin-page"></span>
                </button>
            </div>
            <?php
            }else{
                esc_html_e("Form is deactivated", "project-cost-calculator");
            }
            ?>
        </td>
        <td>
            <a class="rate_cal_button rate_cal_icon_transparent_button" title="Edit Form" href="<?php echo  esc_url(self::get_admin_main_page_url(
            array(
                "action" => "edit",
                "id" => $value->ID
            ))); ?>"><span class="dashicons dashicons-edit"></span></a>
            <button type="button" class="rate_cal_button rate_cal_icon_transparent_button" title="Delete Form" onClick="<?php echo esc_js( "deleteProCalForm( ".esc_attr($value->ID)." )" ); ?>" ><span class="dashicons dashicons-trash"></span></button>
        </td>
    </tr>
<?php } ?>