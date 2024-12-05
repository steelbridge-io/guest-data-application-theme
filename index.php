<?php
get_header();
// Process the login form submission
    function handle_login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wp-submit-login'])) {
            check_admin_referer('custom-login-form');

            $creds = array(
                'user_login'    => sanitize_user($_POST['log']),
                'user_password' => sanitize_text_field($_POST['pwd']),
                'remember'      => isset($_POST['rememberme']),
            );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            $error = $user->get_error_message();
            echo '<div class="error"><p>' . esc_html($error) . '</p></div>';
        } else {
        if (user_can($user, 'subscriber')) {
            wp_logout();
            echo '<div class="error"><p>Subscribers are not allowed to login pending approval.</p></div>';
        } else {
            $redirect_url = home_url();
            $custom_url   = get_user_meta($user->ID, 'custom_redirect_url', true);
        if ($custom_url) {
            $redirect_url = esc_url($custom_url);
        }
        wp_safe_redirect($redirect_url);
            exit();
        }
        }
        }
    }
add_action('template_redirect', 'handle_login');
?>
<div class="wrapper">
    <div class="container background-color-none mt-5 mb-5">
        <main id="main-content">
            <h1>Welcome!! TFS Guest Data</h1>
            <?php if (!is_user_logged_in()): // Check if user is not logged in ?>
        <div class="form-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card login-card">
                        <div class="login-form">
                        <h2>Login</h2>
                        <p class="login-description">Please enter your credentials to log in.</p>
                            <form action="<?php echo esc_url(wp_login_url()); ?>" method="post">
                            <?php wp_nonce_field('custom-login-form', 'registration_nonce'); ?>

                                <div class="form-group">
                                    <label for="log">Username or Email</label>
                                    <input type="text" name="log" id="log" class="form-control" value=""/>
                                </div>

                                <div class="form-group">
                                    <label for="pwd">Password</label>
                                    <input type="password" name="pwd" id="pwd" class="form-control" value=""/>
                                </div>

                                <p>
                                    <label for="rememberme" class="login-rememberme">
                                    <input type="checkbox" name="rememberme" id="rememberme" value="forever"/>
                                    <span class="remember-text">Remember Me</span>
                                    </label>
                                </p>

                                <div class="form-group">
                                    <input type="submit" name="wp-submit-login" id="wp-submit-login" class="btn btn-primary" value="Log In"/>
                                </div>
                            </form>
                            <a href="<?php echo wp_lostpassword_url(); ?>" class="lost-password-link">Lost your password?</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                <!-- REGISTRATION SECTION -->
                    <div class="card">
                        <div class="registration-form">
                            <div class="well">
                                <h2>Register</h2>
                            </div>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['wp-submit-login'])) {
                            // Include WordPress functions to handle user registration
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

                            $username = sanitize_text_field($_POST['username']);
                            $email = sanitize_email($_POST['email']);
                            $password = $_POST['password'];
                            $user_first = sanitize_text_field($_POST['first_name']);
                            $user_last = sanitize_text_field($_POST['last_name']);
                            $requested_destination = sanitize_text_field($_POST['requested_destination_15']);

                            // Validate form inputs (this is a basic example, you should add more validations)
                            if (!empty($username) && !empty($email) && !empty($password) && !empty($user_first) && !empty($user_last)) {
                            $user_id = wp_create_user($username, $password, $email);

                            if (!is_wp_error($user_id)) {
                            // Assign the "subscriber" role (or any role you prefer)
                            $user = new WP_User($user_id);
                            $user->set_role('subscriber');

                            update_user_meta($user_id, 'first_name', $user_first);
                            update_user_meta($user_id, 'last_name', $user_last);
                            update_user_meta($user_id, 'requested_destination_15',
                            $requested_destination);

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
                                <div class="container">
                                    <div class="row">

                                        <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" id="username"
                                        class="input user_login form-control" name="username"
                                        value=""/>
                                        </div>
                                        </div>

                                        <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="input user_email form-control"
                                        name="email" required/>
                                        </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name"
                                        class="form-control first_name" required/>
                                        </div>
                                        </div>

                                        <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"
                                        class="form-control last_name" required/>
                                        </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" name="password"
                                            class="input user_password form-control" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="requested_destination_15">Requested Destination</label>
                                            <input type="text" id="requested_destination_15"
                                            name="requested_destination_15"
                                            class="input destination-request form-control requested_destination_15" required>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- The reCaptcha token will be added here via JavaScript -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <button type="submit" id="wp-sub-register" class="btn btn-primary wp-submit-register">
                                            Register
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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