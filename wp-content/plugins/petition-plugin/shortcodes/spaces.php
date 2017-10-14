<?php 

/**
 * Spaces shortcode
 */
if( !function_exists('conikal_spaces_shortcode') ): 
    function conikal_spaces_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'height' => '50'
    ), $attrs));

        $return_string = '<div style="height: ' . $height . 'px"></div>';

        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_spaces_shortcode' );
function conikal_vc_spaces_shortcode() {
   vc_map( array(
      "name" => __('Spaces', 'petition'),
      "base" => 'spaces',
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
            "heading" => __('Height', 'petition'),
            "param_name" => 'height',
            "value" => 50,
            "description" => __('Set hight of spaces', 'petition')
        )
      )
   ) );
}

?>