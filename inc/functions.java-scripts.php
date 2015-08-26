<?php

// Enqueue scripts
function init_script_enqueue()
{
  if(is_admin())
  {
    wp_enqueue_script('thickbox');
    return;
  }
  elseif(in_array( $GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']))
  {
    return;
  }
}
add_action('init', 'init_script_enqueue');