<?php
/**
 * Template Name: Travel Questionnaire List
 */

get_header(); ?>

  <div class="container">
    <div class="row">
      <?php
      // Query for the custom post type 'travel-questionnaire'
      $args = array(
        'post_type' => 'travel-questionnaire',
        'posts_per_page' => -1, // Get all posts
      );

      $query = new WP_Query($args);

      if ($query->have_posts()) :
        $count = 0;
        while ($query->have_posts()) : $query->the_post();
          // Start a new row every 4 posts
          if ($count > 0 && $count % 4 == 0) {
            echo '</div><div class="row">';
          }
          ?>
          <div class="col-md-4">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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