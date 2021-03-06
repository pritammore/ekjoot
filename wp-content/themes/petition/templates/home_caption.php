<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_home_settings = get_option('conikal_home_settings','');
$home_caption_title = isset($conikal_home_settings['conikal_home_caption_title_field']) ? $conikal_home_settings['conikal_home_caption_title_field'] : '';
$home_caption_subtitle = isset($conikal_home_settings['conikal_home_caption_subtitle_field']) ? $conikal_home_settings['conikal_home_caption_subtitle_field'] : '';
$home_caption_cta = isset($conikal_home_settings['conikal_home_caption_cta_field']) ? $conikal_home_settings['conikal_home_caption_cta_field'] : '';
$home_caption_cta_text = isset($conikal_home_settings['conikal_home_caption_cta_text_field']) ? $conikal_home_settings['conikal_home_caption_cta_text_field'] : '';
$home_caption_cta_link = isset($conikal_home_settings['conikal_home_caption_cta_link_field']) ? $conikal_home_settings['conikal_home_caption_cta_link_field'] : '';
$home_caption_cta_text_2 = isset($conikal_home_settings['conikal_home_caption_cta_text_2_field']) ? $conikal_home_settings['conikal_home_caption_cta_text_2_field'] : '';
$home_caption_cta_link_2 = isset($conikal_home_settings['conikal_home_caption_cta_link_2_field']) ? $conikal_home_settings['conikal_home_caption_cta_link_2_field'] : '';
$home_caption_margin_top = isset($conikal_home_settings['conikal_home_caption_top_field']) ? $conikal_home_settings['conikal_home_caption_top_field'] : '225';
$home_caption_cta_size = isset($conikal_home_settings['conikal_home_caption_cta_size_field']) ? $conikal_home_settings['conikal_home_caption_cta_size_field'] : 'medium';
?>
<div class="ui container">
	<div class="home-caption" style="top: <?php echo ($home_caption_margin_top ? esc_attr($home_caption_margin_top) . 'px' : '') ?>">
	    <?php if($home_caption_title && $home_caption_title != '') { ?>
	    	<div class="home-title"><?php echo esc_html($home_caption_title); ?></div>
	    <?php } ?>
	    <?php if($home_caption_subtitle && $home_caption_subtitle != '') { ?>
	    	<div class="home-subtitle"><?php echo esc_html($home_caption_subtitle); ?></div>
	    <?php } ?>
	    <?php if($home_caption_cta && $home_caption_cta_text && $home_caption_cta_link) { ?>
	    	<a href="<?php echo esc_url($home_caption_cta_link); ?>" class="ui<?php echo ($home_caption_cta_size ? ' ' . esc_attr($home_caption_cta_size) : '') ?> button home-cta-button"><?php echo esc_html($home_caption_cta_text); ?></a>
	    <?php } ?>
	    <?php if($home_caption_cta && $home_caption_cta_text_2 && $home_caption_cta_link_2) { ?>
	    	<a href="<?php echo esc_url($home_caption_cta_link_2); ?>" class="ui<?php echo ($home_caption_cta_size ? ' ' . esc_attr($home_caption_cta_size) : '') ?> inverted button"><?php echo esc_html($home_caption_cta_text_2); ?></a>
	    <?php } ?>
	</div>
</div>
<?php if (!wp_is_mobile()) { ?>
<div class="sixteen wide column computer tablet only" style="max-width: 500px; margin: 200px auto; width: 100%;">
    <div class="ui hidden divider"></div>
    <div class="field left"><h3 class="ui header widget-title" style="text-align: center;">Support an Issue. Enter the Unique Issue Code here.</h3></div>
    <!-- <div class="ui hidden divider"></div> -->
    <div class="ui fluid category search petitions-search focus">
        <div class="ui icon fluid input">
          <input class="prompt search-input" type="text" placeholder="<?php esc_html_e('UIC Code / Title / Catergory', 'petition') ?>" style="z-index: 9999;">
          <i class="search link icon"></i>
        </div>
    </div>
    <!-- <div class="ui hidden divider"></div> -->
</div>
<?php } ?>
