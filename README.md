__IF YOU STUMBLE ACROSS THIS REPOSITORY, I APPOLOGIZE BUT THE DOCUMENTATION IS NOT COMPLETE AND I WILL BE WORKING ON IT MORE. PLEASE CHECK BACK SOON__

WP_OOPlugin
===========
__NOTE:__ This plugin is no where near production ready at this time. It is only posted here on GitHub so I may get feedback from plugin authors in the community! Because I am new to WordPress development it would be silly of me to take this project any further without getting input from other developers.

Table of Contents:
------------------
* [What is WP_OOPlugin?](#what-is-wp_ooplugin)
* [Why WP_OOPlugin?](#why-wp_ooplugin)
* [Directory Structure](#directory-structure)
* [How to define custom post types](#how-to-define-custom-post-types)

- - - 
  
What is WP_OOPlugin?
-------------------
[Back to top](#wp_ooplugin)  
WP_OOPlugin is a WordPress plugin intended to be used by plugin authors to help ease and speed up plugin development.  
[Back to top](#wp_ooplugin)
  
Why WP_OOPlugin?
---------------
[Back to top](#wp_ooplugin)  
I am new to WordPress. Most of my experience, until now is with CakePHP, a RoR (Ruby on Rails) like framework for PHP. Recently, in my professional life, I have been working with WordPress and there are a few things about writing a WordPress plugin I think could be better, so I'd like to change them!

In the CakePHP community there are two very important programming principles that I think could be implemented better in WordPress.

1. Don't Repeat Yourself (DRY)
2. Convention Over Configuration  
  
[Back to top](#wp_ooplugin)

Directory Structure
-------------------
[Back to top](#wp_ooplugin)  
WP_OOPlugin expects your plugins to have a specific directory structure, it is as follows:

* \<YOUR_PLUGIN_DIR_NAME\>
    * custom_post_types/
    * controllers/
    * views/
    * \<YOUR_MAIN_PLUGIN_FILE\>.php

__custom_post_types__:  
The custom_post_types directory contains class files that define WordPress custom post types and options for those post types.

__controllers__:  
The controllers directory contains classes that implement your wordpress action_hooks and filter_hooks.

__views__:  
The views directory contains view files that contain mostly html with bits of php speckled throughout them.
View files are called from custom_post_type classes or controller classes so you no longer have to close your php tag
( ?> ) and output html in the middle of your class file and re-open your php tag ( <?php ) again. Instead you can
render a view file passing in variables to be used in the view file. More on this later.

__\<YOUR_MAIN_PLUGIN_FILE\>.PHP__:  
This file is required for WordPress to recognize your plugin. It mostlikely will only contain your plugin comment
to tell WordPress meta data about your plugin.  

```php

/**
 * Plugin Name: YOUR PLUGIN NAME
 * Description: Some details about what your plugin does
 */

```  
[Back to top](#wp_ooplugin)

How To Define Custom Post Types.
------------------------
[Back to top](#wp_ooplugin)  
I feel like defining custom post types in WordPress has me repeating my self a lot, defining the output for meta boxes,
saving the data etc. With WP_OOPlugin I try to define reasonable defaults for a lot of this stuff while still making the 
defaults customizable.

__File Name:__  
Your file name should be named the plural version of whatever you want to call your custom post type with the 
first letter being a capital letter. i.e. Employees.php

__Class Name:__
Your class name should also be the plural version of whatever you want to call your custom post type. Your class must
also extend WP_OOPlugin_CPT.
```php
<?php
class Employees extends WP_OOPlugin_CPT {
  // define your custom post type here
}
?>
```

A custom post type is defined with WP_OOPlugin by defining instance variables within your class. Many of these instance
variables correspond directly to the arguments passed to WordPress' register_post_type() function (documentation found
[here](http://codex.wordpress.org/Function_Reference/register_post_type)). In addition to those instance variables,
WP_OOPlugin also has some of it's own instance variables you can define to help define your custom post type. (For now,
this documentation is going to concentrate on those WP_OOPlugin specific variables).

__DEFINING CUSTOM META BOXES AND CUSTOM FIELDS:__  
This is where WP_OOPlugin can come in very handy. Your custom post type class has an instance variable called $metaboxes.
$metaboxes is a multidimensional associative array that defines both your metaboxes and their containing custom fields.

In $metaboxes the first key is the name of the meta box, and it's value is an array that defines the custom fields
within that meta box. It's key is the name of the custom field and it's value is the definition of the custom field.
It can be a string ('text' for a text field) or an array of key value pairs defining a more complicated custom field.

I realize this can be a little confusing trying to explain in words so how about an example! In this following example
we are going to define a custom post type for Employees with two meta boxes, one for "Personal Info" and another for 
"Address" info. The Personal Info meta box will have two custom fields, "First Name" and "Last Name". The Address
meta box will contain custom fields for "Street", "City" and "State". The "Street" and "City" custom fields will be
simple text boxes, but the "State" custom field will be a select box.

__NOTE:__ WP_OOPlugin currently only supports defining text fields and select boxes as custom fields but will be
extended in the future to handle radio buttons, checkboxes, textareas etc.

```php
<?php
class Employees extends WP_OOPlugin_CPT {
  
  	// This $public instance variable corressponds directly to the public argument given to WordPress' register_post_type()
  	protected $public = TRUE;
  
	// This $supports instance variable corressponds directly to the public argument given to WordPress' register_post_type()
	protected $supports = array('title');

  	// The $mteaboxes instance variable is where WP_OOPlugin specific instance variables can come in handy
	protected $metaboxes = array(
		'personal_info' => array(
			'first_name' => 'text',
			'last_name' => 'text'
		),
		'address' => array(
			'street' => 'text',
			'city' => 'text',
			'state' => array(
				'type' => 'select',
				'options' => array(
					'MA' => 'Massachusetts',
					'RI' => 'Rhode Island',
					'CT' => 'Connecticut',
				),
				'label' => FALSE
			)
		)
	);

}
?>
```

From the few lines defined in your Employees class, WP_OOPlugin will create the custom post type in WordPress
adding it to the wp-admin because the $public instnce variable was set to true. It will add custom metaboxes and custom
fields to your add and edit screens. When those forms are submitted WP_OOPlugin will handle creating, updating, and 
deleting post meta where appropriate.  
[Back to top](#wp_ooplugin)

To Be Continued...
------------------







