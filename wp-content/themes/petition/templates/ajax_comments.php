<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$current_user = wp_get_current_user();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$comments_per_page_setting = isset($conikal_appearance_settings['conikal_comments_per_page_field']) ? $conikal_appearance_settings['conikal_comments_per_page_field'] : '';
$comments_per_page = $comments_per_page_setting != '' ? $comments_per_page_setting : 10;
$reply_per_comment_setting = isset($conikal_appearance_settings['conikal_reply_per_comment_field']) ? $conikal_appearance_settings['conikal_reply_per_comment_field'] : '';
$reply_per_comment = $reply_per_comment_setting != '' ? $reply_per_comment_setting : 3;
?>

    <!-- COMMENT LIST -->
    <?php
        $id = get_the_ID();

        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
        if($user_avatar != '') {
            $avatar = $user_avatar;
        } else {
            $avatar = get_template_directory_uri().'/images/avatar.svg';
        }
        $user_avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $user_avatar) );

        $current_user_avatar = $current_user->avatar;
        if (!$current_user_avatar) {
            $current_user_avatar = get_template_directory_uri().'/images/avatar.svg';
        }
        $current_user_avatar = conikal_get_avatar_url( $current_user->ID, array('size' => 35, 'default' => $current_user_avatar) );

        $comments = conikal_comments_petition($id, 0);
        $commnet_count = wp_count_comments($id);
    ?>
    <h3 class="ui dividing header"><span id="comment-count"><?php echo conikal_format_number('%!,0i', esc_html($commnet_count->approved)) ?></span> <?php _e('Comments', 'petition') ?></h3>
    <?php if ($commnet_count->approved >= $comments_per_page) { ?> 
        <input type="hidden" value="<?php echo esc_attr($comments_per_page) ?>" id="comment-offset">
        <input type="hidden" value="<?php echo esc_attr($comments_per_page) ?>" id="comment-number">
        <input type="hidden" value="<?php echo esc_attr($reply_per_comment) ?>" id="reply-number">
        <button class="ui basic fluid button" id="comment-more"><i class="long arrow up icon"></i><?php _e('Older comments ...', 'petition') ?></button>
    <?php } ?>
    <div class="ui comments" id="comments-list" style="width: 100%">
        <?php if ($comments) { ?>
            <?php
            foreach($comments as $comment) :
                $votes = get_comment_meta($comment->comment_ID, 'comment_vote', true);
            ?>
                <div class="comment" id="comment-<?php echo esc_attr($comment->comment_ID) ?>">
                    <a href="<?php echo get_author_posts_url($comment->user_id) ?>" class="avatar" data-bjax>
                        <img class="ui bordered image" src="<?php echo esc_url($comment->comment_author_avatar) ?>" alt="<?php echo esc_attr($comment->comment_author_name) ?>" />
                    </a>
                    <div class="content">
                        <a class="author" href="<?php echo get_author_posts_url($comment->user_id) ?>" data-bjax><?php echo esc_attr($comment->comment_author_name) ?></a>
                        <div class="metadata">
                            <div class="date">
                                <?php echo esc_html($comment->comment_time) ?>
                            </div>
                            <div class="date"> · </div>
                            <div class="rating">
                            <?php echo '<span id="vote-num-' . esc_html($comment->comment_ID) . '">' . esc_html(count($votes)) . '</span> ' . __('like', 'petition'); ?>
                            </div>
                        </div>
                        <div class="text" id="comment-content-<?php echo esc_attr($comment->comment_ID) ?>">
                            <p><?php echo esc_html($comment->comment_content) ?></p>
                        </div>
                        <div class="actions">
                            <?php if (is_array($votes) && in_array(get_current_user_id(), $votes)) { ?>
                                <a href="javascript:void(0)" class="vote down" id="vote-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="thumbs down icon"></i><?php esc_html_e('Unlike', 'petition') ?></a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" class="vote up" id="vote-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="thumbs up icon"></i><?php esc_html_e('Like', 'petition') ?></a>
                            <?php } 
                                if ( is_user_logged_in() ) { ?>
                                <a href="javascript:void(0)" class="reply" id="reply-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="reply icon"></i><?php esc_html_e('Reply', 'petition') ?></a>
                            <?php if ( ($comment->user_id == get_current_user_id()) || current_user_can('administrator') ) { ?>
                                <a href="javascript:void(0)" class="edit" id="edit-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="pencil icon"></i><?php esc_html_e('Edit', 'petition') ?></a>
                                <a href="javascript:void(0)" class="delete" id="delete-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="delete icon"></i><?php esc_html_e('Delete', 'petition') ?></a>
                            <?php }
                                }
                             ?>
                        </div>
                    </div>
                    <div class="comments">
                    <?php
                    $replies_total = get_comments(array(
                        'status' => 'approve',
                        'post_id' => $id,
                        'parent' => $comment->comment_ID,
                        'order' => 'DESC'
                    ));
                    if (count($replies_total) > $reply_per_comment) { ?>
                        <a href="javascript:void(0)" class="hide-replies" id="hide-<?php echo esc_attr($comment->comment_ID) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>" style="display: none;"><i class="angle up icon"></i><?php esc_html_e('Hidden replies', 'petition') ?></a>
                        <a href="javascript:void(0)" class="more-replies" id="more-<?php echo esc_attr($comment->comment_ID) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="angle down icon"></i><?php echo esc_html('View all', 'petition') . ' ' . esc_html(count($replies_total)) . ' ' . esc_html('replies', 'petition') ?></a>
                        <div class="ui active mini inline loader" id="loading-<?php echo esc_attr($comment->comment_ID) ?>" style="display: none"></div>
                    <?php } ?>
                    <div id="replies-<?php echo esc_attr($comment->comment_ID) ?>">
                    <?php
                    $replies =  conikal_comments_petition($id, $comment->comment_ID);
                    if ($replies) : ?>
                        <?php foreach($replies as $reply) : 
                        $reply_votes = get_comment_meta($reply->comment_ID, 'comment_vote', true);
                        ?>
                        <div class="comment" id="comment-<?php echo esc_attr($reply->comment_ID) ?>">
                            <a href="<?php echo get_author_posts_url($reply->user_id) ?>" class="avatar" data-bjax>
                                <img class="ui bordered image" src="<?php echo esc_url($reply->comment_author_avatar) ?>"  alt="<?php echo esc_attr($comment->comment_author_name) ?>" />
                            </a>
                            <div class="content">
                                <a class="author" href="<?php echo get_author_posts_url($reply->user_id) ?>" data-bjax><?php echo esc_html($reply->comment_author_name) ?></a>
                                <div class="metadata">
                                    <div class="date">
                                        <?php echo esc_html($reply->comment_time) ?>
                                    </div>
                                    <div class="date"> · </div>
                                    <div class="rating">
                                        <?php echo '<span id="vote-num-' . esc_attr($reply->comment_ID) . '">' . esc_html(count($reply_votes)) . '</span> ' . __('like', 'petition'); ?>
                                    </div>
                                </div>
                                <div class="text" id="comment-content-<?php echo esc_attr($reply->comment_ID) ?>">
                                    <p><?php echo esc_html($reply->comment_content) ?></p>
                                </div>
                                <div class="actions">
                                    <?php if (is_array($votes) && in_array(get_current_user_id(), $votes)) { ?>
                                        <a href="javascript:void(0)" class="vote down" id="vote-<?php echo esc_attr($reply->comment_ID) ?>" data-author="<?php echo esc_attr($reply->comment_author_name) ?>" data-id="<?php echo esc_attr($reply->comment_ID) ?>"><i class="thumbs down icon"></i><?php esc_html_e('Unlike', 'petition') ?></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" class="vote up" id="vote-<?php echo esc_attr($reply->comment_ID) ?>" data-author="<?php echo esc_attr($reply->comment_author_name) ?>" data-id="<?php echo esc_attr($reply->comment_ID) ?>"><i class="thumbs up icon"></i><?php esc_html_e('Like', 'petition') ?></a>
                                    <?php } 
                                        if ( is_user_logged_in() ) { ?>
                                        <a href="javascript:void(0)" class="reply" id="reply-<?php echo esc_attr($comment->comment_ID) ?>" data-author="<?php echo esc_attr($comment->comment_author_name) ?>" data-id="<?php echo esc_attr($comment->comment_ID) ?>"><i class="reply icon"></i><?php esc_html_e('Reply', 'petition') ?></a>
                                    <?php if ( ($comment->user_id == get_current_user_id()) || current_user_can('administrator') ) { ?>
                                        <a href="javascript:void(0)" class="edit" id="edit-<?php echo esc_attr($reply->comment_ID) ?>" data-author="<?php echo esc_attr($reply->comment_author_name) ?>" data-id="<?php echo esc_attr($reply->comment_ID) ?>"><i class="pencil icon"></i><?php esc_html_e('Edit', 'petition') ?></a>
                                        <a href="javascript:void(0)" class="delete" id="delete-<?php echo esc_attr($reply->comment_ID) ?>" data-author="<?php echo esc_attr($reply->comment_author_name) ?>" data-id="<?php echo esc_attr($reply->comment_ID) ?>"><i class="delete icon"></i><?php esc_html_e('Delete', 'petition') ?></a>
                                    <?php } 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } else { ?>
            <div class="ui header" id="no-comment">
                <div class="content">
                    <?php esc_html_e('No comments yet', 'petition') ?>
                    <div class="sub header">
                        <?php esc_html_e('Leaving the first to comment on this article.', 'petition') ?>
                    </div>
                </div>    
            </div>
        <?php } ?>
    </div>

    <!-- ADD NEW COMMENT -->
    <?php if(is_user_logged_in()) { ?>
    <div class="ui sticky" id="comment-sticky">
        <div class="ui reply form ui fluid label">
            <?php if (!wp_is_mobile()) { ?>
            <img class="ui right spaced avatar large image" style="margin-top: 2.5px;" src="<?php echo esc_url($current_user_avatar) ?>">
            <?php } ?>
            <textarea class="auto-height comment-input" rows="1" id="content-comment" placeholder="<?php _e('Add a comment', 'petition') ?>"></textarea>
            <button class="ui basic icon button" id="send-comment"><i class="send icon"></i></button>
            <input type="hidden" id="comment-parent" value="0"></input>
        </div>
        <div id="commentMessage"></div>
    </div>
    <?php } else { ?>
        <div class="ui large message">
        <?php
            $signin_link = '<a href="javascript:void(0)" class="item signin-btn">' . __('Sign In', 'petition') . '</a>';
            $signup_link = '<a href="javascript:void(0)" class="item signup-guest">' . __('Sign Up', 'petition') . '</a>';
            echo sprintf(__('You need %1$s or %2$s account to post comment.', 'petition'), $signin_link, $signup_link);
        ?>
        </div>
    <?php } ?>
    <?php wp_nonce_field('comment_ajax_nonce', 'securityComment', true); ?>