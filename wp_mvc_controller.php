<?php 
include_once 'wp_mvc_object.php';

class WP_MVC_Controller extends WP_MVC_Object{

public function __construct(){
	
	foreach( get_class_methods($this) as $method ){
		if( '__construct' != $method ){
			if( $this->is_action( $method) ){
				//echo 'add_action(\''.$method.'\', array($this, \''.$method.'\'));';
				$action_name = str_replace('action_', '', $method);

				add_action("$action_name", array($this, "$method"));
				
			} else if( $this->is_filter( $method ) ){
				//echo 'add_filter(\''.$method.'\', array($this, \''.$method.'\'));';
				$filter_name = str_replace('filter_', '', $method);
				add_filter("$filter_name", array($this, "$method"));
			}
		}
	}
}// end __construct();







/**
 * Method checks to see if the first word of the method being called is 'filter'
 *
 * @param string $method_name the full name of the method to check
 * @return bool
 */
private function is_filter( $method_name ){
	if( 'filter' == substr($method_name, 0, 6) ){
		return true;
	} else {
		return false;
	}
}// end is_filter();


/**
 * Method checks to see if the first word of the method being called is 'action'
 *
 * @param string $method_name the full name of the method to check
 * @return bool
 */
private function is_action( $method_name ){
	if( 'action' == substr($method_name, 0, 6) ){
		return true;
	} else {
		return false;
	}
}// end is_action();



}