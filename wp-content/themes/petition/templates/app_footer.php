<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_appearance_settings = get_option('conikal_appearance_settings');
$copyright = isset($conikal_appearance_settings['conikal_copyright_field']) ? $conikal_appearance_settings['conikal_copyright_field'] : '';
?>

<footer>
    <div class="ui inverted vertical segment footer">
        <div class="ui container">
            <div class="ui stackable inverted very padded grid tablet computer only">
                <?php get_sidebar('footer'); ?>
            </div>
            <div class="ui inverted text small right menu">
                <div class="item">
                    <?php if($copyright && $copyright != '') { ?>
                        <div class="copyright"><?php echo esc_html($copyright) ?></div>
                    <?php } ?>
                </div>
                <div class="ui inverted text small right menu">
                    <div class="ui grid tablet computer only">
                        <?php conikal_custom_menu('footer') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>