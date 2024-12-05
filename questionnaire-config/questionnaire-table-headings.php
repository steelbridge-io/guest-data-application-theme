<?php


              $gda_meta_value = get_post_meta($post->ID, '_gda_meta_key', true);

              if (!empty($gda_meta_value)) {
              // Table header Name
              $default_name_value = 'Name';
              $gda_meta_value_th = get_post_meta($post->ID, '_gda_meta_key_table_header_title', true);
              // Use default values if the meta values are empty
              $gda_meta_value_th = !empty($gda_meta_value_th) ? $gda_meta_value_th : $default_name_value;
              // Table Name
              if (!empty($gda_meta_value_th)) {
                echo '<th class="fixed-column">' . $gda_meta_value_th . '</th>';
              }


						// Table header reservation
						$default_reservation_value = 'Reservation';
						$gda_header_title_reservation = get_post_meta($post->ID, '_gda_meta_key_header_title_res',true);
						// Use default values if the meta values are empty
						$gda_header_title_reservation = !empty($gda_header_title_reservation) ? $gda_header_title_reservation : $default_reservation_value;
						// Table Name
						if (!empty($gda_header_title_reservation)) {
							echo '<th>' . $gda_header_title_reservation . '</th>';
						}

						// Table header date of arrival
						$default_date_of_arrival_value = 'Date of arrival';
						$gda_header_title_date_of_arrival = get_post_meta($post->ID, '_gda_meta_key_header_date_of_arrival',true);
						// Use default values if the meta values are empty
						$gda_header_title_date_of_arrival = !empty($gda_header_title_date_of_arrival) ? $gda_header_title_date_of_arrival : $default_date_of_arrival_value;
						// Table Name
						if (!empty($gda_header_title_date_of_arrival)) {
							echo '<th>' . $gda_header_title_date_of_arrival . '</th>';
						}

						// Table header date of departure
						$default_date_of_departure_value = 'Date of departure';
						$gda_header_title_date_of_departure = get_post_meta($post->ID, '_gda_meta_key_header_date_of_departure',true);
						// Use default values if the meta values are empty
						$gda_header_title_date_of_departure = !empty($gda_header_title_date_of_departure) ? $gda_header_title_date_of_departure : $default_date_of_departure_value;
						// Table Name
						if (!empty($gda_header_title_date_of_departure)) {
							echo '<th>' . $gda_header_title_date_of_departure . '</th>';
						}

						// Table header cell phone
						$default_cell_phone_value = 'Cell phone';
						$gda_header_title_cell_phone = get_post_meta($post->ID, '_gda_meta_key_header_cell_phone',true);
						// Use default values if the meta values are empty
						$gda_header_title_cell_phone = !empty($gda_header_title_cell_phone) ? $gda_header_title_cell_phone : $default_cell_phone_value;
						// Table Name
						if (!empty($gda_header_title_cell_phone)) {
							echo '<th>' . $gda_header_title_cell_phone . '</th>';
						}

            // Table header date of birth
            $default_date_of_birth_value = 'Date of birth';
            $gda_header_title_date_of_birth = get_post_meta($post->ID, '_gda_meta_key_header_date_of_birth',true);
            // Use default values if the meta values are empty
            $gda_header_title_date_of_birth = !empty($gda_header_title_date_of_birth) ? $gda_header_title_date_of_birth : $default_date_of_birth_value;
            // Table Name
            if (!empty($gda_header_title_date_of_birth)) {
              echo '<th>' . $gda_header_title_date_of_birth . '</th>';
            }

            // Table header body weight
            $default_body_weight_value = 'Body weight';
            $gda_header_title_body_weight = get_post_meta($post->ID, '_gda_meta_key_header_body_weight',true);
            // Use default values if the meta values are empty
            $gda_header_title_body_weight = !empty($gda_header_title_body_weight) ? $gda_header_title_body_weight : $default_body_weight_value;
            // Table Name
            if (!empty($gda_header_title_body_weight)) {
              echo '<th>' . $gda_header_title_body_weight . '</th>';
            }

            // Table header emergency contact
            $default_emergency_contact_value = 'Emergency contact';
            $gda_header_title_emergency_contact = get_post_meta($post->ID, '_gda_meta_key_header_emergency_contact',true);
            // Use default values if the meta values are empty
            $gda_header_title_emergency_contact = !empty($gda_header_title_emergency_contact) ? $gda_header_title_emergency_contact : $default_emergency_contact_value;
            // Table Name
            if (!empty($gda_header_title_emergency_contact)) {
              echo '<th>' . $gda_header_title_emergency_contact . '</th>';
            }

            // Table header emergency contact relationship
            $default_relationship_to_traveler_value = 'Relationship to traveler';
            $gda_header_title_relationship_to_traveler = get_post_meta($post->ID, '_gda_meta_key_header_relationship_to_traveler',true);
            // Use default values if the meta values are empty
            $gda_header_title_relationship_to_traveler = !empty($gda_header_title_relationship_to_traveler) ? $gda_header_title_relationship_to_traveler : $default_relationship_to_traveler_value;
            // Table Name
            if (!empty($gda_header_title_relationship_to_traveler)) {
              echo '<th>' . $gda_header_title_relationship_to_traveler . '</th>';
            }

            // Table header emergency contact telephone number
            $default_ec_tel_number_value = 'Emergency contact tel number';
            $gda_header_title_ec_tel_number = get_post_meta($post->ID, '_gda_meta_key_header_ec_tel_number',true);
            // Use default values if the meta values are empty
            $gda_header_title_ec_tel_number = !empty($gda_header_title_ec_tel_number) ? $gda_header_title_ec_tel_number : $default_ec_tel_number_value;
            // Emergency contact telephone number
            if (!empty($gda_header_title_ec_tel_number)) {
              echo '<th>' . $gda_header_title_ec_tel_number . '</th>';
            }

            // Table header did you purchase cancellation insurance?
            $default_purchase_cancellation_ins_value = 'Did you purchase cancellation insurrance?';
            $gda_header_title_purchase_cancellation_ins = get_post_meta($post->ID, '_gda_meta_key_header_purchase_cancellation_ins',true);
            // Use default values if the meta values are empty
            $gda_header_title_purchase_cancellation_ins = !empty($gda_header_title_purchase_cancellation_ins) ? $gda_header_title_purchase_cancellation_ins : $default_purchase_cancellation_ins_value;
            // Did you purchase cancellation insurance
            if (!empty($gda_header_title_purchase_cancellation_ins)) {
              echo '<th>' . $gda_header_title_purchase_cancellation_ins . '</th>';
            }

            // Table header Travel insurance company name
            $default_ins_co_name_value = 'Travel insurance company name';
            $gda_header_title_ins_co_name = get_post_meta($post->ID, '_gda_meta_key_header_ins_co_name',true);
            // Use default values if the meta values are empty
            $gda_header_title_ins_co_name = !empty($gda_header_title_ins_co_name) ? $gda_header_title_ins_co_name : $default_ins_co_name_value;
            // Travel insurance company name
            if (!empty($gda_header_title_ins_co_name)) {
              echo '<th>' . $gda_header_title_ins_co_name . '</th>';
            }

            // Table header Travel insurance policy number
            $default_ins_co_policy_number_value = 'Travel insurance policy number';
            $gda_header_title_ins_co_policy_number = get_post_meta($post->ID, '_gda_meta_key_header_ins_co_policy_number',true);
            // Use default values if the meta values are empty
            $gda_header_title_ins_co_policy_number = !empty($gda_header_title_ins_co_policy_number) ? $gda_header_title_ins_co_policy_number : $default_ins_co_policy_number_value;
            // Travel insurance policy number
            if (!empty($gda_header_title_ins_co_policy_number)) {
              echo '<th>' . $gda_header_title_ins_co_policy_number . '</th>';
            }
						
	          // Table header Travel insurance policy number
	          $default_what_float_doing_value = 'What float are you doing?';
	          $gda_header_title_what_float_doing = get_post_meta( $post->ID,
	            '_gda_meta_key_header_what_float_doing',
	            TRUE );
	          // Use default values if the meta values are empty
	          $gda_header_title_what_float_doing = !empty( $gda_header_title_what_float_doing )
	            ? $gda_header_title_what_float_doing : $default_what_float_doing_value;
	          // Travel insurance policy number
	          if ( !empty( $gda_header_title_what_float_doing ) ) {
	            echo '<th>' . esc_html( $gda_header_title_what_float_doing ) . '</th>';
	          }
						
            // Table header Travel insurance policy number
            $default_arrival_airport_value = 'Arrival airport city/town';
            $gda_header_title_arrival_airport = get_post_meta($post->ID, '_gda_meta_key_header_arrival_airport', true);
            // Use default values if the meta values are empty
            $gda_header_title_arrival_airport = !empty($gda_header_title_arrival_airport) ? $gda_header_title_arrival_airport : $default_arrival_airport_value;
            // Travel insurance policy number
            if (!empty($gda_header_title_arrival_airport)) {
              echo '<th>' . $gda_header_title_arrival_airport . '</th>';
            }


								

              // Table header Travel insurance policy number
              $default_arrival_airline_value = 'Arrival airline';
              $gda_header_title_arrival_airline = get_post_meta($post->ID, '_gda_meta_key_header_arrival_airline', true);
              // Use default values if the meta values are empty
              $gda_header_title_arrival_airline = !empty($gda_header_title_arrival_airline) ? $gda_header_title_arrival_airline : $default_arrival_airline_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_arrival_airline)) {
                echo '<th>' . $gda_header_title_arrival_airline . '</th>';
              }



              // Table header Travel insurance policy number
                /*
              $default_other_arrival_airline_value = 'Arrival airline (other)';
              $gda_header_title_other_arrival_airline = get_post_meta($post->ID, '_gda_meta_key_header_other_arrival_airline', true);
              // Use default values if the meta values are empty
              $gda_header_title_other_arrival_airline = !empty($gda_header_title_other_arrival_airline) ? $gda_header_title_other_arrival_airline : $default_other_arrival_airline_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_other_arrival_airline)) {
                echo '<th>' . $gda_header_title_other_arrival_airline . '</th>';
              } */

                global $wpdb;

                // Form ID and Field ID to check
                $form_id = 96; // Adjust this to your actual form ID
                $field_id = 50;

                // Table names
                $entry_table = $wpdb->prefix . 'gf_entry';
                $entry_meta_table = $wpdb->prefix . 'gf_entry_meta';

                // Query to check if any entries for the form have the specific field data not empty
                $has_field_data = $wpdb->get_var($wpdb->prepare(
                  "
                  SELECT count(meta.entry_id)
                  FROM $entry_meta_table as meta
                  INNER JOIN $entry_table as entry ON entry.id = meta.entry_id
                  WHERE entry.form_id = %d AND meta.meta_key = %s AND meta.meta_value != ''
                  ",
                  $form_id,
                  $field_id
                ));

                if ($has_field_data > 0) {
                  // If there is field data, execute the original code

                  // Table header Travel insurance policy number
                  $default_other_arrival_airline_value = 'Arrival airline (other)';
                  $gda_header_title_other_arrival_airline = get_post_meta($post->ID, '_gda_meta_key_header_other_arrival_airline', true);

                  // Use default values if the meta values are empty
                  $gda_header_title_other_arrival_airline = !empty($gda_header_title_other_arrival_airline) ? $gda_header_title_other_arrival_airline : $default_other_arrival_airline_value;

                  // Travel insurance policy number
                  if (!empty($gda_header_title_other_arrival_airline)) {
                    echo '<th>' . $gda_header_title_other_arrival_airline . '</th>';
                  }
                } else {
                  echo 'No data found for form ID ' . $form_id . ' and field ID ' . $field_id;
                }




              // Table header Travel insurance policy number
              $default_flight_arrival_date_value = 'Flight arrival date';
              $gda_header_title_flight_arrival_date = get_post_meta($post->ID, '_gda_meta_key_header_flight_arrival_date', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_arrival_date = !empty($gda_header_title_flight_arrival_date) ? $gda_header_title_flight_arrival_date : $default_flight_arrival_date_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_arrival_date)) {
                echo '<th>' . $gda_header_title_flight_arrival_date . '</th>';
              }

              // Table header Travel insurance policy number
              $default_flight_arrival_number_value = 'Flight arrival number';
              $gda_header_title_flight_arrival_number = get_post_meta($post->ID, '_gda_meta_key_header_flight_arrival_number', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_arrival_number = !empty($gda_header_title_flight_arrival_number) ? $gda_header_title_flight_arrival_number : $default_flight_arrival_number_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_arrival_number)) {
                echo '<th>' . $gda_header_title_flight_arrival_number . '</th>';
              }

              // Table header Travel insurance policy number
              $default_flight_arrival_time_value = 'Flight arrival time';
              $gda_header_title_flight_arrival_time = get_post_meta($post->ID, '_gda_meta_key_header_flight_arrival_time', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_arrival_time = !empty($gda_header_title_flight_arrival_time) ? $gda_header_title_flight_arrival_time : $default_flight_arrival_time_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_arrival_time)) {
                echo '<th>' . $gda_header_title_flight_arrival_time . '</th>';
              }

              // Table header Travel insurance policy number
              $default_flight_departure_date_value = 'Flight departure date';
              $gda_header_title_flight_departure_date = get_post_meta($post->ID, '_gda_meta_key_header_flight_departure_date', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_departure_date = !empty($gda_header_title_flight_departure_date) ? $gda_header_title_flight_departure_date : $default_flight_departure_date_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_departure_date)) {
                echo '<th>' . $gda_header_title_flight_departure_date . '</th>';
              }

              // Table header Travel insurance policy number
              $default_flight_departure_number_value = 'Flight departure number';
              $gda_header_title_flight_departure_number = get_post_meta($post->ID, '_gda_meta_key_header_flight_departure_number', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_departure_number = !empty($gda_header_title_flight_departure_number) ? $gda_header_title_flight_departure_number : $default_flight_departure_number_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_departure_number)) {
                echo '<th>' . $gda_header_title_flight_departure_number . '</th>';
              }

              // Table header Travel insurance policy number
              $default_flight_departure_time_value = 'Flight departure time';
              $gda_header_title_flight_departure_time = get_post_meta($post->ID, '_gda_meta_key_header_flight_departure_time', true);
              // Use default values if the meta values are empty
              $gda_header_title_flight_departure_time = !empty($gda_header_title_flight_departure_time) ? $gda_header_title_flight_departure_time : $default_flight_departure_time_value;
              // Travel insurance policy number
              if (!empty($gda_header_title_flight_departure_time)) {
                echo '<th>' . $gda_header_title_flight_departure_time . '</th>';
              }

						
						
						

				/*echo   '
					
                <th>Departure airline</th>
                <th>Other departure airline</th>
                <th>Departure flight &#35;</th>
                <th>Scheduled departure time</th>
                <th>Name(s) of others traveling with you</th>
                <th>Hotel you will be staying in at your final destination?</th>
                <th>Other hotel</th>
                <th>Hotel address</th>
                <th>Rent rods/reels?</th>
                <th>What hand reel with?</th>
                <th>Fish species to target</th>
                <th>How would you rate your fishing skills?</th>
                <th>Rate boat/rafting experience</th>
                <th>Characterize wading ability</th>
                <th>Characterize your physical fitness level</th>
                <th>Allergies (Food and environmental)</th>
                <th>Allergies (Other)</th>
                <th>Diet aversions/dislikes</th>
                <th>Please list any Special Requests...</th>
                <th>Do you need a sleeping bag?</th>
                <th>Rooming\roommate requests</th>
                <th>Will you be celebrating a special occasion while on the float?</th>
                <th>Please tell us about your event or celebration</th>
                <th>What are you most looking forward to during your stay?</th>';*/
                }


