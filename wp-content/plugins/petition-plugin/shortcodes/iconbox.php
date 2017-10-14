<?php

/**
 * Icon box shortcode
 */

if( !function_exists('conikal_iconbox_shortcode') ): 
    function conikal_iconbox_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'icon' => 'empty-star',
        'title' => 'Title Here',
        'description' => 'Description Here',
        'link' => '#',
        'size' => '110',
        'type' => 'normal',
        'style' => 'vertical',
        'align' => 'left',
        'invert' => 'no',
        'padding' => 'no',
        'color' => ''
    ), $attrs));

        $return_string = '<div class="ui ' . ($type != 'normal' ? $type . ' ' : '') . ($align != 'left' ? $align . ' aligned ' : '') . ($invert != 'no' ? 'inverted ' : '') . ($padding != 'no' ? $padding . ' ' : '') . 'segment icon-box" style="background-color: ' . esc_attr($color) . '">';
        $return_string .= '<a href="' . esc_url($link) . '">';
        $return_string .= '<h3 class="ui ' . ($invert != 'no' ? 'inverted ' : '') . ($style === 'vertical' ? 'icon ' : '') . 'header icon-header">';
        $return_string .= (filter_var($icon, FILTER_VALIDATE_URL) == true ? '<img src="' . esc_attr($icon) . ' " style="width: ' . esc_attr($size) . 'px">' : '<i class="' . esc_attr($icon) . ' icon" style="font-size: ' . esc_attr($size) . 'px"></i>' );
        $return_string .= '<div class="content">' . esc_html($title);
        $return_string .= '<div class="sub header">' . esc_html($description) . '</div>';
        $return_string .= '</div>';
        $return_string .= '</h3>';
        $return_string .= '</a>';
        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_iconbox_shortcode' );
function conikal_vc_iconbox_shortcode() {
   vc_map( array(
      "name" => __('Icon Box', 'petition'),
      "base" => 'iconbox',
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
            "heading" => __('Icon or Image', 'petition'),
            "param_name" => 'icon',
            "value" => '',
            "description" => __('Use icon font or URL image icon', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Title', 'petition'),
            "param_name" => 'title',
            "value" => '',
            "description" => __('Title in Box', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Description', 'petition'),
            "param_name" => 'description',
            "value" => '',
            "description" => __('Description below title', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Link', 'petition'),
            "param_name" => 'link',
            "value" => '#',
            "description" => __('Padding Header', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Size', 'petition'),
            "param_name" => 'size',
            "value" => 110,
            "description" => __('Size of Icon', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Type', 'petition'),
            "param_name" => 'type',
            "value" => array(
                'Normal' => 'normal',
                'Raise' => 'raise',
                'Stack' => 'stack',
                'Pile' => 'pile',
                'Circular' => 'circular',
                'Compact' => 'compact',
                'Vertical' => 'vertical',
                'Basic' => 'basic',
                ),
            "std" => 'normal',
            "description" => __('Type of Box', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Style', 'petition'),
            "param_name" => 'style',
            "value" => array(
                'Vertical' => 'vertical',
                'Horizontal' => 'horizontal',
                ),
            "std" => 'vertical',
            "description" => __('Style of Icon Layout', 'petition')
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
            "description" => __('Text align of Icon', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Invert', 'petition'),
            "param_name" => 'invert',
            "value" => array(
                'No' => 'no',
                'Yes' => 'yes'
                ),
            "std" => 'no',
            "description" => __('Inverse Box', 'petition')
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
                'Very Padded' => 'very padded'
                ),
            "std" => 'no',
            "description" => __('Padding of Box', 'petition')
        ),
        array(
            "type" => 'colorpicker',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Color', 'petition'),
            "param_name" => 'color',
            "value" => '#ffffff',
            "description" => __('Color of Box', 'petition')
        )
      )
   ) );
}

?>