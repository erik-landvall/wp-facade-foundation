<?php

// declering dependency
if(!class_exists('Timber')) 
{
  add_action( 'admin_notices', function() 
  {
    echo '<div class="error"><p>This theme is dependent on the plugin "Timber" '
        .'that isn\'t activated. Activate the plugin in <a href="' 
        . esc_url(admin_url('plugins.php#timber')) . '">' 
        . esc_url(admin_url('plugins.php')) . '</a></p></div>';
  });
}

// this is where you can add your own filters to twig
function facade_add_filter_to_twig($twig)
{
  $functions =
  [
    'count',
    'stripslashes',
    'esc_attr',
    'strtoupper',
    'strtolower',
    'ucfirst',
    'sanitize_title',
    'content_filter'
  ];

  foreach ($functions as $function)
    $twig->addFilter($function, new Twig_Filter_Function($function));

  return $twig;
}
add_filter('get_twig', 'facade_add_filter_to_twig');

// Some global variables we always wanna have in context
function facade_add_to_context($context)
{
  $context['theme_url']    = get_template_directory_uri();
  $context['site_url']     = get_home_url();
  $context['query_string'] = $_SERVER['QUERY_STRING'];
  $context['page_title']   = get_the_title();
  $context['request']      = array_filter($_REQUEST, 'strlen');

  return $context;
}

add_filter( 'timber_context', 'facade_add_to_context');