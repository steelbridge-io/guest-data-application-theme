<?php

function display_gravity_form_entry($atts) {
 $atts = shortcode_atts(
  array(
   'id' => '32',  // Form ID
   'entry_id' => '55479',  // Entry ID 55479
  ),
  $atts
 );

 if (empty($atts['id']) || empty($atts['entry_id'])) {
  return 'Please provide a form ID and entry ID.';
 }

 $form_id = intval($atts['id']);
 $entry_id = intval($atts['entry_id']);

 if (!class_exists('GFAPI')) {
  return 'Gravity Forms is not installed or activated.';
 }

 $entry = GFAPI::get_entry($entry_id);
 if (is_wp_error($entry)) {
  return 'Entry not found.';
 }

 $form = GFAPI::get_form($form_id);
 if (!$form) {
  return 'Form not found.';
 }

 /*$output = '<div class="gravity-form-entry">';
 foreach ($form['fields'] as $field) {
  if (!isset($entry[$field->id])) continue;
  $label = esc_html($field->label);
  $value = esc_html($entry[$field->id]);
  $output .= "<p><strong>{$label}:</strong> {$value}</p>";
 }
 $output .= '</div>';

 return $output; */

 $output = '<div class="gravity-form-entry">';
 foreach ($form['fields'] as $field) {
  // If it's an HTML field, output its content
  if ($field->type == 'html') {
   $output .= "<div>" . $field->content . "</div>";
  }
  // For other field types, output their data from the entry
  else if (isset($entry[$field->id])) {
   $label = esc_html($field->label);
   $value = esc_html($entry[$field->id]);
   $output .= "<p><strong>{$label}:</strong> {$value}</p>";
  }
 }
 $output .= '</div>';

 return $output;
}
add_shortcode('gf_entry', 'display_gravity_form_entry');

