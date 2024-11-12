<?php
get_header(); ?>
  <div class="wrapper">
    <div class="container mt-5 mb-5">
      <main id="main-content">
        <h1>Welcome to Guest Data Application Theme</h1>

        <?php //if (!is_user_logged_in()): // Check if user is not logged in ?>
          <div class="form-container">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                <div class="login-form">
                  <h2>Login</h2>
                  <form action="<?php echo wp_login_url(); ?>" method="post">
                    <p>
                      <label for="log">Username or Email<br />
                        <input type="text" name="log" id="log" class="input" value="" size="20" /></label>
                    </p>
                    <p>
                      <label for="pwd">Password<br />
                        <input type="password" name="pwd" id="pwd" class="input" value="" size="20" /></label>
                    </p>
                    <p>
                      <label for="rememberme">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever" /> Remember Me</label>
                    </p>
                    <p>
                      <input type="submit" name="wp-submit" id="wp-submit" value="Log In" />
                    </p>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
              <div class="registration-form">
                <h2>Register</h2>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
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
                    <label for="user_password">Password<br />
                      <input type="password" name="user_password" id="user_password" class="input" value="" size="25" /></label>
                  </p>
                  <p>
                    <input type="submit" name="wp-submit" id="wp-submit" value="Register" />
                  </p>
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
        <?php //else: // If user is logged in ?>
          <!-- <p>You are already logged in.</p> -->
        <?php //endif; ?>
      </main>
    </div>
    <?php get_footer(); ?>
  </div>
