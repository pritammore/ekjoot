<?php
/**
 * @package WordPress
 * @subpackage Petition Plugin
 */


/**
 *****************************************************************************
 * Social Meta Tags
 *****************************************************************************
 */

add_action( 'wp_head', 'conikal_social_meta_tags' );
function conikal_social_meta_tags() {
    $conikal_auth_settings = get_option('conikal_auth_settings','');
    $google_login = isset($conikal_auth_settings['conikal_google_login_field']) ? $conikal_auth_settings['conikal_google_login_field'] : false;
    $google_client_id = isset($conikal_auth_settings['conikal_google_id_field']) ? $conikal_auth_settings['conikal_google_id_field'] : false;
    $google_client_secret = isset($conikal_auth_settings['conikal_google_secret_field']) ? $conikal_auth_settings['conikal_google_secret_field'] : false;

    if ($google_login && $google_client_id) {
        print '
            <meta name="google-signin-clientid" content="' . esc_attr($google_client_id) . '" />
            <meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login" />
            <meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
            <meta name="google-signin-cookiepolicy" content="single_host_origin" />
        ';
    }

    if(is_single() && !is_singular('petition') && have_posts()) { 
        $fb_post_id = get_the_ID();
        $fb_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $fb_post_id ), 'single-post-thumbnail' );
        $fb_post_excerpt = conikal_get_excerpt_by_id($fb_post_id);
        $fb_post_title = get_the_title();

        print '
            <meta property="og:url" content="' . get_permalink($fb_post_id) . '" />
            <meta property="og:title" content="' . esc_attr($fb_post_title) . '" />
            <meta property="og:description" content="' . esc_attr($fb_post_excerpt) . '" />
            <meta property="og:image" content="' . ($fb_post_image ? esc_url($fb_post_image[0]) : '') . '" />
        ';
    } else if(is_singular('petition') && have_posts()) {
        $fb_post_id = get_the_ID();
        $fb_post_title = get_the_title();
        $fb_post_excerpt = conikal_get_excerpt_by_id($fb_post_id);
        $fb_gallery = get_post_meta($fb_post_id, 'petition_gallery', true);
        $fb_images = explode("~~~", $fb_gallery);
        $fb_video_thumb = get_post_meta($fb_post_id, 'petition_thumb', true);

        print '
            <meta property="og:url" content="' . get_permalink($fb_post_id) . '" />
            <meta property="og:title" content="' . esc_attr($fb_post_title) . '" />
            <meta property="og:description" content="' . esc_attr($fb_post_excerpt) . '" />
            <meta property="og:image" content="' . (isset($fb_gallery) && count($fb_images) >= 2 ? esc_url($fb_images[1]) : esc_url($fb_video_thumb) ) . '" />
        ';
    } 
}

?>