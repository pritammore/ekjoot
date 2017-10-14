<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

if( !function_exists('conikal_search_petitions') ): 
    function conikal_search_petitions() {
        $search_key = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
        $search_category = isset($_GET['search_category']) ? sanitize_text_field($_GET['search_category']) : '0';
        $search_topics = isset($_GET['search_topcis']) ? sanitize_text_field($_GET['search_topcis']) : '0';
        $search_country = isset($_GET['search_country']) ? sanitize_text_field($_GET['search_country']) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? sanitize_text_field($_GET['search_neighborhood']) : '';      
        $search_state = isset($_GET['search_state']) ? sanitize_text_field($_GET['search_state']) : '';
        $search_city = isset($_GET['search_city']) ? sanitize_text_field($_GET['search_city']) : '';
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
            'post_status' => 'publish',
            's' => $search_key
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
                'compare' => 'LIKE'
            ));
        }

        if($search_city != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_city',
                'value'   => $search_city,
                'compare' => 'LIKE'
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

if( !function_exists('conikal_get_search_link') ): 
    function conikal_get_search_link() {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'petitions-search-results.php'
        ));

        if($pages) {
            $search_submit = get_permalink($pages[0]->ID);
        } else {
            $search_submit = '';
        }

        return $search_submit;
    }
endif;


//  LOAD MORE SEARCH PETITIONS

if( !function_exists('conikal_load_search_petitions') ): 
    function conikal_load_search_petitions() {
        check_ajax_referer('load_petitions_ajax_nonce', 'security');

        $search_keyword = isset($_POST['search_keyword']) ? sanitize_text_field($_POST['search_keyword']) : '';
        $search_category = isset($_POST['search_category']) ? sanitize_text_field($_POST['search_category']) : '';
        $search_category = ($search_category ? explode(',', $search_category) : '0');
        $search_topics = isset($_POST['search_topics']) ? sanitize_text_field($_POST['search_topics']) : '';
        $search_topics = ($search_topics && $search_topics != ',' ? explode(',', $search_topics) : '0');
        $search_country = isset($_POST['search_country']) ? sanitize_text_field($_POST['search_country']) : '';
        $search_neighborhood = isset($_POST['search_neighborhood']) ? sanitize_text_field($_POST['search_neighborhood']) : '';
        $search_neighborhood = ($search_neighborhood ? explode(',', $search_neighborhood) : '');
        $search_state = isset($_POST['search_state']) ? sanitize_text_field($_POST['search_state']) : '';
        $search_state = ($search_state ? explode(',', $search_state) : '');
        $search_city = isset($_POST['search_city']) ? sanitize_text_field($_POST['search_city']) : '';
        $search_city = ($search_city ? explode(',', $search_city) : '');

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
        $posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
        $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'newest';

        global $paged;

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'petition',
            'post_status' => 'publish',
            's' => $search_keyword
        );

        if($search_category != '0' && $search_topics != '0') {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'term_id',
                    'terms'    => $search_category,
                ),
                array(
                    'taxonomy' => 'petition_topics',
                    'field'    => 'term_id',
                    'terms'    => $search_topics,
                ),
            );
        } else if($search_category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'term_id',
                    'terms'    => $search_category,
                ),
            );
        } else if($search_topics != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_topics',
                    'field'    => 'term_id',
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
                'compare' => 'IN'
            ));
        }

        if($search_city != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_city',
                'value'   => $search_city,
                'compare' => 'IN'
            ));
        }

        if($search_neighborhood != '') {
            array_push($args['meta_query'], array(
                'key'     => 'petition_neighborhood',
                'value'   => $search_neighborhood,
                'compare' => 'IN'
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
                $thumb = ( !wp_is_mobile() ? conikal_video_thumbnail($thumb) : $thumb );
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
add_action( 'wp_ajax_nopriv_conikal_load_search_petitions', 'conikal_load_search_petitions' );
add_action( 'wp_ajax_conikal_load_search_petitions', 'conikal_load_search_petitions' );


?>