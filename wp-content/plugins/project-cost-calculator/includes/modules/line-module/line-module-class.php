<?php
if( !class_exists( 'PRC_LineModule' ) ){
    class PRC_LineModule extends PRC_module {
        

        function __construct(){

            $this->setModuleID('line');
            $this->setModuleName("Divider Line");
            $this->setModuleIconUrl(plugin_dir_url(__FILE__)."icon/line.svg");

            $this->setSettingField( "vertical_padding", array(
                "name" => "Vertical padding",
                "element" => "input",
                "attributes" => array(
                    "name" => "vertical_padding",
                    "type" => "number",
                    "placeholder" => "Set vertical padding in (px)",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                    "layout" => "half",
                )
            ) );

            $this->setSettingField( "horizontal_padding", array(
                "name" => "Horizontal padding",
                "element" => "input",
                "attributes" => array(
                    "name" => "horizontal_padding",
                    "type" => "number",
                    "placeholder" => "Set horizontal padding in (px)",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                    "layout" => "half",
                )
            ) );

            $this->setSettingField( "border", array(
                "name" => "Set border size",
                "element" => "input",
                "attributes" => array(
                    "name" => "border",
                    "type" => "number",
                    "placeholder" => "Set border in (px)",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                    "required" => true,
                )
            ) );

            $this->setSettingField( "color", array(
                "name" => "Set border color",
                "element" => "input",
                "attributes" => array(
                    "name" => "color",
                    "type" => "color",
                    "placeholder" => "Set border color",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                )
            ) );

        }

        public function render($data){
            ob_start();
            $file = plugin_dir_path( __FILE__ )."template/line.php";
            if( file_exists( $file ) ){
                include $file;
            }
            return ob_get_clean();
        }
    }
}
    PRC_fields_module::register_module(new PRC_LineModule());

?>