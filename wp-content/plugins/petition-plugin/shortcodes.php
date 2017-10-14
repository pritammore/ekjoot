<?php

/**
 * @package WordPress
 * @subpackage Petition Plugin
 */


/**
 *****************************************************************************
 * Shortcodes
 *****************************************************************************
 */

if( !function_exists('conikal_register_buttons') ): 
    function conikal_register_buttons($buttons) {
        array_push($buttons, "|", "style_container");
        array_push($buttons, "|", "spaces");
        array_push($buttons, "|", "divider");
        array_push($buttons, "|", "buttons");
        array_push($buttons, "|", "header");
        array_push($buttons, "|", "segment");
        array_push($buttons, "|", "grid");
        array_push($buttons, "|", "column");
        array_push($buttons, "|", "infomation");
        array_push($buttons, "|", "iconbox");
        array_push($buttons, "|", "recent_petitions");
        array_push($buttons, "|", "featured_petitions");
        array_push($buttons, "|", "recent_victory");
        array_push($buttons, "|", "featured_victory");
        array_push($buttons, "|", "team");
        array_push($buttons, "|", "testimonials");
        array_push($buttons, "|", "latest_posts");
        array_push($buttons, "|", "featured_posts");
        array_push($buttons, "|", "category");

        return $buttons;
    }
endif;


// Add shortcodes button
if( !function_exists('conikal_add_plugins') ): 
    function conikal_add_plugins($plugin_array) {
        $plugin_array['style_container'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['spaces'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['divider'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['buttons'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['header'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['segment'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['grid'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['column'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['infomation'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['iconbox'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['recent_petitions'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['featured_petitions'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['recent_victory'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['featured_victory'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['team'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['testimonials'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['latest_posts'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['featured_posts'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        $plugin_array['category'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
        return $plugin_array;
    }
endif;

if( !function_exists('conikal_register_plugin_buttons') ): 
    function conikal_register_plugin_buttons() {
        if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if(get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', 'conikal_add_plugins');
            add_filter('mce_buttons_3', 'conikal_register_buttons');
        }
    }
endif;


// Register Shortcodes
if( !function_exists('conikal_register_shortcodes') ): 
    function conikal_register_shortcodes() {
        add_shortcode('container', 'conical_container_shortcode');
        add_shortcode('spaces', 'conikal_spaces_shortcode');
        add_shortcode('divider', 'conikal_divider_shortcode');
        add_shortcode('buttons', 'conikal_buttons_shortcode');
        add_shortcode('header', 'conikal_header_shortcode');
        add_shortcode('segment', 'conikal_segment_shortcode');
        add_shortcode('grid', 'conikal_grid_shortcode');
        add_shortcode('column', 'conikal_column_shortcode');
        add_shortcode('infomation', 'conikal_infomation_shortcode');
        add_shortcode('iconbox', 'conikal_iconbox_shortcode');
        add_shortcode('recent_petitions', 'conikal_recent_petitions_shortcode');
        add_shortcode('featured_petitions', 'conikal_featured_petitions_shortcode');
        add_shortcode('recent_victory', 'conikal_recent_victory_shortcode');
        add_shortcode('featured_victory', 'conikal_featured_victory_shortcode');
        add_shortcode('team', 'conikal_team_shortcode');
        add_shortcode('testimonials', 'conikal_testimonials_shortcode');
        add_shortcode('latest_posts', 'conikal_latest_posts_shortcode');
        add_shortcode('featured_posts', 'conikal_featured_posts_shortcode');
        add_shortcode('category', 'conikal_category_shortcode');
    }
endif;

add_action('init', 'conikal_register_plugin_buttons');
add_action('init', 'conikal_register_shortcodes');


// Include Shortcodes
include plugin_dir_path( __FILE__ ) . 'shortcodes/container.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/spaces.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/divider.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/buttons.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/title.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/segment.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/infomation.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/iconbox.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/recent_petitions.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/featured_petitions.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/recent_victory.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/featured_victory.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/team.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/testimonials.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/lastest_posts.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/featured_posts.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/grid.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/column.php';
include plugin_dir_path( __FILE__ ) . 'shortcodes/category.php';

?>