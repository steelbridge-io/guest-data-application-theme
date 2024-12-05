<?php

echo '<div id="filter-cont" class="container filter-wrap">';
echo '<form method="GET">';
echo '<div class="row">';

/** @var  $reservation_id */

$reservation_id = filter_input(INPUT_GET, 'filter_reservation_id', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_reservation_id">Reservation &#35;:</label>';
echo '<input type="text" id="filter_reservation_id" name="filter_reservation_id" value="'
     . (isset($reservation_id) ? $reservation_id : '')
     . '">';
echo '</div>';

/** @var  $name */

$name = filter_input(INPUT_GET, 'filter_name', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_name">Last Name:</label>';
echo '<input type="text" id="filter_name" name="filter_name" value="'
     . (isset($name) ? $name : '')
     . '">';
echo '</div>';


/** @var  $email */

$email = filter_input(INPUT_GET, 'filter_email', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_email">Email:</label>';
echo '<input type="text" id="filter_email" name="filter_email" value="'
     . (isset($email) ? $email : '')
     . '">';
echo '</div>';

/** @var  $cell_phone */

$cell_phone = filter_input(INPUT_GET, 'filter_cell_phone', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_cell_phone">Cell Phone:</label>';
echo '<input type="tel" id="filter_cell_phone" name="filter_cell_phone" value="'
     . (isset($cell_phone) ? $cell_phone : '')
     . '">';
echo '</div>';

/** @var  $arrival_date */

$arrival_date = filter_input(INPUT_GET, 'filter_arrival_date', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_arrival_date">Arrival Date:</label>';
echo '<input type="date" id="filter_arrival_date" name="filter_arrival_date" value="'
     . (isset($arrival_date) ? $arrival_date : '')
     . '">';
echo '</div>';

/** @var  $departure_date */

$departure_date = filter_input(INPUT_GET, 'filter_departure_date', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well col-md-3">';
echo '<label for="filter_departure_date">Departure Date:</label>';
echo '<input type="date" id="filter_departure_date" name="filter_departure_date" value="'
     . (isset($departure_date) ? $departure_date : '')
     . '">';
echo '</div>';

echo '</div>'; // </row>

/** @var  $trip_type */

/*$trip_type = filter_input(INPUT_GET, 'filter_trip_type', FILTER_SANITIZE_SPECIAL_CHARS);
echo '<div class="well">';
echo '<label class="form-check-label" for="filter_trip_type">Trip Type:</label>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" id="filter_trip_type_lodge" name="filter_trip_type" value="Lodge"'
    . (isset($trip_type) && $trip_type == 'Lodge' ? ' checked' : '') . '>';
echo '<label class="form-check-label" for="filter_trip_type_lodge">Lodge</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" id="filter_trip_type_wilderness" name="filter_trip_type" value="Wilderness Float"' . (isset($trip_type) && $trip_type == 'Wilderness Float' ? ' checked' : '') . '>';
echo '<label class="form-check-label" for="filter_trip_type_wilderness">Wilderness Float</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="radio" id="filter_trip_type_both" name="filter_trip_type" value="Both"'
    . (isset($trip_type) && $trip_type == 'Both' ? ' checked' : '') . '>';
echo '<label class="form-check-label" for="filter_trip_type_both">Both</label>';
echo '</div>';

echo '</div>';*/

/** @var array $trip_destinations */

/*$trip_destinations = filter_input(INPUT_GET, 'filter_trip_destination',
    FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
echo '<div class="well">';
echo '<label for="filter_trip_destination">What Destination(s) are you fishing at &#x3f;:</label><br>';

$destinations = [
    'Limay River Lodge' => 'Limay River Lodge',
    'Estancia Arroyo Verde' => 'Estancia Arroyo Verde',
    'Estancia Pilolil' => 'Estancia Pilolil',
    'Collon Cura Lodge' => 'Collon Cura Lodge',
    'Estancia Tipiliuke' => 'Estancia Tipiliuke',
    'Estancia San Huberto' => 'Estancia San Huberto',
    'Estancia Quemquemtreu' => 'Estancia Quemquemtreu',
    'Tres Rios Lodge' => 'Tres Rios Lodge'
];

foreach ($destinations as $value => $label) {
    $checked = isset($trip_destinations) && in_array($value, $trip_destinations) ? ' checked' : '';
    echo '<div class="form-check form-check-inline">';
    echo '<input type="radio" class="form-check-input" id="filter_trip_destination_' . strtolower(str_replace(' ', '_', $label)) . '" name="filter_trip_destination[]" value="' . $value . '"' . $checked . '>';
    echo '<label class="form-check-label" for="filter_trip_destination_' . strtolower(str_replace(' ', '_', $label)) . '">' . $label . '</label><br>';
    echo '</div>';
}
echo '</div>';*/


/** @var array $trip_rivers_floating_alaska */

/*$trip_rivers_floating_alaska = filter_input(INPUT_GET, 'filter_rivers_floating_alaska',
    FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
echo '<div class="well">';
echo '<label for="filter_trip_destination">Rivers in Alaska you are floating:</label><br>';

$float_destinations = [
    'Kanektok River Float' => 'Kanektok River Float',
    'Goodnews River Float' => 'Goodnews River Float',
    'Kisarolik River Float' => 'Kisarolik River Float',
    'Arolik River' => 'Arolik River',
    'Moraine River' => 'Moraine River',
    'Alagnak River' => 'Alagnak River',
    'Other' => 'Other'
];

foreach ($float_destinations as $value => $label) {
    $checked = isset($trip_rivers_floating_alaska) && in_array($value, $trip_rivers_floating_alaska) ? ' checked' : '';
    echo '<div class="form-check form-check-inline">';
    echo '<input class="form-check-input" type="radio" id="filter_rivers_floating_alaska' . strtolower(str_replace(' ', '_', $label)) . '" name="filter_rivers_floating_alaska[]" value="' . $value . '"' . $checked . '>';
    echo '<label class="form-check-label" for="filter_rivers_floating_alaska' . strtolower(str_replace(' ', '_', $label)) . '">' . $label . '</label><br>';
    echo '</div>';
}
echo '</div>';*/


echo '<div id="question-items" class="display-items-inline well">';

/** @var  $other_travelers */

$other_travelers = filter_input(INPUT_GET, 'filter_other_travelers', FILTER_SANITIZE_SPECIAL_CHARS);

echo '<label for="filter_other_travelers">Other Travelers:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_other_travelers" name="filter_other_travelers" value="Yes"'
     . (isset($other_travelers) && $other_travelers == 'Yes' ? ' checked' : '') . '>';

/** @var  $needs_equip */

$needs_equip = filter_input(INPUT_GET, 'filter_needs_equip', FILTER_SANITIZE_SPECIAL_CHARS);

echo '<label for="filter_needs_equip">Needs Rods:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_needs_equip" name="filter_needs_equip" value="Yes"'
     . (isset($needs_equip) && $needs_equip == 'Yes' ? ' checked' : '') . '>';

/** @var  $dietary_allergies */

$dietary_allergies = filter_input(INPUT_GET, 'filter_dietary_allergies', FILTER_SANITIZE_SPECIAL_CHARS);

echo '<label for="filter_dietary_allergies">Allergies &amp; Dietary:</label>';
echo '<input class="no-margin" type="checkbox" id="filter_dietary_allergies" name="filter_dietary_allergies" value="Yes"'
     . (isset($dietary_allergies) && $dietary_allergies == 'Yes' ? ' checked' : '') . '>';

echo '</div>';

$base_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$base_url = strtok($base_url, '?');

echo '<input class="filter-btn" type="submit" value="Filter">';
echo '<a href="'. $base_url .'" class="btn btn-danger clear-results" title="Clear results">Clear Results</a>';
echo '</form>';
echo '</div>';

/**
 * This script is setting up some search criteria
 * Initially, it's setting up that only the 'active' status is wanted in the search criteria
 */

$search_criteria['status'] = 'active';

if (isset($reservation_id) && $reservation_id != '') {
	$search_criteria['field_filters'][] = array('key' => '44', 'value' => $reservation_id); // check reservation id
}

if (isset($_GET['filter_name']) && $_GET['filter_name'] != '') {
	$search_criteria['field_filters'][] = array('key' => '1.6', 'value' => $_GET['filter_name']); // check last name
}

if (isset($_GET['filter_email']) && $_GET['filter_email'] != '') {
	$search_criteria['field_filters'][] = array('key' => '261', 'value' => $_GET['filter_email']); // check email
}

if (isset($_GET['filter_cell_phone']) && $_GET['filter_cell_phone'] != '') {
	$search_criteria['field_filters'][] = array('key' => '101', 'value' => $_GET['filter_cell_phone']); // check cell phone
}

if (isset($arrival_date) && $arrival_date != '') {
	$search_criteria['field_filters'][] = array('key' => '46', 'value' => $arrival_date); // check arrival date
}

if (isset($departure_date) && $departure_date != '') {
	$search_criteria['field_filters'][] = array('key' => '47', 'value' => $departure_date); // check departure date
}

if (isset($trip_type) && $trip_type != '') {
	$search_criteria['field_filters'][] = array('key' => '180', 'value' => $trip_type);
}

if (isset($trip_destinations) && !empty($trip_destinations)) {
	foreach ($trip_destinations as $destination) {
		$search_criteria['field_filters'][] = array('key' => '223', 'value' => $destination);
	}
}

if (isset($trip_rivers_floating_alaska) && !empty($trip_rivers_floating_alaska)) {
	foreach ($trip_rivers_floating_alaska as $float_destination) {
		$search_criteria['field_filters'][] = array('key' => '212', 'value' => $float_destination);
	}
}

if (isset($shuttle_service)) {
	$search_criteria['field_filters'][] = array('key' => '34', 'value' => 'Yes');
}

if (isset($needs_equip)) {
	$search_criteria['field_filters'][] = array('key' => '36', 'value' => 'Yes');
}

if ($other_travelers == 'Yes') {
	$search_criteria['field_filters'][] = array('key' => '21', 'operator' => 'isnot', 'value' => '');
}

if ($dietary_allergies == 'Yes') {
	$search_criteria['field_filters'][] = array('key' => '37', 'operator' => 'isnot', 'value' => '');
}

if ($tel_number == 'Yes') {
	$search_criteria['field_filters'][] = array('key' => '26', 'operator' => 'isnot', 'value' => '');
}


