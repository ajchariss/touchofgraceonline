
<div class="pro_rate_cal-main-right-content"> 
    <?php
        if( isset( $_REQUEST['id'] ) &&  !empty( sanitize_text_field( $_REQUEST['id'] ) ) ){
            $form = $this->get_form( sanitize_text_field($_REQUEST['id']) );
            if( !empty( $form ) ){
                //get current form entries
                $entries = new PRC_form_entries( $form->ID );
                $results = $entries->getFormEntries();
                //get custom fields
                $form_field = new PRC_FormField( $form->ID );
                $fields = $form_field->get_form_fields();
                ?>
                <div class="pro_rate-cal_card">
                    <div class="pro_rate-cal_card_header">
                            <h4><?php esc_html_e( "Form Entries","project-cost-calculator" ); ?></h4> 	
                            <a class="rate_cal_button rate_cal_button_primary" href="<?php echo esc_url(self::get_admin_main_page_url()); ?>" title="Calculator Form Lists"><?php esc_html_e( "All calculators", "project-cost-calculator" ); ?></a>       
                    </div>
                    <div class="pro_rate-cal_card-body">
                    <?php 
                        if(count($results) != 0){
                    ?>  
                        <table id="pro_rate_cal_form_entries" >
                            <thead>
                                <tr>
                                    <th>
                                        <?php
                                            esc_html_e("Entrie ID", "project-cost-calculator");
                                        ?>
                                    </th>
                                    <?php  if(  ($fields['firstname']['enabled'] == 1) || ($fields['lastname']['enabled'] == 1)   ){  ?>
                                        <th>
                                            <?php 
                                                esc_html_e("Full Name", "project-cost-calculator"); 
                                            ?>
                                        </th>
                                    <?php } 
                                        foreach ($fields as $key => $value) {
                                            if(  ($key == "firstname") || ($key == "lastname")  ){
                                            }else{ if( $value['enabled'] == 1 ){
                                                    ?>
                                                        <th><?php echo esc_html( $value['key_label'] ); ?> </th>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    foreach ($results as $key => $value) {
                                        $jsonData = $value->form_details;
                                        $jsonArray = json_decode($jsonData, JSON_OBJECT_AS_ARRAY );
                                ?>
                                        <tr>
                                            <td>
                                                <?php echo esc_html($count);  $count ++ ;//echo $value->id; ?>
                                            </td>
                                            <?php  if(  ($fields['firstname']['enabled'] == 1) || ($fields['lastname']['enabled'] == 1)   ){  ?>
                                                    <td>
                                                        <?php
                                                            if( !empty( $jsonArray['firstname'] ) || !empty( $jsonArray['lastname'] ) ){
                                                                $name = !empty($jsonArray['firstname']) ? $jsonArray['firstname'] : null;
                                                                $name .= " ";
                                                                $name .= !empty($jsonArray['lastname']) ? $jsonArray['lastname'] : null;
                                                                echo esc_html( $name );
                                                            }
                                                        ?>
                                                    </td>
                                            <?php } 
                                                foreach ($fields as $key => $value) {
                                                    if( ($key != "firstname") && ($key != "lastname") ){
                                                        if( $value['enabled'] == 1 ){
                                                        ?>
                                                        <td>
                                                        <?php
                                                            echo esc_html( !empty($jsonArray[$key]) ? $jsonArray[$key] : null );
                                                        ?>
                                                        </td>
                                                    <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php
                        } else {
                            printf( "<p style='text-align:center;''>%s</p>", __("No entries received yet.", "project-cost-calculator" )  );
                        }
                    ?>
                    </div>
                </div>
                <?php
            }else{
                ?><div class="pro_rate_cal_die_mesage"><?php esc_html_e("Sorry, Requested Form are invalid.", "project-cost-calculator" ); ?></div><?php
            }
        }
    ?>
</div>