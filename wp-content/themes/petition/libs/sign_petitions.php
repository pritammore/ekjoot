<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * FUNTION ADD SIGNATURE PETITION
 */
if( !function_exists('conikal_add_to_signatures') ): 
    function conikal_add_to_signatures() {
        check_ajax_referer('sign_ajax_nonce', 'security');
        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $reason =  isset($_POST['reason']) ? sanitize_text_field($_POST['reason']) : '';
        $notice = isset($_POST['notice']) ? $_POST['notice'] : false;

        $sign_key = 'petition_sign';
        $sign_users_key = 'petition_users';
        $sign = get_user_meta($user_id, $sign_key, true);
        $sign_number = get_post_meta($post_id, $sign_key, true);
        $sign_users = get_post_meta($post_id, $sign_users_key, true);
        $arrUser = array('user_id' => $user_id, 'date' => current_time('mysql'), 'reason' => $reason, 'notice' => $notice);
    
        if($sign == '') {
            $sign = array();
            delete_user_meta($user_id, $sign_key);
            add_user_meta($user_id, $sign_key, $sign);
        }

        if ($sign_users == '') {
            $sign_users = array();
            update_post_meta($post_id, $sign_users_key, $sign_users);
        }

        if(in_array($post_id, $sign) === false) {
            array_push($sign, $post_id);
            $sign_number = intval($sign_number) + 1;
            $sign_users[$user_id] = $arrUser;
            update_user_meta($user_id, $sign_key, $sign);
            update_post_meta($post_id, $sign_key, $sign_number);
            update_post_meta($post_id, $sign_users_key, $sign_users);
        }

        $sign_no = get_post_meta($post_id, $sign_key, true);
        $goal_no = get_post_meta($post_id, 'petition_goal', true);
        $need_no = ($goal_no - $sign_no);
        echo json_encode(array('addsign'=>true, 'number' => $sign_no, 'need' => $need_no, 'sign'=>$sign, 'sign_users' => $sign_users));

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_add_to_signatures', 'conikal_add_to_signatures' );
add_action( 'wp_ajax_conikal_add_to_signatures', 'conikal_add_to_signatures' );

/**
 * FUNTION REMOVE SIGNATURE PETITION
 */
if( !function_exists('conikal_remove_from_signatures') ): 
    function conikal_remove_from_signatures() {
        check_ajax_referer('sign_ajax_nonce', 'security');
        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';

        $sign_key = 'petition_sign';
        $sign_users_key = 'petition_users';
        $sign = get_user_meta($user_id, $sign_key, true);
        $sign_number = get_post_meta($post_id, $sign_key, true);
        $sign_users = get_post_meta($post_id, $sign_users_key, true);

        if(in_array($post_id, $sign)) {
            $sign = array_diff($sign, array($post_id));
            $sign_number = intval($sign_number) - 1;
            unset($sign_users[$user_id]);
            update_user_meta($user_id, $sign_key, $sign);
            update_post_meta($post_id, $sign_key, $sign_number);
            update_post_meta($post_id, $sign_users_key, $sign_users);
        }
        $sign_no = get_post_meta($post_id, $sign_key, true);
        $goal_no = get_post_meta($post_id, 'petition_goal', true);
        $need_no = ($goal_no - $sign_no);
        echo json_encode(array('removesign'=>true, 'number' => $sign_no, 'need' => $need_no, 'sign'=>$sign,  'sign_users' => $sign_users));

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_remove_from_signatures', 'conikal_remove_from_signatures' );
add_action( 'wp_ajax_conikal_remove_from_signatures', 'conikal_remove_from_signatures' );


/**
 * FUNTION ADD SIGN NATURE IN LIBS
 */
if( !function_exists('conikal_add_to_signatures_plus') ): 
    function conikal_add_to_signatures_plus($user_id, $post_id, $reason = '', $notice = true) {

        $sign_key = 'petition_sign';
        $sign_users_key = 'petition_users';
        $sign = get_user_meta($user_id, $sign_key, true);
        $sign_number = get_post_meta($post_id, $sign_key, true);
        $sign_users = get_post_meta($post_id, $sign_users_key, true);
        $arrUser = array('user_id' => $user_id, 'date' => current_time('mysql'), 'reason' => $reason, 'notice' => $notice);
    
        if($sign == '') {
            $sign = array();
            delete_user_meta($user_id, $sign_key);
            add_user_meta($user_id, $sign_key, $sign);
        }

        if ($sign_users == '') {
            $sign_users = array();
            update_post_meta($post_id, $sign_users_key, $sign_users);
        }

        if(in_array($post_id, $sign) === false) {
            array_push($sign, $post_id);
            $sign_number = intval($sign_number) + 1;
            $sign_users[$user_id] = $arrUser;
            update_user_meta($user_id, $sign_key, $sign);
            update_post_meta($post_id, $sign_key, $sign_number);
            update_post_meta($post_id, $sign_users_key, $sign_users);
        }

        return true;

        die();
    }
endif;


/**
 * FUNTION GET PETITION IS SIGNED
 */
if( !function_exists('conikal_signed_petitions') ): 
    function conikal_signed_petitions($user_id) {
        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
        $fav = get_user_meta($user_id, 'petition_sign', true);

        if($fav && $fav != ''){
            global $paged;

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post__in' => $fav,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'post_type' => 'petition',
                'post_status' => 'publish',
                'ignore_sticky_posts' => true
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

            $query = new WP_Query($args);
            wp_reset_query();
            wp_reset_postdata();
            return $query;
        } else {
            return false;
        }
    }
endif;


// LOAD MORE SIGNED PETITIONS

if( !function_exists('conikal_load_signed_petitions') ): 
    function conikal_load_signed_petitions() {
        check_ajax_referer('load_petitions_ajax_nonce', 'security');

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $author_id = isset($_POST['author_id']) ? sanitize_text_field($_POST['author_id']) : 1;
        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 2;
        $fav = get_user_meta($user_id, 'petition_sign', true);

        $args = array(
            'post__in' => $fav,
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_type' => 'petition',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true
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
                $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $avatar) );

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

add_action( 'wp_ajax_nopriv_conikal_load_signed_petitions', 'conikal_load_signed_petitions' );
add_action( 'wp_ajax_conikal_load_signed_petitions', 'conikal_load_signed_petitions' );

?>