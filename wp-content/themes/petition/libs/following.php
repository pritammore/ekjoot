<?php

/**
 * @package WordPress
 * @subpackage Petition
 */
 
/**
 * FOLLOW USER FUNCTION
 */
if( !function_exists('conikal_follow_user') ): 
    function conikal_follow_user() {
        check_ajax_referer('follow_ajax_nonce', 'security');
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $follow_id = isset($_POST['follow_id']) ? sanitize_text_field($_POST['follow_id']) : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

        $follow_key = 'follow_user';
        $follow_user = get_user_meta($user_id, $follow_key, true);
    
        if ($type === 'follow') {
            if($follow_user == '') {
                $follow_user = array();
                delete_user_meta($user_id, $follow_key);
                add_user_meta($user_id, $follow_key, $follow_user);
            }
            if(in_array($follow_id, $follow_user) === false) {
                array_push($follow_user, $follow_id);
                update_user_meta($user_id, $follow_key, $follow_user);
            }
        } else {
            if(in_array($follow_id, $follow_user)) {
                $follow_user = array_diff($follow_user, array($follow_id));
                update_user_meta($user_id, $follow_key, $follow_user);
            }
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_follow_user', 'conikal_follow_user' );
add_action( 'wp_ajax_conikal_follow_user', 'conikal_follow_user' );


/**
 * FOLLOW TOPIC FUNCTION
 */
if( !function_exists('conikal_follow_topic') ): 
    function conikal_follow_topic() {
        check_ajax_referer('follow_ajax_nonce', 'security');
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $topic_id = isset($_POST['topic_id']) ? sanitize_text_field($_POST['topic_id']) : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

        $follow_key = 'follow_topics';
        $follow_topics = get_user_meta($user_id, $follow_key, true);
    
        if ($type === 'follow') {
            if($follow_topics == '') {
                $follow_topics = array();
                delete_user_meta($user_id, $follow_key);
                add_user_meta($user_id, $follow_key, $follow_topics);
            }
            if(in_array($topic_id, $follow_topics) === false) {
                array_push($follow_topics, $topic_id);
                update_user_meta($user_id, $follow_key, $follow_topics);
            }
        } else {
            if(in_array($topic_id, $follow_topics)) {
                $follow_topics = array_diff($follow_topics, array($topic_id));
                update_user_meta($user_id, $follow_key, $follow_topics);
            }
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_follow_topic', 'conikal_follow_topic' );
add_action( 'wp_ajax_conikal_follow_topic', 'conikal_follow_topic' );


?>