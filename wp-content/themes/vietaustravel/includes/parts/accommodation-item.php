<?php
	global $post, $currency_symbol, $accommodation_review_fields;
	global $date_from, $date_to;

	$accommodation_id = $post->ID;
	$accommodation = $post;
	$accommodation_image = '';
	$custom_accommodation_fields = get_post_custom( $accommodation_id);
	
	$accommodation_is_self_catered = isset($custom_accommodation_fields['accommodation_is_self_catered']) ? (int)$custom_accommodation_fields['accommodation_is_self_catered'][0] : 0;

	$accommodation_general_description = $accommodation->post_content;
	$accommodation_general_description = apply_filters('the_content', $accommodation_general_description);
	if ( has_post_thumbnail($accommodation_id)) {
		$accommodation_image = wp_get_attachment_image_src( get_post_thumbnail_id($accommodation_id), 'large');
		$accommodation_image = $accommodation_image[0];
	}
?>
	<!--accommodation-->
	<article class="<?php echo $accommodation_class; ?>">
		<?php if (!empty($accommodation_image)) {
		$permalink = get_permalink();
		if (isset($_GET['from']) || isset($_GET['to'])) {
			$params = array( 
					'from' => urlencode($date_from),
					'to' => urlencode($date_to)
				);
				
			$permalink = add_query_arg($params, $permalink);
		}

		?>
		<figure><a href="<?php echo $permalink; ?>" title="<?php the_title(); ?>"><img src="<?php echo $accommodation_image; ?>" alt="" width="270" height="152" /></a></figure>
		<?php } ?>
		<div class="details">
			<h1><?php the_title(); ?>
				<span class="stars">
				<?php
				$accommodation_star_count = isset($custom_accommodation_fields['accommodation_star_count']) ? intval($custom_accommodation_fields['accommodation_star_count'][0]) : 0;
				for ( $i = 0; $i < $accommodation_star_count; $i++ ) { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/ico/star.png" alt="" />
				<?php } ?>
				</span>
			</h1>
			<?php 
			$accommodation_address = isset($custom_accommodation_fields['accommodation_address']) ? $custom_accommodation_fields['accommodation_address'][0] : '';
			if (!empty($accommodation_address)) { ?>
			<span class="address"><?php echo $accommodation_address; ?></span>
			<?php } ?>
			<?php 
				$reviews_total = isset($custom_accommodation_fields['review_count']) ? intval($custom_accommodation_fields['review_count'][0]) : 0;
				$reviews_possible_score = $reviews_total * count($accommodation_review_fields) * 10;
				$reviews_score = isset($custom_accommodation_fields['review_score']) ? $custom_accommodation_fields['review_score'][0] : 0;
				
				$score_out_of_10 = 0;
				if ($reviews_possible_score > 0) {
					$score_out_of_10 = ceil($reviews_score * 10);
				}
			?>
			<?php if ($score_out_of_10 > 0) { ?>
			<span class="rating"><?php echo $score_out_of_10; ?>/10</span>
			<?php } ?>
			<?php
			$now = time();
			$current_date = date('Y-m-d', $now);
			$price_decimal_places = (int)of_get_option('price_decimal_places', 0);
			$min_price = number_format (get_accommodation_min_price($accommodation_id, $current_date), $price_decimal_places);
			if ($min_price > 0) {
			?>
			<div class="price">
				<?php 
				if (!$accommodation_is_self_catered)
					_e('Price per room per night from ', 'bookyourtravel'); 
				else 
					_e('Price per night from ', 'bookyourtravel'); 
				?>
				<em><span class="curr"><?php echo $currency_symbol; ?></span>
				<span class="amount"><?php echo $min_price; ?></span></em>
			</div>
			<?php } ?>
			<div class="description clearfix ">
				<?php echo substr($accommodation_general_description, 0, strrpos(substr($accommodation_general_description, 0, 60), " ")); ?> <a href="<?php echo $permalink; ?>"><?php _e('More info', 'bookyourtravel'); ?></a>
			</div>
			<a href="<?php echo $permalink; ?>" title="<?php _e('Book now', 'bookyourtravel'); ?>" class="clearfix gradient-button"><?php _e('Book now', 'bookyourtravel'); ?></a>
		</div>
	</article>
	<!--//accommodation-->
<?php ?>