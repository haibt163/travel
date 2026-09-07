<?php
	global $post;
	global $currency_symbol;
	$location_id = $post->ID;
	$location = $post;
	$location_image = '';
	$custom_location_fields = get_post_custom( $location_id);
	
	$location_general_description = $location->post_content;
	$location_general_description = apply_filters('the_content', $location_general_description);
	if ( has_post_thumbnail($location_id)) {
		$location_image = wp_get_attachment_image_src( get_post_thumbnail_id($location_id), 'large'); 
		$location_image = $location_image[0];
	} else {
		$location_image = get_template_directory_uri() . '/images/uploads/img.jpg';
	}
	$hotel_count = count(list_hotels($location_id));
	$self_catered_count = intval(get_self_catered_count($location_id));
	$price_decimal_places = (int)of_get_option('price_decimal_places', 0);
	$min_price = number_format(get_accommodation_min_price_by_location($location_id, $current_date), $price_decimal_places);
	?>
	
	<!--column-->
	<article class="<?php echo $location_class; ?>">
		<figure><a href="<?php  echo get_permalink($location_id); ?>" title="<?php echo get_the_title($location_id); ?>"><img src="<?php echo $location_image; ?>" alt="" width="270" height="152" /></a></figure>
		<div class="details">
			<a href="<?php  echo get_permalink($location_id); ?>" title="<?php _e('View all', 'bookyourtravel'); ?>" class="gradient-button"><?php _e('View all', 'bookyourtravel'); ?></a>
			<h5><?php echo get_the_title($location_id); ?></h5>
			<span class="count"><?php echo $hotel_count; ?> <?php _e('Hotels', 'bookyourtravel'); ?></span>
			<?php if ($min_price > 0) { ?>
			<div class="ribbon">
				<div class="half hotel">
					<?php if ($hotel_count > 0) { ?>
					<a href="<?php echo get_permalink($location_id); ?>#hotels" title="<?php _e('View all', 'bookyourtravel'); ?>">
						<span class="small"><?php _e('from', 'bookyourtravel'); ?></span>
						<div class="price">
							<em><span class="curr"><?php echo $currency_symbol; ?></span>
							<span class="amount"><?php echo $min_price; ?></span></em>
						</div>
					</a>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</article>
	<!--//column-->
<?php ?>