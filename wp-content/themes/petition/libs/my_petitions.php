<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

if( !function_exists('conikal_my_petitions') ): 
    function conikal_my_petitions($user_id) {
        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;

        global $paged;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'petition',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_status' => array('publish', 'pending'),
            'author' => $user_id
        );

        $query = new WP_Query($args);
        wp_reset_query();
        wp_reset_postdata();
        return $query;
    }
endif;

// LOAD MORE MY PETITION
if( !function_exists('conikal_load_my_petitions') ): 
    function conikal_load_my_petitions() {
        check_ajax_referer('load_petitions_ajax_nonce', 'security');

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $author_id = isset($_POST['author_id']) ? sanitize_text_field($_POST['author_id']) : 1;
        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 2;

        $args = array(
            'post_type' => 'petition',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_status' => array('publish', 'pending'),
            'author' => $author_id
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
                $petitions->the_post();
                $id = get_the_ID();
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
                        'sign_compact' => $sign_compact
                    );

                $arrayPetition = (object) $arrayPetition;
                array_push($arrayPetitions, $arrayPetition);
            }
        }

        if ($arrayPetitions) {
            echo json_encode(array('status' => true, 'found_posts' => count($arrayPetitions), 'total' => $petitions->found_posts, 'per_page' => $posts_per_page, 'petitions' => $arrayPetitions, 'message' => __('Petitions was loaded successfully.', 'petition')));
            exit();
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found petitions.', 'petition')));
            exit();
        }

        die();
    }
endif;

add_action( 'wp_ajax_nopriv_conikal_load_my_petitions', 'conikal_load_my_petitions' );
add_action( 'wp_ajax_conikal_load_my_petitions', 'conikal_load_my_petitions' );


if( !function_exists('approve_decisionmakers') ): 
    function approve_decisionmakers() {
        // check_ajax_referer('approve_decisionmakers_nonce', 'security');
        $bErrorFound = true;
        $petition_id = isset($_POST['petition_id']) ? sanitize_text_field($_POST['petition_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $current_user_role = get_user_meta( wp_get_current_user()->ID,'user_type',true);

        // Checking for current user if Current user is the Author of petition 
        // OR Leader or decision maker or Admin then only proceed.
        
        global $current_user;
        get_currentuserinfo();
        $post_author_id = get_post_field( 'post_author', $petition_id );

        if($petition_id != '' || $user_id != '') {
            $bErrorFound = false;
        }

        if (($current_user->ID == $post_author_id) || $current_user_role == 'decisioner' || current_user_can('administrator'))  {
            $bErrorFound = false;
        }

        if(!$bErrorFound) :
            $sign_key = 'lp_post_ids';
            if( get_post_meta( $petition_id, $sign_key, true ) !== null ) {
                $value = get_post_meta( $petition_id, $sign_key, true );
            }

            if( $value ) {
                $echo = $value;
                array_push( $echo, $user_id);
            }
            else {
                $echo = array( $user_id );
            }
            update_post_meta( $petition_id, $sign_key, $echo );

            $sign_key = 'lp_approve_decisioners';
            if( get_post_meta( $petition_id, $sign_key, true ) !== null ) {
                $value = get_post_meta( $petition_id, $sign_key, true );
            }

            if( $value ) {
                if(($key = array_search($user_id, $value))!==false)
                {
                    unset($value[$key]);
                    $echo = array_values($value);
                    if(!empty($echo))
                        update_post_meta( $petition_id, 'lp_approve_decisioners', $echo );
                    else
                        delete_post_meta( $petition_id, 'lp_approve_decisioners' );
                }
            }
            else {
                $echo = array( $user_id );
                delete_post_meta( $petition_id, 'lp_approve_decisioners', $echo );
            }
            
            $left_decisionermakers = getAll_decisionmakers($petition_id);
            echo json_encode(array('sent'=>true, 'message' => 'Leader Approved Successfully.', 'new_decisionermakers' => $left_decisionermakers));
        endif;
        die();
    }
endif;
add_action( 'wp_ajax_nopriv_approve_decisionmakers', 'approve_decisionmakers' );
add_action( 'wp_ajax_approve_decisionmakers', 'approve_decisionmakers' );

if( !function_exists('remove_decisionmakers') ): 
    function remove_decisionmakers() {
        // check_ajax_referer('remove_decisionmakers', 'security');
        $bErrorFound = true;
        $petition_id = isset($_POST['petition_id']) ? sanitize_text_field($_POST['petition_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $current_user_role = get_user_meta( wp_get_current_user()->ID,'user_type',true);

        // Checking for current user if Current user is the Author of petition 
        // OR Leader or decision maker or Admin then only proceed.
        
        global $current_user;
        get_currentuserinfo();
        $post_author_id = get_post_field( 'post_author', $petition_id );

        if($petition_id != '' || $user_id != '') {
            $bErrorFound = false;
        }

        if (($current_user->ID == $post_author_id) || $current_user_role == 'decisioner' || current_user_can('administrator'))  {
            $bErrorFound = false;
        }

        if(!$bErrorFound) :
            $sign_key = 'lp_post_ids';
            if( get_post_meta( $petition_id, $sign_key, true ) !== null ) {
                $value = get_post_meta( $petition_id, $sign_key, true );
            }

            if( $value ) {
                if(($key = array_search($user_id, $value))!==false)
                {
                    unset($value[$key]);
                    $echo = array_values($value);
                    if(!empty($echo))
                        update_post_meta( $petition_id, $sign_key, $echo );
                    else
                        delete_post_meta( $petition_id, $sign_key );
                }
            }
            else {
                $echo = array( $user_id );
                delete_post_meta( $petition_id, $sign_key, $echo );
            }

            $sign_key = 'lp_approve_decisioners';
            if( get_post_meta( $petition_id, $sign_key, true ) !== null ) {
                $value = get_post_meta( $petition_id, $sign_key, true );
            }

            if( $value ) {
                if(($key = array_search($user_id, $value))!==false)
                {
                    unset($value[$key]);
                    $echo = array_values($value);
                    if(!empty($echo))
                        update_post_meta( $petition_id, 'lp_approve_decisioners', $echo );
                    else
                        delete_post_meta( $petition_id, 'lp_approve_decisioners' );
                }
            }
            else {
                $echo = array( $user_id );
                delete_post_meta( $petition_id, 'lp_approve_decisioners', $echo );
            }
            echo json_encode(array('sent'=>true, 'message' => 'Leader Removed Successfully.'));
        endif;
        die();
    }
endif;
add_action( 'wp_ajax_nopriv_remove_decisionmakers', 'remove_decisionmakers' );
add_action( 'wp_ajax_remove_decisionmakers', 'remove_decisionmakers' );

if( !function_exists('getAll_decisionmakers') ): 
    function getAll_decisionmakers($petition_id) {
        $final_array = array();
        $approvedleaders = get_post_meta($petition_id, 'lp_post_ids', true );

        if( isset($approvedleaders[0]) ) {
            $i=0;
            foreach ($approvedleaders as $id) {
                if ($id) {

                    $user = get_userdata($id);
                    $final_array[$i]["user_id"] = $user_id = $user->ID;
                    $final_array[$i]["user_name"] = $user->display_name;
                    $user_avatar = $user->avatar;
                    $final_array[$i]["petition_id"] = $petition_id;

                    $user_decisionmakers = get_user_meta($user_id, 'user_decision', true);
                    $decision_title =  wp_get_post_terms($user_decisionmakers, 'decisionmakers_title', true);
                    $final_array[$i]["decision_title"] = ($decision_title ? $decision_title[0]->name : '');
                    $organization =  wp_get_post_terms($user_decisionmakers, 'decisionmakers_organization', true);
                    $final_array[$i]["organization"] = ($organization ? $organization[0]->name : '');
                    $final_array[$i]["author_posts_url"] = get_author_posts_url($user_id);

                    if (!$user_avatar) {
                        $user_avatar = get_template_directory_uri().'/images/avatar.svg';
                    }
                    $final_array[$i]["user_avatar"] = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $user_avatar) );
                }
                $i++;
            }
        }
        return $final_array;
    }
endif;
?>