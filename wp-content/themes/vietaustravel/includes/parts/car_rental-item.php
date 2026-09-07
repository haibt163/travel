<?php
	global $post;
	global $currency_symbol;
	$car_rental_id = $post->ID;
	$car_rental = $post;
	$car_rental_name = $post->post_title;
	$car_rental_image = '';
	$custom_car_rental_fields = get_post_custom( $car_rental_id);
	$price_per_day = isset($custom_car_rental_fields['car_rental_price_per_day'][0]) ? $custom_car_rental_fields['car_rental_price_per_day'][0] : 0;
	
	$location_string = '';
	if (isset($_GET['term']) && strlen($_GET['term'])> 0) {
		$location_string = wp_kses($_GET['term'], '');	
	} else {
		$location_post_id = isset($custom_car_rental_fields['car_rental_location_post_id'][0]) ? $custom_car_rental_fields['car_rental_location_post_id'][0] : 0;
		if ($location_post_id > 0) {
			$location = get_post($location_post_id);
			if ($location)
				$location_string = $location->post_title;
		}
	}

	$location_string_2 = '';
	if (isset($_GET['term_to']) && strlen($_GET['term_to'])> 0) {
		$location_string_2 = wp_kses($_GET['term_to'], '');	
	} else {
		$location_post_id = isset($custom_car_rental_fields['car_rental_location_post_id_2'][0]) ? $custom_car_rental_fields['car_rental_location_post_id_2'][0] : 0;
		if ($location_post_id > 0) {
			$location = get_post($location_post_id);
			if ($location)
				$location_string_2 = $location->post_title;
		}
	}
	
	$car_type = null;
	$car_type_obj = wp_get_object_terms($car_rental_id, 'car_type');
	if ($car_type_obj)
		$car_type = $car_type_obj[0];
	$max_people = isset($custom_car_rental_fields['car_rental_max_count'][0]) ? $custom_car_rental_fields['car_rental_max_count'][0] : 0;
	$door_count = isset($custom_car_rental_fields['car_rental_number_of_doors'][0]) ? $custom_car_rental_fields['car_rental_number_of_doors'][0] : 0;
	$transmission = isset($custom_car_rental_fields['car_rental_transmission_type'][0]) ? $custom_car_rental_fields['car_rental_transmission_type'][0] : 0;
	$air_conditioned = isset($custom_car_rental_fields['car_rental_is_air_conditioned'][0]) ? intval($custom_car_rental_fields['car_rental_is_air_conditioned'][0]) : 0;
	$co2_emission = isset($custom_car_rental_fields['car_rental_co2_emission'][0]) ? $custom_car_rental_fields['car_rental_co2_emission'][0] : 0;
	$unlimited_mileage = isset($custom_car_rental_fields['car_rental_is_unlimited_mileage'][0]) ? intval($custom_car_rental_fields['car_rental_is_unlimited_mileage'][0]) : 0;
	$minimum_age = isset($custom_car_rental_fields['car_rental_min_age'][0]) ? $custom_car_rental_fields['car_rental_min_age'][0] : 0;
	
	if ( has_post_thumbnail($car_rental_id)) {
		$car_rental_image = wp_get_attachment_image_src( get_post_thumbnail_id($car_rental_id), 'large');
		$car_rental_image = $car_rental_image[0];
	}
	echo "<script>";
	$booked_days = car_rental_get_booked_days($car_rental_id);
	echo "window.sc_cr_bd" . $car_rental_id . " = new Array(";
	$booked_days_array = array();
	foreach ($booked_days as $day) {
		$booked_days_array[] = "'" . date('Y-m-d', strtotime($day->booking_date)) . "'";
	}	
	echo implode(',', $booked_days_array);
	echo ");";
	echo "</script>";
?>
	<!--accommodation-->
	<article class="<?php echo $car_rental_class; ?>">
		<?php if (!empty($car_rental_image)) { ?>
		<figure><a id="book_car_rental_image<?php echo $car_rental_id; ?>" class="book_car_rental_image" href="#" title="<?php the_title(); ?>"><img src="<?php echo $car_rental_image; ?>" alt="" width="270" height="152" /></a></figure>
		<?php } ?>
		<div class="details cars">
			<h1><?php the_title(); ?></h1>
			<?php
			$now = time();
			$current_date = date('Y-m-d', $now);
			$price_decimal_places = (int)of_get_option('price_decimal_places', 0);
			$min_price = number_format ($price_per_day, $price_decimal_places);
			if ($min_price > 0) {
			?>
			<div class="price">
				<?php 
				_e('Price per day ', 'bookyourtravel'); 
				?>
				<em><span class="curr"><?php echo $currency_symbol; ?></span>
				<span class="amount"><?php echo $min_price; ?></span></em>
				<input type="hidden" id="car_rental_<?php echo $car_rental_id; ?>_car_price" value="<?php echo $price_per_day; ?>" />
			</div>
			<?php } ?>
			<div class="description clearfix ">
				<input type="hidden" id="car_rental_<?php echo $car_rental_id; ?>_term_from" value="<?php echo $location_string; ?>" />
				<input type="hidden" id="car_rental_<?php echo $car_rental_id; ?>_term_to" value="<?php echo $location_string_2; ?>" />
				<input type="hidden" id="car_rental_<?php echo $car_rental_id; ?>_car_rental_name" value="<?php echo $car_rental_name; ?>" />
				<?php if ($car_type) { ?>
					<div class="car_type"><span><?php _e('Car type', 'bookyourtravel'); ?></span><?php echo $car_type->name; ?></div>
					<input type="hidden" id="car_rental_<?php echo $car_rental_id; ?>_car_type_name" value="<?php echo $car_type->name; ?>" />
				<?php } ?>
				<?php if ($max_people) { ?><div class="max_people"><span><?php _e('Max people', 'bookyourtravel'); ?></span><?php echo $max_people; ?></div><?php } ?>
				<?php if ($door_count) { ?><div class="door_count"><span><?php _e('Door count', 'bookyourtravel'); ?></span><?php echo $door_count; ?></div><?php } ?>
				<div class="transmission"><span><?php _e('Transmission', 'bookyourtravel'); ?></span><?php echo $transmission == 'manual' ? __('Manual', 'bookyourtravel') : __('Automatic', 'bookyourtravel') ; ?></div>
				<div class="air_conditioned"><span><?php _e('Air-conditioned?', 'bookyourtravel'); ?></span><?php echo $air_conditioned ? __('Yes', 'bookyourtravel') : __('No', 'bookyourtravel'); ?></div>
				<?php if ($co2_emission) { ?><div class="co2_emission"><span><?php _e('CO2 emission', 'bookyourtravel'); ?></span><?php echo $co2_emission; ?></div><?php } ?>
				<div class="unlimited_mileage"><span><?php _e('Unlimited mileage?', 'bookyourtravel'); ?></span><?php echo $unlimited_mileage ? __('Yes', 'bookyourtravel') : __('No', 'bookyourtravel');; ?></div>
				<?php if ($minimum_age) { ?><div class="minimum_age"><span><?php _e('Minimum driver age', 'bookyourtravel'); ?></span><?php echo $minimum_age; ?></div><?php } ?>
			</div>
			<a href="#" id="book_car_rental<?php echo $car_rental_id; ?>" title="<?php _e('Book now', 'bookyourtravel'); ?>" class="clearfix gradient-button book_car_rental"><?php _e('Book now', 'bookyourtravel'); ?></a>
		</div>
	</article>
	<!--//accommodation-->
<?php ?>