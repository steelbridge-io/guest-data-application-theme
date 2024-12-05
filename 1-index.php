<?php
get_header(); ?>

<div class="wrapper">
    <div class="container background-color-none mt-5 mb-5">
        <main id="main-content">
            <h1>Welcome!! TFS Guest Data</h1>
					
					<?php if (!is_user_logged_in()): // Check if user is not logged in ?>

              <div class="form-container">
                  <div class="row">
                      <div class="col-md-6">

                          <!-- LOGIN SECTION -->
                          <div class="card">
                              <div class="login-form">
                                  <h2>Login</h2>
                                  <p class="login-description">Please enter your credentials to log in.</p>
																
                                    <?php
                                    // Handle login form submission
                                    $login_error_message = '';
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wp-submit-login'])) {
                                        // Include WordPress load file
                                        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
                                        
                                        $credentials = array(
                                            'user_login'    => $_POST['log'] ?? '', // ? operator will prevent undefined array key error
                                            'user_password' => $_POST['pwd'] ?? '',
                                            'remember'      => !empty($_POST['rememberme']),
                                        );
                                        
                                        $user = wp_signon($credentials, is_ssl());
                                        
                                        if (is_wp_error($user)) {
                                            // Output any error messages
                                            $login_error_message = $user->get_error_message();
                                        } else {
                                            // Redirect on successful login
                                            wp_redirect(home_url());
                                            exit;
                                        }
                                    }
                                    ?>
																
                                    <?php if (!empty($login_error_message)): ?>
                                    <div class="login-error">
                                        <p><?php echo $login_error_message; ?></p>
                                    </div>
																<?php endif; ?>

                                  <form action="" method="post">
                                      <p>
                                          <label for="log">Username or Email<br />
                                              <input type="text" name="log" id="log" class="input" size="20" /></label>
                                      </p>
                                      <p>
                                          <label for="pwd">Password<br />
                                              <input type="password" name="pwd" id="pwd" class="input" size="20" /></label>
                                      </p>
                                      <p>
                                          <label for="rememberme" class="login-rememberme">
                                              <input type="checkbox" name="rememberme" id="rememberme" value="forever" />
                                              <span class="remember-text">Remember Me</span>
                                          </label>
                                      </p>
                                      <p>
                                          <input type="submit" name="wp-submit-login" id="wp-submit-login" value="Log In" />
                                      </p>
                                  </form>
                                  <a href="<?php echo wp_lostpassword_url(); ?>" class="lost-password-link">Lost your password?</a>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">

                          <!-- REGISTRATION SECTION -->
                          <div class="card">
                              <div class="registration-form">
                                  <h2>Register</h2>
																
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['wp-submit-login'])) {
                                    // Include WordPress functions to handle user registration
                                    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

                                    $username = sanitize_text_field($_POST['username']);
                                    $email = sanitize_email($_POST['email']);
                                    $password = $_POST['password'];
                                    $requested_destination = sanitize_text_field($_POST['requested_destination']);

                                    // Validate form inputs (this is a basic example, you should add more validations)
                                    if (!empty($username) && !empty($email) && !empty($password) && !empty($requested_destination)) {
                                        $user_id = wp_create_user($username, $password, $email);

                                        if (!is_wp_error($user_id)) {
                                            // Assign the "subscriber" role (or any role you prefer)
                                            $user = new WP_User($user_id);
                                            $user->set_role('subscriber');

                                            // Save the requested destination to user meta
                                            update_user_meta($user_id, 'requested_destination', $requested_destination);

                                            // Display a confirmation message
                                            echo '<p>Thank you for registering! Your registration request has been received and is being reviewed.</p>';
                                        } else {
                                            echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
                                        }
                                    } else {
                                        echo '<p>All fields are required.</p>';
                                    }
                                }
                                ?>

                                  <form method="POST" action="">
                                      <p>
                                          <label for="username">Username<br />
                                              <input type="text" id="username" class="input user_login"  name="username" required size="25" />
                                          </label>
                                      </p>
                                      <p>
                                          <label for="email">Email<br />
                                              <input type="email" id="email" class="input user_email" name="email" required size="25">
                                          </label>
                                      </p>
                                      <p>
                                          <label for="password">Password<br />
                                              <input type="password" id="password"  name="password" class="input user_password" required size="25">
                                          </label>
                                      </p>
                                      <p>
                                          <label for="requested_destination">Requested Destination<br />
                                              <input type="text" id="requested_destination" name="requested_destination" class="input destination-request" required size="25">
                                          </label>
                                      </p>
                                      <p>
                                          <button type="submit" class="btn btn-primary wp-submit-register">Register</button>
                                      </p>
                                  </form>

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