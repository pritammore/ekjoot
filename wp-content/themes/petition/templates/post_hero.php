<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$post_title = get_the_title($post->ID);
$post_date = get_the_date();
$post_category = get_the_category();
$prev_post = get_previous_post();
$next_post = get_next_post(); ?>

    <?php if($post) {
        $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        if ($post_image) {
            $post_image = $post_image[0];
        } else {
            $post_image = get_template_directory_uri().'/images/cover.svg';
        }
    } else {
        $post_image = get_template_directory_uri().'/images/cover.svg';
    } ?>
    <div id="page-hero-container" class="masthead">
        <div class="page-hero" style="background-image:url(<?php echo esc_url($post_image); ?>)"></div>
        <div class="post-shadown"></div>
        <div class="page-caption">
            <div class="ui container">
                <div class="post-title"><?php echo esc_html($post_title) ?></div>
            </div>
        </div>