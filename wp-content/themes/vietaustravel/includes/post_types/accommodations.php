<?php
global $wpdb;

function byt_custom_post_accommodation() {
	
	$accommodations_permalink_slug = of_get_option('accommodations_permalink_slug', 'hotels');
		
	$labels = array(
		'name'                => _x( 'Accommodations', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Accommodation', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Accommodations', 'bookyourtravel' ),
		'all_items'           => __( 'All Accommodations', 'bookyourtravel' ),
		'view_item'           => __( 'View Accommodation', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Accommodation', 'bookyourtravel' ),
		'add_new'             => __( 'New Accommodations', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Accommodations', 'bookyourtravel' ),
		'update_item'         => __( 'Update Accommodations', 'bookyourtravel' ),
		'search_items'        => __( 'Search Accommodations', 'bookyourtravel' ),
		'not_found'           => __( 'No Accommodations found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No Accommodations found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'accommodation', 'bookyourtravel' ),
		'description'         => __( 'Accommodation information pages', 'bookyourtravel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
		'taxonomies'          => array( ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
 		'rewrite' => array('slug' => $accommodations_permalink_slug),
	);
	register_post_type( 'accommodation', $args );	
}

function byt_custom_post_room_type() {
	
	$labels = array(
		'name'                => _x( 'Room types', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Room type', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Room types', 'bookyourtravel' ),
		'all_items'           => __( 'Room types', 'bookyourtravel' ),
		'view_item'           => __( 'View Room type', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Room type', 'bookyourtravel' ),
		'add_new'             => __( 'New Room type', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Room type', 'bookyourtravel' ),
		'update_item'         => __( 'Update Room type', 'bookyourtravel' ),
		'search_items'        => __( 'Search room_types', 'bookyourtravel' ),
		'not_found'           => __( 'No room types found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No room types found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'room type', 'bookyourtravel' ),
		'description'         => __( 'Room type information pages', 'bookyourtravel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
		'taxonomies'          => array( ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=accommodation',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
		'rewrite' => false,
	);
	register_post_type( 'room_type', $args );	
}

//byt_accommodation_vacancy_and_booking_tables
function byt_accommodation_extra_tables($installed_version) {

	if ($installed_version != BOOKYOURTRAVEL_VERSION) {
		global $wpdb;
		
		$table_name = BYT_VACANCIES_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					vacancy_day datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					post_id bigint(20) NOT NULL,
					room_type_id bigint(20) NOT NULL DEFAULT 0,
					room_count int NOT NULL DEFAULT 0,
					price decimal(8,2) NOT NULL,
					has_bookings tinyint(1) NOT NULL DEFAULT 0,
					PRIMARY KEY  (Id)
				);";

		// we do not execute sql directly
		// we are calling dbDelta which cant migrate database
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		$table_name = BYT_BOOKINGS_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					first_name varchar(255) NOT NULL,
					last_name varchar(255) NOT NULL,
					email varchar(255) NOT NULL,
					phone varchar(255) NULL,
					address varchar(255) NULL,
					town varchar(255) NULL,
					zip varchar(255) NULL,
					country varchar(255) NULL,
					special_requirements text NULL,
					room_count int NOT NULL DEFAULT 0,
					total_price decimal(10, 2) NOT NULL,
					user_id bigint(10) NOT NULL DEFAULT 0,
					created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		$table_name = BYT_VACANCY_BOOKINGS_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					vacancy_id bigint(20) NOT NULL,
					booking_id bigint(20) NOT NULL,
					room_count int NOT NULL DEFAULT 0,
					PRIMARY KEY  (Id)
				);";

		// we do not execute sql directly
		// we are calling dbDelta which cant migrate database
		dbDelta($sql);
				
		$table_name = BYT_CURRENCIES_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					currency_code varchar(10) NOT NULL,
					currency_label varchar(255) NOT NULL,
					currency_symbol varchar(10) NULL,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		global $EZSQL_ERROR;
		$EZSQL_ERROR = array();
		
		$wpdb->query("DROP TRIGGER IF EXISTS byt_bookings_delete_trigger;");
		$sql = "				
			CREATE TRIGGER byt_bookings_delete_trigger AFTER DELETE ON  `" . BYT_BOOKINGS_TABLE . "` 
			FOR EACH ROW BEGIN
				DELETE FROM `" . BYT_VACANCY_BOOKINGS_TABLE . "` 
				WHERE booking_id = OLD.Id;
			END;
		";		
		$wpdb->query($sql);	
		
		$wpdb->query("DROP TRIGGER IF EXISTS byt_vacancy_bookings_delete_trigger;");
		$sql = "				
			CREATE TRIGGER byt_vacancy_bookings_delete_trigger AFTER DELETE ON  `" . BYT_VACANCY_BOOKINGS_TABLE . "` 
			FOR EACH ROW BEGIN

				DECLARE bookingCount int;
				
				UPDATE `" . BYT_VACANCIES_TABLE . "` v
				SET v.room_count=v.room_count + OLD.room_count
				WHERE v.Id=OLD.vacancy_id AND v.room_type_id > 0; 
				
				SELECT COUNT(*) INTO bookingCount
				FROM `" . BYT_VACANCY_BOOKINGS_TABLE . "` bv
				WHERE bv.vacancy_id=OLD.vacancy_id;
				
				IF (bookingCount = 0) THEN
					UPDATE `" . BYT_VACANCIES_TABLE . "` v
					SET v.has_bookings=0
					WHERE v.Id=OLD.vacancy_id;
				END IF;	
			
			END;
		";		
		$wpdb->query($sql);	
		
		$wpdb->query("DROP TRIGGER IF EXISTS byt_vacancy_bookings_insert_trigger;");
		$sql = "				
			CREATE TRIGGER byt_vacancy_bookings_insert_trigger AFTER INSERT ON  `" . BYT_VACANCY_BOOKINGS_TABLE . "` 
			FOR EACH ROW BEGIN

				DECLARE roomCount int;
				
				SELECT b.room_count INTO roomCount
				FROM `" . BYT_BOOKINGS_TABLE . "` b
				WHERE b.Id = NEW.booking_id;
				
				UPDATE `" . BYT_VACANCIES_TABLE . "` v
				SET v.room_count=(v.room_count - roomCount)
				WHERE v.Id=NEW.vacancy_id AND v.room_type_id > 0;
				
				UPDATE `" . BYT_VACANCIES_TABLE . "` v
				SET v.has_bookings=1
				WHERE v.Id=NEW.vacancy_id;
			END;
		";

		$wpdb->query($sql);	

	}
}


function create_facility_taxonomies(){
	$labels = array(
			'name'              => _x( 'Facilities', 'taxonomy general name', 'bookyourtravel' ),
			'singular_name'     => _x( 'Facility', 'taxonomy singular name', 'bookyourtravel' ),
			'search_items'      => __( 'Search Facilities', 'bookyourtravel' ),
			'all_items'         => __( 'All Facilities', 'bookyourtravel' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'         => __( 'Edit Facility', 'bookyourtravel' ),
			'update_item'       => __( 'Update Facility', 'bookyourtravel' ),
			'add_new_item'      => __( 'Add New Facility', 'bookyourtravel' ),
			'new_item_name'     => __( 'New Facility Name', 'bookyourtravel' ),
			'separate_items_with_commas' => __( 'Separate facilities with commas', 'bookyourtravel' ),
			'add_or_remove_items'        => __( 'Add or remove facilities', 'bookyourtravel' ),
			'choose_from_most_used'      => __( 'Choose from the most used facilities', 'bookyourtravel' ),
			'not_found'                  => __( 'No facilities found.', 'bookyourtravel' ),
			'menu_name'         => __( 'Facilities', 'bookyourtravel' ),
		);
		
	$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite'           => array( 'slug' => 'facility' ),
		);
	
	$enable_accommodations = of_get_option('enable_accommodations', 1);

	$types_for_facility = array();
	if ($enable_accommodations) {
		$types_for_facility[] = 'accommodation';
		$types_for_facility[] = 'room_type';
	}
		
	if (count($types_for_facility) > 0)
		register_taxonomy( 'facility', $types_for_facility, $args );
}

function create_accommodation_type_taxonomies(){
	$labels = array(
			'name'              => _x( 'Accommodation types', 'taxonomy general name', 'bookyourtravel' ),
			'singular_name'     => _x( 'Accommodation type', 'taxonomy singular name', 'bookyourtravel' ),
			'search_items'      => __( 'Search Accommodation types', 'bookyourtravel' ),
			'all_items'         => __( 'All Accommodation types', 'bookyourtravel' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'         => __( 'Edit Accommodation type', 'bookyourtravel' ),
			'update_item'       => __( 'Update Accommodation type', 'bookyourtravel' ),
			'add_new_item'      => __( 'Add New Accommodation type', 'bookyourtravel' ),
			'new_item_name'     => __( 'New Accommodation type Name', 'bookyourtravel' ),
			'separate_items_with_commas' => __( 'Separate accommodation types with commas', 'bookyourtravel' ),
			'add_or_remove_items'        => __( 'Add or remove accommodation types', 'bookyourtravel' ),
			'choose_from_most_used'      => __( 'Choose from the most used accommodation types', 'bookyourtravel' ),
			'not_found'                  => __( 'No accommodation types found.', 'bookyourtravel' ),
			'menu_name'         => __( 'Accommodation types', 'bookyourtravel' ),
		);
		
	$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite'           => false,
		);
		
	register_taxonomy( 'accommodation_type', array( 'accommodation' ), $args );
}

function accommodation_columns( $columns ) {
    $columns['accommodation_location_post_id'] = 'Location';
    unset( $columns['date'] );
    return $columns;
}

function sort_accommodation_columns( $columns ) {
    $columns['accommodation_location_post_id'] = 'accommodation_location_post_id';
    return $columns;
}

$enable_accommodations = of_get_option('enable_accommodations', 1);
if ($enable_accommodations) {
	add_filter( 'manage_edit-accommodation_columns', 'accommodation_columns' );
	add_filter( 'manage_edit-accommodation_sortable_columns', 'sort_accommodation_columns' );
}

function list_accommodations_all() {

	$args = array(
	   'post_type' => 'accommodation',
	   'post_status' => 'publish',
	   'posts_per_page' => -1,
	);
	$query = new WP_Query($args);

	return $query;
}

function list_room_types_all() {

	$args = array(
	   'post_type' => 'room_type',
	   'post_status' => 'publish',
	   'posts_per_page' => -1,
	);
	$query = new WP_Query($args);

	return $query;
}
	
function list_accommodations($location_id) {

	global $wpdb;
	
	$location_args =  array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $location_id );
	$location_children = get_posts($location_args);
	$location_ids = array($location_id);
	foreach ($location_children as $location) {
		$location_ids[] = $location->ID;
	}
	$location_ids_string = implode(', ', $location_ids);

	$sql = "SELECT accommodations.*
			FROM $wpdb->posts accommodations
			INNER JOIN $wpdb->postmeta location_meta ON (accommodations.ID = location_meta.post_id) 
			WHERE accommodations.post_type = 'accommodation' AND accommodations.post_status = 'publish' AND 
			(location_meta.meta_key = 'accommodation_location_post_id' AND CAST(location_meta.meta_value AS UNSIGNED) IN ($location_ids_string))
			GROUP BY accommodations.ID ORDER BY accommodations.post_date DESC";
	
	$sql = $wpdb->prepare($sql, $location_id);
	
	return $wpdb->get_results($sql);
}

function list_paged_hotels($posts_per_page, $paged, $offset, $orderby, $order, $accommodation_type_id = 0) {

	$args = array(
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'post_type'        => 'accommodation',
		'post_status'      => 'publish',
		'posts_per_page' => $posts_per_page,
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'accommodation_is_self_catered',
				'value' => '', //<--- not required but necessary in this case
				'compare' => 'NOT EXISTS',
			),
			array(
				'key' => 'accommodation_is_self_catered',
				'value' => '1',
			    'type'    => 'CHAR',
				'compare' => '!=',
			),
		)
	);
	
	if ($accommodation_type_id > 0) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'accommodation_type',
				'field' => 'id',
				'terms' => array( $accommodation_type_id ),
				'operator' => 'IN'
			)
		);	
	}
	
	return new WP_Query($args);
}

function list_paged_self_catered($posts_per_page, $paged, $offset, $orderby, $order, $accommodation_type_id = 0) {

	$args = array(
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'post_type'        => 'accommodation',
		'post_status'      => 'publish',
		'posts_per_page' => $posts_per_page,
		'meta_query' => array(
			array(
				'key' => 'accommodation_is_self_catered',
				'value' => '1',
				'compare' => '=',
				'type'    => 'CHAR',
			)
		)
	);
	
	if ($accommodation_type_id > 0) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'accommodation_type',
				'field' => 'id',
				'terms' => array( $accommodation_type_id ),
				'operator' => 'IN'
			)
		);	
	}
	
	$query = new WP_Query($args);

	return $query;
}

function list_hotels($location_id) {

	global $wpdb;

	$location_args =  array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $location_id );
	$location_children = get_posts($location_args);
	$location_ids = array($location_id);
	foreach ($location_children as $location) {
		$location_ids[] = $location->ID;
	}
	$location_ids_string = implode(', ', $location_ids);
	
	$sql = "SELECT hotels.*
			FROM $wpdb->posts hotels
			INNER JOIN $wpdb->postmeta location_meta ON (hotels.ID = location_meta.post_id) 
			LEFT JOIN $wpdb->postmeta accommodation_type_meta ON (hotels.ID = accommodation_type_meta.post_id) 
			LEFT JOIN $wpdb->postmeta accommodation_type_meta_null ON (hotels.ID = accommodation_type_meta_null.post_id AND accommodation_type_meta_null.meta_key = 'accommodation_is_self_catered') 
			WHERE hotels.post_type = 'accommodation' AND hotels.post_status = 'publish' AND 
			(location_meta.meta_key = 'accommodation_location_post_id' AND CAST(location_meta.meta_value AS UNSIGNED) IN ($location_ids_string)) AND
			(
				(accommodation_type_meta.meta_key = 'accommodation_is_self_catered' AND CAST(accommodation_type_meta.meta_value AS CHAR) != '1')
				OR
				accommodation_type_meta_null.post_id IS NULL
			)			
			GROUP BY hotels.ID ORDER BY hotels.post_date DESC";
	
	$sql = $wpdb->prepare($sql, $location_id);
	return $wpdb->get_results($sql);
}

function list_self_catered($location_id) {

	global $wpdb;
	
	$location_args =  array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $location_id );
	$location_children = get_posts($location_args);
	$location_ids = array($location_id);
	foreach ($location_children as $location) {
		$location_ids[] = $location->ID;
	}
	$location_ids_string = implode(', ', $location_ids);
	
	$sql = "SELECT self_catered.*
			FROM $wpdb->posts self_catered
			INNER JOIN $wpdb->postmeta location_meta ON (self_catered.ID = location_meta.post_id) 
			LEFT JOIN $wpdb->postmeta accommodation_type_meta ON (self_catered.ID = accommodation_type_meta.post_id) 
			WHERE self_catered.post_type = 'accommodation' AND self_catered.post_status = 'publish' AND 
			(location_meta.meta_key = 'accommodation_location_post_id' AND CAST(location_meta.meta_value AS UNSIGNED) IN ($location_ids_string)) AND
			(accommodation_type_meta.meta_key = 'accommodation_is_self_catered' AND CAST(accommodation_type_meta.meta_value AS CHAR) = '1')
			GROUP BY self_catered.ID ORDER BY self_catered.post_date DESC";
	
	$sql = $wpdb->prepare($sql, $location_id);
	return $wpdb->get_results($sql);
}

function get_self_catered_count($location_id) {

	global $wpdb;
	
	$location_args =  array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $location_id );
	$location_children = get_posts($location_args);
	$location_ids = array($location_id);
	foreach ($location_children as $location) {
		$location_ids[] = $location->ID;
	}
	$location_ids_string = implode(', ', $location_ids);
	
	$sql = "SELECT self_catered.*
			FROM $wpdb->posts self_catered
			INNER JOIN $wpdb->postmeta location_meta ON (self_catered.ID = location_meta.post_id) 
			LEFT JOIN $wpdb->postmeta accommodation_type_meta ON (self_catered.ID = accommodation_type_meta.post_id) 
			WHERE self_catered.post_type = 'accommodation' AND self_catered.post_status = 'publish' AND 
			(location_meta.meta_key = 'accommodation_location_post_id' AND CAST(location_meta.meta_value AS UNSIGNED) IN ($location_ids_string)) AND
			(accommodation_type_meta.meta_key = 'accommodation_is_self_catered' AND CAST(accommodation_type_meta.meta_value AS CHAR) = '1')
			GROUP BY self_catered.ID ORDER BY self_catered.post_date DESC";
	
	$sql = $wpdb->prepare($sql, $location_id);
	return $wpdb->query($sql);
}

function get_total_price($accommodation_id, $date_from, $date_to, $room_type_id, $room_count) {
	
	global $wpdb;
	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);
	$vacancy_required_days = count($dates);
	
	$sql = "SELECT SUM(price) total_price	FROM (
			SELECT DISTINCT vacancy_day, MIN(price) price FROM 
				(SELECT 	DISTINCT vacancies.vacancy_day, vacancies.price,
					(SELECT COUNT(DISTINCT vacancy_day) FROM `" . BYT_VACANCIES_TABLE . "` v2 
					WHERE v2.post_id=$accommodation_id AND v2.vacancy_day ";

	if ($date_to == $date_from)
		$sql .= " = '$date_from' ";
	else
		$sql .= " BETWEEN '$date_from' AND '$date_to' ";
		
	if ($room_type_id > 0)
		$sql .= "  AND v2.room_type_id=$room_type_id AND v2.room_count >= $room_count ";
		
	$sql .= " ) vacancy_days 	
			FROM " . BYT_VACANCIES_TABLE . " vacancies
			WHERE post_id = $accommodation_id ";

	if ($room_type_id > 0)
		$sql .= "  AND room_type_id=$room_type_id AND room_count >= $room_count ";
	
	if ($date_to == $date_from)
		$sql .= " AND vacancy_day = '$date_from' ";
	else
		$sql .= " AND vacancy_day BETWEEN '$date_from' AND '$date_to' ";
	
	$sql .= " HAVING vacancy_days = $vacancy_required_days) as vacancy_days GROUP BY vacancy_day ) as prices";

	return $wpdb->get_var($sql);	
}

function list_vacancy_room_types($accommodation_id, $date_from, $date_to) {

	global $wpdb;
	
	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);
	$vacancy_required_days = count($dates);

	$sql = "SELECT DISTINCT room_type_id, SUM(room_count) room_count , min_price FROM 
				(SELECT 	DISTINCT vacancies.room_type_id, vacancies.room_count,
					(SELECT MIN(price) FROM " . BYT_VACANCIES_TABLE . " v1 WHERE v1.post_id=$accommodation_id AND v1.vacancy_day >= '$date_from' AND v1.room_count > 0 AND v1.room_type_id=vacancies.room_type_id) min_price,
					(SELECT COUNT(DISTINCT vacancy_day) FROM `" . BYT_VACANCIES_TABLE . "` v2 WHERE v2.room_type_id = vacancies.room_type_id AND v2.post_id=$accommodation_id AND v2.vacancy_day BETWEEN '$date_from' AND '$date_to' AND v2.room_count > 0) vacancy_days 	
			FROM " . BYT_VACANCIES_TABLE . " vacancies
			WHERE post_id = $accommodation_id 
			GROUP BY room_type_id
			HAVING vacancy_days = $vacancy_required_days) as room_types 
			GROUP BY room_type_id			
			HAVING room_count IS NOT NULL AND room_count > 0";

	return $wpdb->get_results($sql);			
}

function get_accommodation_count($location_id) {
	
	$args = array(
	   'post_type' => 'accommodation',
	   'meta_query' => array(
		   array(
			   'key' => 'accommodation_location_post_id',
			   'value' => $location_id,
			   'compare' => '=',
			   'type'    => 'CHAR',
		   ),
	   )
	);
	$query = new WP_Query($args);
	
	return $query->found_posts;
}



function get_accommodation_min_price($accommodation_id, $date) {

	global $wpdb;

	$sql = "SELECT MIN(price) FROM `" . BYT_VACANCIES_TABLE . "`
			WHERE post_id=%d AND vacancy_day > %s AND (room_count > 0 OR (room_count = 0 AND room_type_id=0))";
	
	return $wpdb->get_var($wpdb->prepare($sql, $accommodation_id, $date));			
	
}

function get_accommodation_min_price_by_location($location_id, $current_date) {
	$min_price = 0;
	$accommodations = list_accommodations($location_id);
	if (count($accommodations) > 0) {
		foreach ($accommodations as $accommodation) {
			$min = get_accommodation_min_price($accommodation->ID, $current_date);
			if ($min_price == 0)
				$min_price = $min;
			else if ($min < $min_price) 
				$min_price == $min;
		}
	}
	
	// Reset Second Loop Post Data
    wp_reset_postdata(); 
	return $min_price;
}

function search_accommodations($search_string, $date_from, $date_to, $paged, $posts_per_page, $sort_by_p, $sort_order_p, $stars, $price_array, $rating, $accommodation_types_array, $room_count, $is_self_catered) {

	global $wpdb;

	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);
	$vacancy_required_days = count($dates);

	$search_only_available_accommodations = of_get_option('search_only_available_accommodations', '1');
	
	$sort_order = 'ASC';
	$sort_by = 'accommodations.post_title';
	if (isset($sort_by_p)) {
		switch ($sort_by_p) {
			case '1' : $sort_by = 'min_price';break;// price
			case '2' : $sort_by = 'star_count';break;// star count
			case '3' : $sort_by = 'review_score';break;// star count
			default : $sort_by = 'min_price';break;
		}
		
		if (!$search_only_available_accommodations && $sort_by == 'min_price') 
			$sort_by = 'accommodations.post_title';
	}

	if (isset($sort_order_p)) {
		if ($sort_order_p == '2')
			$sort_order = 'DESC';
	}
	
	$sql = "";

	$select_sql_1 = "SELECT DISTINCT accommodations.* ";

	if ($search_only_available_accommodations) {
		$select_sql_1 .= ", (SELECT COUNT(DISTINCT vacancy_day) FROM `" . BYT_VACANCIES_TABLE . "` v WHERE v.post_id=accommodations.ID AND v.vacancy_day BETWEEN '$date_from' AND '$date_to' ";

		if (!$is_self_catered)
			$select_sql_1 .= " AND v.room_count >= $room_count AND room_type_id > 0 ";
		else
			$select_sql_1 .= " AND (room_type_id = 0 OR room_type_id IS NULL) ";
		
		$select_sql_1 .= " ) vacancy_days ";
	} else {
		$select_sql_1 .= ", 0 vacancy_days ";
	}
	
	$select_sql_2 = " FROM $wpdb->posts accommodations ";
	$where_sql = " WHERE accommodations.post_type='accommodation' AND accommodations.post_status='publish' ";

	$select_sql_2 .= " INNER JOIN $wpdb->postmeta accommodation_meta_location ON accommodations.ID=accommodation_meta_location.post_id AND accommodation_meta_location.meta_key='accommodation_location_post_id' ";
	
	// incorporate the location into search...
	if (!empty($search_string)) {
		$sql = $wpdb->prepare("select ID from $wpdb->posts where LOWER(post_title) LIKE '%%%s%%' AND post_type='location' AND post_status='publish'", strtolower($search_string));
		$location_ids = $wpdb->get_col($sql);
		
		$where_sql .= " AND ( ";
		
		if (count($location_ids) > 0) {
			$where_sql .= " (accommodation_meta_location.meta_value+0 IN (";
			
			foreach ($location_ids as $location_id) {
				$where_sql .= "$location_id,";
			}
			$where_sql = rtrim($where_sql, ',');
			$where_sql .= ")) ";
		} else {
			$where_sql .= ' (1!=1) '; // we haven't found any locations by user's search... so make sure search returns nothing
		}
		
		$where_sql .= sprintf(" OR (LOWER(accommodations.post_title) LIKE '%%%s%%') ", strtolower($search_string));

		$where_sql .= " ) ";
	}
	
	if (!empty($accommodation_types_array)) {	
		$accommodation_types_string = implode(",",$accommodation_types_array);		
		$select_sql_2 .= "  LEFT JOIN $wpdb->term_relationships ON (accommodations.ID = $wpdb->term_relationships.object_id)
							LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";		
		$where_sql .= " AND $wpdb->term_taxonomy.taxonomy = 'accommodation_type' AND $wpdb->term_taxonomy.term_id IN ($accommodation_types_string) ";
	}

	if ($search_only_available_accommodations) {
		$select_sql_1 .= ", ( 	
			SELECT MIN(price) price
			FROM " . BYT_VACANCIES_TABLE . " v2 
			WHERE vacancy_day >= '$date_from' AND post_id=accommodations.ID ";

		if (!$is_self_catered)
			$select_sql_1 .= "  AND room_count>=$room_count AND room_type_id > 0 ";
		else
			$select_sql_1 .= "  AND (room_type_id = 0 OR room_type_id IS NULL) ";
		$select_sql_1 .= "	) min_price	";
	} else {
		$select_sql_1 .= ",	0 min_price	";
	}
	
	$select_sql_1 .= ", ( 	
	SELECT meta_value+0 FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = 'accommodation_star_count' AND $wpdb->postmeta.post_id=accommodations.ID LIMIT 1
	) star_count
	";
	$select_sql_1 .= ", ( 	
	SELECT meta_value+0 FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = 'review_score' AND $wpdb->postmeta.post_id=accommodations.ID LIMIT 1
	) review_score
	";
	
	$having_sql = ' HAVING 1=1 ';
	if ($stars && $stars > 0 & $stars <=5) {
		$having_sql .= " AND star_count >= $stars ";
	}
	
	if ($rating && $rating > 0 & $rating <=10) {
		$having_sql .= " AND CEIL(review_score*10) >= $rating ";
	}
	
	if ($search_only_available_accommodations && !empty($price_array)) {
		$having_sql .= " AND (1!=1 ";

		$price_range_bottom = of_get_option('price_range_bottom', '0');
		$price_range_increment = of_get_option('price_range_increment', '50');
		$price_range_count = of_get_option('price_range_count', '5');
		
		$bottom = 0;
		$top = 0;
		for ($i=0; $i<$price_range_count;$i++) { 
			$bottom = ($i * $price_range_increment) + $price_range_bottom;
			$top = (($i+1) * $price_range_increment) + $price_range_bottom - 1;	

			if ($i < ($price_range_count -1)) {
				if (in_array($i+1, $price_array))
					$having_sql .= " OR (min_price >= $bottom AND min_price <= $top ) ";
			} else {
				$having_sql .= " OR (min_price >= $bottom ) ";
			}
		}
		
		$having_sql .= ")";
	}
	
	if ($search_only_available_accommodations)
		$having_sql .= " AND vacancy_days=$vacancy_required_days ";
	
	$offset = ($paged - 1)*$posts_per_page;
	$sql_end1 = " ORDER BY $sort_by $sort_order ";
	$sql_end2 = " LIMIT $offset, $posts_per_page "; 

	$select_sql = $select_sql_1 . $select_sql_2 . $where_sql . $having_sql . $sql_end1 . $sql_end2;
	$select_sql_count = $select_sql_1 . $select_sql_2 . $where_sql . $having_sql . $sql_end1;
	$results = array(
		'total' => $wpdb->query($select_sql_count),
		'results' => $wpdb->get_results($select_sql)
	);
	
	return $results;
}

function list_available_vacancy_days($accommodation_id, $day=0, $month=0, $year=0) {
	global $wpdb;

	$table_name = BYT_VACANCIES_TABLE;
	$sql = "
		SELECT DISTINCT vacancies.vacancy_day day
		FROM " . $table_name . " vacancies 
		WHERE post_id=%d AND has_bookings=0 ";
	if ($year > 0)
		$sql .= "  AND year(vacancies.vacancy_day)=$year ";
	if ($month > 0)
		$sql .= "  AND month(vacancies.vacancy_day)=$month ";
	if ($day > 0)
		$sql .= "  AND day(vacancies.vacancy_day)=$day ";
	
	$sql = $wpdb->prepare($sql, $accommodation_id);
	$results = $wpdb->get_results($sql);
	$days = array();
	foreach ($results as $result) {
		$days[] = "'" . date('Y-m-d', strtotime($result->day)) . "'";
	}
	return $days;
}

function list_accommodation_vacancies_total_items($day, $month, $year, $accommodation_id, $room_type_id) {
	global $wpdb;

	$table_name = BYT_VACANCIES_TABLE;
	$sql = "SELECT vacancies.* FROM " . $table_name . " vacancies WHERE 1=1 ";
	if ($accommodation_id > 0) {
		$sql .= " AND vacancies.post_id=$accommodation_id ";
	}
	if ($room_type_id > 0) {
		$sql .= " AND vacancies.room_type_id=$room_type_id ";
	}
	
	return $wpdb->query($sql);
}

function delete_all_accommodation_vacancies() {
	global $wpdb;
	$table_name = BYT_VACANCIES_TABLE;
	$sql = "DELETE FROM $table_name";
	$wpdb->query($sql);
}

function list_paged_accommodation_vacancies($day, $month, $year, $accommodation_id, $room_type_id, $search_term = null, $orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;
	
	$filter_date = '';
	if ($day > 0 || $month > 0 || $year) { 
		$filter_date .= ' AND ( 1=1 ';
		if ($day > 0)
			$filter_date .= $wpdb->prepare(" AND DAY(vacancy_day) = %d ", $day);			
		if ($month > 0)
			$filter_date .= $wpdb->prepare(" AND MONTH(vacancy_day) = %d ", $month);			
		if ($year > 0)
			$filter_date .= $wpdb->prepare(" AND YEAR(vacancy_day) = %d ", $year);			
		$filter_date .= ')';		
	}

	$table_name = BYT_VACANCIES_TABLE;
	$sql = "SELECT vacancies.*, accommodations.post_title accommodation_name, room_types.post_title room_type
			FROM " . $table_name . " vacancies 
			INNER JOIN $wpdb->posts accommodations ON accommodations.ID = vacancies.post_id 
			LEFT JOIN $wpdb->posts room_types ON room_types.ID = vacancies.room_type_id 
			WHERE accommodations.post_status = 'publish' AND (room_types.post_status IS NULL OR room_types.post_status = 'publish') ";
			
	if ($accommodation_id > 0) {
		$sql .= " AND vacancies.post_id=$accommodation_id ";
	}
	
	if ($room_type_id > 0) {
		$sql .= " AND vacancies.room_type_id=$room_type_id ";
	}

	if ($search_term != null && !empty($search_term)) {

	}
	
	if ($filter_date != null && !empty($filter_date)) {
		$sql .= $filter_date;
	}
	
	
	if(!empty($orderby) & !empty($order)){ 
		$sql.=' ORDER BY ' . $orderby . ' ' . $order; 
	}
	
	if(!empty($paged) && !empty($per_page)){
		$offset=($paged-1)*$per_page;
		$sql .=' LIMIT '.(int)$offset.','.(int)$per_page;
	}

	return $wpdb->get_results($sql);
}

function list_bookings_total_items() {
	global $wpdb;

	$table_name = BYT_BOOKINGS_TABLE;
	$sql = "SELECT bookings.* FROM " . $table_name . " bookings ";
	
	return $wpdb->query($sql);
}

function get_booking($booking_id) {
	global $wpdb;

	$sql = "SELECT DISTINCT bookings.*, accommodations.post_title accommodation_name, room_types.post_title room_type,
			(
				SELECT MIN(vacancy_day) FROM " . BYT_VACANCIES_TABLE . " v2 
				INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vb2 ON v2.Id = vb2.vacancy_id
				WHERE vb2.booking_id = bookings.Id 
			) min_vacancy_day,
			(
				SELECT MAX(vacancy_day) FROM " . BYT_VACANCIES_TABLE . " v3 
				INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vb3 ON v3.Id = vb3.vacancy_id
				WHERE vb3.booking_id = bookings.Id 
			) max_vacancy_day
			FROM " . BYT_BOOKINGS_TABLE . " bookings 
			INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vacancy_bookings ON vacancy_bookings.booking_id = bookings.Id
			INNER JOIN " . BYT_VACANCIES_TABLE . " vacancies ON vacancies.Id = vacancy_bookings.vacancy_id
			INNER JOIN $wpdb->posts accommodations ON accommodations.ID = vacancies.post_id 
			LEFT JOIN $wpdb->posts room_types ON room_types.ID = vacancies.room_type_id 
			WHERE accommodations.post_status = 'publish' AND (room_types.post_status IS NULL OR room_types.post_status = 'publish') 
			AND bookings.Id = $booking_id ";

	return $wpdb->get_row($sql);
}

function list_paged_bookings($search_term = null, $orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;

	$table_name = BYT_BOOKINGS_TABLE;
	$sql = "SELECT DISTINCT bookings.*, accommodations.post_title accommodation_name, room_types.post_title room_type,
			(
				SELECT MIN(vacancy_day) FROM " . BYT_VACANCIES_TABLE . " v2 
				INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vb2 ON v2.Id = vb2.vacancy_id
				WHERE vb2.booking_id = bookings.Id 
			) min_vacancy_day,
			(
				SELECT MAX(vacancy_day) FROM " . BYT_VACANCIES_TABLE . " v3 
				INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vb3 ON v3.Id = vb3.vacancy_id
				WHERE vb3.booking_id = bookings.Id 
			) max_vacancy_day,
			vacancies.has_bookings
			FROM " . $table_name . " bookings 
			INNER JOIN " . BYT_VACANCY_BOOKINGS_TABLE . " vacancy_bookings ON vacancy_bookings.booking_id = bookings.Id
			INNER JOIN " . BYT_VACANCIES_TABLE . " vacancies ON vacancies.Id = vacancy_bookings.vacancy_id
			INNER JOIN $wpdb->posts accommodations ON accommodations.ID = vacancies.post_id 
			LEFT JOIN $wpdb->posts room_types ON room_types.ID = vacancies.room_type_id 
			WHERE accommodations.post_status = 'publish' AND (room_types.post_status IS NULL OR room_types.post_status = 'publish') ";
	
	if ($search_term != null && !empty($search_term)) {
		$sql .= " WHERE 1=1 AND (bookings.first_name LIKE '%$search_term%' OR bookings.last_name LIKE '%$search_term%') ";
	}
	
	if(!empty($orderby) & !empty($order)){ 
		$sql.=' ORDER BY '.$orderby.' '.$order; 
	}
	
	if(!empty($paged) && !empty($per_page)){
		$offset=($paged-1)*$per_page;
		$sql .=' LIMIT '.(int)$offset.','.(int)$per_page;
	}
	
	return $wpdb->get_results($sql);
}

function create_accommodation_booking($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $room_count, $date_from, $date_to, $accommodation_id, $room_type_id, $user_id, $is_self_catered, $total_price) {
	global $wpdb;
	
	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);
	$vacancy_ids = array();

	foreach ($dates as $date) {
		$sql = "SELECT v.Id
				FROM " . BYT_VACANCIES_TABLE . " v
				WHERE v.post_id=%d ";

		if ($room_type_id > 0) 
			$sql .= $wpdb->prepare(" AND v.room_type_id=%d AND v.room_count>=%d ", $room_type_id, $room_count);
			
		$sql .= " AND v.vacancy_day=%s 
				AND v.price = (SELECT Min(price) FROM " . BYT_VACANCIES_TABLE . " v2 WHERE v2.post_id=v.post_id ";

		if ($room_type_id > 0) 
			$sql .= $wpdb->prepare(" AND v2.room_type_id=v.room_type_id AND v2.room_count>=%d ", $room_count);

		$sql .= " AND v2.vacancy_day=v.vacancy_day) LIMIT 1";

		$sql = $wpdb->prepare($sql, $accommodation_id, $date);

		$vacancy_id = $wpdb->get_var($sql);

		if ($vacancy_id)
			$vacancy_ids[] = $vacancy_id;
	}
	
	if (count($dates) === count($vacancy_ids)) {
	
		$sql = "INSERT INTO " . BYT_BOOKINGS_TABLE . "
				(first_name, last_name, email, phone, address, town, zip, country, special_requirements, room_count, user_id, total_price)
				VALUES 
				(%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d);";
		$wpdb->query($wpdb->prepare($sql, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $room_count, $user_id, $total_price));
		$booking_id = $wpdb->insert_id;
		
		$errors = array();
		foreach ($vacancy_ids as $vacancy_id) {
			$sql = "INSERT INTO " . BYT_VACANCY_BOOKINGS_TABLE . "
					(booking_id, vacancy_id, room_count)
					VALUES
					(%d, %d, %d);";
			$result = $wpdb->query($wpdb->prepare($sql, $booking_id, $vacancy_id, $room_count));
			if (is_wp_error($result))
				$errors[] = $result;
		}
		
		if (count($errors) > 0)
			return $errors;
		return 1;
	}
	
	return 0;
}

?>