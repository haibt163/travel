<?php
/* Template Name: Reset Password Page
 * The template for displaying the reset password page.
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

// Process reset password attempt on submit
if( wp_verify_nonce( $_POST['_wpnonce'], 'resetpassword_form' ) ){

	// user data array
	$resetpassword_userdata = array(
		'user_email' => wp_kses( $_POST['user_email'], '', '' )
	);

	// custom user meta array
	$resetpassword_usermeta = array(
		'user_resetpassword_key' => wp_generate_password( 20, false ),
		'user_resetpassword_datetime' => date('Y-m-d H:i:s', time() )
	);	

	// validation
	$errors = array();

	// validate email
	if ( !is_email( $resetpassword_userdata['user_email'] ) ) {
		$user = get_user_by('login', $resetpassword_userdata['user_email']);
		if (!$user)
			$errors['user_email'] = __( 'You must enter a valid and existing email address or username.', 'bookyourtravel' );
	} else if ( !email_exists( $resetpassword_userdata['user_email'] ) ) {
		$errors['user_email'] = __( 'You must enter a valid and existing email address or username.', 'bookyourtravel' );
	}
	
	if( empty( $errors ) ){

		$user = get_user_by( 'email', $resetpassword_userdata['user_email'] );

		// update custom user meta
		foreach ( $resetpassword_usermeta as $key => $value ) {
			update_user_meta( $user->ID, $key, $value );
		}

		byt_resetpassword_notification( $user->ID );

		// refresh
		wp_redirect( add_query_arg( array( 'action' => 'resetpasswordnotification' ), get_permalink() ) );
		exit;
	}
} 

get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');
?>
	<section class="three-fourth">
		<form id="reset_password_form" method="post" action="<?php get_permalink(); ?>" class="booking">
			<fieldset>
				<h3><?php _e('Reset password', 'bookyourtravel'); ?></h3>
				
<?php 				
if( isset( $_GET['action'] ) && $_GET['action'] == 'resetpasswordnotification' ){ 

	?>
	<p class="success">
		<?php _e( 'Please confirm the request to reset your password by clicking the link sent to your email address.', 'bookyourtravel' ) ?>
	</p>
	<?php
} else if( isset( $_GET['action'] ) && $_GET['action'] == 'resetpassword' && isset( $_GET['user_id'] ) && isset( $_GET['resetpassword_key'] ) ){ 

	$user_id = wp_kses( $_GET['user_id'], '', '' );
	$resetpassword_key = wp_kses( $_GET['resetpassword_key'], '', '' );
	$new_password = byt_resetpassword( $user_id, $resetpassword_key );

	if( $new_password && byt_newpassword_notification( $user_id, $new_password ) ){
		?>
		<p class="success">
			<?php _e( 'Your password was successfully reset. We have sent the new password to your email address.', 'bookyourtravel' ) ?>
		</p>
		<?php
	} else{

		?>
		<p class="error">
			<?php _e( 'We encountered an error when attempting to reset your password. Please try again later.', 'bookyourtravel' ) ?>
		</p>
		<?php
	}
} else { 
?>			
				<p>
				<?php _e('Don\'t have an account yet?', 'bookyourtravel'); ?> <a href="<?php echo $register_page_url; ?>"><?php _e('Sign up', 'bookyourtravel'); ?></a>.
				</p>
			<?php if( isset( $errors['user_email'] ) ){ ?>
				<p class="error"><?php echo $errors['user_email']; ?></p>
			<?php } ?> 
				<div class="row twins">
					<div class="f-item">
						<label for="user_email"><?php _e('Username or email address', 'bookyourtravel'); ?></label>
						<input type="text" name="user_email" id="user_email" value="" />
					</div>
				</div>
				<?php wp_nonce_field( 'resetpassword_form' ) ?>
				<input type="submit" id="reset" name="reset" value="<?php _e('Reset password', 'bookyourtravel'); ?>" class="gradient-button"/>
 <?php } ?>
			</fieldset>
		</form>
	</section>
	

<?php get_footer(); ?>