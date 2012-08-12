<?php
class WP_OOPlugin_CPT extends WP_OOPlugin_Object {


static $instances = array();
private $post_type_slug;
private $class_name;




function __construct(){

	add_action('init', array($this, 'register_post_type'));

	add_action('save_post', array($this, 'save_meta_box_data'), 10, 2);


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



/**
 * This method registers the Custom Post Type with WordPress
 */
public function register_post_type(){
	include_once 'libs/inflector.php';
	$class_name = get_class( $this );
	$this->class_name = $class_name;
	$human_class_name = Inflector::humanize( $class_name );
	$post_type_slug = strtolower( $class_name );
	$this->post_type_slug = $post_type_slug;
	$opts = array();


	$opts['labels']['name'] = (isset( $this->labels['name'] )) ? $this->labels['name'] : Inflector::pluralize( $human_class_name );
	$opts['labels']['singular_name'] = (isset( $this->labels['singular_name'] )) ? $this->labels['singular_name'] : Inflector::singularize( $human_class_name );
	$opts['labels']['add_new'] = (isset( $this->labels['add_new'] )) ? $this->labels['add_new'] : 'Add New ' . Inflector::singularize( $human_class_name );
	$opts['labels']['all_items'] = (isset( $this->labels['all_items'] )) ? $this->labels['all_items'] : 'View All ' . Inflector::pluralize( $human_class_name );
	$opts['labels']['add_new_item'] = (isset( $this->labels['add_new_item'] )) ? $this->labels['add_new_item'] : 'Add New ' . Inflector::singularize( $human_class_name );
	$opts['labels']['edit_item'] = (isset( $this->labels['edit_item'] )) ? $this->labels['edit_item'] : 'Edit ' . Inflector::singularize( $human_class_name );
	$opts['labels']['new_item'] = (isset( $this->labels['new_item'] )) ? $this->labels['new_item'] : 'New ' . Inflector::singularize( $human_class_name );
	$opts['labels']['view_item'] = (isset( $this->labels['view_item'] )) ? $this->labels['view_item'] : 'View ' . Inflector::singularize( $human_class_name );
	$opts['labels']['search_items'] = (isset( $this->labels['search_items'] )) ? $this->labels['search_items'] : 'Search ' . Inflector::pluralize( $human_class_name );
	$opts['labels']['not_found'] = (isset( $this->labels['not_found'] )) ? $this->labels['not_found'] : 'No ' . strtolower(Inflector::pluralize( $human_class_name )) . ' found.';
	$opts['labels']['not_found_in_trash'] = (isset( $this->labels['not_found_in_trash'] )) ? $this->labels['not_found_in_trash'] : 'No ' . strtolower(Inflector::pluralize( $human_class_name )) . ' found in Trash';
	$opts['labels']['parent_item_colon'] = (isset( $this->labels['parent_item_colon'] )) ? $this->labels['parent_item_colon'] : 'Parent ' . Inflector::singularize( $human_class_name ); 



	
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
	if( isset( $this->taxonomies ) ) $opts['taxonomies'] = $this->taxonomies;
	if( isset( $this->capabilities )) $opts['capabilities'] = $this->capabilities;
	if( isset( $this->has_archive )) $opts['has_archive'] = $this->has_archive;
	if( isset( $this->permalink_epmask )) $opts['permalink_epmask'] = $this->permalink_epmask;
	if( isset( $this->rewrite )) $opts['rewrite'] = $this->rewrite;
	if( isset( $this->query_var )) $opts['query_var'] = $this->query_var;
	if( isset( $this->can_export )) $opts['can_export'] = $this->can_export;
	

	register_post_type($post_type_slug, $opts);
	
	
	
}// end register_post_type();


/**
 * This method is the Register Meta Box call back
 */
public function create_meta_boxes(){

	foreach ( $this->fields as $field_name => $field_value) {
		$meta_box_callback_name = $this->get_meta_box_callback( $field_name, $field_value );
		$unique_id = strtolower( Inflector::singularize( $this->class_name ) ) . '_' . $field_name;
		$title = Inflector::humanize( Inflector::singularize( $field_name ) );
		$context = (is_array($field_value) && isset( $field_value['context'] )) ? $field_value['context'] : 'advanced';
		$priority = (is_array($field_value) && isset( $field_value['priority'] )) ? $field_value['priority'] : 'default';
		
	
		add_meta_box( $unique_id, $title, array($this, $meta_box_callback_name), $this->post_type_slug, $context, $priority, array($field_name, $field_value) );
		
		

	}
	
}// end create_meta_boxes();


public function save_meta_box_data( $post_id, $post ){

	if( $post->post_status != 'auto-draft' && $post->post_type == $this->post_type_slug ){

		$post_type_obj = get_post_type_object( $post->post_type );

		if( !current_user_can( $post_type_obj->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		foreach( $this->fields as $field_name => $field_info ){

			if( !isset( $_POST[$field_name.'_nonce'] ) || !wp_verify_nonce( $_POST[$field_name.'_nonce'], basename( __FILE__ ) ) ) {
				return $post_id;
			}

			$current_meta_value = get_post_meta( $post_id, $field_name, true );
			$new_meta_value = $_POST[$field_name];

			if( $new_meta_value && '' == $current_meta_value ){

				add_post_meta( $post_id, $field_name, $_POST[$field_name], true );

			}else if( $new_meta_value && $new_meta_value != $current_meta_value ){

				update_post_meta( $post_id, $field_name, $new_meta_value );

			}else if( '' == $new_meta_value && $field_name ){

				delete_post_meta( $post_id, $field_name, $current_meta_value );

			}



		}
	}
}// end save_meta_box_data;




private function get_meta_box_callback( $field_name, $field_value ){

	$type = (is_array( $field_value )) ? $field_value['type'] : $field_value;
	
	return 'create_default_' . $type . '_meta_box';
	
	

}// end get_meta_box_callback();

public function create_default_text_meta_box($object, $args){
	$field_name = $args['args'][0];
	$field_value = $args['args'][1];
	$class_names[] = Inflector::singularize( $object->post_type );
	$class_names[] = 'cusotm_meta_' . $field_name;
	$name_attr = Inflector::singularize( $object->post_type ) . '_' . $field_name;
	$description = (is_array( $field_value ) && isset( $field_value['description'] )) ? $field_value['description'] : false;
	$before = (is_array( $field_value ) && isset( $field_value['before'] )) ? $field_value['before'] : '';
	$after = (is_array( $field_value ) && isset( $field_value['after'] )) ? $field_value['after'] : '';

	$opts = $this->get_meta_box_options( $object, $args );

	if( method_exists($this, $opts['custom_method']) ){
		$this->{$opts['custom_method']}($object, $opts);
		return;
	}

	?>
	<div class="<?php echo $opts['class_names'] ?>">

		<?php WP_OOPlugin_CPT::nonce( $opts['field_name']) ?>
		<?php echo $opts['before'] ?>
		<input type="text" name="<?php echo $opts['field_name'] ?>" value="<?php echo get_post_meta($object->ID, $opts['field_name'], true) ?>" />
		<?php echo $opts['after'] ?>
		<?php if( $opts['description'] ): ?>
		<div class="custom_field_description"><?php echo $opts['description'] ?></div>
		<?php endif; ?>
	</div>
	<?php
}// end create_default_text_meta_box();


/**
 * outputs a select box for the current field
 */
public function create_default_select_meta_box( $object, $args ){
	$opts = $this->get_meta_box_options( $object, $args );

	if( method_exists($this, $opts['custom_method']) ){
		$this->{$opts['custom_method']}($object, $opts);
		return;
	}
	
	?>
	<div class="<?php echo $opts['classes'] ?>">
		<?php WP_OOPlugin_CPT::nonce( $opts['field_name'] ) ?>
		<?php echo $opts['before'] ?>
		<select name="<?php echo $opts['field_name'] ?>">
			<option value="">- Choose -</option>
			<?php foreach( $opts['field_value']['options'] as $key => $value ): ?>
			<option value="<?php echo $key ?>"><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo $opts['after'] ?>
		
		<?php if( $opts['description'] ): ?>
		
		<div class="custom_field_description"><?php echo $opts['description'] ?></div>
		
		<?php endif; ?>
	</div>
	<?php
	
}

/**
 * outputs a textarea for the current field
 */
public function create_default_textarea_meta_box( $object, $args ){
	$opts = $this->get_meta_box_options( $object, $args );

	if( method_exists( $this, $opts['custom_method'] )) {
		$this->{$opts['custom_method']}($object, $opts);
		return;
	}

	?>
	<div class="<?php echo $opts['classes'] ?>">
		<?php WP_OOPlugin_CPT::nonce( $opts['field_name'] ); ?>
		<?php echo $opts['before'] ?>
		<textarea name="<?php echo $opts['field_name'] ?>"></textarea>
		<?php echo $opts['after'] ?>

		<?php if( $opts['description'] ): ?>

		<div class="custom_field_description"><?php echo $opts['description'] ?></div>

		<?php endif; ?>
	</div>
	<?php


}// end create_default_textarea_meta_box()

/**
 * @param $object 
 * @param $args
 */
private function get_meta_box_options( $object, $args ){
	
	$return = array();
	$return['field_name'] = $args['args'][0];
	$return['field_value'] = $args['args'][1];
	$class_names[] = Inflector::singularize( $object->post_type );
	$class_names[] = 'cusotm_meta_' . $return['field_name'];
	$return['class_names'] = implode(' ', $class_names);
	$return['name_attr'] = Inflector::singularize( $object->post_type ) . '_' . $return['field_name'];
	$return['description'] = (is_array( $field_value ) && isset( $return['field_value']['description'] )) ? $return['field_value']['description'] : false;
	$return['before'] = (is_array( $field_value ) && isset( $return['field_value']['before'] )) ? $return['field_value']['before'] : '';
	$return['after'] = (is_array( $field_value ) && isset( $return['field_value']['after'] )) ? $return['field_value']['after'] : '';

	$return['custom_method'] = 'create_' . $return['field_name'] . '_meta_box';

	return $return;
}


static function nonce( $field_name ){
	wp_nonce_field( basename( __FILE__ ), $field_name . '_nonce' );
}// end wp_ooplugin_nonce;


}// end WP_OOPlugin_CPT class