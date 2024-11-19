<?php
if( isset( $_POST['data'] ) && !empty( $_POST['data'] ) ){
    ?>
        <table  border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff; max-width: 900px;  width: 100%; margin-bottom: 50px;">
            <tbody>
                <?php
                    foreach ($_POST['data'] as $key => $value) {
                        ?> 
                            <tr>
                                <?php
                                    if( isset( $value["isTotal"] ) && !empty( $value["isTotal"] ) && $value["isTotal"] ){
                                        ?>  <th style='text-align: left;font-weight: 700; font-size: 16px; padding: 10px 15px; border-bottom: 1px solid #d6d6d6;'> <?php
                                    }else{
                                        ?> <td style='text-align: left; padding: 10px 15px; border-bottom: 1px solid #d6d6d6;'> <?php
                                    }
                                ?>
                                <?php
                                    if( !empty( trim( $value['label'] ) )  ){
                                        echo esc_html( $value['label'] );
                                    }
                                ?>
                                </td>
                                <td style='text-align: left; padding: 10px 15px; border-bottom: 1px solid #d6d6d6;'>
                                <?php
                                    if( !empty( trim( $value['value'] ) )  ){
                                        echo esc_html( $value['value'] );
                                    }
                                ?>
                               <?php
                                    if( isset( $value["isTotal"] ) && !empty( $value["isTotal"] ) && $value["isTotal"] ){
                                        ?>  <th> <?php
                                    }else{
                                        ?> <td> <?php
                                    }
                                ?>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    <?php
}

?>
