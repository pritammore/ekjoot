<?php

/**
 * @package WordPress
 * @subpackage Petition
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
        array_push($buttons, "|", "parallax");
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

if( !function_exists('conikal_add_plugins') ): 
    function conikal_add_plugins($plugin_array) {
        $plugin_array['style_container'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['spaces'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['divider'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['buttons'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['header'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['segment'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['parallax'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['grid'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['column'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['infomation'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['iconbox'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['recent_petitions'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_petitions'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['recent_victory'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_victory'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['team'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['testimonials'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['latest_posts'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_posts'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['category'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
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

if( !function_exists('conikal_register_shortcodes') ): 
    function conikal_register_shortcodes() {
        add_shortcode('container', 'conikal_container_shortcode');
        add_shortcode('spaces', 'conikal_spaces_shortcode');
        add_shortcode('divider', 'conikal_divider_shortcode');
        add_shortcode('buttons', 'conikal_buttons_shortcode');
        add_shortcode('header', 'conikal_header_shortcode');
        add_shortcode('segment', 'conikal_segment_shortcode');
        add_shortcode('parallax', 'conikal_parallax_shortcode');
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
        add_shortcode('leaders', 'conikal_leaders_shortcode');
    }
endif;

add_action('init', 'conikal_register_plugin_buttons');
add_action('init', 'conikal_register_shortcodes');

/**
 * Container shortcode
 */
if( !function_exists('conikal_container_shortcode') ): 
    function conikal_container_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(), $attrs));

        $return_string = '<div class="ui container">' . do_shortcode($content) . '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Spaces shortcode
 */
if( !function_exists('conikal_spaces_shortcode') ): 
    function conikal_spaces_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'height' => '50'
    ), $attrs));

        $return_string = '<div style="height: ' . $height . 'px"></div>';

        wp_reset_query();
        return $return_string;
    }
endif;


/**
 * Divier shortcode
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

        wp_reset_query();
        return $return_string;
    }
endif;


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

        wp_reset_query();
        return $return_string;
    }
endif;


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


/**
 * Segment shortcode
 */

if( !function_exists('conikal_segment_shortcode') ): 
    function conikal_segment_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
        'type' => 'normal',
        'align' => 'left',
        'attach' => 'no',
        'invert' => 'no',
        'padding' => 'no',
        'color' => ''
    ), $attrs));

        $return_string = '<div class="ui ' . ($type != 'normal' ? $type . ' ' : '') . ($align != 'left' ? $align . ' aligned ' : '') . ($invert != 'no' ? 'inverted ' : '') . ($padding != 'no' ? $padding . ' ' : '') . 'segment" style="background-color: ' . esc_attr($color) . '">' . do_shortcode($content) . '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;


/**
 * Parallax shortcode
 */
if( !function_exists('conikal_parallax_shortcode') ): 
    function conikal_parallax_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'type' => 'image',
            'style' => 'scroll',
            'url' => '',
            'height' => '',
            'speed' => '0.5',
            'color' => '#000000',
            'opacity' => '0.4'
        ), $attrs));

        $jarallax = '{"type": "' . (conikal_get_browser_name() == 'firefox' ? 'scale' : esc_html($style) ) . '", "speed": ' . esc_html($speed) . '}';

        if ($type === 'image') {
            $return_string = '<div class="jarallax" style="background-image: url(' . esc_url($url) . '); height: ' . esc_html($height) . 'px; position: relative" ';
        } else {
            $return_string = '<div class="jarallax" data-jarallax-video="' . esc_url($url) . '" style="height: ' . esc_html($height) . 'px;" ';
        }
        $return_string .= "data-jarallax='" . $jarallax . "'>";
        $return_string .= '<div class="shadow" style="background-color: ' . esc_html(esc_attr($color)) . '; opacity: ' . esc_html($opacity) . '"></div>';
        $return_string .= do_shortcode($content);
        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Infomation shortcode
 */
if( !function_exists('conikal_infomation_shortcode') ): 
    function conikal_infomation_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'stitle' => 'Infomations Title',
            'show' => '4',
            'color' => '#000000',
            's1icon' => 'icon-pointer',
            's1title' => '1st Infomation Title',
            's1text' => '1st Infomation Text',
            's1link' => '#',
            's2icon' => 'icon-users',
            's2title' => '2nd Infomation Title',
            's2text' => '2nd Infomation Text',
            's2link' => '#',
            's3icon' => 'icon-home',
            's3title' => '3rd Infomation Title',
            's3text' => '3rd Infomation Text',
            's3link' => '3rd Infomation Link',
            's4icon' => 'icon-cloud-upload',
            's4title' => '4th Infomation Title',
            's4text' => '4th Infomation Text',
            's4link' => '#'
        ), $attrs));
        
        $return_string = '';
        if ($stitle) {
            $return_string .= '<h1 class="ui centered header" style="color: ' . esc_attr($color) . ' !important; margin-bottom: 50px">' . esc_html($stitle) . '</h1>';
        }

        if(esc_html($show) == '2') {
            $return_string .= '<div class="ui center aligned grid">';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet eight wide computer column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet eight wide computer column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        } else if(esc_html($show) == '3') {
            $return_string .= '<div class="ui center aligned stackable three column grid">';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="column">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s3icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s3title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s3text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        } else {
            $return_string .= '<div class="ui center aligned grid">';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s1icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s1title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s1text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';;
            $return_string .= '<i class="' . $s2icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s2title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s2text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s3icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s3title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s3text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="sixteen wide mobile eight wide tablet four wide computer column">';
            $return_string .= '<a href="' . esc_url($s4link) . '">';
            $return_string .= '<div class="ui icon header infomation-header" style="color:' . esc_attr($color) . '">';
            $return_string .= '<i class="' . $s4icon . ' icon"></i>';
            $return_string .= '<div class="content">' . esc_html($s4title);
            $return_string .= '<div class="sub header" style="color:' . esc_attr($color) . '">' . esc_html($s4text) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '</div>';
        }

        wp_reset_query();
        return $return_string;
    }
endif;

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

/**
 * Recent petitions shortcode
 */
if( !function_exists('conikal_recent_petitions_shortcode') ): 
    function conikal_recent_petitions_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Recent petitions',
            'show' => '4',
            'style' => 'list',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish' );

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }
            array_push($args['meta_query'], array(
                'key'     => 'petition_status',
                'value'   => '2',
                'compare' => '!='
            ));

        $posts = get_posts($args);

        $return_string = '<div class="ui left aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ($style == 'grid') {
            if ( $carousel == 'no') {
                $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
            } else {
                $return_string .= '<div class="post-carousel">';
            }
        }

        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $author_id = $post->post_author;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id);
            $comments = wp_count_comments($id);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
            $address = get_post_meta($id, 'petition_address', true);
            $city = get_post_meta($id, 'petition_city', true);
            $state = get_post_meta($id, 'petition_state', true);
            $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
            $zip = get_post_meta($id, 'petition_zip', true);
            $country = get_post_meta($id, 'petition_country', true);
            $lat = get_post_meta($id, 'petition_lat', true);
            $lng = get_post_meta($id, 'petition_lng', true);
            $receiver = get_post_meta($id, 'petition_receiver', true);
            $receiver = explode(',', $receiver);
            $position = get_post_meta($id, 'petition_position', true);
            $position = explode(',', $position);
            $goal = get_post_meta($id, 'petition_goal', true);
            $sign = get_post_meta($id, 'petition_sign', true);
            $updates = get_post_meta($id, 'petition_update', true);
            $thumb = get_post_meta($id, 'petition_thumb', true);
            $thumb = conikal_video_thumbnail($thumb);
            $status = get_post_meta($id, 'petition_status', true);

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.png';
            }
            $avatar = get_avatar_url( $author_id, array('size' => 35, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            if ($style == 'grid') {

                if ( $carousel == 'no') {
                    $return_string .= '<div class="card petition-card">';
                } else {
                    $return_string .= '<div>';
                    $return_string .= '<div class="ui card petition-card" style="margin-bottom: 2px;">';
                }
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<a href="' . esc_url($link) . '" class="image" data-bjax>';
                $return_string .= '<img class="ui fluid image" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= '</a>';
                $return_string .= '<div class="content" style="height: 140px;">';
                $return_string .= '<div class="header card-petition-title"><a href="' . esc_url($link) . '" data-bjax>' . esc_html($title) . '</a></div>';
                $return_string .= '<div class="meta">';
                $return_string .= esc_html('by ', 'petition') . '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="extra content">';
                if($comments->approved != 0) {
                $return_string .= '<span class="right floated"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                }
                $return_string .= '<span><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui bottom attached indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . esc_html($goal) . '">';
                $return_string .= '<div class="bar"><div class="progress"></div></div>';
                $return_string .= '</div>';

                $return_string .= '</div>';

                if ( $carousel != 'no') {
                    $return_string .= '</div>';
                }

            } else {
                $return_string .= '<div class="ui segments">';
                $return_string .= '<div class="ui segment">';
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column">';
                $return_string .= ' <div class="petition-content">';
                $return_string .= '     <div class="ui grid">';
                $return_string .= '         <div class="sixteen wide column">';
                $return_string .= '             <div class="ui header">';
                $return_string .= '                 <div class="content">';
                $return_string .= '                     <div class="sub header"><i class="send icon"></i>' . __('Petition to', 'petition') . ' ' . $receiver[0] . '</div>';
                $return_string .= '                     <a href="'. esc_url($link) . '" data-bjax>' . esc_html($title) . '</a>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '         <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">';
                $return_string .= '             <div class="text grey">' . esc_html($excerpt) . '</div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= ' <div class="ui grid">';
                $return_string .= '      <div class="petition-footer">';
                $return_string .= '         <div class="sixteen wide column">';
                if ($country || $state || $city) { 
                    $return_string .= '         <span class="text grey"><i class="marker icon"></i>' . ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</span>';
                }
                $return_string .= '             <div class="ui tiny indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . ($status == '1' ? esc_html($sign) : esc_html($goal) ) . '">';
                $return_string .= '                 <div class="bar">';
                $return_string .= '                     <div class="progress"></div>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= '</div>';
                $return_string .= '<div class="sixteen wide mobile six wide tablet six wide computer column">';
                $return_string .= ' <a class="ui fluid image" href="' . esc_url($link) . '" data-bjax>';
                $return_string .= '     <img class="ui fluid image"src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">';
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="ten wide tablet ten wide computer column tablet computer only">';
                $return_string .= '     <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '     <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition') . '</span>';
                if($category) {
                    $return_string .= ' <a class="ui label" href="' . get_category_link($category[0]->term_id) . '" data-bjax><i class="tag icon"></i>' . esc_html($category[0]->name) . '</a>';
                }
                $return_string .= '</div>';
                $return_string .= '<div class="six wide tablet six wide computer right aligned column tablet computer only">';
                $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax><strong>' . get_the_author_meta( 'display_name' , $author_id ) . '</strong>';
                $return_string .= '      <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';

                $return_string .= '<div class="thirteen wide column mobile only">';
                $return_string .= ' <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= ' <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="three wide right aligned column mobile only">';
                $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax>';
                $return_string .= '     <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
            }
        endforeach;

        if ($style == 'grid') {
            $return_string .= '</div>';
        }

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured petitions shortcode
 */
if( !function_exists('conikal_featured_petitions_shortcode') ): 
    function conikal_featured_petitions_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Featured petitions',
            'show' => '4',
            'style' => 'list',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'meta_key'         => 'petition_featured',
            'meta_value'       => '1',
            'post_status'      => 'publish' );

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }
            array_push($args['meta_query'], array(
                'key'     => 'petition_status',
                'value'   => '2',
                'compare' => '!='
            ));

        $posts = get_posts($args);

        $return_string = '<div class="ui left aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ($style == 'grid') {
            if ( $carousel == 'no') {
                $return_string .= '<div class="ui ' . esc_html($column) . ' stackable cards petition-cards">';
            } else {
                $return_string .= '<div class="post-carousel">';
            }
        }

        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $author_id = $post->post_author;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id);
            $comments = wp_count_comments($id);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
            $address = get_post_meta($id, 'petition_address', true);
            $city = get_post_meta($id, 'petition_city', true);
            $state = get_post_meta($id, 'petition_state', true);
            $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
            $zip = get_post_meta($id, 'petition_zip', true);
            $country = get_post_meta($id, 'petition_country', true);
            $lat = get_post_meta($id, 'petition_lat', true);
            $lng = get_post_meta($id, 'petition_lng', true);
            $receiver = get_post_meta($id, 'petition_receiver', true);
            $receiver = explode(',', $receiver);
            $position = get_post_meta($id, 'petition_position', true);
            $position = explode(',', $position);
            $goal = get_post_meta($id, 'petition_goal', true);
            $sign = get_post_meta($id, 'petition_sign', true);
            $updates = get_post_meta($id, 'petition_update', true);
            $thumb = get_post_meta($id, 'petition_thumb', true);
            $thumb = conikal_video_thumbnail($thumb);
            $status = get_post_meta($id, 'petition_status', true);

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.png';
            }
            $avatar = get_avatar_url( $author_id, array('size' => 35, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            if ($style == 'grid') {

                if ( $carousel == 'no') {
                    $return_string .= '<div class="card petition-card">';
                } else {
                    $return_string .= '<div>';
                    $return_string .= '<div class="ui card petition-card" style="margin-bottom: 2px;">';
                }
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<a href="' . esc_url($link) . '" class="image" data-bjax>';
                $return_string .= '<img class="ui fluid image" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= '</a>';
                $return_string .= '<div class="content" style="height: 140px;">';
                $return_string .= '<div class="header card-petition-title"><a href="' . esc_url($link) . '" data-bjax>' . esc_attr($title) . '</a></div>';
                $return_string .= '<div class="meta">';
                $return_string .= esc_html('by ', 'petition') . '<a href="' . get_author_posts_url( $author_id ) . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="extra content">';
                if($comments->approved != 0) {
                $return_string .= '<span class="right floated"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                }
                $return_string .= '<span><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui bottom attached indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . esc_html($goal) . '">';
                $return_string .= '<div class="bar"><div class="progress"></div></div>';
                $return_string .= '</div>';

                $return_string .= '</div>';

                if ( $carousel != 'no') {
                    $return_string .= '</div>';
                }

            } else {
                $return_string .= '<div class="ui segments">';
                $return_string .= '<div class="ui segment">';
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column">';
                $return_string .= ' <div class="petition-content">';
                $return_string .= '     <div class="ui grid">';
                $return_string .= '         <div class="sixteen wide column">';
                $return_string .= '             <div class="ui header">';
                $return_string .= '                 <div class="content">';
                $return_string .= '                     <div class="sub header"><i class="send icon"></i>' . __('Petition to', 'petition') . ' ' . $receiver[0] . '</div>';
                $return_string .= '                     <a href="'. esc_url($link) . '" data-bjax>' . esc_html($title) . '</a>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '         <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">';
                $return_string .= '             <div class="text grey">' . esc_html($excerpt) . '</div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= ' <div class="ui grid">';
                $return_string .= '      <div class="petition-footer">';
                $return_string .= '         <div class="sixteen wide column">';
                if ($country || $state || $city) { 
                    $return_string .= '         <span class="text grey"><i class="marker icon"></i>' . ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</span>';
                }
                $return_string .= '             <div class="ui tiny indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . ($status == '1' ? esc_html($sign) : esc_html($goal) ) . '">';
                $return_string .= '                 <div class="bar">';
                $return_string .= '                     <div class="progress"></div>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= '</div>';
                $return_string .= '<div class="sixteen wide mobile six wide tablet six wide computer column">';
                $return_string .= ' <a class="ui fluid image" href="' . esc_url($link) . '" data-bjax>';
                $return_string .= '     <img class="ui fluid image"src="' . esc_html($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">';
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="ten wide tablet ten wide computer column tablet computer only">';
                $return_string .= '     <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '     <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition') . '</span>';
                if($category) {
                    $return_string .= ' <a class="ui label" href="' . get_category_link($category[0]->term_id) . '"><i class="tag icon"></i>' . esc_html($category[0]->name) . '</a>';
                }
                $return_string .= '</div>';
                $return_string .= '<div class="six wide tablet six wide computer right aligned column tablet computer only">';
                $return_string .= ' <a href="' . get_author_posts_url( $author_id ) . '" data-bjax><strong>' . get_the_author_meta( 'display_name' , $author_id ) . '</strong>';
                $return_string .= '      <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';

                $return_string .= '<div class="thirteen wide column mobile only">';
                $return_string .= ' <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= ' <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="three wide right aligned column mobile only">';
                $return_string .= ' <a href="' . get_author_posts_url( $author_id ) . '" data-bjax>';
                $return_string .= '     <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
            }
        endforeach;

        if ($style == 'grid') {
            $return_string .= '</div>';
        }

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Recent victory petitions shortcode
 */
if( !function_exists('conikal_recent_victory_shortcode') ): 
    function conikal_recent_victory_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Victory petitions',
            'show' => '4',
            'style' => 'list',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish' );

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }
            array_push($args['meta_query'], array(
                'key'     => 'petition_status',
                'value'   => '2',
                'compare' => '!='
            ));

        $posts = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ($style == 'grid') {
            if ( $carousel == 'no') {
                $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
            } else {
                $return_string .= '<div class="post-carousel">';
            }
        }

        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $author_id = $post->post_author;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id);
            $comments = wp_count_comments($id);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
            $address = get_post_meta($id, 'petition_address', true);
            $city = get_post_meta($id, 'petition_city', true);
            $state = get_post_meta($id, 'petition_state', true);
            $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
            $zip = get_post_meta($id, 'petition_zip', true);
            $country = get_post_meta($id, 'petition_country', true);
            $lat = get_post_meta($id, 'petition_lat', true);
            $lng = get_post_meta($id, 'petition_lng', true);
            $receiver = get_post_meta($id, 'petition_receiver', true);
            $receiver = explode(',', $receiver);
            $position = get_post_meta($id, 'petition_position', true);
            $position = explode(',', $position);
            $goal = get_post_meta($id, 'petition_goal', true);
            $sign = get_post_meta($id, 'petition_sign', true);
            $updates = get_post_meta($id, 'petition_update', true);
            $thumb = get_post_meta($id, 'petition_thumb', true);
            $thumb = conikal_video_thumbnail($thumb);
            $status = get_post_meta($id, 'petition_status', true);

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.png';
            }
            $avatar = get_avatar_url( $author_id, array('size' => 35, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            if ($style == 'grid') {
                if ($sign >= $goal || $status == '1') {
                    if ( $carousel == 'no') {
                        $return_string .= '<div class="card petition-card">';
                    } else {
                        $return_string .= '<div>';
                        $return_string .= '<div class="ui card petition-card" style="margin-bottom: 2px;">';
                    }
                    if ($sign >= $goal || $status == '1') {
                        $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                    }
                    $return_string .= '<a href="' . esc_url($link) . '" class="image" data-bjax>';
                    $return_string .= '<img class="ui fluid image" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                    $return_string .= '</a>';
                    $return_string .= '<div class="content" style="height: 140px;">';
                    $return_string .= '<div class="header card-petition-title"><a href="' . esc_url($link) . '" data-bjax>' . esc_html($title) . '</a></div>';
                    $return_string .= '<div class="meta">';
                    $return_string .= esc_html('by ', 'petition') . '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="extra content">';
                    if($comments->approved != 0) {
                    $return_string .= '<span class="right floated"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                    }
                    $return_string .= '<span><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="ui bottom attached indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . esc_html($goal) . '">';
                    $return_string .= '<div class="bar"><div class="progress"></div></div>';
                    $return_string .= '</div>';

                    $return_string .= '</div>';

                    if ( $carousel != 'no') {
                        $return_string .= '</div>';
                    }
                }
            } else {
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui segments">';
                    $return_string .= '<div class="ui segment">';
                    if ($sign >= $goal || $status == '1') {
                        $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                    }
                    $return_string .= '<div class="ui grid">';
                    $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column">';
                    $return_string .= ' <div class="petition-content">';
                    $return_string .= '     <div class="ui grid">';
                    $return_string .= '         <div class="sixteen wide column">';
                    $return_string .= '             <div class="ui header">';
                    $return_string .= '                 <div class="content">';
                    $return_string .= '                     <div class="sub header"><i class="send icon"></i>' . __('Petition to', 'petition') . ' ' . $receiver[0] . '</div>';
                    $return_string .= '                     <a href="'. esc_url($link) . '" data-bjax>' . esc_html($title) . '</a>';
                    $return_string .= '                 </div>';
                    $return_string .= '             </div>';
                    $return_string .= '         </div>';
                    $return_string .= '         <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">';
                    $return_string .= '             <div class="text grey">' . esc_html($excerpt) . '</div>';
                    $return_string .= '         </div>';
                    $return_string .= '     </div>';
                    $return_string .= ' </div>';
                    $return_string .= ' <div class="ui grid">';
                    $return_string .= '      <div class="petition-footer">';
                    $return_string .= '         <div class="sixteen wide column">';
                    if ($country || $state || $city) { 
                        $return_string .= '         <span class="text grey"><i class="marker icon"></i>' . ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</span>';
                    }
                    $return_string .= '             <div class="ui tiny indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . ($status == '1' ? esc_html($sign) : esc_html($goal) ) . '">';
                    $return_string .= '                 <div class="bar">';
                    $return_string .= '                     <div class="progress"></div>';
                    $return_string .= '                 </div>';
                    $return_string .= '             </div>';
                    $return_string .= '         </div>';
                    $return_string .= '     </div>';
                    $return_string .= ' </div>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="sixteen wide mobile six wide tablet six wide computer column">';
                    $return_string .= ' <a class="ui fluid image" href="' . esc_url($link) . '" data-bjax>';
                    $return_string .= '     <img class="ui fluid image"src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">';
                    $return_string .= '<div class="ui grid">';
                    $return_string .= '<div class="ten wide tablet ten wide computer column tablet computer only">';
                    $return_string .= '     <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                    $return_string .= '     <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition') . '</span>';
                    if($category) {
                        $return_string .= ' <a class="ui label" href="' . get_category_link($category[0]->term_id) . '" data-bjax><i class="tag icon"></i>' . esc_html($category[0]->name) . '</a>';
                    }
                    $return_string .= '</div>';
                    $return_string .= '<div class="six wide tablet six wide computer right aligned column tablet computer only">';
                    $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax><strong>' . get_the_author_meta( 'display_name' , $author_id ) . '</strong>';
                    $return_string .= '      <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';

                    $return_string .= '<div class="thirteen wide column mobile only">';
                    $return_string .= ' <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                    $return_string .= ' <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="three wide right aligned column mobile only">';
                    $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax>';
                    $return_string .= '     <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                }
            }
        endforeach;

        if ($style == 'grid') {
            $return_string .= '</div>';
        }

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured victory petitions shortcode
 */
if( !function_exists('conikal_featured_victory_shortcode') ): 
    function conikal_featured_victory_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Victory petitions',
            'show' => '4',
            'style' => 'list',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'meta_key'         => 'petition_victory',
            'meta_value'       => '1',
            'post_status'      => 'publish' );

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }
            array_push($args['meta_query'], array(
                'key'     => 'petition_status',
                'value'   => '2',
                'compare' => '!='
            ));

        $posts = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ($style == 'grid') {
            if ( $carousel == 'no') {
                $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
            } else {
                $return_string .= '<div class="post-carousel">';
            }
        }

        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $author_id = $post->post_author;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id);
            $comments = wp_count_comments($id);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
            $address = get_post_meta($id, 'petition_address', true);
            $city = get_post_meta($id, 'petition_city', true);
            $state = get_post_meta($id, 'petition_state', true);
            $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
            $zip = get_post_meta($id, 'petition_zip', true);
            $country = get_post_meta($id, 'petition_country', true);
            $lat = get_post_meta($id, 'petition_lat', true);
            $lng = get_post_meta($id, 'petition_lng', true);
            $receiver = get_post_meta($id, 'petition_receiver', true);
            $receiver = explode(',', $receiver);
            $position = get_post_meta($id, 'petition_position', true);
            $position = explode(',', $position);
            $goal = get_post_meta($id, 'petition_goal', true);
            $sign = get_post_meta($id, 'petition_sign', true);
            $updates = get_post_meta($id, 'petition_update', true);
            $thumb = get_post_meta($id, 'petition_thumb', true);
            $thumb = conikal_video_thumbnail($thumb);
            $status = get_post_meta($id, 'petition_status', true);

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.png';
            }
            $avatar = get_avatar_url( $author_id, array('size' => 35, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            if ($style == 'grid') {
                if ( $carousel == 'no') {
                    $return_string .= '<div class="card petition-card">';
                } else {
                    $return_string .= '<div>';
                    $return_string .= '<div class="ui card petition-card" style="margin-bottom: 2px;">';
                }
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<a href="' . esc_url($link) . '" class="image" data-bjax>';
                $return_string .= '<img class="ui fluid image" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= '</a>';
                $return_string .= '<div class="content" style="height: 140px;">';
                $return_string .= '<div class="header card-petition-title"><a href="' . esc_url($link) . '" data-bjax>' . esc_html($title) . '</a></div>';
                $return_string .= '<div class="meta">';
                $return_string .= esc_html('by ', 'petition') . '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="extra content">';
                if($comments->approved != 0) {
                $return_string .= '<span class="right floated"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                }
                $return_string .= '<span><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui bottom attached indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . esc_html($goal) . '">';
                $return_string .= '<div class="bar"><div class="progress"></div></div>';
                $return_string .= '</div>';

                $return_string .= '</div>';

                if ( $carousel != 'no') {
                    $return_string .= '</div>';
                }
            } else {
                $return_string .= '<div class="ui segments">';
                $return_string .= '<div class="ui segment">';
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                }
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column">';
                $return_string .= ' <div class="petition-content">';
                $return_string .= '     <div class="ui grid">';
                $return_string .= '         <div class="sixteen wide column">';
                $return_string .= '             <div class="ui header">';
                $return_string .= '                 <div class="content">';
                $return_string .= '                     <div class="sub header"><i class="send icon"></i>' . __('Petition to', 'petition') . ' ' . $receiver[0] . '</div>';
                $return_string .= '                     <a href="'. esc_url($link) . '" data-bjax>' . esc_html($title) . '</a>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '         <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">';
                $return_string .= '             <div class="text grey">' . esc_html($excerpt) . '</div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= ' <div class="ui grid">';
                $return_string .= '      <div class="petition-footer">';
                $return_string .= '         <div class="sixteen wide column">';
                if ($country || $state || $city) { 
                    $return_string .= '         <span class="text grey"><i class="marker icon"></i>' . ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</span>';
                }
                $return_string .= '             <div class="ui tiny indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . ($status == '1' ? esc_html($sign) : esc_html($goal) ) . '">';
                $return_string .= '                 <div class="bar">';
                $return_string .= '                     <div class="progress"></div>';
                $return_string .= '                 </div>';
                $return_string .= '             </div>';
                $return_string .= '         </div>';
                $return_string .= '     </div>';
                $return_string .= ' </div>';
                $return_string .= '</div>';
                $return_string .= '<div class="sixteen wide mobile six wide tablet six wide computer column">';
                $return_string .= ' <a class="ui fluid image" href="' . esc_url($link) . '" data-bjax>';
                $return_string .= '     <img class="ui fluid image"src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">';
                $return_string .= '<div class="ui grid">';
                $return_string .= '<div class="ten wide tablet ten wide computer column tablet computer only">';
                $return_string .= '     <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= '     <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition') . '</span>';
                if($category) {
                    $return_string .= ' <a class="ui label" href="' . get_category_link($category[0]->term_id) . '" data-bjax><i class="tag icon"></i>' . esc_html($category[0]->name) . '</a>';
                }
                $return_string .= '</div>';
                $return_string .= '<div class="six wide tablet six wide computer right aligned column tablet computer only">';
                $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax><strong>' . get_the_author_meta( 'display_name' , $author_id ) . '</strong>';
                $return_string .= '      <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';

                $return_string .= '<div class="thirteen wide column mobile only">';
                $return_string .= ' <span class="ui primary label"><i class="user icon"></i>' . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                $return_string .= ' <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                $return_string .= '</div>';
                $return_string .= '<div class="three wide right aligned column mobile only">';
                $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax>';
                $return_string .= '     <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                $return_string .= ' </a>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
            }
        endforeach;

        if ($style == 'grid') {
            $return_string .= '</div>';
        }

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Team shortcode
 */
if( !function_exists('conikal_team_shortcode') ): 
    function conikal_team_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Our Team',
            'show' => '4'
        ), $attrs));

        $args = array(
                'posts_per_page'   => $show,
                'post_type'        => 'team',
                'orderby'          => 'post_date',
                'order'            => 'ASC',
                'post_status'      => 'publish' );
        $teams = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        $return_string .= '<div class="ui centered stackable grid">';
        foreach($teams as $team) : setup_postdata($team);
            $avatar = get_post_meta($team->ID, 'team_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.png';
            }
            $position = get_post_meta($team->ID, 'team_position', true);
            $living = get_post_meta($team->ID, 'team_living', true);
            $website = get_post_meta($team->ID, 'team_website', true);
            $facebook = get_post_meta($team->ID, 'team_facebook', true);
            $twitter = get_post_meta($team->ID, 'team_twitter', true);
            $google = get_post_meta($team->ID, 'team_googleplus', true);
            $linkedin = get_post_meta($team->ID, 'team_linkedin', true);

            $return_string .= '<div class="four wide center aligned column">';
            $return_string .= '<div class="ui circular bordered centered image team">';
            $return_string .= '<div class="ui dimmer"><div class="content"><div class="center">';
            $return_string .= '<a href="' . esc_url($facebook) . '" target="_blank" class="ui icon inverted small button"><i class="facebook f icon"></i></a>';
            $return_string .= '<a href="' . esc_url($twitter) . '" target="_blank" class="ui icon inverted small button"><i class="twitter f icon"></i></a>';
            $return_string .= '</div></div></div>';
            $return_string .= '<img src="' . esc_url($avatar_src) . '" alt="' . esc_attr($team->post_title) . '" height="200" />';
            $return_string .= '</div>';
            $return_string .= '<div class="ui header">';
            $return_string .= '<div class="content">' . esc_html($team->post_title);
            $return_string .= '<div class="sub header">' . esc_html($position) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Testimonials shortcode
 */
if( !function_exists('conikal_testimonials_shortcode') ): 
    function conikal_testimonials_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'type' => 'horizontal',
            'title' => 'Testimonials',
            'show' => 3
        ), $attrs));

        $args = array(
                'posts_per_page'   => $show,
                'post_type'        => 'testimonials',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_status'      => 'publish' );
        $posts = get_posts($args);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        $return_string .= '<div class="testimonial-carousel">';
        foreach($posts as $post) : setup_postdata($post);
            $avatar = get_post_meta($post->ID, 'testimonials_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.svg';
            }
            $job = get_post_meta($post->ID, 'testimonials_job', true);

            if ($type !== 'horizontal') {
                $return_string .= '<div>';
                $return_string .= '<div class="ui icon header">';
                $return_string .= '<img src="' . esc_url($avatar_src) . '" class="ui circular bordered tiny image" alt="' . esc_attr($post->post_title) . '" />';
                $return_string .= '<div class="testimonial-content">' . esc_html($post->post_content) . '</div>';
                $return_string .= '<div class="testimonial-author">' . esc_html($post->post_title) . '<span class="testimonial-job">' . ($job ? esc_html(' - ' . $job) : '') . '</span></div>';
                $return_string .= '</div>';
                $return_string .= '</div>';
            } else {
                $return_string .= '<div>';
                $return_string .= '<img src="' . esc_url($avatar_src) . '" class="ui left floated circular bordered tiny image" alt="' . esc_attr($post->post_title) . '" />';
                $return_string .= '<div class="testimonial-content">' . esc_html($post->post_content) . '</div>';
                $return_string .= '<div class="testimonial-author">' . esc_html($post->post_title) . '<span class="testimonial-job">' . ($job ? esc_html(' - ' . $job) : '') . '</span></div>';
                $return_string .= '</div>';
            }
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;


/**
 * Latest blog posts shortcode
 */
if( !function_exists('conikal_latest_posts_shortcode') ): 
    function conikal_latest_posts_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Latest posts',
            'show' => '4',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $args = array(
            'numberposts'   => $show,
            'post_type'     => 'post',
            'orderby'       => 'post_date',
            'order'         => 'DESC',
            'post_status'   => 'publish');
        $posts = wp_get_recent_posts($args, OBJECT);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ( $carousel == 'no') {
            $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
        } else {
            $return_string .= '<div class="post-carousel">';
        }

        foreach($posts as $post) : 
            if ( $carousel == 'no') {
                $return_string .= '<div class="card blogs post petition-card">';
            } else {
                $return_string .= '<div>';
                $return_string .= '<div class="ui card blogs post petition-card" style="margin-bottom: 2px;">';
            }
            
            $post_link = get_permalink($post->ID);
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'petition-thumbnail' );
            $return_string .= '<a href="' . esc_url($post_link) . '" target="_blank" class="image" data-bjax>';
            $return_string .= '<div class="ui dimmer"><div class="content"><div class="center">';
            $return_string .= '<div class="ui icon inverted circular big button"><i class="external icon"></i></div>';
            $return_string .= '</div></div></div>';
            if (has_post_thumbnail($post->ID)) {
                $return_string .= '<img class="ui fluid image" src="' . $post_image[0] . '" alt="' . esc_attr($post->post_title) . '">';
            } else {
                $return_string .= '<img class="ui fluid image" src="' . get_template_directory_uri() . '/images/thumbnail.svg' . '" alt="' . esc_attr($post->post_title) . '">';
            }
            $return_string .= '</a>';
            $return_string .= '<div class="content">';
            $return_string .= '<a href="' . esc_url($post_link) . '" class="header card-post-title" style="height: 80px;" data-bjax>' . esc_html($post->post_title) . '</a>';
            $return_string .= '</div>';
            $return_string .= '<div class="extra content">';
            $return_string .= '<span class="right floated">';
            $categories = get_the_category($post->ID);
            $separator = ' ';
            $output = '';
            if($categories) {
                foreach($categories as $category) {
                    $output .= '<a class="text-green" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'petition'), $category->name ) ) . '" data-bjax>' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                }
                $return_string .= trim($output, $separator);
            }
            $return_string .= '</span>';
            $post_date = get_the_date('j F, Y', $post->ID);
            $return_string .= '<span><i class="calendar outline icon"></i>' . esc_html($post_date) .'</span>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            if ( $carousel != 'no') {
                $return_string .= '</div>';
            }
        endforeach;

        $return_string .= '</div>';
        $return_string .= '<div class="ui center aligned basic segment"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '" class="ui basic large button" data-bjax>' . __('View all', 'petition') . '<i class="angle right icon"></i></a></div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured blog posts shortcode
 */
if( !function_exists('conikal_featured_posts_shortcode') ): 
    function conikal_featured_posts_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Featured Listed posts',
            'show' => '4',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $args = array(
            'numberposts'   => $show,
            'post_type'     => 'post',
            'orderby'       => 'post_date',
            'meta_key'      => 'post_featured',
            'meta_value'    => '1',
            'order'         => 'DESC',
            'post_status'   => 'publish');
        $posts = wp_get_recent_posts($args, OBJECT);

        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';

        if ( $carousel == 'no') {
            $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
        } else {
            $return_string .= '<div class="post-carousel">';
        }

        foreach($posts as $post) : 
            if ( $carousel == 'no') {
                $return_string .= '<div class="card blogs post petition-card">';
            } else {
                $return_string .= '<div>';
                $return_string .= '<div class="ui card blogs post petition-card" style="margin-bottom: 2px;">';
            }
            
            $post_link = get_permalink($post->ID);
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'petition-thumbnail' );
            $return_string .= '<a href="' . esc_url($post_link) . '" class="image" data-bjax>';
            $return_string .= '<div class="ui dimmer"><div class="content"><div class="center">';
            $return_string .= '<div class="ui icon inverted circular big button"><i class="external icon"></i></div>';
            $return_string .= '</div></div></div>';
            if (has_post_thumbnail($post->ID)) {
                $return_string .= '<img class="ui fluid image" src="' . $post_image[0] . '" alt="' . esc_attr($post->post_title) . '">';
            } else {
                $return_string .= '<img class="ui fluid image" src="' . get_template_directory_uri() . '/images/thumbnail.svg' . '" alt="' . esc_attr($post->post_title) . '">';
            }
            $return_string .= '</a>';
            $return_string .= '<div class="content">';
            $return_string .= '<a href="' . esc_url($post_link) . '" class="header card-post-title" style="height: 80px;" data-bjax>' . esc_html($post->post_title) . '</a>';
            $return_string .= '</div>';
            $return_string .= '<div class="extra content">';
            $return_string .= '<span class="right floated">';
            $categories = get_the_category($post->ID);
            $separator = ' ';
            $output = '';
            if($categories) {
                foreach($categories as $category) {
                    $output .= '<a class="text-green" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'petition'), $category->name ) ) . '" data-bjax>' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                }
                $return_string .= trim($output, $separator);
            }
            $return_string .= '</span>';
            $post_date = get_the_date('j F, Y', $post->ID);
            $return_string .= '<span><i class="calendar outline icon"></i>' . esc_html($post_date) .'</span>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            if ( $carousel != 'no') {
                $return_string .= '</div>';
            }
        endforeach;

        $return_string .= '</div>';
        $return_string .= '<div class="ui center aligned basic segment"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '" class="ui basic large button" data-bjax>' . __('View all', 'petition') . '<i class="angle right icon"></i></a></div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

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


/**
 * Category shortcode
 */

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


if( !function_exists('conikal_category_shortcode') ): 
    function conikal_category_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Categories',
            'type' => 'category',
            'slugs' => ''
        ), $attrs));

        $slugs = explode(',', $slugs);

        $col_count = 0;
        $total     = count( $slugs );
        $spans     = array();

        for ( $i = 0; $i < $total; $i++ ) {
            $span = 4;

            if ( $i == 0 ) {
                $span = 8;
            } elseif( $i == $total - 1 ) {
                $span = 16 - $col_count;
            } elseif ( $i == rand(1, $total) ) {
                $span = 8;
            }

            $col_count = $col_count + $span;

            if ( $col_count > 16 ) {
                $span = 16 - $col_count + $span;
            }

            if ( $span < 4 ) {
                $spans[ $i - 1 ] = $spans[ $i - 1 ] - 1;
                $span = 4;
            }

            if ( $col_count >= 16 ) {
                $col_count = 0;
            }

            $spans[$i] = $span;
        }


        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';
        $return_string .= '<div class="ui grid">';

        if ($type === 'category') {
            $taxonomy_name = 'petition_category';
            $term_meta_image = 'petition_category_image';
        } else {
            $taxonomy_name = 'petition_topics';
            $term_meta_image = 'petition_topics_image';
        }

        foreach ($slugs as $key => $id_slug) {
            $id_slug = str_replace(' ', '', $id_slug);
            $term = get_term_by('id', $id_slug, $taxonomy_name);
            if (!$term) {
                $term = get_term_by('slug', $id_slug, $taxonomy_name);
            }

            if ($term) {
                $term_image = get_term_meta($term->term_id, $term_meta_image, true);
                $term_link  = get_term_link($term->term_id, $taxonomy_name);
                $return_string .= '<div class="sixteen wide mobile eight wide tablet ' . convert_number_to_words($spans[$key]) . ' wide computer column">';
                $return_string .= '<a href="' . esc_url($term_link) . '">';
                $return_string .= '<div class="topic-card snip category">';
                $return_string .= '<img src="' . ($term_image ? esc_url($term_image) : '') . '" alt="' . $term->name . '"/>';
                $return_string .= '<div href="' . esc_url($term_link) . '" class="caption">';
                $return_string .= '<h3>' . $term->name . '</h3>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</a>';
                $return_string .= '</div>';
            }
        }

        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

if( !function_exists('conikal_leaders_shortcode') ): 
    function conikal_leaders_shortcode() {

        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1;
        $keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

        $args = array(
            'post_type' => 'decisionmakers',
            'posts_per_page' => "4",
            'post_status' => array('publish'),
            'paged' => '1'
        );
        $args['meta_query'] = array('relation' => 'AND');

        array_push($args['meta_query'], array(
            'key'     => 'post_whomi',
            'value'   => 0,
            'type'    => 'NUMERIC',
            'compare' => '='
        ));

        $decisionmakers = new WP_Query($args);
        wp_reset_query();
        wp_reset_postdata();

        $arrayDecisionmakers = array();
        if($decisionmakers->have_posts()) {
            while ( $decisionmakers->have_posts() ) {
                $decisionmakers->the_post();
                $id = get_the_ID();
                $name = get_the_title($id);
                $title =  wp_get_post_terms($id, 'decisionmakers_title', true);
                $title_name = ($title ? $title[0]->name : '');
                $organization =  wp_get_post_terms($id, 'decisionmakers_organization', true);
                $organization_name = ($organization ? $organization[0]->name : '');
                $excerpt = conikal_get_excerpt_by_id($id);
                $author = get_the_author_meta('ID');
                $user_data = get_userdata(intval($author));
                $user_login_name = $user_data->data->user_login;
                $file = home_url( '/' );
                $link = $file . 'author/'. $user_login_name;
                $up_bio = conikal_get_biographical_by_id($author);
                $up_avatar_orginal = get_user_meta($author, 'avatar_orginal', true);
                $up_avatar_id = get_user_meta($author, 'avatar_id', true);
                if ($up_avatar_orginal != '') {
                    $avatar = $up_avatar_orginal;
                } else {
                    $avatar = get_template_directory_uri().'/images/avatar.svg';
                }
                $arrayDecision = array(
                        'id' => $id, 
                        'link' => $link,
                        'name' => $name,
                        'title' => $title_name,
                        'organization' => $organization_name,
                        'description' => $title_name . __(' of ', 'petition') . $organization_name,
                        'excerpt' => $excerpt,
                        'avatar' => $avatar,
                        'author' => $author,
                        'up_bio' => $up_bio,
                    );

                $arrayDecision = (object) $arrayDecision;
                array_push($arrayDecisionmakers, $arrayDecision);
            }
        }
        
        $return_string = '<div class="ui left aligned basic segment"><h1 class="ui header">' . esc_html('Leaders - Individual') . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';
        $return_string .= '<div class="ui two column grid">';
        if(count($arrayDecisionmakers)>0) {
            foreach ( $arrayDecisionmakers as $decisionmakers ) {
                $up_id = $decisionmakers->ID;
                $up_link = $decisionmakers->link;
                $up_decisionmaker_name = $decisionmakers->name;
                $up_author_id = $decisionmakers->author;
                $up_author_name = $decisionmakers->title_name;
                $up_details = get_user_by( 'ID', $up_author_id );
                $up_bio = conikal_get_biographical_by_id($up_author_id);
                $up_type = get_user_meta($up_author_id, 'user_type', true);
                $up_birthday = get_user_meta($up_author_id, 'user_birthday', true);
                $up_gender = get_user_meta($up_author_id, 'user_gender', true);
                $up_address = get_user_meta($up_author_id, 'user_address', true);
                $up_pincode = get_user_meta($up_author_id, 'user_pincode', true);
                $up_neighborhood = get_user_meta($up_author_id, 'user_neighborhood', true);
                $up_state = get_user_meta($up_author_id, 'user_state', true);
                $up_city = get_user_meta($up_author_id, 'user_city', true);
                $up_country = get_user_meta($up_author_id, 'user_country', true);
                $up_lat = get_user_meta($up_author_id, 'user_lat', true);
                $up_lng = get_user_meta($up_author_id, 'user_lng', true);

                $user_meta = get_user_meta($up_author_id);
                $up_avatar_orginal = get_user_meta($up_author_id, 'avatar_orginal', true);
                $up_avatar_id = get_user_meta($up_author_id, 'avatar_id', true);
                if ($up_avatar_orginal != '') {
                    $avatar = $up_avatar_orginal;
                } else {
                    $avatar = get_template_directory_uri().'/images/avatar.svg';
                }

                $author_petitions = conikal_author_petitions($up_author_id);

                if($author_petitions) {
                    $total_p = $author_petitions->found_posts;
                } else {
                    $total_p = 0;
                }

                $decision_id = get_user_meta($up_author_id, 'user_decision', true);
                $decision_status = get_post_status( $decision_id );
                $decision_title = wp_get_post_terms( $decision_id, 'decisionmakers_title' );
                $decision_title = $decision_title ? $decision_title[0]->name : '';
                $decision_organization = wp_get_post_terms($decision_id, 'decisionmakers_organization');
                $decision_organization = $decision_organization ? $decision_organization[0]->name : '';
                $return_string .='<div class="column">';
                $return_string .= '<div class="ui segments petition-list-card">
                                        <div class="ui segment">
                                            <div class="ui grid">
                                                <div class="sixteen wide mobile six wide tablet six wide computer column" style="width:15% !important;float: left">';
                $return_string .= '<a class="ui fluid" href="' . esc_url($up_link). '" target="_blank" data-bjax>
                                                <img class="ui image" src="' .esc_url($avatar). '" alt="' . esc_attr($title). '"></a>
                                                </div>';
                $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column" style="width:85% !important;float: left">
                            <div class="">
                                <div class="ui grid">
                                    <div class="sixteen wide column">
                                        <div class="ui header mar-bot2">
                                            <div class="content">
                                                <a href="' .esc_url($up_link). '" data-bjax>' .esc_html($up_decisionmaker_name). '</a>
                                            </div>
                                        </div>';
                                        if ($up_bio) {
                                        $return_string .= '<span class="text grey">' .($up_bio ? esc_html($up_bio):''). '</span><br>';
                                        }
                                        $return_string .= '<div class="col-sm-12 mar-top10">';
                                            if ($decision_title) {
                                            $return_string .= '<div class="col-sm-6">
                                                <div class="">
                                                    <strong>Title:' . ($decision_title ? esc_html($decision_title) : '') . '</strong>
                                                </div>
                                            </div>';
                                            }
                                            if ($decision_organization) {
                                            $return_string .= '<div class="col-sm-6">
                                                <div class="">
                                                    <strong>Organization:'. ($decision_organization ? esc_html($decision_organization):'') . '</strong>
                                                </div>
                                            </div>';
                                            }
                            $return_string .= '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>';
            }
        }

        $return_string .= '</div>';


        /* Orginazation Leaders */
        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1;
        $keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

        $args = array(
            'post_type' => 'decisionmakers',
            'posts_per_page' => "4",
            'post_status' => array('publish'),
            'paged' => '1'
        );
        $args['meta_query'] = array('relation' => 'AND');

        array_push($args['meta_query'], array(
            'key'     => 'post_whomi',
            'value'   => 1,
            'type'    => 'NUMERIC',
            'compare' => '='
        ));

        $decisionmakers = new WP_Query($args);
        wp_reset_query();
        wp_reset_postdata();

        $arrayDecisionmakers = array();
        if($decisionmakers->have_posts()) {
            while ( $decisionmakers->have_posts() ) {
                $decisionmakers->the_post();
                $id = get_the_ID();
                $name = get_the_title($id);
                $title =  wp_get_post_terms($id, 'decisionmakers_title', true);
                $title_name = ($title ? $title[0]->name : '');
                $organization =  wp_get_post_terms($id, 'decisionmakers_organization', true);
                $organization_name = ($organization ? $organization[0]->name : '');
                $excerpt = conikal_get_excerpt_by_id($id);
                $author = get_the_author_meta('ID');
                $user_data = get_userdata(intval($author));
                $user_login_name = $user_data->data->user_login;
                $file = home_url( '/' );
                $link = $file . 'author/'. $user_login_name;
                $up_bio = conikal_get_biographical_by_id($author);
                $up_avatar_orginal = get_user_meta($author, 'avatar_orginal', true);
                $up_avatar_id = get_user_meta($author, 'avatar_id', true);
                if ($up_avatar_orginal != '') {
                    $avatar = $up_avatar_orginal;
                } else {
                    $avatar = get_template_directory_uri().'/images/avatar.svg';
                }
                $arrayDecision = array(
                        'id' => $id, 
                        'link' => $link,
                        'name' => $name,
                        'title' => $title_name,
                        'organization' => $organization_name,
                        'description' => $title_name . __(' of ', 'petition') . $organization_name,
                        'excerpt' => $excerpt,
                        'avatar' => $avatar,
                        'author' => $author,
                        'up_bio' => $up_bio,
                    );

                $arrayDecision = (object) $arrayDecision;
                array_push($arrayDecisionmakers, $arrayDecision);
            }
        }
        
        $return_string .= '<div class="ui left aligned basic segment" style="margin-top:40px;"><h1 class="ui header">' . esc_html('Leaders - Institution') . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';
        $return_string .= '<div class="ui two column grid">';
        if(count($arrayDecisionmakers)>0) {
            foreach ( $arrayDecisionmakers as $decisionmakers ) {
                $up_id = $decisionmakers->ID;
                $up_link = $decisionmakers->link;
                $up_decisionmaker_name = $decisionmakers->name;
                $up_author_id = $decisionmakers->author;
                $up_author_name = $decisionmakers->title_name;
                $up_details = get_user_by( 'ID', $up_author_id );
                $up_bio = conikal_get_biographical_by_id($up_author_id);
                $up_type = get_user_meta($up_author_id, 'user_type', true);
                $up_birthday = get_user_meta($up_author_id, 'user_birthday', true);
                $up_gender = get_user_meta($up_author_id, 'user_gender', true);
                $up_address = get_user_meta($up_author_id, 'user_address', true);
                $up_pincode = get_user_meta($up_author_id, 'user_pincode', true);
                $up_neighborhood = get_user_meta($up_author_id, 'user_neighborhood', true);
                $up_state = get_user_meta($up_author_id, 'user_state', true);
                $up_city = get_user_meta($up_author_id, 'user_city', true);
                $up_country = get_user_meta($up_author_id, 'user_country', true);
                $up_lat = get_user_meta($up_author_id, 'user_lat', true);
                $up_lng = get_user_meta($up_author_id, 'user_lng', true);

                $user_meta = get_user_meta($up_author_id);
                $up_avatar_orginal = get_user_meta($up_author_id, 'avatar_orginal', true);
                $up_avatar_id = get_user_meta($up_author_id, 'avatar_id', true);
                if ($up_avatar_orginal != '') {
                    $avatar = $up_avatar_orginal;
                } else {
                    $avatar = get_template_directory_uri().'/images/avatar.svg';
                }

                $author_petitions = conikal_author_petitions($up_author_id);

                if($author_petitions) {
                    $total_p = $author_petitions->found_posts;
                } else {
                    $total_p = 0;
                }

                $decision_id = get_user_meta($up_author_id, 'user_decision', true);
                $decision_status = get_post_status( $decision_id );
                $decision_title = wp_get_post_terms( $decision_id, 'decisionmakers_title' );
                $decision_title = $decision_title ? $decision_title[0]->name : '';
                $decision_organization = wp_get_post_terms($decision_id, 'decisionmakers_organization');
                $decision_organization = $decision_organization ? $decision_organization[0]->name : '';
                $return_string .='<div class="column">';
                $return_string .= '<div class="ui segments petition-list-card">
                                        <div class="ui segment">
                                            <div class="ui grid">
                                                <div class="sixteen wide mobile six wide tablet six wide computer column" style="width:15% !important;float: left">';
                $return_string .= '<a class="ui fluid" href="' . esc_url($up_link). '" target="_blank" data-bjax>
                                                <img class="ui image" src="' .esc_url($avatar). '" alt="' . esc_attr($title). '"></a>
                                                </div>';
                $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column" style="width:85% !important;float: left">
                            <div class="">
                                <div class="ui grid">
                                    <div class="sixteen wide column">
                                        <div class="ui header mar-bot2">
                                            <div class="content">
                                                <a href="' .esc_url($up_link). '" data-bjax>' .esc_html($up_decisionmaker_name). '</a>
                                            </div>
                                        </div>';
                                        if ($up_bio) {
                                        $return_string .= '<span class="text grey">' .($up_bio ? esc_html($up_bio):''). '</span><br>';
                                        }
                                        $return_string .= '<div class="col-sm-12 mar-top10">';
                                            if ($decision_title) {
                                            $return_string .= '<div class="col-sm-6">
                                                <div class="">
                                                    <strong>Title:' . ($decision_title ? esc_html($decision_title) : '') . '</strong>
                                                </div>
                                            </div>';
                                            }
                                            if ($decision_organization) {
                                            $return_string .= '<div class="col-sm-6">
                                                <div class="">
                                                    <strong>Organization:'. ($decision_organization ? esc_html($decision_organization):'') . '</strong>
                                                </div>
                                            </div>';
                                            }
                            $return_string .= '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>';
            }
        }
        $return_string .='<div class="ui basic vertical segment" style="width:100%">
                            <div class="ui grid">
                                <div class="eleven wide column" style="padding-right: 0"></div>
                                <div class="five wide right aligned column" style="padding-left: 0">
                                    <a href="/ekjoot/leaders/" class="bookmarkPetition" >see more leaders</a>
                                </div>
                            </div>
                        </div>';
        $return_string .= '</div>';

        return $return_string;
    }
endif;

?>