<?php

/**
 * Latest blog posts shortcode
 */
if( !function_exists('conikal_latest_posts_shortcode') ): 
    function conikal_latest_posts_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Latest Posts',
            'show' => '4',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_appearance_settings = get_option('conikal_appearance_settings','');
        $view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'     => 'post',
            'orderby'       => 'post_date',
            'order'         => 'DESC',
            'post_status'   => 'publish');
        $posts = wp_get_recent_posts($args, OBJECT);

        $return_string = '';
        if ($title != '') {
            $return_string .= '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
            $return_string .= '<div class="title-divider"></div></div>';
        }

        if ( $carousel == 'no') {
            $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
        } else {
            $return_string .= '<div class="post-carousel">';
        }

        foreach($posts as $post) : 
            if ( $carousel == 'no') {
                $return_string .= '<div class="card blogs post petition-card">';
            } else {
                $return_string .= '<div>';
                $return_string .= '<div class="ui card blogs post petition-card" style="margin-bottom: 2px;">';
            }
            
            $post_link = get_permalink($post->ID);
            $post_comments = wp_count_comments($post->ID);
            $post_excerpt = conikal_get_excerpt_by_id($post->ID, 15);
            $post_view = conikal_format_number('%!,0i', (int) conikal_get_post_views($post->ID), true);
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'petition-thumbnail' );
            $return_string .= '<a href="' . esc_url($post_link) . '" target="_blank" class="image blurring" data-bjax>';
            $return_string .= '<div class="ui dimmer"><div class="content">';
            $return_string .= '<div class="center"><div class="ui icon inverted circular ' . ($column == 'three' ? 'big ' : '') . 'button"><i class="external icon"></i></div></div>';
            $return_string .= '<div class="view-counter"><i class="comments icon"></i>' . $post_comments->approved;
            if ($view_counter != '') {
                $return_string .= '<i class="eye icon"></i>' . esc_html($post_view);
            }
            $return_string .= '</div></div></div>';
            if (has_post_thumbnail($post->ID)) {
                $return_string .= '<img class="ui fluid image" src="' . $post_image[0] . '" alt="' . esc_attr($post->post_title) . '">';
            } else {
                $return_string .= '<img class="ui fluid image" src="' . get_template_directory_uri() . '/images/thumbnail.svg' . '" alt="' . esc_attr($post->post_title) . '">';
            }
            $return_string .= '</a>';
            $return_string .= '<div class="content petition-content">';
            $categories = get_the_category($post->ID);
            $separator = ' ';
            $output = '';
            if($categories) {
                foreach($categories as $category) {
                    $output .= '<a class="ui tiny label" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'petition'), $category->name ) ) . '" data-bjax>' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                }
                $return_string .= trim($output, $separator);
            }
            $return_string .= '<div class="header card-post-title"><a href="' . esc_url($post_link) . '" data-bjax>' . esc_html($post->post_title) . '</a></div>';
            if ($column == 'three') {
            $return_string .= '<div class="description">';
            $return_string .= '<div class="text grey">' . esc_html($post_excerpt) . '</div>';
            $return_string .= '</div>';
            }
            $return_string .= '</div>';
            $return_string .= '<div class="extra content">';
            $return_string .= '<span class="right floated">';
            $return_string .= '<a href="' . get_author_posts_url( $post->post_author ) . '">' . get_the_author_meta( 'display_name' , $post->post_author ) . '</a>';
            $return_string .= '</span>';
            $post_date = get_the_date('j F, Y', $post->ID);
            $return_string .= '<span><i class="calendar outline icon"></i>' . esc_html($post_date) .'</span>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            if ( $carousel != 'no') {
                $return_string .= '</div>';
            }
        endforeach;

        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_latest_posts_shortcode' );
function conikal_vc_latest_posts_shortcode() {
   vc_map( array(
      "name" => __('Recent Posts', 'petition'),
      "base" => 'latest_posts',
      "class" => '',
      "category" => __('Petition WP', 'petition'),
      'admin_enqueue_js' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.js',
      'admin_enqueue_css' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.css',
      "icon" => plugin_dir_url( __FILE__ ) . 'images/petition-vc-icon.svg',
      "params" => array(
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Title', 'petition'),
            "param_name" => 'title',
            "value" => 'Recent Posts',
            "description" => __('Title of Segment', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Show Number', 'petition'),
            "param_name" => 'show',
            "value" => 4,
            "description" => __('Number of Petitions', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Carousel Mode', 'petition'),
            "param_name" => 'carousel',
            "value" => array(
                'No' => 'no',
                'Yes' => 'yes',
                ),
            "std" => 'no',
            "description" => __('Display Petitions follow Carousel style', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Column', 'petition'),
            "param_name" => 'column',
            "value" => array(
                '1' => 'one',
                '2' => 'two',
                '3' => 'three',
                '4' => 'four',
                '5' => 'five'
                ),
            "std" => 'four',
            "description" => __('Column of Petitions', 'petition')
        )
      )
   ) );
}

?>