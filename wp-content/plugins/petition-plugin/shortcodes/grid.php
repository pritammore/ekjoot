<?php

/**
 * Grid shortcode
 */
if( !function_exists('conikal_grid_shortcode') ): 
    function conikal_grid_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'align' => 'left',
            'gutter' => 'no',
            'divi' => 'no',
            'equal' => 'no',
            'number' => 'no'
        ), $attrs));

        if ($align == 'right') {
            $align = 'right aligned';
        } elseif ($align == 'left') {
            $align = 'left aligned';
        } elseif ($align == 'center') {
            $align = 'centered';
        } else {
            $align = '';
        }

        $return_string = '<div class="ui stackable ' . ($align != 'left' ? $align . ' ' : '') . ($gutter != 'no' ? $gutter . ' ' : '') . ($divi != 'no' ? $divi . ' ' : '') . ($equal != 'no' ? $equal . ' ' : '') . ($number != 'no' ? $number . ' conlumn ' : '') . 'grid">' . do_shortcode($content) . '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

?>