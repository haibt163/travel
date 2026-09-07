<?php 
get_header('accommodation'); 
byt_breadcrumbs();
get_sidebar('under-header');


global $post, $review_maximum_score, $tour_date_from, $tour_title, $current_user,$tour_location_title, $tour_description, $tour_id, $tour_review_fields, $tour_custom_fields;

global $currency_symbol;
$current_user = wp_get_current_user();

if ( have_posts() ) {
	the_post();
	$tour = $post;
	$tour_id = $tour->ID;
	
	$tour_description = $tour->post_content;
	$tour_description = apply_filters('the_content', $tour_description);
	
		
	// Get all of this post's custom fields in one trip to the database
	$tour_custom_fields = get_post_custom( $tour_id);
	
	$tour_title = $tour->post_title;
	$tour_images = isset($tour_custom_fields['tour_images']) ? $tour_custom_fields['tour_images'][0] : '';
	$tour_map_code = isset($tour_custom_fields['tour_map_code']) ? $tour_custom_fields['tour_map_code'][0] : '';
	$tour_price_now = isset($tour_custom_fields['tour_price_now']) ? $tour_custom_fields['tour_price_now'][0] : '';
	$tour_availability_extra_info = isset($tour_custom_fields['tour_availability_extra_info']) ? $tour_custom_fields['tour_availability_extra_info'][0] : '';
	
	// get current time to be used with fetching vacancies if no querystring parameters provided
	$now = time();
	$date = date('Y-m-d', $now);

	$tour_date_from = $date;
	$tour_date_from = date('Y-m-d', strtotime("+1 day", $now));
	
	// retrieve from and to dates from querystring if provided
	if (isset($_GET['from']) || isset($_GET['to'])) {
		parse_str(urldecode($_SERVER['QUERY_STRING']), $get_array);
		if (isset($get_array['from']))
			$tour_date_from = date('Y-m-d', strtotime($get_array['from']));
	}
	
	$tour_location = null;
	if (isset($tour_custom_fields['tour_location_post_id'])) {
		$location_id = $tour_custom_fields['tour_location_post_id'][0];
		$tour_location = get_post($location_id);
		if ($tour_location)
			$tour_location_title = $tour_location->post_title;
	}
	
	$tour_review_fields = list_tour_review_fields();
	
	// include various forms (booking, review, confirmation, dates)
	if (is_user_logged_in()) 
		get_template_part('includes/parts/tour', 'review-form'); 
	?>
		
	<!--tour three-fourth content-->
	<section class="three-fourth bg-tours">
    <div class="list-tours">
	<?php
	get_template_part('includes/parts/tour', 'booking-form');
	get_template_part('includes/parts/tour', 'confirmation-form');
	?>	
	<script>
		window.reviewFields = new Array();
		<?php if (count($tour_review_fields) > 0) { 
		foreach ($tour_review_fields as $field_key=>$field_label) {
		?>
		reviewFields.push("<?php echo $field_key; ?>");
		<?php }
		} ?>
		window.tourId = <?php echo $tour_id; ?>;
		window.formSingleError = '<?php _e('You failed to provide 1 field. It has been highlighted below.', 'bookyourtravel'); ?>';
		window.formMultipleError = '<?php _e('You failed to provide {0} fields. They have been highlighted below.', 'bookyourtravel');  ?>';
		window.tourDateFrom = '<?php echo $tour_date_from; ?>';
		window.tourTitle = '<?php echo $tour_title; ?>';
		window.reviewFormLikesError = '<?php _e('Please enter your likes', 'bookyourtravel'); ?>';
		window.reviewFormDislikesError = '<?php _e('Please enter your dislikes', 'bookyourtravel'); ?>';
		window.bookingFormFirstNameError = '<?php _e('Please enter your first name', 'bookyourtravel'); ?>';
		window.bookingFormLastNameError = '<?php _e('Please enter your last name', 'bookyourtravel'); ?>';
		window.bookingFormEmailError = '<?php _e('Please enter valid email address', 'bookyourtravel'); ?>';
		window.bookingFormConfirmEmailError1 = '<?php _e('Please provide a confirm email', 'bookyourtravel'); ?>';
		window.bookingFormConfirmEmailError2 = '<?php _e('Please enter the same email as above', 'bookyourtravel'); ?>';
		window.bookingFormAddressError = '<?php _e('Please enter your address', 'bookyourtravel'); ?>';
		window.bookingFormCityError = '<?php _e('Please enter your city', 'bookyourtravel'); ?>';		
		window.bookingFormZipError = '<?php _e('Please enter your zip code', 'bookyourtravel'); ?>';		
		window.bookingFormCountryError = '<?php _e('Please enter your country', 'bookyourtravel'); ?>';	

	</script>
	<?php if (count($tour_images) > 0) { ?>
	<!--gallery-->
	<section class="gallery" id="crossfade">
	<?php 
	$image_array = unserialize($tour_images);
	for ( $i = 0; $i < count($image_array); $i++ ) { 
		$image_meta_id = $image_array[$i]['image'];
		$image_src = wp_get_attachment_image_src($image_meta_id, 'full');	
		$image_src = $image_src[0];
		if (!empty($image_src)) { 
			echo '<img src="' . $image_src . '" alt="" width="850" height="531" />';
		}
	}?>
	</section>
	<!--//gallery-->
	<?php } ?>
    
    <div class="clearfix" style="background:#F9F9F9; border:1px solid #DDD;">    
	    <form id="launch-tour-booking" action="#" method="POST">
			<?php 
			$price_decimal_places = (int)of_get_option('price_decimal_places', 0);
			$schedule_entries = list_available_tour_schedule_entries($tour_id, $tour_date_from);
			if (count($schedule_entries) > 0) {
				foreach ($schedule_entries as $schedule_entry) {
					$tour_price = number_format($schedule_entry->price, $price_decimal_places);
					$start_date = date('Y-m-d', strtotime($schedule_entry->start_date));
				?>
				<div class="f-item">
					<input type="radio" name="schedule_radio" id="schedule_<?php echo $schedule_entry->Id; ?>_radio" value="<?php echo $schedule_entry->Id; ?>" checked="checked" style="display:"/>
					<label for="schedule_<?php echo $schedule_entry->Id; ?>_price">
						<div class="row">
							<span class="first"><?php echo $start_date; ?><input type="hidden" value="<?php echo $start_date; ?>" id="schedule_<?php echo $schedule_entry->Id; ?>_date" name="schedule_<?php echo $schedule_entry->Id; ?>_date" /></span>
							<span class="second"><?php echo $schedule_entry->duration_days; ?><?php _e('days', 'bookyourtravel'); ?></span>
							<span class="third price">
								<em><span class="curr"><?php echo $currency_symbol; ?></span>
								<span class="amount"><?php echo $tour_price; ?></span></em>
								<input type="hidden" id="schedule_<?php echo $schedule_entry->Id; ?>_price" class="tour_price" value="<?php echo $tour_price; ?>" />
							</span>
						</div>
					</label>
				</div>
				<?php
				}
				echo '<p class="info">' . $tour_availability_extra_info . '</p>';
			} else { 
				echo __('Unfortunately, no places are available on this tour at the moment', 'bookyourtravel');			
			}
			?>
				<a style="display:block !important" class="gradient-button " title="<?php echo __('Book', 'bookyourtravel'); ?>" href="#" id="book-tour"><?php echo __('Book', 'bookyourtravel'); ?></a>
			</form>             
    </div>
	<?php if (!empty($tour_map_code)) { ?>
        <!--map-->
        <div class="gmap" style="width:auto; margin-top:15px; border:none; height:320px;"><?php echo $tour_map_code; ?></div>
        <!--//map-->
	<?php } // endif (!empty($tour_map_code)) ?>    
	<!--inner navigation-->
   
    <!--description-->
	<?php 
    if (!empty($tour_description)) { ?>
    <div class="text-wrap" style="margin-top:15px;">	
        <?php echo $tour_description; ?>
    </div>
    <?php } // endif (!empty($accommodation_general_description)) ?>
    
	<!--reviews-->
	<section id="reviews" class="tab-content">
		<?php
		$reviews_total = isset($tour_custom_fields['review_count']) ? intval($tour_custom_fields['review_count'][0]) : 0;
		if ($reviews_total > 0) {
		?>
		<article class="clearfix">
			<h1><?php _e('Tour score and score breakdown', 'bookyourtravel'); ?></h1>
			<div class="score">
			<?php 
				$reviews_possible_score = $reviews_total * count($tour_review_fields) * 10;
				$reviews_score = isset($tour_custom_fields['review_score']) ? $tour_custom_fields['review_score'][0] : 0;
				
				$score_out_of_10 = 0;
				if ($reviews_possible_score > 0) {
					$score_out_of_10 = ceil($reviews_score * 10);
				}
			?>
				<span class="achieved"><?php echo $score_out_of_10; ?></span>
				<span>/ 10</span>
				<p class="info"><?php _e(sprintf('Based on %d reviews', $reviews_total), 'bookyourtravel'); ?></p>
				<p class="disclaimer"><?php _e(sprintf('Guest reviews are written by our customers <strong>after their tour</strong> of %s.', $tour_title), 'bookyourtravel'); ?></p>
			</div>
		
			<dl class="chart">
				<?php 
					$total_possible = $reviews_total * 10;				
					$overall = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_overall') / $total_possible) * 10 : 0);
					$accommodation = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_accommodation') / $total_possible) * 10 : 0);
					$transport = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_transport') / $total_possible) * 10 : 0);
					$meals = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_meals') / $total_possible) * 10 : 0);
					$guide = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_guide') / $total_possible) * 10 : 0);
					$value_for_money = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_value_for_money') / $total_possible) * 10 : 0);
					$program_accuracy = intval($total_possible > 0 ? (sum_review_meta_values($tour_id, 'review_program_accuracy') / $total_possible) * 10 : 0);
					?>
				<dt><?php _e('Overall', 'bookyourtravel');?></dt>
				<dd><span id="data-one" style="width:<?php echo $overall * 10; ?>%;"><?php echo $overall; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Accommodation', 'bookyourtravel');?></dt>
				<dd><span id="data-two" style="width:<?php echo $accommodation * 10; ?>%;"><?php echo $accommodation; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Transport', 'bookyourtravel');?></dt>
				<dd><span id="data-three" style="width:<?php echo $transport * 10; ?>%;"><?php echo $transport; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Meals', 'bookyourtravel');?></dt>
				<dd><span id="data-four" style="width:<?php echo $meals * 10; ?>%;"><?php echo $meals; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Guide', 'bookyourtravel');?></dt>
				<dd><span id="data-five" style="width:<?php echo $guide * 10; ?>%;"><?php echo $guide; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Value for money', 'bookyourtravel');?></dt>
				<dd><span id="data-six" style="width:<?php echo $value_for_money * 10; ?>%;"><?php echo $value_for_money; ?>&nbsp;&nbsp;&nbsp;</span></dd>
				<dt><?php _e('Program accuracy', 'bookyourtravel');?></dt>
				<dd><span id="data-seven" style="width:<?php echo $program_accuracy * 10; ?>%;"><?php echo $program_accuracy; ?>&nbsp;&nbsp;&nbsp;</span></dd>
			</dl>
		</article>
		<article class="clearfix">
			<h1><?php _e('Guest reviews', 'bookyourtravel');?></h1>
			<ul class="reviews">
				<!--review-->
				<?php
				$reviews_query = list_reviews_all($tour_id);
				while ($reviews_query->have_posts()) : 
					global $post;
					$reviews_query->the_post();
				?>
				<li>
					<figure class="left"><?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?></figure>
					<address><span><?php the_author(); ?></span><br /><?php echo get_the_date('Y-m-d'); ?><br /><br /></address>
					<div class="pro"><p><?php echo get_post_meta($post->ID, 'review_likes', true); ?></p></div>
					<div class="con"><p><?php echo get_post_meta($post->ID, 'review_dislikes', true); ?></p></div>
				</li>
				<!--//review-->
				<?php endwhile; 
					// Reset Second Loop Post Data
					wp_reset_postdata(); 
				?>
			</ul>
		</article>
		<?php } else { ?>
			<article>
			<h3><?php _e('We are sorry, there are no reviews yet for this tour.', 'bookyourtravel'); ?></h3>
			</article>
	<?php } ?>
		</section>
		<!--//reviews-->
        </div>
	</section>
	<!--//tour content-->	
<?php
} // end if

get_sidebar('right-tour'); 
get_footer(); 
?>
