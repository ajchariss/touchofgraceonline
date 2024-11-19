<?php
if( !class_exists( 'PRC_dropdownModule' ) ){

    class PRC_dropdownModule extends PRC_module {

        function __construct(){

            $this->setModuleID('dropdown');
            $this->setModuleName("Dropdown");
            $this->setModuleIconUrl(plugin_dir_url(__FILE__)."icon/dropdown-icon.svg");

            $this->setSettingField( "label_name", array(
                "name" => "Field Name",
                "element" => "input",
                "attributes" => array(
                    "name" => "label_name",
                    "type" => "text",
                    "placeholder" => "Enter Field Name",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                    "required" => true,
                )
            ) );

            $this->setSettingField( "option", array(
                "name" => "Choice",
                "element" => "choice",
                "attributes" => array(
                    "name" => "option",
                    "required" => true,
                    "data-validation" => "prevantMinusValueForChoice",
                    "default_value" => false,
                )
            ) );

            $this->setSettingField( "tooltip", array(
                "name" => "Tooltip",
                "element" => "input",
                "attributes" => array(
                    "name" => "tooltip",
                    "placeholder" => "Text for tooltip",
                    "class" => "simple_input_setting_field",
                    "id" => "simple_input_setting_field",
                    "type" => "text",
                )
            ) );

            $this->setSettingField( "logic", array(
                "name" => "Logical Conditions",
                "element" => "input",
                "status" => "hide",
                "attributes" => array(
                    "name" => "Logic",
                    "placeholder" => "Text for Logic",
                    "class" => "simple_Logic_setting_field",
                    "id" => "simple_Logic_setting_field",
                    "type" => "checkbox",
                    "value" => "no",
                )
            ) );

            $this->setSettingField( "elements_state", array(
                "name" => "This field if",
                "element" => "select",
                "attributes" => array(
                    "name" => "elements_state",
                    "placeholder" => "Elements State",
                    "class" => "elements_state_setting_field",
                    "id" => "elements_state_setting_field",
                    "type" => "select",
                    "layout" => "half",
                    "list" => array( "show" => "Show", "hide" => "Hide" ,"lock" => "Lock","unlock" => "Unlock"),
                )
            ) );

            $this->setSettingField( "elements_state_if", array(
                "name" => "of the following match:",
                "element" => "select",
                "attributes" => array(
                    "name" => "elements_state_if",
                    "placeholder" => "Elements State",
                    "class" => "elements_state_if_setting_field",
                    "id" => "elements_state_if_setting_field",
                    "type" => "select",
                    "layout" => "half",
                    "list" => array( "all" => "All", "any" => "Any"),
                )
            ) );

            $this->setSettingField( "elements_condition", array(
                "name" => "",
                "element" => "elements_condition",
                "attributes" =>array(
                    "elements_select" => array(
                    "name" => "elements_select",
                    "placeholder" => "Elements select",
                    "class" => "elements_select_setting_field ",
                    "id" => "elements_select_setting_field",
                    "type" => "select",
                    "element" => "select",
                    "list" => array( "select" => "select"),
                    ),
                    "elements_select_condition" => array(
                        "name" => "elements_select_condition",
                        "placeholder" => "Elements select condition",
                        "class" => "elements_select_condition_setting_field ",
                        "id" => "elements_select_condition_setting_field",
                        "type" => "select",
                        "element" => "select",
                        "list" => array( "is" => "Is","is not" => "Is not"),
                    ),
                    "elements_select_value" => array(
                        "name" => "elements_select_value",
                        "placeholder" => "value",
                        "class" => "elements_value_setting_field",
                        "id" => "elements_select_value_setting_field",
                        "type" => "text",
                        "element" => "input",
                        "clone" => "true",
                    ),
                )

            ) );
          
        }

        public function render( $data ){
            ob_start();
            $file = plugin_dir_path( __FILE__ )."template/dropdown.php";
            if( file_exists( $file ) ){
                include $file;
            }
            return ob_get_clean();
        }
    }
}

PRC_fields_module::register_module(new PRC_dropdownModule());
?>