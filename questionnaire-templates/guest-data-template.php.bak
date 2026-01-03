
<?php
/**
 * Template Name: Guest Data Template
 * Template Post Type: travel-form
 * Developed for The Fly Shop
 *
 * @package The_Fly_Shop
 * Author: Chris Parsons
 * Author URL: https://steelbridge.io
 *
 * This template displays and manages guest data from Gravity Forms submissions.
 * It provides search, filtering, and sorting capabilities for guest information.
 */

get_header();

// === HEADER SECTION ===
// Display the page title and content from WordPress
echo '<div id="travel-form-posts" class="container-fluid">';
echo '<div class="container"><h1>' . get_the_title() . '</h1></div>';

if (have_posts()) :
 while (have_posts()) : the_post();
  echo '<div class="post-content container">';
  the_content();
  echo '</div>';
 endwhile;
else :
 echo '<p>' . __('Sorry, no posts matched your criteria.') . '</p>';
endif;

// Get waiver URL from post meta if available
$gda_waiver_url = get_post_meta($post->ID, '_gda_meta_key_waiver_url', true);

// === SEARCH AND FILTER UI SECTION ===
// Create search input, navigation buttons, and filter controls
echo '<div class="container gda-search-wrapper">
        <div class="row display-flex align-items-center">
            <div class="col-md-3">
                <input type="text" id="searchInput" placeholder="Search table..">
            </div>
            <div class="col-md-3">
                <div class="search-buttons d-flex justify-content-center">
                    <button class="btn btn-danger" id="prevMatch">Previous</button>
                    <button class="btn btn-danger" id="nextMatch">Next</button>
                    <span id="matchInfo"></span>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center">
                <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Filter Table
                </button>
            </div>';

// Add waiver button if URL is available
if(!empty($gda_waiver_url)) :
 echo '<div class="col-md-2 d-flex justify-content-center">
                <a class="btn btn-danger" href="' . $gda_waiver_url . '" title="Find Waivers" target="_blank">Find Release Waivers</a>
            </div> ';
endif;

echo '<div class="col-md-2 save-btn d-flex justify-content-center"></div>
        </div>
      </div>';

// === HIDE PAST DATES CHECKBOX SECTION ===
// Add checkbox option to hide past arrival dates
$hide_past_dates = isset($_GET['hide_past_dates']) ? $_GET['hide_past_dates'] : '';
echo '<div class="container gda-hide-past-wrapper">
             <div class="row">
                 <div class="col-12">
                     <div class="form-check mb-3">
                         <input class="form-check-input" type="checkbox" id="hidePastDates" name="hide_past_dates" value="1" ' .
 ($hide_past_dates ? 'checked' : '') . '>
                         <label class="form-check-label" for="hidePastDates">
                             Hide past arrival dates
                         </label>
                     </div>
                 </div>
             </div>
           </div>';

// === COLLAPSIBLE FILTER SECTION ===
// Create date filter UI that expands when "Filter Table" is clicked
echo '<div class="collapse" id="collapseExample">
            <div id="filter-cont" class="container filter-wrap">
                <form method="GET">
                    <div class="row">';
// Filter for arrival date.
$arrival_date = filter_input(INPUT_GET, 'filter_arrival_date', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-12 search-filter-well">
            <label for="filter_arrival_date">Arrival Date:</label>
            <input type="date" id="filter_arrival_date" name="filter_arrival_date" value="' . esc_attr($arrival_date) . '">
            <input class="filter-btn btn btn-danger" type="submit" value="Filter">
                <a href="' . esc_url(strtok((isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '?')) . '" class="btn btn-danger clear-results" title="Clear results">Clear Results</a>
          </div>';

echo '      </div>
            </form>
        </div>
      </div>'; // Close collapse container

// === GRAVITY FORMS DATA RETRIEVAL SECTION ===
// Get form ID from post meta
$guest_number = get_post_meta(get_the_ID(), '_gda_meta_key', true);
if ($guest_number) {
 $form_id = $guest_number;
}
// Prepare search criteria for filtering entries
$search_criteria = [
 'status' => 'active'
];

// Add date filter if provided in GET parameters
if (isset($_GET['filter_arrival_date']) && !empty($_GET['filter_arrival_date'])) {
 try {
  $date = new DateTime($_GET['filter_arrival_date']);
  $arrival_date_formatted = $date->format('Y-m-d');
  $search_criteria['field_filters'][] = ['key' => '46', 'value' => $arrival_date_formatted];
 } catch (Exception $e) {
  error_log('Invalid arrival date: ' . $_GET['filter_arrival_date']);
 }
}

// Add filter for future dates only if hide past dates is checked
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
  error_log('Error setting up future dates filter: ' . $e->getMessage());
 }
}

// === TABLE STRUCTURE AND FIELD MAPPING SECTION ===
if ($form_id) {
 $form = GFAPI::get_form($form_id);
 error_log(print_r($form, true));

 if ($form) {
  // Retrieve form fields dynamically
  $fields = $form['fields'];

  echo '<div class="container form-list-wrap"></div>';
  echo '<div id="question-grid" class="table-wrapper">
            <div class="table-scrollable">
            <table id="gda-table" class="table">
            <thead>
            <tr>';

  // === FIELD CLASSIFICATION SECTION ===
  // Categorize fields by type for special handling
  $name_field = null;
  $allergies_field = null;
  $other_allergies_field = null;
  $special_requests_field = null;
  $reservation_number_field = null;
  $arrival_date_field = ['label' => 'Trip Arrival Date', 'id' => 46, 'type' => 'date'];
  $departure_date_field = ['label' => 'Trip Departure Date', 'id' => 47, 'type' => 'date'];
  $address_fields = [];
  $other_fields = [];

  // Process each field and categorize by field label
  foreach ($fields as $field) {
   if (in_array($field->type, ['section', 'page', 'html', 'captcha'])) {
    continue;
   }

   // Get the field label, or use a default if empty
   $label = !empty($field->label) ? $field->label : 'Field ' . $field->id;

   // Normalize the label to handle special characters, apostrophes, and whitespace variations
   // This ensures consistent matching regardless of character encoding or formatting
   $normalized_label = normalize_string_for_comparison($label);

   // Create a field entry object with both original and normalized labels
   // The normalized label is used for consistent matching while preserving the original label for display
   $field_entry = [
    'label' => $label,
    'id' => $field->id,
    'type' => $field->type,
    'normalized_label' => $normalized_label
   ];

   // Categorize fields based on their normalized labels
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

  // === TABLE HEADER GENERATION SECTION ===
  // Create headers array from categorized fields
  $headers = [];

  // Add important fields first in a specific order
  if ($name_field) $headers[] = $name_field['label'];
  if ($allergies_field) $headers[] = $allergies_field['label'];
  if ($other_allergies_field) $headers[] = $other_allergies_field['label'];
  if ($special_requests_field) $headers[] = $special_requests_field['label'];
  if ($arrival_date_field) $headers[] = $arrival_date_field['label'];
  if ($departure_date_field) $headers[] = $departure_date_field['label'];
  if ($reservation_number_field) $headers[] = $reservation_number_field['label'];

  // Add remaining fields to headers
  foreach ($address_fields as $field) {
   $headers[] = $field['label'];
  }

  foreach ($other_fields as $field) {
   $headers[] = $field['label'];
  }

  // Remove duplicates from headers
  $headers = array_unique($headers);

  // Rendering the table headers - make name column fixed
  foreach ($headers as $header) {
   if ($header === $name_field['label']) {
    echo '<th class="fixed-column">' . esc_html($header) . '</th>';
   } else {
    echo '<th>' . esc_html($header) . '</th>';
   }
  }

  echo '</tr></thead><tbody>';

  // Fetch entries from Gravity Forms (Commented out. See New GFAPI below.)
  //$entries = GFAPI::get_entries($form_id, $search_criteria);

  // === DATA RETRIEVAL SECTION ===
  // Get entries from Gravity Forms with pagination to handle large datasets
  $paging = array(
   'offset'    => 0,     // Start at the first entry
   'page_size' => 1000   // Get up to 1000 entries (adjust as needed)
  );
  $entries = GFAPI::get_entries($form_id, $search_criteria, null, $paging);

  echo '<div class="container mt-3 mb-3"><div class="alert alert-info">Showing ' . count($entries) . ' entries</div></div>';

  // === DATA SORTING SECTION ===
  // Sort entries by arrival date in chronological order (earliest to latest)
  // This puts June dates before August dates (nearest to farthest out)
  // Example: June 15, 2023 -> July 1, 2023 -> August 1, 2023
  usort($entries, function ($a, $b) {
   // Get the arrival date values from entries
   $date_value_a = rgar($a, '46');
   $date_value_b = rgar($b, '46');

   // Create DateTime objects if valid dates
   $date_a = !empty($date_value_a) ? DateTime::createFromFormat('Y-m-d', $date_value_a) : false;
   $date_b = !empty($date_value_b) ? DateTime::createFromFormat('Y-m-d', $date_value_b) : false;

   // Handle cases where one or both dates might be invalid
   if ($date_a && $date_b) {
    // Both dates are valid, compare them in ascending order (earliest first)
    // This puts June dates before August dates (nearest to farthest)
    return $date_a <=> $date_b;
   } elseif ($date_a) {
    // Only date_a is valid, it should come before null dates
    return -1;
   } elseif ($date_b) {
    // Only date_b is valid, it should come before null dates
    return 1;
   } else {
    // Both dates are invalid, keep original order
    return 0;
   }
  });

  // === TABLE ROW GENERATION SECTION ===
  // Render each entry as a table row
  foreach ($entries as $entry) {
   echo '<tr data-entry-id="' . esc_attr($entry['id']) . '">';

   // Collect values in an array to ensure consistent counts
   $row_values = [];

   // === NAME FIELD PROCESSING ===
   if ($name_field) {
    $field_id = $name_field['id'];
    $first_name = rgar($entry, "{$field_id}.3");
    $last_name = rgar($entry, "{$field_id}.6");
    $full_name = trim("$first_name $last_name");
    $name_value = !empty($full_name) ? esc_html($full_name) : '&nbsp;';
    $row_values[$name_field['label']] = $name_value;
   }

   // === OTHER ALLERGIES FIELD PROCESSING ===
   if ($other_allergies_field) {
    $field_id = $other_allergies_field['id'];
    $other_allergies_value = rgar($entry, $field_id);
    $other_allergies_value = !empty($other_allergies_value) ? esc_html($other_allergies_value) : '&nbsp;';
    $row_values[$other_allergies_field['label']] = $other_allergies_value;
   }

   // === SPECIAL REQUESTS FIELD PROCESSING ===
   // Handle long text fields with popover for readability
   if ($special_requests_field) {
    $entry_id = $entry['id'];
    $field_id = $special_requests_field['id'];
    $special_requests_value = rgar($entry, $field_id);

    if (!empty($special_requests_value)) {
     // Create excerpt for display
     $excerpt = (strlen($special_requests_value) > 50) ? substr($special_requests_value, 0, 50) . '...' : $special_requests_value;
     $popover_link = '';

     // For long text, add popover and edit button
     if (strlen($special_requests_value) > 50) {
      $popover_link = ' <a tabindex="0" class="popover-dismiss" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="' . esc_html($special_requests_value) . '">Read More</a>';

      $edit_button = '<button class="edit-long-textarea-btn btn btn-danger table-edit-btn" data-full-content="' . esc_attr($special_requests_value) . '" data-entry-id="' . esc_attr($entry_id) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '" data-field-label="' . esc_attr($special_requests_field['label']) . '">Edit</button>';

      $row_values[$special_requests_field['label']] = '<span class="more-than-fifty" contenteditable="false" data-field-type="textarea"  data-field-label="' . esc_attr($special_requests_field['label']) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '">' . esc_html($excerpt) . '</span>' . $popover_link . $edit_button;
     } else {
      // For short text, make directly editable
      $row_values[$special_requests_field['label']] = '<span class="special-requests-editable" contenteditable="true" data-field-type="textarea" data-field-label="' . esc_attr($special_requests_field['label']) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '">' . esc_html($excerpt) . '</span>';
     }

     // === ALLERGIES CHECKBOX FIELD PROCESSING ===
     if ($allergies_field && $allergies_field['type'] === 'checkbox') {
      $field_id = $allergies_field['id'];
      $checkbox_values = [];

      // Process checkbox field values
      if (isset($allergies_field['choices']) && is_array($allergies_field['choices'])) {
       $choices = $allergies_field['choices'];

       foreach ($choices as $choice) {
        $choice_value = $choice['value'];
        $subfield_key = "{$field_id}.{$choice_value}";
        if (!empty(rgar($entry, $subfield_key))) {
         $checkbox_values[] = esc_html($choice['text']);
        }
       }

       // Fallback if no values found through choices
       if (empty($checkbox_values)) {
        foreach ($entry as $key => $value) {
         if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
          $checkbox_values[] = esc_html($value);
         }
        }
       }
      } else {
       // Handle case where choices not defined
       foreach ($entry as $key => $value) {
        if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
         $checkbox_values[] = esc_html($value);
        }
       }
      }

      // Format checkbox values for display
      $allergies_value = !empty($checkbox_values) ? implode(', ', $checkbox_values) : '&nbsp;';

      // Use a special class for checkbox fields to identify them
      $row_values[$allergies_field['label']] = '<span class="checkbox-field-editable" contenteditable="true" data-field-type="checkbox" data-field-id="' . esc_attr($allergies_field['id']) . '" data-field-label="' . esc_attr($allergies_field['label']) . '">' . $allergies_value . '</span>';
     }

    } else {
     // Handle empty content
     $row_values[$special_requests_field['label']] = '<span class="no-special-requests">No special requests provided</span>';
    }
   }

   // === DATE FIELDS PROCESSING ===
   // Format arrival date for display
   if ($arrival_date_field) {
    $field_id = $arrival_date_field['id'];
    $arrival_date_value = rgar($entry, $field_id);

    // Format date if valid
    if (!empty($arrival_date_value) && DateTime::createFromFormat('Y-m-d', $arrival_date_value)) {
     $date = DateTime::createFromFormat('Y-m-d', $arrival_date_value);
     if ($date) {
      $arrival_date_value = $date->format('m/d/Y');
     }
    } else {
     // Set to empty for empty fields
     $arrival_date_value = '';
    }
    $row_values[$arrival_date_field['label']] = !empty($arrival_date_value) ? esc_html($arrival_date_value) : '&nbsp;';
   }

   // Format departure date for display
   if ($departure_date_field) {
    $field_id = $departure_date_field['id'];
    $departure_date_value = rgar($entry, $field_id);
    if (DateTime::createFromFormat('Y-m-d', $departure_date_value)) {
     $date = new DateTime($departure_date_value);
     $departure_date_value = $date->format('m/d/Y');
    }
    $row_values[$departure_date_field['label']] = !empty($departure_date_value) ? esc_html($departure_date_value) : '&nbsp;';
   }

   // === RESERVATION NUMBER PROCESSING ===
   if ($reservation_number_field) {
    $field_id = $reservation_number_field['id'];
    $reservation_number_value = rgar($entry, $field_id);
    $reservation_number_value = !empty($reservation_number_value) ? esc_html($reservation_number_value) : '&nbsp;';
    $row_values[$reservation_number_field['label']] = $reservation_number_value;
   }

   // === ADDRESS FIELDS PROCESSING ===
   if ($address_fields) {
    foreach ($address_fields as $field) {
     $field_id = $field['id'];
     $street = rgar($entry, "{$field_id}.1");
     $street2 = rgar($entry, "{$field_id}.2");
     $city = rgar($entry, "{$field_id}.3");
     $state = rgar($entry, "{$field_id}.4");
     $zip = rgar($entry, "{$field_id}.5");
     $country = rgar($entry, "{$field_id}.6");

     // Concatenate address parts for display
     $address_value_parts = array_filter([$street, $street2, $city, $state, $zip, $country]);
     $address_value = implode(", ", $address_value_parts);
     $address_value = !empty($address_value) ? esc_html($address_value) : '&nbsp;';
     $row_values[$field['label']] = $address_value;
    }
   }

   // === OTHER FIELDS PROCESSING ===
   // Process all remaining fields based on their type
   foreach ($other_fields as $field) {
    $field_id = $field['id'];
    $cell_value = rgar($entry, $field_id);
    $field_label = $field['label']; // Store field label explicitly for clarity

    // Check for special field types
    $is_emergency_contact = (strtolower($field_label) === 'emergency contact person name');
    $is_phone_field = ($field['type'] === 'phone' ||
     strpos(strtolower($field_label), 'phone') !== false ||
     strpos(strtolower($field_label), 'telephone') !== false);

    // Handle specific field types with appropriate formatting
    switch ($field['type']) {
     // Date field formatting
     case 'date':
      if (!empty($cell_value)) {
       try {
        $date = DateTime::createFromFormat('Y-m-d', $cell_value);
        if ($date) {
         $cell_value = $date->format('m/d/Y');
        }
       } catch (Exception $e) {
        // Keep original value if parsing fails
       }
      } else {
       $cell_value = '&nbsp;';
      }
      break;
     // Multi-select field formatting
     case 'multiselect':
      $cell_value = !empty($cell_value) ? esc_html(implode(', ', $cell_value)) : '&nbsp;';
      break;
     // Checkbox field formatting
     case 'checkbox':
      $checkbox_values = [];
      foreach ($entry as $key => $value) {
       if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
        $checkbox_values[] = esc_html($value);
       }
      }
      $cell_value = !empty($checkbox_values) ? implode(', ', $checkbox_values) : '&nbsp;';
      break;
     // Text area field with popover for long content
     case 'textarea':
      $excerpt = (strlen($cell_value) > 50) ? substr($cell_value, 0, 50) . '...' : $cell_value;
      $popover_link = '';
      if (strlen($cell_value) > 50) {
       $popover_link = ' <a tabindex="0" class="popover-dismiss" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="' . esc_html($cell_value) . '">Read More</a>';
       $edit_button = '<button class="edit-long-textarea-btn-two btn btn-danger table-edit-btn" data-entry-id="' . esc_attr($entry_id) . '" data-field-label="' . esc_attr($field_label) . '" data-full-content="' . esc_attr($cell_value) . '">Edit</button>';
       $cell_value = '<span class="standardtext-more-than-fifty" contenteditable="false" data-field-type="textarea"  data-field-label="' . esc_attr($field_label) . '" data-excerpt="' . esc_attr($excerpt) . '">' . esc_html($excerpt) . '</span>' . $popover_link . $edit_button;
      } else {
       $cell_value = '<span class="standardtext-less-than-fifty" contenteditable="true" data-field-label="' . esc_attr($field_label) . '" data-excerpt="' . esc_attr($excerpt) . '">' . esc_html($excerpt) . '</span>';
      }
      break;
     // Address field formatting
     case 'address':
      $street = rgar($entry, "{$field_id}.1");
      $street2 = rgar($entry, "{$field_id}.2");
      $city = rgar($entry, "{$field_id}.3");
      $state = rgar($entry, "{$field_id}.4");
      $zip = rgar($entry, "{$field_id}.5");
      $country = rgar($entry, "{$field_id}.6");
      $address_value_parts = array_filter([$street, $street2, $city, $state, $zip, $country]);
      $cell_value = implode(', ', $address_value_parts);
      $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
      break;
     // Name field formatting
     case 'name':
      $first_name = rgar($entry, "{$field_id}.3");
      $last_name = rgar($entry, "{$field_id}.6");
      $full_name = trim("$first_name $last_name");
      $display_value = !empty($full_name) ? esc_html($full_name) : '&nbsp;';
      $cell_value = '<span class="name-field-editable" contenteditable="true" ' .
       'data-field-type="name" ' .
       'data-field-id="' . esc_attr($field_id) . '" ' .
       'data-field-label="' . esc_attr($field_label) . '">' .
       $display_value . '</span>';
      break;
     // Phone field formatting with editing capability
     case 'phone':
      $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
      $cell_value = '<span class="phone-field-editable" contenteditable="true" ' .
       'data-field-type="phone" ' .
       'data-field-id="' . esc_attr($field_id) . '" ' .
       'data-field-label="' . esc_attr($field_label) . '">' .
       $cell_value . '</span>';
      break;
     // Default field handling with special cases
     default:
      if ($is_emergency_contact) {
       // Special handling for emergency contact fields
       $cell_value = '<span class="name-field-editable" contenteditable="true" ' .
        'data-field-type="name" ' .
        'data-field-id="' . esc_attr($field_id) . '" ' .
        'data-field-label="' . esc_attr($field_label) . '">' .
        (!empty($cell_value) ? esc_html($cell_value) : '&nbsp;') . '</span>';
      } else {
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';

       // Add contenteditable for simple text fields
       if (!in_array($field['type'], ['section', 'page', 'html', 'captcha'])) {
        $cell_value = '<span class="standard-field-editable" contenteditable="true" ' .
         'data-field-type="' . esc_attr($field['type']) . '" ' .
         'data-field-id="' . esc_attr($field_id) . '" ' .
         'data-field-label="' . esc_attr($field_label) . '">' .
         $cell_value . '</span>';
       }

      }
      // Special handling for phone-like fields
      if ($is_phone_field) {
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
       $cell_value = '<span class="phone-field-editable" contenteditable="true" ' .
        'data-field-type="phone" ' .
        'data-field-id="' . esc_attr($field_id) . '" ' .
        'data-field-label="' . esc_attr($field_label) . '">' .
        $cell_value . '</span>';
      } else if (!in_array($field['type'], ['section', 'page', 'html', 'captcha'])) {
       // Regular field rendering with proper data attributes
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
       $cell_value = '<span class="standard-field-editable" contenteditable="true" ' .
        'data-field-type="' . esc_attr($field['type']) . '" ' .
        'data-field-id="' . esc_attr($field_id) . '" ' .
        'data-field-label="' . esc_attr($field_label) . '">' .
        $cell_value . '</span>';
      } else {
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
      }
    }
    $row_values[$field['label']] = $cell_value;
   }

   // Create normalized array for matching -- ADDED PER CLAUDE
   $normalized_row_values = [];
   foreach ($row_values as $key => $value) {
    $normalized_key = normalize_string_for_comparison($key);
    $normalized_row_values[$normalized_key] = $value;
   }

   // === TABLE CELL RENDERING SECTION ===
   // Output all cells in the correct order with proper formatting
   foreach ($headers as $header) {
    $normalized_header = normalize_string_for_comparison($header);

    if ($header === $name_field['label']) {
     echo '<td class="fixed-column">' . ($row_values[$header] ?? '&nbsp;') . '</td>';
    } else {
     // Try exact match first, then normalized match
     $cell_content = $row_values[$header] ?? $normalized_row_values[$normalized_header] ?? '&nbsp;';

     // Add contenteditable attribute to cells without it
     if (strpos($cell_content, 'contenteditable="true"') === false &&
      strpos($cell_content, 'data-bs-toggle="popover"') === false) {
      echo '<td><span class="no-popover" contenteditable="true" data-field-label="' . esc_attr($header) . '">' . $cell_content . '</span></td>';
     } else {
      echo '<td>' . $cell_content . '</td>';
     }
    }
   }

   echo '</tr>';
  }

  // Close table structure

  echo '</tbody>'; // End tbody
  echo '</table>'; // End table
  echo '</div>'; // End table-scrollable
  echo '</div>'; // End table-wrapper
 } else {
  echo '<p>Form with ID ' . esc_html($form_id) . ' not found.</p>';
 }
}
echo '</div>'; // End travel-form-posts div

// === JAVASCRIPT FOR CHECKBOX FUNCTIONALITY ===
// Add JavaScript to handle the checkbox interaction
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    const hidePastDatesCheckbox = document.getElementById("hidePastDates");
    
    if (hidePastDatesCheckbox) {
        hidePastDatesCheckbox.addEventListener("change", function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            if (this.checked) {
                urlParams.set("hide_past_dates", "1");
            } else {
                urlParams.delete("hide_past_dates");
            }
            
            // Preserve other existing parameters
            const newUrl = window.location.pathname + "?" + urlParams.toString();
            window.location.href = newUrl;
        });
    }
});
</script>';

get_footer();