<?php

$counter = 1;
/**
 * @param mixed $entry
 * @param int $counter
 * @return void
 */
function formatEntryData(mixed $entry, int $counter): void {
	$date_created = date( "m/d/Y", strtotime( $entry['date_created'] ) );
	
	echo '<tr>';
	
	echo '<td class="fixed-column">';
	// Name
	if ( rgar( $entry, '1.6' ) != '' ) {
		echo '<b>' . rgar( $entry, '1.6' ) . '&comma;&nbsp;' . rgar( $entry, '1.3' ) . /*. rgar($entry, '1.4') .*/ '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Reservation #
	if ( rgar( $entry, '44' ) != '' ) {
		echo '<b>' . rgar( $entry, '44' ) . '</b>';
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
	// How are you getting to King Salmon?
	if (rgar($entry, '285') != '') {
		echo '<b>' . rgar($entry, '285') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Other - How are you getting to King Salmon?
	if (rgar($entry, '287') != '') {
		echo '<b>' . rgar($entry, '287') . '</b>';
	}
	echo '</td>';
	
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
	// King Salmon hotel you will be staying at
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
	// How would you rate your fishing skills?
	if (rgar($entry, '114') != '') {
		echo '<b>' . rgar($entry, '114') . '</b>';
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
	 * Define the range of checkbox IDs based on your form configuration. For diet requirements.
	 */
	$checkbox_ids_diet = ['86.1', '86.2', '86.3', '86.4', '86.5', '86.6', '86.7', '86.8', '86.9', '86.10']; // Add as
	// many as needed, or determine dynamically based on your specific form setup.
	
	$selected_diet = [];
	
	foreach ($checkbox_ids_diet as $checkbox_id_diet) {
		$diet_value = rgar($entry, $checkbox_id_diet);
		if (!empty($diet_value)) {
			$selected_diet[] = $diet_value;
		}
	}
	
	// Diet requirements/special menu
	if (!empty($selected_diet)) {
		$dietCount = count( $selected_diet );
		foreach ( $selected_diet as $index => $diet ) {
			echo '<b>' . esc_html( $diet ) . '</b>';
			if ( $index !== $dietCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other special diet
	if (rgar($entry, '87') != '') {
		echo '<b>' . rgar($entry, '87') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For food and environmental allergies
	 */
	$checkbox_ids_allergy = ['88.1', '88.2', '88.3', '88.4', '88.5', '88.6', '88.7', '88.8']; // Add as many as needed, or determine dynamically based on your specific form setup.
	
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
	
	echo  '<td>';
	// Please list any Special Requests, Needs, Health Concerns, Physical Challenges.
	if ( rgar( $entry, '39' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$specialRequest_paragraph_content = rgar( $entry, '39' );
		
		// Extract the first 10 words from the paragraph content
		$specialRequest_words_array = explode( ' ', $specialRequest_paragraph_content );
		$specialRequest_excerpt     = implode( ' ', array_slice( $specialRequest_words_array, 0, 2 ) );
		
		// Escape content for safe JavaScript usage
		$specialRequest_escaped_excerpt = htmlspecialchars( $specialRequest_excerpt, ENT_QUOTES, 'UTF-8' );
		$specialRequest_escaped_content = htmlspecialchars( $specialRequest_paragraph_content, ENT_QUOTES, 'UTF-8' );
		
		// Construct the "Read more" link to display in the popover
		$specialRequest_read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
		
		// Combine the excerpt and "Read more" link for the popover content
		$specialRequest_data_content = "{$specialRequest_escaped_content}";
		
		// Output perscription details button with popover
		echo <<<HTML
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$specialRequest_data_content}"> <b>{$specialRequest_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
	    more</span></b></button>
	
	    <style>
	        .popover {
	            max-width: none; /* Allow the popover to expand to the size of the content */
	        }
	    </style>
	HTML;
	}
	echo  '</td>';
	
	echo  '<td>';
	// If applicable, please note rooming/roommate requests
	if (rgar($entry, '167') != '') {
		echo '<b>' . rgar($entry, '167') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Will you be celebrating a special occasion while at the lodge?
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
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$specialOccasion_data_content}"> <b>{$specialOccasion_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
	    more</span></b></button>
	
	    <style>
	        .popover {
	            max-width: none; /* Allow the popover to expand to the size of the content */
	        }
	    </style>
	HTML;
	}
	echo  '</td>';
	
	echo  '<td>';
	// What are you most looking forward to?
	if ( rgar( $entry, '161' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$lookingForwardto_paragraph_content = rgar( $entry, '161' );
		
		// Extract the first 10 words from the paragraph content
		$lookingForwardto_words_array = explode( ' ', $lookingForwardto_paragraph_content );
		$lookingForwardto_excerpt     = implode( ' ', array_slice( $lookingForwardto_words_array, 0, 2 ) );
		
		// Escape content for safe JavaScript usage
		$lookingForwardto_escaped_excerpt = htmlspecialchars( $lookingForwardto_excerpt, ENT_QUOTES, 'UTF-8' );
		$lookingForwardto_escaped_content = htmlspecialchars( $lookingForwardto_paragraph_content, ENT_QUOTES, 'UTF-8' );
		
		// Construct the "Read more" link to display in the popover
		$lookingForwardto_read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
		
		// Combine the excerpt and "Read more" link for the popover content
		$lookingForwardto_data_content = "{$lookingForwardto_escaped_content}";
		
		// Please tell us about your event or celebration popover
		echo <<<HTML
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$lookingForwardto_data_content}"> <b>{$lookingForwardto_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
	    more</span></b></button>
	
	    <style>
	        .popover {
	            max-width: none; /* Allow the popover to expand to the size of the content */
	        }
	    </style>
	HTML;
	}
	echo  '</td>';
	echo '</tr>';
	$counter++;
}
