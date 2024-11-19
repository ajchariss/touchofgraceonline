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
        ?>
            <div class="pro_rate_cal_field_radio_group">
                <select name="" id="">  
                    <?php
                        foreach ($values['option']['labels'] as $key => $value) { 
                    ?>  
                            <option data-key="<?php echo esc_attr($key); ?>" name="[<?php echo esc_attr( str_replace( " ", "-", $values['label_name'] ) ); ?>][<?php echo esc_html($key); ?>]" value="<?php echo esc_attr( $values['option']['values'][$key] ); ?>" <?php  if( $value == $values['option']['default'] ){echo esc_attr(" selected ");   }?>><?php echo esc_html( $value ); ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        <?php
        }
        ?>
    </div>
</td>