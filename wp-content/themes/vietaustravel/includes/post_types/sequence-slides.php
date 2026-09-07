<?php
global $wpdb;


function byt_custom_post_slide() {

	// 'SLIDES' POST TYPE
	$labels = array( 'name' => __( 'Slides', 'bookyourtravel' ), 'singular_name' => __( 'Slide', 'bookyourtravel' ), 'all_items' => __( 'All Slides', 'bookyourtravel' ), 'add_new' => __( 'Add New Slide', 'bookyourtravel' ), 'add_new_item' => __( 'Add New Slide', 'bookyourtravel' ), 'edit_item' => __( 'Edit Slide', 'bookyourtravel' ), 'new_item' => __( 'New Slide', 'bookyourtravel' ),'view_item' => __( 'View Slide', 'bookyourtravel' ),'search_items' => __( 'Search Slides', 'bookyourtravel' ),'not_found' => __( 'No Slide found', 'bookyourtravel' ), 'not_found_in_trash' => __( 'No Slide found in Trash', 'bookyourtravel' ), 'parent_item_colon' => '' );
	
	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'_builtin'             => false,
		'show_ui'              => true, 
		'capability_type'      => 'post',
		'hierarchical'         => false,
		'supports'             => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'           => array(),
		'has_archive'          => false,
		'show_in_nav_menus'    => false
	);
	register_post_type( 'sequence-slides', $args );

}

function byt_sequence_slider_rotators()
{
	$rotators = array();
	$rotators['homepage'] = array( 'size' => 'large' );
	return apply_filters( 'byt_sequence_slider_rotators', $rotators );
}

function byt_sequence_slider_create_slide_metaboxes() 
{
    add_meta_box( 'byt_sequence_slider_metabox_1', __( 'Slide Settings', 'bookyourtravel' ), 'byt_sequence_slider_metabox_1', 'sequence-slides', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'byt_sequence_slider_create_slide_metaboxes' );

function byt_sequence_slider_metabox_1() 
{
	global $post;	
    $rotators = byt_sequence_slider_rotators();

	$slide_link_url 	= get_post_meta( $post->ID, '_slide_link_url', true );
	$slider_id		 	= get_post_meta( $post->ID, '_sequence_slider_id', true ); ?>
	
	<p>URL: <input type="text" style="width: 90%;" name="slide_link_url" value="<?php echo esc_attr( $slide_link_url ); ?>" /></p>
	<span class="description"><?php echo _e( 'The URL this slide should link to.', 'bookyourtravel' ); ?></span>

	<p>
		<?php if($rotators) { ?>
		<?php _e('Attach to:', 'bookyourtravel'); ?>
		<select name="slider_id">
			<?php foreach( $rotators as $rotator => $size) { ?>
				<option value="<?php echo $rotator ?>" <?php if($slider_id == $rotator) echo " SELECTED"; ?>><?php echo $rotator ?></option>
			<?php } ?>
		</select>
		<?php } ?>
	</p>
	
	<?php 

}

function byt_sequence_slider_save_meta( $post_id, $post )
{
	if ( isset( $_POST['slide_link_url'] ) ) 
	{
		update_post_meta( $post_id, '_slide_link_url', strip_tags( $_POST['slide_link_url'] ) );
	}
	if ( isset( $_POST['slider_id'] ) ) 
	{
		update_post_meta( $post_id, '_sequence_slider_id', strip_tags( $_POST['slider_id'] ) );
	}
}
add_action( 'save_post', 'byt_sequence_slider_save_meta', 1, 2 );

function byt_sequence_slider_columns( $columns ) 
{
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => __( 'Image', 'bookyourtravel' ),
		'title'    => __( 'Title', 'bookyourtravel' ),
		'ID'       => __( 'Slider ID', 'bookyourtravel' ),
		'order'    => __( 'Order', 'bookyourtravel' ),
		'link'     => __( 'Link', 'bookyourtravel' ),
		'date'     => __( 'Date', 'bookyourtravel' )
	);

	return $columns;
}
add_filter( 'manage_edit-slides_columns', 'byt_sequence_slider_columns' );

function byt_sequence_slider_add_columns( $column )
{
	global $post;
	$edit_link = get_edit_post_link( $post->ID );

	if ( $column == 'image' ) 	echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' . get_the_post_thumbnail( $post->ID, array( 60, 60 ), array( 'title' => trim( strip_tags(  $post->post_title ) ) ) ) . '</a>';
	if ( $column == 'order' ) 	echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	if ( $column == 'ID' ) 		echo get_post_meta( $post->ID, "_sequence_slider_id", true );
	if ( $column == 'link' ) 	echo '<a href="' . get_post_meta( $post->ID, "_slide_link_url", true ) . '" target="_blank" >' . get_post_meta( $post->ID, "_slide_link_url", true ) . '</a>';		
}
add_action( 'manage_slides_posts_custom_column', 'byt_sequence_slider_add_columns' );


function byt_sequence_slider_shortcode($atts, $content = null)
{
	$slug = isset($atts['slug']) ? $atts['slug'] : false;
	if(!$slug) { return apply_filters( 'byt_sequence_slider_empty_shortcode', "<p>BYT Sequence Slider: Please include a 'slug' parameter. [byt_sequence_slider slug=homepage]</p>" ); }
	return show_sequence_slider_rotator( $slug );
}
add_shortcode('byt_sequence_slider', 'byt_sequence_slider_shortcode');

function show_sequence_slider_rotator( $slug )
{
	$rotators = byt_sequence_slider_rotators();
	$orderby = isset($rotators[ $slug ]['orderby']) ? $rotators[ $slug ]['orderby'] : "menu_order";
	$order = isset($rotators[ $slug ]['order']) ? $rotators[ $slug ]['order'] : "ASC";

	$rtn = "";

	query_posts( array( 'post_type' => 'sequence-slides', 'order' => $order, 'orderby' => $orderby, 'meta_key' => '_sequence_slider_id', 'meta_value' => $slug, 'posts_per_page' => -1 ) );
	
	if ( have_posts() ) :

		$rtn .= '<section id="byt_sequence_slider_' . $slug . '_wrapper" class="slider clearfix">';
		$rtn .= '<div id="sequence">';
		$rtn .= '<ul class="slides">';
		
		while ( have_posts() ) : the_post();
		
			$url = get_post_meta( get_the_ID(), "_slide_link_url", true );
			$a_tag_opening = '<a href="' . $url . '" title="' . the_title_attribute( array('echo' => false) ) . '" >';
			
			$rtn .= '<li>';
			
			$rtn .= '<div id="slide-' . get_the_ID() . '" class="info animate-in">';
			
			if ($url && !empty($url))
				$rtn .= $a_tag_opening;
			
			$rtn .= '<h2>' . get_the_title() . '</h2><br />';
			$rtn .= '<p>' . get_the_excerpt() . '</p>';
			
			if ($url && !empty($url))
				$rtn .= '</a>';

			$rtn .= '</div><!-- #slide-' . get_the_ID() . ' -->';
			
			if ( has_post_thumbnail() )
				$rtn .= get_the_post_thumbnail( get_the_ID(), 'full' , array( 'class' => 'main-image animate-in' ) );

			$rtn .= '</li>';
			
		endwhile;

		$rtn .= '</ul>';
		$rtn .= '</div><!-- close: #byt_sequence_slider_' . $slug . ' -->';
		$rtn .= '</section><!-- close: #byt_sequence_slider_' . $slug . '_wrapper -->';
		
	endif;
	wp_reset_postdata();
	wp_reset_query();	
	
	return $rtn;
}

?>