<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_typography_settings = get_option('conikal_typography_settings');
$body_font_family 	= isset($conikal_typography_settings['conikal_typography_body_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_body_font_field']) : '';
$body_font_weight 	= isset($conikal_typography_settings['conikal_typography_body_weight_field']) ? $conikal_typography_settings['conikal_typography_body_weight_field'] : '';
$body_font_line 	= isset($conikal_typography_settings['conikal_typography_body_line_field']) ? $conikal_typography_settings['conikal_typography_body_line_field'] : '';
$body_font_size 	= isset($conikal_typography_settings['conikal_typography_body_size_field']) ? $conikal_typography_settings['conikal_typography_body_size_field'] : '';

$home_heading_font_family 	= isset($conikal_typography_settings['conikal_typography_home_heading_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_home_heading_font_field']) : '';
$home_heading_font_weight 	= isset($conikal_typography_settings['conikal_typography_home_heading_weight_field']) ? $conikal_typography_settings['conikal_typography_home_heading_weight_field'] : '';
$home_heading_font_line 	= isset($conikal_typography_settings['conikal_typography_home_heading_line_field']) ? $conikal_typography_settings['conikal_typography_home_heading_line_field'] : '';
$home_heading_font_size 	= isset($conikal_typography_settings['conikal_typography_home_heading_size_field']) ? $conikal_typography_settings['conikal_typography_home_heading_size_field'] : '';

$home_subheading_font_family 	= isset($conikal_typography_settings['conikal_typography_home_subheading_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_home_subheading_font_field']) : '';
$home_subheading_font_weight 	= isset($conikal_typography_settings['conikal_typography_home_subheading_weight_field']) ? $conikal_typography_settings['conikal_typography_home_subheading_weight_field'] : '';
$home_subheading_font_line 	= isset($conikal_typography_settings['conikal_typography_home_subheading_line_field']) ? $conikal_typography_settings['conikal_typography_home_subheading_line_field'] : '';
$home_subheading_font_size 	= isset($conikal_typography_settings['conikal_typography_home_subheading_size_field']) ? $conikal_typography_settings['conikal_typography_home_subheading_size_field'] : '';

$heading_font_family 	= isset($conikal_typography_settings['conikal_typography_heading_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_heading_font_field']) : '';
$heading_font_weight 	= isset($conikal_typography_settings['conikal_typography_heading_weight_field']) ? $conikal_typography_settings['conikal_typography_heading_weight_field'] : '';
$heading_font_line 	= isset($conikal_typography_settings['conikal_typography_heading_line_field']) ? $conikal_typography_settings['conikal_typography_heading_line_field'] : '';
$heading_font_size 	= isset($conikal_typography_settings['conikal_typography_heading_size_field']) ? $conikal_typography_settings['conikal_typography_heading_size_field'] : '';

$page_heading_font_family 	= isset($conikal_typography_settings['conikal_typography_page_heading_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_page_heading_font_field']) : '';
$page_heading_font_weight 	= isset($conikal_typography_settings['conikal_typography_page_heading_weight_field']) ? $conikal_typography_settings['conikal_typography_page_heading_weight_field'] : '';
$page_heading_font_line 	= isset($conikal_typography_settings['conikal_typography_page_heading_line_field']) ? $conikal_typography_settings['conikal_typography_page_heading_line_field'] : '';
$page_heading_font_size 	= isset($conikal_typography_settings['conikal_typography_page_heading_size_field']) ? $conikal_typography_settings['conikal_typography_page_heading_size_field'] : '';

$widget_title_font_family 	= isset($conikal_typography_settings['conikal_typography_widget_title_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_widget_title_font_field']) : '';
$widget_title_font_weight 	= isset($conikal_typography_settings['conikal_typography_widget_title_weight_field']) ? $conikal_typography_settings['conikal_typography_widget_title_weight_field'] : '';
$widget_title_font_line 	= isset($conikal_typography_settings['conikal_typography_widget_title_line_field']) ? $conikal_typography_settings['conikal_typography_widget_title_line_field'] : '';
$widget_title_font_size 	= isset($conikal_typography_settings['conikal_typography_widget_title_size_field']) ? $conikal_typography_settings['conikal_typography_widget_title_size_field'] : '';

$posts_title_font_family 	= isset($conikal_typography_settings['conikal_typography_title_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_title_font_field']) : '';
$posts_title_font_weight 	= isset($conikal_typography_settings['conikal_typography_title_weight_field']) ? $conikal_typography_settings['conikal_typography_title_weight_field'] : '';
$posts_title_font_line 	= isset($conikal_typography_settings['conikal_typography_title_line_field']) ? $conikal_typography_settings['conikal_typography_title_line_field'] : '';
$posts_title_font_size 	= isset($conikal_typography_settings['conikal_typography_title_size_field']) ? $conikal_typography_settings['conikal_typography_title_size_field'] : '';

$content_font_family 	= isset($conikal_typography_settings['conikal_typography_content_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_content_font_field']) : '';
$content_font_weight 	= isset($conikal_typography_settings['conikal_typography_content_weight_field']) ? $conikal_typography_settings['conikal_typography_content_weight_field'] : '';
$content_font_line 	= isset($conikal_typography_settings['conikal_typography_content_line_field']) ? $conikal_typography_settings['conikal_typography_content_line_field'] : '';
$content_font_size 	= isset($conikal_typography_settings['conikal_typography_content_size_field']) ? $conikal_typography_settings['conikal_typography_content_size_field'] : '';

$button_font_family 	= isset($conikal_typography_settings['conikal_typography_button_font_field']) ? explode(",", $conikal_typography_settings['conikal_typography_button_font_field']) : '';
$button_font_weight 	= isset($conikal_typography_settings['conikal_typography_button_weight_field']) ? $conikal_typography_settings['conikal_typography_button_weight_field'] : '';
$button_font_line 	= isset($conikal_typography_settings['conikal_typography_button_line_field']) ? $conikal_typography_settings['conikal_typography_button_line_field'] : '';
$button_font_size 	= isset($conikal_typography_settings['conikal_typography_button_size_field']) ? $conikal_typography_settings['conikal_typography_button_size_field'] : '';


if ($body_font_family != '') {
	print '
		body {font-family: ' . $body_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $body_font_family[1] . ' !important;font-weight: ' . $body_font_weight . ';line-height: ' . $body_font_line . 'px;font-size: ' . $body_font_size . 'px;}
		p {font-family: ' . $body_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $body_font_family[1] . ' !important;}
		.ui.menu, .ui.inline.dropdown>.text {font-family: ' . $body_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $body_font_family[1] . ' !important;font-weight: ' . $body_font_weight . ';
		}
	';
}

if ($home_heading_font_family != '') {
	print '.home-title {font-family: ' . $home_heading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $home_heading_font_family[1] . ' !important;font-weight: ' . $home_heading_font_weight . ';line-height: ' . $home_heading_font_line . 'px;font-size: ' . $home_heading_font_size . 'px;}';
}

if ($home_subheading_font_family != '') {
	print '.home-subtitle {font-family: ' . $home_subheading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $home_subheading_font_family[1] . ' !important;font-weight: ' . $home_subheading_font_weight . ';line-height: ' . $home_subheading_font_line . 'px;font-size: ' . $home_subheading_font_size . 'px;}';
}

if ($heading_font_family != '') {
	print '.ui.header {font-family: ' . $heading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $heading_font_family[1] . ' !important;font-weight: ' . $heading_font_weight . ';line-height: ' . $heading_font_line . 'px;font-size: ' . $heading_font_size . 'px;}
		h1, h2, h3, h4, h5 {font-family: ' . $heading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $heading_font_family[1] . ' !important;}
		.ui.steps .step .title, .give-goal-progress .income, .give-goal-progress .raised {font-family: ' . $heading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $heading_font_family[1] . ' !important;font-weight: bold;}
	';
}

if ($page_heading_font_family != '') {
	print '.petition-title .content, .page-title, .post-title, .profile-title {font-family: ' . $page_heading_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $page_heading_font_family[1] . ' !important;font-weight: ' . $page_heading_font_weight . ' !important;line-height: ' . $page_heading_font_line . 'px !important;font-size: ' . $page_heading_font_size . 'px !important;}';
}

if ($widget_title_font_family != '') {
	print '.widget-title {font-family: ' . $widget_title_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $widget_title_font_family[1] . ' !important;font-weight: ' . $widget_title_font_weight . ' !important;line-height: ' . $widget_title_font_line . 'px !important;font-size: ' . $widget_title_font_size . 'px !important;}';
}

if ($posts_title_font_family != '') {
	print '.list-petition-title, .victory-title {font-family: ' . $posts_title_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $posts_title_font_family[1] . ' !important;font-weight: ' . $posts_title_font_weight . ' !important;line-height: ' . $posts_title_font_line . 'px !important;font-size: ' . $posts_title_font_size . 'px !important;}
		.card-post-title, .card-petition-title {font-family: ' . $posts_title_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $posts_title_font_family[1] . ' !important;font-weight: ' . $posts_title_font_weight . ' !important;line-height: ' . ($posts_title_font_line - 2) . 'px !important;font-size: ' . ($posts_title_font_size - 2) . 'px !important;}';
}

if ($content_font_family != '') {
	print '.entry-content {font-family: ' . $content_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $content_font_family[1] . ' !important;font-weight: ' . $content_font_weight . ' !important;line-height: ' . $content_font_line . 'px !important;font-size: ' . $content_font_size . 'px !important;}
		.entry-content p {font-family: ' . $content_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $content_font_family[1] . ' !important;line-height: ' . $content_font_line . 'px !important;}
		.entry-content strong {font-family: ' . $content_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $content_font_family[1] . ' !important;font-weight: bold !important;}';
}

if ($button_font_family != '') {
	print 'button, .ui.button, .ui.label {font-family: ' . $button_font_family[0] . ', "Helvetica Neue", Helvetica, ' . $button_font_family[1] . ' !important;font-weight: ' . $button_font_weight . ';}';
}

?>