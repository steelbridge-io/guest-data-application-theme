<?php

?>
<main id="main-content">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h1><?php the_title(); ?></h1>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </article>
      <?php
      endwhile;
    else :
      ?>
      <p><?php esc_html_e('No pages found.', 'guest-data-application-theme'); ?></p>
    <?php
    endif;
    ?>
  </main>
