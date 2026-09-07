<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php
return;
}
?>

<!--comments-->
<div class="comments" id="comments">
	<?php if ( have_comments() ) : ?>
	<h1><?php comments_number(__('No comments', 'bookyourtravel'), __('One comment', 'bookyourtravel'), __('% comments', 'bookyourtravel') );?></h1>
	<?php wp_list_comments('type=comment&callback=byt_comment'); ?>
 

	<?php else : // this is displayed if there are no comments so far ?>
	 
	<?php if ('open' == $post->comment_status) : ?>
	<!-- If comments are open, but there are no comments. -->
	 
	<?php else : // comments are closed ?>
	<!-- If comments are closed. -->
	<p class="nocomments"></p>
	 
	<?php endif; ?>
	<?php endif; ?>
	
	<?php if ('open' == $post->comment_status) : ?>
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>	
	<!--post comment form-->
	<article id="respond" class="post-comment clearfix">
		<h1><?php comment_form_title( __('Leave a Reply', 'bookyourtravel'), __('Leave a Reply to %s', 'bookyourtravel') ); ?></h1>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ) : ?>
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
			<?php else : ?>
			<div class="f-item">
				<label for="author"><?php _e('Name', 'bookyourtravel'); ?> <?php if ($req) echo "*"; ?></label>
				<input type="text" id="author" name="author" value="<?php echo $comment_author; ?>" />
			</div>
			<div class="f-item">
				<label for="email"><?php _e('Email', 'bookyourtravel'); ?> <?php if ($req) echo "*"; ?></label>
				<input type="email" id="email" name="email" value="<?php echo $comment_author_email; ?>" />
			</div>
			<div class="f-item">
				<label for="url"><?php _e('Website', 'bookyourtravel'); ?></label>
				<input type="text" id="url" name="url" value="<?php echo $comment_author_url; ?>" />
			</div>
			<?php endif; /* if ( $user_ID )... */ ?>	
			<div class="f-item">
				<label for="comment"><?php _e('Comment', 'bookyourtravel'); ?></label>
				<textarea id="comment" name="comment" rows="10" cols="10"></textarea>
			</div>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			<input type="submit" value="<?php _e('Submit comment', 'bookyourtravel'); ?>" class="gradient-button" />
		</form>
	</article>
	<!--//post comment form-->
	<?php endif; /* if (get_option('comment_registration')... */ ?>	
	<?php endif; /* if ('open'... */ ?>
	
</div><!--comments-->
<!--bottom navigation-->
<div class="bottom-nav">
	<!--back up button-->
	<a href="#" class="scroll-to-top" title="Back up">Back up</a> 
	<!--//back up button-->
</div>
<!--//bottom navigation-->