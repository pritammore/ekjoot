<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


// PETITION PAGE SETUP

if( !function_exists('conikal_setup') ): 
    function conikal_setup() {

        load_theme_textdomain('petition', get_template_directory() . '/languages');

        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'automatic-feed-links' );
            add_theme_support( 'post-thumbnails' );
            set_post_thumbnail_size( 1920, 1080, true );
        }

        if ( ! isset( $content_width ) ) $content_width = 1140;

        if(is_admin()) {

            $page_check = get_page_by_title('Topics search');
            if (!isset($page_check->ID)) {
                $my_post = array(
                    'post_title' => 'Topics search',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', 'topics-search.php');
            }

            $page_check = get_page_by_title('Petitions search');
            if (!isset($page_check->ID)) {
                $my_post = array(
                    'post_title' => 'Petitions search',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', 'petitions-search.php');
            }

            $page_check = get_page_by_title('Organization search');
            if (!isset($page_check->ID)) {
                $my_post = array(
                    'post_title' => 'Organization search',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', 'organization-search.php');
            }

            $page_check = get_page_by_title('Decision makers search');
            if (!isset($page_check->ID)) {
                $my_post = array(
                    'post_title' => 'Decision makers search',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', 'decision-makers-search.php');
            }

            $page_check = get_page_by_title('Download CSV');
            if (!isset($page_check->ID)) {
                $my_post = array(
                    'post_title' => 'Download CSV',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', 'download-csv.php');
            }
        }

        load_theme_textdomain('petition', get_template_directory() . '/languages/');

        register_nav_menus( array(
            'primary'   => __( 'Top primary menu', 'petition'),
            'category'  => __( 'Category menu','petition'),
            'footer'  => __( 'Footer menu','petition')
        ) );


        // general settings default values
        $conikal_general_settings = get_option('conikal_general_settings');
        if (!isset($conikal_general_settings['conikal_country_field']) || ( isset($conikal_general_settings['conikal_country_field']) && $conikal_general_settings['conikal_country_field'] == '') ) {
            $conikal_general_settings['conikal_country_field'] = 'US';
        }
        if (!isset($conikal_general_settings['conikal_minimum_signature_field']) || ( isset($conikal_general_settings['conikal_minimum_signature_field']) && $conikal_general_settings['conikal_minimum_signature_field'] == '') ) {
            $conikal_general_settings['conikal_minimum_signature_field'] = 1;
        }
        if (!isset($conikal_general_settings['conikal_number_sign_change_field']) || ( isset($conikal_general_settings['conikal_number_sign_change_field']) && $conikal_general_settings['conikal_number_sign_change_field'] == '') ) {
            $conikal_general_settings['conikal_number_sign_change_field'] = 100;
        }
        if (!isset($conikal_general_settings['conikal_number_days_trending_field']) || ( isset($conikal_general_settings['conikal_number_days_trending_field']) && $conikal_general_settings['conikal_number_days_trending_field'] == '') ) {
            $conikal_general_settings['conikal_number_days_trending_field'] = 10;
        }
        if (!isset($conikal_general_settings['conikal_smooth_scroll_field']) || ( isset($conikal_general_settings['conikal_smooth_scroll_field']) && $conikal_general_settings['conikal_smooth_scroll_field'] == '') ) {
            $conikal_general_settings['conikal_smooth_scroll_field'] = 'disabled';
        }
        if (!isset($conikal_general_settings['conikal_ajax_pages_field']) || ( isset($conikal_general_settings['conikal_ajax_pages_field']) && $conikal_general_settings['conikal_ajax_pages_field'] == '') ) {
            $conikal_general_settings['conikal_ajax_pages_field'] = 'disabled';
        }
        if (!isset($conikal_general_settings['conikal_type_ajax_preloader_field']) || ( isset($conikal_general_settings['conikal_type_ajax_preloader_field']) && $conikal_general_settings['conikal_type_ajax_preloader_field'] == '') ) {
            $conikal_general_settings['conikal_type_ajax_preloader_field'] = 'none';
        }
        update_option('conikal_general_settings', $conikal_general_settings);


        // header settings default values
        $conikal_header_settings = get_option('conikal_header_settings');
        if (!isset($conikal_header_settings['conikal_user_menu_name_field']) || ( isset($conikal_header_settings['conikal_user_menu_name_field']) && $conikal_header_settings['conikal_user_menu_name_field'] == '') ) {
            $conikal_header_settings['conikal_user_menu_name_field'] = 'firstname';
        }
        if (!isset($conikal_header_settings['conikal_style_header_menu_field']) || ( isset($conikal_header_settings['conikal_style_header_menu_field']) && $conikal_header_settings['conikal_style_header_menu_field'] == '') ) {
            $conikal_header_settings['conikal_style_header_menu_field'] = 'boxed';
        }
        if (!isset($conikal_header_settings['conikal_type_header_menu_field']) || ( isset($conikal_header_settings['conikal_type_header_menu_field']) && $conikal_header_settings['conikal_type_header_menu_field'] == '') ) {
            $conikal_header_settings['conikal_type_header_menu_field'] = 'scroll';
        }
        if (!isset($conikal_header_settings['conikal_mobile_menu_animation_field']) || ( isset($conikal_header_settings['conikal_mobile_menu_animation_field']) && $conikal_header_settings['conikal_mobile_menu_animation_field'] == '') ) {
            $conikal_header_settings['conikal_mobile_menu_animation_field'] = 'overlay';
        }
        if (!isset($conikal_header_settings['conikal_page_header_opacity_field']) || ( isset($conikal_header_settings['conikal_page_header_opacity_field']) && $conikal_header_settings['conikal_page_header_opacity_field'] == '') ) {
            $conikal_header_settings['conikal_page_header_opacity_field'] = 80;
        }
        if (!isset($conikal_header_settings['conikal_post_header_opacity_field']) || ( isset($conikal_header_settings['conikal_post_header_opacity_field']) && $conikal_header_settings['conikal_post_header_opacity_field'] == '') ) {
            $conikal_header_settings['conikal_post_header_opacity_field'] = 80;
        }
        update_option('conikal_header_settings', $conikal_header_settings);


        // appearance settings default values
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        if (!isset($conikal_appearance_settings['conikal_sidebar_field']) || ( isset($conikal_appearance_settings['conikal_sidebar_field']) && $conikal_appearance_settings['conikal_sidebar_field'] == '') ) {
            $conikal_appearance_settings['conikal_sidebar_field'] = 'right';
        }

        if (!isset($conikal_appearance_settings['conikal_ajax_comment_field']) || ( isset($conikal_appearance_settings['conikal_ajax_comment_field']) && $conikal_appearance_settings['conikal_ajax_comment_field'] == '') ) {
            $conikal_appearance_settings['conikal_ajax_comment_field'] = 'enabled';
        }
        
        if (!isset($conikal_appearance_settings['conikal_petitions_per_page_field']) || ( isset($conikal_appearance_settings['conikal_petitions_per_page_field']) && $conikal_appearance_settings['conikal_petitions_per_page_field'] == '') ) {
            $conikal_appearance_settings['conikal_petitions_per_page_field'] = 10;
        }

        if (!isset($conikal_appearance_settings['conikal_updates_per_page_field']) || ( isset($conikal_appearance_settings['conikal_updates_per_page_field']) && $conikal_appearance_settings['conikal_updates_per_page_field'] == '') ) {
            $conikal_appearance_settings['conikal_updates_per_page_field'] = 5;
        }

        if (!isset($conikal_appearance_settings['conikal_comments_per_page_field']) || ( isset($conikal_appearance_settings['conikal_comments_per_page_field']) && $conikal_appearance_settings['conikal_comments_per_page_field'] == '') ) {
            $conikal_appearance_settings['conikal_comments_per_page_field'] = 10;
        }

        if (!isset($conikal_appearance_settings['conikal_reply_per_comment_field']) || ( isset($conikal_appearance_settings['conikal_reply_per_comment_field']) && $conikal_appearance_settings['conikal_reply_per_comment_field'] == '') ) {
            $conikal_appearance_settings['conikal_reply_per_comment_field'] = 2;
        }

        if (!isset($conikal_appearance_settings['conikal_copyright_field']) || ( isset($conikal_appearance_settings['conikal_copyright_field']) && $conikal_appearance_settings['conikal_copyright_field'] == '') ) {
            $conikal_appearance_settings['conikal_copyright_field'] = 'Copyright © 2017 Conikal.com';
        }
        update_option('conikal_appearance_settings', $conikal_appearance_settings);


        // homepage settings default values
        $conikal_home_settings = get_option('conikal_home_settings');
        if (!isset($conikal_home_settings['conikal_home_header_field']) || ( isset($conikal_home_settings['conikal_home_header_field']) && $conikal_home_settings['conikal_home_header_field'] == '') ) {
            $conikal_home_settings['conikal_home_header_field'] = 'none';
        }

        if (!isset($conikal_home_settings['conikal_shadow_opacity_field']) || ( isset($conikal_home_settings['conikal_shadow_opacity_field']) && $conikal_home_settings['conikal_shadow_opacity_field'] == '') ) {
            $conikal_home_settings['conikal_shadow_opacity_field'] = 70;
        }

        if (!isset($conikal_home_settings['conikal_hight_slideshow_field']) || ( isset($conikal_home_settings['conikal_hight_slideshow_field']) && $conikal_home_settings['conikal_hight_slideshow_field'] == '') ) {
            $conikal_home_settings['conikal_hight_slideshow_field'] = '675';
        }

        if (!isset($conikal_home_settings['conikal_home_caption_top_field']) || ( isset($conikal_home_settings['conikal_home_caption_top_field']) && $conikal_home_settings['conikal_home_caption_top_field'] == '') ) {
            $conikal_home_settings['conikal_home_caption_top_field'] = '225';
        }

        if (!isset($conikal_home_settings['conikal_home_caption_cta_size_field']) || ( isset($conikal_home_settings['conikal_home_caption_cta_size_field']) && $conikal_home_settings['conikal_home_caption_cta_size_field'] == '') ) {
            $conikal_home_settings['conikal_home_caption_cta_size_field'] = 'medium';
        }

        update_option('conikal_home_settings', $conikal_home_settings);


        // colors settings default values
        $conikal_colors_settings = get_option('conikal_colors_settings');
        $default_colors = array(
            'conikal_main_color_field' => '#11ce7c',
            'conikal_background_color_field' => '#f5f5f5',
            'conikal_body_text_color_field' => '#565656',
            'conikal_text_link_color_field' => '#565656',
            'conikal_home_caption_color_field' => '#ffffff',
            'conikal_preloader_progress_color_field' => '#11ce7c',
            'conikal_opacity_hero_page_color_field' => '#2C3E50',
            'conikal_header_menu_color_field' => '#ffffff',
            'conikal_header_menu_text_color_field' => '#565656',
            'conikal_victory_color_field' => '#2ecc71',
            'conikal_signup_button_color_field' => '#f39c12',
            'conikal_victory_label_color_field' => '#2ecc71',
            'conikal_sign_petition_button_color_field' => '#11ce7c',
            'conikal_mobile_menu_bg_color_field' => '#ffffff',
            'conikal_mobile_menu_text_link_color_field' => '#565656',
            'conikal_post_overlay_primary_color_field' => '#2C3E50',
            'conikal_post_overlay_secondary_color_field' => '#2C3E50',
            'conikal_footer_bg_color_field' => '#2C3E50',
            'conikal_footer_text_color_field' => '#fafafa'
        );
        if ($conikal_colors_settings['conikal_main_color_field'] == '' && 
            $conikal_colors_settings['conikal_background_color_field'] == '' && 
            $conikal_colors_settings['conikal_body_text_color_field'] == '' && 
            $conikal_colors_settings['conikal_text_link_color_field'] == '' && 
            $conikal_colors_settings['conikal_home_caption_color_field'] == '' && 
            $conikal_colors_settings['conikal_preloader_progress_color_field'] == '' && 
            $conikal_colors_settings['conikal_opacity_hero_page_color_field'] == '' && 
            $conikal_colors_settings['conikal_header_menu_color_field'] == '' && 
            $conikal_colors_settings['conikal_header_menu_text_color_field'] == '' && 
            $conikal_colors_settings['conikal_victory_color_field'] == '' && 
            $conikal_colors_settings['conikal_signup_button_color_field'] == '' && 
            $conikal_colors_settings['conikal_victory_label_color_field'] == '' && 
            $conikal_colors_settings['conikal_sign_petition_button_color_field'] == '' && 
            $conikal_colors_settings['conikal_mobile_menu_bg_color_field'] == '' && 
            $conikal_colors_settings['conikal_mobile_menu_text_link_color_field'] == '' && 
            $conikal_colors_settings['conikal_post_overlay_primary_color_field'] == '' && 
            $conikal_colors_settings['conikal_post_overlay_secondary_color_field'] == '' && 
            $conikal_colors_settings['conikal_footer_bg_color_field'] == '' && 
            $conikal_colors_settings['conikal_footer_text_color_field'] == '') {
            update_option('conikal_colors_settings', $default_colors);
        }

        // typography default value
        $conikal_typography_settings = get_option('conikal_typography_settings');
        $default_typography = array(
            'conikal_typography_body_font_field' => 'Roboto,sans-serif',
            'conikal_typography_body_weight_field' => '400',
            'conikal_typography_body_line_field' => '16',
            'conikal_typography_body_size_field' => '13',

            'conikal_typography_home_heading_font_field' => 'Comfortaa,display',
            'conikal_typography_home_heading_weight_field' => '700',
            'conikal_typography_home_heading_line_field' => '48',
            'conikal_typography_home_heading_size_field' => '46',

            'conikal_typography_home_subheading_font_field' => 'Comfortaa,display',
            'conikal_typography_home_subheading_weight_field' => '400',
            'conikal_typography_home_subheading_line_field' => '16',
            'conikal_typography_home_subheading_size_field' => '14',

            'conikal_typography_heading_font_field' => 'Roboto,sans-serif',
            'conikal_typography_heading_weight_field' => '700',
            'conikal_typography_heading_line_field' => '26',
            'conikal_typography_heading_size_field' => '20',

            'conikal_typography_page_heading_font_field' => 'Roboto,sans-serif',
            'conikal_typography_page_heading_weight_field' => '700',
            'conikal_typography_page_heading_line_field' => '40',
            'conikal_typography_page_heading_size_field' => '36',

            'conikal_typography_widget_title_font_field' => 'Roboto,sans-serif',
            'conikal_typography_widget_title_weight_field' => '700',
            'conikal_typography_widget_title_line_field' => '36',
            'conikal_typography_widget_title_size_field' => '20',

            'conikal_typography_title_font_field' => 'Roboto,sans-serif',
            'conikal_typography_title_weight_field' => '500',
            'conikal_typography_title_line_field' => '24',
            'conikal_typography_title_size_field' => '20',

            'conikal_typography_content_font_field' => 'Open Sans,sans-serif',
            'conikal_typography_content_weight_field' => '400',
            'conikal_typography_content_line_field' => '24',
            'conikal_typography_content_size_field' => '16',

            'conikal_typography_button_font_field' => 'Roboto,sans-serif',
            'conikal_typography_button_weight_field' => '700',
            'conikal_typography_button_line_field' => '16',
            'conikal_typography_button_size_field' => '13',
        );

        if ($conikal_typography_settings['conikal_typography_body_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_home_heading_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_home_subheading_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_heading_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_page_heading_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_widget_title_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_title_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_content_font_field'] == '' && 
            $conikal_typography_settings['conikal_typography_button_font_field'] == '') {
            update_option('conikal_typography_settings', $default_typography);
        }



        // search sugestion default values
        $conikal_search_settings = get_option('conikal_search_settings');
        if (!isset($conikal_search_settings['conikal_s_min_characters_field']) || ( isset($conikal_search_settings['conikal_s_min_characters_field']) && $conikal_search_settings['conikal_s_min_characters_field'] == '') ) {
            $conikal_search_settings['conikal_s_min_characters_field'] = 3;
        }

        if (!isset($conikal_search_settings['conikal_s_max_results_field']) || ( isset($conikal_search_settings['conikal_s_max_results_field']) && $conikal_search_settings['conikal_s_max_results_field'] == '') ) {
            $conikal_search_settings['conikal_s_max_results_field'] = 7;
        }

        if (!isset($conikal_search_settings['conikal_s_type_field']) || ( isset($conikal_search_settings['conikal_s_type_field']) && $conikal_search_settings['conikal_s_type_field'] == '') ) {
            $conikal_search_settings['conikal_s_type_field'] = 'category';
        }

        if (!isset($conikal_search_settings['conikal_s_link_field']) || ( isset($conikal_search_settings['conikal_s_link_field']) && $conikal_search_settings['conikal_s_link_field'] == '') ) {
            $conikal_search_settings['conikal_s_link_field'] = 'enabled';
        }

        if (!isset($conikal_search_settings['conikal_s_description_field']) || ( isset($conikal_search_settings['conikal_s_description_field']) && $conikal_search_settings['conikal_s_description_field'] == '') ) {
            $conikal_search_settings['conikal_s_description_field'] = 'enabled';
        }

        if (!isset($conikal_search_settings['conikal_s_image_field']) || ( isset($conikal_search_settings['conikal_s_image_field']) && $conikal_search_settings['conikal_s_image_field'] == '') ) {
            $conikal_search_settings['conikal_s_image_field'] = 'enabled';
        }

        if (!isset($conikal_search_settings['conikal_s_supporters_field']) || ( isset($conikal_search_settings['conikal_s_supporters_field']) && $conikal_search_settings['conikal_s_supporters_field'] == '') ) {
            $conikal_search_settings['conikal_s_supporters_field'] = 'enabled';
        }
        update_option('conikal_search_settings', $conikal_search_settings);


        // search filter default values
        $conikal_filter_settings = get_option('conikal_filter_settings');
        if (!isset($conikal_filter_settings['conikal_f_category_field']) || ( isset($conikal_filter_settings['conikal_f_category_field']) && $conikal_filter_settings['conikal_f_category_field'] == '') ) {
            $conikal_filter_settings['conikal_f_category_field'] = 'enabled';
        }

        if (!isset($conikal_filter_settings['conikal_f_topic_field']) || ( isset($conikal_filter_settings['conikal_f_topic_field']) && $conikal_filter_settings['conikal_f_topic_field'] == '') ) {
            $conikal_filter_settings['conikal_f_topic_field'] = 'enabled';
        }

        if (!isset($conikal_filter_settings['conikal_f_country_field']) || ( isset($conikal_filter_settings['conikal_f_country_field']) && $conikal_filter_settings['conikal_f_country_field'] == '') ) {
            $conikal_filter_settings['conikal_f_country_field'] = 'enabled';
        }

        if (!isset($conikal_filter_settings['conikal_f_state_field']) || ( isset($conikal_filter_settings['conikal_f_state_field']) && $conikal_filter_settings['conikal_f_state_field'] == '') ) {
            $conikal_filter_settings['conikal_f_state_field'] = 'enabled';
        }

        if (!isset($conikal_filter_settings['conikal_f_city_field']) || ( isset($conikal_filter_settings['conikal_f_city_field']) && $conikal_filter_settings['conikal_f_city_field'] == '') ) {
            $conikal_filter_settings['conikal_f_city_field'] = 'enabled';
        }

        if (!isset($conikal_filter_settings['conikal_f_neighborhood_field']) || ( isset($conikal_filter_settings['conikal_f_neighborhood_field']) && $conikal_filter_settings['conikal_f_neighborhood_field'] == '') ) {
            $conikal_filter_settings['conikal_f_neighborhood_field'] = 'enabled';
        }
        update_option('conikal_filter_settings', $conikal_filter_settings);


        // petition fields default values
        $conikal_petition_fields_settings = get_option('conikal_petition_fields_settings');
        if (!isset($conikal_petition_fields_settings['conikal_p_category_field']) || ( isset($conikal_petition_fields_settings['conikal_p_category_field']) && $conikal_petition_fields_settings['conikal_p_category_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_category_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_category_r_field']) || ( isset($conikal_petition_fields_settings['conikal_p_category_r_field']) && $conikal_petition_fields_settings['conikal_p_category_r_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_category_r_field'] = 'required';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_topics_field']) || ( isset($conikal_petition_fields_settings['conikal_p_topics_field']) && $conikal_petition_fields_settings['conikal_p_topics_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_topics_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_topics_r_field']) || ( isset($conikal_petition_fields_settings['conikal_p_topics_r_field']) && $conikal_petition_fields_settings['conikal_p_topics_r_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_topics_r_field'] = 'required';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_address_field']) || ( isset($conikal_petition_fields_settings['conikal_p_address_field']) && $conikal_petition_fields_settings['conikal_p_address_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_address_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_city_field']) || ( isset($conikal_petition_fields_settings['conikal_p_city_field']) && $conikal_petition_fields_settings['conikal_p_city_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_city_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_coordinates_field']) || ( isset($conikal_petition_fields_settings['conikal_p_coordinates_field']) && $conikal_petition_fields_settings['conikal_p_coordinates_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_coordinates_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_neighborhood_field']) || ( isset($conikal_petition_fields_settings['conikal_p_neighborhood_field']) && $conikal_petition_fields_settings['conikal_p_neighborhood_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_neighborhood_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_zip_field']) || ( isset($conikal_petition_fields_settings['conikal_p_zip_field']) && $conikal_petition_fields_settings['conikal_p_zip_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_zip_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_state_field']) || ( isset($conikal_petition_fields_settings['conikal_p_state_field']) && $conikal_petition_fields_settings['conikal_p_state_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_state_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_country_field']) || ( isset($conikal_petition_fields_settings['conikal_p_country_field']) && $conikal_petition_fields_settings['conikal_p_country_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_country_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_receiver_field']) || ( isset($conikal_petition_fields_settings['conikal_p_receiver_field']) && $conikal_petition_fields_settings['conikal_p_receiver_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_receiver_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_receiver_r_field']) || ( isset($conikal_petition_fields_settings['conikal_p_receiver_r_field']) && $conikal_petition_fields_settings['conikal_p_receiver_r_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_receiver_r_field'] = 'required';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_position_field']) || ( isset($conikal_petition_fields_settings['conikal_p_position_field']) && $conikal_petition_fields_settings['conikal_p_position_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_position_field'] = 'enabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_goal_field']) || ( isset($conikal_petition_fields_settings['conikal_p_goal_field']) && $conikal_petition_fields_settings['conikal_p_goal_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_goal_field'] = 'disabled';
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_goal_default_field']) || ( isset($conikal_petition_fields_settings['conikal_p_goal_default_field']) && $conikal_petition_fields_settings['conikal_p_goal_default_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_goal_default_field'] = 100;
        }

        if (!isset($conikal_petition_fields_settings['conikal_p_video_field']) || ( isset($conikal_petition_fields_settings['conikal_p_video_field']) && $conikal_petition_fields_settings['conikal_p_video_field'] == '') ) {
            $conikal_petition_fields_settings['conikal_p_video_field'] = 'enabled';
        }
        update_option('conikal_petition_fields_settings', $conikal_petition_fields_settings);
    }
endif;
add_action( 'after_setup_theme', 'conikal_setup' );

?>