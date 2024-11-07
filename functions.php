<?php
function guest_data_application_theme_setup() {
  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  // Let WordPress manage the document title.
  add_theme_support('title-tag');

  // Enable support for Post Thumbnails on posts and pages.
  add_theme_support('post-thumbnails');

  // Register a main navigation menu.
  register_nav_menus(array(
    'main-menu' => __('Main Menu', 'guest-data-application-theme')
  ));
}
add_action('after_setup_theme', 'guest_data_application_theme_setup');

// Enqueue scripts and styles.
function guest_data_application_theme_scripts() {
  // Enqueue theme style.css
  wp_enqueue_style('guest-data-application-theme-style', get_stylesheet_uri());

  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css', array(), '5.2.2', 'all');

  wp_enqueue_script('hero-template-jquery', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', array(), '', true);

  wp_enqueue_script('hero-template-bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js', array('jquery'), '5.2.1', true);
}
add_action('wp_enqueue_scripts', 'guest_data_application_theme_scripts');

function register_custom_templates( $templates ) {
  $directory = get_template_directory() . '/questionnaire-templates/';

  // Ensure the directory exists
  if ( $handler = opendir( $directory ) ) {
    while ( false !== ( $file = readdir( $handler ) ) ) {
      if ( strpos( $file, '.php' ) !== false ) {
        $templates[$file] = $file;
      }
    }
    closedir( $handler );
  }

  return $templates;
}
add_filter( 'theme_page_templates', 'register_custom_templates' );

function load_custom_template( $template ) {
  global $post;

  if ( isset( $post->page_template ) && $post->page_template ) {
    $custom_template = locate_template( 'questionnaire-templates/' . $post->page_template );
    if ( $custom_template ) {
      return $custom_template;
    }
  }
  return $template;
}
add_filter( 'template_include', 'load_custom_template', 99 );