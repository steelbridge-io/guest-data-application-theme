<?php
$counter = 1;
/**
 * @param mixed $entry
 * @param int $counter
 * @return void
 */

function formatEntryData(mixed $entry, int $counter): void {
	
	global $post;
	$date_created = date("m/d/Y", strtotime($entry['date_created']));
	
	echo '<tr>';
  $gda_meta_value = get_post_meta($post->ID, '_gda_meta_key', true);

  if (!empty($gda_meta_value)) {
    echo '<td class="fixed-column">';

// Define default values
    $default_first_name_value = '1.3';
    $default_last_name_value = '1.6';

// Retrieve the meta values with a fallback to default values
    $gda_first_name_value = get_post_meta($post->ID, '_gda_meta_key_first_name_id', true);
    $gda_last_name_value = get_post_meta($post->ID, '_gda_meta_key_last_name_id', true);

// Use default values if the meta values are empty
    $gda_first_name_value = !empty($gda_first_name_value) ? $gda_first_name_value : $default_first_name_value;
    $gda_last_name_value = !empty($gda_last_name_value) ? $gda_last_name_value : $default_last_name_value;

// Name
    if (rgar($entry, $gda_last_name_value) != '') {
      echo '<b>' . rgar($entry, $gda_last_name_value) . '&comma;&nbsp;' . rgar($entry, $gda_first_name_value) . '</b>';
    }

    echo '</td>';


    echo '<td>';

    // Reservation #
    $default_reservation_value = '44';
    // Retrieve the meta values with a fallback to default values
    $gda_reservation_value = get_post_meta($post->ID, '_gda_meta_key_reservation_id', true);
    // Use default values if the meta values are empty
    $gda_reservation_value = !empty($gda_reservation_value) ? $gda_reservation_value : $default_reservation_value;

    // Reservation #
    if (rgar($entry, $gda_reservation_value) != '') {
      echo '<b>' . rgar($entry, $gda_reservation_value) . '</b>';
    }

    echo '</td>';

    echo '<td>';

    $default_arrival_value = '46';
    $gda_arrival_value = get_post_meta($post->ID, '_gda_meta_key_date_of_arrival_id', true);
    $gda_arrival_value = !empty($gda_arrival_value) ? $gda_arrival_value : $default_arrival_value;
    // Date of arrival formating to m-d-Y
    $dateOfArrival = rgar($entry, $gda_arrival_value);
    $dateTime = DateTime::createFromFormat('Y-m-d', $dateOfArrival);

    if ($dateTime) {
      $formattedDateOfArrival = $dateTime->format('m-d-Y');
    } else {
      $formattedDateOfArrival = 'Invalid date format';
    }

    // Date of arrival
    if (rgar($entry, $gda_arrival_value) != '') {
      echo '<b>' . $formattedDateOfArrival . '</b>';
    }
    echo '</td>';


    echo '<td>';

    $default_departure_value = '47';
    $gda_departure_value = get_post_meta($post->ID, '_gda_meta_key_date_of_departure_id', true);
    $gda_departure_value = !empty($gda_departure_value) ? $gda_departure_value : $default_departure_value;

    // Date of departure formating to m-d-Y
    $dateOfDeparture = rgar($entry, $gda_departure_value);
    $departureDateTime = DateTime::createFromFormat('Y-m-d', $dateOfDeparture);

    if ($departureDateTime) {
      $formattedDateOfDeparture = $departureDateTime->format('m-d-Y');
    } else {
      $formattedDateOfDeparture = 'Invalid date format';
    }

    // Date of departure
    if (rgar($entry, $gda_departure_value) != '') {
      echo '<b>' . $formattedDateOfDeparture . '</b>';
    }
    echo '</td>';


    echo '<td>';

    // Define default values
    $default_cell_phone_value = '101';
    // Retrieve the meta values with a fallback to default values
    $gda_cell_phone_value = get_post_meta($post->ID, '_gda_meta_key_cell_phone_id', true);
    // Use default values if the meta values are empty
    $gda_cell_phone_value = !empty($gda_cell_phone_value) ? $gda_cell_phone_value : $default_cell_phone_value;

    // Cell phone
    if (rgar($entry, $gda_cell_phone_value) != '') {
      echo '<b>' . rgar($entry, $gda_cell_phone_value) . '</b>';
    }

    echo '</td>';

    echo '<td>';

    // Define default values
    $default_date_of_birth_value = '24';
    // Retrieve the meta values with a fallback to default values
    $gda_date_of_birth_value = get_post_meta($post->ID, '_gda_meta_key_date_of_birth_id', true);
    // Use default values if the meta values are empty
    $gda_date_of_birth_value = !empty($gda_date_of_birth_value) ? $gda_date_of_birth_value : $default_date_of_birth_value;

    // Birth Date Formating to m-d-Y
    $dateOfBirth = rgar($entry, $gda_date_of_birth_value);
    $dateTime = DateTime::createFromFormat('Y-m-d', $dateOfBirth);

    if ($dateTime) {
      $formattedDateOfBirth = $dateTime->format('m-d-Y');
    } else {
      $formattedDateOfBirth = 'Invalid date format';
    }

    // Birth Date
    if (rgar($entry, $gda_date_of_birth_value) != '') {
      echo '<b>' . $formattedDateOfBirth . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Body Weight
    $default_body_weight_value = '284';
    $gda_body_weight_value = get_post_meta($post->ID, '_gda_meta_key_body_weight_id', true);
    $gda_body_weight_value = !empty($gda_body_weight_value) ? $gda_body_weight_value : $default_body_weight_value;

    if (rgar($entry, $gda_body_weight_value) != '') {
      echo '<b>' . rgar($entry, $gda_body_weight_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Emergency Contact Person
    $default_ec_first_name_value = '28.3';
    $default_ec_last_name_value = '28.6';
    $gda_ec_first_name_value = get_post_meta($post->ID, '_gda_meta_key_ec_first_name_id', true);
    $gda_ec_last_name_value = get_post_meta($post->ID, '_gda_meta_key_ec_last_name_id', true);
    $gda_ec_first_name_value = !empty($gda_ec_first_name_value) ? $gda_ec_first_name_value : $default_ec_first_name_value;
    $gda_ec_last_name_value = !empty($gda_ec_last_name_value) ? $gda_ec_last_name_value : $default_ec_last_name_value;

    if (rgar($entry, $gda_ec_first_name_value) && rgar($entry, $gda_ec_last_name_value) != '') {
      echo '<b>' . rgar($entry, $gda_ec_first_name_value) . '&nbsp;</b><b>' . rgar($entry, $gda_ec_last_name_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Relationship to Traveler
    $default_relationship_to_traveler_value = '29';
    $gda_relationship_to_traveler_value = get_post_meta($post->ID, '_gda_meta_key_relationship_to_traveler_id', true);
    $gda_relationship_to_traveler_value = !empty($gda_relationship_to_traveler_value) ? $gda_relationship_to_traveler_value : $default_relationship_to_traveler_value;
    if (rgar($entry, $gda_relationship_to_traveler_value) != '') {
      echo '<b>' . rgar($entry, $gda_relationship_to_traveler_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Emergency Contact Person's Preferred Phone Number
    $default_ec_tel_number_value = '30';
    $gda_ec_tel_number_value = get_post_meta($post->ID, '_gda_meta_key_ec_tel_number_id', true);
    $gda_ec_tel_number_value = !empty($gda_ec_tel_number_value) ? $gda_ec_tel_number_value : $default_ec_tel_number_value;
    if (rgar($entry, $gda_ec_tel_number_value) != '') {
      echo '<b>' . rgar($entry, $gda_ec_tel_number_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Did you purchase Trip Cancellation Insurance?
    $default_purchase_cancellation_ins_value = '210';
    $gda_purchase_cancellation_ins_value = get_post_meta($post->ID, '_gda_meta_key_purchase_cancellation_ins_id', true);
    $gda_purchase_cancellation_ins_value = !empty($gda_purchase_cancellation_ins_value) ? $gda_purchase_cancellation_ins_value : $default_purchase_cancellation_ins_value;
    if (rgar($entry, $gda_purchase_cancellation_ins_value) != '') {
      echo '<b>' . rgar($entry, $gda_purchase_cancellation_ins_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Name of Travel Insurance company
    $default_ins_co_name_value = '207';
    $gda_ins_co_name_value = get_post_meta($post->ID, '_gda_meta_key_ins_co_name_id', true);
    $gda_ins_co_name_value = !empty($gda_ins_co_name_value) ? $gda_ins_co_name_value : $default_ins_co_name_value;
    if (rgar($entry, $gda_ins_co_name_value) != '') {
      echo '<b>' . rgar($entry, $gda_ins_co_name_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Travel Insurance Policy Number
    $default_ins_co_policy_number_value = '209';
    $gda_ins_co_policy_number_value = get_post_meta($post->ID, '_gda_meta_key_ins_co_policy_number_id', true);
    $gda_ins_co_policy_number_value = !empty($gda_ins_co_policy_number_value) ? $gda_ins_co_policy_number_value : $default_ins_co_policy_number_value;
    if (rgar($entry, $gda_ins_co_policy_number_value) != '') {
      echo '<b>' . rgar($entry, $gda_ins_co_policy_number_value) . '</b>';
    }
    echo '</td>';
		
    echo '<td>';
    // What float are your doing?
    $default_what_float_doing_value = '288';
    $gda_what_float_doing_value = get_post_meta($post->ID, '_gda_meta_key_what_float_doing_id', true);
    $gda_what_float_doing_value = !empty($gda_what_float_doing_value) ? $gda_what_float_doing_value : $default_what_float_doing_value;

    if (rgar($entry, $gda_what_float_doing_value) != '') {
      echo '<b>' . rgar($entry, $gda_what_float_doing_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // What float are your doing?
    $default_arrival_airport_value = '289';
    $gda_arrival_airport_value = get_post_meta($post->ID, '_gda_meta_key_arrival_airport_id', true);
    $gda_arrival_airport_value = !empty($gda_arrival_airport_value) ? $gda_arrival_airport_value : $default_arrival_airport_value;
    // Arrival airport city/town
    if (rgar($entry, $gda_arrival_airport_value) != '') {
      echo '<b>' . rgar($entry, $gda_arrival_airport_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Arrival Airline. Carrier being used.
    $default_arrival_airline_value = '48';
    $gda_arrival_airline_value = get_post_meta($post->ID, '_gda_meta_key_arrival_airline_id', true);
    $gda_arrival_airline_value = !empty($gda_arrival_airline_value) ? $gda_arrival_airline_value : $default_arrival_airline_value;
    if (rgar($entry, $gda_arrival_airline_value) != '') {
      echo '<b>' . rgar($entry, $gda_arrival_airline_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Arrival Airline. Other carrier being used.
    $default_other_arrival_airline_value = '50';
    $gda_other_arrival_airline_value = get_post_meta($post->ID, '_gda_meta_key_other_arrival_airline_id', true);
    $gda_other_arrival_airline_value = !empty($gda_other_arrival_airline_value) ? $gda_other_arrival_airline_value : $default_other_arrival_airline_value;
    if (rgar($entry, $gda_other_arrival_airline_value) != '') {
      echo '<b>' . rgar($entry, $gda_other_arrival_airline_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    //Flight arrival date formating to m-d-Y
    $default_flight_arrival_date_value = '66';
    $gda_flight_arrival_date_value = get_post_meta($post->ID, '_gda_meta_key_flight_arrival_date_id', true);
    $gda_flight_arrival_date_value = !empty($gda_flight_arrival_date_value) ? $gda_flight_arrival_date_value : $default_flight_arrival_date_value;

    $dateOfFlightArr66 = rgar($entry, $gda_flight_arrival_date_value);
    $flightArrDateTime66 = DateTime::createFromFormat('Y-m-d', $dateOfFlightArr66);

    if ($flightArrDateTime66) {
      $formattedDateOfFlightArr66 = $flightArrDateTime66->format('m-d-Y');
    } else {
      $formattedDateOfFlightArr66 = 'Invalid date format';
    }

    // Flight arrival date
    if (rgar($entry, $gda_flight_arrival_date_value) != '') {
      echo '<b>' . $formattedDateOfFlightArr66 . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Arrival Airline Flight Number
    $default_flight_arrival_number_value = '172';
    $gda_flight_arrival_number_value = get_post_meta($post->ID, '_gda_meta_key_flight_arrival_number_id', true);
    $gda_flight_arrival_number_value = !empty($gda_flight_arrival_number_value) ? $gda_flight_arrival_number_value : $default_flight_arrival_number_value;

    if (rgar($entry, $gda_flight_arrival_number_value) != '') {
      echo '<b>' . rgar($entry, $gda_flight_arrival_number_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Scheduled Arrival Time
    $default_flight_arrival_time_value = '60';
    $gda_flight_arrival_time_value = get_post_meta($post->ID, '_gda_meta_key_flight_arrival_time_id', true);
    $gda_flight_arrival_time_value = !empty($gda_flight_arrival_time_value) ? $gda_flight_arrival_time_value : $default_flight_arrival_time_value;
    if (rgar($entry, $gda_flight_arrival_time_value) != '') {
      echo '<b>' . rgar($entry, $gda_flight_arrival_time_value) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Flight Departure Date Formating to m-d-Y
    $default_flight_departure_date_value = '67';
    $gda_flight_departure_date_value = get_post_meta($post->ID, '_gda_meta_key_flight_departure_date_id', true);
    $gda_flight_departure_date_value = !empty($gda_flight_departure_date_value) ? $gda_flight_departure_date_value : $default_flight_departure_date_value;

    $dateOfDeparture = rgar($entry, $gda_flight_departure_date_value);
    $departureDateTime = DateTime::createFromFormat('Y-m-d', $dateOfDeparture);

    if ($departureDateTime) {
      $formattedDateOfDeparture = $departureDateTime->format('m-d-Y');
    } else {
      $formattedDateOfDeparture = 'Invalid date format';
    }

    // Flight Departure Date
    if (rgar($entry, $gda_flight_departure_date_value) != '') {
      echo '<b>' . $formattedDateOfDeparture . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Departure Airline Flight Number
    $default_flight_departure_number_value = '58';
    $gda_flight_departure_number_value = get_post_meta($post->ID, '_gda_meta_key_flight_departure_number_id', true);
    $gda_flight_departure_number_value = !empty($gda_flight_departure_number_value) ? $gda_flight_departure_number_value : $default_flight_departure_number_value;
    if (rgar($entry, $gda_flight_departure_number_value ) != '') {
      echo '<b>' . rgar($entry, $gda_flight_departure_number_value ) . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Scheduled Departure Time
    $default_flight_departure_time_value = '61';
    $gda_flight_departure_time_value = get_post_meta($post->ID, '_gda_meta_key_flight_departure_time_id', true);
    $gda_flight_departure_time_value = !empty($gda_flight_departure_time_value) ? $gda_flight_departure_time_value : $default_flight_departure_time_value;
    if (rgar($entry, $gda_flight_departure_time_value ) != '') {
      echo '<b>' . rgar($entry, $gda_flight_departure_time_value ) . '</b>';
    }
    echo '</td>';


    echo '<td>';
    // Departure airline
    if (rgar($entry, '56') != '') {
      echo '<b>' . rgar($entry, '56') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Other departure airline
    if (rgar($entry, '57') != '') {
      echo '<b>' . rgar($entry, '57') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Flight depature date formating to m-d-Y
    $dateOfDepature226 = rgar($entry, '67');
    $departureDateTime226 = DateTime::createFromFormat('Y-m-d', $dateOfDepature226);

    if ($departureDateTime226) {
      $formattedDateOfDeparture226 = $departureDateTime226->format('m-d-Y');
    } else {
      $formattedDateOfDeparture226 = 'Invalid date format';
    }

    // Flight departure date
    if (rgar($entry, '67') != '') {
      echo '<b>' . $formattedDateOfDeparture226 . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Departure airline flight number
    if (rgar($entry, '58') != '') {
      echo '<b>' . rgar($entry, '58') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Scheduled departure time
    if (rgar($entry, '61') != '') {
      echo '<b>' . rgar($entry, '61') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Name(s) of others traveling with you
    if (rgar($entry, '21') != '') {
      echo '<b>' . rgar($entry, '21') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Hotel you will be staying at
    if (rgar($entry, '205') != '') {
      echo '<b>' . rgar($entry, '205') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Other hotel
    if (rgar($entry, '206') != '') {
      echo '<b>' . rgar($entry, '206') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Other Hotel address
    if (rgar($entry, '237.1') != '') {
      echo '<b>' . rgar($entry, '237.1') . '&#44;</b>&nbsp;<b>' . rgar($entry, '237.3') . '&#44;</b>&nbsp;<b>' . rgar($entry, '237.5') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Do you need to rent rods and reels from the lodge?
    if (rgar($entry, '292') != '') {
      echo '<b>' . rgar($entry, '292') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // What hand do you reel with?
    if (rgar($entry, '293') != '') {
      echo '<b>' . rgar($entry, '293') . '</b>';
    }
    echo '</td>';

    echo '<td>';

    $checkbox_ids = ['214.1', '214.2', '214.3', '214.4', '214.5', '214.6']; // Add as many as needed, or determine dynamically based on your specific form setup.

    $selected_species = [];

    foreach ($checkbox_ids as $checkbox_id) {
      $species_value = rgar($entry, $checkbox_id);
      if (!empty($species_value)) {
        $selected_species[] = $species_value;
      }
    }

    // Is there a certain species of fish you are targeting on this trip?
    if (!empty($selected_species)) {
      $speciesCount = count($selected_species);
      foreach ($selected_species as $index => $species) {
        echo '<b>' . esc_html($species) . '</b>';
        if ($index !== $speciesCount - 1) {
          echo '&#44;&nbsp;';
        }
      }
    }
    echo '</td>';

    echo '<td>';
    // How would you rate your fishing skills?
    if (rgar($entry, '114') != '') {
      echo '<b>' . rgar($entry, '114') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // How would you rate boating/rafting experience?
    if (rgar($entry, '290') != '') {
      echo '<b>' . rgar($entry, '290') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Characterize your wading ability
    if (rgar($entry, '218') != '') {
      echo '<b>' . rgar($entry, '218') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Characterize your physical fitness level
    if (rgar($entry, '280') != '') {
      echo '<b>' . rgar($entry, '280') . '</b>';
    }
    echo '</td>';

    echo '<td>';

    $checkbox_ids_allergy = ['88.1', '88.2', '88.3', '88.4', '88.5']; // Add as many as needed, or determine dynamically based on your specific form setup.

    $selected_allergy = [];

    foreach ($checkbox_ids_allergy as $checkbox_id_allergy) {
      $allergy_value = rgar($entry, $checkbox_id_allergy);
      if (!empty($allergy_value)) {
        $selected_allergy[] = $allergy_value;
      }
    }

    // Diet requirements/special menu
    if (!empty($selected_allergy)) {
      $allergyCount = count($selected_allergy);
      foreach ($selected_allergy as $index => $allergy) {
        echo '<b>' . esc_html($allergy) . '</b>';
        if ($index !== $allergyCount - 1) {
          echo '&#44;&nbsp;';
        }
      }
    }
    echo '</td>';

    echo '<td>';
    // Other allergies
    if (rgar($entry, '89') != '') {
      echo '<b>' . rgar($entry, '89') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Diet Aversions/Dislikes
    if (rgar($entry, '100') != '') {
      echo '<b>' . rgar($entry, '100') . '</b>';
    }
    echo '</td>';


    echo '<td>';
// Please list any Special Requests, Needs, Health Concerns, Physical Challenges.
    if (rgar($entry, '39') != '') {
      // Retrieve the paragraph content from the entry
      $specialRequest_paragraph_content = rgar($entry, '39');

      // Extract the first few words (e.g., 10 words) from the paragraph content
      $specialRequest_words_array = explode(' ', $specialRequest_paragraph_content);
      $specialRequest_excerpt = implode(' ', array_slice($specialRequest_words_array, 0, 10));

      // Escape content for safe JavaScript and HTML usage
      $specialRequest_escaped_excerpt = htmlspecialchars($specialRequest_excerpt, ENT_QUOTES, 'UTF-8');
      $specialRequest_escaped_content = htmlspecialchars($specialRequest_paragraph_content, ENT_QUOTES, 'UTF-8');

      // Combine the excerpt and "Read more" link for the popover content
      $specialRequest_data_content = "{$specialRequest_escaped_content}";

      // Output prescription details button with popover
      echo <<<HTML
    <button type="button" class="btn btn-popover" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-html="true"
    data-bs-content="{$specialRequest_data_content}">
        <b>{$specialRequest_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see more</span></b>
    </button>

    <style>
        .popover {
            max-width: none;
        }
    </style>
HTML;
    }
    echo '</td>';


    echo '<td>';
    // Do you need a sleeping bag?
    if (rgar($entry, '291') != '') {
      echo '<b>' . rgar($entry, '291') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // If applicable, please note rooming/roommate requests.
    if (rgar($entry, '167') != '') {
      echo '<b>' . rgar($entry, '167') . '</b>';
    }
    echo '</td>';

    echo '<td>';
    // Will you be celebrating a special occasion while on the float?
    if (rgar($entry, '41') != '') {
      echo '<b>' . rgar($entry, '41') . '</b>';
    }
    echo '</td>';

    echo '<td>';
// Please tell us about your event or celebration
    if (rgar($entry, '40') != '') {
      // Retrieve the paragraph content from the entry
      $specialOccasion_paragraph_content = rgar($entry, '40');
      // Extract the first 10 words from the paragraph content
      $specialOccasion_words_array = explode(' ', $specialOccasion_paragraph_content);
      $specialOccasion_excerpt = implode(' ', array_slice($specialOccasion_words_array, 0, 2));
      // Escape content for safe JavaScript usage
      $specialOccasion_escaped_excerpt = htmlspecialchars($specialOccasion_excerpt, ENT_QUOTES, 'UTF-8');
      $specialOccasion_escaped_content = htmlspecialchars($specialOccasion_paragraph_content, ENT_QUOTES, 'UTF-8');
      // Construct the "Read more" link to display in the popover
      $specialOccasion_read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
      // Combine the excerpt and "Read more" link for the popover content
      $specialOccasion_data_content = "{$specialOccasion_escaped_content}";
      // Please tell us about your event or celebration popover
      echo <<<HTML
				    <button type="button" class="btn btn-popover" data-bs-toggle="popover" data-bs-placement="bottom"
				    data-bs-html="true"    data-bs-content="{$specialOccasion_data_content}"> <b>{$specialOccasion_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see more</span></b></button>
			      <style>.popover { max-width: none; }</style>
	HTML;
    }
    echo '</td>';

    echo '<td>';
    // What are you most looking forward to during your stay?
    if (rgar($entry, '161') != '') {
      // Retrieve the paragraph content from the entry
      $tripGoals_paragraph_content = rgar($entry, '161');
      // Extract the first 10 words from the paragraph content
      $tripGoals_words_array = explode(' ', $tripGoals_paragraph_content);
      $tripGoals_excerpt = implode(' ', array_slice($tripGoals_words_array, 0, 2));
      // Escape content for safe JavaScript usage
      $tripGoals_escaped_excerpt = htmlspecialchars($tripGoals_excerpt, ENT_QUOTES, 'UTF-8');
      $tripGoals_escaped_content = htmlspecialchars($tripGoals_paragraph_content, ENT_QUOTES, 'UTF-8');
      // Construct the "Read more" link to display in the popover
      $tripGoals_read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
      // Combine the excerpt and "Read more" link for the popover content
      $tripGoals_data_content = "{$tripGoals_escaped_content}";
      // Trip goals
      echo <<<HTML
				    <button type="button" class="btn btn-popover" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-html="true"    data-bs-content="{$tripGoals_data_content}"> <b>{$tripGoals_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
				    more</span></b></button>
				    <style>.popover {  max-width: none; }</style>
	HTML;
    }
    echo '</td>';
  }
	echo '</tr>';
	
	$counter++;
}


