<?php
class WP_MVC_Object {

	protected function render( $view = '', $data = array() ){
		if( is_array($view) ){
			$data = $view;
			$view = '';
		}

		$current_view = ( $view ) ? $view.'.php' : $this->get_default_view_name().'.php';

		$calling_class_directory = $this->get_view_directory();

		
		if( is_array($data) && !empty($data) ){
			foreach( $data as $key => $value) { $$key = $value; }
		}

		include($calling_class_directory.'/'.$current_view);
	
	}// end render();


	private function get_view_directory(){
	    $e = new Exception();
	    $trace = $e->getTrace();
	    //position 0 would be the line that called this function so we ignore it
	    $call = $trace[1];

	    return dirname(dirname($call['file'])).'/views';
	}// end get_view_directory();

	

	private function get_default_view_name(){
		$e = new Exception();
	    $trace = $e->getTrace();
	    //position 0 would be the line that called this function so we ignore it
	    $call = $trace[2];
	    return $call['function'];
	}





}