<?php
get_header();
?>

  <main id="main-content">
    <?php
    if (have_posts()) :
      ?>
      <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="archive-description"><?php the_archive_description(); ?></div>
      </header>
      <?php
      while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="entry-summary">
            <?php the_excerpt(); ?>
          </div>
        </article>
      <?php
      endwhile;

      the_posts_navigation();
    else :
      ?>
      <p><?php esc_html_e('No posts found.', 'guest-data-application-theme'); ?></p>
    <?php
    endif;
    ?>
  </main>

<?php
get_footer();
?>