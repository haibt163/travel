<?php
/*	Template Name: Contact Form 7 
  * The template for displaying the contact page using a contact form 7 form.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
 
 get_header('contact'); 
 byt_breadcrumbs();
 get_sidebar('under-header');
 
 $business_address_latitude =  of_get_option('business_address_latitude', '');
 $business_address_longitude =  of_get_option('business_address_longitude', '');
 $contact_phone_number = of_get_option('contact_phone_number', '');
 $contact_email = of_get_option('contact_email', '');
 ?>
 	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	
 	<!--three-fourth content-->
	<section class="three-fourth">
		<h1><?php the_title(); ?></h1>
		<?php if (!empty($business_address_longitude) && !empty($business_address_latitude)) { ?>
		<!--map-->
		<div class="map-wrap">
			<div class="gmap" id="map_canvas"></div>
		</div>
		<!--//map-->
		<?php } ?>
	</section>	
	<!--three-fourth content-->	
	<!--sidebar-->
	<aside class="right-sidebar lower">
		<!--contact form-->
		<article class="default">
			<?php the_content(); ?>
		</article>
		<!--//contact form-->	
<?php if (!empty($contact_phone_number)	|| !empty($contact_email)) { ?>	
		<!--contact info-->
		<article class="default">
			<h2><?php _e('Or contact us directly', 'bookyourtravel'); ?></h2>
			<?php if (!empty($contact_phone_number)) {?><p class="phone-green"><?php echo $contact_phone_number; ?></p><?php } ?>
			<?php if (!empty($contact_email)) {?><p class="email-green"><a href="#"><?php echo $contact_email; ?></a></p><?php } ?>
		</article>
		<!--//contact info-->
<?php } ?>		
	</aside>
	<!--//sidebar-->	
 	<?php endwhile; ?>  
 <?php get_footer(); ?>
