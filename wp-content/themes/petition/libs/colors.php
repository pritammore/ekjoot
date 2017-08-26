<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_home_settings = get_option('conikal_home_settings');
$caption_aligment = isset($conikal_home_settings['conikal_home_caption_alignment_field']) ? $conikal_home_settings['conikal_home_caption_alignment_field'] : '';

$conikal_header_settings = get_option('conikal_header_settings');
$page_header_opacity = isset($conikal_header_settings['conikal_page_header_opacity_field']) ? $conikal_header_settings['conikal_page_header_opacity_field'] : '';
$post_header_opacity = isset($conikal_header_settings['conikal_post_header_opacity_field']) ? $conikal_header_settings['conikal_post_header_opacity_field'] : '';

$conikal_colors_settings = get_option('conikal_colors_settings');
$shadow_opacity = isset($conikal_home_settings['conikal_shadow_opacity_field']) ? $conikal_home_settings['conikal_shadow_opacity_field'] : '';
$main_color = isset($conikal_colors_settings['conikal_main_color_field']) ? $conikal_colors_settings['conikal_main_color_field'] : '';
$background_color = isset($conikal_colors_settings['conikal_background_color_field']) ? $conikal_colors_settings['conikal_background_color_field'] : '';
$background_color = isset($conikal_colors_settings['conikal_background_color_field']) ? $conikal_colors_settings['conikal_background_color_field'] : '';
$body_text_color = isset($conikal_colors_settings['conikal_body_text_color_field']) ? $conikal_colors_settings['conikal_body_text_color_field'] : '';
$text_link_color = isset($conikal_colors_settings['conikal_text_link_color_field']) ? $conikal_colors_settings['conikal_text_link_color_field'] : '';
$home_caption_color = isset($conikal_colors_settings['conikal_home_caption_color_field']) ? $conikal_colors_settings['conikal_home_caption_color_field'] : '';
$preloader_progress_color = isset($conikal_colors_settings['conikal_preloader_progress_color_field']) ? $conikal_colors_settings['conikal_preloader_progress_color_field'] : '';
$opacity_hero_page_color = isset($conikal_colors_settings['conikal_opacity_hero_page_color_field']) ? $conikal_colors_settings['conikal_opacity_hero_page_color_field'] : '';
$header_menu_color = isset($conikal_colors_settings['conikal_header_menu_color_field']) ? $conikal_colors_settings['conikal_header_menu_color_field'] : '';
$header_menu_text_color = isset($conikal_colors_settings['conikal_header_menu_text_color_field']) ? $conikal_colors_settings['conikal_header_menu_text_color_field'] : '';
$victory_color = isset($conikal_colors_settings['conikal_victory_color_field']) ? $conikal_colors_settings['conikal_victory_color_field'] : '';
$signup_button_color = isset($conikal_colors_settings['conikal_signup_button_color_field']) ? $conikal_colors_settings['conikal_signup_button_color_field'] : '';
$victory_label_color = isset($conikal_colors_settings['conikal_victory_label_color_field']) ? $conikal_colors_settings['conikal_victory_label_color_field'] : '';
$sign_petition_button_color = isset($conikal_colors_settings['conikal_sign_petition_button_color_field']) ? $conikal_colors_settings['conikal_sign_petition_button_color_field'] : '';
$mobile_menu_bg_color = isset($conikal_colors_settings['conikal_mobile_menu_bg_color_field']) ? $conikal_colors_settings['conikal_mobile_menu_bg_color_field'] : '';
$mobile_menu_text_link_color = isset($conikal_colors_settings['conikal_mobile_menu_text_link_color_field']) ? $conikal_colors_settings['conikal_mobile_menu_text_link_color_field'] : '';
$post_overlay_primary_color = isset($conikal_colors_settings['conikal_post_overlay_primary_color_field']) ? $conikal_colors_settings['conikal_post_overlay_primary_color_field'] : '';
$post_overlay_secondary_color = isset($conikal_colors_settings['conikal_post_overlay_secondary_color_field']) ? $conikal_colors_settings['conikal_post_overlay_secondary_color_field'] : '';
$footer_bg_color = isset($conikal_colors_settings['conikal_footer_bg_color_field']) ? $conikal_colors_settings['conikal_footer_bg_color_field'] : '';
$footer_text_color = isset($conikal_colors_settings['conikal_footer_text_color_field']) ? $conikal_colors_settings['conikal_footer_text_color_field'] : '';


if($opacity_hero_page_color != '' || $shadow_opacity != '') {
    print '
        .slideshowShadow {
            background-color: ' . esc_html($opacity_hero_page_color) . ' !important;
            opacity: ' . esc_html($shadow_opacity / 100) . ' !important;
        }

        .topic-card.snip {
            background-color: ' . esc_html($opacity_hero_page_color) . ' !important;
        }

        .page-shadown {
            background-color: ' . esc_html($opacity_hero_page_color) . ' !important;
            opacity: ' . esc_html($page_header_opacity / 100) . ' !important;
        }

        .post-shadown {
            background-color: ' . esc_html($opacity_hero_page_color) . ' !important;
            opacity: ' . esc_html($post_header_opacity / 100) . ' !important;
        }
    ';

    if ($shadow_opacity < 90 && $shadow_opacity > 0) {
        print '
            .home-header {
                background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
                /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 0)));
                /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
                /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
                /* Opera 11.10+ */
                background: -ms-linear-gradient(top, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
                /* IE10+ */
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
                /* W3C */
                filter: progid: DXImageTransform.Microsoft.gradient( startColorstr="#80000000", endColorstr="#00000000", GradientType=0);
                /* IE6-9 */
            }
        ';
    }
}

if ($caption_aligment != '') {
    print '
        .home-caption { text-align: ' . $caption_aligment . ' }
    ';
}

if ($home_caption_color != '') {
    print '
        .home-caption .home-title, .home-caption .home-subtitle { color: ' . $home_caption_color . ' }
    ';
}

if($main_color != '') {
    print '
        .ui.primary.button, .ui.primary.buttons .button, input.wpcf7-form-control.wpcf7-submit, .topic-card.snip .follow-topic.following {
            background-color: ' . esc_html($main_color) . ' !important;
            color: #ffffff !important;
        }
        .ui.primary.button:hover, .ui.primary.buttons .button:hover {
            background-color: ' . esc_html($main_color) . ' !important;
            opacity: 0.87;
        }
        .ui.basic.primary.button, .ui.basic.primary.buttons .button {
            background: 0 0 !important;
            box-shadow: 0 0 0 1px #00b5ad inset !important;
            color: ' . esc_html($main_color) . ' !important;
        }
        .ui.primary.label, .ui.primary.labels .label {
            background-color: ' . esc_html($main_color) . ' !important;
            border-color: ' . esc_html($main_color) . ' !important;
            color: #fff !important;
        }
        .ui.primary.corner.label, .ui.primary.corner.label:hover {
            background-color: transparent !important;
        }
        .ui.primary.progress .bar, .title-divider {
            background-color: ' . esc_html($main_color) . ' !important;
        }
        .ui.primary.segment:not(.inverted) {
            border-top: 2px solid ' . esc_html($main_color) . ' !important;
        }
        .ui.primary.header, .ui.cards>.card>.extra a:not(.ui):hover {
            color: ' . esc_html($main_color) . ' !important;
        }
        .ui.search .results .result .price {
            color: ' . esc_html($main_color) . ' !important;
        }
        .ui.toggle.checkbox input:checked~.box:before, .ui.toggle.checkbox input:checked~label:before, .ui.toggle.checkbox input:focus:checked~.box:before, .ui.toggle.checkbox input:focus:checked~label:before {
            background-color: ' . esc_html($main_color) . ' !important;
        }
        .ui.ordered.steps .step.completed:before, .ui.steps .step.completed>.icon:before {
            color: ' . esc_html($main_color) . ' !important;
        }
        blockquote {
            border-left: 8px solid ' . esc_html($main_color) . ' !important;
            color: ' . esc_html($main_color) . ' !important;
        }
        blockquote::before {
            color: ' . esc_html($main_color) . ' !important;
        }
    ';
}

if($background_color != '') {
    print '
        body {
            background-color: ' . esc_html($background_color) . ' !important;
        }
    ';
}
if($body_text_color != '') {
    print '
        body, p, h1, h2, h3, h4, h5  {
            color: ' . esc_html($body_text_color) . ' !important;
        }
    ';
}
if($text_link_color != '') {
    print '
        a, .ui.card>.content>a.header, .ui.cards>.card>.content>a.header, .ui.breadcrumb a, .ui.steps .step.active .title {
            color: ' . esc_html($text_link_color) . ';
        }
        .category-menu a, .category-menu .nav-submenu .item a {
            color: ' . esc_html($text_link_color) . ' !important;
        }
        a:hover, .ui.card>.content>a.header:hover, .ui.cards>.card>.content>a.header:hover, .ui.comments .comment a.author:hover, .ui.breadcrumb a:hover, .ui.items a.item:hover .content .header, .ui.link.items>.item:hover .content .header {
            color: ' . esc_html($text_link_color) . ' ;
            opacity: 0.87;
        }
        .ui.inverted.list .item a:not(.ui):hover {
            color: #fafafa;
            opacity: 0.87;
        }
        .ui.list .list>.item a.header, .ui.list>.item a.header {
            color: ' . esc_html($text_link_color) . ' !important;
        }
        .ui.list .list>.item a.header:hover, .ui.list>.item a.header:hover {
            color: ' . esc_html($text_link_color) . ' !important;
            opacity: 0.87 !important;
        }
    ';
}

if($preloader_progress_color != '') {
    print '
        .bjax-bar {
            border-color: ' . esc_html($preloader_progress_color) . ' !important;
        }
        .sk-chasing-dots .sk-child, .sk-cube-grid .sk-cube, .sk-double-bounce .sk-child, .sk-fading-circle .sk-circle:before, .sk-folding-cube .sk-cube:before, .sk-spinner-pulse, .sk-rotating-plane, .sk-three-bounce .sk-child, .sk-wandering-cubes .sk-cube, .sk-wave .sk-rect {
            background-color: ' . esc_html($preloader_progress_color) . ' !important;
        }
    ';
}

if($header_menu_color != '') {
    print '
        .header-menu {
            background-color: ' . $header_menu_color . ' !important;
        }
    ';
}

if($header_menu_text_color != '') {
    print '
        .header-menu a, .header-menu .user-menu-label, .header-menu .user-menu i, .header-menu #left-menu-btn i, .menu-home .nav-submenu .item a {
            color: ' . $header_menu_text_color . ' !important;
        }
    ';
}

if($victory_color != '') {
    print '
        .ui.text.victory {
            color: ' . esc_html($victory_color) . ' !important;
        }
        .ui.victory.progress .bar {
            background-color: ' . esc_html($victory_color) . ' !important;
        }
        .ui.victory.success .label {
            color: ' . esc_html($victory_color) . ' !important;
        }
    ';
}

if ($signup_button_color != '' ) {
    print '
        .signup-btn-style, .home-cta-button, signup-btn-modal {
            background-color: ' . esc_html($signup_button_color) . ' !important;
            color: #fff !important;
        }
    ';
}

if($victory_label_color != '') {
    print '
        .victory-label {
            border-color: ' . esc_html($victory_label_color) . ' !important;
        }
    ';
}

if($sign_petition_button_color != '') {
    print '
        #submitSign, #signBtn {
            background-color: ' . esc_html($sign_petition_button_color) . ' !important;
        }
    ';
}

if ($mobile_menu_bg_color != '') {
    print '
        .leftside-menu, .searchBtnMobile input {
            background-color: ' . esc_html($mobile_menu_bg_color) . ' !important;
        }
    ';
}

if ($mobile_menu_text_link_color != '') {
    print '
        .leftside-menu .item, .leftside-menu a, .searchBtnMobile i.icon, .mobile-menu-item .item .title {
            color: ' . esc_html($mobile_menu_text_link_color) . ' !important;
        }
    ';
}

if ($post_overlay_primary_color != '') {
    print '
        .site__wrapper .grid .card .card__overlay--primary {
            background-image: linear-gradient(to bottom, rgba(' . esc_html(conikal_hex_rbg($post_overlay_primary_color, true)) . ', 0.1), rgba(' . esc_html(conikal_hex_rbg($post_overlay_primary_color, true)) . ', 0.8)) !important;
        }
    ';
}

if ($post_overlay_secondary_color != '') {
    print '
        .site__wrapper .grid .card .card__overlay--secondary {
            background-image: linear-gradient(to bottom, rgba(' . esc_html(conikal_hex_rbg($post_overlay_secondary_color, true)) . ', 0.1), rgba(' . esc_html(conikal_hex_rbg($post_overlay_secondary_color, true)) . ', 0.8)) !important;
        }
    ';
}

if($footer_bg_color != '') {
    print '
        .footer {
            background-color: ' . esc_html($footer_bg_color) . ' !important;
        }
    ';
}

if($footer_text_color != '') {
    print '
        .footer .copyright, footer .icon, .footer h3, footer .widget-title {
            color: ' . esc_html($footer_text_color) . ' !important;
        }
        .footer, .footer a {
            color: ' . esc_html($footer_text_color) . ' !important;
        }
        .footer a:hover {
            color: ' . esc_html($footer_text_color) . ' !important;
            opacity: 0.87;
        }
    ';
}

?>