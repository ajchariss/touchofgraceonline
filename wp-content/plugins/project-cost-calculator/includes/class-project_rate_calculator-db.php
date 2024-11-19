<?php
if( !class_exists( "PRC_db" ) ){
    class PRC_db{

        function _construct( ){

        }

        public function message_string($key) {
            $message_string = array(
                'layout_form_Successfully' => __('Layout saved successfully.',"project-cost-calculator"),
                'quotation_settings_successfully' => __('Settings saved successfully.',"project-cost-calculator"),
                'currency_setting_max' => __('Please select a minimum of one currency.',"project-cost-calculator"),
                'currency_setting' => __('Currency setting saved successfully.',"project-cost-calculator"),
                'settings_saved' => __( "Form updated successfully." , "project-cost-calculator"),
                'form_state' => __( "Form has been " , "project-cost-calculator"),
                'category_updated' =>  __("Category updated.","project-cost-calculator"),
                'category_allready' =>  __("Category slug already exists, add different category slug.","project-cost-calculator"),
                'category_invalid' => __("Category is invalid.", "project-cost-calculator"),
                'category_added' => __("Category added successfully.", "project-cost-calculator"),
                'category_response' => __("Response data in invalid or empty.","project-cost-calculator"),
                'form_updated' =>  __("Calculator updated successfully.","project-cost-calculator"),
                'elements_changes' => __("No changes in calculator elements.","project-cost-calculator"),
                'form_name_already' => __("Calculator title already exists.","project-cost-calculator"),
                'form_update' => __(" Calculator title updated successfully.","project-cost-calculator"),
                'form_is_not_exist' => __("Requested form id is invalid or form is not exist.","project-cost-calculator"),
                'form_saved' => __("Form saved.","project-cost-calculator"),
                'currency_settings_save' => __("Currency settings saved successfully.","project-cost-calculator"),
                'form_saved_add_fields' => __("Calculator added successfully, please add fields to activate the calculator. ","project-cost-calculator"),
                'form_not_saved_already_exist' => __("Calculator not saved, Calculator is already exist or somethings went wrong.","project-cost-calculator"),
                'form_request_varified' =>  __("Form request submission invalid, _wpnonce not verified.","project-cost-calculator"),
                'js_message'=> array(
                    'form_name' =>  __("Please enter calculator name.","project-cost-calculator"),
                    'form_name_empty' =>  __("Calculator title is invalid or empty, please enter valid calculator title.","project-cost-calculator"),
                    'form_id_specified' =>  __("Form id is not specified.","project-cost-calculator"),
                    'form_deleted' =>  __("Form deleted successfully.","project-cost-calculator"),
                    'module_default_quantity' =>  __("Default quantity must be less then maximum value and more then minimum value.","project-cost-calculator"),
                    'please_enter_value' =>  __("Please Enter valid value.","project-cost-calculator"),    
                ),
                "tip_for_add_field" => __("Select the element from the right-hand side column to start the building of the calculator.","project-cost-calculator"),
                "form_id_is_not_valid" => __( "Form Id is not valid", "project-cost-calculator" ),
                "form_is_is_not_set" => __( "Form Id is not set", "project-cost-calculator" ),
                "email_not_sent_something_gone_wrong" => __( "Email not sent, somethings gone wrong", "project-cost-calculator" ),
                "quotation_has_been_send" => __( "Quotation has been send through email", "project-cost-calculator" ),
                "there_are_some_issue_with_email" => __( "There are some issue with email sending.", "project-cost-calculator" ),
                "form_id_is_invalid" => __( "Form Id is not valid.", "project-cost-calculator" ),
                "form_id_is_not_set" =>  __( "Form Id is not set.", "project-cost-calculator" ),
                "issue_with_email_sending" => __( "There are some issue with email sending.", "project-cost-calculator" ),
            );
            return $message_string [$key];
        }

    

        /* Generate Shortcode using form or post object */
        public static function get_shortcode( $form ){
            $form_obj = get_post( $form );
            if( !empty( $form_obj ) ):
                return "[rate-calculator-form id=$form_obj->ID ]";
            endif;
        }

        /**
         * Create New Form
         */
        protected function save_new_form($title = null , $json_values = null ){
            if( !empty( $title ) ){
                $my_post = array(
                    'post_title'    => wp_strip_all_tags($title),
                    'post_status'   => 'publish',
                    'post_type'     => PRC_POST_TYPE,
                );
                if( post_exists( wp_strip_all_tags( $title ) ) ){
                    return false;
                } else {
                    return wp_insert_post( $my_post );
                }
            }
            return false;
        }

        /**
         * Remove form related category
         */
        protected function remove_form_category( $form_id ){
            $category = $this->get_form_category( $form_id );
            if( !empty( $category ) ){
                $all_child_cat = get_terms(
                    array(
                        "taxonomy" => PRC_CATEGORY,
                        "parent" => $category['term_id'],
                        'hide_empty' => false,
                    )
                );
                foreach ( $all_child_cat as $key => $value ) {
                    wp_delete_term( $value -> term_id, PRC_CATEGORY ); 
                }
                return wp_delete_term( $category['term_id'], PRC_CATEGORY );
            }
        }

        /**
         * Get form related category
         */
        protected function get_form_category( $form_id ){
            $form_cat_id = get_post_meta( $form_id, "calculator_form_category", true );
            if( !empty( $form_cat_id ) ){
                $category = $this->get_category( "ID", $form_cat_id );
                if( !empty( $category ) ){
                    return $category;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Check form form name exist or not
         */
        protected function is_form_name_exist( $form_name ){
            return get_page_by_title( $form_name, OBJECT, PRC_POST_TYPE );
        }

        /**
         * Save Form name catego
         */
        protected function save_form_category( $form_id, $category ){
            $post_category = wp_insert_category(
                array(  
                    "cat_name" => $category,
                    "category_nicename" => sanitize_title( $category."-".$form_id ),
                    "taxonomy" => PRC_CATEGORY,
                    "category_parent" => 0,
                )
            );
            if( !empty($post_category) ){
                update_post_meta( $form_id, "calculator_form_category", $post_category );
            }
            return $post_category;
        }

        /**
         * Update form category
         * 
         */
        protected function update_form_category( $form_id, $form_name ){
            $category_id = get_post_meta( $form_id, "calculator_form_category", true);
            if( !empty( $category_id ) ){
                $cat = $this->get_category( "ID", $category_id );
                if( !empty( $cat ) ){
                    $args = array(
                        "category-name" => $form_name,
                        "id" => $category_id,
                        "category-slug" =>  $cat['slug'],
                    );
                    return $this->insert_or_update_category( $args );
                }else{
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * save calculator properties to post meta
         */
        protected function save_calculator_properties( $form_id, $data ){
            return update_post_meta( $form_id, "calculator_form_properties", $data );
        }

        /**
         * Get calculator properties from post meta
         */
        public function get_calculator_properties( $form_id ){
            $properties = get_post_meta( $form_id, "calculator_form_properties", true );
            if( is_array( $properties ) ){
                return $properties;
            }else{
                return false;
            }
            //return get_post_meta( $form_id, "calculator_form_properties", true );
        }

        /**
         * Get All forms
         */
        protected function get_all_forms(){
            $args = array(
                'post_type'        => PRC_POST_TYPE,
                'numberposts'      => -1,
            );
            return get_posts( $args );
        }

        /* Remove Form */
        protected function remove_form( $id ){
            return wp_delete_post( $id, true );
        }

        /* Check for form allready exist ? */
        protected function form_exist( $id ){
            return get_post_status( $id );
        }

        /* category handle */
        /* craete new category or update category */
        protected function insert_or_update_category( $args ){
            $categoryArray = array(
                "taxonomy" => PRC_CATEGORY,
                "cat_name" => sanitize_text_field( $args['category-name'] ),
                "category_description" => isset( $args['description'] ) && !empty( sanitize_text_field( $args['description'] ) ) ? sanitize_text_field( $args['description'] ) : null,
                "category_nicename" => sanitize_text_field( $args['category-slug'] ),
                "category_parent" => !empty ( $args['parent'] ) ? $args['parent'] : 0,
                "cat_ID" => !empty( $args['id'] ) ? $args['id'] : 0 ,
            );
            return wp_insert_category($categoryArray);

        }

        /* check for category exist ? */
        protected function is_category_exist( $category, $parent = null ){
            return term_exists( $category, PRC_CATEGORY, $parent);
        }

        /* get category */
        protected function get_category( $field, $value ){
            if( $term = get_term_by( $field, $value, PRC_CATEGORY, ARRAY_A) ){
                return array(
                    "name" => $term["name"],
                    "slug" => $term["slug"],
                    "description" => $term["description"],
                    "term_id" => $term["term_id"],
                    "parent" => $term["parent"],
                );
            } else {
                return false;
            }
        }

        /* get all categories, return ids */
        protected function get_all_categories(){
            return get_terms( 
                    array(
                        'taxonomy' => PRC_CATEGORY,
                        'hide_empty' => false,
                        'fields' => "ids"
                    ) 
            );
        }

        /**
         * Get All category as well
         */
        protected function get_all_categories_parent( ){
            return get_terms( array(
                'taxonomy' => PRC_CATEGORY,
                'hide_empty' => false,
            ) );
        }

        /**
         * Static function for get category id parent exist then return child category based on argument
         */
        public static function get_category_list( $parent = null ){
            $args = array(
                'taxonomy' => PRC_CATEGORY,
                'hide_empty' => false,
            );
            if( !empty( $parent )){
                $args['parent'] = $parent;
            }
            return get_terms( $args );
        }

        /* Remove category from database */
        protected function delete_category( $term_id ){
            return wp_delete_term( $term_id, PRC_CATEGORY );
        }

        /* Get current form state */
        public function get_form_state( $formId , $update = false){
            return get_post_meta( $formId , "calculator_form_state", true);
        }

        /* Set form state */
        protected function set_form_state( $formId, $state = false){
            if( $state == true ){
                return update_post_meta( $formId, "calculator_form_state", "activated" );
            } else {
                return update_post_meta( $formId, "calculator_form_state", "deactivate" );
            }
        }

        //get form post if exist by id
        public function get_form( $form_id ){
            $form = get_post( $form_id );
            if( isset( $form->post_type ) && !empty( $form->post_type ) ){
                if( $form->post_type == PRC_POST_TYPE ){
                    return $form;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        /**
         * Update form or post
         * arg data should be array
         */
        protected function update_form( $data ){
            return wp_update_post( $data, false, false );
        }
    
        /**
         *  Get form field properties 
         */
        protected function get_form_field_properties( $form_id ){
            return get_post_meta( $form_id , "calculator_form_field_properties", true);
        }

        /**
         *  get form properties from meta as per key argument
         */
        protected function get_form_properties( $form_id, $key ){
            return get_post_meta( $form_id, $key, true);
        }

        /**
         * Set form properties to meta as per key and data
         */
        protected function set_form_properties( $form_id, $key, $data ){
            return update_post_meta( $form_id, $key, $data );
        }

        /**
         * insert data to table
         */
        protected function insert_form_entries($form_id, $content = ""){
            global $wpdb;
            $table = PRC_DB_PREFIX."form_entry";
            $data = array('form_id' => $form_id, 'form_details' => $content);
            $format = array('%d','%s');
            $wpdb->insert($table,$data,$format);
            return $wpdb->insert_id;
        }

        /**
         * Get all data from table
         */
        protected function get_form_entries($form_ID){
            global $wpdb;
            $table = PRC_DB_PREFIX."form_entry";
            return $results = $wpdb->get_results( 
                $wpdb->prepare("SELECT * FROM $table WHERE form_id=%d", $form_ID) 
            );
        }
    
        /**
         * save Option data
         */
        protected function save_option_data( $key, $data ){
            return update_option( $key, $data );
        }

        /**
         * Get Option data
         */
        public function get_option_data( $key ){
            return get_option( $key );
        }
    }
}
?>