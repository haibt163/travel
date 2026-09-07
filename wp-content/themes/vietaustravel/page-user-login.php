<?php 
/* Template Name: Login Page
 * The template for displaying the Login page.
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
 
if ( is_user_logged_in() ) {
	wp_redirect( get_home_url() );
	exit;
}

$override_wp_login = of_get_option('override_wp_login', 0);

$register_page_url_id = of_get_option('register_page_url', '');
$register_page_url = get_permalink($register_page_url_id);
if (!$register_page_url || !$override_wp_login)
	$register_page_url = get_home_url() . '/wp-login.php?action=register';
	
$login_page_url_id = of_get_option('login_page_url', '');
$login_page_url = get_permalink($login_page_url_id);
if (!$login_page_url || !$override_wp_login)
	$login_page_url = get_home_url() . '/wp-login.php';
	
$reset_password_page_url_id = of_get_option('reset_password_page_url', '');
$reset_password_page_url = get_permalink($reset_password_page_url_id);
if (!$reset_password_page_url || !$override_wp_login)
	$reset_password_page_url = get_home_url() . '/wp-login.php?action=lostpassword';

$terms_page_url_id = of_get_option('terms_page_url', '');
$terms_page_url = get_permalink($terms_page_url_id);
	
$login = null;
// login
if( isset( $_POST['log'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'bookyourtravel_login_form' ) ){

	$login = wp_signon(

		array(
			'user_login' => $_POST['log'],
			'user_password' => $_POST['pwd'],
			'remember' =>( ( isset( $_POST['rememberme'] ) && $_POST['rememberme'] ) ? true : false )
		),
		false
		);
	
	if ( !is_wp_error( $login ) ) {
		wp_redirect( get_home_url() );
		exit;
	}
} 

get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');
?>
	<section class="three-fourth bg-tours">
		<form id="login_form" method="post" action="<?php get_permalink(); ?>" class="booking">
			<fieldset>
				<h3><?php _e('Login', 'bookyourtravel'); ?></h3>
				<p class="">
				<?php _e('Don\'t have an account yet?', 'bookyourtravel'); ?> <a href="<?php echo $register_page_url; ?>"><?php _e('Sign up', 'bookyourtravel'); ?></a>. <?php _e('Forgotten your password?', 'bookyourtravel'); ?> <a href="<?php echo $reset_password_page_url; ?>"><?php _e('Reset it here', 'bookyourtravel'); ?></a>.
				</p>
				<?php if( is_wp_error( $login ) ){ 
					echo '<p class="error">' . __('Incorrect username or password. Please try again.', 'bookyourtravel') . '</p>';
				} ?>
				<div class="row twins">
					<div class="f-item">
						<label for="log"><?php _e('Username', 'bookyourtravel'); ?></label>
						<input type="text" name="log" id="log" value="" />
					</div>
					<div class="f-item">
						<label for="pwd"><?php _e('Password', 'bookyourtravel'); ?></label>
						<input type="password" name="pwd" id="pwd" value="" />
					</div>
				</div>
				<div class="row">					
					<div class="f-item checkbox">
						<input type="checkbox" name="rememberme" name="rememberme">
						<label for="rememberme"><?php _e( 'Remember Me', 'bookyourtravel' ); ?> </label>
					</div>
				</div>
				<?php wp_nonce_field( 'bookyourtravel_login_form' ) ?>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
				<input type="submit" id="login" name="login" value="<?php _e('Login', 'bookyourtravel'); ?>" class="gradient-button"/>
			</fieldset>
		</form>
	</section>
	
 <?php get_footer(); ?>