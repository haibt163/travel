<?php 
	$override_wp_login = of_get_option('override_wp_login', 0);		
	$login_page_url_id = of_get_option('login_page_url', '');
	$login_page_url = get_permalink($login_page_url_id);
	if (!$login_page_url || !$override_wp_login)
		$login_page_url = get_home_url() . '/wp-login.php';
		
	$reset_password_page_url_id = of_get_option('reset_password_page_url', '');
	$reset_password_page_url = get_permalink($reset_password_page_url_id);
	if (!$reset_password_page_url || !$override_wp_login)
		$reset_password_page_url = get_home_url() . '/wp-login.php?action=lostpassword';
?>	
	<div class="lightbox" style="display:none;" id="login_lightbox">
		<div class="lb-wrap">
			<a onclick="toggleLightbox('login_lightbox');" href="javascript:void(0);" class="close">x</a>
			<div class="lb-content">
				<form action="<?php echo $login_page_url; ?>" method="post">
					<h1><?php _e('Log in', 'bookyourtravel'); ?></h1>
					<div class="f-item">
						<label for="log"><?php _e('Username', 'bookyourtravel'); ?></label>
						<input type="text" name="log" id="log" value="" />
					</div>
					<div class="f-item">
						<label for="pwd"><?php _e('Password', 'bookyourtravel'); ?></label>
						<input type="password" id="pwd" name="pwd" />
					</div>
					<div class="f-item checkbox">
						<input type="checkbox" id="rememberme" name="rememberme" checked="checked" value="forever" />
						<label for="rememberme"><?php _e('Remember me next time', 'bookyourtravel'); ?></label>
					</div>
					<p><a href="<?php echo $reset_password_page_url; ?>" title="<?php _e('Forgot your password?', 'bookyourtravel'); ?>"><?php _e('Forgot your password?', 'bookyourtravel'); ?></a><br />
					<?php _e('Don\'t have an account yet?', 'bookyourtravel'); ?> <a onclick="toggleLightbox('register_lightbox');" href="javascript:void(0);" title="<?php _e('Sign up', 'bookyourtravel'); ?>"><?php _e('Sign up', 'bookyourtravel'); ?>.</a></p>
					<?php wp_nonce_field( 'bookyourtravel_login_form' ) ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="submit" id="login" name="login" value="<?php _e('Login', 'bookyourtravel'); ?>" class="gradient-button"/>
				</form>
			</div>
		</div>
	</div>
<?php ?>