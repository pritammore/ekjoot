<?php

/**
 * Button shortcode
 */

if( !function_exists('conikal_buttons_shortcode') ): 
    function conikal_buttons_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'type' => 'square',
        'size' => 'medium',
        'invert' => 'no',
        'color' => '',
        'icon' => '',
        'text' => '',
        'link' => '',
    ), $attrs));

        $return_string = '<a href="' . ($link ? esc_url($link) : '') . '" class="ui ' . ($type != 'square' ? $type . ' ' : '') . ($size != 'medium' ? $size . ' ' : '') . ($invert != 'no' ? 'inverted ' : '') . ($icon ? 'icon ' : '') . ($icon && $text ? 'labeled ' : '') . ($color != '' ? 'secondary ' : 'primary ') .'button" style="background-color: ' . ($color != '' ? esc_attr($color) : '') . '">' . ($icon ? '<i class="' . $icon . ' icon"></i>' : '') . ($text ? $text : '') . '</a>';

        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_buttons_shortcode' );
function conikal_vc_buttons_shortcode() {
   vc_map( array(
      "name" => __('Button', 'petition'),
      "base" => 'buttons',
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
                'Square' => 'square',
                'Circular' => 'circular',
                'Fluid' => 'fluid',
                ),
            "std" => 'square',
            "description" => __('Type of Button', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Size', 'petition'),
            "param_name" => 'size',
            "value" => array(
                'Mini' => 'mini',
                'Tiny' => 'tiny',
                'Small' => 'small',
                'Medium' => 'medium',
                'Large' => 'large',
                'Big' => 'big',
                'Huge' => 'huge',
                'Massive' => 'massive',
                ),
            "std" => 'medium',
            "description" => __('Size of Button', 'petition')
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
            "description" => __('Invert Button', 'petition')
        ),
        array(
            "type" => 'colorpicker',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Color', 'petition'),
            "param_name" => 'color',
            "value" => '#565656',
            "description" => __('Color of Button', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Icon', 'petition'),
            "param_name" => 'icon',
            "value" => '',
            "description" => __('Text Icon Button', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Text', 'petition'),
            "param_name" => 'text',
            "value" => '',
            "description" => __('Text Name Button', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Link', 'petition'),
            "param_name" => 'link',
            "value" => '#',
            "description" => __('Link in Button', 'petition')
        )
      )
   ) );
}

?>