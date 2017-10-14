<?php

/**
 * Parallax shortcode
 */
if( !function_exists('conikal_parallax_shortcode') ): 
    function conikal_parallax_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'type' => 'image',
            'style' => 'scroll',
            'url' => '',
            'height' => '',
            'speed' => '0.5',
            'color' => '#000000',
            'opacity' => '0.4'
        ), $attrs));

        $jarallax = '{"type": "' . (conikal_get_browser_name() == 'firefox' ? 'scale' : esc_html($style) ) . '", "speed": ' . esc_html($speed) . '}';

        if ($type === 'image') {
            $return_string = '<div class="jarallax" style="background-image: url(' . esc_url($url) . '); height: ' . esc_html($height) . 'px; position: relative" ';
        } else {
            $return_string = '<div class="jarallax" data-jarallax-video="' . esc_url($url) . '" style="height: ' . esc_html($height) . 'px;" ';
        }
        $return_string .= "data-jarallax='" . $jarallax . "'>";
        $return_string .= '<div class="shadow" style="background-color: ' . esc_html(esc_attr($color)) . '; opacity: ' . esc_html($opacity) . '"></div>';
        $return_string .= do_shortcode($content);
        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

?>