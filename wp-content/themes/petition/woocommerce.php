<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
?>
<div id="wrapper">
    <div class="ui container">
        <div class="page content">
            <?php if($show_bc != '') {
            	$args = array(
            			'wrap_before ' => '<div class="ui breadcrumb">',
            			'wrap_after ' => '</div>',
						'delimiter' => '<i class="right angle icon divider"></i>',
						'before' => '<a class="section">',
						'after' => '</a>',
						'home' => '<a class="section" href="' . esc_url( home_url() ) . '" data-bjax><i class="home icon"></i>' . __('Home','petition') . '</a>'
				);
                woocommerce_breadcrumb( $args );
            } ?>
            <?php woocommerce_content(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>