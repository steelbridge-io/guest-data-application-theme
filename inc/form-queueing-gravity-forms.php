<?php
// Add to your theme's functions.php or create a custom plugin file

/**
 * Universal Gravity Forms Submission Lock
 * Prevents race conditions during concurrent form submissions
 */

// Ensure PHP session is started
function ensure_session_started() {
 if (session_status() === PHP_SESSION_NONE) {
	session_start();
 }
}
add_action('init', 'ensure_session_started');

// Create a submission lock at the beginning of form processing
add_action('gform_pre_submission', 'universal_form_submission_lock', 5, 1);
function universal_form_submission_lock($form) {
 // Generate a unique user identifier
 $user_id = get_current_user_id();
 $visitor_id = $user_id > 0 ? $user_id : md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

 // Create a lock key that's unique to this user but applies to all forms
 $lock_key = 'gf_submission_lock_' . $visitor_id;

 // Store the form ID and timestamp in the lock
 $lock_data = [
	'form_id' => $form['id'],
	'timestamp' => time(),
	'form_title' => $form['title'] ?? 'Unknown Form'
 ];

 // Set the lock for 45 seconds (adjust as needed based on your server's processing time)
 set_transient($lock_key, $lock_data, 45);

 // Log the start of processing
 error_log("GF Form {$form['id']} ({$form['title']}) submission started - User: $visitor_id");
}

// Release the lock after submission completes
add_action('gform_after_submission', 'universal_form_submission_complete', 10, 2);
function universal_form_submission_complete($entry, $form) {
 // Generate the same unique user identifier
 $user_id = get_current_user_id();
 $visitor_id = $user_id > 0 ? $user_id : md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

 // Release the lock
 $lock_key = 'gf_submission_lock_' . $visitor_id;
 delete_transient($lock_key);

 // Log completion
 error_log("GF Form {$form['id']} ({$form['title']}) submission completed - Entry: {$entry['id']}");
}

// Check for existing lock before allowing a new form to be submitted
add_filter('gform_pre_render', 'check_existing_form_submission', 10, 1);
function check_existing_form_submission($form) {
 // Don't modify the admin view
 if (is_admin()) {
	return $form;
 }

 // Generate the same unique user identifier
 $user_id = get_current_user_id();
 $visitor_id = $user_id > 0 ? $user_id : md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

 // Check if there's an active lock
 $lock_key = 'gf_submission_lock_' . $visitor_id;
 $active_lock = get_transient($lock_key);

 if ($active_lock) {
	// There's an active submission - add warning
	$seconds_ago = time() - $active_lock['timestamp'];
	$form_title = $active_lock['form_title'];

	$warning_message = sprintf(
	 '<div class="gform_submission_error" style="background:#ffebe8;border:1px solid #c00;padding:10px;margin-bottom:15px;">
                Thank You! Please give me just a second to process your ("%s") form. Almost ready. Currently being processed (%d seconds ago). 
                This is just a slight pause in order to avoid any data loss and maintain security integrity.
            </div>',
	 esc_html($form_title),
	 $seconds_ago
	);

	// Add the warning to the form
	$form['description'] = $warning_message . ($form['description'] ?? '');

	// Also add JavaScript to disable the submit button
	add_action('wp_footer', function() {
	 ?>
	 <script>
       jQuery(document).ready(function($) {
           // Disable all submit buttons on Gravity Forms
           $('.gform_wrapper input[type="submit"], .gform_wrapper button[type="submit"]').prop('disabled', true)
               .css('opacity', '0.5')
               .attr('title', 'Another form submission is being processed');

           // Check every 5 seconds if the lock is released
           const checkInterval = setInterval(function() {
               $.ajax({
                   url: '<?php echo admin_url('admin-ajax.php'); ?>',
                   type: 'POST',
                   data: {
                       action: 'check_form_submission_lock'
                   },
                   success: function(response) {
                       if (response.success && !response.data.locked) {
                           // Lock is released, re-enable buttons and remove warning
                           clearInterval(checkInterval);
                           $('.gform_wrapper input[type="submit"], .gform_wrapper button[type="submit"]')
                               .prop('disabled', false)
                               .css('opacity', '1')
                               .removeAttr('title');
                           $('.gform_submission_error').fadeOut();
                       }
                   }
               });
           }, 5000);
       });
	 </script>
	 <?php
	});
 }

 return $form;
}

// AJAX endpoint to check if lock is released
add_action('wp_ajax_check_form_submission_lock', 'ajax_check_form_submission_lock');
add_action('wp_ajax_nopriv_check_form_submission_lock', 'ajax_check_form_submission_lock');
function ajax_check_form_submission_lock() {
 // Generate the same unique user identifier
 $user_id = get_current_user_id();
 $visitor_id = $user_id > 0 ? $user_id : md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

 // Check if there's an active lock
 $lock_key = 'gf_submission_lock_' . $visitor_id;
 $active_lock = get_transient($lock_key);

 wp_send_json_success([
	'locked' => !empty($active_lock),
	'timestamp' => $active_lock ? $active_lock['timestamp'] : null
 ]);
}

// Emergency auto-release of locks after a timeout period
add_action('init', 'cleanup_stale_form_locks');
function cleanup_stale_form_locks() {
 // Only run occasionally (1% of pageloads)
 if (mt_rand(1, 100) > 1) {
	return;
 }

 // Get current user lock
 $user_id = get_current_user_id();
 $visitor_id = $user_id > 0 ? $user_id : md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
 $lock_key = 'gf_submission_lock_' . $visitor_id;
 $active_lock = get_transient($lock_key);

 // If lock is older than 60 seconds, it's likely stuck - clear it
 if ($active_lock && (time() - $active_lock['timestamp']) > 60) {
	delete_transient($lock_key);
	error_log("Cleared stale form submission lock for user $visitor_id - Form: {$active_lock['form_id']} ({$active_lock['form_title']})");
 }
}