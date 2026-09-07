<?php
/*	Template Name: Contact
 * The template for displaying the contact page.
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
 $business_contact_email = of_get_option('contact_email', '');
 $form_submitted = false;
 $contact_error = '';
 
 if(isset($_POST['contact_submit'])) {
	
	$form_submitted = true;	
	if ( empty($_POST) || !wp_verify_nonce($_POST['contact_form_nonce'],'contact_form') )
	{
	   // failed to verify nonce so exit.
	   exit;
	}
	else
	{
		// process form data since nonce was verified	   
		$contact_message = wp_kses($_POST['contact_message'], '');
		$contact_email = wp_kses($_POST['contact_email'], '');
		$contact_name = wp_kses($_POST['contact_name'], '');
		
		if (!empty($contact_name) &&
			!empty($contact_email) &&
			!empty($contact_message)) {
			
			$emailTo = get_option('admin_email');
			if (!empty($business_contact_email))
				$emailTo = $business_contact_email;
			
			$subject = '[Contact form submit] From ' . $contact_name;
			$body = "Name: $contact_name \n\nEmail: $contact_email \n\nMessage: $contact_message";
			$headers = 'From: '.$contact_name.' <'.$contact_email.'>' . "\r\n" . 'Reply-To: ' . $contact_email;

			wp_mail($emailTo, $subject, $body, $headers);
		} else {
			$contact_error = __('To submit contact form, please enable JavaScript', 'bookyourtravel');
		}
	}
}
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
			<h2><?php _e('Send us a message', 'bookyourtravel'); ?></h2>
			<?php 
			if ($form_submitted) {
				echo '<p>';
				if (!empty($contact_error)) {
					echo $contact_error;
				} else {
					_e('Thank you for contacting us. We will get back to you as soon as we can.', 'bookyourtravel');
				}
				echo '</p>';
			}
			?>
			<?php if (!$form_submitted || !empty($contact_error)) { ?>
			<form action="<?php echo current_page_url(); ?>" id="contact-form" method="post">
				<fieldset>
					<div class="f-item">
						<label for="contact_name"><?php _e('Your name', 'bookyourtravel'); ?></label>
						<input type="text" id="contact_name" name="contact_name" value="" required="required" />
					</div>
					<div class="f-item">
						<label for="contact_email"><?php _e('Your e-mail', 'bookyourtravel'); ?></label>
						<input type="email" id="contact_email" name="contact_email" value="" required="required"  />
					</div>
					<div class="f-item">
						<label for="contact_message"><?php _e('Your message', 'bookyourtravel'); ?></label>
						<textarea name="contact_message" id="contact_message" rows="10" cols="10" required="required"></textarea>
					</div>
					<?php wp_nonce_field('contact_form','contact_form_nonce'); ?>
					<input type="submit" value="<?php _e('Send', 'bookyourtravel'); ?>" id="contact_submit" name="contact_submit" class="gradient-button" />
				</fieldset>
			</form>
			<?php } ?>
		</article>
		<!--//contact form-->		
<?php if (!empty($contact_phone_number)	|| !empty($business_contact_email)) { ?>	
		<!--contact info-->
		<article class="default">
			<h2><?php _e('Or contact us directly', 'bookyourtravel'); ?></h2>
			<?php if (!empty($contact_phone_number)) {?><p class="phone-green"><?php echo $contact_phone_number; ?></p><?php } ?>
			<?php if (!empty($business_contact_email)) {?><p class="email-green"><a href="#"><?php echo $business_contact_email; ?></a></p><?php } ?>
		</article>
		<!--//contact info-->
<?php } ?>	
	</aside>
	<!--//sidebar-->	
 	<?php endwhile; ?> 
 <?php get_footer(); ?>