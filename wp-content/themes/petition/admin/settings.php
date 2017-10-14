<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

add_action( 'admin_menu', 'conikal_add_admin_menu' );
add_action( 'admin_init', 'conikal_settings_init' );

if( !function_exists('conikal_add_admin_menu') ): 
    function conikal_add_admin_menu() { 
        add_theme_page('Theme Settings', 'Theme Settings', 'administrator', 'admin/settings.php', 'conikal_settings_page');
    }
endif;

if( !function_exists('conikal_settings_init') ): 
    function conikal_settings_init() {
        wp_enqueue_style('select2', get_template_directory_uri().'/admin/css/select2.min.css', false, '1.0', 'all');
        wp_enqueue_style('font_awesome', get_template_directory_uri().'/admin/css/font-awesome.css', false, '1.0', 'all');
        wp_enqueue_style('settings_style', get_template_directory_uri().'/admin/css/style.min.css', false, '1.0', 'all');
        wp_enqueue_style('icons_style', get_template_directory_uri().'/admin/css/icons.css', false, '1.0', 'all');
        wp_enqueue_script('media-upload');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('my-upload');
        wp_enqueue_script('select2', get_template_directory_uri().'/admin/js/select2.min.js', false, '1.0', true);
        wp_enqueue_script('settings', get_template_directory_uri().'/admin/js/admin.js', array('wp-color-picker'), '1.0', true);

        wp_localize_script('settings', 'settings_vars', 
            array(  
                'amenities_placeholder' => __('Add new', 'petition'),
                'admin_url' => get_admin_url(),
                'text' => __('Text', 'petition'),
                'numeric' => __('Numeric', 'petition'),
                'date' => __('Date', 'petition'),
                'no' => __('No', 'petition'),
                'yes' => __('Yes', 'petition'),
                'delete' => __('Delete', 'petition')
            )
        );

        register_setting( 'conikal_general_settings', 'conikal_general_settings' );
        register_setting( 'conikal_appearance_settings', 'conikal_appearance_settings' );
        register_setting( 'conikal_colors_settings', 'conikal_colors_settings' );
        register_setting( 'conikal_typography_settings', 'conikal_typography_settings' );
        register_setting( 'conikal_home_settings', 'conikal_home_settings' );
        register_setting( 'conikal_header_settings', 'conikal_header_settings' );
        register_setting( 'conikal_petition_fields_settings', 'conikal_petition_fields_settings' );
        register_setting( 'conikal_fields_settings', 'conikal_fields_settings' );
        register_setting( 'conikal_search_settings', 'conikal_search_settings' );
        register_setting( 'conikal_filter_settings', 'conikal_filter_settings' );
        register_setting( 'conikal_contact_settings', 'conikal_contact_settings' );
        register_setting( 'conikal_auth_settings', 'conikal_auth_settings' );
    }
endif;

if( !function_exists('conikal_admin_general_settings') ): 
    function conikal_admin_general_settings() {
        add_settings_section( 'conikal_generalSettings_section', __( 'General Settings', 'petition'), 'conikal_general_settings_section_callback', 'conikal_general_settings' );
        add_settings_field( 'conikal_logo_field', __( 'Logo', 'petition'), 'conikal_logo_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_inverted_logo_field', __( 'Logo inverse', 'petition'), 'conikal_inverted_logo_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_victory_icon_field', __( 'Victory icon (class name or URL)', 'petition'), 'conikal_victory_icon_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_victory_inverse_icon_field', __( 'Victory inverse icon (class name or URL)', 'petition'), 'conikal_victory_inverse_icon_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_sign_button_icon_field', __( 'Sign button icon (class name or URL)', 'petition'), 'conikal_sign_button_icon_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_supporter_icon_field', __( 'Supporter icon (class name or URL)', 'petition'), 'conikal_supporter_icon_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_country_field', __( 'Country', 'petition'), 'conikal_country_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_minimum_signature_field', __( 'Minimum of signature to display', 'petition'), 'conikal_minimum_signature_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_number_sign_change_field', __( 'Number signature to change goal', 'petition'), 'conikal_number_sign_change_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_number_days_trending_field', __( 'Days of Trending Petition', 'petition'), 'conikal_number_days_trending_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_smooth_scroll_field', __( 'Smooth scroll', 'petition'), 'conikal_smooth_scroll_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_ajax_pages_field', __( 'Ajax pages', 'petition'), 'conikal_ajax_pages_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_type_ajax_preloader_field', __( 'Type of ajax preloader', 'petition'), 'conikal_type_ajax_preloader_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_format_separate_fullname_field', __( 'Format separate fullname', 'petition'), 'conikal_format_separate_fullname_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_admin_submit_petition_only_field', __( 'Admin submit petition only', 'petition'), 'conikal_admin_submit_petition_only_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_review_field', __( 'Front-end petition publish without admin approval', 'petition'), 'conikal_review_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_review_decision_field', __( 'Decision Maker publish without admin approval', 'petition'), 'conikal_review_decision_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_review_contribute_field', __( 'Contribute & donation publish without admin approval', 'petition'), 'conikal_review_contribute_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
        add_settings_field( 'conikal_google_analytics_field', __( 'Google Analytics Code', 'petition'), 'conikal_google_analytics_field_render', 'conikal_general_settings', 'conikal_generalSettings_section' );
    }
endif;

if( !function_exists('conikal_admin_home') ): 
    function conikal_admin_home() {
        add_settings_section( 'conikal_home_section', __( 'Homepage', 'petition'), 'conikal_appearance_section_callback', 'conikal_home_settings' );
        add_settings_field( 'conikal_home_header_field', __( 'Homepage header type', 'petition'), 'conikal_home_header_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_header_video_field', __( 'Homepage header video', 'petition'), 'conikal_home_header_video_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_header_video_sound_field', __( 'Enable video sound', 'petition'), 'conikal_home_header_video_sound_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_header_hide_logined_field', __( 'Hidden slideshow after login', 'petition'), 'conikal_home_header_hide_logined_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_shadow_opacity_field', __( 'Header image shadow opacity', 'petition'), 'conikal_shadow_opacity_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_hight_slideshow_field', __( 'Hight of Slideshow (px)', 'petition'), 'conikal_hight_slideshow_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_top_field', __( 'Home Caption Top (px)', 'petition'), 'conikal_home_caption_top_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_field', __( 'Show homepage caption', 'petition'), 'conikal_home_caption_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_alignment_field', __( 'Homepage caption alignment', 'petition'), 'conikal_home_caption_alignment_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_title_field', __( 'Homepage caption title', 'petition'), 'conikal_home_caption_title_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_subtitle_field', __( 'Homepage caption subtitle', 'petition'), 'conikal_home_caption_subtitle_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_field', __( 'Show homepage cta button', 'petition'), 'conikal_home_caption_cta_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_text_field', __( 'Homepage cta button text 1', 'petition'), 'conikal_home_caption_cta_text_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_link_field', __( 'Homepage cta button link 1', 'petition'), 'conikal_home_caption_cta_link_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_text_2_field', __( 'Homepage cta button text 2', 'petition'), 'conikal_home_caption_cta_text_2_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_link_2_field', __( 'Homepage cta button link 2', 'petition'), 'conikal_home_caption_cta_link_2_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_caption_cta_size_field', __( 'Homepage cta button size', 'petition'), 'conikal_home_caption_cta_size_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_spotlight_field', __( 'Show homepage spotlight section', 'petition'), 'conikal_home_spotlight_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_spotlight_hide_logined_field', __( 'Hidden spotlight after login', 'petition'), 'conikal_home_spotlight_hide_logined_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_spotlight_title_field', __( 'Homepage spotlight section title', 'petition'), 'conikal_home_spotlight_title_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_spotlight_text_field', __( 'Homepage spotlight section text', 'petition'), 'conikal_home_spotlight_text_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_victory_field', __( 'Show homepage victory section', 'petition'), 'conikal_home_victory_field_render', 'conikal_home_settings', 'conikal_home_section' );
        add_settings_field( 'conikal_home_victory_hide_logined_field', __( 'Hidden victory section after login', 'petition'), 'conikal_home_victory_hide_logined_field_render', 'conikal_home_settings', 'conikal_home_section' );
    }
endif;

if( !function_exists('conikal_admin_header') ): 
    function conikal_admin_header() {
        add_settings_section( 'conikal_header_section', __( 'Header', 'petition'), 'conikal_header_section_callback', 'conikal_header_settings' );
        add_settings_field( 'conikal_user_menu_field', __( 'Show user menu in header', 'petition'), 'conikal_user_menu_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_submit_button_field', __( 'Show submit button', 'petition'), 'conikal_submit_button_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_user_menu_name_field', __( 'Display name on user menu', 'petition'), 'conikal_user_menu_name_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_style_header_menu_field', __( 'Style of header menu', 'petition'), 'conikal_style_header_menu_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_type_header_menu_field', __( 'Type of header menu', 'petition'), 'conikal_type_header_menu_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_mobile_menu_animation_field', __( 'Mobile menu animation', 'petition'), 'conikal_mobile_menu_animation_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_page_header_opacity_field', __( 'Page header opacity', 'petition'), 'conikal_page_header_opacity_field_render', 'conikal_header_settings', 'conikal_header_section' );
        add_settings_field( 'conikal_post_header_opacity_field', __( 'Post header opacity', 'petition'), 'conikal_post_header_opacity_field_render', 'conikal_header_settings', 'conikal_header_section' );
    }
endif;

if( !function_exists('conikal_admin_appearance') ): 
    function conikal_admin_appearance() {
        add_settings_section( 'conikal_appearance_section', __( 'Appearance', 'petition'), 'conikal_appearance_section_callback', 'conikal_appearance_settings' );
        add_settings_field( 'conikal_container_width_field', __( 'Container width', 'petition'), 'conikal_container_width_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_sidebar_field', __( 'Sidebar position', 'petition'), 'conikal_sidebar_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_ajax_comment_field', __( 'Use ajax comments', 'petition'), 'conikal_ajax_comment_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_action_after_sign_field', __( 'Action after sign petition', 'petition'), 'conikal_action_after_sign_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_default_accordion_sign_field', __( 'Default accourdion after sign', 'petition'), 'conikal_default_accordion_sign_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_disable_unsign_field', __( 'Disable unsign', 'petition'), 'conikal_disable_unsign_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_view_counter_field', __( 'Show view counter', 'petition'), 'conikal_view_counter_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_related_field', __( 'Show related articles on blog post', 'petition'), 'conikal_related_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_similar_field', __( 'Show similar petitions on petition page', 'petition'), 'conikal_similar_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_similar_base_field', __( 'Show similar petitions base on', 'petition'), 'conikal_similar_base_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_similar_related_per_page_field', __( 'Similar petitions & related posts per page', 'petition'), 'conikal_similar_related_per_page_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_petitions_per_page_field', __( 'Number of petitions per page', 'petition'), 'conikal_petitions_per_page_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_updates_per_page_field', __( 'Number of updates per page', 'petition'), 'conikal_updates_per_page_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_comments_per_page_field', __( 'Number of comments per page', 'petition'), 'conikal_comments_per_page_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_reply_per_comment_field', __( 'Number of reply per comment', 'petition'), 'conikal_reply_per_comment_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_suppporter_per_page_field', __( 'Number of supporter per page', 'petition'), 'conikal_supporter_per_page_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_breadcrumbs_field', __( 'Show breadcrumbs on pages', 'petition'), 'conikal_breadcrumbs_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_show_supporters_section_field', __( 'Show Supporters section', 'petition'), 'conikal_show_supporters_section_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_show_donors_section_field', __( 'Show Donors section', 'petition'), 'conikal_show_donors_section_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
        add_settings_field( 'conikal_copyright_field', __( 'Copyright text', 'petition'), 'conikal_copyright_field_render', 'conikal_appearance_settings', 'conikal_appearance_section' );
    }
endif;

if( !function_exists('conikal_admin_colors') ): 
    function conikal_admin_colors() {
        add_settings_section( 'conikal_colors_section', __( 'Colors', 'petition'), 'conikal_colors_section_callback', 'conikal_colors_settings' );
        add_settings_field( 'conikal_main_color_field', __( 'Main color', 'petition'), 'conikal_main_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_background_color_field', __( 'Background color', 'petition'), 'conikal_background_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_body_text_color_field', __( 'Body text color', 'petition'), 'conikal_body_text_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_text_link_color_field', __( 'Text link color', 'petition'), 'conikal_text_link_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_home_caption_color_field', __( 'Home caption color', 'petition'), 'conikal_home_caption_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_preloader_progress_color_field', __( 'Preloader progress color', 'petition'), 'conikal_preloader_progress_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_opacity_hero_page_color_field', __( 'Opacity hero page color', 'petition'), 'conikal_opacity_hero_page_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_header_menu_color_field', __( 'Header menu', 'petition'), 'conikal_header_menu_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_header_menu_text_color_field', __( 'Header menu text color', 'petition'), 'conikal_header_menu_text_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_home_menu_text_color_field', __( 'Home menu text color', 'petition'), 'conikal_home_menu_text_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_victory_color_field', __( 'Text and Progress Victory color', 'petition'), 'conikal_victory_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_signup_button_color_field', __( 'Sign up button color', 'petition'), 'conikal_signup_button_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_victory_label_color_field', __( 'Victory label color', 'petition'), 'conikal_victory_label_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_sign_petition_button_color_field', __( 'Sign petition button color', 'petition'), 'conikal_sign_petition_button_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_submit_petition_button_color_field', __( 'Submit petition button color', 'petition'), 'conikal_submit_petition_button_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_mobile_menu_bg_color_field', __( 'Mobile menu background color', 'petition'), 'conikal_mobile_menu_bg_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_mobile_menu_text_link_color_field', __( 'Mobile menu text link color', 'petition'), 'conikal_mobile_menu_text_link_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_post_overlay_primary_color_field', __( 'Posts overlay primary color', 'petition'), 'conikal_post_overlay_primary_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_post_overlay_secondary_color_field', __( 'Posts overlay secondary color', 'petition'), 'conikal_post_overlay_secondary_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_footer_bg_color_field', __( 'Footer background color', 'petition'), 'conikal_footer_bg_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
        add_settings_field( 'conikal_footer_text_color_field', __( 'Footer text color', 'petition'), 'conikal_footer_text_color_field_render', 'conikal_colors_settings', 'conikal_colors_section' );
    }
endif;

if( !function_exists('conikal_admin_typography') ): 
    function conikal_admin_typography() {
        add_settings_section( 'conikal_typography_section', __( 'Typography', 'petition'), 'conikal_typography_section_callback', 'conikal_typography_settings' );
        add_settings_field( 'conikal_body_font_field', __( 'Body Font', 'petition'), 'conikal_body_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_home_heading_font_field', __( 'Home Heading Font', 'petition'), 'conikal_home_heading_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_home_subheading_font_field', __( 'Home Sub-Heading Font', 'petition'), 'conikal_home_subheading_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_heading_font_field', __( 'Heading Font', 'petition'), 'conikal_heading_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_page_heading_font_field', __( 'Page Heading Font', 'petition'), 'conikal_page_heading_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_widget_title_font_field', __( 'Widget Title Font', 'petition'), 'conikal_widget_title_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_title_font_field', __( 'Posts Title Font', 'petition'), 'conikal_title_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_content_font_field', __( 'Posts Content Font', 'petition'), 'conikal_content_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
        add_settings_field( 'conikal_button_font_field', __( 'Button Font', 'petition'), 'conikal_button_font_field_render', 'conikal_typography_settings', 'conikal_typography_section' );
    }
endif;

if( !function_exists('conikal_admin_petition_fields') ): 
    function conikal_admin_petition_fields() {
        add_settings_section( 'conikal_prop_fields_section', __( 'Petition Fiels', 'petition'), 'conikal_petition_fields_section_callback', 'conikal_petition_fields_settings' );
        add_settings_field( 'conikal_p_category_field', __( 'Category', 'petition'), 'conikal_p_category_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_topics_field', __( 'Topics', 'petition'), 'conikal_p_topics_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_address_field', __( 'Address', 'petition'), 'conikal_p_address_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_city_field', __( 'City', 'petition'), 'conikal_p_city_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_coordinates_field', __( 'Coordinates', 'petition'), 'conikal_p_coordinates_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_neighborhood_field', __( 'Neighborhood', 'petition'), 'conikal_p_neighborhood_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_zip_field', __( 'Zip Code', 'petition'), 'conikal_p_zip_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_state_field', __( 'County/State', 'petition'), 'conikal_p_state_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_country_field', __( 'Country', 'petition'), 'conikal_p_country_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_receiver_field', __( 'Receiver name', 'petition'), 'conikal_p_receiver_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_position_field', __( 'Position', 'petition'), 'conikal_p_position_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_goal_field', __( 'Goal sign', 'petition'), 'conikal_p_goal_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_goal_default_field', __( 'Goal default', 'petition'), 'conikal_p_goal_default_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_video_field', __( 'Video', 'petition'), 'conikal_p_video_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
        add_settings_field( 'conikal_p_media_upload_field', __( 'Media Upload', 'petition'), 'conikal_p_media_upload_field_render', 'conikal_petition_fields_settings', 'conikal_prop_fields_section' );
    }
endif;

if( !function_exists('conikal_admin_search') ): 
    function conikal_admin_search() {
        add_settings_section( 'conikal_search_section', __( 'Search Suggestion', 'petition'), 'conikal_search_section_callback', 'conikal_search_settings' );
        add_settings_field( 'conikal_s_min_characters_field', __( 'Minimun Characters', 'petition'), 'conikal_s_min_characters_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_max_results_field', __( 'Maxinum Results', 'petition'), 'conikal_s_max_results_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_type_field', __( 'Type', 'petition'), 'conikal_s_type_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_link_field', __( 'Link', 'petition'), 'conikal_s_link_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_description_field', __( 'Description', 'petition'), 'conikal_s_description_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_image_field', __( 'Image', 'petition'), 'conikal_s_image_field_render', 'conikal_search_settings', 'conikal_search_section' );
        add_settings_field( 'conikal_s_supporters_field', __( 'Supporters', 'petition'), 'conikal_s_supporters_field_render', 'conikal_search_settings', 'conikal_search_section' );
    }
endif;

if( !function_exists('conikal_admin_filter') ): 
    function conikal_admin_filter() {
        add_settings_section( 'conikal_filter_section', __( 'Search Filter Fields', 'petition'), 'conikal_filter_section_callback', 'conikal_filter_settings' );
        add_settings_field( 'conikal_f_category_field', __( 'Category', 'petition'), 'conikal_f_category_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
        add_settings_field( 'conikal_f_topic_field', __( 'Topic', 'petition'), 'conikal_f_topic_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
        add_settings_field( 'conikal_f_country_field', __( 'Country', 'petition'), 'conikal_f_country_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
        add_settings_field( 'conikal_f_state_field', __( 'County/State', 'petition'), 'conikal_f_state_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
        add_settings_field( 'conikal_f_city_field', __( 'City', 'petition'), 'conikal_f_city_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
        add_settings_field( 'conikal_f_neighborhood_field', __( 'Neighborhood', 'petition'), 'conikal_f_neighborhood_field_render', 'conikal_filter_settings', 'conikal_filter_section' );
    }
endif;

if( !function_exists('conikal_admin_contact') ): 
    function conikal_admin_contact() {
        add_settings_section( 'conikal_contact_section', __( 'Contact', 'petition'), 'conikal_contact_section_callback', 'conikal_contact_settings' );
        add_settings_field( 'conikal_company_name_field',  __( 'Company Name', 'petition'), 'conikal_company_name_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_email_field',  __( 'E-mail', 'petition'), 'conikal_company_email_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_phone_field',  __( 'Phone', 'petition'), 'conikal_company_phone_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_mobile_field',  __( 'Mobile', 'petition'), 'conikal_company_mobile_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_skype_field',  __( 'Skype', 'petition'), 'conikal_company_skype_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_address_field',  __( 'Address', 'petition'), 'conikal_company_address_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_facebook_field',  __( 'Facebook Link', 'petition'), 'conikal_company_facebook_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_twitter_field',  __( 'Twitter Link', 'petition'), 'conikal_company_twitter_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_google_field',  __( 'Google+ Link', 'petition'), 'conikal_company_google_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
        add_settings_field( 'conikal_company_linkedin_field',  __( 'LinkedIn Link', 'petition'), 'conikal_company_linkedin_field_render', 'conikal_contact_settings', 'conikal_contact_section' );
    }
endif;

if( !function_exists('conikal_admin_auth') ): 
    function conikal_admin_auth() {
        add_settings_section( 'conikal_auth_section', __( 'Authentication', 'petition'), 'conikal_auth_section_callback', 'conikal_auth_settings' );
        add_settings_field( 'conikal_fb_login_field', __( 'Allow Facebook Login', 'petition'), 'conikal_fb_login_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_fb_id_field', __( 'Facebook App ID', 'petition'), 'conikal_fb_id_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_fb_secret_field', __( 'Facebook App Secret', 'petition'), 'conikal_fb_secret_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_google_login_field', __( 'Allow Google Signin', 'petition'), 'conikal_google_login_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_google_id_field', __( 'Google Client ID', 'petition'), 'conikal_google_id_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_google_secret_field', __( 'Google Client Secret', 'petition'), 'conikal_google_secret_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_gmaps_key_field', __( 'Google Map API key', 'petition'), 'conikal_gmaps_key_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_sendinblue_list_field', __( 'SendinBlue Save List', 'petition'), 'conikal_sendinblue_list_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_sendinblue_key_field', __( 'SendinBlue API key v2', 'petition'), 'conikal_sendinblue_key_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_sendinblue_folder_id_field', __( 'SendinBlue List Folder ID', 'petition'), 'conikal_sendinblue_folder_id_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
        add_settings_field( 'conikal_sendinblue_name_field', __( 'SendinBlue name fields', 'petition'), 'conikal_sendinblue_name_field_render', 'conikal_auth_settings', 'conikal_auth_section' );
    }
endif;


/***********************************
* GENERAL SECTION RENDER
************************************/

if( !function_exists('conikal_logo_field_render') ): 
    function conikal_logo_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="logoImage" type="text" size="40" name="conikal_general_settings[conikal_logo_field]" value="<?php if(isset($options['conikal_logo_field'])) { echo esc_attr($options['conikal_logo_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="logoImageBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_inverted_logo_field_render') ): 
    function conikal_inverted_logo_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="invertedLogoImage" type="text" size="40" name="conikal_general_settings[conikal_inverted_logo_field]" value="<?php if(isset($options['conikal_inverted_logo_field'])) { echo esc_attr($options['conikal_inverted_logo_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="invertedLogoImageBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_victory_icon_field_render') ): 
    function conikal_victory_icon_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="victoryIconImage" type="text" size="40" name="conikal_general_settings[conikal_victory_icon_field]" value="<?php if(isset($options['conikal_victory_icon_field'])) { echo esc_attr($options['conikal_victory_icon_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="victoryIconBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_victory_inverse_icon_field_render') ): 
    function conikal_victory_inverse_icon_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="victoryInverseIconImage" type="text" size="40" name="conikal_general_settings[conikal_victory_inverse_icon_field]" value="<?php if(isset($options['conikal_victory_inverse_icon_field'])) { echo esc_attr($options['conikal_victory_inverse_icon_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="victoryInverseIconBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;


if( !function_exists('conikal_sign_button_icon_field_render') ): 
    function conikal_sign_button_icon_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="signIconImage" type="text" size="40" name="conikal_general_settings[conikal_sign_button_icon_field]" value="<?php if(isset($options['conikal_sign_button_icon_field'])) { echo esc_attr($options['conikal_sign_button_icon_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="signIconBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_supporter_icon_field_render') ): 
    function conikal_supporter_icon_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="supporterIconImage" type="text" size="40" name="conikal_general_settings[conikal_supporter_icon_field]" value="<?php if(isset($options['conikal_supporter_icon_field'])) { echo esc_attr($options['conikal_supporter_icon_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button id="supporterIconBtn" class="btn btn-primary" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_country_field_render') ): 
    function conikal_country_field_render() { 
        $options = get_option( 'conikal_general_settings' );

        $countries=array("AF"=>"Afghanistan","AL"=>"Albania","DZ"=>"Algeria","AS"=>"American Samoa","AD"=>"Andorra","AO"=>"Angola","AI"=>"Anguilla","AQ"=>"Antarctica","AG"=>"Antigua and Barbuda","AR"=>"Argentina","AM"=>"Armenia","AW"=>"Aruba","AU"=>"Australia","AT"=>"Austria","AZ"=>"Azerbaijan","BS"=>"Bahamas","BH"=>"Bahrain","BD"=>"Bangladesh","BB"=>"Barbados","BY"=>"Belarus","BE"=>"Belgium","BZ"=>"Belize","BJ"=>"Benin","BM"=>"Bermuda","BT"=>"Bhutan","BO"=>"Bolivia","BA"=>"Bosnia and Herzegovina","BW"=>"Botswana","BV"=>"Bouvet Island","BR"=>"Brazil","BQ"=>"British Antarctic Territory","IO"=>"British Indian Ocean Territory","VG"=>"British Virgin Islands","BN"=>"Brunei","BG"=>"Bulgaria","BF"=>"Burkina Faso","BI"=>"Burundi","KH"=>"Cambodia","CM"=>"Cameroon","CA"=>"Canada","CT"=>"Canton and Enderbury Islands","CV"=>"Cape Verde","KY"=>"Cayman Islands","CF"=>"Central African Republic","TD"=>"Chad","CL"=>"Chile","CN"=>"China","CX"=>"Christmas Island","CC"=>"Cocos [Keeling] Islands","CO"=>"Colombia","KM"=>"Comoros","CG"=>"Congo - Brazzaville","CD"=>"Congo - Kinshasa","CK"=>"Cook Islands","CR"=>"Costa Rica","HR"=>"Croatia","CU"=>"Cuba","CY"=>"Cyprus","CZ"=>"Czech Republic","CI"=>"Côte d’Ivoire","DK"=>"Denmark","DJ"=>"Djibouti","DM"=>"Dominica","DO"=>"Dominican Republic","NQ"=>"Dronning Maud Land","DD"=>"East Germany","EC"=>"Ecuador","EG"=>"Egypt","SV"=>"El Salvador","GQ"=>"Equatorial Guinea","ER"=>"Eritrea","EE"=>"Estonia","ET"=>"Ethiopia","FK"=>"Falkland Islands","FO"=>"Faroe Islands","FJ"=>"Fiji","FI"=>"Finland","FR"=>"France","GF"=>"French Guiana","PF"=>"French Polynesia","TF"=>"French Southern Territories","FQ"=>"French Southern and Antarctic Territories","GA"=>"Gabon","GM"=>"Gambia","GE"=>"Georgia","DE"=>"Germany","GH"=>"Ghana","GI"=>"Gibraltar","GR"=>"Greece","GL"=>"Greenland","GD"=>"Grenada","GP"=>"Guadeloupe","GU"=>"Guam","GT"=>"Guatemala","GG"=>"Guernsey","GN"=>"Guinea","GW"=>"Guinea-Bissau","GY"=>"Guyana","HT"=>"Haiti","HM"=>"Heard Island and McDonald Islands","HN"=>"Honduras","HK"=>"Hong Kong SAR China","HU"=>"Hungary","IS"=>"Iceland","IN"=>"India","ID"=>"Indonesia","IR"=>"Iran","IQ"=>"Iraq","IE"=>"Ireland","IM"=>"Isle of Man","IL"=>"Israel","IT"=>"Italy","JM"=>"Jamaica","JP"=>"Japan","JE"=>"Jersey","JT"=>"Johnston Island","JO"=>"Jordan","KZ"=>"Kazakhstan","KE"=>"Kenya","KI"=>"Kiribati","KW"=>"Kuwait","KG"=>"Kyrgyzstan","LA"=>"Laos","LV"=>"Latvia","LB"=>"Lebanon","LS"=>"Lesotho","LR"=>"Liberia","LY"=>"Libya","LI"=>"Liechtenstein","LT"=>"Lithuania","LU"=>"Luxembourg","MO"=>"Macau SAR China","MK"=>"Macedonia","MG"=>"Madagascar","MW"=>"Malawi","MY"=>"Malaysia","MV"=>"Maldives","ML"=>"Mali","MT"=>"Malta","MH"=>"Marshall Islands","MQ"=>"Martinique","MR"=>"Mauritania","MU"=>"Mauritius","YT"=>"Mayotte","FX"=>"Metropolitan France","MX"=>"Mexico","FM"=>"Micronesia","MI"=>"Midway Islands","MD"=>"Moldova","MC"=>"Monaco","MN"=>"Mongolia","ME"=>"Montenegro","MS"=>"Montserrat","MA"=>"Morocco","MZ"=>"Mozambique","MM"=>"Myanmar [Burma]","NA"=>"Namibia","NR"=>"Nauru","NP"=>"Nepal","NL"=>"Netherlands","AN"=>"Netherlands Antilles","NT"=>"Neutral Zone","NC"=>"New Caledonia","NZ"=>"New Zealand","NI"=>"Nicaragua","NE"=>"Niger","NG"=>"Nigeria","NU"=>"Niue","NF"=>"Norfolk Island","KP"=>"North Korea","VD"=>"North Vietnam","MP"=>"Northern Mariana Islands","NO"=>"Norway","OM"=>"Oman","PC"=>"Pacific Islands Trust Territory","PK"=>"Pakistan","PW"=>"Palau","PS"=>"Palestinian Territories","PA"=>"Panama","PZ"=>"Panama Canal Zone","PG"=>"Papua New Guinea","PY"=>"Paraguay","YD"=>"People's Democratic Republic of Yemen","PE"=>"Peru","PH"=>"Philippines","PN"=>"Pitcairn Islands","PL"=>"Poland","PT"=>"Portugal","PR"=>"Puerto Rico","QA"=>"Qatar","RO"=>"Romania","RU"=>"Russia","RW"=>"Rwanda","RE"=>"Réunion","BL"=>"Saint Barthélemy","SH"=>"Saint Helena","KN"=>"Saint Kitts and Nevis","LC"=>"Saint Lucia","MF"=>"Saint Martin","PM"=>"Saint Pierre and Miquelon","VC"=>"Saint Vincent and the Grenadines","WS"=>"Samoa","SM"=>"San Marino","SA"=>"Saudi Arabia","SN"=>"Senegal","RS"=>"Serbia","CS"=>"Serbia and Montenegro","SC"=>"Seychelles","SL"=>"Sierra Leone","SG"=>"Singapore","SK"=>"Slovakia","SI"=>"Slovenia","SB"=>"Solomon Islands","SO"=>"Somalia","ZA"=>"South Africa","GS"=>"South Georgia and the South Sandwich Islands","KR"=>"South Korea","ES"=>"Spain","LK"=>"Sri Lanka","SD"=>"Sudan","SR"=>"Suriname","SJ"=>"Svalbard and Jan Mayen","SZ"=>"Swaziland","SE"=>"Sweden","CH"=>"Switzerland","SY"=>"Syria","ST"=>"São Tomé and Príncipe","TW"=>"Taiwan","TJ"=>"Tajikistan","TZ"=>"Tanzania","TH"=>"Thailand","TL"=>"Timor-Leste","TG"=>"Togo","TK"=>"Tokelau","TO"=>"Tonga","TT"=>"Trinidad and Tobago","TN"=>"Tunisia","TR"=>"Turkey","TM"=>"Turkmenistan","TC"=>"Turks and Caicos Islands","TV"=>"Tuvalu","UM"=>"U.S. Minor Outlying Islands","PU"=>"U.S. Miscellaneous Pacific Islands","VI"=>"U.S. Virgin Islands","UG"=>"Uganda","UA"=>"Ukraine","SU"=>"Union of Soviet Socialist Republics","AE"=>"United Arab Emirates","GB"=>"United Kingdom","US"=>"United States","ZZ"=>"Unknown or Invalid Region","UY"=>"Uruguay","UZ"=>"Uzbekistan","VU"=>"Vanuatu","VA"=>"Vatican City","VE"=>"Venezuela","VN"=>"Vietnam","WK"=>"Wake Island","WF"=>"Wallis and Futuna","EH"=>"Western Sahara","YE"=>"Yemen","ZM"=>"Zambia","ZW"=>"Zimbabwe","AX"=>"Åland Islands",);

        $country_select = '<select class="form-control" id="conikal_general_settings[conikal_country_field]" name="conikal_general_settings[conikal_country_field]">';

        foreach($countries as $code => $country) {
            $country_select .= '<option value="' . esc_attr($code) . '"';
            if(isset($options['conikal_country_field']) && $options['conikal_country_field'] == $code) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }

        $country_select .= '</select>';

        print $country_select;
    }
endif;

if( !function_exists('conikal_minimum_signature_field_render') ): 
    function conikal_minimum_signature_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input class="form-control" id="conikal_general_settings[conikal_minimum_signature_field]" type="number" size="10" name="conikal_general_settings[conikal_minimum_signature_field]" value="<?php if(isset($options['conikal_minimum_signature_field'])) { echo esc_attr($options['conikal_minimum_signature_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_number_sign_change_field_render') ): 
    function conikal_number_sign_change_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input class="form-control" id="conikal_general_settings[conikal_number_sign_change_field]" type="number" size="10" name="conikal_general_settings[conikal_number_sign_change_field]" value="<?php if(isset($options['conikal_number_sign_change_field'])) { echo esc_attr($options['conikal_number_sign_change_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_number_days_trending_field_render') ): 
    function conikal_number_days_trending_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input class="form-control" id="conikal_general_settings[conikal_number_days_trending_field]" type="number" size="10" name="conikal_general_settings[conikal_number_days_trending_field]" value="<?php if(isset($options['conikal_number_days_trending_field'])) { echo esc_attr($options['conikal_number_days_trending_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_smooth_scroll_field_render') ): 
    function conikal_smooth_scroll_field_render() {
        $options = get_option( 'conikal_general_settings' );

        $sroll_status = array("activated", "disabled");
        $scroll_select = '<select class="form-control" id="conikal_general_settings[conikal_smooth_scroll_field]" name="conikal_general_settings[conikal_smooth_scroll_field]">';

        foreach($sroll_status as $status) {
            $scroll_select .= '<option value="' . esc_attr($status) . '"';
            if(isset($options['conikal_smooth_scroll_field']) && $options['conikal_smooth_scroll_field'] == $status) {
                $scroll_select .= 'selected="selected"';
            }
            $scroll_select .= '>' . esc_html($status) . '</option>';
        }

        $scroll_select .= '</select>';

        print $scroll_select;
    }
endif;

if( !function_exists('conikal_ajax_pages_field_render') ): 
    function conikal_ajax_pages_field_render() {
        $options = get_option( 'conikal_general_settings' );

        $ajax_pages_status = array("activated", "disabled");
        $ajax_pages_select = '<select class="form-control" id="conikal_general_settings[conikal_ajax_pages_field]" name="conikal_general_settings[conikal_ajax_pages_field]">';

        foreach($ajax_pages_status as $status) {
            $ajax_pages_select .= '<option value="' . esc_attr($status) . '"';
            if(isset($options['conikal_ajax_pages_field']) && $options['conikal_ajax_pages_field'] == $status) {
                $ajax_pages_select .= 'selected="selected"';
            }
            $ajax_pages_select .= '>' . esc_html($status) . '</option>';
        }

        $ajax_pages_select .= '</select>';

        print $ajax_pages_select;
    }
endif;

if( !function_exists('conikal_type_ajax_preloader_field_render') ): 
    function conikal_type_ajax_preloader_field_render() {
        $options = get_option( 'conikal_general_settings' );

        $type_preloeaders = array('none' => 'None', 'chasing-dots' => 'Chasing Dots', 'cube-grid' => 'Cube Grid', 'double-bounce' => 'Double Bounce', 'fading-circle' => 'Fading Circle', 'folding-cube' => 'Folding Cube', 'pulse' => 'Pulse', 'rotating-plane' => 'Rotating Plance', 'three-bounce' => 'Three Bounce', 'wandering-cubes' => 'Wandering Cubes', 'wave' => 'Wave');
        $type_preloeaders_select = '<select class="form-control" id="conikal_general_settings[conikal_type_ajax_preloader_field]" name="conikal_general_settings[conikal_type_ajax_preloader_field]">';

        foreach($type_preloeaders as $type => $name) {
            $type_preloeaders_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_type_ajax_preloader_field']) && $options['conikal_type_ajax_preloader_field'] == $type) {
                $type_preloeaders_select .= 'selected="selected"';
            }
            $type_preloeaders_select .= '>' . esc_html($name) . '</option>';
        }

        $type_preloeaders_select .= '</select>';

        print $type_preloeaders_select;
    }
endif;

if( !function_exists('conikal_format_separate_fullname_field_render') ): 
    function conikal_format_separate_fullname_field_render() {
        $options = get_option( 'conikal_general_settings' );
        $formats = array(
            'first_s_middle_last' => __('Fistname | Middle Lastname', 'petition'),
            'first_middle_s_last' => __('Fistname Middle | Lastname', 'petition'),
            'last_s_middle_first' => __('Lastname | Middle Fistname', 'petition'),
            'last_middle_s_first' => __('Lastname Middle | Fistname', 'petition') );

        $format_fullname_select = '<select class="form-control" id="conikal_general_settings[conikal_format_separate_fullname_field]" name="conikal_general_settings[conikal_format_separate_fullname_field]">';
        foreach($formats as $type => $format) {
            $format_fullname_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_format_separate_fullname_field']) && $options['conikal_format_separate_fullname_field'] == $type) {
                $format_fullname_select .= 'selected="selected"';
            }
            $format_fullname_select .= '>' . esc_html($format) . '</option>';
        }

        $format_fullname_select .= '</select>';

        print $format_fullname_select;
    }
endif;

if( !function_exists('conikal_admin_submit_petition_only_field_render') ): 
    function conikal_admin_submit_petition_only_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input type="checkbox" name="conikal_general_settings[conikal_admin_submit_petition_only_field]" <?php if(isset($options['conikal_admin_submit_petition_only_field'])) { checked( $options['conikal_admin_submit_petition_only_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_review_field_render') ): 
    function conikal_review_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input type="checkbox" name="conikal_general_settings[conikal_review_field]" <?php if(isset($options['conikal_review_field'])) { checked( $options['conikal_review_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_review_decision_field_render') ): 
    function conikal_review_decision_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input type="checkbox" name="conikal_general_settings[conikal_review_decision_field]" <?php if(isset($options['conikal_review_decision_field'])) { checked( $options['conikal_review_decision_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_review_contribute_field_render') ): 
    function conikal_review_contribute_field_render() {
        $options = get_option( 'conikal_general_settings' );
        ?>
        <input type="checkbox" name="conikal_general_settings[conikal_review_contribute_field]" <?php if(isset($options['conikal_review_contribute_field'])) { checked( $options['conikal_review_contribute_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_google_analytics_field_render') ): 
    function conikal_google_analytics_field_render() { 
        $options = get_option( 'conikal_general_settings' );
        ?>
        <textarea class="form-control" cols='40' rows='5' name='conikal_general_settings[conikal_google_analytics_field]'><?php if(isset($options['conikal_google_analytics_field'])) { echo esc_html($options['conikal_google_analytics_field']); } ?></textarea>
        <?php
    }
endif;


/***********************************
* HOME SECTION RENDER
************************************/

if( !function_exists('conikal_home_header_field_render') ): 
    function conikal_home_header_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        $headers = array("none", "slideshow", "video");
        $header_select = '<select class="form-control" id="conikal_home_settings[conikal_home_header_field]" name="conikal_home_settings[conikal_home_header_field]">';

        foreach($headers as $header) {
            $header_select .= '<option value="' . esc_attr($header) . '"';
            if(isset($options['conikal_home_header_field']) && $options['conikal_home_header_field'] == $header) {
                $header_select .= 'selected="selected"';
            }
            $header_select .= '>' . esc_html($header) . '</option>';
        }

        $header_select .= '</select>';

        print $header_select;
    }
endif;

if( !function_exists('conikal_home_header_video_field_render') ): 
    function conikal_home_header_video_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-9" style="padding-left: 0px;">
                <input class="form-control" id="homeVideo" type="text" size="40" name="conikal_home_settings[conikal_home_header_video_field]" value="<?php if(isset($options['conikal_home_header_video_field'])) { echo esc_attr($options['conikal_home_header_video_field']); } ?>" />
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" id="homeVideoBtn" style="margin-left: 1rem; padding: 0.4rem 1rem"><?php esc_html_e('Browse...', 'petition') ?></button>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists('conikal_home_header_video_sound_field_render') ): 
    function conikal_home_header_video_sound_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_header_video_sound_field]" <?php if(isset($options['conikal_home_header_video_sound_field'])) { checked( $options['conikal_home_header_video_sound_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_header_hide_logined_field_render') ): 
    function conikal_home_header_hide_logined_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_header_hide_logined_field]" <?php if(isset($options['conikal_home_header_hide_logined_field'])) { checked( $options['conikal_home_header_hide_logined_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_shadow_opacity_field_render') ): 
    function conikal_shadow_opacity_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        $opacities = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100");
        $opacity_select = '<select class="form-control petition-field" id="conikal_home_settings[conikal_shadow_opacity_field]" name="conikal_home_settings[conikal_shadow_opacity_field]">';

        foreach($opacities as $opacity) {
            $opacity_select .= '<option value="' . esc_attr($opacity) . '"';
            if(isset($options['conikal_shadow_opacity_field']) && $options['conikal_shadow_opacity_field'] == $opacity) {
                $opacity_select .= 'selected="selected"';
            }
            $opacity_select .= '>' . esc_html($opacity) . '%</option>';
        }

        $opacity_select .= '</select>';

        print $opacity_select;
    }
endif;

if( !function_exists('conikal_hight_slideshow_field_render') ): 
    function conikal_hight_slideshow_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="number" size="40" name="conikal_home_settings[conikal_hight_slideshow_field]" value="<?php if(isset($options['conikal_hight_slideshow_field'])) { echo esc_attr($options['conikal_hight_slideshow_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_top_field_render') ): 
    function conikal_home_caption_top_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="number" size="40" name="conikal_home_settings[conikal_home_caption_top_field]" value="<?php if(isset($options['conikal_home_caption_top_field'])) { echo esc_attr($options['conikal_home_caption_top_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_field_render') ): 
    function conikal_home_caption_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_caption_field]" <?php if(isset($options['conikal_home_caption_field'])) { checked( $options['conikal_home_caption_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_alignment_field_render') ): 
    function conikal_home_caption_alignment_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        $alignments = array("center", "left", "right");
        $align_select = '<select class="form-control petition-field" id="conikal_home_settings[conikal_home_caption_alignment_field]" name="conikal_home_settings[conikal_home_caption_alignment_field]">';

        foreach($alignments as $alignment) {
            $align_select .= '<option value="' . esc_attr($alignment) . '"';
            if(isset($options['conikal_home_caption_alignment_field']) && $options['conikal_home_caption_alignment_field'] == $alignment) {
                $align_select .= 'selected="selected"';
            }
            $align_select .= '>' . esc_html($alignment) . '</option>';
        }

        $align_select .= '</select>';

        print $align_select;
    }
endif;

if( !function_exists('conikal_home_caption_title_field_render') ): 
    function conikal_home_caption_title_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_title_field]" value="<?php if(isset($options['conikal_home_caption_title_field'])) { echo esc_attr($options['conikal_home_caption_title_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_subtitle_field_render') ): 
    function conikal_home_caption_subtitle_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_subtitle_field]" value="<?php if(isset($options['conikal_home_caption_subtitle_field'])) { echo esc_attr($options['conikal_home_caption_subtitle_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_field_render') ): 
    function conikal_home_caption_cta_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_caption_cta_field]" <?php if(isset($options['conikal_home_caption_cta_field'])) { checked( $options['conikal_home_caption_cta_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_text_field_render') ): 
    function conikal_home_caption_cta_text_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_cta_text_field]" value="<?php if(isset($options['conikal_home_caption_cta_text_field'])) { echo esc_attr($options['conikal_home_caption_cta_text_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_link_field_render') ): 
    function conikal_home_caption_cta_link_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_cta_link_field]" value="<?php if(isset($options['conikal_home_caption_cta_link_field'])) { echo esc_attr($options['conikal_home_caption_cta_link_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_text_2_field_render') ): 
    function conikal_home_caption_cta_text_2_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_cta_text_2_field]" value="<?php if(isset($options['conikal_home_caption_cta_text_2_field'])) { echo esc_attr($options['conikal_home_caption_cta_text_2_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_link_2_field_render') ): 
    function conikal_home_caption_cta_link_2_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_caption_cta_link_2_field]" value="<?php if(isset($options['conikal_home_caption_cta_link_2_field'])) { echo esc_attr($options['conikal_home_caption_cta_link_2_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_caption_cta_size_field_render') ): 
    function conikal_home_caption_cta_size_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        $alignments = array("mini", "tiny", "small", "medium", "large", "big", "huge", "massive");
        $align_select = '<select class="form-control petition-field" id="conikal_home_settings[conikal_home_caption_cta_size_field]" name="conikal_home_settings[conikal_home_caption_cta_size_field]">';

        foreach($alignments as $alignment) {
            $align_select .= '<option value="' . esc_attr($alignment) . '"';
            if(isset($options['conikal_home_caption_cta_size_field']) && $options['conikal_home_caption_cta_size_field'] == $alignment) {
                $align_select .= 'selected="selected"';
            }
            $align_select .= '>' . esc_html($alignment) . '</option>';
        }

        $align_select .= '</select>';

        print $align_select;
    }
endif;

if( !function_exists('conikal_home_spotlight_field_render') ): 
    function conikal_home_spotlight_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_spotlight_field]" <?php if(isset($options['conikal_home_spotlight_field'])) { checked( $options['conikal_home_spotlight_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_spotlight_hide_logined_field_render') ): 
    function conikal_home_spotlight_hide_logined_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_spotlight_hide_logined_field]" <?php if(isset($options['conikal_home_spotlight_hide_logined_field'])) { checked( $options['conikal_home_spotlight_hide_logined_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_spotlight_title_field_render') ): 
    function conikal_home_spotlight_title_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_home_settings[conikal_home_spotlight_title_field]" value="<?php if(isset($options['conikal_home_spotlight_title_field'])) { echo esc_attr($options['conikal_home_spotlight_title_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_home_spotlight_text_field_render') ): 
    function conikal_home_spotlight_text_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <textarea class="form-control" cols='40' rows='5' name='conikal_home_settings[conikal_home_spotlight_text_field]'><?php if(isset($options['conikal_home_spotlight_text_field'])) { echo esc_html($options['conikal_home_spotlight_text_field']); } ?></textarea>
        <?php
    }
endif;

if( !function_exists('conikal_home_victory_field_render') ): 
    function conikal_home_victory_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_victory_field]" <?php if(isset($options['conikal_home_victory_field'])) { checked( $options['conikal_home_victory_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_home_victory_hide_logined_field_render') ): 
    function conikal_home_victory_hide_logined_field_render() { 
        $options = get_option( 'conikal_home_settings' );
        ?>
        <input type="checkbox" name="conikal_home_settings[conikal_home_victory_hide_logined_field]" <?php if(isset($options['conikal_home_victory_hide_logined_field'])) { checked( $options['conikal_home_victory_hide_logined_field'], 1 ); } ?> value="1">
        <?php
    }
endif;


/***********************************
* HEADER SECTION RENDER
************************************/

if( !function_exists('conikal_user_menu_field_render') ): 
    function conikal_user_menu_field_render() { 
        $options = get_option( 'conikal_header_settings' );
        ?>
        <input type="checkbox" name="conikal_header_settings[conikal_user_menu_field]" <?php if(isset($options['conikal_user_menu_field'])) { checked( $options['conikal_user_menu_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_submit_button_field_render') ): 
    function conikal_submit_button_field_render() { 
        $options = get_option( 'conikal_header_settings' );
        ?>
        <input type="checkbox" name="conikal_header_settings[conikal_submit_button_field]" <?php if(isset($options['conikal_submit_button_field'])) { checked( $options['conikal_submit_button_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_user_menu_name_field_render') ): 
    function conikal_user_menu_name_field_render() {
        $options = get_option( 'conikal_header_settings' );

        $types_name = array('none' => __('None', 'petition'), 'firstname' => __('First name', 'petition'), 'lastname' => __('Last name', 'petition'), 'fullname' => __('Full name', 'petition'), 'nickname' => __('Nick name', 'petition'));
        $type_select = '<select class="form-control" id="conikal_header_settings[conikal_user_menu_name_field]" name="conikal_header_settings[conikal_user_menu_name_field]">';

        foreach($types_name as $type => $name) {
            $type_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_user_menu_name_field']) && $options['conikal_user_menu_name_field'] == $type) {
                $type_select .= 'selected="selected"';
            }
            $type_select .= '>' . esc_html($name) . '</option>';
        }

        $type_select .= '</select>';

        print $type_select;
    }
endif;

if( !function_exists('conikal_style_header_menu_field_render') ): 
    function conikal_style_header_menu_field_render() {
        $options = get_option( 'conikal_header_settings' );
        $types_name = array('boxed' => __('Boxed', 'petition'), 'wide' => __('Wide', 'petition'));
        $type_select = '<select class="form-control" id="conikal_header_settings[conikal_style_header_menu_field]" name="conikal_header_settings[conikal_style_header_menu_field]">';

        foreach($types_name as $type => $name) {
            $type_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_style_header_menu_field']) && $options['conikal_style_header_menu_field'] == $type) {
                $type_select .= 'selected="selected"';
            }
            $type_select .= '>' . esc_html($name) . '</option>';
        }

        $type_select .= '</select>';

        print $type_select;

    }
endif;

if( !function_exists('conikal_type_header_menu_field_render') ): 
    function conikal_type_header_menu_field_render() {
        $options = get_option( 'conikal_header_settings' );
        $types_name = array('none' => __('None', 'petition'), 'fixed' => __('Fixed', 'petition'), 'scroll' => __('Scroll', 'petition'));
        $type_select = '<select class="form-control" id="conikal_header_settings[conikal_type_header_menu_field]" name="conikal_header_settings[conikal_type_header_menu_field]">';

        foreach($types_name as $type => $name) {
            $type_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_type_header_menu_field']) && $options['conikal_type_header_menu_field'] == $type) {
                $type_select .= 'selected="selected"';
            }
            $type_select .= '>' . esc_html($name) . '</option>';
        }

        $type_select .= '</select>';

        print $type_select;

    }
endif;

if( !function_exists('conikal_mobile_menu_animation_field_render') ): 
    function conikal_mobile_menu_animation_field_render() { 
        $options = get_option( 'conikal_header_settings' );
        $animations = array('overlay' => __('Overlay', 'petition'), 'push' => __('Push', 'petition'), 'scale down' => __('Scale Down', 'petition'));
        $type_select = '<select class="form-control" id="conikal_header_settings[conikal_mobile_menu_animation_field]" name="conikal_header_settings[conikal_mobile_menu_animation_field]">';

        foreach($animations as $type => $name) {
            $type_select .= '<option value="' . esc_attr($type) . '"';
            if(isset($options['conikal_mobile_menu_animation_field']) && $options['conikal_mobile_menu_animation_field'] == $type) {
                $type_select .= 'selected="selected"';
            }
            $type_select .= '>' . esc_html($name) . '</option>';
        }

        $type_select .= '</select>';

        print $type_select;
    }
endif;

if( !function_exists('conikal_page_header_opacity_field_render') ): 
    function conikal_page_header_opacity_field_render() { 
        $options = get_option( 'conikal_header_settings' );
        $opacities = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100");
        $opacity_select = '<select class="form-control petition-field" id="conikal_header_settings[conikal_page_header_opacity_field]" name="conikal_header_settings[conikal_page_header_opacity_field]">';

        foreach($opacities as $opacity) {
            $opacity_select .= '<option value="' . esc_attr($opacity) . '"';
            if(isset($options['conikal_page_header_opacity_field']) && $options['conikal_page_header_opacity_field'] == $opacity) {
                $opacity_select .= 'selected="selected"';
            }
            $opacity_select .= '>' . esc_html($opacity) . '%</option>';
        }

        $opacity_select .= '</select>';

        print $opacity_select;
    }
endif;

if( !function_exists('conikal_post_header_opacity_field_render') ): 
    function conikal_post_header_opacity_field_render() { 
        $options = get_option( 'conikal_header_settings' );
        $opacities = array("0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100");
        $opacity_select = '<select class="form-control petition-field" id="conikal_header_settings[conikal_post_header_opacity_field]" name="conikal_header_settings[conikal_post_header_opacity_field]">';

        foreach($opacities as $opacity) {
            $opacity_select .= '<option value="' . esc_attr($opacity) . '"';
            if(isset($options['conikal_post_header_opacity_field']) && $options['conikal_post_header_opacity_field'] == $opacity) {
                $opacity_select .= 'selected="selected"';
            }
            $opacity_select .= '>' . esc_html($opacity) . '%</option>';
        }

        $opacity_select .= '</select>';

        print $opacity_select;
    }
endif;


/***********************************
* APPEARENCE SECTION RENDER
************************************/

if( !function_exists('conikal_container_width_field_render') ): 
    function conikal_container_width_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_container_width_field]" value="<?php if(isset($options['conikal_container_width_field'])) { echo esc_attr($options['conikal_container_width_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_sidebar_field_render') ): 
    function conikal_sidebar_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        $sidebars = array("left", "right");
        $sidebar_select = '<select class="form-control" id="conikal_appearance_settings[conikal_sidebar_field]" name="conikal_appearance_settings[conikal_sidebar_field]">';

        foreach($sidebars as $sidebar) {
            $sidebar_select .= '<option value="' . esc_attr($sidebar) . '"';
            if(isset($options['conikal_sidebar_field']) && $options['conikal_sidebar_field'] == $sidebar) {
                $sidebar_select .= 'selected="selected"';
            }
            $sidebar_select .= '>' . esc_html($sidebar) . '</option>';
        }

        $sidebar_select .= '</select>';

        print $sidebar_select;
    }
endif;

if( !function_exists('conikal_ajax_comment_field_render') ): 
    function conikal_ajax_comment_field_render() {
        $options = get_option( 'conikal_appearance_settings' );
        $values = array('disabled', 'enabled'); ?>

        <?php 
        $value_select = '<select class="form-control" id="conikal_appearance_settings[conikal_ajax_comment_field]" name="conikal_appearance_settings[conikal_ajax_comment_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_ajax_comment_field']) && $options['conikal_ajax_comment_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_action_after_sign_field_render') ): 
    function conikal_action_after_sign_field_render() {
        $options = get_option( 'conikal_appearance_settings' );
        $values = array('none' => __('None action', 'petition'), 'refresh' => __('Refresh current page', 'petition'), 'redirect' => __('Redirect to success page', 'petition'), 'modal' => __('Show modal', 'petition')); ?>

        <?php 
        $value_select = '<select class="form-control" id="conikal_appearance_settings[conikal_action_after_sign_field]" name="conikal_appearance_settings[conikal_action_after_sign_field]">';

        foreach($values as $key => $value) {
            $value_select .= '<option value="' . esc_attr($key) . '"';
            if(isset($options['conikal_action_after_sign_field']) && $options['conikal_action_after_sign_field'] == $key) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_default_accordion_sign_field_render') ): 
    function conikal_default_accordion_sign_field_render() {
        $options = get_option( 'conikal_appearance_settings' );
        $values = array('share' => __('Share on Facebook', 'petition'), 'contribute' => __('Contribute & Donation', 'petition')); ?>

        <?php 
        $value_select = '<select class="form-control" id="conikal_appearance_settings[conikal_default_accordion_sign_field]" name="conikal_appearance_settings[conikal_default_accordion_sign_field]">';

        foreach($values as $key => $value) {
            $value_select .= '<option value="' . esc_attr($key) . '"';
            if(isset($options['conikal_default_accordion_sign_field']) && $options['conikal_default_accordion_sign_field'] == $key) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_disable_unsign_field_render') ): 
    function conikal_disable_unsign_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_disable_unsign_field]" <?php if(isset($options['conikal_disable_unsign_field'])) { checked( $options['conikal_disable_unsign_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_view_counter_field_render') ): 
    function conikal_view_counter_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_view_counter_field]" <?php if(isset($options['conikal_view_counter_field'])) { checked( $options['conikal_view_counter_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_related_field_render') ): 
    function conikal_related_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_related_field]" <?php if(isset($options['conikal_related_field'])) { checked( $options['conikal_related_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_similar_field_render') ): 
    function conikal_similar_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_similar_field]" <?php if(isset($options['conikal_similar_field'])) { checked( $options['conikal_similar_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_similar_base_field_render') ): 
    function conikal_similar_base_field_render() {
        $options = get_option( 'conikal_appearance_settings' );
        $values = array('both' => __('Both Category & Topics', 'petition'), 'category' => __('Base on Category', 'petition'), 'topics' => __('Base on Topics', 'petition')); ?>

        <?php 
        $value_select = '<select class="form-control" id="conikal_appearance_settings[conikal_similar_base_field]" name="conikal_appearance_settings[conikal_similar_base_field]">';

        foreach($values as $key => $value) {
            $value_select .= '<option value="' . esc_attr($key) . '"';
            if(isset($options['conikal_similar_base_field']) && $options['conikal_similar_base_field'] == $key) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_similar_related_per_page_field_render') ): 
    function conikal_similar_related_per_page_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_similar_related_per_page_field]" value="<?php if(isset($options['conikal_similar_related_per_page_field'])) { echo esc_attr($options['conikal_similar_related_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_petitions_per_page_field_render') ): 
    function conikal_petitions_per_page_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_petitions_per_page_field]" value="<?php if(isset($options['conikal_petitions_per_page_field'])) { echo esc_attr($options['conikal_petitions_per_page_field']); } ?>" />
        <?php
    }
endif;


if( !function_exists('conikal_updates_per_page_field_render') ): 
    function conikal_updates_per_page_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_updates_per_page_field]" value="<?php if(isset($options['conikal_updates_per_page_field'])) { echo esc_attr($options['conikal_updates_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_comments_per_page_field_render') ): 
    function conikal_comments_per_page_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_comments_per_page_field]" value="<?php if(isset($options['conikal_comments_per_page_field'])) { echo esc_attr($options['conikal_comments_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_reply_per_comment_field_render') ): 
    function conikal_reply_per_comment_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_reply_per_comment_field]" value="<?php if(isset($options['conikal_reply_per_comment_field'])) { echo esc_attr($options['conikal_reply_per_comment_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_supporter_per_page_field_render') ): 
    function conikal_supporter_per_page_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input class="form-control" type="number" size="5" name="conikal_appearance_settings[conikal_supporter_per_page_field]" value="<?php if(isset($options['conikal_supporter_per_page_field'])) { echo esc_attr($options['conikal_supporter_per_page_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_breadcrumbs_field_render') ): 
    function conikal_breadcrumbs_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_breadcrumbs_field]" <?php if(isset($options['conikal_breadcrumbs_field'])) { checked( $options['conikal_breadcrumbs_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_show_supporters_section_field_render') ): 
    function conikal_show_supporters_section_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_show_supporters_section_field]" <?php if(isset($options['conikal_show_supporters_section_field'])) { checked( $options['conikal_show_supporters_section_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_show_donors_section_field_render') ): 
    function conikal_show_donors_section_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <input type="checkbox" name="conikal_appearance_settings[conikal_show_donors_section_field]" <?php if(isset($options['conikal_show_donors_section_field'])) { checked( $options['conikal_show_donors_section_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_copyright_field_render') ): 
    function conikal_copyright_field_render() { 
        $options = get_option( 'conikal_appearance_settings' );
        ?>
        <textarea class="form-control" cols='40' rows='5' name='conikal_appearance_settings[conikal_copyright_field]'><?php if(isset($options['conikal_copyright_field'])) { echo esc_html($options['conikal_copyright_field']); } ?></textarea>
        <?php
    }
endif;


/***********************************
* AUTHENTICATION SECTION RENDER
************************************/

if( !function_exists('conikal_fb_login_field_render') ): 
    function conikal_fb_login_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input type="checkbox" name="conikal_auth_settings[conikal_fb_login_field]" <?php if(isset($options['conikal_fb_login_field'])) { checked( $options['conikal_fb_login_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_fb_id_field_render') ): 
    function conikal_fb_id_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_fb_id_field]" value="<?php if(isset($options['conikal_fb_id_field'])) { echo esc_attr($options['conikal_fb_id_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_fb_secret_field_render') ): 
    function conikal_fb_secret_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_fb_secret_field]" value="<?php if(isset($options['conikal_fb_secret_field'])) { echo esc_attr($options['conikal_fb_secret_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_google_login_field_render') ): 
    function conikal_google_login_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input type="checkbox" name="conikal_auth_settings[conikal_google_login_field]" <?php if(isset($options['conikal_google_login_field'])) { checked( $options['conikal_google_login_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_google_id_field_render') ): 
    function conikal_google_id_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_google_id_field]" value="<?php if(isset($options['conikal_google_id_field'])) { echo esc_attr($options['conikal_google_id_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_google_secret_field_render') ): 
    function conikal_google_secret_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_google_secret_field]" value="<?php if(isset($options['conikal_google_secret_field'])) { echo esc_attr($options['conikal_google_secret_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_gmaps_key_field_render') ): 
    function conikal_gmaps_key_field_render() {
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_gmaps_key_field]" value="<?php if(isset($options['conikal_gmaps_key_field'])) { echo esc_attr($options['conikal_gmaps_key_field']); } ?>" />
        <p class="help">The Google Maps JavaScript API v3 does not require an API key to function correctly. However, we strongly encourage you to load the Maps API using an APIs Console key. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">here</a>.</p>
        <?php
    }
endif;

if( !function_exists('conikal_sendinblue_list_field_render') ): 
    function conikal_sendinblue_list_field_render() { 
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input type="checkbox" name="conikal_auth_settings[conikal_sendinblue_list_field]" <?php if(isset($options['conikal_sendinblue_list_field'])) { checked( $options['conikal_sendinblue_list_field'], 1 ); } ?> value="1">
        <?php
    }
endif;

if( !function_exists('conikal_sendinblue_key_field_render') ): 
    function conikal_sendinblue_key_field_render() {
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="text" size="40" name="conikal_auth_settings[conikal_sendinblue_key_field]" value="<?php if(isset($options['conikal_sendinblue_key_field'])) { echo esc_attr($options['conikal_sendinblue_key_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_sendinblue_folder_id_field_render') ): 
    function conikal_sendinblue_folder_id_field_render() {
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <input class="form-control" type="number" size="40" name="conikal_auth_settings[conikal_sendinblue_folder_id_field]" value="<?php if(isset($options['conikal_sendinblue_folder_id_field'])) { echo esc_attr($options['conikal_sendinblue_folder_id_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_sendinblue_name_field_render') ): 
    function conikal_sendinblue_name_field_render() {
        $options = get_option( 'conikal_auth_settings' );
        ?>
        <div class="row no-gutters">
            <div class="col-sm-5">
                <div class="input-group">
                <div class="input-group-addon"><?php _e('NAME', 'petition') ?></div>
                <input class="form-control" type="text" name="conikal_auth_settings[conikal_sendinblue_name_field]" value="<?php if(isset($options['conikal_sendinblue_name_field'])) { echo esc_attr($options['conikal_sendinblue_name_field']); } ?>" />
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                <div class="input-group-addon"><?php _e('FIRSTNAME', 'petition') ?></div>
                <input class="form-control" type="text" name="conikal_auth_settings[conikal_sendinblue_firstname_field]" value="<?php if(isset($options['conikal_sendinblue_firstname_field'])) { echo esc_attr($options['conikal_sendinblue_firstname_field']); } ?>" />
                </div>
            </div>
        </div>
        <?php
    }
endif;


/***********************************
* CORLOR SECTION RENDER
************************************/

if( !function_exists('conikal_main_color_field_render') ): 
    function conikal_main_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_main_color_field]" value="<?php if(isset($options['conikal_main_color_field'])) { echo esc_attr($options['conikal_main_color_field']); } ?>">
        <?php
    }
endif;
if( !function_exists('conikal_background_color_field_render') ): 
    function conikal_background_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_background_color_field]" value="<?php if(isset($options['conikal_background_color_field'])) { echo esc_attr($options['conikal_background_color_field']); } ?>">
        <?php
    }
endif;
if( !function_exists('conikal_body_text_color_field_render') ): 
    function conikal_body_text_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_body_text_color_field]" value="<?php if(isset($options['conikal_body_text_color_field'])) { echo esc_attr($options['conikal_body_text_color_field']); } ?>">
        <?php
    }
endif;
if( !function_exists('conikal_text_link_color_field_render') ): 
    function conikal_text_link_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_text_link_color_field]" value="<?php if(isset($options['conikal_text_link_color_field'])) echo esc_attr($options['conikal_text_link_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_home_caption_color_field_render') ): 
    function conikal_home_caption_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_home_caption_color_field]" value="<?php if(isset($options['conikal_home_caption_color_field'])) echo esc_attr($options['conikal_home_caption_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_preloader_progress_color_field_render') ): 
    function conikal_preloader_progress_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_preloader_progress_color_field]" value="<?php if(isset($options['conikal_preloader_progress_color_field'])) echo esc_attr($options['conikal_preloader_progress_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_opacity_hero_page_color_field_render') ): 
    function conikal_opacity_hero_page_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_opacity_hero_page_color_field]" value="<?php if(isset($options['conikal_opacity_hero_page_color_field'])) echo esc_attr($options['conikal_opacity_hero_page_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_header_menu_color_field_render') ): 
    function conikal_header_menu_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_header_menu_color_field]" value="<?php if(isset($options['conikal_header_menu_color_field'])) echo esc_attr($options['conikal_header_menu_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_header_menu_text_color_field_render') ): 
    function conikal_header_menu_text_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_header_menu_text_color_field]" value="<?php if(isset($options['conikal_header_menu_text_color_field'])) echo esc_attr($options['conikal_header_menu_text_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_home_menu_text_color_field_render') ): 
    function conikal_home_menu_text_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_home_menu_text_color_field]" value="<?php if(isset($options['conikal_home_menu_text_color_field'])) echo esc_attr($options['conikal_home_menu_text_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_victory_color_field_render') ): 
    function conikal_victory_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_victory_color_field]" value="<?php if(isset($options['conikal_victory_color_field'])) echo esc_attr($options['conikal_victory_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_signup_button_color_field_render') ): 
    function conikal_signup_button_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_signup_button_color_field]" value="<?php if(isset($options['conikal_signup_button_color_field'])) echo esc_attr($options['conikal_signup_button_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_victory_label_color_field_render') ): 
    function conikal_victory_label_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_victory_label_color_field]" value="<?php if(isset($options['conikal_victory_label_color_field'])) echo esc_attr($options['conikal_victory_label_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_sign_petition_button_color_field_render') ): 
    function conikal_sign_petition_button_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_sign_petition_button_color_field]" value="<?php if(isset($options['conikal_sign_petition_button_color_field'])) echo esc_attr($options['conikal_sign_petition_button_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_submit_petition_button_color_field_render') ): 
    function conikal_submit_petition_button_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_submit_petition_button_color_field]" value="<?php if(isset($options['conikal_submit_petition_button_color_field'])) echo esc_attr($options['conikal_submit_petition_button_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_mobile_menu_bg_color_field_render') ): 
    function conikal_mobile_menu_bg_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_mobile_menu_bg_color_field]" value="<?php if(isset($options['conikal_mobile_menu_bg_color_field'])) echo esc_attr($options['conikal_mobile_menu_bg_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_mobile_menu_text_link_color_field_render') ): 
    function conikal_mobile_menu_text_link_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_mobile_menu_text_link_color_field]" value="<?php if(isset($options['conikal_mobile_menu_text_link_color_field'])) echo esc_attr($options['conikal_mobile_menu_text_link_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_post_overlay_primary_color_field_render') ): 
    function conikal_post_overlay_primary_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_post_overlay_primary_color_field]" value="<?php if(isset($options['conikal_post_overlay_primary_color_field'])) echo esc_attr($options['conikal_post_overlay_primary_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_post_overlay_secondary_color_field_render') ): 
    function conikal_post_overlay_secondary_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_post_overlay_secondary_color_field]" value="<?php if(isset($options['conikal_post_overlay_secondary_color_field'])) echo esc_attr($options['conikal_post_overlay_secondary_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_footer_bg_color_field_render') ): 
    function conikal_footer_bg_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_footer_bg_color_field]" value="<?php if(isset($options['conikal_footer_bg_color_field'])) echo esc_attr($options['conikal_footer_bg_color_field']); ?>">
        <?php
    }
endif;
if( !function_exists('conikal_footer_text_color_field_render') ): 
    function conikal_footer_text_color_field_render() { 
        $options = get_option( 'conikal_colors_settings' );
        ?>
        <input type="text" class="color-field" name="conikal_colors_settings[conikal_footer_text_color_field]" value="<?php if(isset($options['conikal_footer_text_color_field'])) echo esc_attr($options['conikal_footer_text_color_field']); ?>">
        <?php
    }
endif;


/***********************************
* TYPOGRAPHY SECTION RENDER
************************************/

if ( !function_exists('get_google_fonts') ):
    function get_google_fonts() {
        global $wp_version;
        $conikal_auth_settings = get_option( 'conikal_auth_settings' );
        $google_api_key = isset($conikal_auth_settings['conikal_gmaps_key_field']) ? $conikal_auth_settings['conikal_gmaps_key_field'] : 'AIzaSyAUYuX_iOuWgl5b5gSdmaL1QeLgbmxbBnU';
        $url = get_template_directory_uri() . '/admin/fonts/webfonts.json';
        $args = array(
            'timeout'     => 3000,
            'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url()
        );
        $response = wp_remote_get( $url, $args );

        return json_decode($response['body']);
    }
endif;


if( !function_exists('conikal_body_font_field_render') ): 
    function conikal_body_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_body_font_field]" name="conikal_typography_settings[conikal_typography_body_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_body_font_field']) && $options['conikal_typography_body_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_body_weight_field]" name="conikal_typography_settings[conikal_typography_body_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_body_weight_field']) && $options['conikal_typography_body_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_body_size_field]" name="conikal_typography_settings[conikal_typography_body_size_field]" value="' . ( isset($options['conikal_typography_body_size_field']) ? esc_attr($options['conikal_typography_body_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_body_line_field]" name="conikal_typography_settings[conikal_typography_body_line_field]" value="' . ( isset($options['conikal_typography_body_line_field']) ? esc_attr($options['conikal_typography_body_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_home_heading_font_field_render') ): 
    function conikal_home_heading_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_home_heading_font_field]" name="conikal_typography_settings[conikal_typography_home_heading_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_home_heading_font_field']) && $options['conikal_typography_home_heading_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_home_heading_weight_field]" name="conikal_typography_settings[conikal_typography_home_heading_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_home_heading_weight_field']) && $options['conikal_typography_home_heading_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_home_heading_size_field]" name="conikal_typography_settings[conikal_typography_home_heading_size_field]" value="' . ( isset($options['conikal_typography_home_heading_size_field']) ? esc_attr($options['conikal_typography_home_heading_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_home_heading_line_field]" name="conikal_typography_settings[conikal_typography_home_heading_line_field]" value="' . ( isset($options['conikal_typography_home_heading_line_field']) ? esc_attr($options['conikal_typography_home_heading_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_home_subheading_font_field_render') ): 
    function conikal_home_subheading_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_home_subheading_font_field]" name="conikal_typography_settings[conikal_typography_home_subheading_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_home_subheading_font_field']) && $options['conikal_typography_home_subheading_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_home_subheading_weight_field]" name="conikal_typography_settings[conikal_typography_home_subheading_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_home_subheading_weight_field']) && $options['conikal_typography_home_subheading_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_home_subheading_size_field]" name="conikal_typography_settings[conikal_typography_home_subheading_size_field]" value="' . ( isset($options['conikal_typography_home_subheading_size_field']) ? esc_attr($options['conikal_typography_home_subheading_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_home_subheading_line_field]" name="conikal_typography_settings[conikal_typography_home_subheading_line_field]" value="' . ( isset($options['conikal_typography_home_subheading_line_field']) ? esc_attr($options['conikal_typography_home_subheading_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_heading_font_field_render') ): 
    function conikal_heading_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_heading_font_field]" name="conikal_typography_settings[conikal_typography_heading_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_heading_font_field']) && $options['conikal_typography_heading_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_heading_weight_field]" name="conikal_typography_settings[conikal_typography_heading_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_heading_weight_field']) && $options['conikal_typography_heading_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_heading_size_field]" name="conikal_typography_settings[conikal_typography_heading_size_field]" value="' . ( isset($options['conikal_typography_heading_size_field']) ? esc_attr($options['conikal_typography_heading_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_heading_line_field]" name="conikal_typography_settings[conikal_typography_heading_line_field]" value="' . ( isset($options['conikal_typography_heading_line_field']) ? esc_attr($options['conikal_typography_heading_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';


        print $fonts_select;
    }
endif;

if( !function_exists('conikal_page_heading_font_field_render') ): 
    function conikal_page_heading_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_page_heading_font_field]" name="conikal_typography_settings[conikal_typography_page_heading_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_page_heading_font_field']) && $options['conikal_typography_page_heading_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_page_heading_weight_field]" name="conikal_typography_settings[conikal_typography_page_heading_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_page_heading_weight_field']) && $options['conikal_typography_page_heading_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_page_heading_size_field]" name="conikal_typography_settings[conikal_typography_page_heading_size_field]" value="' . ( isset($options['conikal_typography_page_heading_size_field']) ? esc_attr($options['conikal_typography_page_heading_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_page_heading_line_field]" name="conikal_typography_settings[conikal_typography_page_heading_line_field]" value="' . ( isset($options['conikal_typography_page_heading_line_field']) ? esc_attr($options['conikal_typography_page_heading_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_widget_title_font_field_render') ): 
    function conikal_widget_title_font_field_render() {
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_widget_title_font_field]" name="conikal_typography_settings[conikal_typography_widget_title_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_widget_title_font_field']) && $options['conikal_typography_widget_title_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_widget_title_weight_field]" name="conikal_typography_settings[conikal_typography_widget_title_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_widget_title_weight_field']) && $options['conikal_typography_widget_title_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_widget_title_size_field]" name="conikal_typography_settings[conikal_typography_widget_title_size_field]" value="' . ( isset($options['conikal_typography_widget_title_size_field']) ? esc_attr($options['conikal_typography_widget_title_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_widget_title_line_field]" name="conikal_typography_settings[conikal_typography_widget_title_line_field]" value="' . ( isset($options['conikal_typography_widget_title_line_field']) ? esc_attr($options['conikal_typography_widget_title_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_title_font_field_render') ): 
    function conikal_title_font_field_render() { 
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_title_font_field]" name="conikal_typography_settings[conikal_typography_title_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_title_font_field']) && $options['conikal_typography_title_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_title_weight_field]" name="conikal_typography_settings[conikal_typography_title_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_title_weight_field']) && $options['conikal_typography_title_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_title_size_field]" name="conikal_typography_settings[conikal_typography_title_size_field]" value="' . ( isset($options['conikal_typography_title_size_field']) ? esc_attr($options['conikal_typography_title_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_title_line_field]" name="conikal_typography_settings[conikal_typography_title_line_field]" value="' . ( isset($options['conikal_typography_title_line_field']) ? esc_attr($options['conikal_typography_title_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_content_font_field_render') ): 
    function conikal_content_font_field_render() { 
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_content_font_field]" name="conikal_typography_settings[conikal_typography_content_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_content_font_field']) && $options['conikal_typography_content_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_content_weight_field]" name="conikal_typography_settings[conikal_typography_content_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_content_weight_field']) && $options['conikal_typography_content_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_content_size_field]" name="conikal_typography_settings[conikal_typography_content_size_field]" value="' . ( isset($options['conikal_typography_content_size_field']) ? esc_attr($options['conikal_typography_content_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_content_line_field]" name="conikal_typography_settings[conikal_typography_content_line_field]" value="' . ( isset($options['conikal_typography_content_line_field']) ? esc_attr($options['conikal_typography_content_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;

if( !function_exists('conikal_button_font_field_render') ): 
    function conikal_button_font_field_render() { 
        $google_fonts = get_google_fonts();
        $options = get_option( 'conikal_typography_settings' );
        $weight = array('300', '400', '500', '600', '700', '800', '900');

        $fonts_select = '<div class="row no-gutters"><div class="col-sm-4">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_button_font_field]" name="conikal_typography_settings[conikal_typography_button_font_field]" class="google-fonts">';
        foreach ($google_fonts->items as $font) {
            $fonts_select .= '<option value="' . esc_html($font->family . ',' . $font->category) . '" ';
            if (isset($options['conikal_typography_button_font_field']) && $options['conikal_typography_button_font_field'] == $font->family . ',' . $font->category) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($font->family) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';
        $fonts_select .= '<select id="conikal_typography_settings[conikal_typography_button_weight_field]" name="conikal_typography_settings[conikal_typography_button_weight_field]" class="form-control">';
        foreach ($weight as $value) {
            $fonts_select .= '<option value="' . esc_html($value) . '" ';
            if (isset($options['conikal_typography_button_weight_field']) && $options['conikal_typography_button_weight_field'] == $value) {
                $fonts_select .= 'selected="selected"';
            }
            $fonts_select .= '>' . esc_html($value) . '</option>';
        }
        $fonts_select .= '</select>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Size', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_button_size_field]" name="conikal_typography_settings[conikal_typography_button_size_field]" value="' . ( isset($options['conikal_typography_button_size_field']) ? esc_attr($options['conikal_typography_button_size_field']) : esc_attr(14) ) . '">';
        $fonts_select .= '</div>';

        $fonts_select .= '</div><div class="col-sm-2">';

        $fonts_select .= '<div class="input-group">';
        $fonts_select .= '<div class="input-group-addon">' . esc_html('Line', 'petition') . '</div>';
        $fonts_select .= '<input type="number" class="form-control typography-number" id="conikal_typography_settings[conikal_typography_button_line_field]" name="conikal_typography_settings[conikal_typography_button_line_field]" value="' . ( isset($options['conikal_typography_button_line_field']) ? esc_attr($options['conikal_typography_button_line_field']) : esc_attr(24) ) . '">';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';
        $fonts_select .= '</div>';

        print $fonts_select;
    }
endif;


/***********************************
* PETITION FIELD SECTION RENDER
************************************/

if( !function_exists('conikal_p_category_field_render') ): 
    function conikal_p_category_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled'); ?>

        <?php 
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_category_field]" name="conikal_petition_fields_settings[conikal_p_category_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_category_field']) && $options['conikal_p_category_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_category_r_field]" name="conikal_petition_fields_settings[conikal_p_category_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_category_r_field']) && $options['conikal_p_category_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_topics_field_render') ): 
    function conikal_p_topics_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_topics_field]" name="conikal_petition_fields_settings[conikal_p_topics_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_topics_field']) && $options['conikal_p_topics_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_topics_r_field]" name="conikal_petition_fields_settings[conikal_p_topics_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_topics_r_field']) && $options['conikal_p_topics_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_address_field_render') ): 
    function conikal_p_address_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_address_field]" name="conikal_petition_fields_settings[conikal_p_address_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_address_field']) && $options['conikal_p_address_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_address_r_field]" name="conikal_petition_fields_settings[conikal_p_address_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_address_r_field']) && $options['conikal_p_address_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_city_field_render') ): 
    function conikal_p_city_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_city_field]" name="conikal_petition_fields_settings[conikal_p_city_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_city_field']) && $options['conikal_p_city_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_city_r_field]" name="conikal_petition_fields_settings[conikal_p_city_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_city_r_field']) && $options['conikal_p_city_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_coordinates_field_render') ): 
    function conikal_p_coordinates_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_coordinates_field]" name="conikal_petition_fields_settings[conikal_p_coordinates_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_coordinates_field']) && $options['conikal_p_coordinates_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_coordinates_r_field]" name="conikal_petition_fields_settings[conikal_p_coordinates_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_coordinates_r_field']) && $options['conikal_p_coordinates_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_neighborhood_field_render') ): 
    function conikal_p_neighborhood_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_neighborhood_field]" name="conikal_petition_fields_settings[conikal_p_neighborhood_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_neighborhood_field']) && $options['conikal_p_neighborhood_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_neighborhood_r_field]" name="conikal_petition_fields_settings[conikal_p_neighborhood_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_neighborhood_r_field']) && $options['conikal_p_neighborhood_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_zip_field_render') ): 
    function conikal_p_zip_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_zip_field]" name="conikal_petition_fields_settings[conikal_p_zip_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_zip_field']) && $options['conikal_p_zip_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_zip_r_field]" name="conikal_petition_fields_settings[conikal_p_zip_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_zip_r_field']) && $options['conikal_p_zip_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_state_field_render') ): 
    function conikal_p_state_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_state_field]" name="conikal_petition_fields_settings[conikal_p_state_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_state_field']) && $options['conikal_p_state_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_state_r_field]" name="conikal_petition_fields_settings[conikal_p_state_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_state_r_field']) && $options['conikal_p_state_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_country_field_render') ): 
    function conikal_p_country_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_country_field]" name="conikal_petition_fields_settings[conikal_p_country_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_country_field']) && $options['conikal_p_country_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_country_r_field]" name="conikal_petition_fields_settings[conikal_p_country_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_country_r_field']) && $options['conikal_p_country_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_receiver_field_render') ): 
    function conikal_p_receiver_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_receiver_field]" name="conikal_petition_fields_settings[conikal_p_receiver_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_receiver_field']) && $options['conikal_p_receiver_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_receiver_r_field]" name="conikal_petition_fields_settings[conikal_p_receiver_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_receiver_r_field']) && $options['conikal_p_receiver_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_position_field_render') ): 
    function conikal_p_position_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_position_field]" name="conikal_petition_fields_settings[conikal_p_position_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_position_field']) && $options['conikal_p_position_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_position_r_field]" name="conikal_petition_fields_settings[conikal_p_position_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_position_r_field']) && $options['conikal_p_position_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_goal_field_render') ): 
    function conikal_p_goal_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_goal_field]" name="conikal_petition_fields_settings[conikal_p_goal_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_goal_field']) && $options['conikal_p_goal_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;

        $r_values = array(__('not required', 'petition'), 'required');
        $r_value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_goal_r_field]" name="conikal_petition_fields_settings[conikal_p_goal_r_field]">';

        foreach($r_values as $r_value) {
            $r_value_select .= '<option value="' . esc_attr($r_value) . '"';
            if(isset($options['conikal_p_goal_r_field']) && $options['conikal_p_goal_r_field'] == $r_value) {
                $r_value_select .= 'selected="selected"';
            }
            $r_value_select .= '>' . esc_html($r_value) . '</option>';
        }

        $r_value_select .= '</select>';

        print $r_value_select;
    }
endif;

if( !function_exists('conikal_p_goal_default_field_render') ): 
    function conikal_p_goal_default_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $goal_default = 100;
        if(isset($options['conikal_p_goal_default_field'])) {
                $goal_default = $options['conikal_p_goal_default_field'];
            }
        $d_value = '<input class="form-control" type="number" id="conikal_petition_fields_settings[conikal_p_goal_default_field]" class="btn btn-primary" name="conikal_petition_fields_settings[conikal_p_goal_default_field]" value="' . $goal_default . '">';
        print $d_value;
    }
endif;

if( !function_exists('conikal_p_video_field_render') ): 
    function conikal_p_video_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_video_field]" name="conikal_petition_fields_settings[conikal_p_video_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_video_field']) && $options['conikal_p_video_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_p_media_upload_field_render') ): 
    function conikal_p_media_upload_field_render() { 
        $options = get_option( 'conikal_petition_fields_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control petition-field" id="conikal_petition_fields_settings[conikal_p_media_upload_field]" name="conikal_petition_fields_settings[conikal_p_media_upload_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_p_media_upload_field']) && $options['conikal_p_media_upload_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;


/***********************************
* SEARCH SUGGESTION SECTION RENDER
************************************/

if( !function_exists('conikal_s_min_characters_field_render') ): 
    function conikal_s_min_characters_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        ?>
        <input type="text" size="5" name="conikal_search_settings[conikal_s_min_characters_field]" value="<?php if(isset($options['conikal_s_min_characters_field'])) { echo esc_attr($options['conikal_s_min_characters_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_s_max_results_field_render') ): 
    function conikal_s_max_results_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        ?>
        <input class="form-control" type="text" size="5" name="conikal_search_settings[conikal_s_max_results_field]" value="<?php if(isset($options['conikal_s_max_results_field'])) { echo esc_attr($options['conikal_s_max_results_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_s_type_field_render') ): 
    function conikal_s_type_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        $values = array(__('category', 'petition'), __('standard', 'petition'));
        $value_select = '<select class="form-control" id="conikal_search_settings[conikal_s_type_field]" name="conikal_search_settings[conikal_s_type_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_s_type_field']) && $options['conikal_s_type_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_s_link_field_render') ): 
    function conikal_s_link_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_search_settings[conikal_s_link_field]" name="conikal_search_settings[conikal_s_link_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_s_link_field']) && $options['conikal_s_link_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_s_description_field_render') ): 
    function conikal_s_description_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_search_settings[conikal_s_description_field]" name="conikal_search_settings[conikal_s_description_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_s_description_field']) && $options['conikal_s_description_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_s_image_field_render') ): 
    function conikal_s_image_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_search_settings[conikal_s_image_field]" name="conikal_search_settings[conikal_s_image_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_s_image_field']) && $options['conikal_s_image_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_s_supporters_field_render') ): 
    function conikal_s_supporters_field_render() { 
        $options = get_option( 'conikal_search_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_search_settings[conikal_s_supporters_field]" name="conikal_search_settings[conikal_s_supporters_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_s_supporters_field']) && $options['conikal_s_supporters_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;


/***********************************
* CONTACT SECTION RENDER
************************************/

if( !function_exists('conikal_company_name_field_render') ): 
    function conikal_company_name_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_name_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_name_field]" value="<?php if(isset($options['conikal_company_name_field'])) { echo esc_attr($options['conikal_company_name_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_email_field_render') ): 
    function conikal_company_email_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_email_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_email_field]" value="<?php if(isset($options['conikal_company_email_field'])) { echo esc_attr($options['conikal_company_email_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_phone_field_render') ): 
    function conikal_company_phone_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_phone_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_phone_field]" value="<?php if(isset($options['conikal_company_phone_field'])) { echo esc_attr($options['conikal_company_phone_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_mobile_field_render') ): 
    function conikal_company_mobile_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_mobile_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_mobile_field]" value="<?php if(isset($options['conikal_company_mobile_field'])) { echo esc_attr($options['conikal_company_mobile_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_skype_field_render') ): 
    function conikal_company_skype_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_skype_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_skype_field]" value="<?php if(isset($options['conikal_company_skype_field'])) { echo esc_attr($options['conikal_company_skype_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_address_field_render') ): 
    function conikal_company_address_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <textarea class="form-control" cols='40' rows='5' name="conikal_contact_settings[conikal_company_address_field]"><?php if(isset($options['conikal_company_address_field'])) { echo esc_html($options['conikal_company_address_field']); } ?></textarea>
        <?php
    }
endif;

if( !function_exists('conikal_company_facebook_field_render') ): 
    function conikal_company_facebook_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_facebook_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_facebook_field]" value="<?php if(isset($options['conikal_company_facebook_field'])) { echo esc_attr($options['conikal_company_facebook_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_twitter_field_render') ): 
    function conikal_company_twitter_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_twitter_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_twitter_field]" value="<?php if(isset($options['conikal_company_twitter_field'])) { echo esc_attr($options['conikal_company_twitter_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_google_field_render') ): 
    function conikal_company_google_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" id="conikal_contact_settings[conikal_company_google_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_google_field]" value="<?php if(isset($options['conikal_company_google_field'])) { echo esc_attr($options['conikal_company_google_field']); } ?>" />
        <?php
    }
endif;

if( !function_exists('conikal_company_linkedin_field_render') ): 
    function conikal_company_linkedin_field_render() {
        $options = get_option( 'conikal_contact_settings' );
        ?>
        <input class="form-control" class="form-control" id="conikal_contact_settings[conikal_company_linkedin_field]" type="text" size="40" name="conikal_contact_settings[conikal_company_linkedin_field]" value="<?php if(isset($options['conikal_company_linkedin_field'])) { echo esc_attr($options['conikal_company_linkedin_field']); } ?>" />
        <?php
    }
endif;


/***********************************
* SEARCH FILTER SECTION RENDER
************************************/

if( !function_exists('conikal_f_category_field_render') ): 
    function conikal_f_category_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filte_settings[conikal_f_category_field]" name="conikal_filter_settings[conikal_f_category_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_category_field']) && $options['conikal_f_category_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_f_topic_field_render') ): 
    function conikal_f_topic_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filter_settings[conikal_f_topic_field]" name="conikal_filter_settings[conikal_f_topic_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_topic_field']) && $options['conikal_f_topic_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_f_country_field_render') ): 
    function conikal_f_country_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filter_settings[conikal_f_country_field]" name="conikal_filter_settings[conikal_f_country_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_country_field']) && $options['conikal_f_country_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_f_state_field_render') ): 
    function conikal_f_state_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filter_settings[conikal_f_state_field]" name="conikal_filter_settings[conikal_f_state_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_state_field']) && $options['conikal_f_state_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_f_city_field_render') ): 
    function conikal_f_city_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filter_settings[conikal_f_city_field]" name="conikal_filter_settings[conikal_f_city_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_city_field']) && $options['conikal_f_city_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_f_neighborhood_field_render') ): 
    function conikal_f_neighborhood_field_render() { 
        $options = get_option( 'conikal_filter_settings' );
        $values = array('disabled', 'enabled');
        $value_select = '<select class="form-control" id="conikal_filter_settings[conikal_f_neighborhood_field]" name="conikal_filter_settings[conikal_f_neighborhood_field]">';

        foreach($values as $value) {
            $value_select .= '<option value="' . esc_attr($value) . '"';
            if(isset($options['conikal_f_neighborhood_field']) && $options['conikal_f_neighborhood_field'] == $value) {
                $value_select .= 'selected="selected"';
            }
            $value_select .= '>' . esc_html($value) . '</option>';
        }

        $value_select .= '</select>';

        print $value_select;
    }
endif;

if( !function_exists('conikal_general_settings_section_callback') ): 
    function conikal_general_settings_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_home_section_callback') ): 
    function conikal_home_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_header_section_callback') ): 
    function conikal_header_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_appearance_section_callback') ): 
    function conikal_appearance_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_colors_section_callback') ): 
    function conikal_colors_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_typography_section_callback') ): 
    function conikal_typography_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_petition_fields_section_callback') ): 
    function conikal_petition_fields_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_search_section_callback') ): 
    function conikal_search_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_filter_section_callback') ): 
    function conikal_filter_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_contact_section_callback') ): 
    function conikal_contact_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_auth_section_callback') ): 
    function conikal_auth_section_callback() { 
        echo '';
    }
endif;

if( !function_exists('conikal_settings_page') ): 
    function conikal_settings_page() { 
        $allowed_html = array();
        $active_tab = isset( $_GET[ 'tab' ] ) ? wp_kses( $_GET[ 'tab' ],$allowed_html ) : 'general_settings';
        $tab = 'conikal_general_settings';

        switch ($active_tab) {
            case "general_settings":
                conikal_admin_general_settings();
                $tab = 'conikal_general_settings';
                break;
            case "home":
                conikal_admin_home();
                $tab = 'conikal_home_settings';
                break;
            case "header":
                conikal_admin_header();
                $tab = 'conikal_header_settings';
                break;
            case "appearance":
                conikal_admin_appearance();
                $tab = 'conikal_appearance_settings';
                break;
            case "colors":
                conikal_admin_colors();
                $tab = 'conikal_colors_settings';
                break;
            case "typography":
                conikal_admin_typography();
                $tab = 'conikal_typography_settings';
                break;
            case "petition_fields":
                conikal_admin_petition_fields();
                $tab = 'conikal_petition_fields_settings';
                break;
            case "search":
                conikal_admin_search();
                $tab = 'conikal_search_settings';
                break;
            case "filter":
                conikal_admin_filter();
                $tab = 'conikal_filter_settings';
                break;
            case "contact":
                conikal_admin_contact();
                $tab = 'conikal_contact_settings';
                break;
            case "auth":
                conikal_admin_auth();
                $tab = 'conikal_auth_settings';
                break;
        }
        ?>

        <div class="petition-wrapper">
            <div class="petition-leftSide">
                <div class="petition-logo"><img src="<?php echo get_template_directory_uri() . '/admin/images/logo.svg'; ?>" /></div>
                <ul class="petition-tabs">
                    <li class="<?php echo ($active_tab == 'general_settings' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=general_settings">
                            <span class="fa fa-cog petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('General Settings', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'home' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=home">
                            <span class="fa fa-home petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Homepage', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'header' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=header">
                            <span class="fa fa-bars petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Header', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'appearance' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=appearance">
                            <span class="fa fa-desktop petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Appearance', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'colors' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=colors">
                            <span class="fa fa-paint-brush petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Colors', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'typography' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=typography">
                            <span class="fa fa-font petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Typography', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'petition_fields' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=petition_fields">
                            <span class="fa fa-edit petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Petition Fields', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'search' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=search">
                            <span class="fa fa-search petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Search Suggestion', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'filter' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=filter">
                            <span class="fa fa-sliders petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Search Filter', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'contact' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=contact">
                            <span class="fa fa-envelope petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Contact Details', 'petition') ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($active_tab == 'auth' ? esc_html('petition-tab-active') : '') ?>">
                        <a href="themes.php?page=admin/settings.php&tab=auth">
                            <span class="fa fa-key petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Authentication', 'petition') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.conikal.com/petition/documentation" target="_blank">
                            <span class="fa fa-life-buoy petition-tab-icon"></span><span class="petition-tab-link"><?php esc_html_e('Documentation', 'petition') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="petition-content">
                <form action='options.php' method='post'>
                    <?php
                    wp_nonce_field( 'update-options' );
                    settings_fields( $tab );
                    do_settings_sections( $tab );
                    submit_button();
                    ?>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php
    }
endif;

if( !function_exists('conikal_preloader_html') ): 
    function conikal_preloader_html($type_preloader = '') {
        switch ($type_preloader) {
            case 'chasing-dots':
                $html_preloader = '<div class="sk-chasing-dots"><div class="sk-child sk-dot1"></div><div class="sk-child sk-dot2"></div></div>';
                break;
            case 'cube-grid':
                $html_preloader = '<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>';
                break;
            case 'double-bounce':
                $html_preloader = '<div class="sk-double-bounce"><div class="sk-child sk-double-bounce1"></div><div class="sk-child sk-double-bounce2"></div></div>';
                break;
            case 'fading-circle':
                $html_preloader = '<div class="sk-fading-circle"><div class="sk-circle1 sk-circle"></div><div class="sk-circle2 sk-circle"></div><div class="sk-circle3 sk-circle"></div><div class="sk-circle4 sk-circle"></div><div class="sk-circle5 sk-circle"></div><div class="sk-circle6 sk-circle"></div><div class="sk-circle7 sk-circle"></div><div class="sk-circle8 sk-circle"></div><div class="sk-circle9 sk-circle"></div><div class="sk-circle10 sk-circle"></div><div class="sk-circle11 sk-circle"></div><div class="sk-circle12 sk-circle"></div></div>';
                break;
            case 'folding-cube':
                $html_preloader = '<div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div>';
                break;
            case 'pulse':
                $html_preloader = '<div class="sk-spinner sk-spinner-pulse"></div>';
                break;
            case 'rotating-plane':
                $html_preloader = '<div class="sk-rotating-plane"></div>';
                break;
            case 'three-bounce':
                $html_preloader = '<div class="sk-three-bounce"><div class="sk-child sk-bounce1"></div><div class="sk-child sk-bounce2"></div><div class="sk-child sk-bounce3"></div></div>';
                break;
            case 'wandering-cubes':
                $html_preloader = '<div class="sk-wandering-cubes"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div></div>';
                break;
            case 'wave':
                $html_preloader = '<div class="sk-wave"><div class="sk-rect sk-rect1"></div><div class="sk-rect sk-rect2"></div><div class="sk-rect sk-rect3"></div><div class="sk-rect sk-rect4"></div><div class="sk-rect sk-rect5"></div></div>';
                break;
            default:
                $html_preloader = '';
                break;
        }

        if ($html_preloader) {
            return $html_preloader;
        } else {
            return false;
        }
    }
endif;

?>