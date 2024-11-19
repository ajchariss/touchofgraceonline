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
    <div class="pro_rate_cal_field pro_rate_cal_range_field">
        <div class="range-wrap">
    		<div class="range-value" id="rangeV"></div>
            <input id="range" type="range" value="<?php echo esc_attr($values['default_quantity']) ?>" name="<?php echo esc_attr( str_replace( " ", "-", $values['label_name'] ) ); ?>"
                min="<?php echo esc_attr( $values['min_range'] ); ?>"
                max="<?php echo esc_attr( $values['max_range'] ); ?>"
                step="1" >
        </div>
    </div>
</td>