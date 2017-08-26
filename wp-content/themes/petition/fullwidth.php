<?php
/*
Template Name: Fullwidth
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
?>
    <div id="fullwidth">
        <?php while(have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div id="content">
                    <?php the_content(); ?>
                    <div class="clearfix"></div>
                    <?php wp_link_pages( array(
                        'before'      => '<div class="page-links">',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                        'pagelink'    => '%',
                        'separator'   => '',
                    ) ); ?>
                </div>
            </div>
        <?php if(comments_open() && !is_front_page()) {
            comments_template();
        }
        endwhile; ?>
    </div>

<?php get_footer(); ?>