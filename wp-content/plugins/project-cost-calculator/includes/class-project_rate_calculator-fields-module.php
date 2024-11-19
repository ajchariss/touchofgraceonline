<?php
if( !class_exists( "PRC_module" ) ){
    class PRC_module extends PRC_db{

        /**
         * Module name
         */
        protected $name; 

        /**
         * Module Icon URL or Path
         */
        protected $icon;

        /**
         * Module Unique ID
         */
        protected $id;

        /**
         * Modules Settings fields which will help to build calsulator field
         */
        protected $settings;

        /**
         * set or update setting fields as per slug
         */
        protected function setSettingField($field_slug,$field){
            $this->settings['field'][$field_slug] = $field;
        }

        /**
         * Get Module ID
         */
        public function getId(){
            return $this->id;
        }

        /**
         * Get Icon URL
         */
        public function getIconUrl(){
            return $this->icon;
        }

        /**
         * Get Setting Fields
         */
        public function getSettingFields(){
            return $this->settings['field'];
        }

        /**
         * Get Module name
         */
        public function getName(){
            return $this->name;
        }

        
        /**
         * set Module ID
         */
        protected function setModuleID($id){
            $this->id = $id;
        }
    
        /***
         * Set module name
         */
        protected function setModuleName($name){
            $this->name = $name;
        }
    
        /**
         * Set Module Icon URL
         */
        protected function setModuleIconUrl($url){
            $this->icon = $url;
        }

        /**
         * Render fields on front end
         * if child class has no field or render method then this method will call 
         */
        public function render($data){
            return __( "Invalid Field Module.", "project-cost-calculator" );
        }
    }
}
?>