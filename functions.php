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

// Custom Travel Manager Nav

function register_custom_menus() {
  register_nav_menus(array(
    'main-menu' => __('Main Menu'),
    'travel-manager-menu' => __('Travel Manager Menu'),
  ));
}
add_action('init', 'register_custom_menus');

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

// Add Logout Menu Item
function add_logout_link_to_menu( $items, $args ) {
  if (is_user_logged_in()) {
    $logout_link = '<li class="menu-item logout-link"><a href="' . wp_logout_url() . '">Logout</a></li>';
    $items .= $logout_link;
  }
  return $items;
}
add_filter('wp_nav_menu_items', 'add_logout_link_to_menu', 10, 2);

// Remove default logout option from admin bar
function remove_default_logout_link($wp_admin_bar) {
  $wp_admin_bar->remove_node('logout');
}
add_action('admin_bar_menu', 'remove_default_logout_link', 999);

/*
    * Adds permalink to Publish section inside the editor for post-type "travel-questionnaire"
    * */

function add_permalink_to_publish_box() {
  global $post, $pagenow;

  if ( $pagenow == 'post.php' && in_array($post->post_type, ['travel-questionnaire', 'travel-form']) ) {
    $post_id = $post->ID;
    $permalink = get_permalink($post_id);
    ?>
    <div class="misc-pub-section misc-pub-permalink">
      <strong><?php _e('Permalink:'); ?></strong>
      <span id="sample-permalink">
          <a href="<?php echo esc_url($permalink); ?>" target="_blank"><?php echo esc_html($permalink); ?></a>
      </span>
    </div>
    <?php
  }
}
add_action('post_submitbox_misc_actions', 'add_permalink_to_publish_box');

// Enqueue scripts and styles for the frontend
function guest_data_application_theme_scripts() {
  // Enqueue theme style.css
  wp_enqueue_style('guest-data-application-theme-style', get_stylesheet_uri());

  // Enqueue Bootstrap styles and scripts
  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css', [], '5.2.2', 'all');
  wp_enqueue_script('hero-template-jquery', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', array(), '', true);
  wp_enqueue_script('hero-template-bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js', ['jquery'], '5.2.1', true);

  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
  wp_enqueue_script('form-table-js', get_template_directory_uri() . '/js/form-table.js', ['jquery'], null, true);
  wp_enqueue_script('gda-popover-js', get_template_directory_uri() . '/js/gda-popover.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'guest_data_application_theme_scripts');

// Enqueue scripts and styles for admin
function guest_data_application_admin_scripts() {
  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script-admin', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
}
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

function include_private_posts_in_search($query) {
  // Check if it's a search query and if the user is logged in
  if ($query->is_search && $query->is_main_query() && is_user_logged_in()) {
    // Include private posts in the search results
    $query->set('post_status', array('publish', 'private'));
  }
  return $query;
}
add_filter('pre_get_posts', 'include_private_posts_in_search');