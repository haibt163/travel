<?php
/**
 * Book Your Travel functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
 
/* 
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
 
 
if ( ! defined( 'BOOKYOURTRAVEL_VERSION' ) )
    define( 'BOOKYOURTRAVEL_VERSION', '1.57' );
	   
if ( ! defined( 'BYT_VACANCIES_TABLE' ) )
    define( 'BYT_VACANCIES_TABLE', $wpdb->prefix . 'byt_vacancies' );

if ( ! defined( 'BYT_CURRENCIES_TABLE' ) )
    define( 'BYT_CURRENCIES_TABLE', $wpdb->prefix . 'byt_currencies' );
	
if ( ! defined( 'BYT_BOOKINGS_TABLE' ) )
    define( 'BYT_BOOKINGS_TABLE', $wpdb->prefix . 'byt_bookings' );	
	
if ( ! defined( 'BYT_VACANCY_BOOKINGS_TABLE' ) )
    define( 'BYT_VACANCY_BOOKINGS_TABLE', $wpdb->prefix . 'byt_vacancy_bookings' );	
	
if ( ! defined( 'BYT_CAR_RENTAL_BOOKINGS_TABLE' ) )
    define( 'BYT_CAR_RENTAL_BOOKINGS_TABLE', $wpdb->prefix . 'byt_car_rental_bookings' );	
	
if ( ! defined( 'BYT_CAR_RENTAL_BOOKING_DAYS_TABLE' ) )
    define( 'BYT_CAR_RENTAL_BOOKING_DAYS_TABLE', $wpdb->prefix . 'byt_car_rental_booking_days' );
	
if ( ! defined( 'BYT_TOUR_SCHEDULE_TABLE' ) )
    define( 'BYT_TOUR_SCHEDULE_TABLE', $wpdb->prefix . 'byt_tour_schedule' );
	
if ( ! defined( 'BYT_TOUR_BOOKING_TABLE' ) )
    define( 'BYT_TOUR_BOOKING_TABLE', $wpdb->prefix . 'byt_tour_booking' );
	   
global $currencies;

global $wpdb;
$table_name = BYT_CURRENCIES_TABLE;
$currencies = $wpdb->get_results("SELECT * FROM $table_name ORDER BY currency_label");
 
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/' );
	require_once dirname( __FILE__ ) . '/framework/options-framework.php';
} 

/*-----------------------------------------------------------------------------------*/
/*	Load Actions & Filters
/*-----------------------------------------------------------------------------------*/
require_once dirname( __FILE__ ) . '/includes/theme_filters.php';
require_once dirname( __FILE__ ) . '/includes/theme_actions.php';
 
/*-----------------------------------------------------------------------------------*/
/*	Load Widgets, Shortcodes & Metaboxes
/*-----------------------------------------------------------------------------------*/

require_once dirname( __FILE__ ) . '/plugins/widgets/custom-package-widget.php';
require_once dirname( __FILE__ ) . '/plugins/widgets/widget-address.php';
require_once dirname( __FILE__ ) . '/plugins/widgets/widget-social.php';
require_once dirname( __FILE__ ) . '/plugins/widgets/widget-home-feature.php';
require_once dirname( __FILE__ ) . '/plugins/metaboxes/meta_box.php';
/*-----------------------------------------------------------------------------------*/
/*	Load Utilities & Ajax & Custom Post Types & metaboxes
/*-----------------------------------------------------------------------------------*/
require_once dirname( __FILE__ ) . '/includes/theme_ajax.php';
require_once dirname( __FILE__ ) . '/includes/theme_utils.php';
require_once dirname( __FILE__ ) . '/includes/theme_post_types.php';
require_once dirname( __FILE__ ) . '/includes/theme_meta_boxes.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_accommodation_vacancy_admin.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_currency_admin.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_accommodation_booking_admin.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_car_rental_booking_admin.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_tour_schedule_admin.php';
require_once dirname( __FILE__ ) . '/includes/admin/theme_tour_schedule_booking_admin.php';

?>