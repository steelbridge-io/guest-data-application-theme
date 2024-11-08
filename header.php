<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="site-header">
  <div class="container">
    <div class="brand">
      <?php if (has_custom_logo()) : ?>
        <div class="site-logo">
          <?php the_custom_logo(); ?>
        </div>
      <?php else : ?>
        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
        <p><?php bloginfo('description'); ?></p>
      <?php endif; ?>
    </div>
    <nav id="site-navigation">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'main-menu'
      ));
      ?>
    </nav>
  </div>
</header>
</body>
</html>