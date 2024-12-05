<?php

function combined_register_user() {
  if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    return;
  }

  if (isset($_POST['user_login'], $_POST['user_email'], $_POST['user_password'])) {
    $user_login = sanitize_text_field($_POST['user_login']);
    $user_email = sanitize_email($_POST['user_email']);
    $user_password = sanitize_text_field($_POST['user_password']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);

    // Error checking
    if (empty($user_login) || empty($user_email) || empty($user_password)) {
      wp_die('All fields are required.');
    }

    // Debugging log for checking input data
    error_log("Registering user: $user_login, Email: $user_email, First Name: $first_name, Last Name: $last_name");

    $userdata = [
      'user_login' => $user_login,
      'user_email' => $user_email,
      'user_pass'  => $user_password,
      'first_name' => $first_name,
      'last_name'  => $last_name,
      'role'       => 'subscriber' // Set the default role here
    ];

    $user_id = wp_insert_user($userdata);

    if (is_wp_error($user_id)) {
      $error_message = $user_id->get_error_message();
      error_log("User registration failed: $error_message");
      wp_die($error_message); // or use wp_redirect(home_url('/register-error')); if you prefer redirection
    }

    // Redirect to indicate a successful registration
    wp_redirect(home_url('/?registered=true'));
    exit;
  }
}

add_action('admin_post_nopriv_register_user', 'combined_register_user');
add_action('admin_post_register_user', 'combined_register_user');

// Add a custom authentication filter to check the subscriber login status
// Restrict subscribers from logging in.
function restrict_subscriber_login($user, $username, $password) {
  if (is_wp_error($user)) {
    return $user;
  }

  // Check if the user has the role 'subscriber'
  if (in_array('subscriber', (array) $user->roles)) {
    // Return an error message instead of successful authentication
    return new WP_Error('pending_approval', __('<strong>ERROR</strong>: Hello! Your registration is still pending approval. Please contact us with questions.'));
  }

  return $user;
}
add_filter('authenticate', 'restrict_subscriber_login', 30, 3);

// Display custom error messages on login page
function custom_login_error_message($error) {
  $error_codes = array('pending_approval');

  foreach ($error_codes as $code) {
    if (strpos($error, $code) !== false) {
      switch ($code) {
        case 'pending_approval':
          return '<div class="error"><p>' . __('Hello! Your registration is still pending approval. Questions? Contact us.') . '</p></div>';
          break;
      }
    }
  }

  return $error;
}
add_filter('login_errors', 'custom_login_error_message');


function handle_user_registration() {
// Perform the registration steps
  if (isset($_POST['user_login']) && isset($_POST['user_email']) && isset($_POST['user_password'])) {
    $userdata = array(
      'user_login' => sanitize_user($_POST['user_login']),
      'user_email' => sanitize_email($_POST['user_email']),
      'user_pass'  => sanitize_text_field($_POST['user_password']),
      'first_name' => sanitize_text_field($_POST['first_name']),
      'last_name'  => sanitize_text_field($_POST['last_name']),
      'role'       => 'subscriber'
    );

    $user_id = wp_insert_user($userdata);

    if (!is_wp_error($user_id)) {
// Redirect with success message
      wp_redirect(home_url('/?registered=true'));
    } else {
// Redirect with error message
      wp_redirect(home_url('/?registration_error=true'));
    }
    exit();
  }
}

add_action('admin_post_nopriv_register_user', 'handle_user_registration');
add_action('admin_post_register_user', 'handle_user_registration');

// Prevent subscribers from logging in
function prevent_subscriber_login($user_login, $user) {
  if (in_array('subscriber', (array) $user->roles)) {
    wp_logout(); // Force logout
    $_SESSION['login_error'] = 'Hello! Your registration is pending approval. If you have not heard from us in over 24 hours since you registered, please contact us.';
    wp_redirect(home_url());
    exit();
  }
}
add_action('wp_login', 'prevent_subscriber_login', 10, 2);

// Show error message on the login page
function show_pending_message() {
  if (isset($_GET['pending']) && $_GET['pending'] == 'true') {
    echo '<div class="error"><p>Uh oh... We have not approved your registration. Please contact us with questions.</p></div>';
  }
}

add_action('login_message', 'show_pending_message');