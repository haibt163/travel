<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');

$contact_page_url_id = of_get_option('contact_page_url', '');
$contact_page_url = get_permalink($contact_page_url_id);

?>	
	<section class="error bg-tours clearfix" style="margin-bottom:25px;">
		<!--Error type-->
		<div class="error-type">
			<h1><?php _e( '404', 'bookyourtravel'); ?></h1>
			<p><?php _e( 'Page not found', 'bookyourtravel'); ?></p>
		</div>
		<!--//Error type-->
		
		<!--Error content-->
		<div class="error-content">
			<h2><?php _e( 'Whoops, you are in the middle of nowhere.', 'bookyourtravel'); ?></h2>
			<h3><?php _e( 'Don’t worry. You’ve probably made a wrong turn somewhwere.', 'bookyourtravel'); ?></h3>
			<ul>
				<li><?php _e( 'If you typed in the address, check your spelling. Could just be a typo.', 'bookyourtravel'); ?></li>
				<li><?php printf(__('If you followed a link, it’s probably broken. Please <a href="%s">contact us</a> and we’ll fix it.', 'bookyourtravel'), $contact_page_url); ?></li>
				<li><?php printf(__( 'If you’re not sure what you’re looking for, go back to <a href="%s">homepage</a>.', 'bookyourtravel'), get_home_url()); ?></li>
			</ul>
		</div>
		<!--//Error content-->
	</section>
<?php get_footer(); ?>