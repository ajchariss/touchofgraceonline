<?php
    $values = $data['settings'];
?>
<td colspan="2">
<div class="pro_rate_cal_field">
    <?php 
        $replacedQuote = str_replace("<quot;>",'"',$values['content']);
        $replacedApos = str_replace("<apos;>","'",$replacedQuote);
        printf( "%s", $replacedApos );
    ?>
</div>
</td>