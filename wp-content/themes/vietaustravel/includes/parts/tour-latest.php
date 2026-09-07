<?php
	$show_tour_offers = of_get_option('show_tour_offers', '0');
	if ($show_tour_offers) { 
		$latest_tours_count = (int)of_get_option('latest_tours_count', 4);
	?>	
	<!--latest deals-->
	<section class="deals clearfix full">
		<h1><?php _e('Explore our latest tours', 'bookyourtravel'); ?></h1>
		<?php
		$tour_review_fields = list_tour_review_fields();

		$args = array(
			'posts_per_page'   => $latest_tours_count,
			'paged'			   => 1,
			'offset'           => 0,
			'category'         => '',   
	         
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'tour',
			'post_status'      => 'publish'
		); 

		$query = new WP_Query($args); 

		if ( $query->have_posts() ) {
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$tour_class = 'one-fourth';
				include('tour-item.php');

    		}
		}?>	
	</section>
<?php  
	} // end if ($show_tour_offers) 
?>
