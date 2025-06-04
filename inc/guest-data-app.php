<?php
/*
 * Guest Data Post Type
 */
add_theme_support('post-thumbnails');
add_post_type_support('travel-form', 'thumbnail');

// Register Custom Post Type
function travel_form() {

  $labels = array(
    'name'                  => _x('Guest Data', 'Post Type General Name', 'travel_domain'),
    'singular_name'         => _x('Guest Data', 'Post Type Singular Name', 'travel_domain'),
    'menu_name'             => __('Guest Data', 'travel_domain'),
    'name_admin_bar'        => __('Guest Data', 'travel_domain'),
    'archives'              => __('Item Archives', 'travel_domain'),
    'attributes'            => __('Item Attributes', 'travel_domain'),
    'parent_item_colon'     => __('Parent Item:', 'travel_domain'),
    'all_items'             => __('All Posts', 'travel_domain'),
    'add_new_item'          => __('Add New Item', 'travel_domain'),
    'add_new'               => __('Add New', 'travel_domain'),
    'new_item'              => __('New Item', 'travel_domain'),
    'edit_item'             => __('Edit Page', 'travel_domain'),
    'update_item'           => __('Update Item', 'travel_domain'),
    'view_item'             => __('View Page', 'travel_domain'),
    'view_items'            => __('View Pages', 'travel_domain'),
    'search_items'          => __('Search Item', 'travel_domain'),
    'not_found'             => __('Not found', 'travel_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'travel_domain'),
    'featured_image'        => __('Featured Image', 'travel_domain'),
    'set_featured_image'    => __('Set featured image', 'travel_domain'),
    'remove_featured_image' => __('Remove featured image', 'travel_domain'),
    'use_featured_image'    => __('Use as featured image', 'travel_domain'),
    'insert_into_item'      => __('Insert into item', 'travel_domain'),
    'uploaded_to_this_item' => __('Uploaded to this item', 'travel_domain'),
    'items_list'            => __('Items list', 'travel_domain'),
    'items_list_navigation' => __('Items list navigation', 'travel_domain'),
    'filter_items_list'     => __('Filter items list', 'travel_domain'),
  );
  $args = array(
    'label'                 => __('Guest Data', 'travel_domain'),
    'description'           => __('Guest Data', 'travel_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'page-attributes', 'post-formats'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-admin-post',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'show_in_rest'          => true,
  );
  register_post_type('travel-form', $args);
}
add_action('init', 'travel_form', 0);

// Custom Taxonomy
add_action('init', 'travel_form_tax');
function travel_form_tax() {
  register_taxonomy(
    'travel-form-destination',
    'travel-form',
    array(
      'hierarchical'    => true,
      'label'           => __('Destination', 'travel_domain'),
      'query_var'       => true,
      'rewrite'         => true,
      'show_in_rest'    => true,
    )
  );
}

// Register Custom Post Type Evaluation Forms
function evaluation_form() {

 $labels = array(
  'name'                  => _x('Evaluation Forms', 'Post Type General Name', 'travel_domain'),
  'singular_name'         => _x('Evaluation Forms', 'Post Type Singular Name', 'travel_domain'),
  'menu_name'             => __('Evaluation Forms', 'travel_domain'),
  'name_admin_bar'        => __('Evaluation Forms', 'travel_domain'),
  'archives'              => __('Item Archives', 'travel_domain'),
  'attributes'            => __('Item Attributes', 'travel_domain'),
  'parent_item_colon'     => __('Parent Item:', 'travel_domain'),
  'all_items'             => __('All Posts', 'travel_domain'),
  'add_new_item'          => __('Add New Item', 'travel_domain'),
  'add_new'               => __('Add New', 'travel_domain'),
  'new_item'              => __('New Item', 'travel_domain'),
  'edit_item'             => __('Edit Page', 'travel_domain'),
  'update_item'           => __('Update Item', 'travel_domain'),
  'view_item'             => __('View Page', 'travel_domain'),
  'view_items'            => __('View Pages', 'travel_domain'),
  'search_items'          => __('Search Item', 'travel_domain'),
  'not_found'             => __('Not found', 'travel_domain'),
  'not_found_in_trash'    => __('Not found in Trash', 'travel_domain'),
  'featured_image'        => __('Featured Image', 'travel_domain'),
  'set_featured_image'    => __('Set featured image', 'travel_domain'),
  'remove_featured_image' => __('Remove featured image', 'travel_domain'),
  'use_featured_image'    => __('Use as featured image', 'travel_domain'),
  'insert_into_item'      => __('Insert into item', 'travel_domain'),
  'uploaded_to_this_item' => __('Uploaded to this item', 'travel_domain'),
  'items_list'            => __('Items list', 'travel_domain'),
  'items_list_navigation' => __('Items list navigation', 'travel_domain'),
  'filter_items_list'     => __('Filter items list', 'travel_domain'),
 );
 $args = array(
  'label'                 => __('Evaluation Forms', 'travel_domain'),
  'description'           => __('Evaluation Forms', 'travel_domain'),
  'labels'                => $labels,
  'supports'              => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'page-attributes', 'post-formats'),
  'hierarchical'          => false,
  'public'                => true,
  'show_ui'               => true,
  'show_in_menu'          => true,
  'menu_position'         => 5,
  'menu_icon'             => 'dashicons-admin-post',
  'show_in_admin_bar'     => true,
  'show_in_nav_menus'     => true,
  'can_export'            => true,
  'has_archive'           => true,
  'exclude_from_search'   => false,
  'publicly_queryable'    => true,
  'capability_type'       => 'post',
  'show_in_rest'          => true,
 );
 register_post_type('evaluation-form', $args);
}
add_action('init', 'evaluation_form', 0);

// Custom Taxonomy
add_action('init', 'evaluation_form_tax');
function evaluation_form_tax() {
 register_taxonomy(
  'evaluation-form-destination',
  'evaluation-form',
  array(
   'hierarchical'    => true,
   'label'           => __('Evaluation Category', 'travel_domain'),
   'query_var'       => true,
   'rewrite'         => true,
   'show_in_rest'    => true,
  )
 );
}

// Register Custom Post Type Evaluation Data (May add to seperate directory)
function evaluation_data() {

 $labels = array(
	'name'                  => _x('Evaluation Data', 'Post Type General Name', 'travel_domain'),
	'singular_name'         => _x('Evaluation Data', 'Post Type Singular Name', 'travel_domain'),
	'menu_name'             => __('Evaluation Data', 'travel_domain'),
	'name_admin_bar'        => __('Evaluation Data', 'travel_domain'),
	'archives'              => __('Item Archives', 'travel_domain'),
	'attributes'            => __('Item Attributes', 'travel_domain'),
	'parent_item_colon'     => __('Parent Item:', 'travel_domain'),
	'all_items'             => __('All Posts', 'travel_domain'),
	'add_new_item'          => __('Add New Item', 'travel_domain'),
	'add_new'               => __('Add New', 'travel_domain'),
	'new_item'              => __('New Item', 'travel_domain'),
	'edit_item'             => __('Edit Page', 'travel_domain'),
	'update_item'           => __('Update Item', 'travel_domain'),
	'view_item'             => __('View Page', 'travel_domain'),
	'view_items'            => __('View Pages', 'travel_domain'),
	'search_items'          => __('Search Item', 'travel_domain'),
	'not_found'             => __('Not found', 'travel_domain'),
	'not_found_in_trash'    => __('Not found in Trash', 'travel_domain'),
	'featured_image'        => __('Featured Image', 'travel_domain'),
	'set_featured_image'    => __('Set featured image', 'travel_domain'),
	'remove_featured_image' => __('Remove featured image', 'travel_domain'),
	'use_featured_image'    => __('Use as featured image', 'travel_domain'),
	'insert_into_item'      => __('Insert into item', 'travel_domain'),
	'uploaded_to_this_item' => __('Uploaded to this item', 'travel_domain'),
	'items_list'            => __('Items list', 'travel_domain'),
	'items_list_navigation' => __('Items list navigation', 'travel_domain'),
	'filter_items_list'     => __('Filter items list', 'travel_domain'),
 );
 $args = array(
	'label'                 => __('Evaluation Data', 'travel_domain'),
	'description'           => __('Evaluation Data', 'travel_domain'),
	'labels'                => $labels,
	'supports'              => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'page-attributes', 'post-formats'),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 5,
	'menu_icon'             => 'dashicons-admin-post',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => true,
	'exclude_from_search'   => false,
	'publicly_queryable'    => true,
	'capability_type'       => 'post',
	'show_in_rest'          => true,
 );
 register_post_type('evaluation-data', $args);
}
add_action('init', 'evaluation_data', 0);

// Custom Taxonomy
add_action('init', 'evaluation_data_tax');
function evaluation_data_tax() {
 register_taxonomy(
	'evaluation-data-destination',
	'evaluation-data',
	array(
	 'hierarchical'    => true,
	 'label'           => __('Destination Evaluation', 'travel_domain'),
	 'query_var'       => true,
	 'rewrite'         => true,
	 'show_in_rest'    => true,
	)
 );
}