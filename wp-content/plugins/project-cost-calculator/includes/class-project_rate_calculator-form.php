<?php

if( !class_exists( "PRC_form" ) ){

    class PRC_form extends PRC_db{

        /**
         * Current Form ID
         */
        private $form_id;

        /**
         * Current form name
         */
        private $form_name;

        /**
         * formcount for current seession 
         * every time new object will create thic count change or increase by one to specify uniqe id for form
         */
        private static $formcount;

        /**
         * Specify current form id or slug
         */
        private $current_form_id;

        /**
         * form properties
         */
        private $form_properties;

        /**
         * form state
         */
        private $form_state;

        /**
         * form ir post object
         */
        private $form;

        /**
         * current form module besed on properties
         */
        private $module;

        /**
         * Not in use
         */
        private $temp;

        /**
         * custom form settings
         */
        private $custom_form;

        /**
         * State of form name
         */
        public $isFormNameShowState;
        


        function __construct( $form_id, $form_name = null ){

            /* increase count by 1 */
            self::$formcount += 1;
            /* specify count to set uniq form id to form object */
            $this->current_form_id = "pro_rate_cal_".self::$formcount;     
            /* db object to perform db operations */
            $db = new PRC_db();
            $this->form = $db->get_form( $form_id );
            if( $this->form ){
                $this->set_form_id( $this->form->ID );
                $this->form_properties = $db->get_calculator_properties( $this->form_id );
                $this->form_state = $db->get_form_state( $this->form_id );
                $this->set_form_name( $this->form->post_title );
            }        
            $this->module = new PRC_fields_module();
            $this->custom_form = new PRC_FormField( $this->form_id );
            /**
             * Set initially form name shoe
             */
            $this->isFormNameShowState = true;

        }

        /**
         * Get custom form settings
         */
        private function get_custom_form(){
            return $this->custom_form;
        }

        /**
         * Get template by key and template name
         */
        private function get_template($key = null, $template){
            $file = PRC_TEMPLATE_DIR.$key.$template.".php";
            if(file_exists( $file )){
                include $file;
            }
        }

        /**
         * set current form id
         */
        private function set_form_id( $id ){
            $this->form_id = $id;
        }

        /**
         * get current form id
         */
        public function get_form_id(){
            return $this->form_id;
        }

        /**
         * set form name
         */
        private function set_form_name( $name ){
            $this->form_name = $name;
        }

        /**
         * Sort fields by orderattributes
         */
        private function sort_array_by_order(){
            $fields = array();
            if( is_array( $this->form_properties ) ){
                foreach ($this->form_properties as $key => $value) {
                    if( !empty($value['order']) || ( $value['order'] == 0 ) ){
                        $fields[$value['order']] = $value;
                    }
                }
            }
            ksort($fields);
            return $fields;
        }

        /**
         * Generate category column
         *  */ 
        private function category_column( $data ){
            $result = array();
            $recentCategory = null;
            $rowspan = 0;
            $tempkey = 0;
            foreach ( $data as $key => $value ) {
                if( isset( $value["settings"]['category_field'] ) ){
                        $result[$key]['category'] = $value["settings"]['category_field'];	
                    if( $result[$key]['category'] != $recentCategory ){
                        $result[$tempkey]['rowspan'] = $rowspan;
                        $rowspan = 0;
                        $result[$key]['rowspan'] = $rowspan;
                        $recentCategory = $result[$key]['category'];
                        $tempkey = $key;
                        $result[$key]['hasCategoryChanged'] = true;
                        $rowspan ++;
                    }else if(  $result[$key]['category'] == $recentCategory ){
                        $rowspan ++;
                        $result[$tempkey]['rowspan'] = $rowspan;
                    }
                }else{
                    $result[$key]['hasCategoryChanged'] = true;
                    $rowspan ++;
                    $result[$tempkey]['rowspan'] = $rowspan;
                }
            }
            return $result;
        }

        /* render fields */
        private function render_field( $data ){
            $field = $this->module->get_module( $data['module_id'] );
            if( !empty($field) ):
                return $field->render( $data );
            endif; 
        }  

        /* return label and field name */
        private function get_label_and_field_name(){
            $data = $this->sort_array_by_order();
            $arrayValue = array();
            foreach ( $data as $key => $value ) {
                if(  isset( $value['settings']['label_name'] ) ){
                    $arrayValue[sanitize_title_with_dashes( $value['settings']['label_name'] )] = sanitize_text_field( $value['settings']['label_name'] );
                }
            }
            return $arrayValue;
        }

        /* return ret of fields */
        private function get_rate_of_field(){
            $arrayValue = array();
            foreach ( $this->form_properties as $key => $value ) {
                if( isset( $value['settings']['rate'] ) ){
                    $arrayValue[sanitize_title_with_dashes($value['settings']['label_name'])] = sanitize_text_field($value['settings']['rate']);
                }
            }   
            return $arrayValue;
        }

        /* render form */
        function render_form(){
            ob_start();
            if( $this->has_fields() ){
                $this->get_template('/view/', "main_container");
            }else{
                printf( "<p style='text-align:center;' >%s</p>", __("The form has been disabled", "project-cost-calculator") );
            }
            echo ob_get_clean();
        }

        /** return sorted properties */
        function get_sorted_properties(){
            $orderData = array();
            foreach ($this->form_properties as $key => $value) {
                $orderData[$value["order"]] = $value;
            }
            ksort( $orderData );
            return $orderData;  
        }

        /* check for ha fields ? */
        function has_fields(){
            if( !empty($this->form_properties) ){
                return true;
            }else{
                return false;
            }
        }

        public function isFormNameShow( $state = null ){
            if( $state == false ){
                $this->isFormNameShowState = false;    
            }else if( $state == true ){
                $this->isFormNameShowState = true;  
            }  
            return $this->isFormNameShowState;
        }   
    }
}
?>