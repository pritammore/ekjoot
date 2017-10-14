<?php

/**
 * Testimonials shortcode
 */
if( !function_exists('conikal_testimonials_shortcode') ): 
    function conikal_testimonials_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'type' => 'horizontal',
            'title' => 'Testimonials',
            'show' => 3
        ), $attrs));

        $args = array(
                'posts_per_page'   => $show,
                'post_type'        => 'testimonials',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_status'      => 'publish' );
        $posts = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        $return_string .= '<div class="testimonial-carousel">';
        foreach($posts as $post) : setup_postdata($post);
            $avatar = get_post_meta($post->ID, 'testimonials_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.svg';
            }
            $job = get_post_meta($post->ID, 'testimonials_job', true);

            if ($type !== 'horizontal') {
                $return_string .= '<div>';
                $return_string .= '<div class="ui icon header">';
                $return_string .= '<img src="' . esc_url($avatar_src) . '" class="ui circular bordered tiny image" alt="' . esc_attr($post->post_title) . '" />';
                $return_string .= '<div class="testimonial-content">' . esc_html($post->post_content) . '</div>';
                $return_string .= '<div class="testimonial-author">' . esc_html($post->post_title) . '<span class="testimonial-job">' . ($job ? esc_html(' - ' . $job) : '') . '</span></div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
            } else {
                $return_string .= '<div>';
                $return_string .= '<img src="' . esc_url($avatar_src) . '" class="ui left floated circular bordered tiny image" alt="' . esc_attr($post->post_title) . '" />';
                $return_string .= '<div class="testimonial-content">' . esc_html($post->post_content) . '</div>';
                $return_string .= '<div class="testimonial-author">' . esc_html($post->post_title) . '<span class="testimonial-job">' . ($job ? esc_html(' - ' . $job) : '') . '</span></div>';
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

add_action( 'vc_before_init', 'conikal_vc_testimonials_shortcode' );
function conikal_vc_testimonials_shortcode() {
   vc_map( array(
      "name" => __('Testimonials', 'petition'),
      "base" => 'testimonials',
      "class" => '',
      "category" => __('Petition WP', 'petition'),
      'admin_enqueue_js' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.js',
      'admin_enqueue_css' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.css',
      "icon" => plugin_dir_url( __FILE__ ) . 'images/petition-vc-icon.svg',
      "params" => array(
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Type', 'petition'),
            "param_name" => 'type',
            "value" => array(
                'Horizontal' => 'horizontal',
                'Vertical' => 'vertical'
                ),
            "std" => 'horizontal',
            "description" => __('Type of Testimonials', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Title', 'petition'),
            "param_name" => 'title',
            "value" => '',
            "description" => __('Title of Team', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Show', 'petition'),
            "param_name" => 'show',
            "value" => 3,
            "description" => __('Number of Display', 'petition')
        )
      )
   ) );
}

?>