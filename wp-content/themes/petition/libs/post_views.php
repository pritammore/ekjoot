<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Function to display post views
 */
if( !function_exists('conikal_set_post_views') ): 
    function conikal_set_post_views($post_id) {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_id, $count_key, true);
        if($count == '') {
            $count = 0;
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, '0');
        } else {
            $count++;
            update_post_meta($post_id, $count_key, $count);
        }
    }
endif;

/**
 * Function to get post views
 */
if( !function_exists('conikal_get_post_views') ): 
    function conikal_get_post_views($post_id) {
        $count_key = 'post_views_count';
        $count = get_post_meta($post_id, $count_key, true);
        if($count == '') {
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, '0');
            return "0";
        }
        return $count;
    }
endif;

?>