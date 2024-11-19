<?php
if( !defined( "PRC_PRE_BUILT_MODULE_PATH" ) ){
	define( "PRC_PRE_BUILT_MODULE_PATH" , plugin_dir_path( __FILE__ )  . 'includes/modules/' );
}

/* 
    find the folder using pattern *-module/*-module-class.php and include it 
    you can add new module here using this pattern 
*/
foreach ( glob( PRC_PRE_BUILT_MODULE_PATH."/*-module/*-module-class.php" ) as $key => $file) {
    if( file_exists( $file ) ){
        require_once $file;
    }
}
?>