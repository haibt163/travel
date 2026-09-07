<?php

global $wpdb;

function byt_custom_post_tour() {
	
	$tours_permalink_slug = of_get_option('tours_permalink_slug', 'tours');
	
	$labels = array(
		'name'                => _x( 'Tours', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Tours', 'bookyourtravel' ),
		'all_items'           => __( 'All Tours', 'bookyourtravel' ),
		'view_item'           => __( 'View Tour', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Tour', 'bookyourtravel' ),
		'add_new'             => __( 'New Tours', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Tours', 'bookyourtravel' ),
		'update_item'         => __( 'Update Tours', 'bookyourtravel' ),
		'search_items'        => __( 'Search Tours', 'bookyourtravel' ),
		'not_found'           => __( 'No Tours found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No Tours found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'tour', 'bookyourtravel' ),
		'description'         => __( 'Tour information pages', 'bookyourtravel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
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
 		'rewrite' => array('slug' => $tours_permalink_slug),
	);
	register_post_type( 'tour', $args );	
}

function create_tour_type_taxonomies(){
	$labels = array(
			'name'              => _x( 'Tour types', 'taxonomy general name', 'bookyourtravel' ),
			'singular_name'     => _x( 'Tour type', 'taxonomy singular name', 'bookyourtravel' ),
			'search_items'      => __( 'Search Tour types', 'bookyourtravel' ),
			'all_items'         => __( 'All Tour types', 'bookyourtravel' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'         => __( 'Edit Tour type', 'bookyourtravel' ),
			'update_item'       => __( 'Update Tour type', 'bookyourtravel' ),
			'add_new_item'      => __( 'Add New Tour type', 'bookyourtravel' ),
			'new_item_name'     => __( 'New Tour Type Name', 'bookyourtravel' ),
			'separate_items_with_commas' => __( 'Separate Tour types with commas', 'bookyourtravel' ),
			'add_or_remove_items'        => __( 'Add or remove Tour types', 'bookyourtravel' ),
			'choose_from_most_used'      => __( 'Choose from the most used Tour types', 'bookyourtravel' ),
			'not_found'                  => __( 'No Tour types found.', 'bookyourtravel' ),
			'menu_name'         => __( 'Tour types', 'bookyourtravel' ),
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
	
	$enable_tours = of_get_option('enable_tours', 1);

	if ($enable_tours) {
		register_taxonomy( 'tour_type', 'tour', $args );
	}
}

function list_paged_tours($posts_per_page, $paged, $offset, $orderby, $order) {

	$args = array(
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'post_type'        => 'tour',
		'post_status'      => 'publish',
		'posts_per_page' => $posts_per_page,
	);
	return new WP_Query($args);
}

function byt_tour_extra_tables($installed_version) {

	if ($installed_version != BOOKYOURTRAVEL_VERSION) {
		global $wpdb;
		
		// we do not execute sql directly
		// we are calling dbDelta which cant migrate database
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');		
		
		$table_name = BYT_TOUR_SCHEDULE_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					tour_id bigint(20) NOT NULL,
					start_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					price decimal(10, 2) NOT NULL,
					duration_days varchar(35) NOT NULL DEFAULT 0,
					max_people int NOT NULL DEFAULT 0,
					created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		$table_name = BYT_TOUR_BOOKING_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					tour_schedule_id bigint(20) NOT NULL,
					first_name varchar(255) NOT NULL,
					last_name varchar(255) NOT NULL,
					email varchar(255) NOT NULL,
					phone varchar(255) NULL,
					address varchar(255) NULL,
					town varchar(255) NULL,
					zip varchar(255) NULL,
					country varchar(255) NULL,
					special_requirements text NULL,
					user_id bigint(10) NOT NULL DEFAULT 0,
					total_price decimal(10, 2) NOT NULL,
					created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		global $EZSQL_ERROR;
		$EZSQL_ERROR = array();
		
	}
}


function list_tours($location_id) {

	global $wpdb;
	
	$location_args =  array( 'post_type' => 'location', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $location_id );
	$location_children = get_posts($location_args);
	$location_ids = array($location_id);
	foreach ($location_children as $location) {
		$location_ids[] = $location->ID;
	}
	$location_ids_string = implode(', ', $location_ids);
	
	$sql = "SELECT tours.*
			FROM $wpdb->posts tours
			INNER JOIN $wpdb->postmeta location_meta ON (tours.ID = location_meta.post_id) 
			LEFT JOIN $wpdb->postmeta tour_location_post_id ON (tours.ID = tour_location_post_id.post_id) 
			WHERE tours.post_type = 'tour' AND tours.post_status = 'publish' AND 
			(location_meta.meta_key = 'tour_location_post_id' AND CAST(location_meta.meta_value AS UNSIGNED) IN ($location_ids_string))
			GROUP BY tours.ID ORDER BY tours.post_date DESC";
	
	$sql = $wpdb->prepare($sql, $location_id);
	return $wpdb->get_results($sql);
}

function list_tours_all() {

	$args = array(
	   'post_type' => 'tour',
	   'post_status' => 'publish',
	   'posts_per_page' => -1,
	);
	$query = new WP_Query($args);

	return $query;
}

function list_tour_schedule_total_items($day, $month, $year, $tour_id) {
	global $wpdb;

	$table_name = BYT_TOUR_SCHEDULE_TABLE;
	$sql = "SELECT schedule.* FROM " . $table_name . " schedule WHERE 1=1 ";
	if ($tour_id > 0) {
		$sql .= " AND schedule.tour_id=$tour_id ";
	}
	
	return $wpdb->query($sql);
}

function get_tour_schedule($tour_schedule_id) {
	global $wpdb;
		
	$table_name = BYT_TOUR_SCHEDULE_TABLE;
	$table_name_2 = BYT_TOUR_BOOKING_TABLE;
	$sql = "
		SELECT schedule.*, (SELECT COUNT(*) ct FROM $table_name_2 bookings WHERE bookings.tour_schedule_id = schedule.Id ) booking_count
		FROM " . $table_name . " schedule 
		WHERE schedule.Id=%d ";
	
	$sql = $wpdb->prepare($sql, $tour_schedule_id);
	return $wpdb->get_row($sql);
}

function get_tour_booking($booking_id) {
	global $wpdb;

	$sql = "SELECT DISTINCT bookings.*, tours.post_title tour_name, schedule.start_date, bookings.total_price
			FROM " . BYT_TOUR_BOOKING_TABLE . " bookings 
			INNER JOIN " . BYT_TOUR_SCHEDULE_TABLE . " schedule ON schedule.Id = bookings.tour_schedule_id
			INNER JOIN $wpdb->posts tours ON tours.ID = schedule.tour_id 
			WHERE tours.post_status = 'publish'	AND bookings.Id = $booking_id ";

	return $wpdb->get_row($sql);
}

function list_paged_tour_bookings($search_term = null, $orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;

	$sql = "SELECT DISTINCT bookings.*, tours.post_title tour_name, schedule.start_date, bookings.total_price
			FROM " . BYT_TOUR_BOOKING_TABLE . " bookings 
			INNER JOIN " . BYT_TOUR_SCHEDULE_TABLE . " schedule ON schedule.Id = bookings.tour_schedule_id
			INNER JOIN $wpdb->posts tours ON tours.ID = schedule.tour_id 
			WHERE tours.post_status = 'publish' ";
	
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

function list_tour_bookings_total_items() {
	global $wpdb;

	$table_name = BYT_TOUR_BOOKING_TABLE;
	$sql = "SELECT bookings.* FROM " . $table_name . " bookings ";
	
	return $wpdb->query($sql);
}

function list_paged_tour_schedule($day, $month, $year, $tour_id, $search_term = null, $orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;
	
	$filter_date = '';
	if ($day > 0 || $month > 0 || $year) { 
		$filter_date .= ' AND ( 1=1 ';
		if ($day > 0)
			$filter_date .= $wpdb->prepare(" AND DAY(start_date) = %d ", $day);			
		if ($month > 0)
			$filter_date .= $wpdb->prepare(" AND MONTH(start_date) = %d ", $month);			
		if ($year > 0)
			$filter_date .= $wpdb->prepare(" AND YEAR(start_date) = %d ", $year);			
		$filter_date .= ')';		
	}

	$table_name = BYT_TOUR_SCHEDULE_TABLE;
	$table_name_2 = BYT_TOUR_BOOKING_TABLE;
	$sql = "SELECT schedule.*, tours.post_title tour_name, (SELECT COUNT(*) ct FROM $table_name_2 bookings WHERE bookings.tour_schedule_id = schedule.Id ) has_bookings
			FROM " . $table_name . " schedule 
			INNER JOIN $wpdb->posts tours ON tours.ID = schedule.tour_id 
			WHERE tours.post_status = 'publish' ";
			
	if ($tour_id > 0) {
		$sql .= " AND schedule.tour_id=$tour_id ";
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

function get_tour_min_price($tour_id, $date) {

	global $wpdb;

	$sql = "SELECT MIN(price) FROM `" . BYT_TOUR_SCHEDULE_TABLE . "`
			WHERE tour_id=%d AND start_date > %s ";
	
	return $wpdb->get_var($wpdb->prepare($sql, $tour_id, $date));			
	
}

function delete_all_tour_scheduled_entries() {
	global $wpdb;
	$table_name = BYT_TOUR_SCHEDULE_TABLE;
	$sql = "DELETE FROM $table_name";
	$wpdb->query($sql);
}

function list_available_tour_schedule_entries($tour_id, $from_date) {
	global $wpdb;

	$table_name = BYT_TOUR_SCHEDULE_TABLE;
	$table_name_2 = BYT_TOUR_BOOKING_TABLE;
	$sql = "
		SELECT *
		FROM " . $table_name . " schedule 
		WHERE tour_id=%d AND start_date >= %s 
		HAVING max_people > (SELECT COUNT(*) ct FROM $table_name_2 bookings WHERE bookings.tour_schedule_id = schedule.Id ) ";
	
	$sql = $wpdb->prepare($sql, $tour_id, $from_date);
	return $wpdb->get_results($sql);
}


function create_tour_booking($first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $tour_schedule_id, $user_id, $total_price) {
	global $wpdb;

	$sql = "INSERT INTO " . BYT_TOUR_BOOKING_TABLE . "
			(first_name, last_name, email, phone, address, town, zip, country, special_requirements, tour_schedule_id, user_id, total_price)
			VALUES 
			(%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d);";
	$wpdb->query($wpdb->prepare($sql, $first_name, $last_name, $email, $phone, $address, $town, $zip, $country, $special_requirements, $tour_schedule_id, $user_id, (float)$total_price));
	$booking_id = $wpdb->insert_id;
	
	return $booking_id;
}

function search_tours($search_string, $date_from, $paged, $posts_per_page, $sort_by, $sort_order, $price_array, $guests) {
	global $wpdb;
	
	$sort_by = 'tours.post_title';
	if (isset($sort_by_p)) {
		switch ($sort_by_p) {
			case '1' : $sort_by = 'price';break;// price
			default : $sort_by = 'price';break;
		}
	}

	$sort_order = '';
	if (isset($sort_order_p)) {
		if ($sort_order_p == '2')
			$sort_order = 'DESC';
	}
	
	$sql = "";

	$select_sql_1 = "SELECT DISTINCT tours.*,
	(
		SELECT COUNT(*) cnt
		FROM " . BYT_TOUR_BOOKING_TABLE . " bookings 
		INNER JOIN " . BYT_TOUR_SCHEDULE_TABLE . " schedule ON bookings.tour_schedule_id = schedule.Id
		WHERE tours.ID = schedule.tour_id
		ORDER BY cnt ASC LIMIT 1
	) bookings,
	( 
		SELECT MIN(price) 
		FROM `" . BYT_TOUR_SCHEDULE_TABLE . "`
		WHERE tour_id=tours.ID AND start_date > '$date_from'
	) price,
	( 
		SELECT MIN(max_people) 
		FROM `" . BYT_TOUR_SCHEDULE_TABLE . "`
		WHERE tour_id=tours.ID AND start_date > '$date_from'
	) max_people
	";
	
	$select_sql_2 = " FROM $wpdb->posts tours ";
	
	$select_sql_2 .= " LEFT JOIN $wpdb->postmeta tours_meta_location ON tours.ID=tours_meta_location.post_id AND tours_meta_location.meta_key='tour_location_post_id' ";
	
	$where_sql = " WHERE  tours.post_type='tour' AND tours.post_status='publish' ";
	
	// incorporate the location 1 into search...
	if (!empty($search_string)) {
		$sql = $wpdb->prepare("select ID from $wpdb->posts where LOWER(post_title) LIKE '%%%s%%' AND post_type='location' AND post_status='publish'", strtolower($search_string));
		$location_ids = $wpdb->get_col($sql);
		
		$where_sql .= " AND ( ";
		
		if (count($location_ids) > 0) {
			$where_sql .= " (tours_meta_location.meta_value+0 IN (";
			
			foreach ($location_ids as $location_id) {
				$where_sql .= "$location_id,";
			}
			$where_sql = rtrim($where_sql, ',');
			$where_sql .= ")) ";
		} else {
			$where_sql .= ' (1!=1) '; // we haven't found any locations by user's search... so make sure search returns nothing
		}
		
		$where_sql .= sprintf(" OR (LOWER(tours.post_title) LIKE '%%%s%%') ", strtolower($search_string));

		$where_sql .= " ) ";
	}
	
	$having_sql = " HAVING 1=1 AND (bookings ";
	
	if ($guests && $guests > 0) {
		$having_sql .= "+ $guests) <= max_people ";
	} else {
		$having_sql .= ") < max_people ";
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

?>
