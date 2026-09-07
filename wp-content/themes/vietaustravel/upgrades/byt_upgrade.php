<?php

	function byt_upgrade($installed_version) {
		if ($installed_version < 1.47)
			byt_upgrade_1_41();
	
	}

	function byt_upgrade_1_41() {
	
		global $wpdb;
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$old_byt_vacancies_table_name = $wpdb->prefix . 'byt_hotel_vacancies';

		// check that the old tables actually exist
		if($wpdb->get_var("SHOW TABLES LIKE '$old_byt_vacancies_table_name'") == $old_byt_vacancies_table_name) {

			// rename sidebar in db
			$sidebars_widgets = get_option( 'sidebars_widgets', array() );
			if ( isset($sidebars_widgets['right-hotel']) ) {
				$sidebars_widgets['right-accommodation'] = $sidebars_widgets['right-hotel'];
				unset($sidebars_widgets['right-hotel']);
				update_option( 'sidebars_widgets', $sidebars_widgets );
			}
		
			// rename the old tables to new naming convention that includes accommodations
			$new_byt_vacancies_table_name = BYT_VACANCIES_TABLE;
			$sql = " ALTER TABLE $old_byt_vacancies_table_name RENAME $new_byt_vacancies_table_name;";
			$wpdb->query($sql);
			
			$old_byt_bookings_table_name = $wpdb->prefix . 'byt_hotel_bookings';
			$new_byt_bookings_table_name = BYT_BOOKINGS_TABLE;
			$sql = " ALTER TABLE $old_byt_bookings_table_name RENAME $new_byt_bookings_table_name;";
			$wpdb->query($sql);
				
			$old_byt_vacancy_bookings_table_name = $wpdb->prefix . 'byt_hotel_vacancy_bookings';
			$new_byt_vacancy_bookings_table_name = BYT_VACANCY_BOOKINGS_TABLE;
			$sql = " ALTER TABLE $old_byt_vacancy_bookings_table_name RENAME $new_byt_vacancy_bookings_table_name;";
			$wpdb->query($sql);

			$sql = "ALTER TABLE $new_byt_vacancies_table_name CHANGE hotel_id post_id bigint(20) NOT NULL; ";
			$wpdb->query($sql);	
			
			$sql = "UPDATE $wpdb->posts SET post_type='accommodation' WHERE post_type='hotel';";
			
			dbDelta($sql);
			
			$sql = "UPDATE $wpdb->postmeta SET meta_key='accommodation_location_post_id' WHERE meta_key='hotel_location_post_id';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_star_count' WHERE meta_key='hotel_star_count';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_room_types' WHERE meta_key='hotel_room_types';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_images' WHERE meta_key='hotel_images';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_address' WHERE meta_key='hotel_address';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_facility' WHERE meta_key='facility';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_accommodation_type' WHERE meta_key='hotel_accommodation_type';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_website_address' WHERE meta_key='hotel_website_address';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_contact_email' WHERE meta_key='hotel_contact_email';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_contact_email' WHERE meta_key='contact_email';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_check_in_time' WHERE meta_key='hotel_check_in_time';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_check_out_time' WHERE meta_key='hotel_check_out_time';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_cancellation_prepayment' WHERE meta_key='hotel_cancellation_prepayment';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_children_and_extra_beds' WHERE meta_key='hotel_children_and_extra_beds';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_pets' WHERE meta_key='hotel_pets';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_accepted_credit_cards' WHERE meta_key='hotel_accepted_credit_cards';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_activities' WHERE meta_key='hotel_activities';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_internet' WHERE meta_key='hotel_internet';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_parking' WHERE meta_key='hotel_parking';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_latitude' WHERE meta_key='hotel_latitude';
					UPDATE $wpdb->postmeta SET meta_key='accommodation_longitude' WHERE meta_key='hotel_longitude';
					UPDATE $wpdb->postmeta SET meta_key='review_post_id' WHERE meta_key='review_hotel_post_id';
					UPDATE $wpdb->postmeta SET meta_key='review_count' WHERE meta_key='hotel_review_count';
					UPDATE $wpdb->postmeta SET meta_key='review_score' WHERE meta_key='hotel_review_score';
					UPDATE $wpdb->postmeta SET meta_key='review_sum_score' WHERE meta_key='hotel_review_sum_score';";
					
			dbDelta($sql);
			
			$query = list_accommodations_all();
			if ( $query->have_posts() ) {
				while ($query->have_posts()) {
					global $post;
					$query->the_post();
					
					update_post_meta($post->ID, 'accommodation_is_self_catered', '0');
				}
			}
			
			wp_reset_postdata(); 
			
		}
		
	}
?>