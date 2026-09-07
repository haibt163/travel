<?php
	global $post, $currency_symbol, $tour_review_fields;
	$tour_id = $post->ID;
	$tour = $post;
	$tour_image = '';
	$custom_tour_fields = get_post_custom( $tour_id);
	
	$tour_location_title = '';
	$tour_location = null;
	if (isset($custom_tour_fields['tour_location_post_id'])) {
		$location_id = $custom_tour_fields['tour_location_post_id'][0];
		$tour_location = get_post($location_id);
		if ($tour_location)
			$tour_location_title = $tour_location->post_title;
	}
	
	$tour_general_description = $tour->post_excerpt;
	$tour_general_description = apply_filters('the_content', $tour_general_description);
	if ( has_post_thumbnail($tour_id)) {
		$tour_image = wp_get_attachment_image_src( get_post_thumbnail_id($tour_id), 'large');
		$tour_image = $tour_image[0];
	}
?>
	<!--tour-->
	<article class="<?php echo $tour_class; ?> clearfix">
	    <h1><?php the_title(); ?></h1>
		<span class="address">(<?php echo $tour_location_title; ?>)</span>
        <div class="content-tour clearfix">
		<?php if (!empty($tour_image)) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="img-tour"><img src="<?php echo $tour_image; ?>" alt="" width="270" height="152" /></a>
		<?php } ?>
		<div class="details">
			<?php 
				$reviews_total = isset($custom_tour_fields['review_count']) ? intval($custom_tour_fields['review_count'][0]) : 0;
				$reviews_possible_score = $reviews_total * count($tour_review_fields) * 10;
				$reviews_score = isset($custom_tour_fields['review_score']) ? $custom_tour_fields['review_score'][0] : 0;
				
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
			$min_price = number_format (get_tour_min_price($tour_id, $current_date), $price_decimal_places);
			if ($min_price > 0) {
			?>
			<div class="price">
				<?php 
					_e('Price per person from ', 'bookyourtravel'); 
				?>
				<em><span class="curr"><?php echo $currency_symbol; ?></span>
				<span class="amount"><?php echo $min_price; ?></span></em>
			</div>
			<?php } ?>
			<div class="clearfix">
				<?php echo $tour_general_description; ?> 
                <a href="<?php the_permalink(); ?>" title="<?php _e('More detail', 'bookyourtravel'); ?>" class="clearfix gradient-button"><?php _e('More detail', 'bookyourtravel'); ?></a>
			</div>
			
		</div>
        </div>
	</article>
	<!--//tour-->
<?php ?>