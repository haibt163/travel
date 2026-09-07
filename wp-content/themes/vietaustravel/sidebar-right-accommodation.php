<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */

global $current_user, $accommodation_address, $accommodation_web_site, $accommodation_star_count, $accommodation_title, $accommodation_location_title, $accommodation_description, $accommodation_id, $accommodation_review_fields, $accommodation_custom_fields;

	$reviews_by_current_user_query = list_reviews($accommodation_id, $current_user->ID);
	$all_reviews_query = list_reviews_all($accommodation_id);
?>
	<aside id="secondary" class="right-sidebar widget-area" role="complementary">
		<ul>
			<li>
				<article class="accommodation-details hotel-details clearfix">
					<h1><?php echo $accommodation_title; ?>
						<span class="stars">
							<?php for ($i=0;$i<$accommodation_star_count;$i++) { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/ico/star.png" alt="">
							<?php } ?>
						</span>
					</h1>
					<span class="address"><?php echo $accommodation_address; ?>, <?php echo $accommodation_location_title; ?></span>
					<?php 
						$reviews_total = isset($accommodation_custom_fields['review_count']) ? intval($accommodation_custom_fields['review_count'][0]) : 0;
						$reviews_possible_score = $reviews_total * count($accommodation_review_fields) * 10;
						$reviews_score = isset($accommodation_custom_fields['review_score']) ? $accommodation_custom_fields['review_score'][0] : 0;
						
						$score_out_of_10 = 0;
						if ($reviews_possible_score > 0) {
							$score_out_of_10 = ceil($reviews_score * 10);
						}
					?>
					<?php if ($score_out_of_10 > 0) { ?>
					<span class="rating"><?php echo $score_out_of_10; ?>/10</span>
					<?php } ?>
					<?php if (!empty($accommodation_description)) { ?>
					<div class="description">
						<?php echo substr($accommodation_description, 0, strrpos(substr($accommodation_description, 0, 120), " ")); ?>
					</div>
					<?php } ?>
					<?php 
					if (!$reviews_by_current_user_query->have_posts() && is_user_logged_in()) { ?>
					<a onclick="javascript:void(0);" class="gradient-button right leave-review review_accommodation" title="<?php _e('Leave a review', 'bookyourtravel'); ?>"><?php _e('Leave a review', 'bookyourtravel'); ?></a>
					<?php } ?>
					<?php if (isset($accommodation_custom_fields['accommodation_contact_email'])) { ?>
					<a onclick="javascript:void(0);" class="gradient-button right inquiry_accommodation inquiry_hotel" title="<?php _e('Send inquiry', 'bookyourtravel'); ?>"><?php _e('Send inquiry', 'bookyourtravel'); ?></a>		
					<?php } ?>

				</article>
				
			</li>			

			<li>
				<?php if ($all_reviews_query->have_posts()) { 
						while ($all_reviews_query->have_posts()) { 
						$all_reviews_query->the_post();
						global $post;	
						$likes = get_post_meta($post->ID, 'review_likes', true); 
						$author = get_the_author();
						?>
				<!--testimonials-->
				<article class="testimonials clearfix">
					<blockquote><?php echo $likes; ?></blockquote>
					<span class="name"><?php echo $author; ?></span>
				</article>
				<!--//testimonials-->
				<?php break; } } ?>
			</li>
			
		<?php 
			wp_reset_postdata(); 
			dynamic_sidebar( 'right-accommodation' ); ?>
		</ul>
	</aside><!-- #secondary -->