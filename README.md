__IF YOU STUMBLE ACROSS THIS REPOSITORY, I APPOLOGIZE BUT THE DOCUMENTATION IS NOT COMPLETE AND I WILL BE WORKING ON IT MORE. PLEASE CHECK BACK SOON__

WP_OOPlugin
===========
__NOTE:__ This plugin is no where near production ready at this time. It is only posted here on GitHub so I may get feedback from plugin authors in the community! Because I am new to WordPress development it would be silly of me to take this project any further without getting input from other developers.
- - - 
  
What is WP_OOPlugin?
-------------------
WP_OOPlugin is a WordPress plugin intended to be used by plugin authors to help ease and speed up plugin development.
- - -
  
Why WP_OOPlugin?
---------------
I am new to WordPress. Most of my experience, until now is with CakePHP, a RoR (Ruby on Rails) like framework for PHP. Recently, in my professional life, I have been working with WordPress and there are a few things about writing a WordPress plugin I think could be better, so I'd like to change them!

In the CakePHP community there are two very important programming principles that I think could be implemented better in WordPress.

1. Don't Repeat Yourself (DRY)
2. Convention Over Configuration
- - -

Directory Structure
-------------------
WP_OOPlugin expects your plugins to have a specific directory structure, it is as follows:

* ~YOUR_PLUGIN_DIR_NAME~
    * custom_post_types/
    * controllers/
    * views/
    * ~YOUR_MAIN_PLUGIN_FILE~.php

