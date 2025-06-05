
<?php
/*
 * Multi Destination User Content
 */

// Security check - ensure this is only included for multi-destination users
$current_user = wp_get_current_user();
if (!is_user_logged_in() || !in_array('multi-destination', (array) $current_user->roles)) {
 return; // Don't display anything if not a multi-destination user
}

$user_id = $current_user->ID;
?>
<div id="multi-dest-user-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Welcome <?php echo esc_html($current_user->first_name); ?>!</h1>
                <h2 class="text-center mb-5">Your Available Destinations</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                 <?php
                 // Loop through the 5 possible destination URLs
                 for ($i = 1; $i <= 5; $i++) {
                  $url = get_user_meta($user_id, 'multi_dest_url_' . $i, true);
                  $label = get_user_meta($user_id, 'multi_dest_label_' . $i, true);

                  // Only show button if URL exists
                  if (!empty($url)) {
                   // Use label if provided, otherwise use a default label
                   $button_text = !empty($label) ? $label : 'Destination ' . $i;
                   ?>
                      <a href="<?php echo esc_url($url); ?>"
                         class="btn btn-primary btn-lg px-4 py-3 destination-btn"
                         target="_self"
                         style="min-width: 200px; max-width: 250px;">
                       <?php echo esc_html($button_text); ?>
                      </a>
                   <?php
                  }
                 }
                 ?>
                </div>
            </div>
        </div>

     <?php
     // Check if no destinations are configured
     $has_destinations = false;
     for ($i = 1; $i <= 5; $i++) {
      if (!empty(get_user_meta($user_id, 'multi_dest_url_' . $i, true))) {
       $has_destinations = true;
       break;
      }
     }

     if (!$has_destinations) {
      ?>
         <div class="row justify-content-center">
             <div class="col-md-8 col-lg-6">
                 <div class="alert alert-info text-center" role="alert">
                     <i class="fas fa-info-circle me-2"></i>
                     No destinations have been configured for your account yet. Please contact your administrator.
                 </div>
             </div>
         </div>
      <?php
     }
     ?>

        <div class="row justify-content-center mt-5">
            <div class="col-auto">
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-outline-primary btn-lg">Logout</a>
            </div>
        </div>
    </div>
</div>
