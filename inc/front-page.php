<?php

function mytheme_register_user() {
	if ('POST' !== $_SERVER['REQUEST_METHOD']) {
		return;
	}
	
	$username = sanitize_text_field($_POST['user_login']);
	$email = sanitize_email($_POST['user_email']);
	$password = sanitize_text_field($_POST['user_password']);
	$first_name = sanitize_text_field($_POST['first_name']);
	$last_name = sanitize_text_field($_POST['last_name']);
	
	// Error checking
	if (empty($username) || empty($email) || empty($password)) {
		wp_die('All fields are required.');
	}
	
	$userdata = array(
		'user_login' => $username,
		'user_email' => $email,
		'user_pass'  => $password,
		'first_name' => $first_name,
		'last_name'  => $last_name,
		'role'       => 'subscriber' // Set the custom user role here
	);
	
	$user_id = wp_insert_user($userdata);
	
	if (is_wp_error($user_id)) {
		wp_die($user_id->get_error_message());
	}
	
	// Log the user in
	wp_clear_auth_cookie();
	wp_set_current_user($user_id);
	wp_set_auth_cookie($user_id);
	
	// Redirect to the homepage
	wp_redirect(home_url());
	exit;
}
add_action('admin_post_nopriv_register_user', 'mytheme_register_user');
add_action('admin_post_register_user', 'mytheme_register_user');
?>