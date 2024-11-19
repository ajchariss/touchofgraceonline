<?php

if( !class_exists( 'PRC_FormLayout' ) ){

    class PRC_FormLayout extends PRC_db{
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
            "layout_type" => "classic-view",
            "layout_css" => "",
        );

        function __construct( $form_id ){
            $this->form_id = $form_id;
        }
    
        /**
        * layout form update function
        */
        function update_settings( $array ){

            if( !empty( $array['layout_type'] )  || sanitize_text_field( !empty( $array['layout_type'] ) ) ){
                $layoutState = $this->set_layout_type( sanitize_text_field( $array['layout_type'] ) );
            }
            if( !empty( $array['layout_css'] ) || gettype( sanitize_text_field( $array['layout_css'] ) ) == "string" ){  
                $cssState = $this->set_css( sanitize_text_field( $array['layout_css'] ) ); 
            }
            if( !empty( $array['design_type'] ) ||  sanitize_text_field( !empty( $array['design_type'] ) )  ){  
                $cssState = $this->set_design_type( sanitize_text_field( $array['design_type'] ) ); 
            }

            if( $layoutState || $cssState ){
                $this -> message[] = '<div class="notice notice-success form-setting-notification"><p>'.PRC_db::message_string("layout_form_Successfully").'</p></div>';
            }

        }

        /**
        * layout type get function 
        */
        public function get_layout_type(){
            $type = $this->get_form_properties( $this->form_id, "layout_type" );
            if( !empty( $type )) {
                return $type;
            }else{
                return $this->settings['layout_type'];
            }
        }

        /**
        * layout inner_layout get function 
        */

        public function get_design_type(){
            $design_type = $this->get_form_properties( $this->form_id, "design_type" );
            if( !empty( $design_type )) {
                return $design_type;
            }else{
                return $design_type;
            }
        }

        /**
        * layout css get function 
        */

        public function get_css(){
            return $this->get_form_properties( $this->form_id, "layout_css" );
        }

        /**
        * layout form submit massage function 
        */

        public function getMessage(){
            return $this->message;
        }

        /**
        * layout type set Function   
        */

        private function set_layout_type( $data ){
            return $this->set_form_properties( $this->form_id, "layout_type", $data );
        }

          /**
        * layout inner layout set Function   
        */

        private function set_design_type( $data ){
            return $this->set_form_properties( $this->form_id, "design_type", $data );
        }

        
        /**
        * layout css add Function   
        */
        private function set_css( $data ){
            return $this->set_form_properties( $this->form_id, "layout_css", $data );    
        }

    }
    
}
?>