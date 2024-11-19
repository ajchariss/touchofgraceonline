<?php
if( !class_exists( 'PRC_NotificationField' ) ){

    class PRC_NotificationField extends PRC_db{

        /**
        * Form ID
        */
        public $form_id;
        /**
        * Form 
        */
        private $form;
        /**
        * Form properties
        */
        private $properties;
        /**
        * Form message
        */
        private $message = array();
       
        function __construct( $form_id ){
            $this->form_id = $form_id;
            $this->setForm( $this->form_id );
            $this->setProperties();
        }

        /**
        * Form  update function
        */

        public function update_settings( $array ){

            /* Notifiction Form Fields Data Store */
            if( isset( $array['notifi_admin_email'] ) && !empty( sanitize_email( $array['notifi_admin_email'] ) )){
                if( $this->set_form_properties( $this->form_id, "notifi_admin_email", sanitize_email( $array['notifi_admin_email'] ) ) ){
                    $this->setNotifiProperties('notifi_admin_email');
                }
            }

            if( isset( $array['notifi_subject'] ) && !empty( sanitize_text_field($array['notifi_subject']) )){
                if( $this->set_form_properties( $this->form_id, "notifi_subject", sanitize_text_field( $array['notifi_subject'] ) ) ){
                    $this->setNotifiProperties('notifi_subject');
                }
            }

            if( isset( $array['notifi_email_template'] ) && !empty( sanitize_text_field( $array['notifi_email_template'] ) )){
                if( $this->set_form_properties( $this->form_id, "notifi_email_template", wp_kses_post($array['notifi_email_template']) )  ){
                    $this->setNotifiProperties('notifi_email_template');
                }
            }

            if( isset( $array['valeditonary_text'] ) && !empty( sanitize_text_field( $array['valeditonary_text'] ) )){
                if( $this->set_form_properties( $this->form_id, "valeditonary_text", wp_kses_post( $array['valeditonary_text'] ) )){
                    $this->set_form_valeditonary_text();
                }
            }

            $this->set_message( PRC_db::message_string('settings_saved') );

        }

        /**
        * Form submit massage
        */

        private function set_message($message){
            $this -> message[] = '<div class="notice notice-success form-setting-notification"><p>'.$message.'</p></div>';
        }

        /**
        * Form submit massage get
        */

        public function get_message(){
            return $this->message;
        }

         /**
        * Form valeditonary set function 
        */

        private function set_form_valeditonary_text(){
            $this->properties['valeditonary_text'] = $this->get_form_valeditonary_text();
        }

        /**
        * Form valeditonary get function 
        */

        public function get_form_valeditonary_text(){
            return $this->get_form_properties( $this->form_id, "valeditonary_text");
        }

        /**
        * Form notifiction admin mail set  function 
        */
        
        private function setNotifiProperties($field = null){
            $this->properties[$field] = $this->get_notifi_fields($field);
        }

        /**
        * Form notifiction admin mail get function 
        */

        public function get_notifi_fields($field = null){
            return $this->get_form_properties( $this->form_id, $field);
        }

        /**
        * Form  field  get  function 
        */

        public function getProperties(){
            return $this->properties;
        }

        /**
        * Form  field  set  function 
        */

        private function setProperties(){
            $properties = $this->get_form_field_properties( $this->form_id );
            if( !empty( $properties ) ){
                $this->properties = $properties;
            }else{
                $this->properties = $this->getdefaultProperties();
            }
        }

        /**
        * Form  field  get  function 
        */

        private function setForm( $form_id ){
            $this->form = $this->get_form( $form_id );
        }

        /**
        * Form status set function 
        */

        private function setFormState(){
            $form_state = $this->get_form_state($this->form_id);
            if( $form_state == "deactivate" ){
                $this->properties['form_state'] = "deactive";
            }else if( $form_state == "activated" ){
                $this->properties['form_state'] = "active";
            }
        }


        /**
        * Form body template get function 
        */

        private function get_email_template_body(){
            ob_start();
            $file = PRC_TEMPLATE_DIR."/email/email.php";
            if(file_exists( $file )){
                include $file;
            }
            return ob_get_clean();
        }
          
        /**
        * Form default Properties get function 
        */

        public function getdefaultProperties(){
            return array(
                "page_action" => "pro_rat_cal_notifi_form_fields",
                "form_state" => $this->get_form_state($this->form_id) == "activated" ? "active" : "deactive",
                "form_name" => $this->form->post_title,
                "notifi_admin_email" => !empty( $this->get_notifi_fields('notifi_admin_email') ) ? $this->get_notifi_fields('notifi_admin_email') : get_bloginfo('admin_email') ,
                "notifi_subject" => !empty( $this->get_notifi_fields('notifi_subject') ) ? $this->get_notifi_fields('notifi_subject') : __("New submission from Project Cost Calculator Form", "project-cost-calculator"),
                "notifi_email_template" => !empty( $this->get_notifi_fields('notifi_email_template') ) ? $this->get_notifi_fields('notifi_email_template') : $this->get_email_template_body() ,
                "valeditonary_text" => !empty($this->get_form_valeditonary_text()) ? $this->get_form_valeditonary_text() : null
            );
        }

    }

}
?>
