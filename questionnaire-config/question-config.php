<?php

$counter = 1;
/**
 * @param mixed $entry
 * @param int $counter
 * @return void
 */
function formatEntryData(mixed $entry, int $counter): void
{
	$date_created = date("m/d/Y", strtotime($entry['date_created']));
	
	echo '<tr>';
	
	echo '<td class="fixed-column">';
	// Name
	if (rgar($entry, '1.6') != '') {
		echo '<b>' . rgar($entry, '1.6') . '&comma;&nbsp;' . rgar($entry, '1.3') . /*. rgar($entry, '1.4') .*/ '</b>';
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
	// Email
	if (rgar($entry, '261') != '') {
		echo '<b>' . rgar($entry, '261') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// #home-address
	if ( rgar( $entry, '69.1' ) != '' ) {
		// Retrieve address entries
		$street_address = rgar( $entry, '69.1' );
		$address_line_2 = rgar( $entry, '69.2' ) != '' ? rgar( $entry, '69.2' ) : '';
		$city = rgar( $entry, '69.3' );
		$state_province_region = rgar( $entry, '69.4' );
		$zip_postal_code = rgar( $entry, '69.5' );
		
		// Escape content for safe JavaScript usage
		$escaped_address = htmlspecialchars( $street_address, ENT_QUOTES, 'UTF-8' );
		$escaped_address_line_2 = htmlspecialchars( $address_line_2, ENT_QUOTES, 'UTF-8' );
		$escaped_city = htmlspecialchars( $city, ENT_QUOTES, 'UTF-8' );
		$escaped_state_province = htmlspecialchars( $state_province_region, ENT_QUOTES, 'UTF-8' );
		$escaped_zip_postal_code = htmlspecialchars( $zip_postal_code, ENT_QUOTES, 'UTF-8' );
		
		// Construct the popover content with proper line breaks
		$address_data_content = "{$escaped_address}<br>";
		if ($escaped_address_line_2) {
			$address_data_content .= "{$escaped_address_line_2}<br>";
		}
		$address_data_content .= "{$escaped_city}<br>{$escaped_state_province}<br>{$escaped_zip_postal_code}";
		
		// Trip goals button
		echo <<<HTML
    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
    data-content="{$address_data_content}">
        <b>{$escaped_city}...<span style="color:red;">&nbsp;Click to see more</span></b>
    </button>

    <style>
        .popover {
            max-width: none; /* Allow the popover to expand to the size of the content */
        }
    </style>
HTML;
	}
	echo '</td>';
	
	echo '<td>';
	// Cell Phone - Text/SMS
	if (rgar($entry, '101') != '') {
		echo '<b>' . rgar($entry, '101') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Shuttle service?
	if (rgar($entry, '34') != '') {
		echo '<b>' . rgar($entry, '34') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Trip Type
	if (rgar($entry, '180') != '') {
		echo '<b>' . rgar($entry, '180') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Extract trip destinations
	$trip_destinations = [];
	foreach ($entry as $key => $value) {
		if (strpos($key, '223.') === 0 && !empty($value)) {
			$trip_destinations[] = $value;
		}
	}
	// Trip destinations
	if (!empty($trip_destinations)) {
		echo '<b>';
		echo esc_html(implode(', ', $trip_destinations));
		echo '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Extract Alaska float destinations
	$trip_rivers_floating_alaska = [];
	foreach ($entry as $key => $value) {
		if (strpos($key, '212.') === 0 && !empty($value)) {
			$trip_rivers_floating_alaska[] = $value;
		}
	}
	// Alaska destinations
	if (!empty($trip_rivers_floating_alaska)) {
		echo '<b>';
		echo esc_html(implode(', ', $trip_rivers_floating_alaska));
		echo '</b>';
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
	// Height
	if (rgar($entry, '52') != '') {
		echo '<b>' . rgar($entry, '52') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Gender
	if (rgar($entry, '267') != '') {
		echo '<b>' . rgar($entry, '267') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Passport Number
	if (rgar($entry, '64') != '') {
		echo '<b>' . rgar($entry, '64') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Passport Expiration Date Formating to m-d-Y
	$dateOfPassport = rgar($entry, '65');
	$passPortdateTime = DateTime::createFromFormat('Y-m-d', $dateOfPassport);
	
	if ($passPortdateTime) {
		$formattedDateOfPassport = $passPortdateTime->format('m-d-Y');
	} else {
		$formattedDateOfPassport = 'Invalid date format';
	}
	
	// Passport Expiration Date
	if (rgar($entry, '65') != '') {
		echo '<b>' . $formattedDateOfPassport . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Passport Issuing Country
	if (rgar($entry, '281') != '') {
		echo '<b>' . rgar($entry, '281') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Other Country where your passport was issued
	if (rgar($entry, '282') != '') {
		echo '<b>' . rgar($entry, '282') . '</b>';
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
	// Mandatory Medical Evacuation Company/Policy Number
	if (rgar($entry, '72') != '') {
		echo '<b>' . rgar($entry, '72') . '</b>';
	}
	echo '</td>';

  echo '<td>';
  // What float are your doing?
  if (rgar($entry, '288') != '') {
    echo '<b>' . rgar($entry, '288') . '</b>';
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
	// Passport Photo Copy
	if (rgar($entry, '111') != '') {
		// Retrieve the relative URL from the entry.
		$relative_url = rgar($entry, '111');
		
		// Remove any leading slash.
		$relative_url = ltrim($relative_url, '/');
		
		// Define your custom base URL. Edit based on hosting environment.
		$custom_base_url = 'http://www.theflyshop.local/wp-content/uploads';
		
		// Derive the relative part of the path after "uploads" directory.
		$path_relative_to_uploads = strstr($relative_url, 'gravity_forms');
		
		// Construct the full URL using custom base URL.
		$full_url = $custom_base_url . '/' . $path_relative_to_uploads;
		
		// Sanitize the constructed URL.
		$file_url = esc_url($full_url);
		
		// Output the image.
		echo <<<HTML
        <button type="button" class="btn btn-passport-preview btn-popover" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<img src='{$file_url}' alt='Uploaded Photo' style='width: 600px; height: auto;'>">
        <div class="overlay-container">
            <img class='passport-copy-preview' src='{$file_url}' alt='Uploaded Photo'/>
            <p class="overlay-text">Click to see image</p>
        </button>
        </div>
        <style>
            .popover {
                max-width: none; /* Allow the popover to expand to the size of the content */
            }
            .popover-content img {
                width: 600px; /* Adjust the width as needed */
                height: auto; /* Maintain aspect ratio */
            }
        </style>
        HTML;
	}
	echo '</td>';
	
	echo '<td>';
	
	// Russian Visa Photo Copy
	if (rgar($entry, '271') != '') {
		// Retrieve the relative URL from the entry.
		$relative_url = rgar($entry, '271');
		
		// Remove any leading slash.
		$relative_url = ltrim($relative_url, '/');
		
		// Define your custom base URL. Edit based on hosting environment.
		$custom_base_url = 'http://www.theflyshop.local/wp-content/uploads';
		
		// Derive the relative part of the path after "uploads" directory.
		$path_relative_to_uploads = strstr($relative_url, 'gravity_forms');
		
		// Construct the full URL using custom base URL.
		$full_url = $custom_base_url . '/' . $path_relative_to_uploads;
		
		// Sanitize the constructed URL.
		$file_url = esc_url($full_url);
		
		// Output the image.
		echo <<<HTML
            <button type="button" class="btn btn-passport-preview btn-popover" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<img src='{$file_url}' alt='Uploaded Photo' style='width: 600px; height: auto;'>">
            <div class="overlay-container">
                <img class='passport-copy-preview' src='{$file_url}' alt='Uploaded Photo'/>
                <p class="overlay-text">Click to see image</p>
            </button>
            </div>
            <style>
                .popover {
                    max-width: none; /* Allow the popover to expand to the size of the content */
                }
                .popover-content img {
                    width: 600px; /* Adjust the width as needed */
                    height: auto; /* Maintain aspect ratio */
                }
            </style>
        HTML;
	}
	echo '</td>';
	
	echo '<td>';
	// Occupation
	if (rgar($entry, '277') != '') {
		echo '<b>' . rgar($entry, '277') . '</b>';
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
	
	echo  '<td>';
	// Departure airport city/town
	if (rgar($entry, '290') != '') {
		echo '<b>' . rgar($entry, '290') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Departure Airline
	if (rgar($entry, '56') != '') {
		echo '<b>' . rgar($entry, '56') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Other Departure Airline
	if (rgar($entry, '57') != '') {
		echo '<b>' . rgar($entry, '57') . '</b>';
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
	
	echo '<td>';
	// How do you plan on arriving at the lodge?
	if (rgar($entry, '168') != '') {
		echo '<b>' . rgar($entry, '168') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Other option on arriving at the lodge
	if (rgar($entry, '175') != '') {
		echo '<b>' . rgar($entry, '175') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// What time do you plan on arriving at the airstrip?
	if (rgar($entry, '236') != '') {
		echo '<b>' . rgar($entry, '236') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Do you need shuttle service from the airstrip?
	if (rgar($entry, '287') != '') {
		echo '<b>' . rgar($entry, '287') . '</b>';
	}
	echo '</td>';
	
	echo '<td>';
	// Do you need shuttle service?
	if (rgar($entry, '34') != '') {
		echo '<b>' . rgar($entry, '34') . '</b>';
	}
	echo '</td>';
	
	echo  '<td>';
	// Estimated time of arrival at lodge?
	if (rgar($entry, '32') != '') {
		echo '<b>' . rgar($entry, '32') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Arrival airport city/town
	if (rgar($entry, '178') != '') {
		echo '<b>' . rgar($entry, '178') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Arrival airline
	if (rgar($entry, '171') != '') {
		echo '<b>' . rgar($entry, '171') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other airline
	if (rgar($entry, '173') != '') {
		echo '<b>' . rgar($entry, '173') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Flight arrival date formating to m-d-Y
	$dateOfFlightArr = rgar($entry, '169');
	$flightArrDateTime = DateTime::createFromFormat('Y-m-d', $dateOfFlightArr);
	
	if ($flightArrDateTime) {
		$formattedDateOfFlightArr = $flightArrDateTime->format('m-d-Y');
	} else {
		$formattedDateOfFlightArr = 'Invalid date format';
	}
	// Flight arrival date
	if (rgar($entry, '169') != '') {
		echo '<b>' . $formattedDateOfFlightArr . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Arrival airline flight number
	if (rgar($entry, '170') != '') {
		echo '<b>' . rgar($entry, '170') . '</b>';
	}
	echo  '</td>';
	
	echo '<td>';
	// Scheduled arrival time
	if (rgar($entry, '174') != '') {
		echo '<b>' . rgar($entry, '174') . '</b';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Depature airport city/town
	if (rgar($entry, '288') != '') {
		echo '<b>' . rgar($entry, '288') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Departure airline
	if (rgar($entry, '224') != '') {
		echo '<b>' . rgar($entry, '224') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other departure airline
	if (rgar($entry, '225') != '') {
		echo '<b>' . rgar($entry, '225') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Flight depature date formating to m-d-Y
	$dateOfDepature226 = rgar($entry, '226');
	$departureDateTime226 = DateTime::createFromFormat('Y-m-d', $dateOfDepature226);
	
	if ($departureDateTime226) {
		$formattedDateOfDeparture226 = $departureDateTime226->format('m-d-Y');
	} else {
		$formattedDateOfDeparture226 = 'Invalid date format';
	}
	
	// Flight departure date
	if (rgar($entry, '226') != '') {
		echo '<b>' . $formattedDateOfDeparture226 . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Departure airline flight number
	if (rgar($entry, '227') != '') {
		echo '<b>' . rgar($entry, '227') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Scheduled departure time
	if (rgar($entry, '228') != '') {
		echo '<b>' . rgar($entry, '228') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Name(s) of others traveling with you
	if (rgar($entry, '21') != '') {
		echo '<b>' . rgar($entry, '21') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Would you like to upgrade your hotel in Ulaanbaatar?
	if (rgar($entry, '179') != '') {
		echo '<b>' . rgar($entry, '179') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Will you need extra nights arranged for you?
	if (rgar($entry, '247') != '') {
		echo '<b>' . rgar($entry, '247') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Please let us know the dates of the extra nights
	if (rgar($entry, '251') != '') {
		echo '<b>' . rgar($entry, '251') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Anchorage Alaska Hotel you will be staying in
	if (rgar($entry, '205') != '') {
		echo '<b>' . rgar($entry, '205') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other Anchorage hotel
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
	// Hotel Info - Include telephone number - special instructions
	if (rgar($entry, '216') != '') {
		echo '<b>' . rgar($entry, '216') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Overnight in Manaus
	if (rgar($entry, '231') != '') {
		echo '<b>' . rgar($entry, '231') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Who would you like to share a room with?
	if (rgar($entry, '232') != '') {
		echo '<b>' . rgar($entry, '232') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Overnight on return
	if (rgar($entry, '233') != '') {
		echo '<b>' . rgar($entry, '233') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Room type
	if (rgar($entry, '234') != '') {
		echo '<b>' . rgar($entry, '234') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Who would you like to share a room with?
	if (rgar($entry, '235') != '') {
		echo '<b>' . rgar($entry, '235') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to rent rods and reels from the lodge?
	if (rgar($entry, '163') != '') {
		echo '<b>' . rgar($entry, '163') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to use rods and reels provided by the lodge?
	if (rgar($entry, '36') != '') {
		echo '<b>' . rgar($entry, '36') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// What hand do you reel with?
	$reel_with = [];
	foreach ($entry as $key => $value) {
		if (strpos($key, '75.') === 0 && !empty($value)) {
			$reel_with[] = $value;
		}
	}
	// Hand you reel with
	if (!empty($reel_with)) {
		echo '<b> ' . esc_html(implode(', ', $reel_with)) . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to rent waders and boots from the lodge?
	if (rgar($entry, '164') != '') {
		echo '<b>' . rgar($entry, '164') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to use waders provided by the lodge?
	if (rgar($entry, '74') != '') {
		echo '<b>' . rgar($entry, '74') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Wader size?
	if (rgar($entry, '123') != '') {
		echo '<b>' . rgar($entry, '123') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Wader size chart for men
	if (rgar($entry, '126') != '') {
		echo '<b>' . rgar($entry, '126') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Wader size chart for women
	if (rgar($entry, '266') != '') {
		echo '<b>' . rgar($entry, '266') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to use wading boots provided bt the lodge?
	if (rgar($entry, '122') != '') {
		echo '<b>' . rgar($entry, '122') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Shoe size?
	if (rgar($entry, '121') != '') {
		echo '<b>' . rgar($entry, '121') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Men's sizes
	if (rgar($entry, '119') != '') {
		echo '<b>' . rgar($entry, '119') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Womens's sizes
	if (rgar($entry, '120') != '') {
		echo '<b>' . rgar($entry, '120') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need to rent a sleeping bag
	if (rgar($entry, '221') != '') {
		echo '<b>' . rgar($entry, '221') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you need any of the following equipment provided by the outfitter?
	$rent_equip = [];
	foreach ($entry as $key => $value) {
		if (strpos($key, '136.') === 0 && !empty($value)) {
			$rent_equip[] = $value;
		}
	}
	// Equipment to rent
	if (!empty($rent_equip)) {
		echo '<b> ' . esc_html(implode(', ', $rent_equip)) . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Preferred style of fishing
	if (rgar($entry, '118') != '') {
		echo '<b>' . rgar($entry, '118') . '</b>';
	}
	echo  '</td>';
  
  echo  '<td>';
  // Is there a particular fish you wish to target?
  if (rgar($entry, '182') != '') {
    echo '<b>' . rgar($entry, '182') . '</b>';
  }
  echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For certain species of fish being targeting.
	 */
	$checkbox_ids = ['214.1', '214.2', '214.3', '214.4', '214.5', '214.6', '214.7', '214.8', '214.9']; // Add as many as needed, or determine dynamically based on your specific form setup.
	
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
	// Do you have interest in fishing the Kenai River to target Trout and/or Silver Salmon?
	if (rgar($entry, '217') != '') {
		echo '<b>' . rgar($entry, '217') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Type of fishing you prefer?
	if (rgar($entry, '244') != '') {
		echo '<b>' . rgar($entry, '244') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Are you fishing 1 or 2 to a boat/guide?
	if (rgar($entry, '240') != '') {
		echo '<b>' . rgar($entry, '240') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Name of fishing companion you would like to share the boat with
	if (rgar($entry, '241') != '') {
		echo '<b>' . rgar($entry, '241') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For what species have you fished for?
	 */
	$checkbox_ids_saltSpecies = ['242.1', '242.2', '242.3', '242.4', '242.5']; // Add as many as needed, or determine dynamically based on your specific form setup.
	
	$selected_saltSpecies = [];
	
	foreach ($checkbox_ids_saltSpecies as $checkbox_id_saltSpecie) {
		$saltSpecies_value = rgar($entry, $checkbox_id_saltSpecie);
		if (!empty($saltSpecies_value)) {
			$selected_saltSpecies[] = $saltSpecies_value;
		}
	}
	
	// Have you fished in saltwater before? If so, where and for what species?
	if (!empty($selected_saltSpecies)) {
		$saltSpeciesCount = count($selected_saltSpecies);
		foreach ($selected_saltSpecies as $index => $saltSpecies) {
			echo '<b>' . esc_html($saltSpecies) . '</b>';
			if ($index !== $saltSpeciesCount - 1) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other saltwater species
	if (rgar($entry, '243') != '') {
		echo '<b>' . rgar($entry, '243') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Which style of guiding sounds like the best fit for you?
	if (rgar($entry, '246') != '') {
		echo '<b>' . rgar($entry, '246') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// What type of fishing experience do you prefer?
	if (rgar($entry, '125') != '') {
		echo '<b>' . rgar($entry, '125') . '</b>';
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
	if (rgar($entry, '222') != '') {
		echo '<b>' . rgar($entry, '222') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you want to substitute Horseback Guided Fishing for one angling day?
	if (rgar($entry, '254') != '') {
		echo '<b>' . rgar($entry, '254') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Date to subsitute horseback guided fishing - formating to m-d-Y
	$dateHorsebackFishing = rgar($entry, '255');
	$horsebackDate = DateTime::createFromFormat('Y-m-d', $dateHorsebackFishing);
	
	if ($horsebackDate) {
		$dateofHorsebackFishing = $horsebackDate->format('m-d-Y');
	} else {
		$dateofHorsebackFishing = 'Invalid date format';
	}
	
	// Horseback guided fishing date
	if (rgar($entry, '255') != '') {
		echo '<b>' . $dateofHorsebackFishing . '</b>';
	}
	
	echo  '</td>';
	
	echo  '<td>';
	// Horse riding experience
	if (rgar($entry, '181') != '') {
		echo '<b>' . rgar($entry, '181') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Characterize your wading ability
	if (rgar($entry, '218') != '') {
		echo '<b>' . rgar($entry, '218') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Interested in heli fishing at Poronoui Lodge?
	if (rgar($entry, '265') != '') {
		echo '<b>' . rgar($entry, '265') . '</b>';
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
	/**
	 * Define the range of checkbox IDs based on your form configuration. For misc allergic reactions
	 */
	$checkbox_ids_allergyMisc = ['183.1', '183.2', '183.3', '183.4', '183.5']; // Add as many as needed, or determine dynamically based on your specific form setup.
	
	$selected_allergyMisc = [];
	
	foreach ($checkbox_ids_allergyMisc as $checkbox_id_allergyMisc) {
		$allergyMisc_value = rgar($entry, $checkbox_id_allergyMisc);
		if (!empty($allergyMisc_value)) {
			$selected_allergyMisc[] = $allergyMisc_value;
		}
	}
	
	// Have you had allergic reactions to any of the following?
	if (!empty($selected_allergyMisc)) {
		$allergyMiscCount = count( $selected_allergyMisc );
		foreach ( $selected_allergyMisc as $index => $allergyMisc ) {
			echo '<b>' . esc_html( $allergyMisc ) . '</b>';
			if ( $index !== $allergyMiscCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other misc allergies
	if (rgar($entry, '184') != '') {
		echo '<b>' . rgar($entry, '184') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Will you be using any prescribed medicine?
	if (rgar($entry, '274') != '') {
		echo '<b>' . rgar($entry, '274') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Perscription details
	if ( rgar( $entry, '275' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$paragraph_content = rgar( $entry, '275' );
		
		// Extract the first 10 words from the paragraph content
		$words_array = explode( ' ', $paragraph_content );
		$excerpt     = implode( ' ', array_slice( $words_array, 0, 2 ) );
		
		// Escape content for safe JavaScript usage
		$escaped_excerpt = htmlspecialchars( $excerpt, ENT_QUOTES, 'UTF-8' );
		$escaped_content = htmlspecialchars( $paragraph_content, ENT_QUOTES, 'UTF-8' );
		
		// Construct the "Read more" link to display in the popover
		$read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
		
		// Combine the excerpt and "Read more" link for the popover content
		$data_content = "{$escaped_content}";
		
		// Output perscription details button with popover
		echo <<<HTML
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$data_content}"> <b>{$escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
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
	// Blood type
	if (rgar($entry, '276') != '') {
		echo '<b>' . rgar($entry, '276') . '</b>';
	}
	echo  '</td>';
	
	
	
	echo  '<td>';
	// If applicable, please provide further information for any of the allergies identified above. Including what provokes and treats the allergy. Especially if you have experienced an anaphylactic reaction to the allergen.
	if ( rgar( $entry, '185' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$allergy_paragraph_content = rgar( $entry, '185' );
		
		// Extract the first 10 words from the paragraph content
		$allergy_words_array = explode( ' ', $allergy_paragraph_content );
		$allergy_excerpt     = implode( ' ', array_slice( $allergy_words_array, 0, 2 ) );
		
		// Escape content for safe JavaScript usage
		$allergy_escaped_excerpt = htmlspecialchars( $allergy_excerpt, ENT_QUOTES, 'UTF-8' );
		$allergy_escaped_content = htmlspecialchars( $allergy_paragraph_content, ENT_QUOTES, 'UTF-8' );
		
		// Construct the "Read more" link to display in the popover
		$read_more_link = '<a href="#" class="read-more" onclick="showFullContent(this); return false;"></a>';
		
		// Combine the excerpt and "Read more" link for the popover content
		$allergy_data_content = "{$allergy_escaped_content}";
		
		// Output perscription details button with popover
		echo <<<HTML
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$allergy_data_content}"> <b>{$allergy_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
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
	/**
	 * Define the range of checkbox IDs based on your form configuration. For misc allergic reactions
	 */
	$checkbox_ids_anyFollowing = ['186.1', '186.2', '186.3', '186.4', '186.5']; // Add as many as needed, or determine
	// dynamically based on your specific form setup.
	
	$selected_anyFollowing = [];
	
	foreach ($checkbox_ids_anyFollowing as $checkbox_id_anyFollowing) {
		$anyFollowing_value = rgar($entry, $checkbox_id_anyFollowing);
		if (!empty($anyFollowing_value)) {
			$selected_anyFollowing[] = $anyFollowing_value;
		}
	}
	
	// Have you had allergic reactions to any of the following?
	if (!empty($selected_anyFollowing)) {
		$anyFollowingCount = count( $selected_anyFollowing );
		foreach ( $selected_anyFollowing as $index => $anyFollowing ) {
			echo '<b>' . esc_html( $anyFollowing ) . '</b>';
			if ( $index !== $anyFollowingCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other reactions
	if (rgar($entry, '187') != '') {
		echo '<b>' . rgar($entry, '187') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// If you checked any of the conditions above, please explain as necessary. Please include any other health requirements.
	if (rgar($entry, '188') != '') {
		echo '<b>' . rgar($entry, '188') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Diet Aversions/Dislikes
	if (rgar($entry, '100') != '') {
		echo '<b>' . rgar($entry, '100') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Diet Aversions/Dislikes
	if (rgar($entry, '100') != '') {
		echo '<b>' . rgar($entry, '100') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you have any aversion to eating game meat?
	if (rgar($entry, '272') != '') {
		echo '<b>' . rgar($entry, '272') . '</b>';
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
	// Have you been Vaccinated for COVID-19?
	if (rgar($entry, '257') != '') {
		echo '<b>' . rgar($entry, '257') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Brand/type of Vaccination and dates recieved
	if (rgar($entry, '262') != '') {
		echo '<b>' . rgar($entry, '262') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Vaccination Photo Copy
	if (rgar($entry, '264') != '') {
		// Retrieve the relative URL from the entry.
		$vaxCard_relative_url = rgar($entry, '264');
		
		// Remove any leading slash.
		$vaxCard_relative_url = ltrim($vaxCard_relative_url, '/');
		
		// Define your custom base URL. Edit based on hosting environment.
		$vaxCard_custom_base_url = 'http://www.theflyshop.local/wp-content/uploads';
		
		// Derive the relative part of the path after "uploads" directory.
		$vaxCard_path_relative_to_uploads = strstr($vaxCard_relative_url, 'gravity_forms');
		
		// Construct the full URL using custom base URL.
		$vaxCard_full_url = $vaxCard_custom_base_url . '/' . $vaxCard_path_relative_to_uploads;
		
		// Sanitize the constructed URL.
		$vaxCard_file_url = esc_url($vaxCard_full_url);
		
		// Output the image.
		echo <<<HTML
        <button type="button" class="btn btn-passport-preview btn-popover" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<img src='{$vaxCard_file_url}' alt='Uploaded Photo' style='width: 600px; height: auto;'>">
        <div class="overlay-container">
            <img class='passport-copy-preview' src='{$vaxCard_file_url}' alt='Uploaded Photo'/>
            <p class="overlay-text">Click to see card</p>
        </button>
        </div>
        <style>
            .popover {
                max-width: none; /* Allow the popover to expand to the size of the content */
            }
            .popover-content img {
                width: 600px; /* Adjust the width as needed */
                height: auto; /* Maintain aspect ratio */
            }
        </style>
        HTML;
	}
	echo  '</td>';
	
	echo  '<td>';
	// Medical insurance including HTA CV19 related isolation, quarantine and clinical care?
	if (rgar($entry, '263') != '') {
		echo '<b>' . rgar($entry, '263') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
// Would you like to have an ice cooler filled with block ice:  $125.00. If not all drinks are cooled in the river.
	if (rgar($entry, '291') != '') {
		echo '<b>' . rgar($entry, '291') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
// Guests wishing to avoid carrying personal gear to the river on their back may prearrange to have their gear taken in for an additional fee. Would you like to have your personal gear packed to the River?
	if (rgar($entry, '292') != '') {
		echo '<b>' . rgar($entry, '292') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// If you are arriving early and or departing late, would you like to hire a guide for those days?
	if (rgar($entry, '220') != '') {
		echo '<b>' . rgar($entry, '220') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// What Beverage would you like with your Lunches?
	if (rgar($entry, '213') != '') {
		echo '<b>' . rgar($entry, '213') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Would you like the Lodge to purchase Beverages for you for the Float?
	if (rgar($entry, '159') != '') {
		echo '<b>' . rgar($entry, '159') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #1 (Soda, Coke, Sprite, etc) $7.50
	if (rgar($entry, '146') != '') {
		echo '<b>' . rgar($entry, '146') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #1 Amount
	if (rgar($entry, '147') != '') {
		echo '<b>' . rgar($entry, '147') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #2 (Gatorade, Iced Tea, etc) $9.50
	if (rgar($entry, '148') != '') {
		echo '<b>' . rgar($entry, '148') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #2 Amount
	if (rgar($entry, '149') != '') {
		echo '<b>' . rgar($entry, '149') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage choice #3 (domestic, Bud, Miller, etc) $9.50
	if (rgar($entry, '151') != '') {
		echo '<b>' . rgar($entry, '151') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage choice #3 amount
	if (rgar($entry, '152') != '') {
		echo '<b>' . rgar($entry, '152') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #4 (Import, Heineken, etc) $11.50
	if (rgar($entry, '153') != '') {
		echo '<b>' . rgar($entry, '153') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage choice #4 amount
	if (rgar($entry, '154') != '') {
		echo '<b>' . rgar($entry, '154') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #5 (Microbrews) $13.50
	if (rgar($entry, '156') != '') {
		echo '<b>' . rgar($entry, '156') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage choice #5 amount
	if (rgar($entry, '155') != '') {
		echo '<b>' . rgar($entry, '155') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage Choice #6 Box Wine @ Cost
	if (rgar($entry, '157') != '') {
		echo '<b>' . rgar($entry, '157') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Beverage choice #6 amount
	if (rgar($entry, '158') != '') {
		echo '<b>' . rgar($entry, '158') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Please let us know the level of housekeeping you prefer:
	if (rgar($entry, '189') != '') {
		echo '<b>' . rgar($entry, '189') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Would you like to place an alcohol order?
	if (rgar($entry, '133') != '') {
		echo '<b>'
		     . rgar($entry, '133') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Preferred beverage to be purchased
	if (rgar($entry, '134') != '') {
		echo '<b>'
		     . rgar($entry, '134') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Amount
	if (rgar($entry, '135') != '') {
		echo '<b>' . rgar($entry, '135') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Other amount to be purchased
	if (rgar($entry, '238') != '') {
		echo '<b>' . rgar($entry, '238') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For drink preference
	 */
	$checkbox_ids_drinkPref = ['229.1', '229.2', '229.3', '229.4', '229.5']; // Add as many as needed, or determine
	// dynamically based on your specific form setup.
	
	$selected_drinkPref = [];
	
	foreach ($checkbox_ids_drinkPref as $checkbox_id_drinkPref) {
		$drinkPref_value = rgar($entry, $checkbox_id_drinkPref);
		if (!empty($drinkPref_value)) {
			$selected_drinkPref[] = $drinkPref_value;
		}
	}
	
	// Drink preference
	if (!empty($selected_drinkPref)) {
		$drinkPrefCount = count( $selected_drinkPref );
		foreach ( $selected_drinkPref as $index => $drinkPref ) {
			echo '<b>' . esc_html( $drinkPref ) . '</b>';
			if ( $index !== $drinkPrefCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Shirt size
	if (rgar($entry, '253') != '') {
		echo '<b>' . rgar($entry, '253') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Choice of bed
	if (rgar($entry, '230') != '') {
		echo '<b>' . rgar($entry, '230') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Preferred evening beverage
	if (rgar($entry, '99') != '') {
		echo '<b>' . rgar($entry, '99') . '</b>';
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
	/**
	 * Define the range of checkbox IDs based on your form configuration. For guided activities.
	 */
	$checkbox_ids_guidedActivities = ['285.1', '285.2', '285.3', '285.4', '285.5', '285.6', '285.7', '285.8'];
	
	$selected_guidedActivities = [];
	
	foreach ($checkbox_ids_guidedActivities as $checkbox_id_guidedActivities) {
		$guidedActivities_value = rgar($entry, $checkbox_id_guidedActivities);
		if (!empty($guidedActivities_value)) {
			$selected_guidedActivities[] = $guidedActivities_value;
		}
	}
	
	// Guided activities
	if (!empty($selected_guidedActivities)) {
		$guidedActivitiesCount = count( $selected_guidedActivities );
		foreach ( $selected_guidedActivities as $index => $guidedActivities ) {
			echo '<b>' . esc_html( $guidedActivities ) . '</b>';
			if ( $index !== $guidedActivitiesCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Were you interested in massages during your stay?
	if (rgar($entry, '200') != '') {
		echo '<b>' . rgar($entry, '200') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Massage date - formating to m-d-Y
	$datemassageDate = rgar($entry, '269');
	$massageDate = DateTime::createFromFormat('Y-m-d', $datemassageDate);
	
	if ($massageDate) {
		$dateofmassage = $massageDate->format('m-d-Y');
	} else {
		$dateofmassage = 'Invalid date format';
	}

// massage date
	if (rgar($entry, '269') != '') {
		echo '<b>' . $dateofmassage . '</b>';
	}
	echo  '</td>';
	
	
	echo  '<td>';
	// Please tell us about your event or celebration
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
	
	echo  '<td>';
	// Trip goals
	if ( rgar( $entry, '202' ) != '' ) {
		// Retrieve the paragraph content from the entry
		$tripGoals_paragraph_content = rgar( $entry, '202' );
		
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
	    <button type="button" class="btn btn-popover" data-toggle="popover" data-placement="bottom" data-html="true"
	    data-content="{$tripGoals_data_content}"> <b>{$tripGoals_escaped_excerpt}...<span style="color:red;">&nbsp;Click to see
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
	// Interested in pre-booking Scuba diving?
	if (rgar($entry, '258') != '') {
		echo '<b>' . rgar($entry, '258') . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	// Scuba diving date - formating to m-d-Y
	$datescubaDiving = rgar($entry, '259');
	$scubaDivingDate = DateTime::createFromFormat('Y-m-d', $datescubaDiving);
	
	if ($scubaDivingDate) {
		$dateofscubaDiving = $scubaDivingDate->format('m-d-Y');
	} else {
		$dateofscubaDiving = 'Invalid date format';
	}

// Scuba diving date
	if (rgar($entry, '259') != '') {
		echo '<b>' . $dateofscubaDiving . '</b>';
	}
	echo  '</td>';
	
	echo  '<td>';
	/**
	 * Define the range of checkbox IDs based on your form configuration. For leisure activities.
	 */
	$checkbox_ids_leisureActivities = ['260.1', '260.2', '260.3', '260.4', '260.5', '260.6', '260.7', '260.8', '260.9'];
	
	$selected_leisureActivities = [];
	
	foreach ($checkbox_ids_leisureActivities as $checkbox_id_leisureActivities) {
		$leisureActivities_value = rgar($entry, $checkbox_id_leisureActivities);
		if (!empty($leisureActivities_value)) {
			$selected_leisureActivities[] = $leisureActivities_value;
		}
	}
	
	// Leisure activities
	if (!empty($selected_leisureActivities)) {
		$leisureActivitiesCount = count( $selected_leisureActivities );
		foreach ( $selected_leisureActivities as $index => $leisureActivities ) {
			echo '<b>' . esc_html( $leisureActivities ) . '</b>';
			if ( $index !== $leisureActivitiesCount - 1 ) {
				echo '&#44;&nbsp;';
			}
		}
	}
	echo  '</td>';
	
	echo  '<td>';
	// Do you give permission for East Coast Angling to use photo's taken of yourself with fish onboard during your trip?
	if (rgar($entry, '278') != '') {
		echo '<b>' . rgar($entry, '278') . '</b>';
	}
echo  '</td>';
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo '</tr>';
	
	$counter++;
}

