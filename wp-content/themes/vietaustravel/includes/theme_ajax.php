<?php

add_action( 'wp_ajax_settings_ajax_save_password', 'settings_ajax_save_password' );
add_action( 'wp_ajax_settings_ajax_save_email', 'settings_ajax_save_email' );
add_action( 'wp_ajax_settings_ajax_save_last_name', 'settings_ajax_save_last_name' );
add_action( 'wp_ajax_settings_ajax_save_first_name', 'settings_ajax_save_first_name' );

function settings_ajax_save_password() {
	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$userId = wp_kses($_REQUEST['userId'], '');	
			$oldPassword = wp_kses($_REQUEST['oldPassword'], '');
			$password = wp_kses($_REQUEST['password'], '');
			
			$user = get_user_by( 'id', $userId );
			if ( $user && wp_check_password( $oldPassword, $user->data->user_pass, $user->ID) )
			{
				// ok
				echo wp_update_user( array ( 'ID' => $userId, 'user_pass' => $password ) ) ;
			} else {
				
			}
		}
	}
	
	// Always die in functions echoing ajax content
	die();
}

function settings_ajax_save_email() {
	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$email = wp_kses($_REQUEST['email'], '');
			$userId = wp_kses($_REQUEST['userId'], '');	
			echo wp_update_user( array ( 'ID' => $userId, 'user_email' => $email ) ) ;
		}
	}
	
	// Always die in functions echoing ajax content
	die();
}

function settings_ajax_save_last_name() {
	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$lastName = wp_kses($_REQUEST['lastName'], '');
			$userId = wp_kses($_REQUEST['userId'], '');	
			echo wp_update_user( array ( 'ID' => $userId, 'last_name' => $lastName ) ) ;
		}
	}
	
	// Always die in functions echoing ajax content
	die();
}

function settings_ajax_save_first_name() {
	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$firstName = wp_kses($_REQUEST['firstName'], '');
			$userId = wp_kses($_REQUEST['userId'], '');	
			echo wp_update_user( array ( 'ID' => $userId, 'first_name' => $firstName ) ) ;
		}
	}
	
	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_currency_symbol_ajax_request', 'currency_symbol_ajax_request' );
add_action( 'wp_ajax_nopriv_currency_symbol_ajax_request', 'currency_symbol_ajax_request' );
function currency_symbol_ajax_request() {
	if ( isset($_REQUEST) ) {
		$currency_code = wp_kses($_REQUEST['currency_code'], '');
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$currency_obj = find_currency_object($currency_code);
			if ($currency_obj)
				echo $currency_obj->currency_symbol;
			else 
				echo '';
		} else
			echo '';		
	}
	
	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_inquiry_ajax_request', 'inquiry_ajax_request' );
add_action( 'wp_ajax_nopriv_inquiry_ajax_request', 'inquiry_ajax_request' );
function inquiry_ajax_request() {
	if ( isset($_REQUEST) ) {
	
		$your_name = wp_kses($_REQUEST['your_name'], '');
		$your_email = wp_kses($_REQUEST['your_email'], '');
		$your_phone = wp_kses($_REQUEST['your_phone'], '');
		$your_message = wp_kses($_REQUEST['your_message'], '');
		$postId = wp_kses($_REQUEST['postId'], '');	
		$userId = wp_kses($_REQUEST['userId'], '');	
		
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
		
			// nonce passed ok
			$post = get_post($postId);
			
			if ($post) {
			
				$admin_email = get_bloginfo('admin_email');
				$contact_email = get_post_meta($postId, 'accommodation_contact_email', true );
				$admin_name = get_bloginfo('name');
				$headers = "From: $admin_name <$admin_email>\n";
				$subject = __('New inquiry', 'bookyourtravel');				
				$message = __("The following inquiry has just arrived: \n Name: %s \n Email: %s \n Phone: %s \n Message: %s \n Inquiring about: %s \n", 'bookyourtravel');
				$message = sprintf($message, $your_name, $your_email, $your_phone, $your_message, $post->post_title);
				wp_mail($admin_email, $subject, $message, $headers);
				wp_mail($contact_email, $subject, $message, $headers);
			
			}
			
		} 
		echo '';
	}
	
	// Always die in functions echoing ajax content
	die();

}

add_action( 'wp_ajax_review_ajax_request', 'review_ajax_request' );
add_action( 'wp_ajax_nopriv_review_ajax_request', 'review_ajax_request' );
function review_ajax_request() {

	if ( isset($_REQUEST) ) {
	
		$likes = wp_kses($_REQUEST['likes'], '');
		$dislikes = wp_kses($_REQUEST['dislikes'], '');
		$reviewedPostId = wp_kses($_REQUEST['postId'], '');	
		$userId = wp_kses($_REQUEST['userId'], '');	

		$review_cleanliness = wp_kses($_REQUEST['reviewField_review_cleanliness'], '');
		$review_comfort = wp_kses($_REQUEST['reviewField_review_comfort'], '');
		$review_location = wp_kses($_REQUEST['reviewField_review_location'], '');
		$review_staff = wp_kses($_REQUEST['reviewField_review_staff'], '');
		$review_services = wp_kses($_REQUEST['reviewField_review_services'], '');
		$review_value_for_money = wp_kses($_REQUEST['reviewField_review_value_for_money'], '');
		$review_sleep_quality = wp_kses($_REQUEST['reviewField_review_sleep_quality'], '');

		$review_cleanliness = $review_cleanliness ? intval($review_cleanliness) : 0;
		$review_comfort = $review_comfort ? intval($review_comfort) : 0;
		$review_location = $review_location ? intval($review_location) : 0;
		$review_staff = $review_staff ? intval($review_staff) : 0; 
		$review_services = $review_services ? intval($review_services) : 0;
		$review_value_for_money = $review_value_for_money ? intval($review_value_for_money) : 0;
		$review_sleep_quality = $review_sleep_quality ? intval($review_sleep_quality) : 0;
		
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
		
			// nonce passed ok
			$reviewed_post = get_post($reviewedPostId);
			$user_info = get_userdata($userId);
			
			if ($reviewed_post != null && $user_info != null ) {
			
				$review_post = array(
					'post_title'    => 'Accommodation review by ' . $user_info->user_nicename . ' [' . $userId . ']',
					'post_status'   => 'publish',
					'post_author'   => $userId,
					'post_type' 	=> 'review',
					'post_date' => date('Y-m-d H:i:s')					
				);

				// Insert the post into the database
				$review_post_id = wp_insert_post( $review_post );
				
				if( ! is_wp_error( $review_post_id ) ) {
					add_post_meta($review_post_id, 'review_likes', $likes);
					add_post_meta($review_post_id, 'review_dislikes', $dislikes);
					add_post_meta($review_post_id, 'review_post_id', $reviewedPostId);
					add_post_meta($review_post_id, 'review_cleanliness', $review_cleanliness);
					add_post_meta($review_post_id, 'review_comfort', $review_comfort);
					add_post_meta($review_post_id, 'review_location', $review_location);
					add_post_meta($review_post_id, 'review_staff', $review_staff);
					add_post_meta($review_post_id, 'review_services', $review_services);
					add_post_meta($review_post_id, 'review_value_for_money', $review_value_for_money);
					add_post_meta($review_post_id, 'review_sleep_quality', $review_sleep_quality);
					
					$review_score = get_post_meta($reviewedPostId, 'review_score', true);
					$review_sum_score = get_post_meta($reviewedPostId, 'review_sum_score', true);
					$review_count = get_post_meta($reviewedPostId, 'review_count', true);
					
					$review_score = $review_score ? $review_score : 0;
					$review_sum_score = $review_sum_score ? $review_sum_score : 0;
					$review_count = $review_count ? $review_count : 0;					
					$review_count = $review_count+1;	
					
					$new_score_sum = $review_cleanliness + $review_comfort + $review_location + $review_staff + $review_services + $review_value_for_money + $review_sleep_quality;
					$review_sum_score = $review_sum_score + $new_score_sum;
					$new_review_score = $new_score_sum / 70;
					$review_score = ($review_score + $new_review_score) / $review_count;					
					
					update_post_meta($reviewedPostId, 'review_count', $review_count);
					update_post_meta($reviewedPostId, 'review_sum_score', $review_sum_score);
					update_post_meta($reviewedPostId, 'review_score', $review_score);					
				} 
				
				echo $review_post_id;
			}
		} 
		echo '';
	}
	
	// Always die in functions echoing ajax content
	die();

}	

add_action( 'wp_ajax_review_tour_ajax_request', 'review_tour_ajax_request' );
add_action( 'wp_ajax_nopriv_review_tour_ajax_request', 'review_tour_ajax_request' );
function review_tour_ajax_request() {

	if ( isset($_REQUEST) ) {
	
		$likes = wp_kses($_REQUEST['likes'], '');
		$dislikes = wp_kses($_REQUEST['dislikes'], '');
		$reviewedPostId = wp_kses($_REQUEST['postId'], '');	
		$userId = wp_kses($_REQUEST['userId'], '');	

		$review_overall = wp_kses($_REQUEST['tourReviewField_review_overall'], '');
		$review_accommodation = wp_kses($_REQUEST['tourReviewField_review_accommodation'], '');
		$review_transport = wp_kses($_REQUEST['tourReviewField_review_transport'], '');
		$review_meals = wp_kses($_REQUEST['tourReviewField_review_meals'], '');
		$review_guide = wp_kses($_REQUEST['tourReviewField_review_guide'], '');
		$review_value_for_money = wp_kses($_REQUEST['tourReviewField_review_value_for_money'], '');
		$review_program_accuracy = wp_kses($_REQUEST['tourReviewField_review_program_accuracy'], '');

		$review_overall = $review_overall ? intval($review_overall) : 0;
		$review_accommodation = $review_accommodation ? intval($review_accommodation) : 0;
		$review_transport = $review_transport ? intval($review_transport) : 0;
		$review_meals = $review_meals ? intval($review_meals) : 0; 
		$review_guide = $review_guide ? intval($review_guide) : 0;
		$review_value_for_money = $review_value_for_money ? intval($review_value_for_money) : 0;
		$review_program_accuracy = $review_program_accuracy ? intval($review_program_accuracy) : 0;
		
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
		
			// nonce passed ok
			$reviewed_post = get_post($reviewedPostId);
			$user_info = get_userdata($userId);
			
			if ($reviewed_post != null && $user_info != null ) {
			
				$review_post = array(
					'post_title'    => 'Tour review by ' . $user_info->user_nicename . ' [' . $userId . ']',
					'post_status'   => 'publish',
					'post_author'   => $userId,
					'post_type' 	=> 'review',
					'post_date' => date('Y-m-d H:i:s')					
				);

				// Insert the post into the database
				$review_post_id = wp_insert_post( $review_post );
				
				if( ! is_wp_error( $review_post_id ) ) {
					add_post_meta($review_post_id, 'review_likes', $likes);
					add_post_meta($review_post_id, 'review_dislikes', $dislikes);
					add_post_meta($review_post_id, 'review_post_id', $reviewedPostId);
					add_post_meta($review_post_id, 'review_overall', $review_overall);
					add_post_meta($review_post_id, 'review_accommodation', $review_accommodation);
					add_post_meta($review_post_id, 'review_transport', $review_transport);
					add_post_meta($review_post_id, 'review_meals', $review_meals);
					add_post_meta($review_post_id, 'review_guide', $review_guide);
					add_post_meta($review_post_id, 'review_value_for_money', $review_value_for_money);
					add_post_meta($review_post_id, 'review_program_accuracy', $review_program_accuracy);
					
					$review_score = get_post_meta($reviewedPostId, 'review_score', true);
					$review_sum_score = get_post_meta($reviewedPostId, 'review_sum_score', true);
					$review_count = get_post_meta($reviewedPostId, 'review_count', true);
					
					$review_score = $review_score ? $review_score : 0;
					$review_sum_score = $review_sum_score ? $review_sum_score : 0;
					$review_count = $review_count ? $review_count : 0;					
					$review_count = $review_count+1;	
					
					$new_score_sum = $review_overall + $review_accommodation + $review_transport + $review_meals + $review_guide + $review_value_for_money + $review_program_accuracy;
					$review_sum_score = $review_sum_score + $new_score_sum;
					$new_review_score = $new_score_sum / 70;
					$review_score = ($review_score + $new_review_score) / $review_count;					
					
					update_post_meta($reviewedPostId, 'review_count', $review_count);
					update_post_meta($reviewedPostId, 'review_sum_score', $review_sum_score);
					update_post_meta($reviewedPostId, 'review_score', $review_score);					
				} else {
					echo var_dump($review_post_id);
				}
				
				echo $review_post_id;
			}
		} 
		echo '';
	}
	
	// Always die in functions echoing ajax content
	die();

}

add_action( 'wp_ajax_total_price_ajax_request', 'total_price_ajax_request' );
add_action( 'wp_ajax_nopriv_total_price_ajax_request', 'total_price_ajax_request' );
function total_price_ajax_request() {
	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$date_from = wp_kses($_REQUEST['date_from'], '');
			$date_to = wp_kses($_REQUEST['date_to'], '');
			$accommodation_id = wp_kses($_REQUEST['accommodation_id'], '');		

			$total_price = get_total_price($accommodation_id, $date_from, $date_to, 0, 1);
			echo $total_price;
		}
	}	
	
	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_book_car_rental_ajax_request', 'book_car_rental_ajax_request' );
add_action( 'wp_ajax_nopriv_book_car_rental_ajax_request', 'book_car_rental_ajax_request' );
function book_car_rental_ajax_request() {

	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$first_name = wp_kses($_REQUEST['first_name'], '');
			$last_name = wp_kses($_REQUEST['last_name'], '');
			$email = wp_kses($_REQUEST['email'], '');
			$phone = wp_kses($_REQUEST['phone'], '');
			$address = wp_kses($_REQUEST['address'], '');
			$town = wp_kses($_REQUEST['town'], '');
			$zip = wp_kses($_REQUEST['zip'], '');
			$country = wp_kses($_REQUEST['country'], '');
			$special_requirements = wp_kses($_REQUEST['requirements'], '');
			$date_from = wp_kses($_REQUEST['date_from'], '');
			$date_to = wp_kses($_REQUEST['date_to'], '');
			$car_rental_id = wp_kses($_REQUEST['car_rental_id'], '');		
			// nonce passed ok
			$car_rental = get_post($car_rental_id);
			
			if ($car_rental != null) {
				
				$price_per_day = intval(get_post_meta( $car_rental_id, 'car_rental_price_per_day', true ));
				$datediff =  strtotime($date_to) -  strtotime($date_from);
				$days = floor($datediff/(60*60*24));
				
				$total_price = $price_per_day * $days;
				
				$current_user = wp_get_current_user();
				
				echo create_car_rental_booking ($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $date_from, $date_to, $car_rental_id,  $current_user->ID, $total_price);
				
				$admin_email = get_bloginfo('admin_email');
				$admin_name = get_bloginfo('name');
				
				$headers = "From: $admin_name <$admin_email>\n";
				$subject = __('New car rental booking', 'bookyourtravel');
				$message = '';

				$message = __("New car rental booking: \n
				First name: %s \n
				Last name: %s \n
				Email: %s \n
				Phone: %s \n
				Address: %s \n
				Town: %s \n
				Zip: %s \n
				Country: %s \n
				Special requirements: %s \n
				Date from: %s \n
				Date to: %s \n
				Total price: %d \n
				Car: %s \n", 'bookyourtravel');	
				
				$message = sprintf($message, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $date_from, $date_to, $total_price, $car_rental->post_title);
				
				wp_mail($email, $subject, $message, $headers);
				wp_mail($admin_email, $subject, $message, $headers);
			}
		} 		
	}
	
	// Always die in functions echoing ajax content
	die();
} 

add_action( 'wp_ajax_book_ajax_request', 'book_ajax_request' );
add_action( 'wp_ajax_nopriv_book_ajax_request', 'book_ajax_request' );
function book_ajax_request() {

	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$first_name = wp_kses($_REQUEST['first_name'], '');
			$last_name = wp_kses($_REQUEST['last_name'], '');
			$email = wp_kses($_REQUEST['email'], '');
			$phone = wp_kses($_REQUEST['phone'], '');
			$address = wp_kses($_REQUEST['address'], '');
			$town = wp_kses($_REQUEST['town'], '');
			$zip = wp_kses($_REQUEST['zip'], '');
			$country = wp_kses($_REQUEST['country'], '');
			$special_requirements = wp_kses($_REQUEST['requirements'], '');
			$date_from = wp_kses($_REQUEST['date_from'], '');
			$date_to = wp_kses($_REQUEST['date_to'], '');
			$accommodation_id = wp_kses($_REQUEST['accommodation_id'], '');		
			$room_type_id = wp_kses($_REQUEST['room_type_id'], '0');		
			$room_count = wp_kses($_REQUEST['room_count'], '1');		
			// nonce passed ok
			$accommodation = get_post($accommodation_id);
			if ($room_type_id)
				$room_type = get_post($room_type_id);
			
			if ($accommodation != null) {
				
				$is_self_catered = get_post_meta( $accommodation_id, 'accommodation_is_self_catered', true );
				$current_user = wp_get_current_user();
				$total_price = get_total_price($accommodation_id, $date_from, $date_to, $room_type_id, $room_count);
				
				echo create_accommodation_booking ($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $room_count, $date_from, $date_to, $accommodation_id, $room_type_id, $current_user->ID, $is_self_catered, $total_price);

				$admin_email = get_bloginfo('admin_email');
				$admin_name = get_bloginfo('name');
				
				$headers = "From: $admin_name <$admin_email>\n";
				$subject = __('New accommodation booking', 'bookyourtravel');
				$message = '';
				if ($is_self_catered) {
					$message = __("New self-catered booking: \n
					First name: %s \n
					Last name: %s \n
					Email: %s \n
					Phone: %s \n
					Address: %s \n
					Town: %s \n
					Zip: %s \n
					Country: %s \n
					Special requirements: %s \n
					Room count: %d \n
					Date from: %s \n
					Date to: %s \n
					Total price: %d \n
					Accommodation: %s \n", 'bookyourtravel');	
					$message = sprintf($message, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $room_count, $date_from, $date_to, $total_price, $accommodation->post_title);
				} else {
					$message = __("New hotel booking: \n
					First name: %s \n
					Last name: %s \n
					Email: %s \n
					Phone: %s \n
					Address: %s \n
					Town: %s \n
					Zip: %s \n
					Country: %s \n
					Special requirements: %s \n
					Room count: %d \n
					Date from: %s \n
					Date to: %s \n
					Total price: %d \n
					Accommodation: %s \n
					Room type: %s \n", 'bookyourtravel');
					$message = sprintf($message, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $room_count, $date_from, $date_to, $total_price, $accommodation->post_title, $room_type->post_title);
				}

				wp_mail($email, $subject, $message, $headers);
				$contact_email = get_post_meta($accommodation_id, 'accommodation_contact_email', true );
				wp_mail($contact_email, $subject, $message, $headers);
			}
		} 		
	}
	
	// Always die in functions echoing ajax content
	die();
} 


add_action( 'wp_ajax_book_tour_ajax_request', 'book_tour_ajax_request' );
add_action( 'wp_ajax_nopriv_book_tour_ajax_request', 'book_tour_ajax_request' );
function book_tour_ajax_request() {

	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {
			$first_name = wp_kses($_REQUEST['first_name'], '');
			$last_name = wp_kses($_REQUEST['last_name'], '');
			$email = wp_kses($_REQUEST['email'], '');
			$phone = wp_kses($_REQUEST['phone'], '');
			$address = wp_kses($_REQUEST['address'], '');
			$town = wp_kses($_REQUEST['town'], '');
			$zip = wp_kses($_REQUEST['zip'], '');
			$country = wp_kses($_REQUEST['country'], '');
			$special_requirements = wp_kses($_REQUEST['requirements'], '');

			$tour_schedule_id = wp_kses($_REQUEST['tour_schedule_id'], '');		
		
			// nonce passed ok
			$tour_schedule = get_tour_schedule($tour_schedule_id);
			
			if ($tour_schedule != null) {
			
				$tour_id = $tour_schedule->tour_id;
				$tour = get_post($tour_id);
				
				$current_user = wp_get_current_user();
				$total_price = $tour_schedule->price;
				$start_date = date('Y-m-d', strtotime($tour_schedule->start_date));
				$tour_name = $tour->post_title;
				
				echo create_tour_booking ($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $tour_schedule_id, $current_user->ID, $total_price);
				
				$admin_email = get_bloginfo('admin_email');
				$admin_name = get_bloginfo('name');
				$headers = "From: $admin_name <$admin_email>\n";
				$subject = __('New tour booking', 'bookyourtravel');
				
				$message = __("New tour booking: \n
				First name: %s \n
				Last name: %s \n
				Email: %s \n
				Phone: %s \n
				Address: %s \n
				Town: %s \n
				Zip: %s \n
				Country: %s \n
				Special requirements: %s \n
				Tour name: %s \n
				Start date: %s \n
				Price: %d \n", 'bookyourtravel');
				$message = sprintf($message, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $tour_name, $start_date, $total_price);

				wp_mail($email, $subject, $message, $headers);
				wp_mail($admin_email, $subject, $message, $headers);
			}
		} 		
	}
	
	// Always die in functions echoing ajax content
	die();
} 

add_action( 'wp_ajax_currency_ajax_request', 'currency_ajax_request' );
add_action( 'wp_ajax_nopriv_currency_ajax_request', 'currency_ajax_request' );
function currency_ajax_request() {

	if ( isset($_REQUEST) ) {
        $nonce = $_REQUEST['nonce'];
		
        if ( wp_verify_nonce( $nonce, 'byt-ajax-nonce' ) ) {

			$amount = wp_kses($_REQUEST['amount'], '');
			$from = wp_kses($_REQUEST['from'], '');
			$to = wp_kses($_REQUEST['to'], '');
			$user_id = wp_kses($_REQUEST['userId'], '');
			
			update_user_meta($user_id, 'user_currency', $to);
			$xml = currency_conversion($amount, $from, $to);
			echo $xml;
		} 		
	}
	
	// Always die in functions echoing ajax content
	die();
}

function currency_conversion($amount, $from_currency, $to_currency) {
 
	// Call Google Currency API
	//$google_url = "http://www.google.com/ig/calculator?hl=en&q=$amount$from_currency=?$to_currency";
	$alt_url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=$from_currency&ToCurrency=$to_currency";
	$price_decimal_places = (int)of_get_option('price_decimal_places', 0);
	
	$cache_key =  'currency_conversion' . $amount . '_' . $from_currency . '_' . $to_currency;
	$conversion = get_transient( $cache_key );
			
	if (!$conversion) {
		// Retrieve and Store API results into $result
		$result = '';
		try {
			$result = file_get_contents($alt_url);
		} catch (Exception $e) {
			$result = "-1";
		}
		
		if (!empty($result) && $result != "-1") {
			$rate = (double)simplexml_load_string($result); 
			$conversion = $amount * $rate;
			$conversion = round($conversion, $price_decimal_places); // round to 2 decimal places as google returns 9 decimal places		
			
			// // Explode result string into an array
			// $resultS = $result;
			// $result = explode('"', $result);

			// $converted_amount = explode(' ', $result[3]);
			// $conversion = $converted_amount[0];
			// $conversion = preg_replace('/[\x00-\x1F\x7F]/', '', $conversion); // remove control characters 
			// $conversion = round($conversion, $price_decimal_places); // round to 2 decimal places as google returns 9 decimal places
			set_transient( $cache_key, $conversion, 60*60*12 );
		}
	}
	return $conversion;
}

?>