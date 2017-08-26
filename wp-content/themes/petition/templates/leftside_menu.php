<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


$conikal_appearance_settings = get_option('conikal_appearance_settings');
$copyright = isset($conikal_appearance_settings['conikal_copyright_field']) ? $conikal_appearance_settings['conikal_copyright_field'] : '';
?>

<div class="ui left vertical menu sidebar leftside-menu" id="leftside-menu">
    <div class="item searchBtnMobile">
        <div class="ui search">
            <div class="ui icon fluid input">
              <input class="prompt" type="text" placeholder="<?php esc_html_e('Search...', 'petition') ?>">
              <i class="search icon"></i>
            </div>
        </div>
    </div>
    <?php conikal_custom_menu_mobile('category') ?>
    <div class="item" style="padding: 20px 0"></div>
    <?php conikal_custom_menu_mobile('primary') ?>
    <div class="item">
        <?php if($copyright && $copyright != '') { ?>
            <div class="copyright"><?php echo esc_html($copyright) ?></div>
        <?php } ?>
    </div>
</div>