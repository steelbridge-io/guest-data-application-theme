<?php


echo '<div id="filter-cont" class="container filter-wrap">';
echo '<form method="GET">';
echo '<div class="row">';

/** @var  $reservation_id */

$reservation_id = filter_input( INPUT_GET, 'filter_reservation_id', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_reservation_id">Reservation &#35;:</label>';
echo '<input type="text" id="filter_reservation_id" name="filter_reservation_id" value="'
     . ( isset( $reservation_id ) ? $reservation_id : '' )
     . '">';
echo '</div>';

/** @var  $name */

$name = filter_input( INPUT_GET, 'filter_name', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_name">Last Name:</label>';
echo '<input type="text" id="filter_name" name="filter_name" value="'
     . ( isset( $name ) ? $name : '' )
     . '">';
echo '</div>';


/** @var  $email */

$email = filter_input( INPUT_GET, 'filter_email', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_email">Email:</label>';
echo '<input type="text" id="filter_email" name="filter_email" value="'
     . ( isset( $email ) ? $email : '' )
     . '">';
echo '</div>';

/** @var  $cell_phone */

$cell_phone = filter_input( INPUT_GET, 'filter_cell_phone', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_cell_phone">Cell Phone:</label>';
echo '<input type="tel" id="filter_cell_phone" name="filter_cell_phone" value="'
     . ( isset( $cell_phone ) ? $cell_phone : '' )
     . '">';
echo '</div>';

/** @var  $arrival_date */

$arrival_date = filter_input( INPUT_GET, 'filter_arrival_date', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_arrival_date">Arrival Date:</label>';
echo '<input type="date" id="filter_arrival_date" name="filter_arrival_date" value="'
     . ( isset( $arrival_date ) ? $arrival_date : '' )
     . '">';
echo '</div>';

/** @var  $departure_date */

$departure_date = filter_input( INPUT_GET, 'filter_departure_date', FILTER_SANITIZE_SPECIAL_CHARS );
echo '<div class="well col-md-4">';
echo '<label for="filter_departure_date">Departure Date:</label>';
echo '<input type="date" id="filter_departure_date" name="filter_departure_date" value="'
     . ( isset( $departure_date ) ? $departure_date : '' )
     . '">';
echo '</div>';

echo '</div>'; // </row>

echo '<div id="question-items" class="display-items-inline well">';

/** @var  $tel_number */

/*$tel_number = filter_input(INPUT_GET, 'filter_tel_number', FILTER_SANITIZE_SPECIAL_CHARS);

echo '<label for="filter_tel_number">Tel:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_tel_number" name="filter_tel_number" value="Yes"'
     . (isset($tel_number) && $tel_number == 'Yes' ? ' checked' : '') . '>';*/

/** @var  $shuttle_service */

/*$shuttle_service = filter_input(INPUT_GET, 'filter_shuttle_service', FILTER_SANITIZE_SPECIAL_CHARS);

echo '<label for="filter_shuttle_service">Shuttle Service:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_shuttle_service" name="filter_shuttle_service" value="Yes"'
     . (isset($shuttle_service) && $shuttle_service == 'Yes' ? ' checked' : '') . '>';*/

/** @var  $other_travelers */

$other_travelers = filter_input( INPUT_GET, 'filter_other_travelers', FILTER_SANITIZE_SPECIAL_CHARS );

echo '<label for="filter_other_travelers">Other Travelers:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_other_travelers" name="filter_other_travelers" value="Yes"'
     . ( isset( $other_travelers ) && $other_travelers == 'Yes' ? ' checked' : '' ) . '>';

/** @var  $needs_equip */

$needs_equip = filter_input( INPUT_GET, 'filter_needs_equip', FILTER_SANITIZE_SPECIAL_CHARS );

echo '<label for="filter_needs_equip">Needs Rods:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_needs_equip" name="filter_needs_equip" value="Yes"'
     . ( isset( $needs_equip ) && $needs_equip == 'Yes' ? ' checked' : '' ) . '>';

/** @var  $dietary_allergies */

$dietary_allergies = filter_input( INPUT_GET, 'filter_dietary_allergies', FILTER_SANITIZE_SPECIAL_CHARS );

echo '<label for="filter_dietary_allergies">Allergies &amp; Dietary:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_dietary_allergies" name="filter_dietary_allergies" value="Yes"'
     . ( isset( $dietary_allergies ) && $dietary_allergies == 'Yes' ? ' checked' : '' ) . '>';

echo '</div>';

$base_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$base_url = strtok( $base_url, '?' );

echo '<input class="filter-btn" type="submit" value="Filter">';
echo '<a href="' . $base_url . '" class="btn btn-danger clear-results" title="Clear results">Clear Results</a>';
echo '</form>';
echo '</div>';

/**
 * This script is setting up some search criteria
 * Initially, it's setting up that only the 'active' status is wanted in the search criteria
 */

$search_criteria['status'] = 'active';

if ( isset( $reservation_id ) && $reservation_id != '' ) {
	$search_criteria['field_filters'][] = array( 'key' => '44', 'value' => $reservation_id ); // check reservation id
}

if ( isset( $_GET['filter_name'] ) && $_GET['filter_name'] != '' ) {
	$search_criteria['field_filters'][] = array( 'key' => '1.6', 'value' => $_GET['filter_name'] ); // check last name
}

/*if (isset($_GET['filter_email']) && $_GET['filter_email'] != '') {
	$search_criteria['field_filters'][] = array('key' => '261', 'value' => $_GET['filter_email']); // check email
}*/

if ( isset( $_GET['filter_cell_phone'] ) && $_GET['filter_cell_phone'] != '' ) {
	$search_criteria['field_filters'][] = array( 'key'   => '101',
	                                             'value' => $_GET['filter_cell_phone']
	); // check cell phone
}

if ( isset( $arrival_date ) && $arrival_date != '' ) {
	$search_criteria['field_filters'][] = array( 'key' => '66', 'value' => $arrival_date ); // check arrival date
}

if ( isset( $departure_date ) && $departure_date != '' ) {
	$search_criteria['field_filters'][] = array( 'key' => '67', 'value' => $departure_date ); // check departure date
}

/*if (isset($trip_type) && $trip_type != '') {
	$search_criteria['field_filters'][] = array('key' => '180', 'value' => $trip_type);
}*/

/*if (isset($trip_destinations) && !empty($trip_destinations)) {
	foreach ($trip_destinations as $destination) {
		$search_criteria['field_filters'][] = array('key' => '223', 'value' => $destination);
	}
}*/

/*if (isset($trip_rivers_floating_alaska) && !empty($trip_rivers_floating_alaska)) {
	foreach ($trip_rivers_floating_alaska as $float_destination) {
		$search_criteria['field_filters'][] = array('key' => '212', 'value' => $float_destination);
	}
}*/

/*if (isset($shuttle_service)) {
	$search_criteria['field_filters'][] = array('key' => '34', 'value' => 'Yes');
}*/

if ( isset( $needs_equip ) ) {
	$search_criteria['field_filters'][] = array( 'key' => '292', 'value' => 'Yes' );
}

if ( $other_travelers == 'Yes' ) {
	$search_criteria['field_filters'][] = array( 'key' => '21', 'operator' => 'isnot', 'value' => '' );
}

if ( $dietary_allergies == 'Yes' ) {
	$search_criteria['field_filters'][] = array( 'key' => '88', 'operator' => 'isnot', 'value' => '' );
}

/*if ($tel_number == 'Yes') {
	$search_criteria['field_filters'][] = array('key' => '26', 'operator' => 'isnot', 'value' => '');
}*/


