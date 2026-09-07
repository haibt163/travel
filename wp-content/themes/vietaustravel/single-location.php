<?php 
get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');

global $currency_symbol;
if ( have_posts() ) {
	the_post();
	global $post;
	$location = $post;
	$location_id = $location->ID;		
	// Get all of this post's custom fields in one trip to the database
	$location_custom_fields = get_post_custom( $location_id);

	$location_country = isset($location_custom_fields['location_country']) ? $location_custom_fields['location_country'][0] : '';
	$location_area = isset($location_custom_fields['location_area']) ? $location_custom_fields['location_area'][0] : '';
	$location_visa_requirements = isset($location_custom_fields['location_visa_requirements']) ? $location_custom_fields['location_visa_requirements'][0] : '';
	$location_languages_spoken = isset($location_custom_fields['location_languages_spoken']) ? $location_custom_fields['location_languages_spoken'][0] : '';
	$location_currency = isset($location_custom_fields['location_currency']) ? $location_custom_fields['location_currency'][0] : '';
	$location_sports_and_nature = isset($location_custom_fields['location_sports_and_nature']) ? $location_custom_fields['location_sports_and_nature'][0] : '';
	$location_nightlife = isset($location_custom_fields['location_nightlife']) ? $location_custom_fields['location_nightlife'][0] : '';
	$location_culture_and_history = isset($location_custom_fields['location_culture_and_history']) ? $location_custom_fields['location_culture_and_history'][0] : '';

	$image_meta = isset($location_custom_fields['location_sports_and_nature_image']) ? $location_custom_fields['location_sports_and_nature_image'][0] : '';
	$temp_image = wp_get_attachment_image_src($image_meta, 'medium');	
	if (count($temp_image) > 0)
		$location_sports_and_nature_image = $temp_image[0];

	$image_meta = isset($location_custom_fields['location_nightlife_image']) ? $location_custom_fields['location_nightlife_image'][0] : '';
	$temp_image = wp_get_attachment_image_src($image_meta, 'medium');	
	if (count($temp_image) > 0)
		$location_nightlife_image = $temp_image[0];

	$image_meta = isset($location_custom_fields['location_culture_and_history_image']) ? $location_custom_fields['location_culture_and_history_image'][0] : '';
	$temp_image = wp_get_attachment_image_src($image_meta, 'medium');	
	if (count($temp_image) > 0)
		$location_culture_and_history_image = $temp_image[0];

	$location_title = $location->post_title; ?>
	<!--three-fourth content-->
	<section class="three-fourth bg-tours">
    	<div class="list-tours localtion">
		<h1><?php echo $location_title; ?></h1>					
		<!--inner navigation-->
		<nav class="inner-nav">
			<ul>
				<li><a href="#general_info" title="<?php _e('General information', 'bookyourtravel'); ?>"><?php _e('General information', 'bookyourtravel'); ?></a></li>
				<?php if (!empty($location_culture_and_history)) { ?>
				<li><a href="#culture" title="<?php _e('Culture and history', 'bookyourtravel'); ?>"><?php _e('Culture and history', 'bookyourtravel'); ?></a></li>
				<?php } ?>
				<li><a href="#tours" title="<?php _e('Tours', 'bookyourtravel'); ?>"><?php _e('Tours', 'bookyourtravel'); ?></a></li>
			</ul>
		</nav>
		<!--//inner navigation-->		
		<!--General information-->
		<section id="general_info" class="tab-content">
			<article>
				<h1><?php echo $location_title; ?></h1>
				<?php 
				$location_image = '';
				if ( has_post_thumbnail($location_id)) {
					$location_image = wp_get_attachment_image_src( get_post_thumbnail_id($location_id), 'large');
					$location_image = $location_image[0];
				} else {
					$location_image = get_template_directory_uri() . '/images/uploads/img.jpg';
				}
				if (!empty($location_image)) { ?>
				<figure class="left_pic"><img src="<?php echo $location_image; ?>" alt="<?php _e('Things to do - general', 'bookyourtravel'); ?>" /></figure>
				<?php } ?>
				<?php the_content(); ?>
				<table>
					<?php if (!empty($location_country)) { ?>
					<tr>
						<th><?php _e('Country', 'bookyourtravel'); ?></th>
						<td><?php echo $location_country; ?></td>
					</tr>
					<?php } ?>
					<?php if (!empty($location_area)) { ?>
					<tr>
						<th><?php _e('Area', 'bookyourtravel'); ?></th>
						<td><?php echo $location_area; ?></td>
					</tr>
					<?php } ?>
					<?php if (!empty($location_languages_spoken)) { ?>
					<tr>
						<th><?php _e('Languages spoken', 'bookyourtravel'); ?></th>
						<td><?php echo $location_languages_spoken; ?></td>
					</tr>
					<?php } ?>
					<?php if (!empty($location_currency)) { ?>
					<tr>
						<th><?php _e('Currency', 'bookyourtravel'); ?></th>
						<td><?php echo $location_currency; ?></td>
					</tr>
					<?php } ?>
					<?php if (!empty($location_visa_requirements)) { ?>
					<tr>
						<th><?php _e('Visa requirements', 'bookyourtravel'); ?></th>
						<td><?php echo $location_visa_requirements; ?></td>
					</tr>
					<?php } ?>
				</table>
			</article>
		</section>
		<!--//General information-->		
		<?php if (!empty($location_sports_and_nature)) { ?>
		<!--Sports and nature-->
		<section id="sports_and_nature" class="tab-content">
			<article>
				<h1><?php _e('Sports and nature', 'bookyourtravel'); ?></h1>
				<?php if (!empty($location_sports_and_nature_image)) { ?>
				<img src="<?php echo $location_sports_and_nature_image; ?>" alt="<?php _e('Sports and nature', 'bookyourtravel'); ?>" />
				<?php } ?>
				<?php echo $location_sports_and_nature; ?>
			</article>
		</section>
		<!--//Sports and nature-->
		<?php } ?>		
		<?php if (!empty($location_nightlife)) { ?>
		<!--Nightlife-->
		<section id="nightlife" class="tab-content">
			<article>
				<h1><?php _e('Nightlife', 'bookyourtravel'); ?></h1>
				<?php if (!empty($location_nightlife_image)) { ?>
				<img src="<?php echo $location_nightlife_image; ?>" alt="<?php _e('Nightlife', 'bookyourtravel'); ?>" />
				<?php } ?>
				<?php echo $location_nightlife; ?>
			</article>
		</section>
		<!--//Nightlife-->
		<?php } ?>		
		<?php if (!empty($location_culture_and_history)) { ?>
		<!--Culture and history-->
		<section id="culture" class="tab-content">
			<article>
				<h1><?php _e('Culture and history', 'bookyourtravel'); ?></h1>
				<?php if (!empty($location_culture_and_history_image)) { ?>
				<img src="<?php echo $location_culture_and_history_image; ?>" alt="<?php _e('Culture &amp; history', 'bookyourtravel'); ?>" />
				<?php } ?>
				<?php echo $location_culture_and_history; ?>
			</article>
		</section>
		<!--//Culture and history-->
		<?php } ?>
		
		<!--Hotels-->
		<section id="hotels" class="tab-content">
			<div class="deals">
			<?php 
			$accommodation_review_fields = list_accommodation_review_fields();
			$hotel_results = list_hotels($location_id);	
			if (count($hotel_results) > 0) {
				foreach ($hotel_results as $hotel_result) {
					global $post;
					$post = $hotel_result;
					setup_postdata( $post ); 
					$accommodation_class = 'full-width';
					include('includes/parts/accommodation-item.php');
				}
			} else { ?>
				<p><?php _e('Unfortunately there are no hotels at this location at the moment.', 'bookyourtravel'); ?></p>
			<?php } ?>
			</div>
		</section>		
		<!--/Hotels-->
		
		<!--Hotels-->
		<section id="self-catered" class="tab-content">
			<div class="deals">
			<?php 
			$self_catetered_accommodations = list_self_catered($location_id);	
			if (count($self_catetered_accommodations) > 0) {
				foreach ($self_catetered_accommodations as $self_catetered_accommodation) {
					global $post;
					$post = $self_catetered_accommodation;
					setup_postdata( $post );
					$accommodation_class = 'full-width';
					include('includes/parts/accommodation-item.php');
				}
				wp_reset_postdata();
			} else { ?>
				<p><?php _e('Unfortunately there are no self-catering offers at this location at the moment.', 'bookyourtravel'); ?></p>
			<?php } ?>
			</div>
		</section>		
		<!--/Hotels-->
		
		<!--Tours-->
		<section id="tours" class="tab-content">
			<div class="deals">
			<?php 
			$tours = list_tours($location_id);	
			if (count($tours) > 0) {
				foreach ($tours as $tour) {
					global $post;
					$post = $tour;
					setup_postdata($post);
					$tour_class = 'full-width';
					include('includes/parts/tour-item.php');
				}
				wp_reset_postdata();
			} else { ?>
				<p><?php _e('Unfortunately there are no tour offers at this location at the moment.', 'bookyourtravel'); ?></p>
			<?php } ?>
			</div>
		</section>		
		<!--/Tours-->
		</div>
	</section>
<?php
} // end if
get_sidebar('right'); 
get_footer(); 
?>