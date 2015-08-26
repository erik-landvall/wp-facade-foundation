<?php

// Enqueue style sheets
function init_style_enqueue()
{
  wp_enqueue_style(
    'font-awesome',
    '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
    [],
    '4.4.0',
    'all');
  
  if(in_array( $GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) || is_admin())
  {
    wp_enqueue_style(
      'admin',
      get_template_directory_uri().'/css/admin.css',
      [],
      '1.0.0',
      'all');
    
    return;
  }

  wp_enqueue_style(
    // Name
    'bootstrap',
    // Url
    '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
    // Dependencies
    [],
    // Version
    '3.3.5',
    // Media
    'all');

  wp_enqueue_style(
    'master',
    get_template_directory_uri().'/css/main.css',
    ['bootstrap', 'font-awesome'],
    '1.0.0',
    'all');
}
add_action('init', 'init_style_enqueue');