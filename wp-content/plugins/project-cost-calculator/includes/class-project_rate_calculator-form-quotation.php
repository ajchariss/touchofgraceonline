<?php

if( !class_exists( 'PRC_FormQuotation' ) ){

    class PRC_FormQuotation extends PRC_db{
        /**
        * Form ID
        */
        public $form_id;

        /**
        * message
        */
        public $message = array();

        /**
        * layout type
        */
        public $settings = array(
            "quatation_notification" => "deactive",
            "quatation_email" => "",
            "quatation_message" => "",
        );

        function __construct( $form_id ){
            $this->form_id = $form_id;
        }
    
        /**
        * layout form update function
        */
        function update_settings( $array ){

            if( isset( $array['quatation_notification'] ) && !empty( sanitize_text_field( $array['quatation_notification'] ) ) ){
                $this -> set_properties( "quatation_notification", sanitize_text_field( $array['quatation_notification'] ) );
            }

            if( isset( $array['open_form_quotation_btn_text'] ) && !empty( sanitize_text_field( $array['open_form_quotation_btn_text'] ) ) ){
                $this -> set_properties( "open_form_quotation_btn_text", sanitize_text_field( $array['open_form_quotation_btn_text'] ) );
            }

            if( isset( $array['send_quotation_btn_text'] ) && !empty( sanitize_text_field( $array['send_quotation_btn_text'] ) ) ){
                $this -> set_properties( "send_quotation_btn_text", sanitize_text_field( $array['send_quotation_btn_text'] ) );
            }

            if( isset( $array['quatation_email_template'] ) && !empty( sanitize_text_field( $array['quatation_email_template'] ) )){
                $this -> set_properties( "quatation_email_template",  wp_kses_post($array['quatation_email_template']) );
            }
            
            if( isset( $array['send_quot_to_user'] ) && !empty( sanitize_text_field( $array['send_quot_to_user'] ) ) ){
                $this -> set_properties( "send_quot_to_user", sanitize_text_field( $array['send_quot_to_user'] ) );
            }

            if( isset( $array['quatation_email'] ) && !empty( sanitize_email( $array['quatation_email'] ) ) ){
                $this -> set_properties( "quatation_email", sanitize_email( $array['quatation_email'] ) );
            }

            if( isset( $array['quatation_message'] ) && !empty( sanitize_text_field( $array['quatation_message'] ) ) ){
                $this -> set_properties( "quatation_message", sanitize_text_field( $array['quatation_message'] ) );
            }

            if( isset( $array['quatation_email_subject'] ) && !empty( sanitize_text_field( $array['quatation_email_subject'] ) ) ){
                $this -> set_properties( "quatation_email_subject", sanitize_text_field( $array['quatation_email_subject'] ) );
            }

            $this -> message[] = '<div class="notice notice-success form-setting-notification"><p>'.PRC_db::message_string("quotation_settings_successfully").'</p></div>';


        }

        /**
         * Set Properties
         */
        public function set_properties( $key = null, $value ){
            if( !empty( $key ) ){
                return $this->set_form_properties( $this->form_id, $key, $value );
            }else{
                return false;
            }
        }

        /**
         * get Properties
         */
        public function get_properties( $key = null ){
            if( !empty( $key ) ){
                if( $key == "quatation_email_template" ){
                    if( empty( $this->get_form_properties( $this->form_id, $key ) ) ){
                        return $this->get_default_quote_email_template();   
                    }
                }
                return $this->get_form_properties( $this->form_id, $key );
            }else{
                return false;
            }
        }

        /**
         * Default email template
         */
        function get_default_quote_email_template(){
            ob_start();
            $file = PRC_TEMPLATE_DIR."/email/email-default-quatation.php";
            if( file_exists( $file )){
                include $file;
            }
            return ob_get_clean();
        }
        

        /**
        * layout form submit massage function 
        */
        public function getMessage(){
            return $this->message;
        }

    }
    
}
?>