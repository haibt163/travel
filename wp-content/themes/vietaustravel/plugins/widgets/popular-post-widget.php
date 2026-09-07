<?php
add_action( 'widgets_init', 'suckhoemevabe_popular_post_widget' );

function suckhoemevabe_popular_post_widget() {
	register_widget( 'suckhoemevabe_Popular_Post' );
}


class suckhoemevabe_popular_post extends WP_Widget {

/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/

	function  suckhoemevabe_popular_post() {
		$widget_ops = array( 'classname' => 'suckhoemevabe-popularpost-widget', 'description' => __( 'A widget that show popular posts', 'tl_back' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'suckhoemevabe-popularpost-widget' );
		$this->WP_Widget( 'suckhoemevabe-popularpost-widget', __('suckhoemevabe: Popular Posts', 'tl_back'), $widget_ops, $control_ops );
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('Popular Posts', $instance['title'] );
		$num_posts = $instance['num_posts'];
		echo $before_widget;
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
		}

			$recent_posts = new WP_Query(array(
				'showposts' => $num_posts,
				'orderby' => 'comment_count',
			));
			
			?>
				<div class="widget">
				<ul class="ulpost">
			<?php while($recent_posts->have_posts()){ $recent_posts->the_post(); 
			
			
				$thumb = get_post_thumbnail_id(get_the_ID());
                if (!$thumb) {
                    $url[0] = get_template_directory_uri() . '/img/demo/dum-6.jpg';
                }else{
					 $url = wp_get_attachment_image_src( $thumb , '120x85');
				}
			?>
            
			<li>		
					
	<?php 
				
				
				
                echo '<a class="entry-thumb feature-link" href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '"><img src="' . $url[0] . '" alt="' . get_the_title() . '" />';?>					 
                <?php echo $post_type = 'tour'; ?>
               </a>
			
				<div class="ulpost_title">
                <a class="title" href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
				<?php echo suckhoemevabe_short_title(61, get_the_title('')); ?>
                </a>
                                   <p class="post-meta">
                                        <span class="meta-date"><i class="icon-calendar"></i> <?php echo get_the_date('M d, Y'); ?></span>
                                    	<span class="meta-comment last-meta"><?php comments_popup_link(__('<i class="icon-comments-alt"></i> 0', 'tl_back'), __('<i class="icon-comments-alt"></i> 1', 'tl_back'), __('<i class="icon-comments-alt"></i> %', 'tl_back')); ?></span>
        </p>
                     <?php $enable_review = get_post_custom_values('reviewsuckhoemevabe_checkbox', get_the_ID()); ?>
                    
	                 <?php if (of_get_option('disable_review') == 0){
						if($enable_review[0] == 1){?>
                     <span class="review-star">
                          <span style="width:<?php echo suckhoemevabe_get_total_review(get_the_ID()); ?>%" class="review-star-inline"></span>
                     </span>
                    <?php }else{?>
						 <span class="review-star-none">
                          <span class="review-star-inline-none"></span>
                     </span>
						<?php }}else{?>
						 <span class="review-star-none">
                          <span class="review-star-inline-none"></span>
                     </span>
                    	<?php } ?> 
				</div>	
	<div class="clear"></div>
	</li>	
		<?php } ?>
</ul>		
</div>			
<?php
		echo $after_widget;
	}

/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_posts'] = $new_instance['num_posts'];
		return $instance;
	}

/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/

	function form($instance)
	{
		$defaults = array('title' => __( 'Popular Posts', 'tl_back' ) , 'num_posts' => 4, 'show_comments' => 'on');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'tl_back' ) ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e( 'Number of posts:', 'tl_back' ); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo $instance['num_posts']; ?>" />
		</p>		
	<?php 
	}
}
?>