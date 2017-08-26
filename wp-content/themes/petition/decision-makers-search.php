<?php

/*
Template Name: Decision Maker Search
*/

/**
 * @package WordPress
 * @subpackage Petition
 */


$conikal_general_settings = get_option('conikal_general_settings','');

$keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

$args = array(
    'post_type' => 'decisionmakers',
    'posts_per_page' => -1,
    'post_status' => array('publish'),
    's' => $keyword
);

$decisionmakers = new WP_Query($args);
wp_reset_query();
wp_reset_postdata();

$arrayDecisionmakers = array();
if($decisionmakers->have_posts()) {
    while ( $decisionmakers->have_posts() ) {
        $decisionmakers->the_post();
        $id = get_the_ID();
        $link = get_permalink($id);
        $name = get_the_title($id);
        $title =  wp_get_post_terms($id, 'decisionmakers_title', true);
        $title_name = ($title ? $title[0]->name : '');
        $organization =  wp_get_post_terms($id, 'decisionmakers_organization', true);
        $organization_name = ($organization ? $organization[0]->name : '');
        $excerpt = conikal_get_excerpt_by_id($id);
        $author = get_the_author_meta('ID');

        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
        if($user_avatar != '') {
            $avatar = $user_avatar;
        } else {
            $avatar = get_template_directory_uri().'/images/avatar.svg';
        }
        $avatar = conikal_get_avatar_url( $author, array('size' => 28, 'default' => $avatar) );

        $arrayDecision = array(
                'id' => $id, 
                'link' => $link,
                'name' => $name,
                'title' => $title_name,
                'organization' => $organization_name,
                'description' => $title_name . __(' of ', 'petition') . $organization_name,
                'excerpt' => $excerpt,
                'avatar' => $avatar,
                'author' => $author,
            );

        $arrayDecision = (object) $arrayDecision;
        array_push($arrayDecisionmakers, $arrayDecision);
    }
}

if ($arrayDecisionmakers) {
    echo json_encode(array('status' => true, 'total' => $decisionmakers->found_posts, 'results' => $arrayDecisionmakers, 'message' => __('Petitions was loaded successfully.', 'petition') ));
    exit();
} else {
    echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found petitions.', 'petition')));
    exit();
}

die();

 ?>