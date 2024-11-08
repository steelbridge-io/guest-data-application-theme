<?php
// Theme setup
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

// Require necessary files
require_once __DIR__ . '/inc/questionnaire-pages.php';
require_once __DIR__ . '/inc/guest-data-app.php';
require_once __DIR__ . '/inc/customizer.php';
require_once __DIR__ . '/inc/front-page.php';

// Redirect after logout
function mytheme_redirect_after_logout() {
  wp_redirect(home_url());
  exit();
}
add_action('wp_logout', 'mytheme_redirect_after_logout');

// Custom logout URL function
function mytheme_custom_logout_url($logout_url, $redirect) {
  $nonce = wp_create_nonce('log-out');
  $logout_url = add_query_arg([
    'action' => 'logout',
    '_wpnonce' => $nonce,
    'redirect_to' => !empty($redirect) ? urlencode($redirect) : urlencode(home_url())
  ], home_url('wp-login.php'));
  return $logout_url;
}
add_filter('logout_url', 'mytheme_custom_logout_url', 10, 2);

// Add custom logout option to admin bar
function add_custom_logout_link($wp_admin_bar) {
  $wp_admin_bar->add_node([
    'id'    => 'custom_logout',
    'title' => 'Logout',
    'href'  => wp_logout_url(home_url()),
    'meta'  => [
      'class' => 'custom-logout'
    ]
  ]);
}
add_action('admin_bar_menu', 'add_custom_logout_link', 999);

// Remove default logout option from admin bar
function remove_default_logout_link($wp_admin_bar) {
  $wp_admin_bar->remove_node('logout');
}
add_action('admin_bar_menu', 'remove_default_logout_link', 999);

// Enqueue scripts and styles for the frontend
function guest_data_application_theme_scripts() {
  // Enqueue theme style.css
  wp_enqueue_style('guest-data-application-theme-style', get_stylesheet_uri());

  // Enqueue Bootstrap styles and scripts
  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css', [], '5.2.2', 'all');
  wp_enqueue_script('hero-template-bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js', ['jquery'], '5.2.1', true);

  // Ensure WordPress's version of jQuery is enqueued
  wp_enqueue_script('jquery');

  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'guest_data_application_theme_scripts');

// Enqueue scripts and styles for admin
function guest_data_application_admin_scripts() {
  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script-admin', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
}

// Register jQuery and add it to the footer
wp_enqueue_script('jquery');

add_action('admin_enqueue_scripts', 'guest_data_application_admin_scripts');

// Register custom templates
function guest_data_application_register_custom_templates($templates) {
  $directory = get_template_directory() . '/questionnaire-templates/';

  // Ensure the directory exists
  if ($handler = opendir($directory)) {
    while (false !== ($file = readdir($handler))) {
      if (strpos($file, '.php') !== false) {
        $templates[$file] = $file;
      }
    }
    closedir($handler);
  }

  return $templates;
}
add_filter('theme_page_templates', 'guest_data_application_register_custom_templates');

// Load custom template
function guest_data_application_load_custom_template($template) {
  global $post;

  if (isset($post->page_template) && $post->page_template) {
    $custom_template = locate_template('questionnaire-templates/' . $post->page_template);
    if ($custom_template) {
      return $custom_template;
    }
  }
  return $template;
}
add_filter('template_include', 'guest_data_application_load_custom_template', 99);