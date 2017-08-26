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
    <?php dynamic_sidebar('blog-widget-area'); ?>