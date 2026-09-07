<?php

$prefix = 'tour_';
$tour_custom_meta_fields = array(
	array( // Post ID select box
		'label'	=> 'Location', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'location_post_id', // field id and name
		'type'	=> 'post_select', // type of field
		'post_type' => array('location') // post types to display, options are prefixed with their post type
	),
	array( // Repeatable & Sortable Text inputs
		'label'	=> 'Gallery images', // <label>
		'desc'	=> 'A collection of images to be used in slider/gallery on single page', // description
		'id'	=> $prefix.'images', // field id and name
		'type'	=> 'repeatable', // type of field
		'sanitizer' => array( // array of sanitizers with matching kets to next array
			'featured' => 'meta_box_santitize_boolean',
			'title' => 'sanitize_text_field',
			'desc' => 'wp_kses_data'
		),
		'repeatable_fields' => array ( // array of fields to be repeated
			array( // Image ID field
				'label'	=> 'Image', // <label>
				'id'	=> 'image', // field id and name
				'type'	=> 'image' // type of field
			)
		)
	),
	array(
		'label'	=> 'Price Tour',
		'desc'	=> '',
		'id'	=> $prefix.'price_now',
		'type'	=> 'text'
	),
		
	array(
		'label'	=> 'Map code',
		'desc'	=> '',
		'id'	=> $prefix.'map_code',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Availaibility extra info',
		'desc'	=> 'Extra info shown under availability list on single tour screen',
		'id'	=> $prefix.'availability_extra_info',
		'type'	=> 'textarea'
	),
	array( // Taxonomy Select box
		'label'	=> 'Tour type', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'tour_type', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_select' // type of field
	)
);

$transmission_types = array();
$transmission_types[] = array('value' => 'manual', 'label' => __('Manual transmission', 'bookyourtravel'));
$transmission_types[] = array('value' => 'auto', 'label' => __('Auto transmission', 'bookyourtravel'));

$prefix = 'car_rental_';
$car_rental_custom_meta_fields = array(
	array( // Post ID select box
		'label'	=> 'Pickup Location', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'location_post_id', // field id and name
		'type'	=> 'post_select', // type of field
		'post_type' => array('location') // post types to display, options are prefixed with their post type
	),
	array( // Post ID select box
		'label'	=> 'Drop-off Location', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'location_post_id_2', // field id and name
		'type'	=> 'post_select', // type of field
		'post_type' => array('location') // post types to display, options are prefixed with their post type
	),
	array(
		'label'	=> 'Price per day',
		'desc'	=> 'What is the car\'s rental price per day?',
		'id'	=> $prefix.'price_per_day',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Number of available cars',
		'desc'	=> 'What number of cars are available for rent (used for admin purposes to determine availability)?',
		'id'	=> $prefix.'number_of_cars',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Max count',
		'desc'	=> 'How many people are allowed in the car?',
		'id'	=> $prefix.'max_count',
		'type'	=> 'slider',
		'min'	=> '1',
		'max'	=> '10',
		'step'	=> '1'
	),
	array(
		'label'	=> 'Minimum age',
		'desc'	=> 'What is the minimum age of people in the car?',
		'id'	=> $prefix.'min_age',
		'type'	=> 'slider',
		'min'	=> '18',
		'max'	=> '100',
		'step'	=> '1'
	),
	array(
		'label'	=> 'Number of doors',
		'desc'	=> 'What is the number of doors the car has?',
		'id'	=> $prefix.'number_of_doors',
		'type'	=> 'slider',
		'min'	=> '1',
		'max'	=> '10',
		'step'	=> '1'
	),
	array(
		'label'	=> 'CO2 emission',
		'desc'	=> 'What is the car\'s CO2 emission rate (g/km)?',
		'id'	=> $prefix.'co2_emission',
		'type'	=> 'text'
	),
	array( 
		'label'	=> 'Unlimited mileage', // <label>
		'desc'	=> 'Is there no restriction on mileage covered?', // description
		'id'	=> $prefix.'is_unlimited_mileage', // field id and name
		'type'	=> 'checkbox', // type of field
	),
	array( 
		'label'	=> 'Air-conditioning', // <label>
		'desc'	=> 'Is there air-conditioning?', // description
		'id'	=> $prefix.'is_air_conditioned', // field id and name
		'type'	=> 'checkbox', // type of field
	),
	array( 
		'label'	=> 'Transmission type', // <label>
		'desc'	=> 'What is the car\'s transmission type?', // description
		'id'	=> $prefix.'transmission_type', // field id and name
		'type'	=> 'select', // type of field
		'options' => $transmission_types
	),
	array( // Taxonomy Select box
		'label'	=> 'Car type', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'car_type', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_select' // type of field
	),
);

$prefix = 'review_';
$review_custom_meta_fields = array(
	array(
		'label'	=> 'Likes',
		'desc'	=> 'What the user likes about the accommodation',
		'id'	=> $prefix.'likes',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Dislikes',
		'desc'	=> 'What the user dislikes about the accommodation',
		'id'	=> $prefix.'dislikes',
		'type'	=> 'textarea'
	),
	array( // Post ID select box
		'label'	=> 'Reviewed item', // <label>
		'desc'	=> '', // description
		'id'	=>  $prefix.'post_id', // field id and name
		'type'	=> 'post_select', // type of field
		'post_type' => array('accommodation', 'tour') // post types to display, options are prefixed with their post type
	),
	array('label'	=> 'Cleanliness',	'desc'	=> 'Cleanliness rating', 'id'	=> $prefix.'cleanliness', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Comfort',	'desc'	=> 'Comfort rating', 'id'	=> $prefix.'comfort', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Location',	'desc'	=> 'Location rating', 'id'	=> $prefix.'location', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Staff',	'desc'	=> 'Staff rating', 'id'	=> $prefix.'staff', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Services',	'desc'	=> 'Services rating', 'id'	=> $prefix.'services', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Value for money',	'desc'	=> 'Value for money rating', 'id'	=> $prefix.'value_for_money', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Sleep quality',	'desc'	=> 'Sleep quality rating', 'id'	=> $prefix.'sleep_quality', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Overall',	'desc'	=> 'Overall rating', 'id'	=> $prefix.'overall', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Accommodation',	'desc'	=> 'Accommodation rating', 'id'	=> $prefix.'accommodation', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Transport',	'desc'	=> 'Transport rating', 'id'	=> $prefix.'transport', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Meals',	'desc'	=> 'Meals rating', 'id'	=> $prefix.'meals', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Guide',	'desc'	=> 'Guide rating', 'id'	=> $prefix.'guide', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' ),
	array('label'	=> 'Program accuracy',	'desc'	=> 'Program accuracy rating', 'id'	=> $prefix.'program_accuracy', 'type'	=> 'slider', 'min'	=> '1', 'max'	=> '10', 'step'	=> '1' )
);

$prefix = 'room_type_';
$room_type_custom_meta_fields = array(
	array(
		'label'	=> 'Max count',
		'desc'	=> 'How many people are allowed in the room?',
		'id'	=> $prefix.'max_count',
		'type'	=> 'slider',
		'min'	=> '1',
		'max'	=> '10',
		'step'	=> '1'
	),
	array(
		'label'	=> 'Bed size',
		'desc'	=> 'How big is/are the beds?',
		'id'	=> $prefix.'bed_size',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Room size',
		'desc'	=> 'What is the room size (m2)?',
		'id'	=> $prefix.'room_size',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Room meta information',
		'desc'	=> 'What other information applies to this specific room type?',
		'id'	=> $prefix.'meta',
		'type'	=> 'text'
	),
	array( // Taxonomy Select box
		'label'	=> 'Facilities', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'facility', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_checkboxes' // type of field
	),
);

$prefix = 'accommodation_';
$accommodation_custom_meta_fields = array(
	array( // Post ID select box
		'label'	=> 'Is Self Catered', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'is_self_catered', // field id and name
		'type'	=> 'checkbox', // type of field
	),
	array( // Post ID select box
		'label'	=> 'Room types', // <label>
		'desc'	=> '', // description
		'id'	=>  'room_types', // field id and name
		'type'	=> 'post_checkboxes', // type of field
		'post_type' => array('room_type') // post types to display, options are prefixed with their post type
	),
	array(
		'label'	=> 'Star count',
		'desc'	=> '',
		'id'	=> $prefix.'star_count',
		'type'	=> 'slider',
		'min'	=> '1',
		'max'	=> '5',
		'step'	=> '1'
	),
	array( // Taxonomy Select box
		'label'	=> 'Facilities', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'facility', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_checkboxes' // type of field
	),
	array( // Taxonomy Select box
		'label'	=> 'Accomodation type', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'accommodation_type', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_select' // type of field
	),
	array( // Post ID select box
		'label'	=> 'Location', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'location_post_id', // field id and name
		'type'	=> 'post_select', // type of field
		'post_type' => array('location') // post types to display, options are prefixed with their post type
	),
	array( // Repeatable & Sortable Text inputs
		'label'	=> 'Gallery images', // <label>
		'desc'	=> 'A collection of images to be used in slider/gallery on single page', // description
		'id'	=> $prefix.'images', // field id and name
		'type'	=> 'repeatable', // type of field
		'sanitizer' => array( // array of sanitizers with matching kets to next array
			'featured' => 'meta_box_santitize_boolean',
			'title' => 'sanitize_text_field',
			'desc' => 'wp_kses_data'
		),
		'repeatable_fields' => array ( // array of fields to be repeated
			array( // Image ID field
				'label'	=> 'Image', // <label>
				'id'	=> 'image', // field id and name
				'type'	=> 'image' // type of field
			)
		)
	),
	array(
		'label'	=> 'Address',
		'desc'	=> '',
		'id'	=> $prefix.'address',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Website address',
		'desc'	=> '',
		'id'	=> $prefix.'website_address',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Contact email address',
		'desc'	=> 'Contact email address (leave blank if direct contact via front end is not desired/required)',
		'id'	=> $prefix.'contact_email',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Check-in time info',
		'desc'	=> '',
		'id'	=> $prefix.'check_in_time',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Check-out time info',
		'desc'	=> '',
		'id'	=> $prefix.'check_out_time',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Cancellation / Prepayment info',
		'desc'	=> '',
		'id'	=> $prefix.'cancellation_prepayment',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Children &amp; extra beds info',
		'desc'	=> '',
		'id'	=> $prefix.'children_and_extra_beds',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Pets',
		'desc'	=> '',
		'id'	=> $prefix.'pets',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Accepted credit cards info',
		'desc'	=> '',
		'id'	=> $prefix.'accepted_credit_cards',
		'type'	=> 'textarea'
	),	
	array(
		'label'	=> 'Activities info',
		'desc'	=> '',
		'id'	=> $prefix.'activities',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Internet info',
		'desc'	=> '',
		'id'	=> $prefix.'internet',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Parking info',
		'desc'	=> '',
		'id'	=> $prefix.'parking',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Latitude coordinates',
		'desc'	=> 'Latitude coordinates for use with google map (leave blank to not use)',
		'id'	=> $prefix.'latitude',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Longitude coordinates',
		'desc'	=> 'Longitude coordinates for use with google map (leave blank to not use)',
		'id'	=> $prefix.'longitude',
		'type'	=> 'text'
	),
	
);

$prefix = 'location_';
$location_custom_meta_fields = array(
	/*array(
		'label'	=> 'Country',
		'desc'	=> 'Country name',
		'id'	=> $prefix.'country',
		'type'	=> 'text'
	),*/
	array(
		'label'	=> 'Visa requirements',
		'desc'	=> '',
		'id'	=> $prefix.'visa_requirements',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Languages spoken',
		'desc'	=> '',
		'id'	=> $prefix.'languages_spoken',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Currency',
		'desc'	=> '',
		'id'	=> $prefix.'currency',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Area',
		'desc'	=> 'Area (km2)',
		'id'	=> $prefix.'area',
		'type'	=> 'text'
	),
	/*array(
		'label'	=> 'Sports &amp; nature',
		'desc'	=> '',
		'id'	=> $prefix.'sports_and_nature',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Sports and nature image',
		'desc'	=> '',
		'id'	=> $prefix.'sports_and_nature_image',
		'type'	=> 'image'
	),
	array(
		'label'	=> 'Nightlife info',
		'desc'	=> '',
		'id'	=> $prefix.'nightlife',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Nightlife image',
		'desc'	=> '',
		'id'	=> $prefix.'nightlife_image',
		'type'	=> 'image'
	),*/
	array(
		'label'	=> 'Culture and history info',
		'desc'	=> '',
		'id'	=> $prefix.'culture_and_history',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Culture and history image',
		'desc'	=> '',
		'id'	=> $prefix.'culture_and_history_image',
		'type'	=> 'image'
	)
);
add_action( 'admin_init', 'location_admin_init' );

function location_admin_init() {
	global $location_custom_meta_fields;
	new custom_add_meta_box( 'location_custom_meta_fields', 'Extra information', $location_custom_meta_fields, 'location', true );
}

$enable_accommodations = of_get_option('enable_accommodations', 1);
if ($enable_accommodations) {
	add_action( 'admin_init', 'accommodation_admin_init' );
}
	
function accommodation_admin_init() {
	global $accommodation_custom_meta_fields, $room_type_custom_meta_fields, $review_custom_meta_fields, $car_rental_custom_meta_fields, $tour_custom_meta_fields;
	new custom_add_meta_box( 'accommodation_custom_meta_fields', 'Extra information', $accommodation_custom_meta_fields, 'accommodation', true );
	new custom_add_meta_box( 'room_type_custom_meta_fields', 'Extra information', $room_type_custom_meta_fields, 'room_type', true );
	new custom_add_meta_box( 'review_custom_meta_fields', 'Extra information', $review_custom_meta_fields, 'review', true );
	new custom_add_meta_box( 'car_rental_custom_meta_fields', 'Extra information', $car_rental_custom_meta_fields, 'car_rental', true );
	new custom_add_meta_box( 'tour_custom_meta_fields', 'Extra information', $tour_custom_meta_fields, 'tour', true );
}

?>