__IF YOU STUMBLE ACROSS THIS REPOSITORY, I APPOLOGIZE BUT THE DOCUMENTATION IS NOT COMPLETE AND I WILL BE WORKING ON IT MORE. PLEASE CHECK BACK SOON__

WP_OOPlugin
===========
__NOTE:__ This plugin is no where near production ready at this time. It is only posted here on GitHub so I may get feedback from plugin authors in the community! Because I am new to WordPress development it would be silly of me to take this project any further without getting input from other developers.
- - - 
  
What is WP_OOPlugin?
-------------------
WP_OOPlugin is a WordPress plugin intended to be used by plugin authors to help ease and speed up plugin development.

  
Why WP_OOPlugin?
---------------
I am new to WordPress. Most of my experience, until now is with CakePHP, a RoR (Ruby on Rails) like framework for PHP. Recently, in my professional life, I have been working with WordPress and there are a few things about writing a WordPress plugin I think could be better, so I'd like to change them!

In the CakePHP community there are two very important programming principles that I think could be implemented better in WordPress.

1. Don't Repeat Yourself (DRY)
2. Convention Over Configuration


Directory Structure
-------------------
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

Define Custom Post Types
------------------------
I feel like defining custom post types in WordPress has me repeating my self a lot, defining the output for meta boxes,
saving the data etc. With WP_OOPlugin I try to define reasonable defaults for a lot of this stuff while still making the 
defaults overwritable.

__File Name:__  
Your file name should be named the plural version whatever you want to call your custom post type with the 
first letter being a capital letter. i.e. Employees.php


