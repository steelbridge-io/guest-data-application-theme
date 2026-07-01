
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

// Get waiver URL and filter variables
$gda_waiver_url = get_post_meta($post->ID, '_gda_meta_key_waiver_url', true);
$hide_past_dates = isset($_GET['hide_past_dates']) ? $_GET['hide_past_dates'] : '';
$filter_year = isset($_GET['filter_year']) ? sanitize_text_field($_GET['filter_year']) : '';
$arrival_date = filter_input(INPUT_GET, 'filter_arrival_date', FILTER_SANITIZE_SPECIAL_CHARS);

// === GRAVITY FORMS DATA RETRIEVAL SECTION ===
// Get form ID from post meta
$guest_number = get_post_meta(get_the_ID(), '_gda_meta_key', true);
if ($guest_number) {
 $form_id = $guest_number;
}

// Prepare search criteria for filtering entries
$search_criteria = ['status' => 'active'];

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

// Add year filter if provided in GET parameters
if ($filter_year && is_numeric($filter_year) && strlen($filter_year) === 4) {
 try {
  // Create date range for the entire year
  $year_start = $filter_year . '-01-01';
  $year_end = $filter_year . '-12-31';

  // Validate the year input
  $start_date = DateTime::createFromFormat('Y-m-d', $year_start);
  $end_date = DateTime::createFromFormat('Y-m-d', $year_end);

  if ($start_date && $end_date) {
   // Add date range filter for the specified year
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
  error_log('Error setting up year filter: ' . $e->getMessage());
 }
}

// Get entries from Gravity Forms with pagination to handle large datasets
$entries = [];
if ($form_id) {
 $paging = array(
  'offset'    => 0,     // Start at the first entry
  'page_size' => 1000   // Get up to 1000 entries (adjust as needed)
 );
 $entries = GFAPI::get_entries($form_id, $search_criteria, null, $paging);
}


// === SEARCH AND FILTER UI SECTION ===
// Create search input, navigation buttons, and filter controls
echo '<div class="container">
        <!-- Minimize/Expand Control -->
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between align-items-center bg-light p-2 rounded">
                <h6 class="mb-0 text-muted">
                    <i class="bi bi-gear-fill me-2"></i>Table Controls
                </h6>
                <button class="btn btn-outline-secondary btn-sm" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#table-controls" 
                        aria-expanded="true" 
                        aria-controls="table-controls"
                        id="toggleTableControls">
                    <span class="fw-bold" id="toggleIcon">−</span> 
                    <span id="toggleText">Minimize</span>
                </button>
            </div>
        </div>
    </div>';

echo '<div id="table-controls" class="container gda-search-wrapper collapse show">
        <div class="row g-2 align-items-center mb-3">
            <div class="col-md-4">
                <div class="input-group" style="flex-wrap: nowrap;">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search table..">
                </div>
            </div>
            <div class="col-md-2 prev-next-spacing">
                <div class="btn-group d-flex" role="group">
                    <button class="btn btn-outline-danger btn-sm" id="prevMatch">
                        <i class="bi bi-chevron-left"></i> Prev
                    </button>
                    <button class="btn btn-outline-danger btn-sm" id="nextMatch">
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="text-center mt-1">
                    <small class="text-muted" id="matchInfo"></small>
                </div>
            </div>
            <div class="col-md-2 text-center">
                <button class="btn btn-danger" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapseExample" 
                        aria-expanded="false" 
                        aria-controls="collapseExample">
                    <i class="bi bi-funnel-fill me-1"></i>Filter Options
                </button>
            </div>';

// Add waiver button if URL is available, otherwise add empty column for consistent layout
if(!empty($gda_waiver_url)) {
 echo '<div class="col-md-2 text-center">
                <a class="btn btn-success" href="' . $gda_waiver_url . '" title="Find Waivers" target="_blank">
                    <i class="bi bi-file-text me-1"></i>Waivers
                </a>
            </div>';
} else {
 //echo '<div class="col-md-2"></div>'; // Empty column for consistent layout
 '';
}

// CRITICAL: This is the exact element your JavaScript targets for the save button
echo '<div class="col-md-2 save-btn d-flex justify-content-center"></div>
        </div>';

        echo '<div class="collapse" id="collapseExample">
            <div id="filter-cont" class="container filter-wrap">
                <form method="GET">
                    <div class="row">
                        <!-- Date Filter -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="filter-group">
                                <label for="filter_arrival_date" class="form-label fw-bold">Filter by Arrival Date</label>
                                <div class="input-group">
                                    <input type="date" id="filter_arrival_date" name="filter_arrival_date" 
                                           class="form-control" value="' . esc_attr($arrival_date) . '">
                                    <button class="btn btn-danger" type="submit">Apply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Year Filter -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="filter-group">
                                <label for="filterYear" class="form-label fw-bold">Filter by Year</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="filterYear" name="filter_year" 
                                           value="' . esc_attr($filter_year) . '" 
                                           placeholder="e.g., 2024" 
                                           min="2020" 
                                           max="2030" 
                                           step="1">
                                    <button class="btn btn-danger" type="button" id="applyYearFilter">Apply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Options -->
                        <div class="col-12 col-lg-4">
                            <div class="filter-group">
                                <label class="form-label fw-bold">Quick Options</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="hidePastDates" 
                                           name="hide_past_dates" value="1" ' . ($hide_past_dates ? 'checked' : '') . '>
                                    <label class="form-check-label" for="hidePastDates">
                                        Hide past arrival dates
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons row -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                <!-- Filter buttons on the left -->
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-danger">Apply Filters</button>
                                    <a href="' . esc_url(strtok((isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '?')) . '" 
                                       class="btn btn-outline-secondary">Clear All Filters</a>
                                    ' . ($filter_year ? '<button class="btn btn-outline-warning" id="clearYearFilter" type="button">Clear Year Filter</button>' : '') . '
                                </div>
                                
                                <!-- Save button on the right -->
                                <!-- <div class="save-btn"></div> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Status indicators row - compact and non-intrusive -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="d-flex flex-wrap align-items-center gap-3 small text-muted">
                    <!-- Entry count badge -->
                    <span class="badge bg-secondary">
                        Showing ' . count($entries) . ' entries
                    </span>';

// Build filter status messages
$filter_status_messages = [];
if ($hide_past_dates) {
 $filter_status_messages[] = 'Hiding past dates';
}
if ($filter_year) {
 $filter_status_messages[] = 'Year: ' . esc_html($filter_year);
}
if (!empty($arrival_date)) {
 $filter_status_messages[] = 'Date: ' . esc_html($arrival_date);
}

if (!empty($filter_status_messages)) {
 echo '<span class="badge bg-success">
            Active filters: ' . implode(' | ', $filter_status_messages) . '
        </span>';
}

echo '              </div>
            </div>
        </div>
    </div>'; // This closes the table-controls container

// === TABLE STRUCTURE AND FIELD MAPPING SECTION ===
if ($form_id) {
 $form = GFAPI::get_form($form_id);

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
   $normalized_label = normalize_string_for_comparison($label);

   // Create a field entry object with both original and normalized labels
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

  // === DATA SORTING SECTION ===
  // Sort entries by arrival date in chronological order (earliest to latest)
  usort($entries, function ($a, $b) {
   // Get the arrival date values from entries
   $date_value_a = rgar($a, '46');
   $date_value_b = rgar($b, '46');

   // Create DateTime objects if valid dates
   $date_a = !empty($date_value_a) ? DateTime::createFromFormat('Y-m-d', $date_value_a) : false;
   $date_b = !empty($date_value_b) ? DateTime::createFromFormat('Y-m-d', $date_value_b) : false;

   // Handle cases where one or both dates might be invalid
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
   if ($special_requests_field) {
    $entry_id = $entry['id'];
    $field_id = $special_requests_field['id'];
    $special_requests_value = rgar($entry, $field_id);

    if (!empty($special_requests_value)) {
     $excerpt = (strlen($special_requests_value) > 50) ? substr($special_requests_value, 0, 50) . '...' : $special_requests_value;
     $popover_link = '';

     if (strlen($special_requests_value) > 50) {
      $popover_link = ' <a tabindex="0" class="popover-dismiss" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="' . esc_html($special_requests_value) . '">Read More</a>';
      $edit_button = '<button class="edit-long-textarea-btn btn btn-danger table-edit-btn" data-full-content="' . esc_attr($special_requests_value) . '" data-entry-id="' . esc_attr($entry_id) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '" data-field-label="' . esc_attr($special_requests_field['label']) . '">Edit</button>';
      $row_values[$special_requests_field['label']] = '<span class="more-than-fifty" contenteditable="false" data-field-type="textarea"  data-field-label="' . esc_attr($special_requests_field['label']) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '">' . esc_html($excerpt) . '</span>' . $popover_link . $edit_button;
     } else {
      $row_values[$special_requests_field['label']] = '<span class="special-requests-editable" contenteditable="true" data-field-type="textarea" data-field-label="' . esc_attr($special_requests_field['label']) . '" data-field-id="' . esc_attr($special_requests_field['id']) . '">' . esc_html($excerpt) . '</span>';
     }

     // === ALLERGIES CHECKBOX FIELD PROCESSING ===
     if ($allergies_field && $allergies_field['type'] === 'checkbox') {
      $field_id = $allergies_field['id'];
      $checkbox_values = [];

      if (isset($allergies_field['choices']) && is_array($allergies_field['choices'])) {
       $choices = $allergies_field['choices'];
       foreach ($choices as $choice) {
        $choice_value = $choice['value'];
        $subfield_key = "{$field_id}.{$choice_value}";
        if (!empty(rgar($entry, $subfield_key))) {
         $checkbox_values[] = esc_html($choice['text']);
        }
       }

       if (empty($checkbox_values)) {
        foreach ($entry as $key => $value) {
         if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
          $checkbox_values[] = esc_html($value);
         }
        }
       }
      } else {
       foreach ($entry as $key => $value) {
        if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
         $checkbox_values[] = esc_html($value);
        }
       }
      }

      $allergies_value = !empty($checkbox_values) ? implode(', ', $checkbox_values) : '&nbsp;';
      $row_values[$allergies_field['label']] = '<span class="checkbox-field-editable" contenteditable="true" data-field-type="checkbox" data-field-id="' . esc_attr($allergies_field['id']) . '" data-field-label="' . esc_attr($allergies_field['label']) . '">' . $allergies_value . '</span>';
     }
    } else {
     $row_values[$special_requests_field['label']] = '<span class="no-special-requests">No special requests provided</span>';
    }
   }

   // === DATE FIELDS PROCESSING ===
   if ($arrival_date_field) {
    $field_id = $arrival_date_field['id'];
    $arrival_date_value = rgar($entry, $field_id);

    if (!empty($arrival_date_value) && DateTime::createFromFormat('Y-m-d', $arrival_date_value)) {
     $date = DateTime::createFromFormat('Y-m-d', $arrival_date_value);
     if ($date) {
      $arrival_date_value = $date->format('m/d/Y');
     }
    } else {
     $arrival_date_value = '';
    }
    $row_values[$arrival_date_field['label']] = !empty($arrival_date_value) ? esc_html($arrival_date_value) : '&nbsp;';
   }

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

     $address_value_parts = array_filter([$street, $street2, $city, $state, $zip, $country]);
     $address_value = implode(", ", $address_value_parts);
     $address_value = !empty($address_value) ? esc_html($address_value) : '&nbsp;';
     $row_values[$field['label']] = $address_value;
    }
   }

   // === OTHER FIELDS PROCESSING ===
   foreach ($other_fields as $field) {
    $field_id = $field['id'];
    $cell_value = rgar($entry, $field_id);
    $field_label = $field['label'];

    $is_emergency_contact = (strtolower($field_label) === 'emergency contact person name');
    $is_phone_field = ($field['type'] === 'phone' ||
     strpos(strtolower($field_label), 'phone') !== false ||
     strpos(strtolower($field_label), 'telephone') !== false);

    switch ($field['type']) {
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
     case 'multiselect':
      $cell_value = !empty($cell_value) ? esc_html(implode(', ', $cell_value)) : '&nbsp;';
      break;
     case 'checkbox':
      $checkbox_values = [];
      foreach ($entry as $key => $value) {
       if (strpos($key, "{$field_id}.") === 0 && !empty($value)) {
        $checkbox_values[] = esc_html($value);
       }
      }
      $cell_value = !empty($checkbox_values) ? implode(', ', $checkbox_values) : '&nbsp;';
      break;
     case 'textarea':
      $excerpt = (strlen($cell_value) > 50) ? substr($cell_value, 0, 50) . '...' : $cell_value;
      $popover_link = '';
      if (strlen($cell_value) > 50) {
       $popover_link = ' <a tabindex="0" class="popover-dismiss" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="' . esc_html($cell_value) . '">Read More</a>';
       $edit_button = '<button class="edit-long-textarea-btn-two btn btn-danger table-edit-btn" data-entry-id="' . esc_attr($entry['id']) . '" data-field-label="' . esc_attr($field_label) . '" data-full-content="' . esc_attr($cell_value) . '">Edit</button>';
       $cell_value = '<span class="standardtext-more-than-fifty" contenteditable="false" data-field-type="textarea"  data-field-label="' . esc_attr($field_label) . '" data-excerpt="' . esc_attr($excerpt) . '">' . esc_html($excerpt) . '</span>' . $popover_link . $edit_button;
      } else {
       $cell_value = '<span class="standardtext-less-than-fifty" contenteditable="true" data-field-label="' . esc_attr($field_label) . '" data-excerpt="' . esc_attr($excerpt) . '">' . esc_html($excerpt) . '</span>';
      }
      break;
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
     case 'phone':
      $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
      $cell_value = '<span class="phone-field-editable" contenteditable="true" ' .
       'data-field-type="phone" ' .
       'data-field-id="' . esc_attr($field_id) . '" ' .
       'data-field-label="' . esc_attr($field_label) . '">' .
       $cell_value . '</span>';
      break;
     default:
      if ($is_emergency_contact) {
       $cell_value = '<span class="name-field-editable" contenteditable="true" ' .
        'data-field-type="name" ' .
        'data-field-id="' . esc_attr($field_id) . '" ' .
        'data-field-label="' . esc_attr($field_label) . '">' .
        (!empty($cell_value) ? esc_html($cell_value) : '&nbsp;') . '</span>';
      } else {
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';

       if (!in_array($field['type'], ['section', 'page', 'html', 'captcha'])) {
        $cell_value = '<span class="standard-field-editable" contenteditable="true" ' .
         'data-field-type="' . esc_attr($field['type']) . '" ' .
         'data-field-id="' . esc_attr($field_id) . '" ' .
         'data-field-label="' . esc_attr($field_label) . '">' .
         $cell_value . '</span>';
       }
      }

      if ($is_phone_field) {
       $cell_value = !empty($cell_value) ? esc_html($cell_value) : '&nbsp;';
       $cell_value = '<span class="phone-field-editable" contenteditable="true" ' .
        'data-field-type="phone" ' .
        'data-field-id="' . esc_attr($field_id) . '" ' .
        'data-field-label="' . esc_attr($field_label) . '">' .
        $cell_value . '</span>';
      }
    }
    $row_values[$field['label']] = $cell_value;
   }

   // Create normalized array for matching
   $normalized_row_values = [];
   foreach ($row_values as $key => $value) {
    $normalized_key = normalize_string_for_comparison($key);
    $normalized_row_values[$normalized_key] = $value;
   }

   // === TABLE CELL RENDERING SECTION ===
   foreach ($headers as $header) {
    $normalized_header = normalize_string_for_comparison($header);

    if ($header === $name_field['label']) {
     echo '<td class="fixed-column">' . ($row_values[$header] ?? '&nbsp;') . '</td>';
    } else {
     $cell_content = $row_values[$header] ?? $normalized_row_values[$normalized_header] ?? '&nbsp;';

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

  echo '</tbody></table></div></div>';
 } else {
  echo '<p>Form with ID ' . esc_html($form_id) . ' not found.</p>';
 }
}
echo '</div>'; // End travel-form-posts div

// === JAVASCRIPT FOR FILTER FUNCTIONALITY ===
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    const hidePastDatesCheckbox = document.getElementById("hidePastDates");
    const filterYearInput = document.getElementById("filterYear");
    const applyYearFilterBtn = document.getElementById("applyYearFilter");
    const clearYearFilterBtn = document.getElementById("clearYearFilter");
    
    if (hidePastDatesCheckbox) {
        hidePastDatesCheckbox.addEventListener("change", function() {
            updateURL();
        });
    }
    
    if (applyYearFilterBtn) {
        applyYearFilterBtn.addEventListener("click", function() {
            updateURL();
        });
    }
    
    if (filterYearInput) {
        filterYearInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                updateURL();
            }
        });
    }
    
    if (clearYearFilterBtn) {
        clearYearFilterBtn.addEventListener("click", function() {
            filterYearInput.value = "";
            updateURL();
        });
    }
    
    function updateURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (hidePastDatesCheckbox && hidePastDatesCheckbox.checked) {
            urlParams.set("hide_past_dates", "1");
        } else {
            urlParams.delete("hide_past_dates");
        }
        
        const yearValue = filterYearInput ? filterYearInput.value.trim() : "";
        if (yearValue && /^\d{4}$/.test(yearValue)) {
            urlParams.set("filter_year", yearValue);
        } else {
            urlParams.delete("filter_year");
        }
        
        const newUrl = window.location.pathname + "?" + urlParams.toString();
        window.location.href = newUrl;
    }
});
</script>';


// === JAVASCRIPT FOR FILTER FUNCTIONALITY ===
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    const hidePastDatesCheckbox = document.getElementById("hidePastDates");
    const filterYearInput = document.getElementById("filterYear");
    const applyYearFilterBtn = document.getElementById("applyYearFilter");
    const clearYearFilterBtn = document.getElementById("clearYearFilter");
    
    // === TABLE CONTROLS MINIMIZE/EXPAND FUNCTIONALITY (Bootstrap 5.3.3 optimized) ===
    const toggleButton = document.getElementById("toggleTableControls");
    const toggleIcon = document.getElementById("toggleIcon");
    const toggleText = document.getElementById("toggleText");
    const tableControls = document.getElementById("table-controls");
    
    if (toggleButton && tableControls) {
        // Bootstrap 5.3.3 uses these event names
        tableControls.addEventListener("hidden.bs.collapse", function() {
            toggleIcon.textContent = "+";
            toggleText.textContent = "Expand";
            toggleButton.classList.remove("btn-outline-secondary");
            toggleButton.classList.add("btn-outline-primary");
        });
        
        tableControls.addEventListener("shown.bs.collapse", function() {
            toggleIcon.textContent = "−";
            toggleText.textContent = "Minimize";
            toggleButton.classList.remove("btn-outline-primary");
            toggleButton.classList.add("btn-outline-secondary");
        });
        
        // Optional: Add smooth scroll when expanding
        tableControls.addEventListener("shown.bs.collapse", function() {
            tableControls.scrollIntoView({ behavior: "smooth", block: "nearest" });
        });
    }
    
    // Existing filter functionality (unchanged)
    if (hidePastDatesCheckbox) {
        hidePastDatesCheckbox.addEventListener("change", function() {
            updateURL();
        });
    }
    
    if (applyYearFilterBtn) {
        applyYearFilterBtn.addEventListener("click", function() {
            updateURL();
        });
    }
    
    if (filterYearInput) {
        filterYearInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                updateURL();
            }
        });
    }
    
    if (clearYearFilterBtn) {
        clearYearFilterBtn.addEventListener("click", function() {
            filterYearInput.value = "";
            updateURL();
        });
    }
    
    function updateURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (hidePastDatesCheckbox && hidePastDatesCheckbox.checked) {
            urlParams.set("hide_past_dates", "1");
        } else {
            urlParams.delete("hide_past_dates");
        }
        
        const yearValue = filterYearInput ? filterYearInput.value.trim() : "";
        if (yearValue && /^\d{4}$/.test(yearValue)) {
            urlParams.set("filter_year", yearValue);
        } else {
            urlParams.delete("filter_year");
        }
        
        const newUrl = window.location.pathname + "?" + urlParams.toString();
        window.location.href = newUrl;
    }
});
</script>';

get_footer();