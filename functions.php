<?php
function start_session() {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
}

add_action('init', 'start_session', 1);


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
require_once __DIR__ . '/inc/waiver-link.php';

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
function add_logout_link_to_menu($items, $args) {
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

// Adds permalink to Publish section inside the editor for post-type "travel-questionnaire"
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

function async_css_load($tag, $handle) {
  if ('bootstrap5' !== $handle) {
    return $tag;
  }
  return str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $tag);
}
add_filter('style_loader_tag', 'async_css_load', 10, 2);

function add_async_defer_attributes($tag, $handle) {
  // Add async to specific scripts
  $scripts_to_async = array('hero-template-jquery', 'hero-template-bootstrapjs');
  foreach ($scripts_to_async as $async_script) {
    if ($async_script === $handle) {
      return str_replace(' src', ' async="async" src', $tag);
    }
  }
  // Add defer to specific scripts
  $scripts_to_defer = array('custom-logout-script', 'form-table-js', 'nav-js', 'google-recaptcha', 'recaptcha-script');
  foreach ($scripts_to_defer as $defer_script) {
    if ($defer_script === $handle) {
      return str_replace(' src', ' defer="defer" src', $tag);
    }
  }
  return $tag;
}
add_filter('script_loader_tag', 'add_async_defer_attributes', 10, 2);

function dequeue_gf_scripts_and_styles() {
  // Dequeue Gravity Forms styles
  wp_dequeue_style('gforms_css');

  // Dequeue Gravity Forms scripts
  wp_dequeue_script('gforms_gravityforms');
  wp_dequeue_script('gforms_json');
  wp_dequeue_script('gforms_placeholder');
}
add_action('wp_print_styles', 'dequeue_gf_scripts_and_styles', 100);
add_action('wp_enqueue_scripts', 'dequeue_gf_scripts_and_styles', 100);

function enqueue_gf_scripts_conditionally() {
  // Check if the current post type is 'travel-questionnaire'
  if (is_singular('travel-questionnaire')) {
    // Re-enqueue styles
    wp_enqueue_style('gforms_css');

    // Re-enqueue scripts
    wp_enqueue_script('gforms_gravityforms');
    wp_enqueue_script('gforms_json');
    wp_enqueue_script('gforms_placeholder');
  }
}
add_action('wp_enqueue_scripts', 'enqueue_gf_scripts_conditionally');

// Enqueue scripts and styles for the frontend
function guest_data_application_theme_scripts() {

  wp_enqueue_style('guest-data-application-theme-style', get_stylesheet_uri());

  // Enqueue and defer Bootstrap CSS
  wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css', [], '5.2.2', 'all');

  // Enqueue and async/defer scripts
  wp_enqueue_script('hero-template-jquery', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', array(), '', true);
  wp_enqueue_script('hero-template-bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js', array('jquery'), '5.2.1', true);

  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);

  wp_enqueue_script('gda-popover-js', get_template_directory_uri() . '/js/gda-popover.js', array('jquery', 'hero-template-bootstrapjs'), null, true);
  wp_enqueue_script('nav-js', get_template_directory_uri() . '/js/nav.js', ['jquery'], null, true);

  if (is_page_template('questionnaire-templates/guest-data-template.php')) {
  wp_enqueue_script('form-table-js', get_template_directory_uri() . '/js/form-table.js', array('jquery', 'hero-template-bootstrapjs'), null, true);
  }

  if (is_front_page()) { // Check if we are on the front page (index.php)

    $recaptcha_site_key = defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : '';

    if (!empty($recaptcha_site_key)) {
      wp_enqueue_script(
        'google-recaptcha',
        "https://www.google.com/recaptcha/api.js?render={$recaptcha_site_key}",
        array(),
        null,
        true
      );
    } else {
      // Handle the case where RECAPTCHA_SITE_KEY is not defined
      error_log('RECAPTCHA_SITE_KEY is not defined in wp-config.php');
    }

    wp_enqueue_script('recaptcha-script', get_template_directory_uri() . '/js/captcha-front-page.js', ['jquery'], null, true);

    // Localize script to pass site key
    wp_localize_script('recaptcha-script', 'recaptchaConfig', array(
      'siteKey' => $recaptcha_site_key
    ));
  }

wp_enqueue_script('table-save-logic', get_template_directory_uri() . '/js/table-save-logic.js', ['jquery'], null, true);

wp_localize_script('table-save-logic', 'ajax_object', [
'ajax_url' => admin_url('admin-ajax.php'),
'security' => wp_create_nonce('table_save_nonce'),
]);

}
add_action('wp_enqueue_scripts', 'guest_data_application_theme_scripts');

// Temporary test to ensure the key is loaded
//error_log('Recaptcha Site Key: ' . (defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : 'Not Defined'));

// Enqueue scripts and styles for admin
function guest_data_application_admin_scripts() {
  // Custom script to handle logout without confirmation
  wp_enqueue_script('custom-logout-script-admin', get_template_directory_uri() . '/js/logout.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'guest_data_application_admin_scripts');

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

// Consolidated reCAPTCHA Functions
add_action('login_form', 'verify_recaptcha_on_login');
add_action('admin_post_register_user', 'verify_recaptcha_on_registration');
add_action('admin_post_nopriv_register_user', 'verify_recaptcha_on_registration');

function verify_recaptcha($recaptcha_response) {
  if (!defined('RECAPTCHA_SECRET_KEY') || empty(RECAPTCHA_SECRET_KEY)) {
    error_log('RECAPTCHA_SECRET_KEY is missing or not defined in wp-config.php');
    wp_die('Configuration error');
  }

  $captcha_secret = RECAPTCHA_SECRET_KEY;
  $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$captcha_secret}&response={$recaptcha_response}");

  if (is_wp_error($response)) {
    error_log('Failed to contact reCaptcha server: ' . $response->get_error_message());
    wp_die('Failed to verify reCaptcha, please try again.');
  }

  $response_body = wp_remote_retrieve_body($response);
  $result = json_decode($response_body);

  if (empty($result) || !$result->success) {
    wp_die('reCaptcha verification failed!');
  }

  return true;
}

function verify_recaptcha_on_login() {
  if (isset($_POST['recaptcha_response'])) {
    $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);
    verify_recaptcha($recaptcha_response);
  }
}

function verify_recaptcha_on_registration() {
  if (isset($_POST['recaptcha_response'])) {
    $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);
    verify_recaptcha($recaptcha_response);
  }
  // Proceed with the rest of your registration logic here
}

// Display user meta values for debugging
add_action('admin_notices', function() {
  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $custom_redirect_url = get_user_meta($user_id, 'custom_redirect_url', true);
    echo '<div class="notice notice-info"><p>' . esc_html($custom_redirect_url) . '</p></div>';
  }
});

/*** Testing ****/
// Add the custom field to the user profile page
function add_requested_destination_to_profile($user) {
 $value = get_user_meta($user->ID, 'requested_destination_15', true); // Fetch the saved value
 ?>
    <h3><?php _e('Custom User Information', 'your-plugin-textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="requested_destination_15"><?php _e('Requested Travel Destination', 'your-plugin-textdomain'); ?></label></th>
            <td>
                <input type="text" name="requested_destination_15" id="requested_destination_15" value="<?php echo esc_attr($value); ?>" class="regular-text">
                <p class="description"><?php _e('Please enter your requested travel destination.', 'your-plugin-textdomain'); ?></p>
            </td>
        </tr>
    </table>
 <?php
}
add_action('show_user_profile', 'add_requested_destination_to_profile');
add_action('edit_user_profile', 'add_requested_destination_to_profile');

// Save the custom field value
function save_requested_destination_to_profile($user_id) {
 if (!current_user_can('edit_user', $user_id)) {
  return false;
 }

 if (isset($_POST['requested_destination_15'])) {
  update_user_meta($user_id, 'requested_destination_15', sanitize_text_field($_POST['requested_destination_15']));
 }
}
add_action('personal_options_update', 'save_requested_destination_to_profile');
add_action('edit_user_profile_update', 'save_requested_destination_to_profile');

function add_toolbar_fallback_script() {
 if (is_admin_bar_showing()) {
  ?>
     <script type="text/javascript">
         document.addEventListener("DOMContentLoaded", function() {
             var isFirefox = typeof InstallTrigger !== 'undefined';
             if (isFirefox && !document.getElementById('wpadminbar')) {
                 location.reload();
             }
         });
     </script>
  <?php
 }
}
add_action('wp_footer', 'add_toolbar_fallback_script');

/**
* Admin bypass for *required Gravity Form Fields
*/

add_filter( 'gform_field_validation_FORMID', function( $result, $value, $form, $field ) {
if ( current_user_can( 'administrator' ) ) {
$result['208'] = true; // Skip validation for admins
}
return $result;
}, 10, 4 );

add_filter( 'gform_validation', function( $validation_result ) {
if ( current_user_can( 'administrator' ) ) {
foreach ( $validation_result['form']['fields'] as &$field ) {
$field['failed_validation'] = false;
$field['validation_message'] = '';
}
$validation_result['is_valid'] = true;
}
return $validation_result;
} );

/******* REST API ******/

add_action('wp_ajax_update_gravity_form_entry', 'update_gravity_form_entry');
add_action('wp_ajax_nopriv_update_gravity_form_entry', 'update_gravity_form_entry');

function update_gravity_form_entry() {
// Debug nonce received from Postman
error_log('Generated Nonce: ' . wp_create_nonce('table_save_nonce'));
error_log('Received Nonce: ' . (isset($_POST['security']) ? $_POST['security'] : 'None provided'));
error_log('Received nonce: ' . ($_POST['security'] ?? 'Not sent'));
error_log('Expected nonce: ' . wp_create_nonce('table_save_nonce'));
error_log(print_r($_POST, true)); // Logs all POST data sent by the AJAX request
// Verify nonce for security
if (!check_ajax_referer('table_save_nonce', 'security', false)) {
wp_send_json_error(['message' => 'Invalid security token']);
wp_die();
}

// Fetch and sanitize inputs
global $entry_id;
//$entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
$entry_id = isset($_POST['entry_id']) ? intval($_POST['entry_id']) : 0;
$field_label = isset($_POST['field_label']) ? sanitize_text_field($_POST['field_label']) : '';
$updated_value = isset($_POST['updated_value']) ? sanitize_textarea_field($_POST['updated_value']) : '';

// Debugging: Log inputs
/*error_log("Entry ID Received: $entry_id");
error_log("Field Label Received: $field_label");
error_log("Updated Value Received: $updated_value");*/

// Retrieve the entry
$entry = GFAPI::get_entry($entry_id);
if (is_wp_error($entry)) {
//error_log("Error Retrieving Entry: " . $entry->get_error_message());
wp_send_json_error(['message' => 'Entry not found: ' . $entry->get_error_message()]);
wp_die();
}

// Debugging: Log the retrieved entry
//error_log("Retrieved Entry: " . print_r($entry, true));

// Retrieve the form and resolve the field ID
$form_id = $entry['form_id'];
$form = GFAPI::get_form($form_id);
if (empty($form)) {
//error_log("Form not found for Form ID: $form_id");
wp_send_json_error(['message' => 'Form not found']);
wp_die();
}

// Debugging: Log the retrieved form
//error_log("Retrieved Form: " . print_r($form, true));

// Find the field ID that matches the label
$field_id = null;
foreach ($form['fields'] as $field) {
if (trim($field->label) === trim($field_label)) {
$field_id = $field->id;
break;
}
}

if (!$field_id) {
//error_log("Field Label '$field_label' Does Not Match Any Fields in the Form.");
wp_send_json_error(['message' => 'Field could not be found for label: ' . $field_label]);
wp_die();
}

// Debugging: Log the matched field ID
//error_log("Matched Field ID: $field_id for Label: $field_label");

// Check if the field exists in the entry object
if (!array_key_exists($field_id, $entry)) {
error_log("Field ID $field_id does not exist in the entry.");
wp_send_json_error(['message' => "Field ID $field_id not available in entry."]);
wp_die();
}

// Update the field in the entry
$entry[$field_id] = $updated_value;

// Debugging: Log entry before update
//error_log("Entry Before Update: " . print_r($entry, true));

// Update the entry and handle errors
$result = GFAPI::update_entry($entry);
if (is_wp_error($result)) {
error_log("Error Updating Entry: " . $result->get_error_message());
wp_send_json_error(['message' => 'Update failed: ' . $result->get_error_message()]);
wp_die();
}

// Debugging: Log success
//error_log("Entry Successfully Updated for ID: $entry_id. Updated Entry: " . print_r($entry, true));

// Respond with success
wp_send_json_success(['message' => 'Entry successfully updated.']);
wp_die();
}

/*** /REST API **/

/**
 * @return void
 * CSP (Content Security Policy)
 */
function add_csp_header() {
 $csp_header = "default-src 'self'";
 $csp_header .= "; script-src 'self' 'unsafe-inline' https://www.google.com https://www.gstatic.com https://cdn.jsdelivr.net https://stats.wpmucdn.com https://www.google.com/recaptcha/";
 $csp_header .= "; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net";
 $csp_header .= "; img-src 'self' data: https://tfs-spaces.sfo2.digitaloceanspaces.com https://stats1.wpmudev.com";
 $csp_header .= "; font-src 'self' https://fonts.gstatic.com";
 $csp_header .= "; connect-src 'self' https://stats1.wpmudev.com";
 $csp_header .= "; object-src 'none'";
 $csp_header .= "; frame-src 'self' https://www.google.com";
 $csp_header .= "; worker-src 'self' blob:";
 $csp_header .= "; upgrade-insecure-requests";

 header("Content-Security-Policy: " . $csp_header);
}

//add_action('send_headers', 'add_csp_header');

/*add_action('wp_head', function () {
if (current_user_can('administrator')) { // Make sure it's only available to authenticated users
echo '<script>console.log("Generated Nonce: ' . wp_create_nonce('table_save_nonce') . '");</script>';
}
});*/