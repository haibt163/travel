<?php

$show_top_locations = of_get_option('show_top_locations', '1');
if ($show_top_locations) {
	$top_destinations_count = (int)of_get_option('top_destinations_count', 4);

	$args = array(
		'posts_per_page'   => $top_destinations_count,
		'paged'			   => 1,
		'offset'           => 0,
		'category'         => '',

		'orderby'          => 'post_title',
		'order'            => 'DESC',
		'post_type'        => 'location',
		'post_status'      => 'publish'
	); 

	$query = new WP_Query($args); 

	$now = time();
	$current_date = date('Y-m-d', $now); ?>
	<!--top destinations-->
	<section class="destinations clearfix full">
		<h1><?php _e('Top destinations around the world', 'bookyourtravel'); ?></h1>
	<?php 
		if ( $query->have_posts() ) {
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$location_class = 'one-fourth';
				include('location-item.php');
			}
		} ?>
	</section>
<?php } // end if ?>