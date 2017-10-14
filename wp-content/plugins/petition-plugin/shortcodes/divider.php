<?php

/**
 * Divider shortcode
 */

if( !function_exists('conikal_divider_shortcode') ): 
    function conikal_divider_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'type' => 'normal',
        'style' => 'no',
        'invert' => 'no',
        'text' => ''
    ), $attrs));

        $return_string = '<div class="ui ' . ($type != 'normal' ? $type . ' ' : '') . ($style != 'no' ? $style . ' ' : '') . ($invert != 'no' ? 'inverted ' : '') . 'divider">' . ($text ? $text : '') . '</div>';

        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_divider_shortcode' );
function conikal_vc_divider_shortcode() {
   vc_map( array(
      "name" => __('Divider', 'petition'),
      "base" => 'divider',
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
                'Normal' => 'normal',
                'Vertical' => 'vertical',
                'Horizontal' => 'horizontal',
                'Hidden' => 'hidden'
                ),
            "std" => 'normal',
            "description" => __('Type of Divider', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Style', 'petition'),
            "param_name" => 'style',
            "value" => array(
                'No style' => 'no',
                'Fitted' => 'fitted',
                'Section' => 'section'
                ),
            "std" => 'no',
            "description" => __('Style of Divider', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Invert', 'petition'),
            "param_name" => 'invert',
            "value" => array(
                'No' => 'no',
                'Yes' => 'yes',
                ),
            "std" => 'no',
            "description" => __('Invert Divider', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Text', 'petition'),
            "param_name" => 'text',
            "value" => '',
            "description" => __('Text Between Divider', 'petition')
        )
      )
   ) );
}


?>