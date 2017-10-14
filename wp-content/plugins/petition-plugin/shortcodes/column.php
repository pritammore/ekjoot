<?php

/**
 * Columns shortcode
 */
if( !function_exists('conikal_column_shortcode') ): 
    function conikal_column_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'align' => 'left',
            'number' => '',
        ), $attrs));

        $return_string = '';

        switch($number) {
            case 'no':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'column">' . do_shortcode($content) . '</div>';
                break;
            case 'one':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'one wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'two':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'two wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'three':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'three wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'four':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'four wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'five':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'five wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'six':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'six wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'seven':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'seven wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'eight':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'eight wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'nine':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'nice wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'ten':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'ten wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'eleven':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'eleven wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'twelve':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'twelve wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'thirteen':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'thirteen wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'fourteen':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'fourteen wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'fifteen':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'fifteen wide column">' . do_shortcode($content) . '</div>';
                break;
            case 'sixteen':
                $return_string .= '<div class="' . ($align != 'left' ? $align . ' aligned ' : '') . 'sixteen wide column">' . do_shortcode($content) . '</div>';
                break;
        }

        wp_reset_query();
        return $return_string;
    }
endif;

?>