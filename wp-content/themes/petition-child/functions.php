<?php
/**
 * Petiton child theme.
 */
function conikal_petition_child_styles() {
    wp_enqueue_style( 'conikal-petition-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'conikal_petition_child_styles', 999 );

/** Place any new code below this line */