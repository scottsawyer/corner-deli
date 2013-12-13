<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

global $ssc_options;
$ssc_options = array(
  'permissions' => array(
    'administrator' => array(
      'remove' => array(
        'export',
        'import',
        'switch_themes',
        'delete_plugins',
        'delete_others_pages',
        'edit_theme_options',
        ),
      ),
    ),
  'logo' => array(
    'image' => 'logo.png',
    'width' => '350px',
    'height' => '250px',
    ),
  'logo_admin' => array(
    'image' => 'logo_small.png',
    ),
  'sidebars' => array(
    array(
      'machine_name' => 'mobile_menu',
      'title' => 'Mobile Menu',
      'id' => 'ssc_mobile_menu',
      'description' => 'This is for the Mobile Menu',
      ),
    array(
      'machine_name' => 'home_sidebar',
      'title' => 'Home Sidebar',
      'id' => 'ssc_home_sidebar',
      'description' => 'Home page sidebar',
      ),
    array(
      'machine_name' => 'blog_sidebar',
      'title' => 'Blog Sidebar',
      'id' => 'ssc_blog_sidebar',
      'description' => 'Blog sidebar',
      ),
    array(
      'machine_name' => 'menu_sidebar',
      'title' => 'Menu Item Sidebar',
      'id' => 'ssc_menu_sidebar',
      'description' => 'Menu item sidebar',
      ),
    ),
  'post_types' => array(
    array(
      'machine_name' => 'menu_item',
      'labels' => array(
        'name' => 'Menu Items',
        'singular_name' => 'Menu Item',
        ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array(
        'slug' => 'menu_item',
        ),
      'description' => 'Items to appear on restaurant menu.',
      'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
      'taxonomies' => array( 'menu_category' ),
      'capability_type' => array( 'menu_item', 'menu_items' ),
      'map_meta_cap' => true,
      ),
    ),
  
  'metaboxes' => array(
    array( 
      'id' => 'menu_item_details',
      'title' => 'Menu Item Details',
      'pages' => array( 'menu_item' ),
      'context' => 'side',
      'priority' => 'high',
      'show_names' => true,
      'fields' => array(
        array(
          'name' => 'Price',
          'desc' => 'This item\'s price',
          'id' => '_ssc_price',
          'std' => '$',
          'type' => 'text_money',
          ),
        array(
          'name' => 'Calories',
          'desc' => 'The calories',
          'id' => '_ssc_calories',
          'type' => 'text',
          ),
        array( 
          'name' => 'Ingredients',
          'desc' => 'The Ingredients',
          'id' => '_ssc_ingredients',
          'type' => 'textarea',
          ),
        ),
      ),
    ),
/**/
  'taxonomies' => array(
    array(
      'machine_name' => 'menu_category',
      'post_types' => array( 'menu_item' ),
      'args' => array(
        //'label' => __( 'Menu Categories' ),
        
        'labels' => array(
          'name' => _x( 'Menu Categories', 'taxonomy general name' ), //__( 'Menu Categories' ), //
          'singular_name' => _x( 'Menu Category', 'taxonomy singular name' ), //__( 'Menu Category' ), //
          'search_items' => __( 'Search Menu Categories' ),
          'all_items' => __( 'All Menu Categories' ),
          'parent_item' => __( 'Parent Menu Category' ),
          'edit_item' => __( 'Edit Menu Category' ),
          'update_item' => __( 'Update Menu Category' ),
          'add_new_item' => __( 'Add New Menu Category' ),
          'new_item_name' => __( 'New Menu Category Name' ),
          'menu_name' => __( 'Menu' ),
          ),
        'show_ui' => true,
        'hierarchical' => true,
        'show_admin_column' => true,
        'query_var' => true,
        /**/
        'rewrite' => array( 'slug' => 'menu_category' ),
        'capabilities' => array(
          'assign_terms' => 'edit_menu',
          'edit_terms' => 'publish_menu',
          ),
        ),
      ),
    ),
/**/
  /*
   * Settings fields 
  /**/
  'settings' => array(
    array(
      'group_name' => 'location',
      'group_title' => 'Location',
      'group_description' => 'Enter the location information.',
      'group_section' => 'general',
      'group_fields' => array(
        array(
          'name' => 'phone',
          'title' => 'Phone Number',
          'type' => 'text',
          ),
        array(
          'name' => 'street',
          'title' => 'Street',
          'type' => 'text',
          ),
        array(
          'name' => 'city',
          'title' => 'City',
          'type' => 'text',
          ),
        array(
          'name' => 'zip',
          'title' => 'ZIP',
          'type' => 'text',
          ),
        array(
          'name' => 'state',
          'title' => 'State',
          'type' => 'select',
          'options' => 'us_state_abbrevs_names',
          ),
        ),
      ),
    array(
      'group_name' => 'socialmedia',
      'group_title' => 'Social Media',
      'group_description' => 'Add social media links.',
      'group_section' => 'general',
      'group_fields' => array(
        array(
          'name' => 'facebook',
          'title' => 'Facebook',
          'type' => 'text',
          ),
        array(
          'name' => 'twitter',
          'title' => 'Twitter',
          'type' => 'text',
          ),
        array(
          'name' => 'linkedin',
          'title' => 'LinkedIn',
          'type' => 'text',
          ),
        array(
          'name' => 'google',
          'title' => 'Google Plus',
          'type' => 'text',
          ),
        array(
          'name' => 'youtube',
          'title' => 'YouTube',
          'type' => 'text',
          ),
        array(
          'name' => 'flickr',
          'title' => 'Flickr',
          'type' => 'text',
          ),
        ),
      ),    
    array(
      'group_name' => 'business_hours',
      'group_title' => 'Business Hours',
      'group_description' => 'Enter the business hours',
      'group_section' => 'general',
      'group_fields' => array(
        array(
          'name' => 'monday_open',
          'title' => 'Monday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'monday_close',
          'title' => 'Monday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'tuesday_open',
          'title' => 'Tuesday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'tuesday_close',
          'title' => 'Tuesday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'wednesday_open',
          'title' => 'Wednesday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'wednesday_close',
          'title' => 'Wednesday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'thursday_open',
          'title' => 'Thursday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'thursday_close',
          'title' => 'Thursday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'friday_open',
          'title' => 'Friday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'friday_close',
          'title' => 'Friday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'saturday_open',
          'title' => 'Saturday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'saturday_close',
          'title' => 'Saturday Close',
          'type' => 'time',
          ),
        array(
          'name' => 'sunday_open',
          'title' => 'Sunday Open',
          'type' => 'time',
          ),
        array(
          'name' => 'sunday_close',
          'title' => 'Sunday Close',
          'type' => 'time',
          ),
        ),
      ),
    ),
  'admin' => array(
    'footer' => array(
      'text' => '&copy 2005 - '. date('Y'). ' Scott Sawyer Consulting.  All rights reserved.',
      ),
    ),
  'menus' => array(
    array(
      'machine_name' => 'header_menu',
      'title' => 'Header Menu',
      ),
    array(
      'machine_name' => 'footer_menu',
      'title' => 'Footer Menu',
      ),
    ),
  );
require_once ( get_stylesheet_directory() . '/inc/functions-inc.php' );
function ssc_panels_row_styles($styles) {
  $styles['large-6'] = __('Half', 'ssc-corner-deli-child');
  return $styles;
}
add_filter('siteorgin_panels_row_styles', 'ssc_panels_row_styles');
/*
function ssc_init_meta_boxes(){
  if( !class_exists( 'cmb_Meta_Box' ) ) {
    require_once( get_stylesheet_directory() . '/lib/metabox/init.php' );
  }
}
add_action( 'init', 'ssc_init_meta_boxes', 9999 );		
/**/
?>