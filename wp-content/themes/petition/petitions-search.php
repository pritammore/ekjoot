<?php

/*
Template Name: Petitions Search
*/

/**
 * @package WordPress
 * @subpackage Petition
 */


$conikal_general_settings = get_option('conikal_general_settings','');
$minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

$keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

global $wpdb;
$uic_petitions = $uic_search_Ids = array();
$uic_query_string = "SELECT * 
                    FROM $wpdb->postmeta 
                    WHERE meta_key = 'petition_uic' 
                    AND meta_value LIKE '%$keyword%'";

foreach ($wpdb->get_results( $uic_query_string ) as $key => $row) {
    $uic_search_Ids[] = $row->post_id;
    $uic_petitions[] = get_petition_search_result(get_post($row->post_id));
}

$args = array(
    'post_type' => 'petition',
    'posts_per_page' => -1,
    'post_status' => array('publish'),
    's' => $keyword
);
$args['meta_query'] = array('relation' => 'AND');

if ($minimum_signature != 0) {
    array_push($args['meta_query'], array(
        'key'     => 'petition_sign',
        'value'   => $minimum_signature,
        'type'    => 'NUMERIC',
        'compare' => '>='
    ));
}


$petitions = new WP_Query($args);
wp_reset_query();
wp_reset_postdata();

$arrayPetitions = array();
if($petitions->have_posts()) {
    while ( $petitions->have_posts() ) {
        $proceed = true;
        $petitions->the_post();
        $id = get_the_ID();
        if(!empty($uic_search_Ids)) {
            foreach($uic_search_Ids as $uic_Id)
            {
                if($uic_Id == $id) {
                    $proceed = false;
                    break;
                }
                else {
                    $proceed = true;
                }
            }
        }

        if($proceed)
        {
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id);
            $comments = wp_count_comments($id);
            $comments_fomated = conikal_format_number('%!,0i', $comments->approved, true);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $address = get_post_meta($id, 'petition_address', true);
            $city = get_post_meta($id, 'petition_city', true);
            $state = get_post_meta($id, 'petition_state', true);
            $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
            $zip = get_post_meta($id, 'petition_zip', true);
            $country = get_post_meta($id, 'petition_country', true);
            $lat = get_post_meta($id, 'petition_lat', true);
            $lng = get_post_meta($id, 'petition_lng', true);
            $receiver = get_post_meta($id, 'petition_receiver', true);
            $receiver = explode(',', $receiver);
            $position = get_post_meta($id, 'petition_position', true);
            $position = explode(',', $position);
            $goal = get_post_meta($id, 'petition_goal', true);
            $sign = get_post_meta($id, 'petition_sign', true);
            $sign_fomated = conikal_format_number('%!,0i', $sign);
            $sign_compact = conikal_format_number('%!,0i', $sign, true);
            $updates = get_post_meta($id, 'petition_update', true);
            $thumb = get_post_meta($id, 'petition_thumb', true);
            $thumb = conikal_video_thumbnail($thumb);
            $status = get_post_meta($id, 'petition_status', true);
            $petition_uic = get_post_meta($id, 'petition_uic', true);
            $author_link = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.svg';
            }
            $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );

            if(has_post_thumbnail()) {
                $thumb_id = get_post_thumbnail_id();
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail.svg';
            }

            $arrayPetition = array(
                    'id' => $id, 
                    'link' => $link,
                    'title' => $title,
                    'category_name' => $category[0]->name,
                    'category_link' => get_category_link($category[0]->term_id),
                    'excerpt' => $excerpt,
                    'comments' => $comments->approved,
                    'comments_fomated' => $comments_fomated,
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'neighborhood' => $neighborhood,
                    'zip' => $zip,
                    'country' => $country,
                    'lat' => $lat,
                    'lng' => $lng,
                    'receiver' => $receiver[0],
                    'position' => $position[0],
                    'goal' => $goal,
                    'updates' => $updates,
                    'thumbnail' => $thumbnail,
                    'status' => $status,
                    'author_avatar' => $avatar,
                    'author_name' => get_the_author(),
                    'author_link' => $author_link,
                    'sign' => $sign,
                    'sign_fomated' => $sign_fomated,
                    'sign_compact' => $sign_compact . __(' supporters', 'petition'),
                    'petition_uic' => $petition_uic
                );

            $arrayPetition = (object) $arrayPetition;
            array_push($arrayPetitions, $arrayPetition);
        }
    }
}

if ($uic_petitions) {
    $arrayPetitions = array_merge($arrayPetitions,$uic_petitions);
}

$args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'petitions-search-results.php'
);

$query = new WP_Query($args);

while($query->have_posts()) {
    $query->the_post();
    $page_id = get_the_ID();
    $page_link = get_permalink($page_id) . '?q=' . $keyword;
}
wp_reset_postdata();
wp_reset_query();

if ($arrayPetitions) {
    $found_posts = count($arrayPetitions);
    echo json_encode(array('status' => true, 'total' => $found_posts, 'results' => $arrayPetitions, 'message' => __('Petitions was loaded successfully.', 'petition'), 'action' => array('url' => $page_link, 'text' => __('View ', 'petition') . $found_posts . __(' results for ', 'petition') . '"' . $keyword . '"' ) ));
    exit();
} else {
    echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found petitions.', 'petition')));
    exit();
}

die();

 ?>