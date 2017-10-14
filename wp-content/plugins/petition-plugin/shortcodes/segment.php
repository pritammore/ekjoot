<?php

/**
 * Segment shortcode
 */

if( !function_exists('conikal_segment_shortcode') ): 
    function conikal_segment_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'type' => 'normal',
        'align' => 'left',
        'attach' => 'no',
        'invert' => 'no',
        'padding' => 'no',
        'color' => ''
    ), $attrs));

        $return_string = '<div class="ui ' . ($type != 'normal' ? $type . ' ' : '') . ($align != 'left' ? $align . ' aligned ' : '') . ($invert != 'no' ? 'inverted ' : '') . ($padding != 'no' ? $padding . ' ' : '') . 'segment" style="background-color: ' . esc_attr($color) . '">' . do_shortcode($content) . '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

?>