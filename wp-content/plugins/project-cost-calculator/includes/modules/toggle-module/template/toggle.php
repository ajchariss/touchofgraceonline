<?php
    $values = $data['settings'];
?>
<td>
    <div class="pro_rate_cal_label">
        <label><?php  echo esc_html( $values['label_name'] ); ?>
        <?php if( !empty( $values['tooltip'] ) ) : ?>
            <span class="rate_cal_tooltip">
                <span class="rate_cal_tooltiptext" id="myTooltip">
                    <?php echo esc_html( $values['tooltip'] ); ?>
                </span>
                <span class="dashicons dashicons-info"></span>
            </span>
        <?php endif; ?>
        </label>
    </div>
</td>
<td>
    <div class="pro_rate_cal_field">
        <label class="pro_rate_cal_field_switch">
            <span class="pro_rate_cal_switch_label-text pro_rate_cal_switch_label-deactive"><?php echo esc_html($values['deactive_name']) ?></span>
            <div class="pro_rate_cal_field_switch_block">
                <input class="pro_rate_cal_switch_input" type="checkbox" value="1" name="<?php echo esc_attr( str_replace( " ", "-", $values['label_name'] ) ); ?>" <?php
                    if( esc_attr( $values['default_state'] ) == "activated" ){
                        echo esc_attr( "checked" );
                    }
                ?> />
                <span class="pro_rate_cal_switch_label" data-on="<?php echo esc_attr($values['active_name']) ?>" data-off="<?php echo esc_attr($values['deactive_name']) ?>"></span> 
                <span class="pro_rate_cal_switch_handle"></span> 
            </div>
            <span class="pro_rate_cal_switch_label-text pro_rate_cal_switch_label-active"><?php echo esc_html($values['active_name']) ?></span>
        </label>
    </div>
</td>



