<?php
get_header();
?>

  <main id="main-content">
    <article id="post-404" class="post-not-found container">
      <header class="entry-header mt-5">
        <h1><?php esc_html_e('Whoops!', 'guest-data-application-theme'); ?></h1>
      </header>
      <div class="entry-content">
        <p class="lead"><?php esc_html_e('It is possible you are seeing this message becuase you are not logged-in?',
					'guest-data-application-theme'); ?></p>
        <p class="lead"><?php esc_html_e('Some of the content on this website is private and only a logged-in user can veiw certain types of content. If logging in does not address the problem you are experiencing, please send us a message at info@theflyshop.com and we will help you resolve this issue.',	'guest-data-application-theme'); ?></p>
			 <p class="lead"><?php esc_html_e('Log in here:&nbsp;', 'guest-data-application-theme'); ?><a href="https://www.theflyshop.com/gda/" title="Log in"><b>Log In</b></a></p>

      </div>
    </article>
  </main>

<?php
get_footer();
?>