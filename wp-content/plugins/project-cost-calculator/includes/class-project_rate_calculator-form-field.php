<?php
if ( !class_exists( 'PRC_FormField' ) ) {

    class PRC_FormField extends PRC_db{

        /**
         * Post id or form is of current form
         */
        public $form_id;

        /**
         * Form post
         */
        private $form;

        /**
         * Manage and set fields properties in this variable
         */
        private $properties;

        /**
         * To show message on front of user for current status of fields operations
         */
        private $message = array();

        function __construct( $form_id ){
            $this->form_id = $form_id;
            $this->setForm( $this->form_id );
            $this->setProperties();
        }

        /** Update fields  */
        public function update_settings( $array ){
            /* check and update form state */
            if( isset( $array['form_state'] ) && !empty( $array['form_state'] ) || ( sanitize_text_field( $array['form_state'] ) == "active" || sanitize_text_field( $array['form_state'] ) == "deactive" ) ){
                $form_state = $this->get_form_state($this->form_id);
                if( sanitize_text_field( $array['form_state'] ) == "deactive" && $form_state != "deactivate" ){
                    if( $this->set_form_state( $this->form_id, false ) ){
                        $this->setFormState();
                    }
                }else if( sanitize_text_field( $array['form_state'] ) == "active" && $form_state != "activated" ){
                    if( $this->set_form_state( $this->form_id, true ) ){
                        $this->setFormState();
                    }
                }
            }

            /* check form time out */
            if( isset($array['form_timeout']) && !empty( $array['form_timeout'] ) || ( sanitize_text_field( $array['form_timeout'] ) != $this->properties['form_timeout'] ) ){
                if( $this->set_form_properties( $this->form_id, "form_timeout", sanitize_text_field( $array['form_timeout'] ) )){
                    $this->set_form_timeout();
                }
            } 

            /* check for form name changes and update */
            if( isset($array['form_name']) && ( sanitize_text_field( $array['form_name'] ) != $this->properties['form_name'] ) ){
                $post_title = $this->get_form( sanitize_text_field( $this->form_id ) ) -> post_title;
                if( $post_title != sanitize_text_field( $array['form_name'] ) ){
                    if( $this->set_form_properties( $this->form_id, "form_name", $array['form_name'] ) ){
                        $this->setFormName();
                    }
                }
            }

            /* check for Introduction Paregraph and update */
            if( isset( $array['intro_paragraph'] ) && !empty( sanitize_text_field( $array['intro_paragraph'] ) ) ){
                if( $this->set_form_properties( $this->form_id, "intro_paragraph", wp_kses_post( $array['intro_paragraph'] ) ) ){
                    $this->setIntroProperties();
                }
            }

            /* fields settings */
            if( isset( $array['fields'] ) && !empty( $array['fields'] )){
                $fields = $array['fields'];
                $arrayFields = array();
                foreach ( $this->properties['fields'] as $key => $value) {
                    $arrayFields[$key]['key_label'] = $value['key_label'];
                    $arrayFields[$key]['label'] = $fields[$key]['label'];
                    $arrayFields[$key]['enabled'] = !empty($fields[$key]['enabled']) ? 1 : 0 ;
                    $arrayFields[$key]['required'] = !empty($fields[$key]['required']) ? 1 : 0 ;
                    $arrayFields[$key]['validation_message'] = $fields[$key]['validation_message'];
                    $arrayFields[$key]['order'] = $fields[$key]['order'];

                }
                if( $this->set_form_properties( $this->form_id, "form_fields", $arrayFields )){
                    $this->set_form_fields();
                }
            }

            /* submit button text */

            if( isset( $array['btn_text'] ) && !empty( sanitize_text_field( $array['btn_text'] ) )){
                if( $this->set_form_properties( $this->form_id, "btn_text", sanitize_text_field( $array['btn_text'] ) )){
                    $this->set_form_submit_btn();
                }
            }

            /* webhook settings */
            if( isset( $array['iswebhook'] ) && !empty( sanitize_text_field( $array['iswebhook'] ) )){
                if( $this->set_form_properties( $this->form_id, "iswebhook", sanitize_text_field( $array['iswebhook'] ) )){
                    $this->set_iswebhook();
                }
            }else{
                if( $this->set_form_properties( $this->form_id, "iswebhook", 0 )){
                    $this->set_iswebhook();
                }
            }

            /* webhook url */
            if( isset( $array['webhookurl'] ) && !empty( sanitize_text_field( $array['webhookurl'] ) )){
                if( $this->set_form_properties( $this->form_id, "webhookurl", sanitize_text_field( $array['webhookurl'] ) )){
                    $this->set_webhookurl();
                }
            }

            /* valeditonary_text */
            if( isset( $array['valeditonary_text'] ) && !empty( sanitize_text_field( $array['valeditonary_text'] ) )){
                if( $this->set_form_properties( $this->form_id, "valeditonary_text", wp_kses_post( $array['valeditonary_text'] ) )){
                    $this->set_form_valeditonary_text();
                }
            }

            $this->set_message( PRC_db::message_string('settings_saved'));
        }

        /**
         * Set operation message
         */
        private function set_message($message){
            $this -> message[] = '<div class="notice notice-success form-setting-notification"><p>'.$message.'</p></div>';
        }

        /**
         * Get message of current operations
         * 
        */
        public function get_message(){
            return $this->message;
        }

        /**
         * Set valeditionary text to properties
         */
        private function set_form_valeditonary_text(){
            $this->properties['valeditonary_text'] = $this->get_form_valeditonary_text();
        }

        /**
         * Get valeditionary text from db
         */
        public function get_form_valeditonary_text(){
            return $this->get_form_properties( $this->form_id, "valeditonary_text");
        }

        /**
         * set form submit btn to properties
         */
        private function set_form_submit_btn(){
            $this->properties['btn_text'] = $this->get_form_submit_btn();
        }

        /**
         * get form submit button text from db
         */
        public function get_form_submit_btn(){
            return $this->get_form_properties( $this->form_id, "btn_text");
        }


        /**
         * set webhook properties
         */
        private function set_iswebhook(){
            $this->properties['iswebhook'] = $this->get_iswebhook();
        }

        /**
         * get webhook state from db
         */
        public function get_iswebhook(){
            return $this->get_form_properties( $this->form_id, "iswebhook");
        }


        /**
         * set webhookurl properties
         */
        private function set_webhookurl(){
            $this->properties['webhookurl'] = $this->get_webhookurl();
        }


        /**
         * get webhook state from db
         */
        public function get_webhookurl(){
            return $this->get_form_properties( $this->form_id, "webhookurl");
        }
        

        /**
         * set form fields on properties
         */
        private function set_form_fields(){
            $this->properties['fields'] = $this->get_form_fields();
        }

        /**
         * set form timeout
         */
        private function set_form_timeout(){
            $this->properties['form_timeout'] = $this->get_form_timeout();
        }

        /**
         * get form timeout
         */
        public function get_form_timeout(){
            return !empty( $this->get_form_properties( $this->form_id, "form_timeout") ) ? $this->get_form_properties( $this->form_id, "form_timeout")  : 5;
        }


        /**
         * Get Form fields
         */
        public function get_form_fields(){
            $fields = $this->get_form_properties( $this->form_id, "form_fields");
            $fieldArray = array();
            $default = $this->get_default_fields();
            foreach ($default as $key => $value) {
                $fieldArray[$key]["key_label"] = $value["key_label"];
                $fieldArray[$key]["label"] = isset( $fields[$key]['label'] ) ?  $fields[$key]['label'] : $value["label"];
                $fieldArray[$key]["enabled"] = isset( $fields[$key]['enabled'] ) ?  $fields[$key]['enabled'] : $value["enabled"];
                $fieldArray[$key]["required"] = isset( $fields[$key]['required'] ) ?  $fields[$key]['required'] : $value["required"];
                $fieldArray[$key]["validation_message"] = isset( $fields[$key]['validation_message'] ) ?  $fields[$key]['validation_message'] : $value["validation_message"];
                $fieldArray[$key]["order"] = isset( $fields[$key]['order'] ) ?  $fields[$key]['order'] : $value["order"];
            }
            return $fieldArray;
        }

        /* set introduction paragraph */
        private function setIntroProperties(){
            $this->properties['intro_paragraph'] = $this->get_intro_paragraph();
        }

        /**
         * Get introduction paragraph
         */
        public function get_intro_paragraph(){
            return $this->get_form_properties( $this->form_id, "intro_paragraph");
        }

        /**
         * Set current Form name
         */
        private function setFormName(){
            $form = $this->get_form( $this->form_id );
            $this->properties['form_name'] = $this->get_form_name();
        }

        /**
         * Get Current Form Name
         */
        public function get_form_name(){
            return $this->get_form_properties( $this->form_id, "form_name");
        }


        /**
         * get form properties
         */
        public function getProperties(){
            return $this->properties;
        }

        /**
         * Set form properties
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
         * Set current form using form form id
         */
        private function setForm( $form_id ){
            $this->form = $this->get_form( $form_id );
        }

        /**
         * Set Form State
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
         * Get form state from post meta
         */
        public function getFormState(){
            $form_state = $this->get_form_state($this->form_id);
            if( $form_state == "deactivate" ){
                $this->properties['form_state'] = "deactive";
            }else if( $form_state == "activated" ){
                $this->properties['form_state'] = "active";
            }
            return $this->properties['form_state'];
        }

        /**
         * 
         * For set default properties
         */
        private function get_default_fields(){
            return array(
                "firstname" => array(
                    "key_label" => __("First Name","project-cost-calculator"),
                    "label" => __("First Name","project-cost-calculator"),
                    "enabled" => 1,
                    "required" => 1,
                    "validation_message" => __("First Name is required","project-cost-calculator"),
                    "order" => 0,
                ),
                "lastname" => array(
                    "key_label" => __("Last Name","project-cost-calculator"),
                    "label" => __("Last Name","project-cost-calculator"),
                    "enabled" => 1,
                    "required" => 1,
                    "validation_message" => __("Last Name is required","project-cost-calculator"),
                    "order" => 1,
                ),
                "email" => array(
                    "key_label" => __("Email","project-cost-calculator"),
                    "label" => __("Email","project-cost-calculator"),
                    "enabled" => 1,
                    "required" => 1,
                    "validation_message" => __("Email is required","project-cost-calculator"),
                    "order" => 2,
                ),
                "phone" => array(
                    "key_label" => __("Phone Number","project-cost-calculator"),
                    "label" => __("Phone Number","project-cost-calculator"),
                    "enabled" => 0,
                    "required" => 1,
                    "validation_message" => __("Phone Number is required","project-cost-calculator"),
                    "order" => 3,
                ),
                "address" => array(
                    "key_label" => __("Address:","project-cost-calculator"),
                    "label" => __("Address:","project-cost-calculator"),
                    "enabled" => 0,
                    "required" => 1,
                    "validation_message" => __("Address is required","project-cost-calculator"),
                    "order" => 4,
                ),
            );
        }

        /**Get Default Properties */
        private function getdefaultProperties(){
            return array(
                "page_action" => "pro_rat_cal_form_fields",
                "webhookurl" => !empty($this->get_webhookurl()) ? $this->get_webhookurl() : null, 
                "iswebhook" => !empty($this->get_iswebhook()) ? $this->get_iswebhook() : 0,
                "form_timeout" => !empty($this->get_form_timeout()) ? $this->get_form_timeout() : "5",
                "form_state" => $this->get_form_state($this->form_id) == "activated" ? "active" : "deactive",
                "form_name" => !empty( $this->get_form_name() ) ? $this->get_form_name() : null ,
                "intro_paragraph" => !empty( $this->get_intro_paragraph() ) ? $this->get_intro_paragraph() : null ,
                "fields" => !empty($this->get_form_fields()) ? $this->get_form_fields() : $this->get_default_fields(),
                "btn_text" => !empty($this->get_form_submit_btn()) ? $this->get_form_submit_btn() : "Save",
                "valeditonary_text" => !empty($this->get_form_valeditonary_text()) ? $this->get_form_valeditonary_text() : null
            );
        }
    }
}
?>
