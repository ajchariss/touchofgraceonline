<?php
    $values = $data['settings'];
?>
<td colspan="3">
    <hr  style="<?php
            if( !empty( $values['vertical_padding'] ) ){
                printf( "padding-top:%spx;", $values['vertical_padding']);
                printf( "padding-bottom:%spx;", $values['vertical_padding']);
            }
            if( !empty( $values['horizontal_padding'] ) ){
                printf( "padding-left:%spx;", $values['vertical_padding']);
                printf( "padding-right:%spx;", $values['vertical_padding']);
            }
            if( !empty( $values['border'] )){
                printf( "border: solid %spx;", $values['border']);
            }
            if( !empty( $values['color'] )){
                printf( "border-color:%s", $values['color']);
            }
        
    ?>" >
</td>

