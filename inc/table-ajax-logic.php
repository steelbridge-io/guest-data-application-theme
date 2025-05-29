<?php


/**
 * Normalizes strings for robust comparison regardless of:
 * - Capitalization
 * - Special characters (removes them)
 * - HTML entities (&, &amp;, etc.)
 * - Extra spaces or different types of whitespace
 * - Punctuation like colons, apostrophes, commas
 *
 * @param string $string The string to normalize
 * @return string The normalized string for comparison
 */
function normalize_string_for_comparison($string) {
 if (empty($string)) {
  return '';
 }

 // Convert HTML entities to characters first
 $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

 // Convert to lowercase for case-insensitive comparison
 $string = strtolower($string);

 // Replace common word separators with space
 $string = str_replace(['&', '+', '/', ',', ':', ';', '-', '_', '|'], ' ', $string);

 // Remove apostrophes - use only standard apostrophe character
 $string = str_replace("'", "", $string);

 // Remove any remaining special characters
 $string = preg_replace('/[^a-z0-9\s]/', '', $string);

 // Normalize whitespace
 $string = preg_replace('/\s+/', ' ', $string);

 // Trim whitespace
 $string = trim($string);

 return $string;
}

add_action('wp_ajax_update_gravity_form_entry', 'update_gravity_form_entry');
add_action('wp_ajax_nopriv_update_gravity_form_entry', 'update_gravity_form_entry');

function update_gravity_form_entry() {
 // Debug nonce received from Postman
 error_log('Generated Nonce: ' . wp_create_nonce('table_save_nonce'));
 error_log('Received Nonce: ' . (isset($_POST['security']) ? $_POST['security'] : 'None provided'));
 error_log('Received nonce: ' . ($_POST['security'] ?? 'Not sent'));
 error_log('Expected nonce: ' . wp_create_nonce('table_save_nonce'));
 error_log(print_r($_POST, true)); // Logs all POST data sent by the AJAX request

 error_log("Raw POST data: " . file_get_contents('php://input'));
 $updated_value = isset($_POST['updated_value']) ? sanitize_textarea_field($_POST['updated_value']) : '';
 error_log("Updated value after sanitization: " . $updated_value);

// Check if the value has HTML
 if (strip_tags($updated_value) !== $updated_value) {
  error_log("WARNING: Updated value contains HTML tags!");
  // Consider stripping tags if needed
  // $updated_value = strip_tags($updated_value);
 }

 // Verify nonce for security
 if (!check_ajax_referer('table_save_nonce', 'security', false)) {
  wp_send_json_error(['message' => 'Invalid security token']);
  wp_die();
 }

 // Fetch and sanitize inputs
 global $entry_id;
 //$entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
 $entry_id = isset($_POST['entry_id']) ? intval($_POST['entry_id']) : 0;
 $field_label = isset($_POST['field_label']) ? sanitize_text_field($_POST['field_label']) : '';
 $updated_value = isset($_POST['updated_value']) ? sanitize_textarea_field($_POST['updated_value']) : '';
 $field_type = isset($_POST['field_type']) ? sanitize_text_field($_POST['field_type']) : '';

 // Debugging: Log inputs
 error_log("Entry ID Received: $entry_id");
 error_log("Field Label Received: $field_label");
 error_log("Updated Value Received: $updated_value");
 error_log("Field Type Received: $field_type");

 // Retrieve the entry
 $entry = GFAPI::get_entry($entry_id);
 if (is_wp_error($entry)) {
  error_log("Error Retrieving Entry: " . $entry->get_error_message());
  wp_send_json_error(['message' => 'Entry not found: ' . $entry->get_error_message()]);
  wp_die();
 }

 // Debugging: Log the retrieved entry
 error_log("Retrieved Entry: " . print_r($entry, true));

 // Retrieve the form and resolve the field ID
 $form_id = $entry['form_id'];
 $form = GFAPI::get_form($form_id);
 if (empty($form)) {
  error_log("Form not found for Form ID: $form_id");
  wp_send_json_error(['message' => 'Form not found']);
  wp_die();
 }

 // Find field ID based on field label - normalized comparison
 $field_id = null;
 $field_object = null;
 $normalized_field_label = normalize_string_for_comparison($field_label);

 foreach ($form['fields'] as $field) {
  $normalized_current_label = normalize_string_for_comparison($field->label);

  // Compare normalized strings
  if ($normalized_current_label === $normalized_field_label) {
   $field_id = $field->id;
   $field_object = $field;
   break;
  }
 }

// Log the result for debugging
 if ($field_id === null) {
  error_log("Field not found for normalized label: " . $normalized_field_label);
  // Also log all available field labels for comparison
  foreach ($form['fields'] as $field) {
   error_log("Available field: " . $field->label . " (normalized: " . normalize_string_for_comparison($field->label) . ")");
  }
 }

 if (!$field_id) {
  error_log("Field not found for label: $field_label");
  wp_send_json_error(['message' => 'Field not found']);
  wp_die();
 }

 error_log("Field ID found: $field_id, Field Type: " . $field_object->type);

 // Handle different field types differently
 if ($field_object->type === 'checkbox' || $field_type === 'checkbox') {
  error_log("Processing checkbox field: $field_id");

  // For checkbox fields, parse the comma-separated values
  $checkbox_values = array_map('trim', explode(',', $updated_value));
  error_log("Parsed checkbox values: " . print_r($checkbox_values, true));

  // Clear existing checkbox values
  foreach ($entry as $key => $value) {
   if (is_string($key) && strpos($key, $field_id . '.') === 0) {
    $entry[$key] = '';
    error_log("Cleared checkbox value for key: $key");
   }
  }

  // Update with new values - match them to the choices
  if (!empty($checkbox_values) && !empty($field_object->choices)) {
   error_log("Field choices: " . print_r($field_object->choices, true));

   foreach ($field_object->choices as $index => $choice) {
    $choice_text = $choice['text'];
    error_log("Checking choice: $choice_text");

    // If this choice text is in our updated values, mark it as selected
    if (in_array($choice_text, $checkbox_values)) {
     $input_key = $field_id . '.' . ($index + 1);
     $entry[$input_key] = $choice['value'];
     error_log("Selected checkbox value: $input_key = " . $choice['value']);
    }
   }
  }

// Per Claude Add this inside your update_gravity_form_entry function, within the field type handling section
// Per Claude After the checkbox field handling and before the default case

// Handle name fields
 } else if ($field_object->type === 'name' || $field_type === 'name') {
  error_log("Processing name field: $field_id");

  // For name fields, try to split the value into first and last name
  $name_parts = explode(' ', $updated_value, 2);
  $first_name = isset($name_parts[0]) ? trim($name_parts[0]) : '';
  $last_name = isset($name_parts[1]) ? trim($name_parts[1]) : '';

  error_log("Parsed name: First = '$first_name', Last = '$last_name'");

  // Update first name
  if (!empty($first_name)) {
   $entry[$field_id . '.3'] = $first_name;
   error_log("Updated first name: " . $field_id . '.3 = ' . $first_name);
  }

  // Update last name
  if (!empty($last_name)) {
   $entry[$field_id . '.6'] = $last_name;
   error_log("Updated last name: " . $field_id . '.6 = ' . $last_name);
  }

  // Also update the full field for compatibility
  $entry[$field_id] = $updated_value;
  error_log("Updated full name field: $field_id = $updated_value");

 } else if ($field_object->type === 'phone' || $field_type === 'phone' ||
  strpos(strtolower($field_label), 'phone') !== false ||
  strpos(strtolower($field_label), 'telephone') !== false) {


  error_log("Processing phone field: $field_id");

  // Format phone number if needed (optional)
  // You could add phone number formatting here if required

  // For phone fields, we just update the value directly
  $entry[$field_id] = preg_replace('/[^0-9]/', '', $updated_value); // Keep only digits
  error_log("Updated phone field: $field_id = " . $entry[$field_id]);
  /**
   * Per Claude, code !!above!! added to save phone #'s
   */

 } else if ($field_object->type === 'date' || $field_label === 'Trip Arrival Date' || $field_label === 'Trip Departure Date') {
  error_log("Processing date field: $field_id with label: $field_label");

  // Check if the date is in mm/dd/yyyy format
  if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $updated_value)) {
    // Convert from mm/dd/yyyy to Y-m-d format for database storage
    $date = DateTime::createFromFormat('m/d/Y', $updated_value);
    if ($date) {
      $formatted_date = $date->format('Y-m-d');
      $entry[$field_id] = $formatted_date;
      error_log("Converted date from $updated_value to $formatted_date");
    } else {
      // If date parsing fails, log error and store original value
      error_log("Failed to parse date: $updated_value");
      $entry[$field_id] = $updated_value;
    }
  } else {
    // If not in expected format, store as is
    error_log("Date not in expected format: $updated_value");
    $entry[$field_id] = $updated_value;
  }

 } else {
  // For regular fields, just update the value directly
  error_log("Updating regular field: $field_id with value: $updated_value");
  $entry[$field_id] = $updated_value;
 }

 // Update the entry in Gravity Forms
 $result = GFAPI::update_entry($entry);

 if (is_wp_error($result)) {
  error_log("ENTRY UPDATE ERROR: " . $result->get_error_message());
  error_log("Field ID: $field_id");
  error_log("Field Type: " . ($field_object ? $field_object->type : 'unknown'));
  error_log("POST field_type: $field_type");
  error_log("Value attempting to save: " . $updated_value);
  error_log("Entry before update: " . print_r($entry, true));
  error_log("Error updating entry: " . $result->get_error_message());
  wp_send_json_error(['message' => $result->get_error_message()]);
 } else {
  error_log("Entry updated successfully");
  wp_send_json_success(['message' => 'Entry updated successfully']);
 }

 wp_die();
}
