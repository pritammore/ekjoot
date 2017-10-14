<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;

$cover = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
if ($cover) {
	$cover = $cover[0];
} else {
	$cover = get_template_directory_uri().'/images/cover.svg';
}

?>
	<div id="blog-hero-container" class="masthead">
	    <div class="blog-hero" style="background-image:url(<?php echo esc_url($cover); ?>)"></div>
	    <div class="page-shadown"></div>