echo '<div id="filter-cont" class="container filter-wrap">';
  echo '<form method="GET">';
    echo '<div class="row">';

      /** @var  $reservation_id */
      $reservation_id = filter_input(INPUT_GET, 'filter_reservation_id', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_reservation_id">Reservation &#35;:</label>';
        echo '<input type="text" id="filter_reservation_id" name="filter_reservation_id" value="'
  . (isset($reservation_id) ? $reservation_id : '')
  . '">';
        echo '</div>';

      /** @var  $name */
      $name = filter_input(INPUT_GET, 'filter_name', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_name">Last Name:</label>';
        echo '<input type="text" id="filter_name" name="filter_name" value="'
  . (isset($name) ? $name : '')
  . '">';
        echo '</div>';

      /** @var  $email */
      $email = filter_input(INPUT_GET, 'filter_email', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_email">Email:</label>';
        echo '<input type="text" id="filter_email" name="filter_email" value="'
  . (isset($email) ? $email : '')
  . '">';
        echo '</div>';

      /** @var  $cell_phone */
      $cell_phone = filter_input(INPUT_GET, 'filter_cell_phone', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_cell_phone">Cell Phone:</label>';
        echo '<input type="tel" id="filter_cell_phone" name="filter_cell_phone" value="'
  . (isset($cell_phone) ? $cell_phone : '')
  . '">';
        echo '</div>';

      /** @var  $arrival_date */
      $arrival_date = filter_input(INPUT_GET, 'filter_arrival_date', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_arrival_date">Arrival Date:</label>';
        echo '<input type="date" id="filter_arrival_date" name="filter_arrival_date" value="'
  . (isset($arrival_date) ? $arrival_date : '')
  . '">';
        echo '</div>';

      /** @var  $departure_date */
      $departure_date = filter_input(INPUT_GET, 'filter_departure_date', FILTER_SANITIZE_SPECIAL_CHARS);
      echo '<div class="well col-md-4">';
        echo '<label for="filter_departure_date">Departure Date:</label>';
        echo '<input type="date" id="filter_departure_date" name="filter_departure_date" value="'
  . (isset($departure_date) ? $departure_date : '')
  . '">';
        echo '</div>';

      echo '</div>'; // </row>

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
  echo '</div>';<?php
