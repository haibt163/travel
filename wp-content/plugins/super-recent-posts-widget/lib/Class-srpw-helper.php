<?php

class Srpw_helper {
    public static function post_types(){
        $recent_post_types = get_post_types( array( '_builtin'=> false ) );
        $recent_post_types[] = 'post';
        $recent_post_types[] = 'page';
        $recent_post_types = apply_filters( 'srpw_post_types', $recent_post_types );
        return $recent_post_types;
    }

    public static function get_taxonomies( $post_type, $selected = null ){
        
        $taxonomies = get_object_taxonomies( $post_type );
        $taxonomies = apply_filters( 'srpw_taxonomies', $taxonomies );
        if ( $taxonomies ){
            $output = '<option value=""> -- No Specific Taxonomy -- </option>';
            foreach( $taxonomies as $taxonomy ){
                $selected_option = '';
                if ( $selected !== null ) {
                    $selected_option = selected( $taxonomy, $selected, false );
                }

                $output .= '<option value="' . $taxonomy . '" ' . $selected_option . '>' . $taxonomy . '</option>';
            }
        } else {
            $output = '<option value=""> -- No Taxonomies Available for ' . $post_type . ' -- </option>';
        }
        return $output;
    }

    public static function get_terms( $taxonomy, $selected = null ){
        
        $terms = get_terms( $taxonomy );
        if ( $terms ) {
            $output = '<option value=""> -- Choose a Term -- </option>';
            foreach( $terms as $term ){
                $selected_option = '';
                $id = $term->slug;
                $name = $term->name;
                if ( $selected !== null ) {
                    $selected_option = selected( $id, $selected, false );
                }
                $output .= '<option value="' . $id . '" ' . $selected_option . '>' . $name . '</option>';
            }
        } else {
            $output = '<option value=""> -- No Terms available for ' . $taxonomy . ' -- </option>';
        }
        return $output;
    }

    public static function get_post_types( $selected = null ){
        $output = '<option value=""> -- Choose a Post Type -- </option>';
        foreach( Srpw_helper::post_types() as $post_type ){
            $selected_output = '';
            if ( $selected !== null ) {
                $selected_output = selected( $post_type, $selected, false );
            }
            $output .= '<option ' . $selected_output . 'value=' . $post_type . '>' . $post_type . '</option>';
        }
        return $output;
    }
}


