<?php

/**
 * @package WordPress
 * @subpackage Petition
 */

include get_template_directory() . '/libs/widgets/contact_widget.php';
include get_template_directory() . '/libs/widgets/social_widget.php';
include get_template_directory() . '/libs/widgets/featured_petitions_widget.php';
include get_template_directory() . '/libs/widgets/recent_petitions_widget.php';
include get_template_directory() . '/libs/widgets/featured_posts_widget.php';
include get_template_directory() . '/libs/widgets/recent_posts_widget.php';
include get_template_directory() . '/libs/widgets/topic_cards_widget.php';

/**
 * Register Petition custom widgets
 */
if( !function_exists('conikal_register_widgets') ): 
    function conikal_register_widgets() {
        register_widget('Contact_Widget');
        register_widget('Social_Widget');
        register_widget('Featured_Petitions_Widget');
        register_widget('Recent_Petitions_Widget');
        register_widget('Featured_Posts_Widget');
        register_widget('Recent_Posts_Widget');
        register_widget('Topic_Cards_Widget');
    }
endif;
add_action( 'widgets_init', 'conikal_register_widgets' );

?>