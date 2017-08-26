<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_home_settings = get_option('conikal_home_settings','');
$home_header = isset($conikal_home_settings['conikal_home_header_field']) ? $conikal_home_settings['conikal_home_header_field'] : '';
$home_header_video = isset($conikal_home_settings['conikal_home_header_video_field']) ? $conikal_home_settings['conikal_home_header_video_field'] : ''; 
$home_header_video_sound = isset($conikal_home_settings['conikal_home_header_video_sound_field']) ? $conikal_home_settings['conikal_home_header_video_sound_field'] : ''; 
$home_header_hide_logined = isset($conikal_home_settings['conikal_home_header_hide_logined_field']) ? $conikal_home_settings['conikal_home_header_hide_logined_field'] : ''; 
$home_victory = isset($conikal_home_settings['conikal_home_victory_field']) ? $conikal_home_settings['conikal_home_victory_field'] : '';
$home_victory_hide_logined = isset($conikal_home_settings['conikal_home_victory_hide_logined_field']) ? $conikal_home_settings['conikal_home_victory_hide_logined_field'] : '';
$home_header_hight = isset($conikal_home_settings['conikal_hight_slideshow_field']) ? $conikal_home_settings['conikal_hight_slideshow_field'] : '675';

// victory class
$victory_hide_class = '-feature';
if($home_victory && ($home_header != 'none') && ($home_victory_hide_logined != '')) {
    if (!is_user_logged_in()) {
        $victory_hide_class = '';
    }
} else if ($home_victory && ($home_header === 'none')) {
    $victory_hide_class = '';
} else {
    $victory_hide_class = '';
}

// home header class
$home_header_class = 'none-hero-container';
$home_header_masthead = 'none-masthead';
$hight_slideshow = '';
if ( ($home_header != 'none') && ($home_header_hide_logined != '') ) {
    if (!is_user_logged_in()) {
        $home_header_class = 'hero-container';
        $home_header_masthead = 'masthead';
        $hight_slideshow = $home_header_hight . 'px';
    }
} else if ($home_header != 'none') {
    $home_header_class = 'hero-container';
    $home_header_masthead = 'masthead';
    $hight_slideshow = $home_header_hight . 'px';
}
?>

<div id="<?php echo esc_attr($home_header_class) . esc_attr($victory_hide_class) ?>" class="<?php echo esc_attr($home_header_masthead) ?>" style="height: <?php echo ($hight_slideshow ? esc_attr($hight_slideshow) : '') ?>">
    <?php if($home_header == 'slideshow') { ?>
        <?php if ($home_header_hide_logined != '') { 
            if (!is_user_logged_in()) { ?>
                <div id="slideshow" style="height: <?php echo ($home_header != 'none' && $hight_slideshow ? esc_attr($hight_slideshow) . 'px' : '') ?>">
                    <?php 
                        $images = conikal_get_slideshow_images();
                        foreach ($images as $image) {
                            echo '<div style="background-image: url(' . esc_url($image) . ')"></div>';
                        }
                    ?>
                </div>
                <div class="slideshowShadow"></div>
            <?php } else { ?>
                <div class="none-slideshow"></div>
            <?php }
        } else { ?>
            <div id="slideshow" style="height: <?php echo ($home_header != 'none' && $hight_slideshow ? esc_attr($hight_slideshow) . 'px' : '') ?>">
                <?php 
                    $images = conikal_get_slideshow_images();
                    foreach ($images as $image) {
                        echo '<div style="background-image: url(' . esc_url($image) . ')"></div>';
                    }
                ?>
            </div>
            <div class="slideshowShadow"></div>
        <?php } ?>
    <?php } else if($home_header == 'video') { ?>
         <?php if ($home_header_hide_logined != '') { 
            if (!is_user_logged_in()) { ?>
                <video autoplay id="bgvid" loop <?php ($home_header_video_sound != '' ? '' : 'muted') ?>>
                    <source src="<?php echo esc_url($home_header_video); ?>" type="video/mp4">
                </video>
                <div class="slideshowShadow"></div>
            <?php } else { ?>
                <div class="none-slideshow"></div>
            <?php }
        } else { ?>
            <video autoplay id="bgvid" loop <?php ($home_header_video_sound != '' ? '' : 'muted') ?>>
                <source src="<?php echo esc_url($home_header_video); ?>" type="video/mp4">
            </video>
            <div class="slideshowShadow"></div>
        <?php } ?>
    <?php } else { ?>
        <div class="none-slideshow"></div>
    <?php }
?>