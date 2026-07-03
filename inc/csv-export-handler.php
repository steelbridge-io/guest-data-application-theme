<?php
/**
 * CSV Export Handler for Guest Data App
 * 
 * Handles AJAX requests to export filtered guest data tables to CSV format.
 * Respects all active filters (date, year, hide past dates).
 * 
 * @package Guest_Data_Application_Theme
 * Author: Chris Parsons
 */

// AJAX handler for logged-in users
add_action('wp_ajax_export_guest_data_csv', 'export_guest_data_csv');

// AJAX handler for non-logged-in users (if needed)
add_action('wp_ajax_nopriv_export_guest_data_csv', 'export_guest_data_csv');

/**
 * Export guest data to CSV format
 * 
 * @return void Outputs CSV file and terminates
 */
function export_guest_data_csv() {
    // Verify nonce for security
    if (!check_ajax_referer('csv_export_nonce', 'security', false)) {
        wp_send_json_error(['message' => 'Invalid security token']);
        wp_die();
    }

    // Get form ID from POST
    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    
    if (!$form_id) {
        wp_send_json_error(['message' => 'No form ID provided']);
        wp_die();
    }

    // Get filter parameters
    $hide_past_dates = isset($_POST['hide_past_dates']) ? $_POST['hide_past_dates'] === '1' : false;
    $filter_year = isset($_POST['filter_year']) ? sanitize_text_field($_POST['filter_year']) : '';
    $arrival_date = isset($_POST['filter_arrival_date']) ? sanitize_text_field($_POST['filter_arrival_date']) : '';
    $destination_title = isset($_POST['destination_title']) ? sanitize_text_field($_POST['destination_title']) : 'Guest Data';

    // Build search criteria matching the table filters
    $search_criteria = ['status' => 'active'];

    // Add arrival date filter
    if (!empty($arrival_date)) {
        try {
            $date = new DateTime($arrival_date);
            $arrival_date_formatted = $date->format('Y-m-d');
            $search_criteria['field_filters'][] = [
                'key' => '46',
                'value' => $arrival_date_formatted
            ];
        } catch (Exception $e) {
            error_log('Invalid arrival date for CSV export: ' . $arrival_date);
        }
    }

    // Add filter for future dates only
    if ($hide_past_dates) {
        try {
            $today = new DateTime();
            $today_formatted = $today->format('Y-m-d');
            $search_criteria['field_filters'][] = [
                'key' => '46',
                'value' => $today_formatted,
                'operator' => '>='
            ];
        } catch (Exception $e) {
            error_log('Error setting up future dates filter for CSV: ' . $e->getMessage());
        }
    }

    // Add year filter
    if ($filter_year && is_numeric($filter_year) && strlen($filter_year) === 4) {
        try {
            $year_start = $filter_year . '-01-01';
            $year_end = $filter_year . '-12-31';

            $start_date = DateTime::createFromFormat('Y-m-d', $year_start);
            $end_date = DateTime::createFromFormat('Y-m-d', $year_end);

            if ($start_date && $end_date) {
                $search_criteria['field_filters'][] = [
                    'key' => '46',
                    'value' => $year_start,
                    'operator' => '>='
                ];
                $search_criteria['field_filters'][] = [
                    'key' => '46',
                    'value' => $year_end,
                    'operator' => '<='
                ];
            }
        } catch (Exception $e) {
            error_log('Error setting up year filter for CSV: ' . $e->getMessage());
        }
    }

    // Get entries from Gravity Forms
    $paging = array(
        'offset'    => 0,
        'page_size' => 1000
    );
    $entries = GFAPI::get_entries($form_id, $search_criteria, null, $paging);

    if (is_wp_error($entries) || empty($entries)) {
        wp_send_json_error(['message' => 'No entries found to export']);
        wp_die();
    }

    // Get form structure
    $form = GFAPI::get_form($form_id);
    if (!$form) {
        wp_send_json_error(['message' => 'Form not found']);
        wp_die();
    }

    // Sort entries by arrival date (same as table display)
    usort($entries, function ($a, $b) {
        $date_value_a = rgar($a, '46');
        $date_value_b = rgar($b, '46');

        $date_a = !empty($date_value_a) ? DateTime::createFromFormat('Y-m-d', $date_value_a) : false;
        $date_b = !empty($date_value_b) ? DateTime::createFromFormat('Y-m-d', $date_value_b) : false;

        if ($date_a && $date_b) {
            return $date_a <=> $date_b;
        } elseif ($date_a) {
            return -1;
        } elseif ($date_b) {
            return 1;
        } else {
            return 0;
        }
    });

    // Build CSV data
    $csv_data = build_csv_from_entries($entries, $form);

    // Generate filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $filename = sanitize_file_name($destination_title) . '_export_' . $timestamp . '.csv';

    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output CSV
    echo $csv_data;

    wp_die();
}

/**
 * Build CSV string from entries
 * 
 * @param array $entries Gravity Forms entries
 * @param array $form Gravity Forms form structure
 * @return string CSV formatted data
 */
function build_csv_from_entries($entries, $form) {
    $fields = $form['fields'];

    // Categorize fields (same logic as template)
    $name_field = null;
    $allergies_field = null;
    $other_allergies_field = null;
    $special_requests_field = null;
    $reservation_number_field = null;
    $arrival_date_field = ['label' => 'Trip Arrival Date', 'id' => 46, 'type' => 'date'];
    $departure_date_field = ['label' => 'Trip Departure Date', 'id' => 47, 'type' => 'date'];
    $address_fields = [];
    $other_fields = [];

    // Include the normalize function if not already available
    if (!function_exists('normalize_string_for_comparison')) {
        require_once get_template_directory() . '/inc/table-ajax-logic.php';
    }

    foreach ($fields as $field) {
        if (in_array($field->type, ['section', 'page', 'html', 'captcha'])) {
            continue;
        }

        $label = !empty($field->label) ? $field->label : 'Field ' . $field->id;
        $normalized_label = normalize_string_for_comparison($label);

        $field_entry = [
            'label' => $label,
            'id' => $field->id,
            'type' => $field->type,
            'normalized_label' => $normalized_label
        ];

        switch ($normalized_label) {
            case 'name':
                $name_field = $field_entry;
                break;
            case 'allergies food and environmental':
                $allergies_field = $field_entry;
                break;
            case 'other allergies':
                $other_allergies_field = $field_entry;
                break;
            case 'please list any special requests needs health concerns physical challenges':
                $special_requests_field = $field_entry;
                break;
            case 'reservation number':
                $reservation_number_field = $field_entry;
                break;
            case 'address':
                $address_fields[] = $field_entry;
                break;
            default:
                $other_fields[] = $field_entry;
                break;
        }
    }

    // Build headers array (same order as table)
    $headers = [];
    if ($name_field) $headers[] = $name_field['label'];
    if ($allergies_field) $headers[] = $allergies_field['label'];
    if ($other_allergies_field) $headers[] = $other_allergies_field['label'];
    if ($special_requests_field) $headers[] = $special_requests_field['label'];
    if ($arrival_date_field) $headers[] = $arrival_date_field['label'];
    if ($departure_date_field) $headers[] = $departure_date_field['label'];
    if ($reservation_number_field) $headers[] = $reservation_number_field['label'];

    foreach ($address_fields as $field) {
        $headers[] = $field['label'];
    }

    foreach ($other_fields as $field) {
        $headers[] = $field['label'];
    }

    $headers = array_unique($headers);

    // Create field map for easy lookup
    $field_map = [];
    if ($name_field) $field_map[$name_field['label']] = $name_field;
    if ($allergies_field) $field_map[$allergies_field['label']] = $allergies_field;
    if ($other_allergies_field) $field_map[$other_allergies_field['label']] = $other_allergies_field;
    if ($special_requests_field) $field_map[$special_requests_field['label']] = $special_requests_field;
    if ($arrival_date_field) $field_map[$arrival_date_field['label']] = $arrival_date_field;
    if ($departure_date_field) $field_map[$departure_date_field['label']] = $departure_date_field;
    if ($reservation_number_field) $field_map[$reservation_number_field['label']] = $reservation_number_field;

    foreach ($address_fields as $field) {
        $field_map[$field['label']] = $field;
    }

    foreach ($other_fields as $field) {
        $field_map[$field['label']] = $field;
    }

    // Start building CSV
    $output = fopen('php://temp', 'r+');

    // Write header row
    fputcsv($output, $headers);

    // Write data rows
    foreach ($entries as $entry) {
        $row = [];

        foreach ($headers as $header) {
            $field_info = $field_map[$header];
            $field_id = $field_info['id'];
            $field_type = $field_info['type'];

            $value = '';

            // Handle different field types
            if ($field_type === 'name') {
                $first_name = rgar($entry, "{$field_id}.3");
                $last_name = rgar($entry, "{$field_id}.6");
                $value = trim("$first_name $last_name");
            } elseif ($field_type === 'date') {
                $date_value = rgar($entry, $field_id);
                if (!empty($date_value)) {
                    $date = DateTime::createFromFormat('Y-m-d', $date_value);
                    if ($date) {
                        $value = $date->format('m/d/Y');
                    } else {
                        $value = $date_value;
                    }
                }
            } elseif ($field_type === 'checkbox') {
                // Collect all checked values
                $checkbox_values = [];
                foreach ($entry as $key => $entry_value) {
                    if (is_string($key) && strpos($key, $field_id . '.') === 0 && !empty($entry_value)) {
                        $checkbox_values[] = $entry_value;
                    }
                }
                $value = implode(', ', $checkbox_values);
            } elseif ($field_type === 'address') {
                // Build full address from parts
                $street = rgar($entry, $field_id . '.1');
                $street2 = rgar($entry, $field_id . '.2');
                $city = rgar($entry, $field_id . '.3');
                $state = rgar($entry, $field_id . '.4');
                $zip = rgar($entry, $field_id . '.5');
                $country = rgar($entry, $field_id . '.6');

                $address_parts = array_filter([$street, $street2, $city, $state, $zip, $country]);
                $value = implode(', ', $address_parts);
            } else {
                // Regular field
                $value = rgar($entry, $field_id);
            }

            // Clean up value
            $value = strip_tags($value); // Remove HTML
            $value = str_replace(["\r\n", "\r", "\n"], ' ', $value); // Replace line breaks with spaces
            
            $row[] = $value;
        }

        fputcsv($output, $row);
    }

    // Get CSV content
    rewind($output);
    $csv_data = stream_get_contents($output);
    fclose($output);

    return $csv_data;
}
