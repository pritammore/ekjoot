<?php
/**
 * @package WordPress
 * @subpackage Petition
 */



// FUNTION GET CLIENT IP ADDRESS
function conikal_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


/**
 * ADD COMMENT AND SIGN PETITION FUNTION
 */
if( !function_exists('conikal_add_comments') ): 
    function conikal_add_comments() {
        check_ajax_referer('comment_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $ip_address = conikal_get_client_ip();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $parent = isset($_POST['parent']) ? sanitize_text_field($_POST['parent']) : 0;
        $author  = get_userdata( $user_id );

        if ($content == '') {
            echo json_encode(array('save' => false, 'message' => __('Comment content is required!', 'petition')));
            exit();
        }

        $time = current_time('mysql');

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $author->user_login,
            'comment_author_email' => $author->user_email,
            'comment_author_url' => $author->user_url,
            'comment_content' => $content,
            'comment_type' => '',
            'comment_parent' => $parent,
            'user_id' => $user_id,
            'comment_author_IP' => $ip_address,
            'comment_agent' => $agent,
            'comment_date' => $time,
            'comment_approved' => 1,
        );

        $comment_id = wp_insert_comment($comment_data);
        $details = get_comment($comment_id);

        $author_avatar = get_user_meta($details->user_id, 'avatar', true);
        $author_name   = get_userdata($details->user_id);
        $author_name   = $author_name->display_name;
        
        if (!$author_name) {
            $author_name = $details->comment_author;
            $details->comment_author_name = $author_name;
        }
        if (!$author_avatar) {
            $author_avatar = get_template_directory_uri().'/images/avatar.svg';
            $details->comment_author_avatar = $author_avatar;
        }
        $author_avatar = conikal_get_avatar_url( $author->ID, array('size' => 35, 'default' => $author_avatar) );
        
        $details->comment_author_name = $author_name;
        $details->comment_author_avatar = $author_avatar;
        if ($comment_id != 0) {
            echo json_encode(array('save' => true, 'id' => $comment_id, 'time' => __(' just now', 'petition'), 'details' => $details, 'message' => __('The comment was successfuly saved', 'petition')));
            exit();
        } else {
            echo json_encode(array('save' => false, 'message' => __('Something went wrong. The comment was not saved.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_add_comments', 'conikal_add_comments' );
add_action( 'wp_ajax_conikal_add_comments', 'conikal_add_comments' );


/**
 * UPVOTE COMMENT PETITION
 */
if( !function_exists('conikal_vote_comment') ): 
    function conikal_vote_comment() {
        check_ajax_referer('comment_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $comment_id = isset($_POST['comment_id']) ? sanitize_text_field($_POST['comment_id']) : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';


        $vote_key = 'comment_vote';
        $vote = get_comment_meta($comment_id, $vote_key, true);

        if ($type == 'up') {
            if($vote == '') {
                $vote = array();
                delete_user_meta($comment_id, $vote_key);
                add_comment_meta($comment_id, $vote_key, $vote);
            }
            if(in_array($user_id, $vote) === false) {
                array_push($vote, $user_id);
                update_comment_meta($comment_id, $vote_key, $vote);
            }

            echo json_encode(array('status' => true, 'type' => $type, 'votes' => $vote));
        } else if ($type == 'down') {
            if(in_array($user_id, $vote)) {
                $vote = array_diff($vote, array($user_id));
                update_comment_meta($comment_id, $vote_key, $vote);
            }

            echo json_encode(array('status' => true, 'type' => $type, 'votes' => $vote));
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_vote_comment', 'conikal_vote_comment' );
add_action( 'wp_ajax_conikal_vote_comment', 'conikal_vote_comment' );

/**
 * UPDATE COMMENT PETITION
 */
if( !function_exists('conikal_update_comment') ): 
    function conikal_update_comment() {
        check_ajax_referer('comment_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $comment_id = isset($_POST['comment_id']) ? sanitize_text_field($_POST['comment_id']) : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';

        if ($content == '') {
            echo json_encode(array('save' => false, 'message' => __('Comment content is required!', 'petition')));
            exit();
        }

        $arg = array(
                'comment_ID' => $comment_id,
                'comment_content' => $content
            );
        $update_comment = wp_update_comment($arg);

        if ($update_comment) {
            echo json_encode(array('status' => true, 'id' => $comment_id, 'content' => $content, 'message' => __('Update comment successfuly.', 'petition') ));
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Comment is not update.', 'petition') ));
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_update_comment', 'conikal_update_comment' );
add_action( 'wp_ajax_conikal_update_comment', 'conikal_update_comment' );

/**
 * UPDATE COMMENT PETITION
 */
if( !function_exists('conikal_delete_comment') ): 
    function conikal_delete_comment() {
        check_ajax_referer('comment_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $comment_id = isset($_POST['comment_id']) ? sanitize_text_field($_POST['comment_id']) : '';

        $delete_comment = wp_delete_comment($comment_id);

        if ($delete_comment == true) {
            echo json_encode(array('status' => true, 'id' => $comment_id, 'message' => __('The comment was deleted successfuly.', 'petition') ));
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Comment is not update.', 'petition') ));
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_delete_comment', 'conikal_delete_comment' );
add_action( 'wp_ajax_conikal_delete_comment', 'conikal_delete_comment' );


/**
 * FUNTION ADD COMMENT PETITION GUEST SIGN
 */
if( !function_exists('conikal_add_comment_sign') ): 
    function conikal_add_comment_sign($user_id, $post_id, $content) {

        $ip_address = conikal_get_client_ip();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $author  = get_userdata( $user_id );

        if ($content == '') {
            echo json_encode(array('save' => false, 'message' => __('Comement content is required!', 'petition')));
            exit();
        }

        $time = current_time('mysql');

        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $author->user_login,
            'comment_author_email' => $author->user_email,
            'comment_author_url' => $author->user_url,
            'comment_content' => $content,
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => $user_id,
            'comment_author_IP' => $ip_address,
            'comment_agent' => $agent,
            'comment_date' => $time,
            'comment_approved' => 1,
        );

        $comment_id = wp_insert_comment($comment_data);
        $details = get_comment($comment_id);

        $author_avatar = get_user_meta($details->user_id, 'avatar', true);
        $author_name   = get_userdata($details->user_id);
        $author_name   = $author_name->display_name;
        
        if (!$author_name) {
            $author_name = $details->comment_author;
            $details->comment_author_name = $author_name;
        }
        if (!$author_avatar) {
            $author_avatar = get_template_directory_uri().'/images/avatar.svg';
            $details->comment_author_avatar = $author_avatar;
        }
        $author_avatar = conikal_get_avatar_url( $author->ID, array('size' => 35, 'default' => $author_avatar) );
        
        $details->comment_author_name = $author_name;
        $details->comment_author_avatar = $author_avatar;
        if ($comment_id != 0) {
            return true;
        } else {
            return false;
        }

        die();
    }
endif;

/*
** GET QUERY COMMENT PETITION
*/

if( !function_exists('conikal_comments_petition') ): 
    function conikal_comments_petition($post_id, $parent_id) {

        $conikal_appearance_settings = get_option('conikal_appearance_settings','');
        $comments_per_page_setting = isset($conikal_appearance_settings['conikal_comments_per_page_field']) ? $conikal_appearance_settings['conikal_comments_per_page_field'] : '';
        $comments_per_page = $comments_per_page_setting != '' ? $comments_per_page_setting : 10;

        $reply_per_comment_setting = isset($conikal_appearance_settings['conikal_reply_per_comment_field']) ? $conikal_appearance_settings['conikal_reply_per_comment_field'] : '';
        $reply_per_comment = $reply_per_comment_setting != '' ? $reply_per_comment_setting : 3;

        if ($parent_id == 0) {
            $number = $comments_per_page;
        } else {
            $number = $reply_per_comment;
        }

        $comments = get_comments(array(
            'status' => 'approve',
            'post_id' => $post_id,
            'number' => $number,
            'parent' => $parent_id,
            'orderby' => 'comment_date',
            'order' => 'DESC'
        ));


        $arrayComments = array();
        if ($comments) :
            foreach($comments as $comment) :
                    $author_avatar = get_user_meta($comment->user_id, 'avatar', true);
                    $author_data   = get_userdata($comment->user_id);
                    if ($author_data) {
                        $author_name   = $author_data->display_name;
                    } else {
                        $author_name = $comment->comment_author;
                    }
                    if (!$author_avatar) {
                        $author_avatar = get_template_directory_uri().'/images/avatar.svg';
                    }
                    $author_avatar = conikal_get_avatar_url( $author_data->ID, array('size' => 35, 'default' => $author_avatar) );

                    $comment_time = strtotime($comment->comment_date, current_time('timestamp'));
                    $comment_time = human_time_diff($comment_time, current_time('timestamp')) . __(' ago', 'petition');
                    $votes = get_comment_meta($comment->comment_ID, 'comment_vote', true);
                    if (is_array($votes) && in_array(get_current_user_id(), $votes)) {
                        $voted = true;
                    } else {
                        $voted = false;
                    }

                    $author_link = get_author_posts_url($comment->user_id);

                    $arrayComment = array(
                                            'comment_ID' => $comment->comment_ID, 
                                            'comment_post_ID' => $comment->comment_post_ID, 
                                            'comment_author' => $comment->comment_author,
                                            'comment_author_name' => $author_name,
                                            'comment_author_avatar' => $author_avatar,
                                            'comment_author_link' => $author_link,
                                            'comment_author_email' => $comment->comment_author_email,
                                            'comment_author_url' => $comment->comment_author_url,
                                            'comment_author_IP' => $comment->comment_author_IP,
                                            'comment_date' => $comment->comment_date,
                                            'comment_date_gmt' => $comment->comment_date_gmt,
                                            'comment_time' => $comment_time,
                                            'comment_content' => $comment->comment_content,
                                            'comment_karma' => $comment->comment_karma,
                                            'comment_approved' => $comment->comment_approved,
                                            'comment_agent' => $comment->comment_agent,
                                            'comment_type' => $comment->comment_type,
                                            'comment_parent' => $comment->comment_parent,
                                            'comment_vote' => count($votes),
                                            'comment_voted' => $voted,
                                            'user_id' => $comment->user_id
                                    );
                    $arrayComment = (object) $arrayComment;
                    array_push($arrayComments, $arrayComment);
            endforeach;
        endif;
        $comments = array_reverse($arrayComments);

        return $comments;

        die();
    }
endif;


/**
 * FUNTION LOAD MORE COMMENTS
 */
if( !function_exists('conikal_load_comments') ): 
    function conikal_load_comments() {
        global $post;
        $user = wp_get_current_user();
        $conikal_appearance_settings = get_option('conikal_appearance_settings','');
        $comments_per_page_setting = isset($conikal_appearance_settings['conikal_comments_per_page_field']) ? $conikal_appearance_settings['conikal_comments_per_page_field'] : '';
        $comments_per_page = $comments_per_page_setting != '' ? $comments_per_page_setting : 10;
        $reply_per_comment_setting = isset($conikal_appearance_settings['conikal_reply_per_comment_field']) ? $conikal_appearance_settings['conikal_reply_per_comment_field'] : '';
        $reply_per_comment = $reply_per_comment_setting != '' ? $reply_per_comment_setting : 3;

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : $post->ID;
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : $user->ID;
        $parent_id = isset($_POST['parent_id']) ? sanitize_text_field($_POST['parent_id']) : 0;
        $offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : 0;

        if ($parent_id != 0) {
            $comments_per_page = '';
        }

        $comments = get_comments(array(
            'status' => 'approve',
            'post_id' => $post_id,
            'number' => $comments_per_page,
            'parent' => $parent_id,
            'offset' => $offset,
            'orderby' => 'comment_date',
            'order' => 'DESC'
        ));

        
        $arrayComments = array();
        if ($comments) :
            foreach($comments as $comment) :
                    $author_avatar = get_user_meta($comment->user_id, 'avatar', true);
                    $author_data   = get_userdata($comment->user_id);
                    if ($author_data) {
                        $author_name   = $author_data->display_name;
                    } else {
                        $author_name = $comment->comment_author;
                    }
                    if (!$author_avatar) {
                        $author_avatar = get_template_directory_uri().'/images/avatar.svg';
                    }
                    $author_avatar = conikal_get_avatar_url( $author_data->ID, array('size' => 35, 'default' => $author_avatar) );

                    $comment_time = strtotime($comment->comment_date, current_time('timestamp'));
                    $comment_time = human_time_diff($comment_time, current_time('timestamp')) . __(' ago', 'petition');
                    $votes = get_comment_meta($comment->comment_ID, 'comment_vote', true);
                    if (is_array($votes) && in_array(get_current_user_id(), $votes)) {
                        $voted = true;
                    } else {
                        $voted = false;
                    }

                    $author_link = get_author_posts_url($comment->user_id);

                    $arrayComment = array(
                                            'comment_ID' => $comment->comment_ID, 
                                            'comment_post_ID' => $comment->comment_post_ID, 
                                            'comment_author' => $comment->comment_author,
                                            'comment_author_name' => $author_name,
                                            'comment_author_avatar' => $author_avatar,
                                            'comment_author_link' => $author_link,
                                            'comment_author_email' => $comment->comment_author_email,
                                            'comment_author_url' => $comment->comment_author_url,
                                            'comment_author_IP' => $comment->comment_author_IP,
                                            'comment_date' => $comment->comment_date,
                                            'comment_date_gmt' => $comment->comment_date_gmt,
                                            'comment_time' => $comment_time,
                                            'comment_content' => $comment->comment_content,
                                            'comment_karma' => $comment->comment_karma,
                                            'comment_approved' => $comment->comment_approved,
                                            'comment_agent' => $comment->comment_agent,
                                            'comment_type' => $comment->comment_type,
                                            'comment_parent' => $comment->comment_parent,
                                            'comment_vote' => count($votes),
                                            'comment_voted' => $voted,
                                            'user_id' => $comment->user_id
                                    );
                    $replies = conikal_comments_petition($post_id, $comment->comment_ID);
                    $arrayComment = (object) $arrayComment;
                    if ($replies) {
                        $arrayComment->replies = $replies;
                    }
                    $replies_total = get_comments(array(
                        'status' => 'approve',
                        'post_id' => $post_id,
                        'parent' => $comment->comment_ID,
                        'order' => 'DESC'
                    ));
                    $arrayComment->replies_total = count($replies_total);
                    array_push($arrayComments, $arrayComment);
            endforeach;
        endif;
        $comments = array_reverse($arrayComments);

        if ($comments) {
            echo json_encode(array('status' => true, 'per_page' => $comments_per_page, 'per_comment' => $reply_per_comment, 'comments' => $comments, 'message' => __('Comments was loaded successfully', 'petition')));
            exit();
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found comments.', 'petition')));
            exit();
        }

        die();
    }
endif;

add_action( 'wp_ajax_nopriv_conikal_load_comments', 'conikal_load_comments' );
add_action( 'wp_ajax_conikal_load_comments', 'conikal_load_comments' );


?>