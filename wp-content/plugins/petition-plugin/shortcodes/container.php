<?php 

/**
 * Container shortcode
 */
if( !function_exists('conical_container_shortcode') ): 
    function conical_container_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(), $attrs));

        $return_string = '<div class="ui container">' . do_shortcode($content) . '</div>';

        return $return_string;
    }
endif;

?>