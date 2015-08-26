<?php

/*
 * This file contains only helper function that are used in templates. Other 
 * functionlity should extend the library with new classes in seperat files.
 */

function get_flash_messages( $namespace = '' )
{
  return Facade_FlashMessage::getMessages( $namespace );
}

function get_the_meta_value( $key, $post = null, $content_filter = false )
{
  $value = Facade_WP_MetaBox::get( $key, $post );

  if( $content_filter )
    $value = the_content_filter( $value );

  return $value;
}

function the_meta_value( $key, $post = null, $content_filter = false )
{
  echo get_the_meta_value( $key, $post, $content_filter );
}

function content_filter($content)
{
  $content = apply_filters( 'the_content', $content );
  $content = str_replace( ']]>', ']]&gt;', $content );

  return $content;
}

function get_dynamic_sidebar($index = 1)
{
  ob_start();
  dynamic_sidebar($index);
  $sidebar_contents = ob_get_clean();
  return $sidebar_contents;
}

function get_the_post_thumbnail_src($id = null)
{
  global $post;
  $id  = is_null($id) ? $post->ID : $id;
  $url = wp_get_attachment_url( get_post_thumbnail_id( $id ) );
  return $url;
}

/**
 * @param string $key The global key to access
 * @param string $lang [optional] Specify a language or let it fallback
 * @return String
 */
function get_global($key, $lang = null)
{
  if($lang === false)
    return get_option('facade_' . $key);
  
  $lang = $lang ?: (ICL_LANGUAGE_CODE ?: '');
  return get_option('facade_' . $key . '_' . $lang);
}

/**
 * Works the same as wp_count_posts, but with the posibility to count by 
 * language code
 *
 * @link https://wpml.org/forums/topic/count-number-of-translated-posts/#post-90076
 * @global type $wpdb
 * @param string $language_code
 * @param string $post_type
 * @param string $post_status
 * @return Number
 */
function count_posts_by_language(
        $lang         = ICL_LANGUAGE_CODE, 
        $post_type    = 'post', 
        $post_status  = 'publish')
{
  global $wpdb;

  switch ($post_type)
  {
    case 'page':
    case 'post':
      $post_type = 'post_'.$post_type;
      break;

    default:
      // Not sure how to handle this
      break;
  }

  $query = 
    "SELECT COUNT(p.ID) "
  . "FROM {$wpdb->prefix}posts AS p "
  . "LEFT JOIN {$wpdb->prefix}icl_translations AS t "
  . "ON p.ID = t.element_id "
  . "WHERE t.language_code = '{$lang}' "
  . "AND t.element_type = '{$post_type}' "
  . "AND p.post_status = '{$post_status}'";
  
  return $wpdb->get_var($query);
}