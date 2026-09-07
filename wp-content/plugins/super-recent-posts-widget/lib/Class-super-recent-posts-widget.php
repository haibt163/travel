<?php

class Super_recent_posts_widget extends WP_Widget {

    protected static $text_domain = 'super_recent_posts_widget';
    protected static $ver = '0.2.3'; //for cache busting
    protected static $transient_limit = 60;
    
    /**
     * Initialization method
     */
    public static function init(){
        add_action( 'widgets_init', create_function( '', 'register_widget( "Super_recent_posts_widget" );' ) );
        add_action( 'admin_print_scripts-widgets.php', array( __CLASS__, 'enqueue' ) );
    }

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'super_recent_posts_widget', // Base ID
            'Super Recent Posts Widget', // Name
            array( 'description' => __( 'A prettier and more functional recent posts widget', self::$text_domain ), ) // Args
        );
    }


    /**
     * Front-end display of widget.
     *
     * Filter 'srpw_template' - template allowing a theme to use its own template file
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $template_file = plugin_dir_path( dirname( __FILE__ ) ) . 'views/widget.php';
        $template_file = apply_filters( 'srpw_template', $template_file );
        $template_file = apply_filters( 'srpw_' . $this->id . '_template', $template_file );
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $number_posts = ( ! empty( $instance['number_posts'] ) || ! is_integer( $instance['number_posts'] ) ) ? $instance['number_posts'] : 5;
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $post_type = esc_attr( $instance['post-type'] );
        $taxonomy = esc_attr( $instance['taxonomy'] );
        $term_slug = esc_attr($instance['term_slug']);
        $orderby = esc_attr($instance['orderby']);
        $order = esc_attr($instance['order']);
        $atts = array(
            'post_type' => $post_type,
            'taxonomy' => $taxonomy,
            'term_slug' => $term_slug,
            'number_posts' => $number_posts,
            'orderby' => $orderby,
            'order' => $order,
        );
        $posts = $this->get( $atts );
        ?>
        <?php extract( $args ); ?>
        <?php echo $before_widget; ?>
        <?php include( $template_file ); ?>
        <?php echo $after_widget; ?>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = esc_attr( $new_instance['title'] );
        $instance['order'] = esc_attr( $new_instance['order'] );
        $instance['orderby'] = esc_attr( $new_instance['orderby'] );
        $instance['post-type'] = esc_attr( $new_instance['post-type'] );
        $instance['taxonomy'] = esc_attr( $new_instance['taxonomy'] );
        $instance['term_slug'] = esc_attr( $new_instance['term_slug'] );
        $instance['number_posts'] = (int)$new_instance['number_posts'];
        delete_transient( $this->id );
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $defaults = array( 
            'title' => __( 'Posts', self::$text_domain ),
            'order' => null,
            'orderby' => null,
            'post-type' => null,
            'taxonomy' => null,
            'term_slug' => null,
            'number_posts' => __(5, self::$text_domain ),
        );  
        $instance = wp_parse_args( (array) $instance, $defaults );        
        ?>
        <div class="srpw-form">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', self::$text_domain ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number of Posts:', self::$text_domain ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" type="text" value="<?php echo $instance['number_posts']; ?>" />
            </p>            

            <p class="post-types-wrap">
                <label for="<?php echo $this->get_field_id( 'post-type' ); ?>"><?php _e( 'Post Type:', self::$text_domain ); ?></label> 
                <?php wp_nonce_field( 'nonce_spw', 'nonce_spw' ); ?>
                <select class="srpw-post-types widefat" id="<?php echo $this->get_field_id( 'post-type' ); ?>" name="<?php echo $this->get_field_name( 'post-type' ); ?>">
                    <?php echo Srpw_helper::get_post_types( $instance['post-type'] ); ?>
                </select>
                <span class="loading"></span>
                
            </p>
            <p class="taxonomies-wrap">
                <label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:', self::$text_domain ); ?></label> 
                <select class="srpw-taxonomies widefat" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
                    <?php if ( $instance['post-type'] ) { ?>
                        <?php echo Srpw_helper::get_taxonomies( $instance['post-type'], $instance['taxonomy'] ); ?>

                    <?php } ?>
                </select>
                <span class="block"><small><?php _e('Tip: Leave Taxonomy as "No Specific Taxonomy" to have the widget display post types regardless of taxonomy/term.', self::$text_domain); ?></small></span>
                <span class="loading"></span>
            </p>
            <p class="terms-wrap">
                <label for="<?php echo $this->get_field_id( 'term_slug' ); ?>"><?php _e( 'Term:', self::$text_domain ); ?></label> 
                <select class="terms widefat" id="<?php echo $this->get_field_id( 'term_slug' ); ?>" name="<?php echo $this->get_field_name( 'term_slug' ); ?>">
                    <?php if ( $instance['post-type'] ) { ?>
                        <?php echo Srpw_helper::get_terms( $instance['taxonomy'], $instance['term_slug'] ); ?>

                    <?php } ?>
                </select>
            </p>
            <hr>
            <p class="orderby-wrap">
                <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order by: ', self::$text_domain ); ?></label> 
                <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                    <option> -- Default orderby parameter -- </option>
                    <option <?php selected( $instance['orderby'], 'date') ?> value="date">Date</option>
                    <option <?php selected( $instance['orderby'], 'modified') ?> value="modified">Modified</option>
                    <option <?php selected( $instance['orderby'], 'title') ?> value="title">Title</option>
                    <option <?php selected( $instance['orderby'], 'author') ?> value="author">Author</option>
                    <option <?php selected( $instance['orderby'], 'name') ?> value="name">Name</option>
                    <option <?php selected( $instance['orderby'], 'id') ?> value="id">ID</option>
                    <option <?php selected( $instance['orderby'], 'parent') ?> value="parent">Parent</option>
                    <option <?php selected( $instance['orderby'], 'rand') ?> value="rand">Random</option>
                    <option <?php selected( $instance['orderby'], 'menu_order') ?> value="menu_order">Menu Order</option>
                    <option <?php selected( $instance['orderby'], 'comment_count') ?> value="comment_count">Comment Count</option>
                    <option <?php selected( $instance['orderby'], 'none') ?> value="none">None</option>
                </select>
            </p>            
            <p class="order-wrap">
                <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', self::$text_domain ); ?></label> 
                <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
                    <option> -- Default order parameter -- </option>
                    <option <?php selected( $instance['order'], 'asc') ?> value="asc">Ascending</option>
                    <option <?php selected( $instance['order'], 'desc') ?> value="desc">Descending</option>
                </select>
                <div><small>Order and orderby are not required, if blank will default to the default <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_BLANK">see here</a> for details</small></div>
            </p>
            <?php $this_id = $this->id; ?>
            <?php if ( strpos( $this_id, '_i_') === false ) { ?>
                <p>
                    <strong>This widget's name is </strong> <?php echo $this->id; ?>
                </p>
            <?php } ?>

        </div>
        <script>
        if (typeof(srpwSetupForms) == typeof(Function)) {
            srpwSetupForms();
        }
        </script>
        
        
        <?php 
    }


   /**
     * Get the posts
     *
     * Filter(s): 
     * 'srpw_get_args' - filter args in query for getting posts
     *
     * @param array $atts - list of attributes to use in the query
     * @param array $transient_key - transient key normalized to the widget's ID
     *
     * @return array Updated safe values to be saved.
     */    

    public function get( $atts ){
        $transient_key = $this->id;
        $posts = get_transient( $transient_key );
        if ( ! $posts ) {
            $number_posts = $atts['number_posts'];
            $post_type = $atts['post_type'];
            $term_slug = $atts['term_slug'];
            $taxonomy = $atts['taxonomy'];
            $order = $atts['order'];
            $orderby = $atts['orderby'];
            if ( $taxonomy === 'category' ) $taxonomy = 'category_name';  
            if ( $taxonomy === 'post_tag' ) $taxonomy = 'tag';  
            $args = array(
                    'posts_per_page' => $number_posts,
                    'post_type' => $post_type,
            );
            if ( $taxonomy && $term_slug ) {
                $args = array_merge( $args, array( $taxonomy => $term_slug ) );
            }
            if ( $orderby ) {
                $args = array_merge( $args, array( 'orderby' => $orderby ) );
            }
            if ( $order ) {
                $args = array_merge( $args, array( 'order' => $order ) );
            }        
            
            $args = apply_filters( 'srpw_get_args', $args );
            
            
            $posts = new WP_Query( $args );    
            set_transient( $transient_key, $posts, self::$transient_limit );
        } 
        return $posts;
    }

    /**
     * Enqueue CSS and JavaScripts
     */
    public static function enqueue(){
        if ( is_admin() ) {
            wp_enqueue_style( 'srpw-admin', plugins_url( 'css/' . 'srpw-admin.min.css', dirname( __FILE__ ) ), false, self::$ver );
            wp_enqueue_script( 'srpw-admin', plugins_url( 'js/' . 'srpw-admin.min.js', dirname( __FILE__ ) ), array( 'jquery' ), self::$ver, true );
            wp_localize_script( 'srpw-admin', 'srpwAjax', array(
                'srpwNonce' => wp_create_nonce( 'nonce_spw' ),
                )
            );            
        }   
    }

} 