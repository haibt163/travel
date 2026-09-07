<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: BYT Company Address

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'recent_package_widgets' );

// Register widget.
function recent_package_widgets() {
	register_widget( 'byt_Recent_Package' );
}

// Widget class.
class byt_Recent_Package extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
	function byt_Recent_Package() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'recent_package_widgets', 'description' => __('Recent_Package', 'bookyourtravel') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 550, 'id_base' => 'byt_Recent_Package' );

		/* Create the widget. */
		$this->WP_Widget( 'recent_package_widgets', __('Recent_Package', 'bookyourtravel'), $widget_ops, $control_ops );
	}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$post_cat = $instance['post_cat'];
		$show_num = $instance['show_num'];
		
		if($post_cat == "All"){ $post_cat = ''; }
				
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display Widget */
		
		// Open of title tag
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
		}
			
		// Widget Content
		wp_reset_query();
		$current_post = array(get_the_ID());		
		$custom_posts = get_posts( array('post_type'=>'tour', 'showposts'=>$show_num, 'tour_location_post_id'=>$post_cat, 
			'post__not_in'=>$current_post) );
		
		if( !empty($custom_posts) ){ 
			echo "<div class='gdl-recent-post-widget'>";
			foreach($custom_posts as $custom_post) { 
				?>
				<div class="recent-post-widget">
					<?php
						$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );				
						$thumbnail = wp_get_attachment_image_src( $thumbnail_id , $blog_port_widget_size );
						if( $thumbnail_id ){
							echo '<div class="recent-post-widget-thumbnail">';
							echo '<a href="' . get_permalink( $custom_post->ID ) . '">';
							$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
							if( !empty($thumbnail) ){
								echo '<img src="' . $thumbnail[0] . '" alt="'. $alt_text .'"/>';
							}	
							echo '</a>';
							echo '</div>';
						}
					?>
					
					<div class="recent-post-widget-context">
						<h4 class="recent-post-widget-title">
							<a href="<?php echo get_permalink( $custom_post->ID ); ?>"> 
								<?php _e( $custom_post->post_title, 'gdl_front_end'); ?> 
							</a>
						</h4>
						<div class="recent-post-widget-info">
							<div class="recent-post-widget-date"><i class="icon-time"></i>
							<?php
								$date_type = get_post_meta( $custom_post->ID, 'package-date-type', true );
								if( $date_type == 'Fixed' ){
									$start_date = get_post_meta( $custom_post->ID, 'package-start-date', true );
									$end_date = get_post_meta( $custom_post->ID, 'package-end-date', true ); 			
									
									echo get_package_date($start_date, $end_date, $gdl_widget_date_format);
								}else if( $date_type == 'Duration' ){
									echo get_post_meta( $custom_post->ID, 'package-duration', true );
								}
							?>
							</div>						
						</div>
					</div>
					<div class="clear"></div>
				</div>						
				<?php 
				
			}
			echo "</div>";
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['company_name'] = strip_tags( $new_instance['company_name'] );
		$instance['company_address'] = strip_tags( $new_instance['company_address'] );
		$instance['company_phone'] = strip_tags( $new_instance['company_phone'] );
		$instance['company_email'] = strip_tags( $new_instance['company_email'] );

		return $instance;
	}
	

/*-----------------------------------------------------------------------------------*/
/*	Widget Settings
/*-----------------------------------------------------------------------------------*/
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'company_name' => 'Book Your Travel LLC',
		'company_address' => '1400 Pennsylvania Ave. Washington, DC',
		'company_phone' => '1-555-555-5555',
		'company_email' => 'info@bookyourtravel.com'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'bookyourtravel') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'company_name' ); ?>"><?php _e('Company name:', 'bookyourtravel') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'company_name' ); ?>" name="<?php echo $this->get_field_name( 'company_name' ); ?>" value="<?php echo $instance['company_name']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'company_address' ); ?>"><?php _e('Company address:', 'bookyourtravel') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'company_address' ); ?>" name="<?php echo $this->get_field_name( 'company_address' ); ?>" value="<?php echo $instance['company_address']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'company_phone' ); ?>"><?php _e('Company phone:', 'bookyourtravel') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'company_phone' ); ?>" name="<?php echo $this->get_field_name( 'company_phone' ); ?>" value="<?php echo $instance['company_phone']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'company_email' ); ?>"><?php _e('Company email:', 'bookyourtravel') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'company_email' ); ?>" name="<?php echo $this->get_field_name( 'company_email' ); ?>" value="<?php echo $instance['company_email']; ?>" />
		</p>		
		
	<?php
	}
}
?>