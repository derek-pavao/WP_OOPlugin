<?php
/*
Plugin Name: OOPlugin
Description: This plugin adds MVC type features to a plugin authors tool belts. Please note this plugin doesn't "Do Anything on its own"
Version: 0.0.1
Author: Derek Pavao
Author URI: http://www.derekpavao.com
*/
class OOPlugin {


	function __construct(){
		include_once ABSPATH . 'wp-content/plugins/ooplugin/wp_mvc_controller.php';

		if( $active_plugins = get_option('active_plugins') ){
			foreach( $active_plugins as $plugin ){

				$this->instantiate_controllers( $plugin );

			}
		}
	}// end __construct();


	function instantiate_controllers( $plugin_file ){

		$plugin_directory = dirname( $plugin_file );

		if( 'ooplugin' == $plugin_directory ) return;
		
		$full_path_to_directory = ABSPATH . 'wp-content/plugins/' . $plugin_directory . '/controllers';
		if ( file_exists( $full_path_to_directory ) && $dir = opendir( $full_path_to_directory ) ) {

		    while (false !== ($file = readdir($dir))) {
		    	if( '.' != $file && '..' != $file ){
		    		include_once ABSPATH . 'wp-content/plugins/' . $plugin_directory . '/controllers/' . $file;
		        	list( $class_name, $extension ) = explode('.', $file, -1);
		        	
		        	$r = new ReflectionClass($class_name);
		        	
		        	$$class_name = $r->newInstance();
		        	
		    	}
		    }

		}

		
	}// end instantiate_controllers();

}
$ooplugin = new OOPlugin;

