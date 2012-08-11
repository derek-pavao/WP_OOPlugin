<?php
class WP_OOPlugin_CPT extends WP_OOPlugin_Object {


static $instances = array();




function __construct(){

	add_action('init', array($this, 'register_post_type'));


}// end __construct();


/**
 * This method handles creating the instances of the sub class. A Custom Post Type
 * class can only ever be instantiated once, or it would try to create multiple 
 * CPTs with the same name. If the CPT has already been created it just returns that instance.
 * This is known as a Singleton.
 */
public function create_instance( $class_name ){


	if( ! isset(self::$instances[$class_name]) && empty(self::$instances[$class_name]) ){
		$rc = new ReflectionClass( $class_name );
		self::$instances[$class_name] = $rc->newInstance();
	} else {
		return self::$instances[$class_name];
	}

}// end __initialize



public function register_post_type(){
	include_once 'libs/inflector.php';
	$class_name = get_class( $this );
	$post_type_slug = strtolower( $class_name );
	
	$opts = array(
		'labels' => array(
			'name' => Inflector::singularize( Inflector::humanize( $class_name ) )
		)
	);

	$opts['labels']['name'] = (isset( $this->labels['name'] )) ? $this->labels['name'] : Inflector::pluralize( Inflector::humanize( $class_name ));
	$opts['labels']['singular_name'] = (isset( $this->labels['singular_name'] )) ? $this->labels['singular_name'] : Inflector::singularize( Inflector::humanize( $class_name ));
	$opts['labels']['add_new'] = (isset( $this->labels['add_new'] )) ? $this->labels['add_new'] : 'Add New ' . Inflector::singularize( Inflector::humanize( $class_name ));


	if( isset( $this->taxonomies ) ) $opts['taxonomies'] = $this->taxonomies;
	if( isset( $this->capabilities )) $opts['capabilities'] = $this->capabilities;
	if( isset( $this->labels )) $opts['labels'] = $this->labels;
	if( isset( $this->description )) $opts['description'] = $this->description;
	if( isset( $this->public )) $opts['public'] = $this->public;
	if( isset( $this->exclude_from_search )) $opts['exclude_from_search'] = $this->exclude_from_search;
	if( isset( $this->publicly_queryable )) $opts['publicly_queryable'] = $this->publicly_queryable;
	if( isset( $this->show_ui )) $opts['show_ui'] = $this->show_ui;
	if( isset( $this->show_in_nav_menus )) $opts['show_in_nav_menus'] = $this->show_in_nav_menus;
	if( isset( $this->show_in_menu )) $opts['show_in_menu'] = $this->show_in_menu;
	if( isset( $this->show_in_admin_bar )) $opts['show_in_admin_bar'];
	if( isset( $this->menu_position )) $opts['menu_position'] = $this->menu_position;
	if( isset( $this->menu_icon )) $opts['menu_icon'] = $this->menu_icon;
	if( isset( $this->capability_type )) $opts['capability_type'] = $this->capability_type;
	if( isset( $this->map_meta_cap )) $opts['map_meta_cap'] = $this->map_meta_cap;
	if( isset( $this->hierarchical )) $opts['hierarchical'] = $this->hierarchical;
	if( isset( $this->supports )) $opts['supports'] = $this->supports;
	if( isset( $this->fields )) $opts['register_meta_box_cb'] = array($this, 'create_meta_boxes');
	

	register_post_type($post_type_slug, $opts);
	
	
	
}// end register_post_type();

public function create_meta_boxes(){

}// end create_meta_boxes();






}// end WP_OOPlugin_CPT class