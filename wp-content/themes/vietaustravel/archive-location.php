<?php
 /*
 * The template for displaying the location list
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */

get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');
global $currency_symbol;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = of_get_option('locations_archive_posts_per_page', 12);
$accommodation_review_fields = list_accommodation_review_fields();
$args = array(
	'posts_per_page'   => $posts_per_page,
	'paged'			   => $page,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_title',
	'order'            => 'DESC',
	'post_type'        => 'location',
	'post_status'      => 'publish'); 

$query = new WP_Query($args); 

$now = time();
$current_date = date('Y-m-d', $now);
?>
<section class="three-fourth bg-tours">
	<div class="list-tours list-localtions">
        <h1><?php _e('Location list', 'bookyourtravel'); ?></h1>
        <div class="destinations clearfix">
        <?php 
        if ( $query->have_posts() ) {
            while ($query->have_posts()) {
                global $post;
                $query->the_post(); 
                $location_class = 'one-fourth';
                include('includes/parts/location-item.php');	
            } // end while ($query->have_posts()) ?>
            <nav class="page-navigation bottom-nav">
                <!--pager-->
                <div class="pager">
                    <?php byt_display_pager($query->max_num_pages); ?>
                </div>
            </nav>
        <?php } // end if ( $query->have_posts() ) ?>
        </div><!--//destinations clearfix-->
    </div>
</section>
 <?php get_sidebar('right'); ?>
<?php
	wp_reset_postdata();
get_footer(); 
?>