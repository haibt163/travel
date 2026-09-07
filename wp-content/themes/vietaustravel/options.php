<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$byt_settings = get_option( 'byt_options' );
	$byt_settings['id'] = $themename;
	update_option( 'byt_options', $byt_settings );
}
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'bookyourtravel'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
function optionsframework_options() {

	$color_scheme_array = array(
		'' => __('Default', 'bookyourtravel'),
		'theme-black' => __('Black', 'bookyourtravel'),
		'theme-blue' => __('Blue', 'bookyourtravel'),
		'theme-orange' => __('Orange', 'bookyourtravel'),
		'theme-pink' => __('Pink', 'bookyourtravel'),
		'theme-purple' => __('Purple', 'bookyourtravel'),
		'theme-strawberry' => __('Strawberry', 'bookyourtravel'),
		'theme-yellow' => __('Yellow', 'bookyourtravel'),
		'theme-navy' => __('Navy', 'bookyourtravel'),
	);
		
	$pages = get_pages(); 
	$pages_array = array();
	$pages_array[0] = __('Select page', 'bookyourtravel');
	foreach ( $pages as $page ) {
		$pages_array[$page->ID] = $page->post_title;
	}
	
	$price_decimals_array = array(
		'0' => __('Zero (e.g. $200)', 'bookyourtravel'),
		'1' => __('One  (e.g. $200.0)', 'bookyourtravel'),
		'2' => __('Two (e.g. $200.00)', 'bookyourtravel'),
	);
	
	$search_results_view_array = array(
		'0' => __('Grid view', 'bookyourtravel'),
		'1' => __('List view', 'bookyourtravel'),
	);	
	
	$options = array();

	$options[] = array(
		'name' => __('Basic settings', 'bookyourtravel'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Website logo', 'bookyourtravel'),
		'desc' => __('Upload your website logo to go in place of default theme logo.', 'bookyourtravel'),
		'id' => 'website_logo_upload',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Select color scheme', 'bookyourtravel'),
		'desc' => __('Select website color scheme.', 'bookyourtravel'),
		'id' => 'color_scheme_select',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $color_scheme_array);

	$options[] = array(
		'name' => __('Company info', 'bookyourtravel'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Company name', 'bookyourtravel'),
		'desc' => __('Company name displayed on the contact us page.', 'bookyourtravel'),
		'id' => 'contact_company_name',
		'std' => 'Book Your Travel LLC',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Contact phone number', 'bookyourtravel'),
		'desc' => __('Contact phone number displayed on the site.', 'bookyourtravel'),
		'id' => 'contact_phone_number',
		'std' => '1- 555 - 555 - 555',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Contact address street', 'bookyourtravel'),
		'desc' => __('Contact address street displayed on the contact us page.', 'bookyourtravel'),
		'id' => 'contact_address_street',
		'std' => '1400 Pennsylvania Ave',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Contact address city', 'bookyourtravel'),
		'desc' => __('Contact address city displayed on the contact us page.', 'bookyourtravel'),
		'id' => 'contact_address_city',
		'std' => 'Washington DC',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Contact address country', 'bookyourtravel'),
		'desc' => __('Contact address country displayed on the contact us page.', 'bookyourtravel'),
		'id' => 'contact_address_country',
		'std' => 'USA',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Contact email', 'bookyourtravel'),
		'desc' => __('Contact email displayed on the contact us page.', 'bookyourtravel'),
		'id' => 'contact_email',
		'std' => 'info at bookyourtravel',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Business address latitude', 'bookyourtravel'),
		'desc' => __('Enter your business address latitude to use for contact form map', 'bookyourtravel'),
		'id' => 'business_address_latitude',
		'std' => '49.47216',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Business address longitude', 'bookyourtravel'),
		'desc' => __('Enter your business address longitude to use for contact form map', 'bookyourtravel'),
		'id' => 'business_address_longitude',
		'std' => '-123.76307',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Footer copyright notice', 'bookyourtravel'),
		'desc' => __('Copyright notice in footer.', 'bookyourtravel'),
		'id' => 'copyright_footer',
		'std' => '&copy; bookyourtravel.com 2013. All rights reserved.',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Data', 'bookyourtravel'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Locations permalink slug', 'bookyourtravel'),
		'desc' => __('The permalink slug used for creating links for location archives and single locations (by default it is set to "locations". <br /><strong>Note:</strong> Please make sure you flush your rewrite rules after changing this setting. You can do so by navigating to <a href="/wp-admin/options-permalink.php">Settings->Permalinks</a> and clicking "Save Changes".', 'bookyourtravel'),
		'id' => 'locations_permalink_slug',
		'std' => 'locations',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Locations archive posts per page', 'bookyourtravel'),
		'desc' => __('Number of locations to display on locations archive page', 'bookyourtravel'),
		'id' => 'locations_archive_posts_per_page',
		'std' => '12',
		'type' => 'text');

	$options[] = array(
		'name' => __('Enable Car rentals', 'bookyourtravel'),
		'desc' => __('Enable "Car rentals" data-type', 'bookyourtravel'),
		'id' => 'enable_car_rentals',
		'std' => '1',
		'type' => 'checkbox');	
		
	$options[] = array(
		'name' => __('Car rentals archive posts per page', 'bookyourtravel'),
		'desc' => __('Number of car rentals to display on car rentals archive page', 'bookyourtravel'),
		'id' => 'car_rentals_archive_posts_per_page',
		'std' => '12',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Enable Tours', 'bookyourtravel'),
		'desc' => __('Enable "Tours" data-type', 'bookyourtravel'),
		'id' => 'enable_tours',
		'std' => '1',
		'type' => 'checkbox');	
		
	$options[] = array(
		'name' => __('Tours archive posts per page', 'bookyourtravel'),
		'desc' => __('Number of tours to display on tours archive page', 'bookyourtravel'),
		'id' => 'tours_archive_posts_per_page',
		'std' => '12',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Tours permalink slug', 'bookyourtravel'),
		'desc' => __('The permalink slug used for creating links for tour archives and single tour (by default it is set to "tours". <br /><strong>Note:</strong> Please make sure you flush your rewrite rules after changing this setting. You can do so by navigating to <a href="/wp-admin/options-permalink.php">Settings->Permalinks</a> and clicking "Save Changes".', 'bookyourtravel'),
		'id' => 'tours_permalink_slug',
		'std' => 'tours',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Enable Accommodations', 'bookyourtravel'),
		'desc' => __('Enable "Accommodations" data-type', 'bookyourtravel'),
		'id' => 'enable_accommodations',
		'std' => '1',
		'type' => 'checkbox');	

	$options[] = array(
		'name' => __('Search only available accommodations', 'bookyourtravel'),
		'desc' => __('Search displays only accommodations with valid vacancies', 'bookyourtravel'),
		'id' => 'search_only_available_accommodations',
		'std' => '1',
		'type' => 'checkbox');	
		
	$options[] = array(
		'name' => __('Price decimal places', 'bookyourtravel'),
		'desc' => __('Number of decimal places to show for prices', 'bookyourtravel'),
		'id' => 'price_decimal_places',
		'std' => '0',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $price_decimals_array);
		
	$options[] = array(
		'name' => __('Accommodations permalink slug', 'bookyourtravel'),
		'desc' => __('The permalink slug used for creating links for accommodation archives and single accommodation (by default it is set to "accommodations". <br /><strong>Note:</strong> Please make sure you flush your rewrite rules after changing this setting. You can do so by navigating to <a href="/wp-admin/options-permalink.php">Settings->Permalinks</a> and clicking "Save Changes".', 'bookyourtravel'),
		'id' => 'accommodations_permalink_slug',
		'std' => 'hotels',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Accommodations archive posts per page', 'bookyourtravel'),
		'desc' => __('Number of accommodations to display on accommodations archive page', 'bookyourtravel'),
		'id' => 'accommodations_archive_posts_per_page',
		'std' => '12',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Accommodations search posts per page', 'bookyourtravel'),
		'desc' => __('Number of accommodations to display on custom search page', 'bookyourtravel'),
		'id' => 'accommodations_search_posts_per_page',
		'std' => '12',
		'type' => 'text');
		
	global $currencies;
		
	// Multicheck Defaults
	$currency_defaults = array(
		'usd' => '1',
		'eur' => '1',
		'gbp' => '1'
	);
		
	$currencies_array = array();
	foreach ($currencies as $currency) {
		$currencies_array[$currency->currency_code] = __($currency->currency_label, 'bookyourtravel');
	}
		
	$options[] = array(
		'name' => __('Enable currencies', 'bookyourtravel'),
		'desc' => __('Enable website currencies', 'bookyourtravel'),
		'id' => 'enabled_currencies',
		'std' => $currency_defaults,
		'type' => 'multicheck',
		'class' => 'small', //mini, tiny, small
		'options' => $currencies_array);				
		
	$options[] = array(
		'name' => __('Select default currency', 'bookyourtravel'),
		'desc' => __('Select website default currency.', 'bookyourtravel'),
		'id' => 'default_currency_select',
		'std' => 'usd',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $currencies_array);
		
	$options[] = array(
		'name' => __('WP Settings', 'bookyourtravel'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Override wp-login.php', 'bookyourtravel'),
		'desc' => __('Override wp-login.php and use custom login, register, forgot password pages', 'bookyourtravel'),
		'id' => 'override_wp_login',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Users specify password', 'bookyourtravel'),
		'desc' => __('Let users specify their password when registering', 'bookyourtravel'),
		'id' => 'let_users_set_pass',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Send user confirmation email', 'bookyourtravel'),
		'desc' => __('Require users to confirm their registration by clicking link in email', 'bookyourtravel'),
		'id' => 'require_confirmation',
		'std' => '0',
		'type' => 'checkbox');
	
	
	$options[] = array(
		'name' => __('My account dashboard page', 'bookyourtravel'),
		'desc' => __('Page that displays settings, bookings and reviews of logged in user', 'bookyourtravel'),
		'id' => 'my_account_page_id',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
	
	$options[] = array(
		'name' => __('Redirect to after login', 'bookyourtravel'),
		'desc' => __('Page to redirect to after login if "Override wp-login.php" is checked above', 'bookyourtravel'),
		'id' => 'redirect_to_after_login',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('Redirect to after logout', 'bookyourtravel'),
		'desc' => __('Page to redirect to after logout if "Override wp-login.php" is checked above', 'bookyourtravel'),
		'id' => 'redirect_to_after_logout',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);

	$options[] = array(
		'name' => __('Login page url', 'bookyourtravel'),
		'desc' => __('Login page if "Override wp-login.php" is checked above', 'bookyourtravel'),
		'id' => 'login_page_url',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('Register page url', 'bookyourtravel'),
		'desc' => __('Register page if "Override wp-login.php" is checked above', 'bookyourtravel'),
		'id' => 'register_page_url',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('Reset password page url', 'bookyourtravel'),
		'desc' => __('Reset password page if "Override wp-login.php" is checked above', 'bookyourtravel'),
		'id' => 'reset_password_page_url',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('Terms &amp; conditions page url', 'bookyourtravel'),
		'desc' => __('Terms &amp; conditions page url', 'bookyourtravel'),
		'id' => 'terms_page_url',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('Contact Us page url', 'bookyourtravel'),
		'desc' => __('Contact Us page url', 'bookyourtravel'),
		'id' => 'contact_page_url',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);
		
	$options[] = array(
		'name' => __('BYT Home page', 'bookyourtravel'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Show top locations', 'bookyourtravel'),
		'desc' => __('Show "top destinations" on home page', 'bookyourtravel'),
		'id' => 'show_top_locations',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('"Top destinations" count', 'bookyourtravel'),
		'desc' => __('Number of "Top destinations" to show', 'bookyourtravel'),
		'id' => 'top_destinations_count',
		'std' => '4',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Show accommodation offers', 'bookyourtravel'),
		'desc' => __('Show "accommodation offers" on home page', 'bookyourtravel'),
		'id' => 'show_accommodation_offers',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('"Latest accommodations" count', 'bookyourtravel'),
		'desc' => __('Number of "Latest accommodations" to show', 'bookyourtravel'),
		'id' => 'latest_accommodations_count',
		'std' => '4',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show tour offers', 'bookyourtravel'),
		'desc' => __('Show "tour offers" on home page', 'bookyourtravel'),
		'id' => 'show_tour_offers',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('"Latest tour" count', 'bookyourtravel'),
		'desc' => __('Number of "Latest tour" to show', 'bookyourtravel'),
		'id' => 'latest_tours_count',
		'std' => '4',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Show latest offers', 'bookyourtravel'),
		'desc' => __('Show "latest offers" blog posts on home page', 'bookyourtravel'),
		'id' => 'show_latest_offers_posts',
		'std' => '0',
		'type' => 'checkbox');
		
	$categories = get_categories(''); 
	$categories_array = array('' => __('Select category', 'bookyourtravel'));
	foreach ($categories as $category) {
		$categories_array[$category->term_id] = $category->cat_name;
	}
		
	$options[] = array(
		'name' => __('"Latest offers" category', 'bookyourtravel'),
		'desc' => __('"Latest offers" blog posts category', 'bookyourtravel'),
		'id' => 'latest_offers_category',
		'std' => '',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $categories_array);
		
	$options[] = array(
		'name' => __('"Latest offers" count', 'bookyourtravel'),
		'desc' => __('Number of "Latest offers" blog posts to show', 'bookyourtravel'),
		'id' => 'latest_offers_count',
		'std' => '4',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Show slider', 'bookyourtravel'),
		'desc' => __('Show slider on home page', 'bookyourtravel'),
		'id' => 'frontpage_show_slider',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Slider speed', 'bookyourtravel'),
		'desc' => __('The duration in milliseconds at which frames should remain on screen before animating to the next.', 'bookyourtravel'),
		'id' => 'slider_speed',
		'std' => '1000',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Search results page', 'bookyourtravel'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Enable tour search', 'bookyourtravel'),
		'desc' => __('Enable tour search feature', 'bookyourtravel'),
		'id' => 'enable_tour_search',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Enable hotel search', 'bookyourtravel'),
		'desc' => __('Enable hotel search feature', 'bookyourtravel'),
		'id' => 'enable_hotel_search',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Enable self-catered search', 'bookyourtravel'),
		'desc' => __('Enable self-catered search feature', 'bookyourtravel'),
		'id' => 'enable_self_catered_search',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Enable car rental search', 'bookyourtravel'),
		'desc' => __('Enable car rental search feature', 'bookyourtravel'),
		'id' => 'enable_car_rental_search',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Custom search results page', 'bookyourtravel'),
		'desc' => __('Page to redirect to for custom search results', 'bookyourtravel'),
		'id' => 'redirect_to_search_results',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pages_array);

	$options[] = array(
		'name' => __('Custom search results default view', 'bookyourtravel'),
		'desc' => __('Custom search results default view (grid or list view)', 'bookyourtravel'),
		'id' => 'search_results_default_view',
		'std' => '0',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $search_results_view_array);
		
	$options[] = array(
		'name' => __('Price range bottom', 'bookyourtravel'),
		'desc' => __('Bottom value of price range used in search form (usually 0)', 'bookyourtravel'),
		'id' => 'price_range_bottom',
		'std' => '0',
		'type' => 'text',
		'class' => 'mini');

	$options[] = array(
		'name' => __('Price range increment', 'bookyourtravel'),
		'desc' => __('Increment value of price range used in search form (default 50)', 'bookyourtravel'),
		'id' => 'price_range_increment',
		'std' => '50',
		'type' => 'text',
		'class' => 'mini');

	$options[] = array(
		'name' => __('Price range increment count', 'bookyourtravel'),
		'desc' => __('Increment count of price range used in search form (default 5)', 'bookyourtravel'),
		'id' => 'price_range_count',
		'std' => '5',
		'type' => 'text',
		'class' => 'mini');
		
	return $options;
}
/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>
<?php
}