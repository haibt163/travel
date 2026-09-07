<?php
/*	Template Name: Hotel list
 * The template for displaying the hotel list.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
get_header('accommodation'); 
byt_breadcrumbs();
get_sidebar('under-header');

global $currency_symbol;
$accommodation_review_fields = list_accommodation_review_fields();

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$posts_per_page = of_get_option('accommodations_archive_posts_per_page', 12);

$query = list_paged_hotels($posts_per_page, $paged, 0, 'post_title', 'ASC');
?>
	<section class="full">
		<h1><?php the_title(); ?></h1>
		<div class="deals clearfix">
		<?php 
		if ( $query->have_posts() ) {
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$accommodation_class = 'one-fourth';
				include(locate_template('includes/parts/accommodation-item.php'));
			}
		?>
			<nav class="page-navigation bottom-nav">
				<!--back up button-->
				<a href="#" class="scroll-to-top" title="<?php _e('Back up', 'bookyourtravel'); ?>"><?php _e('Back up', 'bookyourtravel'); ?></a> 
				<!--//back up button-->
				<!--pager-->
				<div class="pager">
					<?php byt_display_pager($query->max_num_pages); ?>
				</div>
			</nav>
		<?php } // end if ( $query->have_posts() ) ?>
		</div><!--//deals clearfix-->
	</section>
<?php
	wp_reset_postdata();
	wp_reset_query();
get_footer(); 
?>