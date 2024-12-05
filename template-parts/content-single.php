<?php
?>
<main id="main-content">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
          </header>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </article>
        <?php
        /*if (comments_open() || get_comments_number()) :
          comments_template();
        endif;*/
      endwhile;
    else :
      ?>
      <p><?php esc_html_e('No posts found.', 'guest-data-application-theme'); ?></p>
    <?php
    endif;
    ?>
  </main>
