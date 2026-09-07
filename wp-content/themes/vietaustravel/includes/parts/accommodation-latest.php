<?php
	$show_accommodation_offers = of_get_option('show_accommodation_offers', '0');
	if ($show_accommodation_offers) { 
		$latest_accommodations_count = (int)of_get_option('latest_accommodations_count', 4);
	?>	
	<!--latest deals-->
	<section class="deals clearfix full">
		<h1><?php _e('Explore our latest accommodations', 'bookyourtravel'); ?></h1>
		<?php
		$accommodation_review_fields = list_accommodation_review_fields();

		$args = array(
			'posts_per_page'   => $latest_accommodations_count,
			'paged'			   => 1,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'accommodation',
			'post_status'      => 'publish'
		); 

		$query = new WP_Query($args); 

		if ( $query->have_posts() ) {
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$accommodation_class = 'one-fourth';
				include('accommodation-item.php');
			}
		}?>	
	</section>
<?php  
	} // end if ($show_accommodation_offers) 
?>