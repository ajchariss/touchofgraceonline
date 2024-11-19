<?php
if( !class_exists( "PRC_category" ) ){

    class PRC_category extends PRC_db{

        public function __construct() {
            
        }
        /* this function operate update and delete category operation on query request */
        public function load_operations(){
            if( isset( $_REQUEST['action'] ) ){
                if( sanitize_text_field( $_REQUEST['action'] ) == "delete" ){
                    if( isset( $_REQUEST['id'] ) &&  ( !empty( sanitize_text_field( $_REQUEST['id'] ) ) ) ){
                        $this->delete_category( sanitize_text_field( $_REQUEST['id'] ) );
                    }
                }
            }
        }
    }
}
?>