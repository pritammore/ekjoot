<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Petition Update notification when new post update for petition
 */
if( !function_exists('conikal_new_update_notification') ): 
    function conikal_new_update_notification($petition_id, $update_id, $user_id, $edit) {
        $user_info = get_userdata($user_id);
        $sign_users = get_post_meta($petition_id, 'petition_users', true);
        $supporters = array();
        foreach ($sign_users as $user) {
            if (isset($user['notice']) && $user['notice'] == true) {
                $user_data = get_userdata($user['user_id']);
                $user_email = $user_data->user_email;
                array_push($supporters, $user_email);
            }
        }
        $petition_title = get_the_title($petition_id);
        $petition_link = get_permalink($petition_id);
        $update_title = get_the_title($update_id);
        $update_link = get_permalink($update_id);

        $message = sprintf( __('A new update on %s:','petition'), esc_html($petition_title) ) . "\r\n\r\n";
        $message .= sprintf( __('Update title: %s','petition'), esc_html($update_title) ) . "\r\n\r\n";
        $message .= sprintf( __('Update link: %s','petition'), esc_html($update_link) ) . "\r\n\r\n";
        $message .= sprintf( __('User: %s','petition'), $user_info->display_name ) . "\r\n";
        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        wp_mail(
            $supporters,
            sprintf(__('[Petition New Update] %s','petition'), esc_html($update_title) ),
            $message,
            $headers
        );
    }
endif;


/**
 * ADD UPDATE PETITION
 */
if( !function_exists('conikal_add_update_petition') ): 
    function conikal_add_update_petition() {
        check_ajax_referer('update_petition_ajax_nonce', 'security');
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $update_id = isset($_POST['update_id']) ? sanitize_text_field($_POST['update_id']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 0;
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'update';
        $media = isset($_POST['media']) ? sanitize_text_field($_POST['media']) : '';
        $petition_id = isset($_POST['petition_id']) ? sanitize_text_field($_POST['petition_id']) : '';
        $gallery = isset($_POST['gallery']) ? sanitize_text_field($_POST['gallery']) : '';
        $video = isset($_POST['video']) ? sanitize_text_field($_POST['video']) : '';
        $thumb = isset($_POST['thumb']) ? sanitize_text_field($_POST['thumb']) : '';
        $attach_id = isset($_POST['attach']) ? sanitize_text_field($_POST['attach']) : '';

        $update_status = 'publish';

        $update_arg = array(
            'post_title' => $title,
            'post_content' => $content,
            'post_type' => 'update',
            'post_status' => $update_status,
            'post_author' => $user_id
        );

        if($update_id != '') {
            $update_arg['ID'] = $update_id;
        }

        if($title == '') {
            echo json_encode(array('status'=>false, 'message'=>__('Title field is mandatory.', 'petition')));
            exit();
        }
        if($content == '') {
            echo json_encode(array('status'=>false, 'message'=>__('Content field is mandatory.', 'petition')));
            exit();
        }
        if($petition_id == '') {
            echo json_encode(array('status'=>false, 'message'=>__('Petition id field is mandatory.', 'petition')));
            exit();
        }
        
        if ($update_id != '') {
            $update = wp_update_post($update_arg);
        } else {
            $update = wp_insert_post($update_arg);
        }

        update_post_meta($petition_id, 'petition_status', $status);

        update_post_meta($update, 'update_post_id', $petition_id);
        update_post_meta($update, 'update_type', $type);
        update_post_meta($update, 'update_media', $media);
        update_post_meta($update, 'update_gallery', $gallery);
        update_post_meta($update, 'update_video', $video);
        update_post_meta($update, 'update_thumb', $thumb);
        set_post_thumbnail( $update, $attach_id );

        $update_link = get_permalink($update);

        conikal_new_update_notification($petition_id, $update, $user_id, $update_id);

        if($update != 0) {
            echo json_encode(array('status' => true, 'ID' => $update, 'link' => $update_link, 'message'=>__('The update was successfully saved.', 'petition')));
            exit();
        } else {
            echo json_encode(array('status'=>false, 'message'=>__('Something went wrong. The update was not saved.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_add_update_petition', 'conikal_add_update_petition' );
add_action( 'wp_ajax_conikal_add_update_petition', 'conikal_add_update_petition' );


/*
** GET UPDATE PETITION
*/

if( !function_exists('conikal_update_petition') ): 
    function conikal_update_petition($post_id) {
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $updates_per_page_setting = isset($conikal_appearance_settings['conikal_updates_per_page_field']) ? $conikal_appearance_settings['conikal_updates_per_page_field'] : '';
        $updates_per_page = $updates_per_page_setting != '' ? $updates_per_page_setting : 5;
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        global $paged;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => $updates_per_page_setting,
            'paged' => $paged,
            'post_type' => 'update',
            'post_status' => 'publish'
        );

        $args['meta_query'] = array('relation' => 'AND');

        if($post_id != '') {
            array_push($args['meta_query'], array(
                'key'     => 'update_post_id',
                'value'   => $post_id,
            ));
        }

        $query = new WP_Query($args);
        wp_reset_postdata();
        wp_reset_query(); 
        return $query;
    }
endif;


/*
** LOAD MORE UPDATE PETITION
*/

if( !function_exists('conikal_load_updates_petition') ): 
    function conikal_load_updates_petition() {
        check_ajax_referer('update_petition_ajax_nonce', 'security');

        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $updates_per_page_setting = isset($conikal_appearance_settings['conikal_updates_per_page_field']) ? $conikal_appearance_settings['conikal_updates_per_page_field'] : '';
        $updates_per_page = $updates_per_page_setting != '' ? $updates_per_page_setting : 5;
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : 5;

        $args = array(
            'posts_per_page' => $updates_per_page_setting,
            'offset' => $offset,
            'post_type' => 'update',
            'post_status' => 'publish'
        );

        $args['meta_query'] = array('relation' => 'AND');

        if($post_id != '') {
            array_push($args['meta_query'], array(
                'key'     => 'update_post_id',
                'value'   => $post_id,
            ));
        }

        $query = new WP_Query($args);
        wp_reset_postdata();
        wp_reset_query();

        $edit_args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'add-update.php'
        );

        $edit_query = new WP_Query($edit_args);

        while($edit_query->have_posts()) {
            $edit_query->the_post();
            $page_id = get_the_ID();
            $page_link = get_permalink($page_id);
        }
        wp_reset_postdata();
        wp_reset_query();

        $updates = array();
        if($query->have_posts()) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $id = get_the_ID();
                $link = get_permalink($id);
                $title = get_the_title($id);
                $excerpt = conikal_get_excerpt_by_id($id);
                $date = human_time_diff(get_the_time('U', $id), current_time('timestamp')) . __(' ago', 'petition');
                $petition_id =  get_post_meta($id, 'update_post_id', true);
                $media =  get_post_meta($id, 'update_media', true);
                $gallery = get_post_meta($id, 'update_gallery', true);
                $images = explode("~~~", $gallery);
                $thumb_video = get_post_meta($id, 'update_thumb', true);
                $comments = wp_count_comments($id);

                if(has_post_thumbnail()) {
                    $thumb_id = get_post_thumbnail_id();
                    $thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
                    $thumbnail = $thumbnail[0];
                } elseif ($gallery) {
                    $thumbnail = $images[1];
                } elseif ($thumb_video) {
                    $thumbnail = $thumb_video;
                } else {
                    $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.png';
                }

                $update = array(
                            'id' => $id, 
                            'link' => $link,
                            'title' => $title, 
                            'excerpt' => $excerpt,
                            'date' => $date, 
                            'petition_id' => $petition_id,
                            'media' => $media,
                            'thumbnail' => $thumbnail,
                            'comments' => $comments->approved,
                            'edit_link' => $page_link . '?edit_id=' . $id
                        );
                array_push($updates, $update);
            }
        }

        if ($updates) {
            echo json_encode( array('status' => true, 'per_page' => $updates_per_page, 'updates' => $updates, 'message' => __('The updates was loaded successfully.', 'petition')) );
            exit();
        } else {
            echo json_encode( array('status' => true, 'per_page' => $updates_per_page, 'updates' => '', 'message' => __('Not found updates.', 'petition')) );
            exit();
        }
        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_load_updates_petition', 'conikal_load_updates_petition' );
add_action( 'wp_ajax_conikal_load_updates_petition', 'conikal_load_updates_petition' );


/**
 * DELETE UPDATE
 */
if( !function_exists('conikal_delete_update') ): 
    function conikal_delete_update() {
        check_ajax_referer('update_petition_ajax_nonce', 'security');

        $del_id = isset($_POST['update_id']) ? sanitize_text_field($_POST['update_id']) : '';

        $del_update = wp_delete_post($del_id);

        if($del_update) {
            echo json_encode(array('delete'=>true, 'message'=>__('The update was successfully deleted.', 'petition')));
            exit();
        } else {
            echo json_encode(array('delete'=>false, 'message'=>__('Something went wrong. The update was not deleted.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_delete_update', 'conikal_delete_update' );
add_action( 'wp_ajax_conikal_delete_update', 'conikal_delete_update' );


?>