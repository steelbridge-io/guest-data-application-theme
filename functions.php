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
    'public-menu' => __('Public Menu'),
    'destination-menu' => __('Destination Menu'),
    'tfs-staff-menu' => __('TFS Staff Menu'),
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
  wp_enqueue_script('nav-js', get_template_directory_uri() . '/js/nav.js', ['jquery'], null, true);
  if (is_front_page()) { // Check if we are on the front page (index.php)
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=6Lf-pYQqAAAAACH2PMrn77ojtGqtJ27peYjCHGdz', array(), null, true);
    wp_enqueue_script('recaptcha-script', get_template_directory_uri() . '/js/captcha-front-page.js', ['jquery'],
      null, true);
  }
}
add_action('wp_enqueue_scripts', 'guest_data_application_theme_scripts');

// Enqueue scripts and styles for admin
function guest_data_application_admin_scripts() {
  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script-admin', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'guest_data_application_admin_scripts');

// Register custom templates
// Register custom templates for travel-form post type
function guest_data_application_register_travel_form_templates($post_templates, $wp_theme, $post) {
  $directory = get_template_directory() . '/questionnaire-templates/';

  // Ensure the directory exists and is for 'travel-form' post type
  if ($post->post_type === 'travel-form' && $handler = opendir($directory)) {
    while (false !== ($file = readdir($handler))) {
      if (strpos($file, '.php') !== false) {
        $post_templates['questionnaire-templates/' . $file] = str_replace('.php', '', $file);
      }
    }
    closedir($handler);
  }

  return $post_templates;
}
add_filter('theme_post_templates', 'guest_data_application_register_travel_form_templates', 10, 3);


// Load custom template
// Load custom template
function guest_data_application_load_custom_template($template) {
  global $post;

  // Check if the post type is 'travel-form' and template is set
  if ($post && $post->post_type === 'travel-form' && isset($post->page_template) && $post->page_template) {
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

// Custom login

// Enqueue custom styles for the login page
function my_custom_login_styles() {
  // Path to your custom logo in the theme directory
  $custom_logo_url = get_template_directory_uri() . '/images/login-logo.png';

  ?>
  <style type="text/css">
      body.login {
          background-color: #333333; /* Change this to match your theme's background color */
      }
      a.wp-login-lost-password,
      #backtoblog a {
          color: #f5f5f5 !important;
      }
      #login h1 a {
          background-image: url('<?php echo esc_url($custom_logo_url); ?>');
          background-size: contain;
          width: 300px; /* Adjust based on your logo size */
          height: 80px; /* Adjust based on your logo size */
      }
      #wp-submit {
          background-color: #B32018 !important;
      }
      #wp-submit:focus {
          border-color: #B32018 !important;
          box-shadow: none !important;
      }
      .login form {
          background: #ffffff; /* Change this to match your theme's form background color */
          border: 1px solid #ddd; /* Change this to match your theme's form border color */
          box-shadow: 0 1px 3px rgba(0,0,0,0.13);
      }
      .login label {
          color: #333333; /* Change this to match your theme's font color */
      }
      .wp-core-ui .button-primary {
          background: #007cba; /* Change this to match your theme's button color */
          border-color: #0073aa; /* Change this to match your theme's button border color */
      }
  </style>
  <?php
}
add_action('login_enqueue_scripts', 'my_custom_login_styles');

// Change the URL of the login logo to your site homepage
function my_custom_login_logo_url() {
  return home_url(); // Change this to the URL you want to link the logo to
}
add_filter('login_headerurl', 'my_custom_login_logo_url');

// Change the title attribute of the login logo
function my_custom_login_logo_url_title() {
  return get_bloginfo('name');
}
add_filter('login_headertext', 'my_custom_login_logo_url_title');

// Function to include private posts and pages in nav menu meta box
function include_private_posts_in_menu_editor($query) {
  if (is_admin() && isset($GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'nav-menus.php') {
    $post_type = $query->get('post_type');

    if (in_array($post_type, array('page', 'post'))) {
      $query->set('post_status', array('publish', 'private'));
    }
  }
}
add_action('pre_get_posts', 'include_private_posts_in_menu_editor');

// Ensure nav menu meta box items include private content
function add_private_posts_to_nav_menu($items, $menu, $args) {
  if (is_admin() && isset($GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'nav-menus.php') {
    foreach ($items as $item) {
      if ('private' === get_post_status($item->object_id)) {
        $item->title .= ' (Private)';
      }
    }
  }
  return $items;
}
add_filter('wp_get_nav_menu_items', 'add_private_posts_to_nav_menu', 10, 3);

add_action('login_form', 'verify_recaptcha_on_login');

function verify_recaptcha_on_login() {
  if (isset($_POST['recaptcha_response'])) {
    $captcha_secret = '6Lf-pYQqAAAAABtM65vB8Z9uPAs8xpcXPEfM4bft';
    $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$captcha_secret}&response={$recaptcha_response}");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (!$result->success) {
      wp_die('reCaptcha verification failed!');
    }
  }
}

add_action('admin_post_register_user', 'verify_recaptcha_on_registration');
add_action('admin_post_nopriv_register_user', 'verify_recaptcha_on_registration');

function verify_recaptcha_on_registration() {
  if (isset($_POST['recaptcha_response'])) {
    $captcha_secret = '6Lf-pYQqAAAAABtM65vB8Z9uPAs8xpcXPEfM4bft';
    $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$captcha_secret}&response={$recaptcha_response}");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (!$result->success) {
      wp_die('reCaptcha verification failed!');
    }
  }

  // Proceed with the rest of your registration logic here
}