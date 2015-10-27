<?php

// Starts the session
session_start();

// Extended function collection
require_once get_template_directory()
  .DS.'inc'.DS.'Facade'.DS.'WP'.DS.'functions.php';

// Include classes
spl_autoload_register(function($class_name)
{
  $file = get_template_directory()
    . DS
    . 'inc'
    . DS
    . str_replace('_', DS, $class_name)
    . '.php';

  if(is_file($file))
  {
    require $file;
  }
});

spl_autoload_register(function($class_name)
{
  $file = get_template_directory()
    . DS
    . 'inc'
    . DS
    . str_replace('\\', DS, $class_name)
    . '.php';

  if(is_file($file))
  {
    require $file;
  }
});

// Handles certain post data
if(isset($_POST['ns']))
  Facade_Form::mapper($_POST['ns']);

// Security
define('DISALLOW_FILE_EDIT', true);

// Removes login error messages to prevent bruteforce
function facade_remove_wordpress_errors()
{
  return __('You shall not pass', 'facade');
}
add_filter('login_errors', 'facade_remove_wordpress_errors');

// Allow strictly 3 revisions to prevent a slower database that is building up
// in size over time else
define('WP_POST_REVISIONS', 3);