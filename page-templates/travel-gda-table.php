<?php
/**
 * Template Name: Guest Data Tables
 */

get_header(); ?>

<div class="container container-flex-none mt-5">
  <h1><?php echo the_title(); ?></h1>

<?php
if (have_posts()) :
  while (have_posts()) : the_post();
    if (get_the_content()) {
      ?>
        <div class="row">
          <div class="col-12">
            <?php the_content(); ?>
          </div>
        </div>
      <?php
    }
  endwhile;
endif;
?>
</div>

  <div class="container travel-item-list mt-5 mb-5">
    <div class="row">
      <div class="col-12">
        <div class="well mt-5 mb-5">
          <?php echo do_shortcode('[custom_search post_type="travel-form"]'); ?>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      // Query for the custom post type 'travel-form'
      $args = array(
        'post_type' => 'travel-form',
        'posts_per_page' => -1, // Get all posts
      );

      $query = new WP_Query($args);

      if ($query->have_posts()) :
        $count = 0;
        while ($query->have_posts()) : $query->the_post();
          // Start a new row every 4 posts
          // if ($count > 0 && $count % 4 == 0) {
          //echo '</div><div class="row">';
          // }
          ?>
          <div class="col-md-6 travel-item">
            <div class="card">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
          </div>
          <?php
          $count++;
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>No travel questionnaires found.</p>';
      endif;
      ?>
    </div>
  </div>

<?php get_footer(); ?>