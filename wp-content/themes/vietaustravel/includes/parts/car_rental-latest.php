<?php
	$show_car_rental_offers = of_get_option('show_car_rental_offers', '0');
	if ($show_car_rental_offers) { 
		$latest_car_rentals_count = (int)of_get_option('latest_car_rentals_count', 4);
	?>	
	<!--latest deals-->
	<section class="deals clearfix full">
		<h1><?php _e('Top car rental offers', 'bookyourtravel'); ?></h1>
		<?php

		$args = array(
			'posts_per_page'   => $latest_car_rentals_count,
			'paged'			   => 1,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'car_rental',
			'post_status'      => 'publish'
		); 

		$query = new WP_Query($args); 

		if ( $query->have_posts() ) {
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$car_rental_class = 'one-fourth';
				include('car_rental-item.php');
			}
		}?>	
	</section>
<?php  
	} // end if ($show_car_rental_offers) 
?>