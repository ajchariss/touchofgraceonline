<?php
    $values = $data['settings'];
?>
<td class="pro_rate_cal_label">
    <label><?php  echo esc_html( $values['label_name'] ); ?>
    <?php if( !empty( $values['tooltip'] ) ) : ?>
        <span class="rate_cal_tooltip" >
            <span class="rate_cal_tooltiptext" id="myTooltip">
                <?php echo esc_html( $values['tooltip'] ); ?>
            </span>
            <span class="dashicons dashicons-info"></span>
        </span>
    <?php endif; ?>
    </label>
</td>
<td>
    <div class="pro_rate_cal_qty-input">
        <input type="button" value="-" class="pro_rate_cal_qty-minus">
        <input type="number" class="pro_rate_cal_qty-txt" min="0" value="<?php echo esc_attr($values['default_quantity']) ?>" name="<?php echo esc_attr( str_replace( " ", "-", $values['label_name'] ) ); ?>">
        <input type="button" value="+" class="pro_rate_cal_qty-plus">
    </div>
</td>