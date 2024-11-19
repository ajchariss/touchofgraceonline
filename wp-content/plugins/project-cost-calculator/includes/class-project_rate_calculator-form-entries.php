<?php

if( !class_exists( "PRC_form_entries" ) ){

    class PRC_form_entries extends PRC_db{

        /**
         * Current form id
         */
        public $form_ID;
        function __construct( $form_ID ){
            $this->form_ID = $form_ID;
        }

        /**
         * Insert new data in database for current form id
         */
        function insertData( $json ){ 
            /**
             * Get Notification properties for current form
             *  */
            $notification = new PRC_NotificationField( $this->form_ID );
            /**
             * Get current form fields 
             */
            $form_fields = new PRC_FormField( $this->form_ID );
            $notificationProperties = $notification-> getdefaultProperties();
            $dynamicData = array();
            foreach ($form_fields -> get_form_fields() as $key => $value) {
                if( $value['enabled'] == true ){
                    $dynamicData[$key] = $json[$key];
                }
            }
            $email = $notificationProperties['notifi_admin_email'];
            $emails = explode(",",$email);
            $subject = $notificationProperties['notifi_subject'];
            $template = $notificationProperties['notifi_email_template'];
                           
            /**
             * Send email
             */
            $template = apply_filters( "pro_rate_cal_sticky_form_email_template", $template );
            new PRC_Email( $emails ,$subject, $dynamicData, $template );
            return $this->insert_form_entries( $this->form_ID, json_encode( $json ) );

        }

        /**
         * Get all entries from database
         */
        function getFormEntries(){
            return $this->get_form_entries( $this->form_ID );
        }

        /**
         * Get Email Template
         */
        function get_email_template( $file ){
            ob_start();
            $file = PRC_TEMPLATE_DIR."/email/".$file.".php";
            if( file_exists( $file )){
                include $file;
            }
            return ob_get_clean();
        }

        /* Get email body template */
        function get_email_template_body(){
            ob_start();
            $file = PRC_TEMPLATE_DIR."/email/email.php";
            if(file_exists( $file )){
                include $file;
            }
            return ob_get_clean();
        }
    }
}
?>