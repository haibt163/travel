<?php

global $wpdb;

function byt_custom_post_review() {
	
	$labels = array(
		'name'                => _x( 'Reviews', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Review', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Reviews', 'bookyourtravel' ),
		'all_items'           => __( 'Reviews', 'bookyourtravel' ),
		'view_item'           => __( 'View Review', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Review', 'bookyourtravel' ),
		'add_new'             => __( 'New Review', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Review', 'bookyourtravel' ),
		'update_item'         => __( 'Update Review', 'bookyourtravel' ),
		'search_items'        => __( 'Search reviews', 'bookyourtravel' ),
		'not_found'           => __( 'No reviews found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No reviews found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'Review', 'bookyourtravel' ),
		'description'         => __( 'Review information pages', 'bookyourtravel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'author' ),
		'taxonomies'          => array( ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
		'rewrite' => false,
	);
	register_post_type( 'review', $args );	
}

function review_columns( $columns ) {
    $columns['review_post_id'] = __('Reviewed item', 'bookyourtravel');
    return $columns;
}
add_filter( 'manage_edit-review_columns', 'review_columns' );

function list_user_reviews($user_id) {
	
	$args = array(
	   'post_type' => 'review',
	   'author' => $user_id,
	   'posts_per_page' => -1,
	);
	$query = new WP_Query($args);
	return $query;	
}

function list_reviews($post_id, $user_id) {

	$args = array(
	   'post_type' => 'review',
	   'author' => $user_id,
	   'posts_per_page' => -1,
	   'meta_query' => array(
		   array(
			   'key' => 'review_post_id',
			   'value' => $post_id,
			   'compare' => '=',
			   'type'    => 'CHAR',
		   ),
	   )
	);
	$query = new WP_Query($args);

	return $query;
}

function list_reviews_all($post_id) {

	$args = array(
	   'post_type' => 'review',
	   'posts_per_page' => -1,
	   'meta_query' => array(
		   array(
			   'key' => 'review_post_id',
			   'value' => $post_id,
			   'compare' => '=',
			   'type'    => 'CHAR',
		   ),
	   )
	);
	$query = new WP_Query($args);

	return $query;
}

function list_accommodation_review_fields() {

	$fields = array();
	$fields['review_cleanliness'] = __('Cleanliness', 'bookyourtravel');
	$fields['review_comfort'] = __('Comfort', 'bookyourtravel');
	$fields['review_location'] = __('Location', 'bookyourtravel');
	$fields['review_staff'] = __('Staff', 'bookyourtravel');
	$fields['review_services'] = __('Services', 'bookyourtravel');
	$fields['review_value_for_money'] = __('Value for money', 'bookyourtravel');
	$fields['review_sleep_quality'] = __('Sleep quality', 'bookyourtravel');

	return $fields;
}

function list_tour_review_fields() {

	$fields = array();
	$fields['review_overall'] =  __('Overall', 'bookyourtravel');
	$fields['review_accommodation'] = __('Accommodation', 'bookyourtravel');
	$fields['review_transport'] = __('Transport', 'bookyourtravel');
	$fields['review_meals'] = __('Meals', 'bookyourtravel');
	$fields['review_guide'] = __('Guide', 'bookyourtravel');
	$fields['review_value_for_money'] = __('Value for money', 'bookyourtravel');
	$fields['review_program_accuracy'] = __('Program accuracy', 'bookyourtravel');

	return $fields;
}

function get_review_count($post_id) {
	
	$args = array(
	   'post_type' => 'review',
	   'meta_query' => array(
		   array(
			   'key' => 'review_post_id',
			   'value' => $post_id,
			   'compare' => '=',
			   'type'    => 'CHAR',
		   ),
	   )
	);
	$query = new WP_Query($args);
	
	return $query->found_posts;
}

function sum_review_meta_values($post_id, $meta_key) {
	
	global $wpdb;

	$sql = $wpdb->prepare("SELECT sum(meta.meta_value)
		FROM $wpdb->postmeta as meta
		INNER JOIN $wpdb->postmeta as meta2 ON meta2.post_id = meta.post_id
		INNER JOIN $wpdb->posts as posts ON posts.ID = meta.post_id
		WHERE meta.meta_key = %s AND posts.post_type='review' AND posts.post_status='publish' AND meta2.meta_key = 'review_post_id' AND meta2.meta_value=%d", $meta_key, $post_id);
	
	return $wpdb->get_var($sql);	
}

function sum_tour_review_meta_values_total($post_id) {
	
	global $wpdb;
	
	$review_fields = list_tour_review_fields();
	$review_fields_str = "";
	foreach ($review_fields as $review_field) {
		$review_fields_str .= "'$review_field', ";
	}
	$review_fields_str = rtrim($review_fields_str, ', ');

	$sql = $wpdb->prepare("SELECT sum(meta.meta_value)
		FROM $wpdb->postmeta as meta
		INNER JOIN $wpdb->postmeta as meta2 ON meta2.post_id = meta.post_id
		INNER JOIN $wpdb->posts as posts ON posts.ID = meta.post_id
		WHERE meta.meta_key IN ($review_fields_str) AND posts.post_type='review' AND posts.post_status='publish' AND meta2.meta_key = 'review_post_id' AND meta2.meta_value=%d", $post_id);
		
	return $wpdb->get_var($sql);	
}

function sum_accommodation_review_meta_values_total($post_id) {
	
	global $wpdb;
	
	$review_fields = list_accommodation_review_fields();
	$review_fields_str = "";
	foreach ($review_fields as $review_field) {
		$review_fields_str .= "'$review_field', ";
	}
	$review_fields_str = rtrim($review_fields_str, ', ');

	$sql = $wpdb->prepare("SELECT sum(meta.meta_value)
		FROM $wpdb->postmeta as meta
		INNER JOIN $wpdb->postmeta as meta2 ON meta2.post_id = meta.post_id
		INNER JOIN $wpdb->posts as posts ON posts.ID = meta.post_id
		WHERE meta.meta_key IN ($review_fields_str) AND posts.post_type='review' AND posts.post_status='publish' AND meta2.meta_key = 'review_post_id' AND meta2.meta_value=%d", $post_id);
		
	return $wpdb->get_var($sql);	
}

function sum_accommodation_review_meta_values_total_for_user($review_id, $user_id) {
	
	global $wpdb;
	
	$review_fields = list_accommodation_review_fields();
	$review_fields_str = "";
	foreach ($review_fields as $field_key => $field_label) {
		$review_fields_str .= "'$field_key', ";
	}
	$review_fields_str = rtrim($review_fields_str, ', ');

	$sql = $wpdb->prepare("SELECT sum(meta.meta_value)
		FROM $wpdb->postmeta as meta
		INNER JOIN $wpdb->posts as posts ON posts.ID = meta.post_id
		WHERE meta.meta_key IN ($review_fields_str) AND posts.post_type='review' AND posts.post_status='publish' 
		AND posts.ID=%d AND posts.post_author=%d", $review_id, $user_id);

	return $wpdb->get_var($sql);	
}

function sum_tour_review_meta_values_total_for_user($review_id, $user_id) {
	
	global $wpdb;
	
	$review_fields = list_tour_review_fields();
	$review_fields_str = "";
	foreach ($review_fields as $field_key => $field_label) {
		$review_fields_str .= "'$field_key', ";
	}
	$review_fields_str = rtrim($review_fields_str, ', ');

	$sql = $wpdb->prepare("SELECT sum(meta.meta_value)
		FROM $wpdb->postmeta as meta
		INNER JOIN $wpdb->posts as posts ON posts.ID = meta.post_id
		WHERE meta.meta_key IN ($review_fields_str) AND posts.post_type='review' AND posts.post_status='publish' 
		AND posts.ID=%d AND posts.post_author=%d", $review_id, $user_id);

	return $wpdb->get_var($sql);	
}


?>