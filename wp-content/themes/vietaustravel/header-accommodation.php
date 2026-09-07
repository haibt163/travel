<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!---<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">--->
	<meta name="HandheldFriendly" content="True">
	<title><?php wp_title(''); ?></title>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<script type="text/javascript">	
<?php
	$current_user = wp_get_current_user();
	$default_currency = strtoupper(of_get_option('default_currency_select', 'USD'));
	$current_currency = $default_currency;
	
	global $currencies;
	
	$default_currency_list = array(
		'usd'=> '1',
		'gbp'=> '1',
		'eur'=> '1'
	);
	$possible_currencies = of_get_option('enabled_currencies', $default_currency_list);

	$enabled_currencies = array();
	foreach ($possible_currencies as $currency => $enabled) {
		if ($enabled == '1')
			$enabled_currencies[] = $currency;
	}
	
	if ($current_user->ID > 0){
	?>
		window.currentUserId = '<?php echo $current_user->ID;?>';
	<?php
		$user_currency = get_user_meta($current_user->ID, 'user_currency', true);
		if (!empty($user_currency) && in_array(strtolower($user_currency), $enabled_currencies))
			$current_currency = $user_currency;
	}
	
	global $currency_symbol;
	$currency_obj = find_currency_object($current_currency);
	$currency_symbol = $currency_obj->currency_symbol;
?>	
		window.currentCurrency = '<?php echo $current_currency;?>';
		window.defaultCurrency = '<?php echo $default_currency; ?>';
		window.currencySymbol = '<?php echo $currency_symbol; ?>';
<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
		window.currentLanguage = '<?php echo ICL_LANGUAGE_CODE; ?>';
<?php } ?>
		window.themePath = '<?php echo get_template_directory_uri(); ?>';
	</script>
<?php
	 $my_account_page_id =  of_get_option('my_account_page_id', '');
	 $my_account_page = get_permalink($my_account_page_id);

	$color_scheme_style_sheet = of_get_option('color_scheme_select', 'style');
	$logo_src = of_get_option('website_logo_upload', '');
	
	if (empty($logo_src)) {
		if (empty($color_scheme_style_sheet)) 
			$logo_src = get_template_directory_uri() . '/images/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-strawberry')
			$logo_src = get_template_directory_uri() . '/images/themes/strawberry/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-black')
			$logo_src = get_template_directory_uri() . '/images/themes/black/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-blue')
			$logo_src = get_template_directory_uri() . '/images/themes/blue/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-orange')
			$logo_src = get_template_directory_uri() . '/images/themes/orange/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-pink')
			$logo_src = get_template_directory_uri() . '/images/themes/pink/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-yellow')
			$logo_src = get_template_directory_uri() . '/images/themes/yellow/txt/logo.png';
		else if ($color_scheme_style_sheet == 'theme-navy')
			$logo_src = get_template_directory_uri() . '/images/themes/navy/txt/logo.png';
		else 
			$logo_src = get_template_directory_uri() . '/images/txt/logo.png';
	}
	 
	wp_head(); ?>	
</head>
<body <?php body_class(); ?>>
	<!--header-->
	<header>
		<div class="taskbar">
    	<div class="wrap clearfix">
			<div class="pull-left">
		<!--primary navigation-->
		<?php  if ( has_nav_menu( 'menu-taskbar' ) ) {
			wp_nav_menu( array( 
				'theme_location' => 'menu-taskbar', 
				'container' => 'nav', 
				'container_class' => 'main-nav-top',
				'container_id' => 'nav-taskbar',
				'menu_class' => 'menu-left-taskbar'
			) ); 
		} else { ?>
		<nav class="main-nav-top">
			<ul class="menu-left-taskbar">
				<li class="menu-item"><a href="<?php echo home_url(); ?>"><?php _e('Taskbar', "bookyourtravel"); ?></a></li>
				<li class="menu-item"><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Configure', "bookyourtravel"); ?></a></li>
            </ul>       
		</nav>
		<?php } ?>
		<!--//primary navigation-->
                    
            	
            </div>
            <div class="pull-right">
            	<ul class="menu-right-taskbar">
                    <li><i class="icon-current"></i> AUD DOLLAR</li>
                    <li class="submenu">
                    	<i class="icon-account"></i> My Account
                        <div class="submenu-taskbar">
                        	<ul>
						<?php if (!is_user_logged_in()) { ?>
						<li><a class="fn" onclick="toggleLightbox('login_lightbox');" href="javascript:void(0);" title="<?php _e('Login', 'bookyourtravel'); ?>"><?php _e('Login', 'bookyourtravel'); ?></a></li>
						<li><a class="fn" onclick="toggleLightbox('register_lightbox');" href="javascript:void(0);" title="<?php _e('Register', 'bookyourtravel'); ?>"><?php _e('Register', 'bookyourtravel'); ?></a></li>
						<?php } else {?>
						<li><a class="fn" href="<?php echo $my_account_page; ?>" title="<?php _e('Account info', 'bookyourtravel'); ?>"><?php _e('Account info', 'bookyourtravel'); ?></a></li>
						<li><a class="fn" href="<?php echo wp_logout_url(get_option('home')); ?>"><?php _e('Logout', 'bookyourtravel'); ?></a></li>
						<?php } ?>                          
                            </ul>
                        </div>
                    </li>                                           
                    
                    <li><a href="<?php echo get_home_url(); ?>"><i class="icon-flag-australia"></i></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/vn"><i class="icon-flag-vietnam"></i></a></li>
                    
                </ul>
            </div>
        </div>
    </div>    
		<div class="wrap clearfix">
			<!--logo-->
			<h1 class="logo"><a href="<?php echo get_home_url(); ?>" title="<?php _e('Book Your Travel - home', 'bookyourtravel'); ?>"><img src="<?php echo $logo_src; ?>" alt="<?php _e('Book Your Travel - home', 'bookyourtravel'); ?>" /></a></h1>
			<!--//logo-->
			<?php get_sidebar('header'); ?>	
			<!--search-->
			<div class="search">
				<form id="searchform" method="get" action="<?php echo get_option('home'); ?>">
					<input type="search" placeholder="<?php _e('Search here..', 'bookyourtravel'); ?>" name="s" id="search" /> 
					<input type="submit" id="searchsubmit" value="" name="searchsubmit"/>
				</form>
			</div>
			<!--//search-->		

		</div>
		<!--primary navigation-->
		<?php  if ( has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 
				'theme_location' => 'primary-menu', 
				'container' => 'nav', 
				'container_class' => 'main-nav',
				'container_id' => 'nav',
				'menu_class' => 'wrap'
			) ); 
		} else { ?>
		<nav class="main-nav">
			<ul class="wrap">
				<li class="menu-item"><a href="<?php echo home_url(); ?>"><?php _e('Home', "bookyourtravel"); ?></a></li>
				<li class="menu-item"><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Configure', "bookyourtravel"); ?></a></li>
			</ul>
		</nav>
		<?php } ?>
		<!--//primary navigation-->
	</header>
	<!--//header-->

	<!--main-->
	<div class="main" role="main" id="primary">		
		<div class="wrap clearfix">
			<!--main content-->
			<div class="content clearfix" id="content">