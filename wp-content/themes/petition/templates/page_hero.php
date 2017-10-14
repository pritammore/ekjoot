<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
$current_user = wp_get_current_user();

if ((is_author() || is_page_template('my-petitions.php')) && is_user_logged_in()) {
	if (is_author()) {
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
	} else {
		$curauth = wp_get_current_user();
	}

	$user_cover = get_user_meta($curauth->ID, 'user_cover', true);

	if ($user_cover) {
		$cover = $user_cover;
	} else {
		if($post) {
		    $cover = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
		    if ($cover) {
		    	$cover = $cover[0];
		    } else {
		    	$cover = get_template_directory_uri().'/images/cover.svg';
		    }
		} else {
		    $cover = get_template_directory_uri().'/images/cover.svg';
		} 
	}
} else if ( is_tax('petition_category') || is_tax('petition_topics') ) { 
	$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
	if ($term->count) {
		$cover = get_term_meta($term->term_id, 'petition_category_image', true);
		if (!$cover) {
			$cover = get_term_meta($term->term_id, 'petition_topics_image', true);
		}
		if(!$cover) {
		    $cover = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
		    if ($cover) {
		    	$cover = $cover[0];
		    } else {
		    	$cover = get_template_directory_uri().'/images/cover.svg';
		    }
		}
	} else {
		$cover = get_template_directory_uri().'/images/cover.svg';
	}
} else {
	if($post) {
	    $cover = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	    if ($cover) {
	    	$cover = $cover[0];
	    } else {
	    	$cover = get_template_directory_uri().'/images/cover.svg';
	    }
	} else {
	    $cover = get_template_directory_uri().'/images/cover.svg';
	} 
} ?>
	<div id="page-hero-container" class="masthead">
	    <div class="page-hero" style="background-image:url(<?php echo esc_url($cover); ?>)"></div>
	    <div class="page-shadown"></div>