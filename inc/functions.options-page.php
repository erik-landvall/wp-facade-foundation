<?php

function facade_theme_options_global_segment()
{
  // Validate access
  if(!current_user_can('manage_options'))
    wp_die(__(
      'You do not have sufficient privileges to access this page.',
      'facade'));

  // Save post data
  if($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    foreach ($_POST as $key => $value)
      update_option('facade_' . $key, $value);

    echo '<div id="message" class="updated" style="padding:15px">' . __('Content saved', 'facade') . '</div>';
  }

  // Render template
  $fallback = ICL_LANGUAGE_CODE ?: '';
  $context  = ['currentTab' => $_GET['tab'] ?: $fallback];
  Timber::render('admin/global-segment.twig', $context);
}

function facade_theme_options()
{
  add_menu_page(
    __('Global segments', 'facade'),
    'Options',
    'manage_options',
    'facade_global-segment',
    'facade_theme_options_global_segment');
}
add_action('admin_menu', 'facade_theme_options');