
<?php
    $values = $data['settings'];
?>
<td class="pro_rate_cal_label">
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
</td>
<td>
    <div class="pro_rate_cal_field">
    <?php
    if( !empty( $values['option']['labels'] ) && is_array( $values['option']['labels'] ) ){
        ?><div class="pro_rate_cal_field_radio_group"><?php
        foreach ($values['option']['labels'] as $key => $value) { 
            ?>
                <div class="pro_rate_cal_field_radio_item">
                    <input id= "<?php echo esc_attr($values['label_name']).$key; ?>" type="checkbox" value="<?php echo esc_attr( $values['option']['values'][$key] ); ?>"  name="[<?php echo esc_attr( str_replace( " ", "-", $values['label_name'] ) ); ?>][<?php echo esc_attr($key); ?>]"  <?php 
                        if( $value == $values['option']['default'] ){
                            echo esc_attr("checked ");  
                        }
                    ?>>
                    <label for="<?php echo esc_attr($values['label_name']).$key; ?>" ><?php echo esc_html( $value ); ?></label>
                </div>
            <?php
        }
        ?></div><?php
    }
    ?>
    </div>
</td>