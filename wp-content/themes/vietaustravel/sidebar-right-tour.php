<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */

global $post, $review_maximum_score, $tour_review_fields, $tour_date_from, $tour_title, $current_user, $tour_location_title, $tour_description, $tour_id, $tour_review_fields, $tour_custom_fields;
 
	$reviews_by_current_user_query = list_reviews($tour_id, $current_user->ID);
	$all_reviews_query = list_reviews_all($tour_id);
?>
	<aside id="secondary" class="right-sidebar widget-area" role="complementary">
		<ul>
			<li>
				<article class="tour-details clearfix">
					<h1><?php echo $tour_title; ?></h1>
					<span class="address"><?php echo $tour_location_title; ?></span>
					<?php 
						$reviews_total = isset($tour_custom_fields['review_count']) ? intval($tour_custom_fields['review_count'][0]) : 0;
						$reviews_possible_score = $reviews_total * count($tour_review_fields) * 10;
						$reviews_score = isset($tour_custom_fields['review_score']) ? $tour_custom_fields['review_score'][0] : 0;
						
						$score_out_of_10 = 0;
						if ($reviews_possible_score > 0) {
							$score_out_of_10 = ceil($reviews_score * 10);
						}
					?>
					<?php if ($score_out_of_10 > 0) { ?>
					<span class="rating"><?php echo $score_out_of_10; ?>/10</span>
					<?php } ?>
					<?php if (!empty($tour_description)) { ?>
					<div class="description">
						<?php echo substr($tour_description, 0, strrpos(substr($tour_description, 0, 120), " ")); ?>
					</div>
					<?php } ?>
					<?php 
					if (!$reviews_by_current_user_query->have_posts() && is_user_logged_in()) { ?>
					<a onclick="javascript:void(0);" class="gradient-button right leave-review review_tour" title="<?php _e('Leave a review', 'bookyourtravel'); ?>"><?php _e('Leave a review', 'bookyourtravel'); ?></a>
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
			dynamic_sidebar( 'right-tour' ); ?>
		</ul>
	</aside><!-- #secondary -->