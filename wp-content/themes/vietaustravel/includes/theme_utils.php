<?php

/*
 * Breadcrumbs
 */
function byt_breadcrumbs() {
	if (is_home()) {}
	else {
		echo '<!--breadcrumbs--><nav role="navigation" class="breadcrumbs clearfix">';
		echo '<ul>';
		echo '<li><a href="' . home_url() . '" title="' . __('Home', 'bookyourtravel') . '">' . __('Home', 'bookyourtravel') . '</a></li>';
		if (is_category()) {
			echo "<li>";
			the_category('</li><li>');
			echo "</li>";
		} elseif (is_page() || is_single()) {
			echo "<li>";
			echo the_title();
			echo "</li>";
		} elseif (is_404()) {
			echo "<li>" . __('Error 404 - Page not found', 'bookyourtravel') . "</li>";
		} elseif (is_search()) {
			echo "<li>";
			echo __('Search results for: ', 'bookyourtravel');
			echo '"<em>';
			echo get_search_query();
			echo '</em>"';
			echo "</li>";
		} else if (is_post_type_archive('accommodation')) {
			echo "<li>";
			echo __('Accommodations', 'bookyourtravel');
			echo "</li>";
		} else if (is_post_type_archive('location')) {
			echo "<li>";
			echo __('Locations', 'bookyourtravel');
			echo "</li>";
		}
		
		echo '</ul>';
		echo '</nav><!--//breadcrumbs-->';
	}
}

/**
  * Helper function: string contains string
  */
function byt_string_contains($haystack, $needle) {
	if (strpos($haystack, $needle) !== FALSE)
		return true;
	else
		return false;
}

/**
  * Helper function: get current page url
 */
function current_page_url() {
	$pageURL = 'http';
	if ( isset( $_SERVER["HTTPS"] ) && strtolower($_SERVER["HTTPS"]) == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ( isset( $_SERVER["SERVER_PORT"] )  && $_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/*
 * Pager
 */
function byt_display_pager($max_num_pages) {

	$pattern = '#(www\.|https?:\/\/){1}[a-zA-Z0-9]{2,254}\.[a-zA-Z0-9]{2,4}[a-zA-Z0-9.?&=_/]*#i';

	$big = 999999999; // need an unlikely integer
	$pager_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $max_num_pages,
		'prev_text'    => __('&lt;'),
		'next_text'    => __('&gt;'),
		'type'		   => 'array'
	) );
	$count_links = count($pager_links);
	if ($count_links > 0) {
		$first_link = $pager_links[0];
		$last_link = $first_link;
		preg_match_all($pattern, $first_link, $matches, PREG_PATTERN_ORDER);
		echo '<span><a href="' . $matches[0][0] . '">' . __('First page', 'bookyourtravel') . '</a></span>';
		for ($i=0; $i<$count_links; $i++) {
			$pager_link = $pager_links[$i];
			if (!byt_string_contains($pager_link, 'current'))
				echo '<span>' . $pager_link . '</span>';
			else
				echo $pager_link;
			$last_link = $pager_link;
		}
		preg_match_all($pattern, $last_link, $matches, PREG_PATTERN_ORDER);
		echo '<span><a href="' . $matches[0][0] . '">' . __('Last page', 'bookyourtravel') . '</a></span>';
	}
}



/*-----------------------------------------------------------------------------------*/
/*	Custom comments template
/*-----------------------------------------------------------------------------------*/
function byt_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   $comment_class = comment_class('clearfix', null, null, false);
   ?>							
	<!--single comment-->
	<article <?php echo $comment_class; ?> id="article-comment-<?php comment_ID() ?>">
		<div class="third">
			<figure><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></figure>
			<address>
				<span><?php echo get_comment_author_link(); ?></span><br />
				<?php the_time('F j, Y'); ?>
			</address>
			<div class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.') ?></em>
		<?php endif; ?>
		<div class="comment-content"><?php echo get_comment_text(); ?></div>
<?php 
	$reply_link = get_comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
	$reply_link = str_replace('comment-reply-link', 'comment-reply-link reply', $reply_link);
	$reply_link = str_replace('comment-reply-login', 'comment-reply-login reply', $reply_link);
?>		
		<?php echo $reply_link; ?>
	</article>
	<!--//single comment-->
<?php
}

/**
 * Email sent to user during registration process requiring confirmation if option enabled in Theme settings
 */
function byt_activation_notification( $user_id ){

	$user = get_userdata( $user_id );
	if( !$user || !$user->user_activation_key ) return false;
	
	$register_page_url_id = of_get_option('register_page_url', '');
	$register_page_url = get_permalink($register_page_url_id);
	if (!$register_page_url)
		$register_page_url = get_home_url() . '/wp-login.php';
	
	$activation_url = add_query_arg( 
		array( 
			'action' => 'activate',
			'user_id' => $user->ID,
			'activation_key' => $user->user_activation_key
		), 
		get_permalink( $register_page_url ) 
	);

	$subject = get_bloginfo( 'name' ) . __( ' - User Activation ', 'bookyourtravel' );
	$body = __( 'To activate your user account, please click the activation link below: ', 'bookyourtravel' );
	$body .= "\r\n";
	$body .= $activation_url;

	$admin_email = get_option( 'admin_email' );
	
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=utf-8";
	$headers[] = "From: " . get_bloginfo( 'name' ) . " <" . admin_email . ">";
	$headers[] = "Reply-To: " . get_bloginfo( 'name' ) . " <" . admin_email . ">";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	if( mail( $user->user_email, $subject, $body, implode( "\r\n", $headers ), '-f ' . admin_email ) ){
		return true;
	} else {
		return false;
	}

}

/**
 * Activate user if option enabled in Theme settings
 * 
 * @param  object $user
 * @param  string $activation_key
 * @return bool
 */
function byt_activate_user( $user_id, $activation_key ){
	$user = get_userdata( $user_id );

	if( 
		$user &&
		$user->user_activation_key && 
		$user->user_activation_key === $activation_key 
	){
		$userdata = array(
			'ID' => $user->ID,
			'role' => get_option('default_role')
		);

		wp_update_user( $userdata );
		delete_user_meta( $user->ID, 'user_activation_key' );
		
		return true;
	} else{
		return false;
	}
}

/**
 * Notify user about successful password reset if option enabled in Theme settings
 * 
 * @param  object $user
 * @param  string $activation_key
 * @return bool
 */
function byt_newpassword_notification( $user_id, $new_password ){

	$user = get_userdata( $user_id );
	if( !$user || !$new_password ) return false;

	$subject = get_bloginfo( 'name' ) . __( ' - New Password ', 'bookyourtravel' );
	$body = __( 'Your password was successfully reset. ', 'bookyourtravel' );
	$body .= "\r\n";
	$body .= "\r\n";
	$body .= __( 'Your new password is:', 'bookyourtravel' );
	$body .= ' ' . $new_password;

	$admin_email = get_option( 'admin_email' );
	
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=utf-8";
	$headers[] = "From: " . get_bloginfo( 'name' ) . " <" . $admin_email . ">";
	$headers[] = "Reply-To: " . get_bloginfo( 'name' ) . " <" . $admin_email . ">";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	if( mail( $user->user_email, $subject, $body, implode( "\r\n", $headers ), '-f ' . $admin_email ) ){
		return true;
	} else {
		return false;
	}
}


/**
 * Send reset password notification if option enabled in Theme settings
 * 
 * @param  int $user_id 
 * @return bool
 */
function byt_resetpassword_notification( $user_id ){

	$user = get_userdata( $user_id );
	if( !$user || !$user->user_resetpassword_key ) return false;

	$reset_password_page_url_id = of_get_option('reset_password_page_url', '');
	$reset_password_page_url = get_permalink($reset_password_page_url_id);
	if (!$reset_password_page_url || !$override_wp_login)
		$reset_password_page_url = get_home_url() . '/wp-login.php';
	
	$admin_email = get_option( 'admin_email' );
	
	$resetpassword_url = add_query_arg( 
		array( 
			'action' => 'resetpassword',
			'user_id' => $user->ID,
			'resetpassword_key' => $user->user_resetpassword_key
		), 
		$reset_password_page_url
	);

	$subject = get_bloginfo( 'name' ) . __( ' - Reset Password ', 'bookyourtravel' );
	$body = __( 'To reset your password please go to the following url: ', 'bookyourtravel' );
	$body .= "\r\n";
	$body .= $resetpassword_url;
	$body .= "\r\n";
	$body .= "\r\n";
	$body .= __( 'This link will remain valid for the next 24 hours.', 'bookyourtravel' );
	$body .= __( 'In case you did not request a password reset, please ignore this email.', 'bookyourtravel' );

	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=utf-8";
	$headers[] = "From: " . get_bloginfo( 'name' ) . " <" . $admin_email . ">";
	$headers[] = "Reply-To: " . get_bloginfo( 'name' ) . " <" . $admin_email . ">";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	if( mail( $user->user_email, $subject, $body, implode( "\r\n", $headers ), '-f ' . $admin_email ) ){
		return true;
	} else {
		return false;
	}
}


/**
 * Reset password
 * 
 * @param  int $user_id
 * @param  str $resetpassword_key
 * @return str/false New password or false
 */
function byt_resetpassword( $user_id, $resetpassword_key ){
	$user = get_userdata( $user_id );

	if( 
		$user && 
		$user->user_resetpassword_key && 
		$user->user_resetpassword_key === $resetpassword_key 
	){
		// check reset password time
		if(
			!$user->user_resetpassword_datetime ||
			strtotime( $user->user_resetpassword_datetime ) < time() - ( 24 * 60 * 60 )
		) return false;

		// reset password
		$userdata = array(
			'ID' => $user->ID,
			'user_pass' => wp_generate_password( 8, false )
		);

		wp_update_user( $userdata );
		delete_user_meta( $user->ID, 'user_resetpassword_key' );
		
		return $userdata['user_pass'];
	} else{
		return false;
	}
}

?>