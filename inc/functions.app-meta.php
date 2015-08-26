<?php

// Clean up head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');

// Removes the wpml generator tag
if($sitepress)
  remove_action('wp_head', [$sitepress, 'meta_generator_tag']);

// RSS feed to header
add_theme_support('automatic-feed-links');

// Feutured images
add_theme_support('post-thumbnails', ['page', 'post']);

// Adding css rules for the text editor in admin panel
add_editor_style();

// Exerpt length
function init_excerpt_length()
{
  return 24;
}
add_filter('excerpt_length', 'init_excerpt_length');

// Change the suffix
function init_excerpt_sufix($txt)
{
  return str_replace(' [&hellip;]', '&hellip;', $txt);
}
add_filter('get_the_excerpt', 'init_excerpt_sufix');

// Change the suffix
function init_read_more($txt)
{
  return $txt.' <a href="'.get_permalink().'">'.__('Read more', 'facade').'..</a>';
}
add_filter('read_more', 'init_read_more');

// Removes not used menus from admin
function remove_menus()
{
  global $menu;
  $remove =
  [
    __('Comments'),
    __('Links')
  ];
  foreach($menu as $key => $value)
  {
    $value = explode(' ',$value[0]);
    if(in_array($value[0] != null ? $value[0] : '' , $remove))
      unset($menu[$key]);
  }
}
add_action('admin_menu', 'remove_menus');

// Removes not used menus from admin bar
function my_admin_bar_link()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('new-link');
  $wp_admin_bar->remove_menu('new-user');
}
add_action('wp_before_admin_bar_render', 'my_admin_bar_link');