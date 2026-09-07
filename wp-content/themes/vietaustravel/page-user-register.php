<?php 
/* Template Name: Register Page
 * The template for displaying the Register page.
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

	$errors = array();

// login
if( isset( $_POST['user_login'] ) &&  isset( $_POST['user_email'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'bookyourtravel_register_form' ) ){

	// user data array
	$register_userdata = array(
		'role' => 'pending',
		'user_login' => wp_kses( $_POST['user_login'], '', '' ),
		'user_pass' => wp_kses( $_POST['password'], '', '' ),
		'confirm_pass' => wp_kses( $_POST['repeat_password'], '', '' ),
		'user_email' => wp_kses( $_POST['user_email'], '', '' ),
		'first_name' => '',
		'last_name' => '',
		'user_url' => '',
		'description' => ''
	);
	
	// custom user meta array
	$register_usermeta = array(
		'agree' =>( ( isset( $_POST['checkboxagree'] ) && !empty( $_POST['checkboxagree'] ) ) ? '1' : '0' ),
		'user_activation_key' => wp_generate_password( 20, false )
	);
	
// validation


	// validate username
	if ( trim( $register_userdata['user_login'] ) == '' ) {
		$errors['user_login'] = __( 'Username is required.', 'bookyourtravel' );
	}
	else if ( strlen( $register_userdata['user_login'] ) < 6 ) {
		$errors['user_login'] = __( 'Sorry, username must be 6 characters or more.', 'bookyourtravel' );
	}
	else if ( !validate_username( $register_userdata['user_login'] ) ) {
		$errors['user_login'] = __( 'Sorry, the username you provided is invalid.', 'bookyourtravel' );
	}
	else if ( username_exists( $register_userdata['user_login'] ) ) {
		$errors['user_login'] = __( 'Sorry, that username already exists.', 'bookyourtravel' );
	}

	$let_users_set_pass = of_get_option('let_users_set_pass', 0);
	if ($let_users_set_pass) {
		// validate password
		if ( trim( $register_userdata['user_pass'] ) == '' ) {
			$errors['user_pass'] = __( 'Password is required.', 'bookyourtravel' );
		}
		else if ( strlen( $register_userdata['user_pass'] ) < 6 ) {
			$errors['user_pass'] = __( 'Sorry, password must be 6 characters or more.', 'bookyourtravel' );
		}
		else if ( $register_userdata['user_pass'] !== $register_userdata['confirm_pass'] ) {
			$errors['confirm_pass'] = __( 'Password and confirm password fields must match.', 'bookyourtravel' );
		}
	}
	
	// validate email
	if ( !is_email( $register_userdata['user_email'] ) ) {
		$errors['user_email'] = __( 'You must enter a valid email address.', 'bookyourtravel' );
	}
	else if ( email_exists( $register_userdata['user_email'] ) ) {
		$errors['user_email'] = __( 'Sorry, that email address is already in use.', 'bookyourtravel' );
	}

	// validate agree
	if( $register_usermeta['agree'] == '0' ){
		$errors['agree'] = __( 'You must agree to our terms &amp; conditions to sign up.', 'bookyourtravel' );
	}

	if( empty( $errors ) ){
		
		// insert new user
		$new_user_id = wp_insert_user( $register_userdata );
		
        do_action('user_register', $new_user_id);
		
		$new_user = get_userdata( $new_user_id );

		// update custom user meta
		foreach ( $register_usermeta as $key => $value ) {
			update_user_meta( $new_user_id, $key, $value );
		}

		// send notification
		byt_activation_notification( $new_user_id );

		// refresh
		wp_redirect( add_query_arg( array( 'action' => 'registered' ), get_permalink() ) );
		exit;
	}
} 

get_header(); 
byt_breadcrumbs();
get_sidebar('under-header');
?>
	<section class="three-fourth bg-tours">
		<form id="register_form" method="post" action="<?php echo get_permalink(); ?>" class="booking">
			<fieldset>
<?php
			/**
			 * Registration completed
			 */
			if( isset( $_GET['action'] ) && $_GET['action'] == 'registered'){ 
				?>
				<p class="success">
					<?php _e( 'Account was successfully created. Please click the activation link in the email we just sent you to complete the registration process.', 'bookyourtravel' ) ?>
				</p>
			<?php
			} else if( isset( $_GET['action'] ) && $_GET['action'] == 'activate' && isset( $_GET['user_id'] ) && isset( $_GET['activation_key'] ) ){
			/**
			 * User activation
			 */
				if( byt_activate_user( wp_kses( $_GET['user_id'], '', '' ), wp_kses( $_GET['activation_key'], '', '' ) ) ){

					?>
					<p class="success">
						<?php _e( 'User account successfully activated.', 'bookyourtravel' ) ?>
					</p>
					<?php

				} else{
					?>
					<p class="error">
						<?php _e( 'An error was encountered when attempting to activate your account.', 'bookyourtravel' ) ?>
					</p>
					<?php
				}
			} else if( isset( $_GET['action'] ) && $_GET['action'] == 'sendactivation' && isset( $_GET['user_id'] ) ){
				/**
				 * Resend activation notification
				 */
				if( byt_activation_notification( wp_kses( $_GET['user_id'], '', '' ) ) ){
					?>
					<p class="success">
						<?php _e( 'Activation link was successfully sent.', 'bookyourtravel' ) ?>
					</p>
					<?php
				} else { ?>
					<p class="error">
						<?php _e( 'An error was encountered when attempting to send the activation link. Please try again later.', 'bookyourtravel' ) ?>
					</p>
					<?php
				}
			} else {
			?>
				<h3><?php _e('Register', 'bookyourtravel'); ?></h3>
				<p class="row">	
				<?php _e('Already a member?', 'bookyourtravel'); ?> <?php _e(sprintf('Proceed to <a href="%s">login</a> page', $login_page_url), 'bookyourtravel'); ?>. <?php _e('Forgotten your password?', 'bookyourtravel'); ?> <a href="<?php echo $reset_password_page_url; ?>"><?php _e('Reset it here', 'bookyourtravel'); ?></a>.
				</p>
				<?php
				if (count($errors) > 0) {
					?>
					<p class="error">
						<?php _e( 'Errors were encountered when processing your registration request.', 'bookyourtravel' ) ?>
					</p>
					<?php
				}
				?>
				<div class="row twins">
					<div class="f-item">
						<label for="user_login"><?php _e('Username', 'bookyourtravel'); ?></label>
						<input type="text" id="user_login" name="user_login" value="<?php echo isset($register_userdata) ? $register_userdata['user_login'] : ''; ?>" />
						<?php if( isset( $errors['user_login'] ) ){ ?>
							<span class="input_error"><?php echo $errors['user_login']; ?></span>
						<?php } ?>
					</div>
					<div class="f-item">
						<label for="user_email"><?php _e('Email', 'bookyourtravel'); ?></label>
						<input type="email" id="user_email" name="user_email" value="<?php echo isset($register_userdata) ? $register_userdata['user_email'] : ''; ?>" />
						<?php if( isset( $errors['user_email'] ) ){ ?>
							<span class="input_error"><?php echo $errors['user_email']; ?></span>
						<?php } ?>
					</div>
				</div>
				<?php do_action('register_form', true); ?>  				
				<div class="row">					
					<div class="f-item checkbox">
						<div class="checker" id="uniform-check"><span><input type="checkbox" value="ch1" id="checkboxagree" name="checkboxagree" style="opacity: 0;"></span></div>
						<label><?php _e(sprintf('I agree to the <a href="%s">terms &amp; conditions</a>.', $terms_page_url), 'bookyourtravel'); ?></label>
						<?php if( isset( $errors['agree'] ) ){ ?>
							<span class="input_error"><?php echo $errors['agree']; ?></span>
						<?php } ?>
					</div>
				</div>
				<?php wp_nonce_field( 'bookyourtravel_register_form' ) ?>
				<input type="submit" id="register" name="register" value="<?php _e('Register', 'bookyourtravel'); ?>" class="gradient-button"/>
			<?php } ?>
			</fieldset>
		</form>
	</section>
	
<?php get_footer(); ?>