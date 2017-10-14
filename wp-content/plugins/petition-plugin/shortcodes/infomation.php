<?php

/**
 * Infomation shortcode
 */
if( !function_exists('conikal_infomation_shortcode') ): 
    function conikal_infomation_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'stitle' => 'Infomations Title',
            'show' => '4',
            'color' => '#000000',
            's1icon' => 'icon-pointer',
            's1title' => '1st Infomation Title',
            's1text' => '1st Infomation Text',
            's1link' => '#',
            's2icon' => 'icon-users',
            's2title' => '2nd Infomation Title',
            's2text' => '2nd Infomation Text',
            's2link' => '#',
            's3icon' => 'icon-home',
            's3title' => '3rd Infomation Title',
            's3text' => '3rd Infomation Text',
            's3link' => '3rd Infomation Link',
            's4icon' => 'icon-cloud-upload',
            's4title' => '4th Infomation Title',
            's4text' => '4th Infomation Text',
            's4link' => '#'
        ), $attrs));
        
        $return_string = '';
        if ($stitle) {
            $return_string .= '<h1 class="ui centered header" style="color: ' . esc_attr($color) . ' !important; margin-bottom: 50px">' . esc_html($stitle) . '</h1>';
        }

        if(esc_html($show) == '2') {
            $return_string .= '<div class="ui center aligned grid">';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet eight wide computer column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet eight wide computer column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        } else if(esc_html($show) == '3') {
            $return_string .= '<div class="ui center aligned stackable three column grid">';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s3icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s3title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s3text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        } else {
            $return_string .= '<div class="ui center aligned grid">';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';;
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s3icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s3title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s3text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s4link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s4icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s4title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s4text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        }

        wp_reset_query();
        return $return_string;
    }
endif;

?>