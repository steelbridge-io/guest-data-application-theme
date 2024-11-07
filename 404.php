<?php
get_header();
?>

  <main id="main-content">
    <article id="post-404" class="post-not-found">
      <header class="entry-header">
        <h1><?php esc_html_e('Page Not Found', 'guest-data-application-theme'); ?></h1>
      </header>
      <div class="entry-content">
        <p><?php esc_html_e('Sorry, but the page you were trying to view does not exist.', 'guest-data-application-theme'); ?></p>
        <p><?php esc_html_e('It looks like this was the result of either a mistyped address or an out-of-date link.', 'guest-data-application-theme'); ?></p>
      </div>
    </article>
  </main>

<?php
get_footer();
?>