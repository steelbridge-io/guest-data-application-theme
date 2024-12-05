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
	if (rgar($entry, '44') != '') {
		echo '<b>' . rgar($entry, '44') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Date of arrival formating to m-d-Y
	$dateOfArrival = rgar($entry, '46');
	$dateTime = DateTime::createFromFormat('Y-m-d', $dateOfArrival);
	
	if ($dateTime) {
		$formattedDateOfArrival = $dateTime->format('m-d-Y');
	} else {
		$formattedDateOfArrival = 'Invalid date format';
	}
	
	// Date of arrival
	if (rgar($entry, '46') != '') {
		echo '<b>' . $formattedDateOfArrival . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Date of departure formating to m-d-Y
	$dateOfDeparture = rgar($entry, '47');
	$departureDateTime = DateTime::createFromFormat('Y-m-d', $dateOfDeparture);
	
	if ($departureDateTime) {
		$formattedDateOfDeparture = $departureDateTime->format('m-d-Y');
	} else {
		$formattedDateOfDeparture = 'Invalid date format';
	}
	
	// Date of departure
	if (rgar($entry, '47') != '') {
		echo '<b>' . $formattedDateOfDeparture . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Cell Phone - Text/SMS
	if (rgar($entry, '101') != '') {
		echo '<b>' . rgar($entry, '101') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Birth Date Formating to m-d-Y
	$dateOfBirth = rgar($entry, '24');
	$dateTime = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
	
	if ($dateTime) {
		$formattedDateOfBirth = $dateTime->format('m-d-Y');
	} else {
		$formattedDateOfBirth = 'Invalid date format';
	}
	
	// Birth Date
	if (rgar($entry, '24') != '') {
		echo '<b>' . $formattedDateOfBirth . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Body Weight
	if (rgar($entry, '284') != '') {
		echo '<b>' . rgar($entry, '284') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Emergency Contact Person
	if (rgar($entry, '28.3') != '') {
		echo '<b>' . rgar($entry, '28.3') . '&nbsp;</b><b>' . rgar($entry, '28.6') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Relationship to Traveler
	if (rgar($entry, '29') != '') {
		echo '<b>' . rgar($entry, '29') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Emergency Contact Person's Preferred Phone Number
	if (rgar($entry, '30') != '') {
		echo '<b>' . rgar($entry, '30') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Did you purchase Trip Cancellation Insurance?
	if (rgar($entry, '210') != '') {
		echo '<b>' . rgar($entry, '210') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Name of Travel Insurance company
	if (rgar($entry, '207') != '') {
		echo '<b>' . rgar($entry, '207') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Travel Insurance Policy Number
	if (rgar($entry, '209') != '') {
		echo '<b>' . rgar($entry, '209') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
// What float are your doing?
	if (rgar($entry, '288') != '') {
		echo '<b>' . rgar($entry, '288') . '</b>';
	}
	echo '</td>';
	
	echo  '<td>';
	// Arrival airport city/town
	if (rgar($entry, '289') != '') {
		echo '<b>' . rgar($entry, '289') . '</b>';
	}
	echo  '</td>';
	
	echo '<td>';
	// Arrival Airline. Carrier being used.
	if (rgar($entry, '48') != '') {
		echo '<b>' . rgar($entry, '48') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Arrival Airline. Other carrier being used.
	if (rgar($entry, '50') != '') {
		echo '<b>' . rgar($entry, '50') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	//Flight arrival date formating to m-d-Y
	$dateOfFlightArr66 = rgar($entry, '66');
	$flightArrDateTime66 = DateTime::createFromFormat('Y-m-d', $dateOfFlightArr66);
	
	if ($flightArrDateTime66) {
		$formattedDateOfFlightArr66 = $flightArrDateTime66->format('m-d-Y');
	} else {
		$formattedDateOfFlightArr66 = 'Invalid date format';
	}
	
	// Flight arrival date
	if (rgar($entry, '66') != '') {
		echo '<b>' . $formattedDateOfFlightArr66 . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Arrival Airline Flight Number
	if (rgar($entry, '172') != '') {
		echo '<b>' . rgar($entry, '172') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Scheduled Arrival Time
	if (rgar($entry, '60') != '') {
		echo '<b>' . rgar($entry, '60') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Flight Departure Date Formating to m-d-Y
	$dateOfDeparture = rgar($entry, '67');
	$departureDateTime = DateTime::createFromFormat('Y-m-d', $dateOfDeparture);
	
	if ($departureDateTime) {
		$formattedDateOfDeparture = $departureDateTime->format('m-d-Y');
	} else {
		$formattedDateOfDeparture = 'Invalid date format';
	}
	
	// Flight Departure Date
	if (rgar($entry, '67') != '') {
		echo '<b>' . $formattedDateOfDeparture . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Departure Airline Flight Number
	if (rgar($entry, '58') != '') {
		echo '<b>' . rgar($entry, '58') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Scheduled Departure Time
	if (rgar($entry, '61') != '') {
		echo '<b>' . rgar($entry, '61') . '</b>';
	}
	echo '</td>';
	
	echo  '<td>';
	// Departure airline
	if (rgar($entry, '56') != '') {
		echo '<b>' . rgar($entry, '56') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other departure airline
	if (rgar($entry, '57') != '') {
		echo '<b>' . rgar($entry, '57') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
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
	echo  '</td>';
	
	echo  '<td>';
	// Departure airline flight number
	if (rgar($entry, '58') != '') {
		echo '<b>' . rgar($entry, '58') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Scheduled departure time
	if (rgar($entry, '61') != '') {
		echo '<b>' . rgar($entry, '61') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Name(s) of others traveling with you
	if (rgar($entry, '21') != '') {
		echo '<b>' . rgar($entry, '21') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Hotel you will be staying at
	if (rgar($entry, '205') != '') {
		echo '<b>' . rgar($entry, '205') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other hotel
	if (rgar($entry, '206') != '') {
		echo '<b>' . rgar($entry, '206') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other Hotel address
	if (rgar($entry, '237.1') != '') {
		echo '<b>' . rgar($entry, '237.1') . '&#44;</b>&nbsp;<b>' . rgar($entry, '237.3') . '&#44;</b>&nbsp;<b>' . rgar($entry,	'237.5') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to rent rods and reels from the lodge?
	if (rgar($entry, '292') != '') {
		echo '<b>' . rgar($entry, '292') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// What hand do you reel with?
	if (rgar($entry, '293') != '') {
		echo '<b>' . rgar($entry, '293') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For certain species of fish being targeting.
	 */
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
	echo  '</td>';
	
	echo  '<td>';
	// How would you rate your fishing skills?
	if (rgar($entry, '114') != '') {
		echo '<b>' . rgar($entry, '114') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// How would you rate boating/rafting experience?
	if (rgar($entry, '290') != '') {
		echo '<b>' . rgar($entry, '290') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Characterize your wading ability
	if (rgar($entry, '218') != '') {
		echo '<b>' . rgar($entry, '218') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Characterize your physical fitness level
	if (rgar($entry, '280') != '') {
		echo '<b>' . rgar($entry, '280') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For food and environmental allergies
	 */
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
		$allergyCount = count( $selected_allergy );
		foreach ( $selected_allergy as $index => $allergy ) {
			echo '<b>' . esc_html( $allergy ) . '</b>';
			if ( $index !== $allergyCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other allergies
	if (rgar($entry, '89') != '') {
		echo '<b>' . rgar($entry, '89') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Diet Aversions/Dislikes
	if (rgar($entry, '100') != '') {
		echo '<b>' . rgar($entry, '100') . '</b>';
	}
	echo  '</td>';
	
	
	echo '<td>';
// Please list any Special Requests, Needs, Health Concerns, Physical Challenges.
	if (rgar($entry, '39') != '') {
		// Retrieve the paragraph content from the entry
		$specialRequest_paragraph_content = rgar($entry, '39');
		
		// Extract the first few words (e.g., 10 words) from the paragraph content
		$specialRequest_words_array = explode(' ', $specialRequest_paragraph_content);
		$specialRequest_excerpt     = implode(' ', array_slice($specialRequest_words_array, 0, 10));
		
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
            max-width: none; /* Allow the popover to expand to the size of the content */
        }
    </style>
HTML;
	}
	echo '</td>';
	
	
	echo  '<td>';
	// Do you need a sleeping bag?
	if (rgar($entry, '291') != '') {
		echo '<b>' . rgar($entry, '291') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// If applicable, please note rooming/roommate requests.
	if (rgar($entry, '167') != '') {
		echo '<b>' . rgar($entry, '167') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Will you be celebrating a special occasion while on the float?
	if (rgar($entry, '41') != '') {
		echo '<b>' . rgar($entry, '41') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
// Please tell us about your event or celebration
	if ( rgar( $entry, '40' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$specialOccasion_paragraph_content = rgar( $entry, '40' );
		// Extract the first 10 words from the paragraph content
		$specialOccasion_words_array = explode( ' ', $specialOccasion_paragraph_content );
		$specialOccasion_excerpt     = implode( ' ', array_slice( $specialOccasion_words_array, 0, 2 ) );
		// Escape content for safe JavaScript usage
		$specialOccasion_escaped_excerpt = htmlspecialchars( $specialOccasion_excerpt, ENT_QUOTES, 'UTF-8' );
		$specialOccasion_escaped_content = htmlspecialchars( $specialOccasion_paragraph_content, ENT_QUOTES, 'UTF-8' );
		// Construct the "Read more" link to display in the popover
		$specialOccasion_read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
		// Combine the excerpt and "Read more" link for the popover content
		$specialOccasion_data_content = "{$specialOccasion_escaped_content}";
		// Please tell us about your event or celebration popover
		echo <<<HTML
				    <button type="button" class="btn btn-popover" data-bs-toggle="popover" data-bs-placement="bottom"
				    data-bs-html="true"    data-bs-content="{$specialOccasion_data_content}"> <b>{$specialOccasion_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see more</span></b></button>
			      <style>.popover { max-width: none; /* Allow the popover to expand to the size of the content */}</style>
	HTML;
	}
	echo  '</td>';
	
	echo  '<td>';
	// What are you most looking forward to during your stay?
	if ( rgar( $entry, '161' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$tripGoals_paragraph_content = rgar( $entry, '161' );
		// Extract the first 10 words from the paragraph content
		$tripGoals_words_array = explode( ' ', $tripGoals_paragraph_content );
		$tripGoals_excerpt     = implode( ' ', array_slice( $tripGoals_words_array, 0, 2 ) );
		// Escape content for safe JavaScript usage
		$tripGoals_escaped_excerpt = htmlspecialchars( $tripGoals_excerpt, ENT_QUOTES, 'UTF-8' );
		$tripGoals_escaped_content = htmlspecialchars( $tripGoals_paragraph_content, ENT_QUOTES, 'UTF-8' );
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
	echo  '</td>';
	
	echo '</tr>';
	
	$counter++;
}

