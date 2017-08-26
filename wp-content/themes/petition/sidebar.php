<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>
<?php 
	$conikal_appearance_settings = get_option('conikal_appearance_settings');
	$copyright = isset($conikal_appearance_settings['conikal_copyright_field']) ? $conikal_appearance_settings['conikal_copyright_field'] : '';
?>
    <?php dynamic_sidebar('main-widget-area'); ?>
    <div class="ui sticky" id="sign-category">
    	<h3 class="ui dividing header widget-title">
    		<?php _e('Categories', 'petition'); ?>
    	</h3>
        <div class="ui secondary vertical fluid menu category-menu">
            <?php conikal_custom_menu('category'); ?>
        </div>
        <div class="ui divider"></div>
        <div class="ui text small right menu">
	            <?php conikal_custom_menu('footer') ?>
	    </div>
        <?php if($copyright && $copyright != '') { ?>
            <div class="copyright"><?php echo esc_html($copyright) ?></div>
        <?php } ?>
    </div>