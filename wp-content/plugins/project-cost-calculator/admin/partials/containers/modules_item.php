<div class="pro_rate_cal_module" data-module="<?php echo esc_attr($value->getId()); ?>" title="<?php echo esc_attr( $value->getName() ); ?>" >
    <div class="pro_rate_cal_module_icon_box">
        <img src="<?php echo esc_url($value->getIconUrl()); ?>">
        <span><?php echo esc_html($value->getName()); ?></span>
    </div>
</div>