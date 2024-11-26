<?php
get_header();

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wp-submit-login'])) {
  // Get login credentials
  $creds = array(
    'user_login'    => sanitize_text_field($_POST['log']),
    'user_password' => sanitize_text_field($_POST['pwd']),
    'remember'      => isset($_POST['rememberme']),
  );

  // Attempt to sign the user in
  $user = wp_signon($creds, false);

  // Check if there was an error logging in
  if (is_wp_error($user)) {
    $_SESSION['login_error'] = $user->get_error_message();
  } else {
    // Check if the user has the 'subscriber' role
    if (in_array('subscriber', $user->roles)) {
      wp_logout(); // Log the subscriber out
      $_SESSION['login_error'] = 'Subscribers are not allowed to login pending approval.';
    } else {
      // Check for a custom redirect URL
      $custom_redirect_url = get_user_meta($user->ID, 'custom_redirect_url', true);
      if ($custom_redirect_url) {
        // Redirect to the custom URL if set
        wp_redirect($custom_redirect_url);
      } else {
        // Redirect to homepage if no custom URL is set
        wp_redirect(home_url());
      }
      exit();
    }
  }
}
?>

<div class="wrapper">
  <div class="container background-color-none mt-5 mb-5">
    <main id="main-content">
      <h1>Welcome!! TFS Guest Data</h1>

      <?php if (!is_user_logged_in()): // Check if user is not logged in ?>
        <div class="form-container">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="login-form">
                  <h2>Login</h2>
                  <p class="login-description">Please enter your credentials to log in.</p>
                  <?php
                  if (isset($_SESSION['login_error'])) {
                    echo '<div class="error"><p>' . $_SESSION['login_error'] . '</p></div>';
                    unset($_SESSION['login_error']); // Clear the error after displaying it
                  }
                  ?>
                  <form action="<?php echo esc_url(home_url()); ?>" method="post">
                    <p>
                      <label for="log">Username or Email<br />
                        <input type="text" name="log" id="log" class="input" value="" size="20" /></label>
                    </p>
                    <p>
                      <label for="pwd">Password<br />
                        <input type="password" name="pwd" id="pwd" class="input" value="" size="20" /></label>
                    </p>
                    <p>
                      <label for="rememberme" class="login-rememberme">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever" />
                        <span class="remember-text">Remember Me</span>
                      </label>
                    </p>
                    <!-- The reCaptcha token will be added here via JavaScript -->
                    <p>
                      <input type="submit" name="wp-submit-login" id="wp-submit-login" value="Log In" />
                    </p>
                  </form>
                  <a href="<?php echo wp_lostpassword_url(); ?>" class="lost-password-link">Lost your password?</a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="registration-form">
                  <h2>Register</h2>
                  <?php if (isset($_GET['registered']) && $_GET['registered'] == 'true'): ?>
                    <div class="success"><p>Thank you for registering. Your request is pending review.</p></div>
                  <?php elseif (isset($_GET['registration_error'])): ?>
                    <div class="error"><p>Registration failed. Please try again.</p></div>
                  <?php else: ?>
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="registration-form">
                      <input type="hidden" name="action" value="register_user">
                      <p>
                        <label for="user_login">Username<br />
                          <input type="text" name="user_login" id="user_login" class="input" value="" size="20" /></label>
                      </p>
                      <p>
                        <label for="user_email">Email<br />
                          <input type="email" name="user_email" id="user_email" class="input" value="" size="25" /></label>
                      </p>
                      <p>
                        <label for="first_name">First Name<br />
                          <input type="text" name="first_name" id="first_name" class="input" value="" size="20" /></label>
                      </p>
                      <p>
                        <label for="last_name">Last Name<br />
                          <input type="text" name="last_name" id="last_name" class="input" value="" size="20" /></label>
                      </p>
                      <p>
                        <label for="user_password">Password<br />
                          <input type="password" name="user_password" id="user_password" class="input" value="" size="25" /></label>
                      </p>
                      <!-- The reCaptcha token will be added here via JavaScript -->
                      <p>
                        <input type="submit" name="wp-submit-register" id="wp-submit-register" value="Register" />
                      </p>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php else: // If user is logged in ?>
        <h2 class="logged-in">You are currently logged in</h2>
      <?php endif; ?>
    </main>
  </div>
  <?php get_footer(); ?>
</div>