<?php

 /**
 * Sets up theme defaults and registers the various WordPress features that
 * Book Your Travel supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Book Your Travel 1.0
 */
function bookyourtravel_setup() {
	/*
	 * Book Your Travel available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Book Your Travel, use a find and replace
	 * to change 'bookyourtravel' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bookyourtravel', get_template_directory() . '/languages' );
	
	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu', 'bookyourtravel' ),
		'menu-taskbar' => __( 'Taskbar Menu', 'bookyourtravel' ),
		'footer-menu' => __( 'Footer Menu', 'bookyourtravel' ),
		'customer-support-menu' => __( 'Customer Support Menu', 'bookyourtravel' )
	) );	
	
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( 200, 200, true );
	add_image_size( 'related', 180, 120, true ); //related
	add_image_size( 'featured', 815, 459, true ); //Featured
	
	//Left Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Left Sidebar', 'bookyourtravel'),
		'id'=>'left',
		'description' => __('This Widget area is used for the left sidebar', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Right Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Right Sidebar', 'bookyourtravel'),
		'id'=>'right',
		'description' => __('This Widget area is used for the right sidebar', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Under Header Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Under Header Sidebar', 'bookyourtravel'),
		'id'=>'under-header',
		'description' => __('This Widget area is placed under the website header', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Under Header Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Above Footer Sidebar', 'bookyourtravel'),
		'id'=>'above-footer',
		'description' => __('This Widget area is placed above the website footer', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Right Sidebar Widget area for Accommodation
	register_sidebar(array(
		'name'=> __('Right Sidebar Accommodation', 'bookyourtravel'),
		'id'=>'right-accommodation',
		'description' => __('This Widget area is used for the right sidebar of the single accommodation screen', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Right Sidebar Widget area for Tour
	register_sidebar(array(
		'name'=> __('Right Sidebar Tour', 'bookyourtravel'),
		'id'=>'right-tour',
		'description' => __('This Widget area is used for the right sidebar of the single tour screen', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Footer Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Footer Sidebar', 'bookyourtravel'),
		'id'=>'footer',
		'description' => __('This Widget area is used for the footer area', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Header Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Header Sidebar', 'bookyourtravel'),
		'id'=>'header',
		'description' => __('This Widget area is used for the header area (usually for purposes of displaying WPML language switcher widget)', 'bookyourtravel'),
		'before_widget' => '',
		'after_widget' => '',
		'class'	=> 'lang-nav',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Home Footer Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Home Footer Widget Area', 'bookyourtravel'),
		'id'=>'home-footer',
		'description' => __('This Widget area is used for the home page footer area above the regular footer', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name'=> __('Home Above Slider Widget Area', 'bookyourtravel'),
		'id'=>'home-above-slider',
		'description' => __('This Widget area is used for the home page area above the slider', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name'=> __('Home Below Slider Widget Area', 'bookyourtravel'),
		'id'=>'home-below-slider',
		'description' => __('This Widget area is used for the home page area imediatally below the slider', 'bookyourtravel'),
		'before_widget' => '<li class="widget widget-sidebar">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Right Sidebar Widget area
	register_sidebar(array(
		'name'=> __('Tour Home Natural', 'bookyourtravel'),
		'id'=>'tour-home-natural',
		'description' => __('This Widget area is used for the right sidebar', 'bookyourtravel'),
		'before_widget' => '<ul><li class="widget widget-sidebar">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));	
	// Right Sidebar Widget area
	register_sidebar(array(
		'name'=> __('home tour unesco', 'bookyourtravel'),
		'id'=>'home-tour-unesco',
		'description' => __('This Widget area is used for the right sidebar', 'bookyourtravel'),
		'before_widget' => '<ul><li class="widget widget-sidebar">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));	
	// Right Sidebar Widget area
	register_sidebar(array(
		'name'=> __('home tour beach', 'bookyourtravel'),
		'id'=>'home-tour-beach',
		'description' => __('This Widget area is used for the right sidebar', 'bookyourtravel'),
		'before_widget' => '<ul><li class="widget widget-sidebar">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));		
	
}
add_action( 'after_setup_theme', 'bookyourtravel_setup' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Book Your Travel 1.0
 */
function bookyourtravel_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for various theme features
	 */
	 
	wp_enqueue_script('jquery');

	wp_register_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', false, '1.9.2');
	wp_enqueue_script('jquery-ui');

	$page_object = get_queried_object();
	$page_id     = get_queried_object_id();
	
	if (is_single() && get_post_type() == 'accommodation') {
	
		wp_register_script(
			'google-maps',
			'http://maps.google.com/maps/api/js?sensor=false',
			'jquery',
			'1.0',
			true
		);

		wp_enqueue_script( 'google-maps' );

		wp_register_script(
			'infobox',
			get_template_directory_uri() . '/js/infobox.js',
			'jquery',
			'1.0',
			true
		);

		wp_enqueue_script( 'infobox' );
	
		wp_register_script(
			'accommodations',
			get_template_directory_uri() . '/js/accommodations.js',
			'jquery',
			'1.0',
			true
		);

		wp_enqueue_script( 'accommodations' );		
		
	} else if (is_single() && get_post_type() == 'tour') {
	
		wp_register_script(
			'google-maps',
			'http://maps.google.com/maps/api/js?sensor=false',
			'jquery',
			'1.0',
			true
		);

		wp_enqueue_script( 'google-maps' );
	
		wp_register_script(
			'tours',
			get_template_directory_uri() . '/js/tours.js',
			'jquery',
			'1.0',
			true
		);

		wp_enqueue_script( 'tours' );
	
	}
	
	wp_register_script(
		'car_rentals',
		get_template_directory_uri() . '/js/car_rentals.js',
		'jquery',
		'1.0',
		true
	);

	wp_enqueue_script( 'car_rentals' );	
	
	wp_enqueue_script( 'bookyourtravel-mediaqueries', get_template_directory_uri() . '/js/css3-mediaqueries.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-sequence-jquery', get_template_directory_uri() . '/js/sequence.jquery-min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-jquery-uniform', get_template_directory_uri() . '/js/jquery.uniform.min.js', array('jquery', 'jquery-ui'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-jquery-prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-jquery-raty', get_template_directory_uri() . '/js/jquery.raty.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-sequence', get_template_directory_uri() . '/js/sequence.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-selectnav', get_template_directory_uri() . '/js/selectnav.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bookyourtravel-scripts', get_template_directory_uri() . '/js/scripts.js', array('bookyourtravel-jquery-uniform'), '1.0', true );
	
	wp_localize_script( 'bookyourtravel-scripts', 'BYTAjax', array( 
		   'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		   'nonce'   => wp_create_nonce('byt-ajax-nonce') 
		) );

	/*
	 * Loads our main stylesheets.
	 */
	wp_enqueue_style('bookyourtravel-style-main',  get_template_directory_uri() . '/css/style.css', array(), '1.0', "screen,projection,print");
	wp_enqueue_style( 'bookyourtravel-style', get_stylesheet_uri() );
	
	/*
	 * Load the color scheme sheet if set in set in options.
	 */	 
	$color_scheme_style_sheet = of_get_option('color_scheme_select', 'style');
	if (!empty($color_scheme_style_sheet)) {
		wp_enqueue_style('bookyourtravel-style-color',  get_template_directory_uri() . '/css/' . $color_scheme_style_sheet . '.css', array(), '1.0', "screen,projection,print");
	}
	
	wp_enqueue_style('bookyourtravel-style-pp',  get_template_directory_uri() . '/css/prettyPhoto.css', array(), '1.0', "screen");
	 
}
add_action( 'wp_enqueue_scripts', 'bookyourtravel_scripts_styles' );

/**
 * Enqueues scripts and styles for admin.
 *
 * @since Book Your Travel 1.0
 */
function bookyourtravel_admin_scripts_styles() {
	wp_enqueue_script('jquery');

	wp_register_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', false, '1.9.2');
	wp_enqueue_script('jquery-ui');
	
	wp_register_script('byt-admin', get_template_directory_uri() . '/includes/admin/admin.js', false, '1.0.0');
	wp_enqueue_script('byt-admin');
	
	wp_enqueue_style('byt-admin-ui-css', get_template_directory_uri() . '/css/jquery-ui-custom.css', false);
}
add_action( 'admin_enqueue_scripts', 'bookyourtravel_admin_scripts_styles' );

/**
 * Add password fields to wordpress registration form if option for users to set their own password is enabled in Theme settings.
 */
add_action( 'register_form', 'byt_password_register_fields', 10, 1 );
function byt_password_register_fields($includeRow=false){
	$let_users_set_pass = of_get_option('let_users_set_pass', 0);
	if ($includeRow && $let_users_set_pass)
		echo '<div class="row twins">';
		
	if ($let_users_set_pass) {
?>
	<div class="f-item">
		<label for="password"><?php _e('Password', 'bookyourtravel'); ?></label>
		<input id="password" class="input" type="password" tabindex="30" size="25" value="" name="password" />
	</div>
	<div class="f-item">
		<label for="repeat_password"><?php _e('Repeat password', 'bookyourtravel'); ?></label>
		<input id="repeat_password" class="input" type="password" tabindex="40" size="25" value="" name="repeat_password" />
	</div>
<?php
	}
	
	if ($includeRow && $let_users_set_pass)
		echo '</div>';
}

/**
 * Disable WP login if option enabled in Theme settings
 */
function byt_disable_wp_login(){
	$override_wp_login = of_get_option('override_wp_login', 0);
	if ($override_wp_login) {
	
		$redirect_to_after_logout_id = of_get_option('redirect_to_after_logout', '');
		$redirect_to_after_logout = get_permalink($redirect_to_after_logout_id);
			
		$login_page_url_id = of_get_option('login_page_url', '');
		$login_page_url = get_permalink($login_page_url_id);
			
		if (!empty($login_page_url) && !empty($redirect_to_after_logout)) {
			if( isset( $_GET['loggedout'] ) ){
				wp_redirect( $redirect_to_after_logout );
				exit;
			} else{
				wp_redirect( $login_page_url );
				exit;
			}
		}
	}
}
add_action( 'login_form_login', 'byt_disable_wp_login' );

function set_flexslider_hg_rotators( $rotators = array() )
{
	$rotators['homepage'] = array( 'size' => 'homepage-rotator', 'options' => "{slideshowSpeed: 4000, animationSpeed: 800, direction: 'horizontal', controlNav: false, directionNav: false, animation: 'slide'}" );
    return $rotators;
}
add_filter('flexslider_hg_rotators', 'set_flexslider_hg_rotators');	

/*
 * Override optionsframework sanitization for 'textarea' sanitization and $allowedposttags + embed and script.
 */
add_action('admin_init','optionscheck_change_santiziation', 100);
function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'byt_sanitize_textarea' );
}
function byt_sanitize_textarea($input) {
    global $allowedposttags;
	$custom_allowedtags["iframe"] = array();	
    $custom_allowedtags["script"] = array();
    $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
    $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}

?>