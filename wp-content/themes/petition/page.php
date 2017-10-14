<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = get_post_meta($post->ID, 'meta_box_sidebar', true);
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
?>
<div class="wrapper read" style="padding-top: 10px">
    <div class="ui container">
        <div class="page content">
            <div class="ui <?php echo ($sidebar_position == 'center' ? 'centered ' : '') ?>grid">
                <?php if($sidebar_position == 'left') { ?>
                <div class="five wide column computer only">
                    <?php get_sidebar('blog'); ?>
                </div>
                <?php } ?>
                <div class="sixteen wide mobile <?php echo ($sidebar_position == 'none' ? 'sixteen ' : 'eleven ') ?>wide computer left aligned column" id="content">
                    <?php if($show_bc != '') {
                        conikal_petition_breadcrumbs();
                    } ?>
                    <?php while(have_posts()) : the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content font medium">
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

                    <?php if(comments_open() || get_comments_number()) {
                        comments_template();
                    }

                    endwhile; ?>
                </div>
                <?php if($sidebar_position == 'right') { ?>
                <div class="five wide column computer only">
                    <?php get_sidebar('blog'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>