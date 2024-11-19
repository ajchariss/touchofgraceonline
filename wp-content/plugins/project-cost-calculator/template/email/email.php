<?php
    if( isset( $_REQUEST['id'] ) &&  !empty( sanitize_text_field($_REQUEST['id']) ) ){
        $form = $this->get_form( sanitize_text_field( $_REQUEST['id'] ) );
    }
    $form_field = new PRC_FormField( $form->ID );
    $fields = $form_field->get_form_fields();
?>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table  width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="max-width: 1024px; width: 100%; background-color: #F5F5F5;">
                        <tr>
                            <td>
                                <table  width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="background-color: #f7f7f7;">
                                    <tr>
                                        <td style="padding: 20px 0 20px 20px; width: 48%;">
                                            <img src="<?php echo esc_url(PRC_Public::get_image_url("logo-main-1.png")); ?>" style="max-width: 100%; height:auto;">
                                        </td>
                                        <td align="right" style="padding: 20px 20px 20px 10px;">
                                            <table border="0" cellspacing="0" cellpadding="0" style=" border-radius: 20px; color: #ffffff; padding:10px 33px; background-color: #e32a2f;">
                                                <tr>
                                                    <td>
                                                        <?php 
                                                            printf('<a style="color: #ffffff; font-family: "Roboto", sans-serif; text-decoration: none; text-transform: uppercase; font-weight: 700; text-align: center;" href="#"> %s </a>',__('Support',"project-cost-calculator"));
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table  width="100%" border="0"  align="center" cellspacing="0" cellpadding="0" style="background-color: #ffffff;">
                                        <tr>
                                            <td style="padding: 50px;">
                                                <table  border="0" cellspacing="0" cellpadding="0" width="100%">
                                                        <tr>
                                                            <td align="center">
                                                                <h2 style="font-size:26px; font-family: 'Roboto', sans-serif; color: #000000; line-height:1; font-weight:700;margin: 0 0 20px;"> <?php esc_html_e('WELCOME ',"project-cost-calculator" ); echo esc_html( get_bloginfo("name") ); ?></h2>
                                                                <p style="font-size:16px; line-height:28px; font-family: 'Roboto', sans-serif; color:#000000; font-weight:300; margin: 0 0 30px;">
                                                                    <?php 
                                                                    esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',"project-cost-calculator");
                                                                    ?> 
                                                                    </p>    
                                                            </td>
                                                        </tr>
                                                </table>
                                            </td>
                                        </tr>
                                </table>
                                <table  width="100%" border="0"  align="center" cellspacing="0" cellpadding="0" style="background-color: #fbfbfb;">
                                    <tr>
                                        <td align="center" style="padding: 0 15px;">
                                            <table  border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff; max-width: 600px; border: 1px solid #ebebeb; width: 100%; margin: 30px 0;">
                                                <tr>
                                                    <td style="padding: 0 15px 0;">
                                                        <table  border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff; max-width: 900px;  width: 100%; margin-bottom: 0;">   
                                                        <?php
                                                        foreach ($fields as $key => $value) {
                                                            if( !empty($value['enabled']) && $value['enabled'] ){
                                                                printf("
                                                                <tr>
                                                                <td style='text-align: left; padding: 10px 15px; border-bottom: 1px solid #d6d6d6;'>%s</td>
                                                                <td style='text-align: right; padding: 10px 15px; border-bottom: 1px solid #d6d6d6;'>{{%s}}</td>
                                                                </tr>
                                                                ", $value['label'], $key);

                                                            }
                                                        }
                                                        ?>
                                                        </table>
                                                    </td>
                                                </tr>   
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table  width="100%" border="0"  align="center" cellspacing="0" cellpadding="0" style="background-color: #1c1c1c;">
                                    <tr>
                                        <td style="padding: 30px 15px; font-family: 'Roboto', sans-serif; font-size:15px; line-height:28px; color: #ffffff; text-align: center;">
                                            <?php 
                                            printf(' %s <a style="color: #e32a2f; text-decoration: none;" href="mailto:hello@unlimitedwp.com">hello@unlimitedwp.com</a> %s <a style="color: #e32a2f; text-decoration: none;" href="tel:000-123-45677">000-123-4567</a>.', __( " If you have any questions, please feel free to contact us at", "project-cost-calculator" ) , __( " or by phone at ", "project-cost-calculator") );
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <td style="padding: 18px 30px; background-color:#000000; border-top: 1px solid #1e1e1e;">
                                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                    <td style="font-size:15px; line-height:28px;color: #ffffff; font-family: 'Roboto', sans-serif; vertical-align:middle; text-align: center;">

                                                        <?php
                                                        
                                                        printf( ' %s <a style="color: #e32a2f; text-decoration: none;" href="https://unlimitedwp.com/" target="_blank">UnlimitedWP</a>', __( 'All Rights reserved. Copyright 2021 | Project Cost Calculator powered by' , "project-cost-calculator") );
                                                        
                                                        ?>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    
                </table>
            </td>
        </tr>
    
</table>