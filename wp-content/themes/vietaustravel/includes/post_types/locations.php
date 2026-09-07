<?php
global $wpdb;


function byt_custom_post_location() {
	
	$locations_permalink_slug = of_get_option('locations_permalink_slug', 'locations');
	
	$labels = array(
		'name'                => _x( 'Locations', 'Post Type General Name', 'bookyourtravel' ),
		'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'bookyourtravel' ),
		'menu_name'           => __( 'Locations', 'bookyourtravel' ),
		'all_items'           => __( 'All Locations', 'bookyourtravel' ),
		'view_item'           => __( 'View Location', 'bookyourtravel' ),
		'add_new_item'        => __( 'Add New Location', 'bookyourtravel' ),
		'add_new'             => __( 'New Location', 'bookyourtravel' ),
		'edit_item'           => __( 'Edit Location', 'bookyourtravel' ),
		'update_item'         => __( 'Update Location', 'bookyourtravel' ),
		'search_items'        => __( 'Search locations', 'bookyourtravel' ),
		'not_found'           => __( 'No locations found', 'bookyourtravel' ),
		'not_found_in_trash'  => __( 'No locations found in Trash', 'bookyourtravel' ),
	);
	$args = array(
		'label'               => __( 'location', 'bookyourtravel' ),
		'description'         => __( 'Location information pages', 'bookyourtravel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author', 'page-attributes' ),
		'taxonomies'          => array( ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite' => array('slug' => $locations_permalink_slug)
	);
	register_post_type( 'location', $args );
	
}

function location_columns( $columns ) {
    $columns['location_country'] = 'Country';
    unset( $columns['date'] );
    return $columns;
}
add_filter( 'manage_edit-location_columns', 'location_columns' );

function sort_location_columns( $columns ) {
    $columns['location_country'] = 'location_country';
    return $columns;
}
add_filter( 'manage_edit-location_sortable_columns', 'sort_location_columns' );


?>