<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

if( !function_exists('conikal_trending_petitions') ): 
    function conikal_trending_petitions() {
        $search_country = isset($_GET['search_country']) ? sanitize_text_field($_GET['search_country']) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? sanitize_text_field($_GET['search_neighborhood']) : '';      
        $search_state = isset($_GET['search_state']) ? sanitize_text_field($_GET['search_state']) : '';
        $search_city = isset($_GET['search_city']) ? sanitize_text_field($_GET['search_city']) : '';
        $search_category = isset($_GET['search_category']) ? sanitize_text_field($_GET['search_category']) : '0';
        $search_topics = isset($_GET['search_topcis']) ? sanitize_text_field($_GET['search_topcis']) : '0';
        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        global $paged;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_type' => 'petition',
            'post_status' => 'publish'
        );

        if($search_category != '0' && $search_topics != '0') {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $search_category,
                ),
                array(
                    'taxonomy' => 'petition_topics_category',
                    'field'    => 'id',
                    'terms'    => $search_topics,
                ),
            );
        } else if($search_category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $search_category,
                ),
            );
        } else if($search_topics != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_topics_category',
                    'field'    => 'id',
                    'terms'    => $search_topics,
                ),
            );
        }

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }

        if($search_country != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_country',
                'value'   => $search_country,
            ));
        }

        if($search_state != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_state',
                'value'   => $search_state,
            ));
        }

        if($search_city != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_city',
                'value'   => $search_city,
            ));
        }

        if($search_neighborhood != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_neighborhood',
                'value'   => $search_neighborhood,
                'compare' => 'LIKE'
            ));
        }

        $query = new WP_Query($args);
        wp_reset_postdata();
        return $query;
    }
endif;


//  LOAD MORE SEARCH PETITIONS

if( !function_exists('conikal_load_trending_petitions') ): 
    function conikal_load_trending_petitions() {
        check_ajax_referer('load_petitions_ajax_nonce', 'security');

        $search_country = isset($_GET['search_country']) ? sanitize_text_field($_GET['search_country']) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? sanitize_text_field($_GET['search_neighborhood']) : '';      
        $search_state = isset($_GET['search_state']) ? sanitize_text_field($_GET['search_state']) : '';
        $search_city = isset($_GET['search_city']) ? sanitize_text_field($_GET['search_city']) : '';
        $search_category = isset($_GET['search_category']) ? sanitize_text_field($_GET['search_category']) : '0';
        $search_topics = isset($_GET['search_topcis']) ? sanitize_text_field($_GET['search_topcis']) : '0';

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $days_trending = isset($conikal_general_settings['conikal_number_days_trending_field']) ? $conikal_general_settings['conikal_number_days_trending_field'] : 10;

        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        global $paged;

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $author_id = isset($_POST['author_id']) ? sanitize_text_field($_POST['author_id']) : 1;
        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1;

        $args = array(
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_type' => 'petition',
            'post_status' => 'publish'
        );

        if($search_category != '0' && $search_topics != '0') {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $search_category,
                ),
                array(
                    'taxonomy' => 'petition_topics_category',
                    'field'    => 'id',
                    'terms'    => $search_topics,
                ),
            );
        } else if($search_category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $search_category,
                ),
            );
        } else if($search_topics != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_topics_category',
                    'field'    => 'id',
                    'terms'    => $search_topics,
                ),
            );
        }

        $args['meta_query'] = array('relation' => 'AND');

        if ($minimum_signature != 0) {
            array_push($args['meta_query'], array(
                'key'     => 'petition_sign',
                'value'   => $minimum_signature,
                'type'    => 'NUMERIC',
                'compare' => '>='
            ));
        }

        if($search_country != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_country',
                'value'   => $search_country,
            ));
        }

        if($search_state != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_state',
                'value'   => $search_state,
            ));
        }

        if($search_city != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_city',
                'value'   => $search_city,
            ));
        }

        if($search_neighborhood != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_neighborhood',
                'value'   => $search_neighborhood,
                'compare' => 'LIKE'
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
                $post_date = get_the_date('Y-m-d', $id);
                $category =  wp_get_post_terms($id, 'petition_category', true);
                $excerpt = conikal_get_excerpt_by_id($id);
                $comments = wp_count_comments($id);
                $comments_fomated = conikal_format_number('%!,0i', $comments->approved, true);
                $view = conikal_format_number('%!,0i', (int) conikal_get_post_views($id), true);
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

                $date = current_time('mysql');
                $date = strtotime($date);
                $arrDate = array();
                for ($i=0; $i <= $days_trending; $i++) { 
                    $date = strtotime('-'.$i.' day', $date);
                    array_push($arrDate, date('m/d', $date));
                    $date = current_time('mysql');
                    $date = strtotime($date);
                }

                $sign_users = get_post_meta($id, 'petition_users', true);
                $usrDate = array();
                foreach ($sign_users as $user) {
                    $user_date = $date = strtotime($user['date']);
                    $user_date = date('m/d', $user_date);
                    array_push($usrDate, $user_date);
                }
                
                $usrDate = array_count_values($usrDate);
                $totalData = array();
                foreach ($usrDate as $sign_date => $sign_count) {
                    if ( in_array($sign_date, $arrDate) ) {
                        $totalData[$sign_date] = $sign_count;
                    }
                }
                foreach ($arrDate as $date) {
                    if ( array_key_exists($date, $totalData) ) {
                        
                    } else {
                        $totalData[$date] = 0;
                    }
                }
                ksort($totalData);
                $trending = 0;
                foreach ($totalData as $date => $sign) {
                    $trending = $trending + $sign;
                }

                $arrayPetition = array(
                        'id' => $id, 
                        'link' => $link,
                        'title' => $title,
                        'date' => $post_date,
                        'category_name' => $category[0]->name,
                        'category_link' => get_category_link($category[0]->term_id),
                        'excerpt' => $excerpt,
                        'comments' => $comments->approved,
                        'comments_fomated' => $comments_fomated,
                        'view' => $view,
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
                        'sign_compact' => $sign_compact,
                        'trending' => $trending
                    );

                $arrayPetition = (object) $arrayPetition;
                array_push($arrayPetitions, $arrayPetition);
            }
        }

        if ($arrayPetitions) {
            foreach($arrayPetitions as $meta => $value) {
                $sort_trending[] = $value->trending;
                $sort_date[] = $value->date;
            }
            array_multisort($sort_trending, SORT_DESC, $sort_date, SORT_DESC, $arrayPetitions);

            echo json_encode(array('status' => true, 'found_posts' => count($arrayPetitions), 'total' => $petitions->found_posts, 'per_page' => $posts_per_page, 'petitions' => $arrayPetitions, 'message' => __('Petitions was loaded successfully.', 'petition')));
            exit();
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found petitions.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_load_trending_petitions', 'conikal_load_trending_petitions' );
add_action( 'wp_ajax_conikal_load_trending_petitions', 'conikal_load_trending_petitions' );


?>