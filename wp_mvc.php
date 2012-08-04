<?php
/*
Plugin Name: WP_MVC
Description: This plugin adds MVC type features to a plugin authors tool belts. Please note this plugin doesn't "Do Anything on its own"
Version: 0.0.1
Author: Derek Pavao
Author URI: http://www.derekpavao.com
*/

add_action('init', 'wp_mvc_init', 1);
function wp_mvc_init(){

	include_once ABSPATH . 'wp-content/plugins/wp_mvc/wp_mvc_controller.php';
}// end wp_mvc_init();