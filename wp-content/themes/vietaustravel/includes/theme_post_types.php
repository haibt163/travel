<?php
global $wpdb;

/*-----------------------------------------------------------------------------------*/
/*	Load Post Type Files
/*-----------------------------------------------------------------------------------*/
require_once dirname( __FILE__ ) . '/post_types/locations.php';
require_once dirname( __FILE__ ) . '/post_types/sequence-slides.php';
require_once dirname( __FILE__ ) . '/post_types/reviews.php';
require_once dirname( __FILE__ ) . '/post_types/car_rentals.php';
require_once dirname( __FILE__ ) . '/post_types/accommodations.php';
require_once dirname( __FILE__ ) . '/post_types/tours.php';

function custom_posts_per_page( $query ) { 
	$accommodations_archive_posts_per_page = of_get_option('accommodations_archive_posts_per_page', 12);
	$locations_archive_posts_per_page = of_get_option('locations_archive_posts_per_page', 12);
	$tours_archive_posts_per_page = of_get_option('tours_archive_posts_per_page', 12);
	$car_rentals_archive_posts_per_page = of_get_option('car_rentals_archive_posts_per_page', 12);
	
    if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'accommodation' && is_page() ) 
		$query->query_vars['posts_per_page'] = $accommodations_archive_posts_per_page;  
	else if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'location' && is_post_type_archive('location') ) 
		$query->query_vars['posts_per_page'] = $locations_archive_posts_per_page;  
	else if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'tour' && is_page() ) 
		$query->query_vars['posts_per_page'] = $tours_archive_posts_per_page;  
	else if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'car_rental' && is_page() ) 
		$query->query_vars['posts_per_page'] = $car_rentals_archive_posts_per_page;  
		
    return $query;  
}  
if ( !is_admin() ) 
	add_filter( 'pre_get_posts', 'custom_posts_per_page' ); 

function remove_unnecessary_meta_boxes() {
    remove_meta_box('tagsdiv-facility', 'accommodation', 'side');
	remove_meta_box('tagsdiv-facility', 'room_type', 'side');
    remove_meta_box('tagsdiv-accommodation_type', 'accommodation', 'side');
    remove_meta_box('tagsdiv-car_type', 'car_rental', 'side');
    remove_meta_box('tagsdiv-tour_type', 'tour', 'side');
}

add_action( 'manage_posts_custom_column', 'populate_columns' );
function populate_columns( $column ) {
	$enable_accommodations = of_get_option('enable_accommodations', 1);
	$enable_car_rentals = of_get_option('enable_car_rentals', 1);

    if ( 'location_country' == $column ) {
        $location_country = esc_html( get_post_meta( get_the_ID(), 'location_country', true ) );
        echo $location_country;
    } else if ( 'accommodation_location_post_id' == $column && $enable_accommodations ) {
        $location_post_id = get_post_meta( get_the_ID(), 'accommodation_location_post_id', true );
		$location = get_post($location_post_id);
        echo $location->post_title;
    } else if ( 'car_rental_location_post_id' == $column && $enable_car_rentals) {
        $location_post_id = get_post_meta( get_the_ID(), 'car_rental_location_post_id', true );
		$location = get_post($location_post_id);
        echo $location->post_title;
    } else if ( 'car_rental_location_post_id_2' == $column && $enable_car_rentals ) {
        $location_post_id = get_post_meta( get_the_ID(), 'car_rental_location_post_id_2', true );
		$location = get_post($location_post_id);
        echo $location->post_title;
	} else if ( 'review_post_id' == $column && $enable_accommodations) {
		$review_post_id = get_post_meta( get_the_ID(), 'review_post_id', true );
		$reviewed_post = get_post($review_post_id);
		if ($reviewed_post)
			echo $reviewed_post->post_title;
	} 
}

function initialize_post_types() {

	$enable_accommodations = of_get_option('enable_accommodations', 1);
	$enable_car_rentals = of_get_option('enable_car_rentals', 1);
	$enable_tours = of_get_option('enable_tours', 1);
	
	$installed_version = get_option('bookyourtravel_version', 0);

	if ($installed_version == 0)
		add_option("bookyourtravel_version", BOOKYOURTRAVEL_VERSION);
	else
		update_option("bookyourtravel_version", BOOKYOURTRAVEL_VERSION);

	require get_template_directory() . '/upgrades/byt_upgrade.php';
	byt_upgrade($installed_version);
	
	byt_custom_post_slide();
	byt_custom_post_location();
	byt_custom_post_review();
	
	byt_currencies_tables($installed_version);
	
	if ($enable_tours) {
		byt_custom_post_tour();
		create_tour_type_taxonomies();
		byt_tour_extra_tables($installed_version);
	}
	
	if ($enable_car_rentals) {
		create_car_type_taxonomies();
		byt_custom_post_car_rental();
		byt_car_rental_extra_tables($installed_version);
	}
		
	if ($enable_accommodations) {
		byt_custom_post_accommodation();
		byt_custom_post_room_type();
		create_facility_taxonomies();
		create_accommodation_type_taxonomies();
		byt_accommodation_extra_tables($installed_version);
	}
	
}

add_action('init','initialize_post_types');
add_action('admin_init','remove_unnecessary_meta_boxes');

add_filter( 'request', 'post_columns_orderby' ); 
function post_columns_orderby ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'location_country' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'location_country', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}

function list_user_bookings($user_id) {

	global $wpdb;

	$sql =  "SELECT DISTINCT bookings.*, accommodations.ID accommodation_id, accommodations.post_title accommodation_name, room_types.post_title room_type,
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
			WHERE accommodations.post_status = 'publish' AND (room_types.post_status IS NULL OR room_types.post_status = 'publish') AND bookings.user_id = %d";
	
	$sql = $wpdb->prepare($sql, $user_id);
	return $wpdb->get_results($sql);		
}

function get_dates_from_range($start, $end){
	$dates = array($start);
	while(end($dates) < $end){
		$dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
	}
	return $dates;
}

function byt_currencies_tables($installed_version) {

	if ($installed_version != BOOKYOURTRAVEL_VERSION) {
		global $wpdb;
		
		// we do not execute sql directly
		// we are calling dbDelta which cant migrate database
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	

		$table_name = BYT_CURRENCIES_TABLE;
		$sql = "CREATE TABLE " . $table_name . " (
					Id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					currency_code varchar(10) NOT NULL,
					currency_label varchar(255) NOT NULL,
					currency_symbol varchar(10) NULL,
					PRIMARY KEY  (Id)
				);";

		dbDelta($sql);
		
		$table_name = BYT_CURRENCIES_TABLE;
		$sql = "SELECT COUNT(*) cnt FROM $table_name";
		$cnt = $wpdb->get_var($sql);
		if ($cnt == 0) {
		
			$sql = "INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('aed','united arab emirates dirham', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('ars','argentina peso', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('aud','australia dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('bgn','bulgaria lev', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('bob','bolivia boliviano', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('brl','brazil real', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('cad','canada dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('chf','switzerland franc', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('clp','chile peso', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('cny','china yuan renminbi', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('czk','czech republic koruna', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('dkk','denmark krone', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('egp','egypt pound', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('eur','euro', '€');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('gbp','pound','£');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('hkd','hong kong dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('hrk','croatia kuna', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('huf','hungary forint', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('idr','indonesia rupiah', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('ils','israel shekel', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('inr','india rupee', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('jpy','japan yen', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('krw','korea (south) won', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('ltl','lithuania litas', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('mad','morocco dirham', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('mxn','mexico peso', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('myr','malaysia ringgit', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('nok','norway krone', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('nzd','new zealand dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('pen','peru nuevo sol', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('php','philippines peso', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('pkr','pakistan rupee', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('pln','poland zloty', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('ron','romania new leu', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('rsd','serbia dinar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('rub','russia ruble', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('sar','saudi arabia riyal', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('sek','sweden krona', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('sgd','singapore dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('thb','thailand baht', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('trl','turkey lira', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('twd','taiwan new dollar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('uah','ukraine hryvna', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('usd','us dollar', '$');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('vef','venezuela bolivar', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('vnd','viet nam dong', '');
					INSERT INTO $table_name (currency_code, currency_label, currency_symbol) VALUES ('zar','south africa rand', '');";

			dbDelta($sql);
					
		}
		
		global $EZSQL_ERROR;
		$EZSQL_ERROR = array();
	}
}

function find_currency_object($currency_code) {
	global $wpdb;
	$table_name = BYT_CURRENCIES_TABLE;
	$sql = "SELECT * FROM $table_name WHERE currency_code = %s";
	$row = $wpdb->get_row($wpdb->prepare($sql, $currency_code));
	return $row;
}

function list_currencies_total_items() {
	global $wpdb;
	$table_name = BYT_CURRENCIES_TABLE;
	return $wpdb->get_var("SELECT COUNT(*) cnt FROM $table_name");
}

function get_currency($currency_id) {
	global $wpdb;
	$table_name = BYT_CURRENCIES_TABLE;
	$sql = "SELECT * FROM $table_name WHERE Id = %d";
	return $wpdb->get_row($wpdb->prepare($sql, $currency_id), ARRAY_A );	
}

function list_paged_currencies($orderby = 'Id', $order = 'ASC', $paged = null, $per_page = 0 ) {
	global $wpdb;
	
	$table_name = BYT_CURRENCIES_TABLE;
	$sql = "SELECT *
			FROM " . $table_name . " currencies 
			WHERE 1=1 ";
			
	if(!empty($orderby) & !empty($order)){ 
		$sql.=' ORDER BY ' . $orderby . ' ' . $order; 
	}
	
	if(!empty($paged) && !empty($per_page)){
		$offset=($paged-1)*$per_page;
		$sql .=' LIMIT '.(int)$offset.','.(int)$per_page;
	}

	return $wpdb->get_results($sql);
}


?>