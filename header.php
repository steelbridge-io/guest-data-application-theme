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
    <div class="menu-toggle" id="menu-toggle">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <nav id="site-navigation">
      <?php
      if ( is_user_logged_in() ) {
        $user = wp_get_current_user();

        if ( in_array( 'travel_manager', (array) $user->roles ) ) {
          wp_nav_menu(array(
            'theme_location' => 'travel-manager-menu'
          ));
        } else if ( in_array( 'administrator', (array) $user->roles ) ) {
          wp_nav_menu(array(
            'theme_location' => 'main-menu'
          ));
        } else if ( in_array( 'destination', (array) $user->roles ) ) {
	        wp_nav_menu( array(
		        'theme_location' => 'destination-menu'
	        ) );
        } else if ( in_array( 'multi-destination', (array) $user->roles ) ) {
         wp_nav_menu( array(
          'theme_location' => 'multi-destination-menu'
         ) );
        } else if ( in_array( 'tfs_staff', (array) $user->roles ) ) {
	        wp_nav_menu( array(
		        'theme_location' => 'tfs-staff-menu'
	        ) );
        }
      } else {
        wp_nav_menu(array(
          'theme_location' => 'public-menu'
        ));
      }
      ?>
    </nav>
  </div>
</header>