<?php

/**
 * Team shortcode
 */
if( !function_exists('conikal_team_shortcode') ): 
    function conikal_team_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Our Team',
            'show' => '4'
        ), $attrs));

        $args = array(
                'posts_per_page'   => $show,
                'post_type'        => 'team',
                'orderby'          => 'post_date',
                'order'            => 'ASC',
                'post_status'      => 'publish' );
        $teams = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        $return_string .= '<div class="ui centered stackable grid">';
        foreach($teams as $team) : setup_postdata($team);
            $avatar = get_post_meta($team->ID, 'team_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.png';
            }
            $position = get_post_meta($team->ID, 'team_position', true);
            $living = get_post_meta($team->ID, 'team_living', true);
            $website = get_post_meta($team->ID, 'team_website', true);
            $facebook = get_post_meta($team->ID, 'team_facebook', true);
            $twitter = get_post_meta($team->ID, 'team_twitter', true);
            $google = get_post_meta($team->ID, 'team_googleplus', true);
            $linkedin = get_post_meta($team->ID, 'team_linkedin', true);

            $return_string .= '<div class="four wide center aligned column">';
            $return_string .= '<div class="ui circular bordered centered image team">';
            $return_string .= '<div class="ui dimmer"><div class="content"><div class="center">';
            $return_string .= '<a href="' . esc_url($facebook) . '" target="_blank" class="ui icon inverted small button"><i class="facebook f icon"></i></a>';
            $return_string .= '<a href="' . esc_url($twitter) . '" target="_blank" class="ui icon inverted small button"><i class="twitter f icon"></i></a>';
            $return_string .= '</div></div></div>';
            $return_string .= '<img src="' . esc_url($avatar_src) . '" alt="' . esc_attr($team->post_title) . '" height="200" />';
            $return_string .= '</div>';
            $return_string .= '<div class="ui header">';
            $return_string .= '<div class="content">' . esc_html($team->post_title);
            $return_string .= '<div class="sub header">' . esc_html($position) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_team_shortcode' );
function conikal_vc_team_shortcode() {
   vc_map( array(
      "name" => __('Team', 'petition'),
      "base" => 'team',
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
            "value" => '',
            "description" => __('Title of Team', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Show', 'petition'),
            "param_name" => 'show',
            "value" => 4,
            "description" => __('Number of Display', 'petition')
        )
      )
   ) );
}

?>