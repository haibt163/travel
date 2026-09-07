<?php
	$override_wp_login = of_get_option('override_wp_login', 0);
	$register_page_url_id = of_get_option('register_page_url', '');
	$register_page_url = get_permalink($register_page_url_id);
	if (!$register_page_url || !$override_wp_login)
		$register_page_url = get_home_url() . '/wp-login.php?action=register';
	$terms_page_url_id = of_get_option('terms_page_url', '');
	$terms_page_url = get_permalink($terms_page_url_id);
?>
	<div class="lightbox" style="display:none;" id="register_lightbox">
		<div class="lb-wrap">
			<a onclick="toggleLightbox('register_lightbox');" href="javascript:void(0);" class="close">x</a>
			<div class="lb-content">
				<form action="<?php echo $register_page_url; ?>" method="post">
					<h1><?php _e('Register', 'bookyourtravel'); ?></h1>
					<div class="f-item">
						<label for="user_login"><?php _e('Username', 'bookyourtravel'); ?></label>
						<input type="text" id="user_login" name="user_login" />
					</div>
					<div class="f-item">
						<label for="user_email"><?php _e('Email', 'bookyourtravel'); ?></label>
						<input type="email" id="user_email" name="user_email" />
					</div>
					<?php do_action('register_form', false); ?>  
					<?php if ($terms_page_url) { ?>
					<p><?php _e(sprintf('By clicking "Create Account" you confirm that you accept the <a href="%s">terms &amp; conditions</a>', $terms_page_url), 'bookyourtravel'); ?></p>
					<?php } ?>
					<?php wp_nonce_field( 'bookyourtravel_register_form' ) ?>
					<input type="submit" id="register" name="register" value="<?php _e('Create account', 'bookyourtravel'); ?>" class="gradient-button"/>
				</form>
			</div>
		</div>
	</div>
<?php ?>