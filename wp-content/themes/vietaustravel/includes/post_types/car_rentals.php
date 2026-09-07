<?php
global $wpdb;

function byt_custom_post_car_rental() {
	
	$labels = array(
		'name'                => _x( 'Car rentals', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Car rental', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Car rentals', 'bookyourtravel' ),
		'all_items'           => __( 'All Car rentals', 'bookyourtravel' ),
		'view_item'           => __( 'View Car rental', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Car rental', 'bookyourtravel' ),
		'add_new'             => __( 'New Car rentals', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Car rentals', 'bookyourtravel' ),
		'update_item'         => __( 'Update Car rentals', 'bookyourtravel' ),
		'search_items'        => __( 'Search Car rentals', 'bookyourtravel' ),
		'not_found'           => __( 'No Car rentals found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No Car rentals found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'car rental', 'bookyourtravel' ),
		'description'         => __( 'Car rental information pages', 'bookyourtravel' ),
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
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
 		'rewrite' => false,
	);
	register_post_type( 'car_rental', $args );	

}

function create_car_type_taxonomies(){
	$labels = array(
			'name'              => _x( 'Car types', 'taxonomy general name', 'bookyourtravel' ),
			'singular_name'     => _x( 'Car type', 'taxonomy singular name', 'bookyourtravel' ),
			'search_items'      => __( 'Search Car types', 'bookyourtravel' ),
			'all_items'         => __( 'All Car types', 'bookyourtravel' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'         => __( 'Edit Car type', 'bookyourtravel' ),
			'update_item'       => __( 'Update Car type', 'bookyourtravel' ),
			'add_new_item'      => __( 'Add New Car type', 'bookyourtravel' ),
			'new_item_name'     => __( 'New Car type Name', 'bookyourtravel' ),
			'separate_items_with_commas' => __( 'Separate car types with commas', 'bookyourtravel' ),
			'add_or_remove_items'        => __( 'Add or remove car types', 'bookyourtravel' ),
			'choose_from_most_used'      => __( 'Choose from the most used car types', 'bookyourtravel' ),
			'not_found'                  => __( 'No car types found.', 'bookyourtravel' ),
			'menu_name'         => __( 'Car types', 'bookyourtravel' ),
		);
		
	$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => false,
			'update_count_callback' => '_update_post_term_count',
			'rewrite'           => false,
		);
	
	$enable_car_rentals = of_get_option('enable_car_rentals', 1);

	if ($enable_car_rentals) {
		register_taxonomy( 'car_type', 'car_rental', $args );
	}
}

function byt_car_rental_extra_tables($installed_version) {

	if ($installed_version != BOOKYOURTRAVEL_VERSION) {
		global $wpdb;
		
		// we do not execute sql directly
		// we are calling dbDelta which cant migrate database
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');		
		
		$table_name = BYT_CAR_RENTAL_BOOKINGS_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					car_rental_id bigint(20) NOT NULL,
					first_name varchar(255) NOT NULL,
					last_name varchar(255) NOT NULL,
					email varchar(255) NOT NULL,
					phone varchar(255) NULL,
					address varchar(255) NULL,
					town varchar(255) NULL,
					zip varchar(255) NULL,
					country varchar(255) NULL,
					special_requirements text NULL,
					total_price decimal(10, 2) NOT NULL,
					user_id bigint(10) NOT NULL DEFAULT 0,
					created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		$table_name = BYT_CAR_RENTAL_BOOKING_DAYS_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					car_rental_booking_id bigint(20) NOT NULL,
					booking_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  (Id)
				);";
		
		dbDelta($sql);
		global $EZSQL_ERROR;
		$EZSQL_ERROR = array();
				
		$wpdb->query("DROP TRIGGER IF EXISTS byt_car_rental_bookings_delete_trigger;");
		$sql = "				
			CREATE TRIGGER byt_car_rental_bookings_delete_trigger AFTER DELETE ON `" . BYT_CAR_RENTAL_BOOKINGS_TABLE . "` 
			FOR EACH ROW BEGIN
				DELETE FROM `" . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . "` 
				WHERE car_rental_booking_id = OLD.Id;
			END;
		";		
		$wpdb->query($sql);	
		
	}
}

function car_rental_columns($columns) {
    $columns['car_rental_location_post_id'] = 'Pick Up Location';
    $columns['car_rental_location_post_id_2'] = 'Drop-Off Location';
    unset( $columns['date'] );
    return $columns;
}

function sort_car_rental_columns( $columns ) {
    $columns['car_rental_location_post_id'] = 'car_rental_location_post_id';
    $columns['car_rental_location_post_id_2'] = 'car_rental_location_post_id_2';
    return $columns;
}

$enable_car_rentals = of_get_option('enable_car_rentals', 1);
if ($enable_car_rentals) {
	add_filter( 'manage_edit-car_rental_columns', 'car_rental_columns' );
	add_filter( 'manage_edit-car_rental_sortable_columns', 'sort_car_rental_columns' );
}

function list_paged_car_rentals($posts_per_page, $paged, $offset, $orderby, $order, $car_type_id = 0) {

	$args = array(
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'post_type'        => 'car_rental',
		'post_status'      => 'publish',
		'posts_per_page' => $posts_per_page,
	);
		
	if ($car_type_id > 0) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'car_type',
				'field' => 'id',
				'terms' => array( $car_type_id ),
				'operator' => 'IN'
			)
		);	
	}
	
	return new WP_Query($args);
}

function create_car_rental_booking ($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $date_from, $date_to, $car_rental_id,  $user_id, $total_price) {
	global $wpdb;
	
	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);
	
	$sql = "INSERT INTO " . BYT_CAR_RENTAL_BOOKINGS_TABLE . "
			(first_name, last_name, email, phone, address, town, zip, country, special_requirements, car_rental_id, user_id, total_price)
			VALUES 
			(%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d);";
			
	$wpdb->query($wpdb->prepare($sql, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $car_rental_id, $user_id, $total_price));

	$booking_id = $wpdb->insert_id;
	
	$errors = array();
	foreach ($dates as $date) {
		$sql = "INSERT INTO " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . "
				(car_rental_booking_id, booking_date)
				VALUES
				(%d, %s);";
		$result = $wpdb->query($wpdb->prepare($sql, $booking_id, $date));
		if (is_wp_error($result))
			$errors[] = $result;
	}
	
	if (count($errors) > 0)
		return $errors;
	return 1;	
}

function search_car_rentals($search_string, $search_string_2, $date_from, $date_to, $paged, $posts_per_page, $sort_by, $sort_order, $price_array, $car_types_array, $age) {

	global $wpdb;
	
	// we are actually (in terms of db data) looking for date 1 day before the to date
	// e.g. when you look to book a room from 19.12. to 20.12 you will be staying 1 night, not 2
	$date_to = date('Y-m-d', strtotime($date_to.' -1 day'));
	
	$dates = get_dates_from_range($date_from, $date_to);

	$sort_order = 'ASC';
	$sort_by = 'car_rentals.post_title';
	if (isset($sort_by_p)) {
		switch ($sort_by_p) {
			case '1' : $sort_by = 'min_price';break;// price
			default : $sort_by = 'min_price';break;
		}
	}

	if (isset($sort_order_p)) {
		if ($sort_order_p == '2')
			$sort_order = 'DESC';
	}
	
	$sql = "";

	$select_sql_1 = "SELECT DISTINCT car_rentals.*, car_rentals_meta_price.meta_value price, car_rentals_meta_min_age.meta_value min_age,
	(
		SELECT COUNT(DISTINCT car_rental_booking_id) cnt
		FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " booking_days_table 
		INNER JOIN " . BYT_CAR_RENTAL_BOOKINGS_TABLE . " booking_table ON booking_days_table.car_rental_booking_id = booking_table.Id 
		WHERE booking_table.car_rental_id = car_rentals.ID AND booking_days_table.booking_date BETWEEN $date_from AND $date_to
	) bookings, (car_rentals_meta_number_of_cars.meta_value+0) number_of_cars
	";
	
	$select_sql_2 = " FROM $wpdb->posts car_rentals ";
	$where_sql = " WHERE car_rentals.post_type='car_rental' AND car_rentals.post_status='publish' ";

	$select_sql_2 .= " INNER JOIN $wpdb->postmeta car_rentals_meta_number_of_cars ON car_rentals.ID=car_rentals_meta_number_of_cars.post_id AND car_rentals_meta_number_of_cars.meta_key='car_rental_number_of_cars' ";
	$select_sql_2 .= " LEFT JOIN $wpdb->postmeta car_rentals_meta_location ON car_rentals.ID=car_rentals_meta_location.post_id AND car_rentals_meta_location.meta_key='car_rental_location_post_id' ";
	$select_sql_2 .= " LEFT JOIN $wpdb->postmeta car_rentals_meta_location_2 ON car_rentals.ID=car_rentals_meta_location_2.post_id AND car_rentals_meta_location_2.meta_key='car_rental_location_post_id_2' ";
	$select_sql_2 .= " LEFT JOIN $wpdb->postmeta car_rentals_meta_min_age ON car_rentals.ID=car_rentals_meta_min_age.post_id AND car_rentals_meta_min_age.meta_key='car_rental_min_age' ";
	$select_sql_2 .= " LEFT JOIN $wpdb->postmeta car_rentals_meta_price ON car_rentals.ID=car_rentals_meta_price.post_id AND car_rentals_meta_price.meta_key='car_rental_price_per_day' ";

	
	// incorporate the location 1 into search...
	if (!empty($search_string)) {
		$sql = $wpdb->prepare("select ID from $wpdb->posts where LOWER(post_title) LIKE '%%%s%%' AND post_type='location' AND post_status='publish'", strtolower($search_string));
		$location_ids = $wpdb->get_col($sql);
		
		$where_sql .= " AND ( ";
		
		if (count($location_ids) > 0) {
			$where_sql .= " (car_rentals_meta_location.meta_value+0 IN (";
			
			foreach ($location_ids as $location_id) {
				$where_sql .= "$location_id,";
			}
			$where_sql = rtrim($where_sql, ',');
			$where_sql .= ")) ";
		} else {
			$where_sql .= ' (1!=1) '; // we haven't found any locations by user's search... so make sure search returns nothing
		}
		
		$where_sql .= sprintf(" OR (LOWER(car_rentals.post_title) LIKE '%%%s%%') ", strtolower($search_string));

		$where_sql .= " ) ";
	}

	// incorporate the location 2 into search...
	if (!empty($search_string_2)) {
		$sql = $wpdb->prepare("select ID from $wpdb->posts where LOWER(post_title) LIKE '%%%s%%' AND post_type='location' AND post_status='publish'", strtolower($search_string));
		$location_ids = $wpdb->get_col($sql);
		
		$where_sql .= " AND ( ";
		
		if (count($location_ids) > 0) {
			$where_sql .= " (car_rentals_meta_location_2.meta_value+0 IN (";
			
			foreach ($location_ids as $location_id) {
				$where_sql .= "$location_id,";
			}
			$where_sql = rtrim($where_sql, ',');
			$where_sql .= ")) ";
		} else {
			$where_sql .= ' (1!=1) '; // we haven't found any locations by user's search... so make sure search returns nothing
		}
		
		$where_sql .= " ) ";
	}
	
	if (!empty($car_types_array) && count($car_types_array) > 0) {	
		$car_types_string = implode(",",$car_types_array);		
		$select_sql_2 .= "  LEFT JOIN $wpdb->term_relationships ON (car_rentals.ID = $wpdb->term_relationships.object_id)
							LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) ";		
		$where_sql .= " AND $wpdb->term_taxonomy.taxonomy = 'car_type' AND $wpdb->term_taxonomy.term_id IN ($car_types_string) ";
	}

	$having_sql = ' HAVING 1=1 AND bookings < number_of_cars ';
	
	if ($age && $age > 0) {
		$having_sql .= " AND min_age >= $age ";
	}
	
	if (!empty($price_array)) {
		$having_sql .= " AND (1!=1 ";

		$price_range_bottom = of_get_option('price_range_bottom', '0');
		$price_range_increment = of_get_option('price_range_increment', '50');
		$price_range_count = of_get_option('price_range_count', '5');
		
		$bottom = 0;
		$top = 0;
		for ($i=0; $i<$price_range_count;$i++) { 
			$bottom = ($i * $price_range_increment) + $price_range_bottom;
			$top = (($i+1) * $price_range_increment) + $price_range_bottom - 1;	

			if ($i < ($price_range_count)) {
				if (in_array($i+1, $price_array))
					$having_sql .= " OR (price >= $bottom AND price <= $top ) ";
			} else {
				$having_sql .= " OR (price >= $bottom ) ";
			}
		}
		
		$having_sql .= ")";
	}
	
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

function car_rental_get_booked_days($car_rental_id) {
	global $wpdb;
	
	$sql = "	SELECT DISTINCT booking_date, (car_rentals_meta_number_of_cars.meta_value+0) number_of_cars
				FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " days
				INNER JOIN " . BYT_CAR_RENTAL_BOOKINGS_TABLE . " bookings ON bookings.Id = days.car_rental_booking_id 
				INNER JOIN $wpdb->postmeta car_rentals_meta_number_of_cars ON bookings.car_rental_id=car_rentals_meta_number_of_cars.post_id AND car_rentals_meta_number_of_cars.meta_key='car_rental_number_of_cars' 
				WHERE bookings.car_rental_id=%d AND booking_date >= %s 
				GROUP BY booking_date
				HAVING COUNT(DISTINCT car_rental_booking_id) >= number_of_cars";

	$today = date('Y-m-d H:i:s');
	
	$sql = $wpdb->prepare($sql, $car_rental_id, $today);
	
	return $wpdb->get_results($sql);
}


function list_paged_car_rental_bookings($search_term = null, $orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;

	$table_name = BYT_CAR_RENTAL_BOOKINGS_TABLE;
	$sql = "SELECT DISTINCT bookings.*, car_rentals.post_title car_rental_name,
			(
				SELECT MIN(booking_date) FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " v2 
				WHERE v2.car_rental_booking_id = bookings.Id 
			) from_day,
			(
				SELECT MAX(booking_date) FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " v3 
				WHERE v3.car_rental_booking_id = bookings.Id 
			) to_day, locations.post_title pick_up, locations_2.post_title drop_off
			FROM " . $table_name . " bookings 
			INNER JOIN $wpdb->posts car_rentals ON car_rentals.ID = bookings.car_rental_id 
			LEFT JOIN $wpdb->postmeta car_rental_meta_location ON car_rentals.ID=car_rental_meta_location.post_id AND car_rental_meta_location.meta_key='car_rental_location_post_id'
			LEFT JOIN $wpdb->posts locations ON locations.ID = car_rental_meta_location.meta_value+0
			LEFT JOIN $wpdb->postmeta car_rental_meta_location_2 ON car_rentals.ID=car_rental_meta_location_2.post_id AND car_rental_meta_location_2.meta_key='car_rental_location_post_id_2'
			LEFT JOIN $wpdb->posts locations_2 ON locations_2.ID = car_rental_meta_location_2.meta_value+0
			WHERE car_rentals.post_status = 'publish' AND locations.post_status = 'publish' AND locations_2.post_status = 'publish' ";
	
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

function list_car_rental_bookings_total_items() {
	global $wpdb;

	$table_name = BYT_CAR_RENTAL_BOOKINGS_TABLE;
	$sql = "SELECT bookings.* FROM " . $table_name . " bookings ";
	
	return $wpdb->query($sql);
}

function get_car_rental_booking($booking_id) {
	global $wpdb;
	$table_name = BYT_CAR_RENTAL_BOOKINGS_TABLE;
	$sql = "SELECT DISTINCT bookings.*, car_rentals.post_title car_rental_name,
			(
				SELECT MIN(booking_date) FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " v2 
				WHERE v2.car_rental_booking_id = bookings.Id 
			) from_day,
			(
				SELECT MAX(booking_date) FROM " . BYT_CAR_RENTAL_BOOKING_DAYS_TABLE . " v3 
				WHERE v3.car_rental_booking_id = bookings.Id 
			) to_day, locations.post_title pick_up, locations_2.post_title drop_off
			FROM " . $table_name . " bookings 
			INNER JOIN $wpdb->posts car_rentals ON car_rentals.ID = bookings.car_rental_id 
			LEFT JOIN $wpdb->postmeta car_rental_meta_location ON car_rentals.ID=car_rental_meta_location.post_id AND car_rental_meta_location.meta_key='car_rental_location_post_id'
			LEFT JOIN $wpdb->posts locations ON locations.ID = car_rental_meta_location.meta_value+0
			LEFT JOIN $wpdb->postmeta car_rental_meta_location_2 ON car_rentals.ID=car_rental_meta_location_2.post_id AND car_rental_meta_location_2.meta_key='car_rental_location_post_id_2'
			LEFT JOIN $wpdb->posts locations_2 ON locations_2.ID = car_rental_meta_location_2.meta_value+0
			WHERE car_rentals.post_status = 'publish' AND locations.post_status = 'publish' AND locations_2.post_status = 'publish' AND bookings.Id = $booking_id ";

	return $wpdb->get_row($sql);
}

?>