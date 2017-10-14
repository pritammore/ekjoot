<?php

/**
 * Title shortcode
 */

if( !function_exists('conikal_header_shortcode') ): 
    function conikal_header_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'border' => 'short',
        'align' => 'left',
        'invert' => 'no',
        'padding' => 'no',
        'title' => '',
    ), $attrs));

        $return_string = '<div class="ui basic ' . ($align != 'left' ? $align . ' aligned ' : '') . ($padding != 'no' ? $padding . ' ' : '') . 'segment">';
        $return_string .= '<h1 class="ui ' . ($invert != 'no' ? 'inverted ' : '') . 'header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider' . ($border != 'short' ? ' ' . $border : '') . '"></div>';
        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_header_shortcode' );
function conikal_vc_header_shortcode() {
   vc_map( array(
      "name" => __('Header', 'petition'),
      "base" => 'header',
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
            "heading" => __('Border', 'petition'),
            "param_name" => 'border',
            "value" => array(
                'None' => 'none',
                'Short' => 'short',
                'Long' => 'long',
                'Full' => 'full',
                ),
            "std" => 'short',
            "description" => __('Border below Header', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Text Align', 'petition'),
            "param_name" => 'align',
            "value" => array(
                'Left' => 'left',
                'Right' => 'right',
                'Center' => 'center'
                ),
            "std" => 'left',
            "description" => __('Align text Header', 'petition')
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
            "description" => __('Invert Header', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Padding', 'petition'),
            "param_name" => 'padding',
            "value" => array(
                'No' => 'no',
                'Padded' => 'padded',
                'Very Padded' => 'very padded',
                ),
            "std" => 'no',
            "description" => __('Padding Header', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Title', 'petition'),
            "param_name" => 'title',
            "value" => '',
            "description" => __('Text Title Header', 'petition')
        )
      )
   ) );
}


?>