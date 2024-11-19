<?php

if( !class_exists( "PRC_fields_module" ) ){

    class PRC_fields_module {

        /* To store modules data */
        private static $modules = array();

        /* Register Modules */
        public static function register_module( $module ){
            if( !empty( $module->getId() ) ){
                if( empty( self::$modules[ $module->getId() ] ) ){
                    self::$modules[ $module->getId() ] = $module;
                }
            }
        }

        /**
         * Get Module Using module using module id
         */
        public function get_module( $module_id ){
            return !empty( self::$modules[ $module_id ] ) ? self::$modules[ $module_id ] : false;
        }

        /* Retrive All Registered Modules */
        public static function get_modules(){
            return self::$modules;
        }

        /**
         *  get All registered modules
         */
        public static function get_modules_settings(){
            $array = array();
            $modules = self::get_modules();
            foreach ( $modules as $key => $value ) {
                $array[$key] = apply_filters( "get_pro_rate_cal_form_setting_fields", $value->getSettingFields(), $key ,$value );
            }
            return $array;
        }
    }
}
?>