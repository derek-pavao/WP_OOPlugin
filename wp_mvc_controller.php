<?php 
include_once 'wp_mvc_object.php';

class WP_MVC_Controller extends WP_MVC_Object{

public function __construct(){
	
	$this->call_wp_actions_and_filters( get_class_methods($this) );
	
}// end __construct();




/*********************************************************
**			Private Methods Beyond This Point 			**
*********************************************************/

private function call_wp_actions_and_filters( $methods ){
	

	foreach( $methods as $method ){
		if( '__construct' != $method ){
			if( $this->is_action( $method) ){

				$action_name = $this->get_action_name( $method );
				add_action("$action_name", array($this, "$method"));
				
			} else if( $this->is_filter( $method ) ){
				
				$filter_name = $this->get_filter_name( $method );
				add_filter("$filter_name", array($this, "$method"));

			}
		}
	}

}// end call_wordpress_actions_and_filters();

/**
 * Method takes the name of the method being called and parses it to find out
 * the filter name.
 *
 * @param string $method_name the full name of the method being called
 * @return string the name of the action to call the method on.
 */
private function get_filter_name( $method_name ){
	$method_arr = explode('__', $method_name, 2);
	return str_replace('filter_', '', $method_arr[0]);
}// end get_filter_name();


/**
 * Method takes the name of the method being called and parses it to find out
 * the action name.
 * 
 * @param string $method_name the full name of the method being called
 * @return string the name of the action to call the method on
 */
private function get_action_name( $method_name ){
	$method_arr = explode('__', $method_name, 2);
	return str_replace('action_', '', $method_arr[0]);
}// get_action_name();




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