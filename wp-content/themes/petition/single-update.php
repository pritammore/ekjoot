<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
global $current_user;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$conikal_auth_settings = get_option('conikal_auth_settings','');
$fb_login = isset($conikal_auth_settings['conikal_fb_login_field']) ? $conikal_auth_settings['conikal_fb_login_field'] : false;
$fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$comments_per_page_setting = isset($conikal_appearance_settings['conikal_comments_per_page_field']) ? $conikal_appearance_settings['conikal_comments_per_page_field'] : '';
$comments_per_page = $comments_per_page_setting != '' ? $comments_per_page_setting : 10;
$reply_per_comment_setting = isset($conikal_appearance_settings['conikal_reply_per_comment_field']) ? $conikal_appearance_settings['conikal_reply_per_comment_field'] : '';
$reply_per_comment = $reply_per_comment_setting != '' ? $reply_per_comment_setting : 3;
?>

<?php while(have_posts()) : the_post();
    $update_id = get_the_ID();           
    $update_title = get_the_title($update_id);
    $update_content = get_the_content($update_id);
    $update_date = get_the_date('', $update_id);
    $update_type = get_post_meta($update_id, 'update_type', true);
    $update_media = get_post_meta($update_id, 'update_media', true);
    $update_gallery = get_post_meta($update_id, 'update_gallery', true);
    $update_images = explode('~~~', $update_gallery);
    $update_thumb_id = get_post_thumbnail_id($update_id);
    $update_thumbnail = wp_get_attachment_image_src($update_thumb_id, 'large', true);
    $update_video = get_post_meta($update_id, 'update_video', true);
    $update_thumb = get_post_meta($update_id, 'update_thumb', true);

    $petition_id = get_post_meta($update_id, 'update_post_id', true);
    $petition = get_post($petition_id);
    $title = $petition->post_title;
    $content = $petition->post_content;
    $excerpt = conikal_get_excerpt_by_id($petition_id);
    $link = get_permalink($petition_id);
    $gallery = get_post_meta($petition_id, 'petition_gallery', true);
    $images = explode("~~~", $gallery);
    $thumb_id = get_post_thumbnail_id($petition_id);
    $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-small', true);
    $category =  wp_get_post_terms($petition_id, 'petition_category');
    $topics =  wp_get_post_terms($petition_id, 'petition_topics');
    $date = get_the_date('', $petition_id);
    $conikal_general_settings = get_option('conikal_general_settings');
    $address = get_post_meta($petition_id, 'petition_address', true);
    $city = get_post_meta($petition_id, 'petition_city', true);
    $state = get_post_meta($petition_id, 'petition_state', true);
    $neighborhood = get_post_meta($petition_id, 'petition_neighborhood', true);
    $zip = get_post_meta($petition_id, 'petition_zip', true);
    $country = get_post_meta($petition_id, 'petition_country', true);
    $lat = get_post_meta($petition_id, 'petition_lat', true);
    $lng = get_post_meta($petition_id, 'petition_lng', true);
    $receiver = get_post_meta($petition_id, 'petition_receiver', true);
    $receiver = explode(',', $receiver);
    $position = get_post_meta($petition_id, 'petition_position', true);
    $position = explode(',', $position);
    $goal = get_post_meta($petition_id, 'petition_goal', true);
    $sign_num = get_post_meta($petition_id, 'petition_sign', true);
    $sign_num = isset($sign_num) ? intval($sign_num) : 0;
    $p_info_link = get_permalink($petition_id);
    $p_info_title = $title;
    $video = get_post_meta($petition_id, 'petition_video', true);
    $thumb_placeholder = get_post_meta($petition_id, 'petition_thumb', true);
    $thumb = conikal_video_thumbnail($thumb_placeholder);
    $letter = get_post_meta($petition_id, 'petition_letter', true);
    $status = get_post_meta($petition_id, 'petition_status', true);
    $uic = get_post_meta($petition_id, 'petition_uic', true);

    $user_address = get_user_meta(get_the_author_meta( 'ID' ), 'user_address', true);
    $user_country = get_user_meta(get_the_author_meta( 'ID' ), 'user_country', true);
    $user_city = get_user_meta(get_the_author_meta( 'ID' ), 'user_city', true);
    $user_state = get_user_meta(get_the_author_meta( 'ID' ), 'user_state', true);
    $user_neighborhood = get_user_meta(get_the_author_meta( 'ID' ), 'user_neighborhood', true);

    conikal_set_post_views($update_id);

    $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
    if($user_avatar != '') {
        $avatar = $user_avatar;
    } else {
        $avatar = get_template_directory_uri().'/images/avatar.svg';
    }
    $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $avatar) );


    $user = wp_get_current_user();
    // delete_user_meta($user->ID, 'property_fav');
    $sign = get_user_meta($user->ID, 'petition_sign', true);
    $users = get_users();
    $signs = 0;

    foreach ($users as $user) {
        $user_fav = get_user_meta($user->data->ID, 'petition_sign', true);
        if(is_array($user_fav) && in_array($petition_id, $user_fav)) {
            $signs = $signs + 1;
        }
    }

    $current_user_avatar = $current_user->avatar;
    if (!$current_user_avatar) {
        $current_user_avatar = get_template_directory_uri().'/images/avatar.svg';
    }
    $current_user_avatar = conikal_get_avatar_url( $current_user->ID, array('size' => 35, 'default' => $current_user_avatar) );

    switch ($update_type) {
        case 'update':
            $update_feed = __('Issue Update', 'petition');
            break;
        case 'featured':
            $update_feed = __('Featured on Press', 'petition');
            break;
        case 'responsive':
            $update_feed = __('Decision maker Responsive', 'petition');
            break;
        case 'victory':
            $update_feed = __('Issue Victory', 'petition');
            break;
        
        default:
            $update_feed = __('Issue Update', 'petition');
            break;
    }

?>

<div id="wrapper" class="wrapper read">
    <!-- BACK PETITION -->
    <div class="ui secondary vertical segment">
        <div class="ui container">
            <div class="ui grid">
                <div class="sixteen wide column tablet computer only">
                    <div class="ui link items">
                        <a class="item" href="<?php echo isset($p_info_link) ? $p_info_link : ''; ?>" title="<?php $p_info_title ?>" data-bjax>
                            <div class="ui tiny image">
                                <?php if(has_post_thumbnail($petition_id)) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url($thumbnail[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($gallery) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url($images[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($thumb) { ?>
                                    <img class="ui fluid image" id="video-thumbnail" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } else { ?>
                                    <img class="ui fluid image" id="no-thumbnail" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } ?>
                            </div>
                            <div class="content">
                                <div class="header"><?php echo esc_html($title) ?></div>
                                <div class="extra">
                                    <?php _e('by', 'petition') ?> <strong><?php the_author(); ?></strong>
                                    <span><?php echo ' · ' . esc_html($signs) . ' ' . __('supporters', 'petition') ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sixteen wide column mobile only">
                    <div class="ui link items">
                        <a class="item" href="<?php echo isset($p_info_link) ? esc_url($p_info_link) : ''; ?>" title="<?php echo esc_attr($p_info_title) ?>" data-bjax>
                            <div class="content">
                                <div class="header"><i class="chevron left icon"></i><?php echo esc_html($title) ?></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui hidden divider"></div>

    <div class="ui container">
        <div class="ui grid">
            <div class="sixteen wide mobile ten wide tablet ten wide computer column" id="content">
                <!-- PETITION CONTENT -->
                <div id="main-petition">
                    <div class="ui basic vertical segment">
                        <h1 class="ui header petition-title">
                            <div class="content">
                                <div class="sub header"><i class="feed icon"></i><?php echo esc_html($update_feed) ?></div>
                                <?php echo esc_html($update_title) ?>
                            </div>
                        </h1>

                        <!-- THUMBNAIL UPDATE -->
                        <?php
                            if ($update_gallery) { 
                                if (has_post_thumbnail($update_id)) { ?>
                                <img class="ui fluid image" id="thumbnail" src="<?php echo esc_url($update_thumbnail[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($update_gallery) { ?>
                                <img class="ui fluid image" id="gallery" src="<?php echo esc_url($update_images[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } ?>
                            <?php } elseif ($update_video) { ?>
                                <div class="ui embed" id="media-embed"></div>
                                <input type="hidden" id="video-url" value="<?php echo esc_url($update_video) ?>">
                                <?php if (!wp_is_mobile()) { ?>
                                    <input type="hidden" id="thumb-url" value="<?php echo esc_url($thumb_placeholder) ?>">
                                <?php } ?>
                        <?php } ?>
                        <div class="ui hidden divider"></div>

                        <!-- MAIN CONTENT UPDATE -->
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="entry-content">
                                <?php echo esc_html($update_date) ?>
                                <?php the_content(); ?>
                                <div class="clearfix"></div>
                                <?php wp_link_pages( array(
                                    'before'      => '<div class="page-links">',
                                    'after'       => '</div>',
                                    'link_before' => '<span>',
                                    'link_after'  => '</span>',
                                    'pagelink'    => '%',
                                    'separator'   => '',
                                ) ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COMMENT UPDATE -->
                <?php if(comments_open() || get_comments_number()) {
                        comments_template();
                    } ?>

            </div>
            <div class="six wide tablet six wide computer column tablet computer only" >
                <!-- SIGN AND SHARE PETITION -->
                <div class="ui sticky" id="sign-sticky">
                    <div class="ui basic vertical segment">
                        <?php /*if ($sign_num >= $goal || $status == '1') { ?>
                            <h2 class="ui text victory"><i class="flag icon"></i><?php echo ( $status == '1' ? __('Confirm Victory!', 'petition') : __('Victory!', 'petition') ); ?></h2>
                            <div class="ui indicating small victory progress petition-goal" data-value="<?php echo esc_html($goal) ?>" data-total="<?php echo esc_html($goal) ?>">
                                <div class="bar">
                                    <div class="progress"></div>
                                </div>
                                <div class="label">
                                    <span><?php _e('This petition won with', 'petition') ?><?php echo ' ' . conikal_format_number('%!,0i', esc_html($sign_num)) . ' ' ?><?php _e('supporters', 'petition') ?></span>
                                </div>
                            </div>
                        <?php } else*/ /*if ($status == '2') { ?>
                            <h2><i class="lock icon"></i><span class="fav_no"><?php  _e('Petition closed', 'petition') ?></span></h2>
                            <div class="ui small progress petition-goal" data-value="<?php echo esc_html($sign_num) ?>" data-total="<?php echo esc_html($goal) ?>">
                                <div class="bar">
                                    <div class="progress"></div>
                                </div>
                                <div class="label">
                                    <span class="ned_no"><?php echo conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h2><i class="user icon"></i><span class="fav_no"><?php echo conikal_format_number('%!,0i', esc_html($sign_num)) ?></span> <?php  _e('Supporters', 'petition') ?></h2>
                            <div class="ui indicating small primary progress petition-goal" data-value="<?php echo esc_html($sign_num) ?>" data-total="<?php echo esc_html($goal) ?>">
                                <div class="bar">
                                    <div class="progress"></div>
                                </div>
                                <div class="label">
                                    <span class="ned_no"><?php echo conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                                </div>
                            </div>
                        <?php }*/ ?>
                        
                        <?php
                        if($sign != '') {
                            if(is_user_logged_in()) {
                                if(in_array($petition_id, $sign) === false && $status == '0') { ?>
                                    <!-- SIGN THE PETITION -->
                                    <div class="ui segment">
                                        <div class="ui list">
                                            <div class="item">
                                                <img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
                                                <div class="content">
                                                    <div class="header">
                                                        <?php echo esc_html($current_user->display_name); ?>
                                                    </div>
                                                    <div class="description">
                                                        <?php if ($current_user->user_country || $current_user->user_state || $current_user->user_city) { ?>
                                                            <?php echo ($current_user->user_city ? esc_html($current_user->user_city) . ', ' : '') . ($current_user->user_state ? esc_html($current_user->user_state) . ', ' : '') . esc_html($current_user->user_country); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui form">
                                        <div class="field">
                                            <div class="ui pointing below fluid basic label font large">
                                                <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="4" placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
                                            </div>
                                            <div class="ui message" style="margin-top: 0">
                                                <div class="fb-publish ui toggle checkbox <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>">
                                                    <input type="checkbox" name="fb-publish" class="hidden" <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>>
                                                    <label><i class="facebook icon"></i><?php _e('Share with Facebook friends', 'petition') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="field">
                                            <a href="javascript:void(0);" class="ui fluid primary big button signBtn signPetition"><i class="write icon"></i><?php _e('Sign', 'petition') ?></a>
                                        </div>
                                        <div class="field">
                                            <div class="email-notice ui checkbox <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>">
                                              <input type="checkbox" name="email-notice" <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>>
                                              <label><?php esc_html_e('Notify me when new information', 'petition') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <!-- FACEBOOK SHARE -->
                                    <div class="ui fitted divider"></div>
                                    <div class="ui accordion">
                                        <div class="title active">
                                            <h3 class="ui header">
                                            <i class="dropdown icon"></i>
                                            <?php _e('Share on Facebook', 'petition') ?>
                                            </h3>
                                        </div>
                                        <div class="content active">
                                            <div class="ui form">
                                                <div class="field">
                                                    <div class="ui pointing below fluid basic large label">
                                                        <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('Add a personal message', 'petition') ?>"></textarea>
                                                        <div class="ui horizontal divider"><i class="share alternate icon"></i></div>
                                                        <div class="ui grid">
                                                            <div class="four wide column">
                                                                <?php if($gallery) {
                                                                    if (has_post_thumbnail()) { ?>
                                                                        <img class="ui fluid image" id="thumbnail-share" src="<?php echo esc_url(the_post_thumbnail_url('thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                    <?php } else { ?>
                                                                        <img class="ui fluid image" id="gallery-share" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                    <?php } ?>
                                                                <?php } elseif ($thumb) { ?>
                                                                    <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                <?php } else { ?>
                                                                    <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumb.png') ?>" alt="<?php echo esc_attr($title) ?>">
                                                                <?php } ?>
                                                            </div>
                                                            <div class="twelve wide column">
                                                                <h4><?php echo esc_html($title) ?></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="ui fluid facebook big button postFB"><i class="facebook f icon"></i><?php _e('Post to Facebook', 'petition') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>

                                    <!-- SOCIAL SHARE BUTTON -->
                                    <div class="ui six column grid social-share">
                                        <div class="column">
                                            <a href="mailto://?subject=<?php echo esc_html($title) ?>&body=<?php echo esc_url($link); ?>" class="ui basic icon button" id="send-email" data-content="<?php _e('Send an Email' ,'petition') ?>" data-variation="small" data-position="top center"><i class="mail outline icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <?php if (wp_is_mobile()) { ?>
                                            <a href="<?php echo esc_url('sms://&body=' .$title . ' - ' . wp_get_shortlink()) ?>" id="send-sms" class="ui basic icon button" id="send-sms" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                            <?php } else { ?>
                                            <a href="javascript:void(0)" class="ui basic icon button send-message" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                            <?php } ?>
                                        </div>
                                        <div class="column">
                                            <a href="javascript:void(0)" class="ui basic icon button share-facebook" data-content="<?php _e('Share on Facebook' ,'petition') ?>" data-variation="small" data-position="top center"><i class="facebook f icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <a href="https://plus.google.com/share?url=<?php echo esc_url($link) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                                                target="_blank" class="ui basic icon button" id="share-google" data-content="<?php _e('Share on Google+' ,'petition') ?>" data-variation="small" data-position="top center"><i class="google plus icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <a href="https://twitter.com/share?url=<?php echo esc_url($link) ?>&text=<?php echo urlencode($title); ?>" target="_blank" class="ui basic icon button" id="tweet-twitter" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="top center"><i class="twitter icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <div class="ui icon top right pointing dropdown basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                                                <i class="ellipsis horizontal icon"></i>
                                                <div class="menu">
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="linkedin square icon"></i><?php esc_html_e('LinkedIn', 'petition') ?>
                                                    </a>
                                                    <a href="http://www.tumblr.com/share/link?url=<?php echo esc_url($link) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="tumblr square icon"></i><?php esc_html_e('Tumblr', 'petition') ?>
                                                    </a>
                                                    <a href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo isset($images[1]) ? esc_url($images[1]) : esc_url($thumb_placeholder) ?>&url=<?php echo esc_url($link) ?>&description=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="pinterest square icon"></i><?php esc_html_e('Pinterest', 'petition') ?>
                                                    </a>
                                                    <a href="http://reddit.com/submit?url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="reddit square icon"></i><?php esc_html_e('Reddit', 'petition') ?>
                                                    </a>
                                                    <a href="http://wordpress.com/press-this.php?u=<?php urlencode(urlencode($link)); ?>&t=<?php echo urlencode($title); ?>&s=<?php echo urlencode($excerpt); ?>&i=<?php echo urlencode($images[0]) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="wordpress square icon"></i><?php esc_html_e('WordPress', 'petition') ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SHORT URL -->
                                    <div class="ui divider"></div>
                                    <div class="ui right action left icon fluid input">
                                        <i class="linkify icon"></i>
                                        <input type="text" id="short-link" value="<?php echo wp_get_shortlink($petition_id) ?>" readonly>
                                        <button id="copy-link" class="ui basic button"><i class="copy icon"></i><?php _e('Copy', 'petition') ?></button>
                                    </div>
                                    <div id="msg-copy"></div>
                                    <!--<a href="javascript:void(0);" class="ui fluid primary big button signBtn signedPetition"><i class="checkmark icon"></i></a>-->
                                <?php }
                            } else {
                                get_template_part('templates/guest_sign');
                            }
                        } else {
                            if(is_user_logged_in()) {
                                if($status == '0') { ?>
                                    <!-- SIGN THE PETITION -->
                                    <div class="ui segment">
                                        <div class="ui list">
                                            <div class="item">
                                                <img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
                                                <div class="content">
                                                    <div class="header">
                                                        <?php echo esc_html($current_user->display_name); ?>
                                                    </div>
                                                    <div class="description">
                                                        <?php if ($current_user->user_country || $current_user->user_state || $current_user->user_city) { ?>
                                                            <?php echo ($current_user->user_city ? esc_html($current_user->user_city) . ', ' : '') . ($current_user->user_state ? esc_html($current_user->user_state) . ', ' : '') . esc_html($current_user->user_country); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui form">
                                        <div class="field">
                                            <div class="ui pointing below fluid basic label font large">
                                                <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="4" placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
                                            </div>
                                            <div class="ui message" style="margin-top: 0">
                                                <div class="fb-publish ui toggle checkbox <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>">
                                                    <input type="checkbox" name="fb-publish" class="hidden" <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>>
                                                    <label><i class="facebook icon"></i><?php _e('Share with Facebook friends', 'petition') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <a href="javascript:void(0);" class="ui fluid primary big button signBtn signPetition"><i class="write icon"></i><?php _e('Sign', 'petition') ?></a>
                                        </div>
                                        <div class="field">
                                            <div class="email-notice ui checkbox <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>">
                                              <input type="checkbox" name="email-notice" <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>>
                                              <label><?php esc_html_e('Notify me when new information', 'petition') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <!-- FACEBOOK SHATE -->
                                    <div class="ui fitted divider"></div>
                                    <div class="ui accordion">
                                        <div class="title active">
                                            <h3 class="ui header">
                                            <i class="dropdown icon"></i>
                                            <?php _e('Share on Facebook', 'petition') ?>
                                            </h3>
                                        </div>
                                        <div class="content active">
                                            <div class="ui form">
                                                <div class="field">
                                                    <div class="ui pointing below fluid basic large label">
                                                        <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('Add a personal message', 'petition') ?>"></textarea>
                                                        <div class="ui horizontal divider"><i class="share alternate icon"></i></div>
                                                        <div class="ui grid">
                                                            <div class="four wide column">
                                                                <?php if($gallery) {
                                                                    if (has_post_thumbnail()) { ?>
                                                                        <img class="ui fluid image" id="thumbnail-share" src="<?php echo esc_url(the_post_thumbnail_url('thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                    <?php } else { ?>
                                                                        <img class="ui fluid image" id="gallery-share" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                    <?php } ?>
                                                                <?php } elseif ($thumb) { ?>
                                                                    <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                                                <?php } else { ?>
                                                                    <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumb.png') ?>" alt="<?php echo esc_attr($title) ?>">
                                                                <?php } ?>
                                                            </div>
                                                            <div class="twelve wide column">
                                                                <h4><?php echo esc_html($title) ?></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="ui fluid facebook big button postFB"><i class="facebook f icon"></i><?php _e('Post to Facebook', 'petition') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>

                                    <!-- SOCIAL SHARE BUTTON -->
                                    <div class="ui six column grid social-share">
                                        <div class="column">
                                            <a href="mailto://?subject=<?php echo esc_html($title) ?>&body=<?php echo esc_url($link); ?>" class="ui basic icon button" id="send-email" data-content="<?php _e('Send an Email' ,'petition') ?>" data-variation="small" data-position="top center"><i class="mail outline icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <?php if (wp_is_mobile()) { ?>
                                            <a href="<?php echo esc_url('sms://&body=' .$title . ' - ' . wp_get_shortlink()) ?>" id="send-sms" class="ui basic icon button" id="send-sms" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                            <?php } else { ?>
                                            <a href="javascript:void(0)" class="ui basic icon button send-message" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                            <?php } ?>
                                        </div>
                                        <div class="column">
                                            <a href="javascript:void(0)" class="ui basic icon button share-facebook" data-content="<?php _e('Share on Facebook' ,'petition') ?>" data-variation="small" data-position="top center"><i class="facebook f icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <a href="https://plus.google.com/share?url=<?php echo esc_url($link) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                                                target="_blank" class="ui basic icon button" id="share-google" data-content="<?php _e('Share on Google+' ,'petition') ?>" data-variation="small" data-position="top center"><i class="google plus icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <a href="https://twitter.com/share?url=<?php echo esc_url($link) ?>&text=<?php echo urlencode($title); ?>" target="_blank" class="ui basic icon button" id="tweet-twitter" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="top center"><i class="twitter icon"></i></a>
                                        </div>
                                        <div class="column">
                                            <div class="ui icon top right pointing dropdown basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                                                <i class="ellipsis horizontal icon"></i>
                                                <div class="menu">
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="linkedin square icon"></i><?php esc_html_e('LinkedIn', 'petition') ?>
                                                    </a>
                                                    <a href="http://www.tumblr.com/share/link?url=<?php echo esc_url($link) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="tumblr square icon"></i><?php esc_html_e('Tumblr', 'petition') ?>
                                                    </a>
                                                    <a href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo isset($images[1]) ? esc_url($images[1]) : esc_url($thumb_placeholder) ?>&url=<?php echo esc_url($link) ?>&description=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="pinterest square icon"></i><?php esc_html_e('Pinterest', 'petition') ?>
                                                    </a>
                                                    <a href="http://reddit.com/submit?url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="reddit square icon"></i><?php esc_html_e('Reddit', 'petition') ?>
                                                    </a>
                                                    <a href="http://wordpress.com/press-this.php?u=<?php urlencode(urlencode($link)); ?>&t=<?php echo urlencode($title); ?>&s=<?php echo urlencode($excerpt); ?>&i=<?php echo urlencode($images[0]) ?>"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                                                target="_blank" class="item">
                                                        <i class="wordpress square icon"></i><?php esc_html_e('WordPress', 'petition') ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui divider"></div>

                                    <!-- SHORT URL COPY -->
                                    <div class="ui right action left icon fluid input">
                                        <i class="linkify icon"></i>
                                        <input type="text" id="short-link" value="<?php echo wp_get_shortlink($petition_id) ?>" readonly>
                                        <button id="copy-link" class="ui basic button"><i class="copy icon"></i><?php _e('Copy', 'petition') ?></button>
                                    </div>
                                    <div id="msg-copy"></div>
                                    <!--<a href="javascript:void(0);" class="ui fluid primary big button signBtn signedPetition"><i class="checkmark icon"></i></a>-->
                                <?php }
                            } else {
                                get_template_part('templates/guest_sign');
                            }
                        } ?>
                        <input type="hidden" id="petition_id" value="<?php echo esc_attr($petition_id) ?>">
                        <?php
                        wp_nonce_field('sign_ajax_nonce', 'securitySign', true);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile;
    wp_reset_postdata();
    wp_reset_query();
?>

<?php
$similar = isset($conikal_appearance_settings['conikal_similar_field']) ? $conikal_appearance_settings['conikal_similar_field'] : false;
if($similar) { ?>
    <div class="ui basic vertical segment">
        <div class="ui container">
            <?php get_template_part('templates/similar_petitions'); ?>
        </div>
    </div>
<?php } ?>

<!-- SIDEBAR SIGN AND SHARE PETITION -->
<?php if (wp_is_mobile()) { ?>
<div class="ui bottom sidebar segment" id="sign-sidebar" style="z-index: 999;">
    <div class="ui grid mobile only">
        <div class="sixteen wide column">
            <?php if ($sign_num >= $goal || $status == '1') { ?>
                <div class="ui grid">
                    <!-- <div class="thirteen wide column">
                        <h3 class="ui text victory"><i class="flag icon"></i><?php //echo ( $status == '1' ? __('Confirm Victory!', 'petition') : __('Victory!', 'petition') ); ?></h3>
                    </div> -->
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <!-- <div class="ui indicating tiny victory progress petition-goal" data-value="<?php //echo esc_html($goal) ?>" data-total="<?php //echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span><?php //_e('This petition won with', 'petition') ?><?php //echo ' ' . conikal_format_number('%!,0i', esc_html($sign_num)) . ' ' ?><?php //_e('supporters', 'petition') ?></span>
                    </div>
                </div> -->
            <?php } else if ($status == '2') { ?>
                <div class="ui grid">
                    <div class="thirteen wide column">
                        <h3><i class="lock icon"></i><span class="fav_no"><?php  _e('Issue closed', 'petition') ?></span></h3>
                    </div>
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <!-- <div class="ui tiny progress petition-goal" data-value="<?php echo esc_html($sign_num) ?>" data-total="<?php echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span class="ned_no"><?php //print conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php //echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                    </div>
                </div> -->
            <?php } else { ?>
                <div class="ui grid">
                    <div class="thirteen wide column">
                        <h3><i class="user icon"></i><span class="fav_no"><?php echo conikal_format_number('%!,0i', esc_html($sign_num)) ?></span> <?php  _e('Supporters', 'petition') ?></h3>
                    </div>
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <!-- <div class="ui indicating tiny primary progress petition-goal" data-value="<?php //echo esc_html($sign_num) ?>" data-total="<?php //echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span class="ned_no"><?php //print conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php //echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                    </div>
                </div> -->
            <?php } ?>
            
            <?php
            if($sign != '') {
                if(is_user_logged_in()) {
                    if(in_array($petition_id, $sign) === false && $status == '0') { ?>
                        <!-- SIGN THE PETITIN -->
                        <div class="ui segment">
                            <div class="ui list">
                                <div class="item">
                                    <img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
                                    <div class="content">
                                        <div class="header">
                                            <?php echo esc_html($current_user->display_name); ?>
                                        </div>
                                        <div class="description">
                                            <?php if ($current_user->user_country || $current_user->user_state || $current_user->user_city) { ?>
                                                
                                                <?php echo ($current_user->user_city ? esc_html($current_user->user_city) . ', ' : '') . ($current_user->user_state ? esc_html($current_user->user_state) . ', ' : '') . esc_html($current_user->user_country); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <div class="field">
                                <div class="ui pointing below fluid basic label font large">
                                    <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="4 " placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
                                </div>
                                <div class="ui message" style="margin-top: 0">
                                    <div class="fb-publish ui toggle checkbox <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>">
                                        <input type="checkbox" name="fb-publish" class="hidden" <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>>
                                        <label><i class="facebook icon"></i><?php _e('Share on Facebook', 'petition') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui message" style="margin-top: 0">
                                    <div class="email-notice ui toggle checkbox <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>">
                                      <input type="checkbox" name="email-notice" <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>>
                                      <label><?php esc_html_e('Notify me when new update', 'petition') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <a href="javascript:void(0);" class="ui fluid primary big button signBtn signPetition"><i class="write icon"></i><?php _e('Sign', 'petition') ?></a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="ui divider"></div>

                        <!-- SOCICAL SHARE BUTTON -->
                        <div class="ui five column grid social-share">
                            <div class="column">
                                <a href="mailto://?subject=<?php echo esc_html($title) ?>&body=<?php echo esc_url($link); ?>" class="ui basic icon button" id="send-email" data-content="<?php _e('Send an Email' ,'petition') ?>" data-variation="small" data-position="top center"><i class="mail outline icon"></i></a>
                            </div>
                            <div class="column">
                                <?php if (wp_is_mobile()) { ?>
                                <a href="sms://+84&body=<?php echo esc_html($title) . ' - ' . esc_html(wp_get_shortlink()); ?>" id="send-sms" class="ui basic icon button" id="send-sms" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                <?php } else { ?>
                                <a href="javascript:void(0)" class="ui basic icon button send-message" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                <?php } ?>
                            </div>
                            <div class="column">
                                <a href="https://plus.google.com/share?url=<?php echo esc_url($link) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                                    target="_blank" class="ui basic icon button" id="share-google" data-content="<?php _e('Share on Google+' ,'petition') ?>" data-variation="small" data-position="top center"><i class="google plus icon"></i></a>
                            </div>
                            <div class="column">
                                <a href="https://twitter.com/share?url=<?php echo esc_url($link) ?>&text=<?php echo urlencode($title); ?>" target="_blank" class="ui basic icon button" id="tweet-twitter" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="top center"><i class="twitter icon"></i></a>
                            </div>
                            <div class="column">
                                <div class="ui icon top right pointing dropdown basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                                    <i class="ellipsis horizontal icon"></i>
                                    <div class="menu">
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="linkedin square icon"></i><?php esc_html_e('LinkedIn', 'petition') ?>
                                        </a>
                                        <a href="http://www.tumblr.com/share/link?url=<?php echo esc_url($link) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="tumblr square icon"></i><?php esc_html_e('Tumblr', 'petition') ?>
                                        </a>
                                        <a href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo isset($images[1]) ? esc_url($images[1]) : esc_url($thumb_placeholder) ?>&url=<?php echo esc_url($link) ?>&description=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="pinterest square icon"></i><?php esc_html_e('Pinterest', 'petition') ?>
                                        </a>
                                        <a href="http://reddit.com/submit?url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="reddit square icon"></i><?php esc_html_e('Reddit', 'petition') ?>
                                        </a>
                                        <a href="http://wordpress.com/press-this.php?u=<?php urlencode(urlencode($link)); ?>&t=<?php echo urlencode($title); ?>&s=<?php echo urlencode($excerpt); ?>&i=<?php echo urlencode($images[0]) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="wordpress square icon"></i><?php esc_html_e('WordPress', 'petition') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>

                        <!-- FACEBOOK SHARE -->
                        <div class="ui accordion">
                            <div class="title active">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('Share on Facebook', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content active">
                                <div class="ui form">
                                    <div class="field">
                                        <div class="ui pointing below fluid basic large label">
                                            <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('Add a personal message', 'petition') ?>"></textarea>
                                            <div class="ui horizontal divider"><i class="share alternate icon"></i></div>
                                            <div class="ui grid">
                                                <div class="four wide column">
                                                    <?php if($gallery) {
                                                        if (has_post_thumbnail()) { ?>
                                                            <img class="ui fluid image" id="thumbnail-share" src="<?php echo esc_url(the_post_thumbnail_url('thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                                        <?php } else { ?>
                                                            <img class="ui fluid image" id="gallery-share" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                                        <?php } ?>
                                                    <?php } elseif ($thumb) { ?>
                                                        <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                                    <?php } else { ?>
                                                        <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumb.png') ?>" alt="<?php echo esc_attr($title) ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="twelve wide column">
                                                    <h4><?php echo esc_html($title) ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="ui fluid facebook button postFB"><i class="facebook f icon"></i><?php _e('Post to Facebook', 'petition') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<a id="signBtn" href="javascript:void(0);" class="ui fluid primary big button signedPetition"><i class="checkmark icon"></i></a>-->
                    <?php }
                } else {
                    get_template_part('templates/guest_sign');
                }
            } else {
                if(is_user_logged_in()) {
                    if($status == '0') { ?>
                        <!-- SIGN THE PETITIN -->
                        <div class="ui segment">
                            <div class="ui list">
                                <div class="item">
                                    <img class="ui avatar bordered image" src="<?php echo esc_url($current_user_avatar) ?>">
                                    <div class="content">
                                        <div class="header">
                                            <?php echo esc_html($current_user->display_name); ?>
                                        </div>
                                        <div class="description">
                                            <?php if ($current_user->user_country || $current_user->user_state || $current_user->user_city) { ?>
                                                <?php echo ($current_user->user_city ? esc_html($current_user->user_city) . ', ' : '') . ($current_user->user_state ? esc_html($current_user->user_state) . ', ' : '') . esc_html($current_user->user_country); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <div class="field">
                                <div class="ui pointing below fluid basic label font large">
                                    <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('Add a personal message', 'petition') ?>"></textarea>
                                </div>
                                <div class="ui message" style="margin-top: 0">
                                    <div class="fb-publish ui toggle checkbox <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>">
                                        <input type="checkbox" name="fb-publish" class="hidden" <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : ''); ?>>
                                        <label><i class="facebook icon"></i><?php _e('Share on Facebook', 'petition') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui message" style="margin-top: 0">
                                    <div class="email-notice ui toggle checkbox <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>">
                                      <input type="checkbox" name="email-notice" <?php echo ($current_user->notice == 'true' ? esc_attr('checked') : ''); ?>>
                                      <label><?php esc_html_e('Notify me when new update', 'petition') ?></label>
                                    </div>
                                </div>
                            </div>
                           <div class="field">
                                <a href="javascript:void(0);" class="ui fluid primary big button signBtn signPetition"><i class="write icon"></i><?php _e('Sign', 'petition') ?></a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="ui divider"></div>

                        <!-- SOCIAL SHARE BUTTON -->
                        <div class="ui five column grid social-share">
                            <div class="column">
                                <a href="mailto://?subject=<?php echo esc_html($title) ?>&body=<?php echo esc_url($link); ?>" class="ui basic icon button" id="send-email" data-content="<?php _e('Send an Email' ,'petition') ?>" data-variation="small" data-position="top center"><i class="mail outline icon"></i></a>
                            </div>
                            <div class="column">
                                <?php if (wp_is_mobile()) { ?>
                                <a href="<?php echo esc_url('sms://&body=' .$title . ' - ' . wp_get_shortlink()) ?>" id="send-sms" class="ui basic icon button" id="send-sms" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                <?php } else { ?>
                                <a href="javascript:void(0)" class="ui basic icon button send-message" data-content="<?php _e('Send a message' ,'petition') ?>" data-variation="small" data-position="top center"><i class="comment outline icon"></i></a>
                                <?php } ?>
                            </div>
                            <div class="column">
                                <a href="https://plus.google.com/share?url=<?php echo esc_url($link) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                                    target="_blank" class="ui basic icon button" id="share-google" data-content="<?php _e('Share on Google+' ,'petition') ?>" data-variation="small" data-position="top center"><i class="google plus icon"></i></a>
                            </div>
                            <div class="column">
                                <a href="https://twitter.com/share?url=<?php echo esc_url($link) ?>&text=<?php echo urlencode($title); ?>" target="_blank" class="ui basic icon button" id="tweet-twitter" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="top center"><i class="twitter icon"></i></a>
                            </div>
                            <div class="column">
                                <div class="ui icon top right pointing dropdown basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                                    <i class="ellipsis horizontal icon"></i>
                                    <div class="menu">
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="linkedin square icon"></i><?php esc_html_e('LinkedIn', 'petition') ?>
                                        </a>
                                        <a href="http://www.tumblr.com/share/link?url=<?php echo esc_url($link) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="tumblr square icon"></i><?php esc_html_e('Tumblr', 'petition') ?>
                                        </a>
                                        <a href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo isset($images[1]) ? esc_url($images[1]) : esc_url($thumb_placeholder) ?>&url=<?php echo esc_url($link) ?>&description=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="pinterest square icon"></i><?php esc_html_e('Pinterest', 'petition') ?>
                                        </a>
                                        <a href="http://reddit.com/submit?url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="reddit square icon"></i><?php esc_html_e('Reddit', 'petition') ?>
                                        </a>
                                        <a href="http://wordpress.com/press-this.php?u=<?php urlencode(urlencode($link)); ?>&t=<?php echo urlencode($title); ?>&s=<?php echo urlencode($excerpt); ?>&i=<?php echo urlencode($images[0]) ?>"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                                    target="_blank" class="item">
                                            <i class="wordpress square icon"></i><?php esc_html_e('WordPress', 'petition') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>

                        <!-- FACEBOOK SHARE -->
                        <div class="ui accordion">
                            <div class="title active">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('Share on Facebook', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content active">
                                <div class="ui form">
                                    <div class="field">
                                        <div class="ui pointing below fluid basic large label">
                                            <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="4" placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
                                            <div class="ui horizontal divider"><i class="share alternate icon"></i></div>
                                            <div class="ui grid">
                                                <div class="four wide column">
                                                    <?php if($gallery) {
                                                        if (has_post_thumbnail()) { ?>
                                                            <img class="ui fluid image" id="thumbnail-share" src="<?php echo esc_url(the_post_thumbnail_url('thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                                        <?php } else { ?>
                                                            <img class="ui fluid image" id="gallery-share" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                                        <?php } ?>
                                                    <?php } elseif ($thumb) { ?>
                                                        <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                                    <?php } else { ?>
                                                        <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumb.png') ?>" alt="<?php echo esc_attr($title) ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="twelve wide column">
                                                    <h4><?php echo esc_html($title) ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="ui fluid facebook button postFB"><i class="facebook f icon"></i><?php _e('Post to Facebook', 'petition') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<a href="javascript:void(0);" class="ui fluid primary big button signBtn signedPetition"><i class="checkmark icon"></i></a>-->
                    <?php }
                } else {
                    get_template_part('templates/guest_sign');
                }
            } ?>
            <input type="hidden" id="petition_id" value="<?php echo esc_attr($petition_id) ?>">
            <?php wp_nonce_field('sign_ajax_nonce', 'securitySign', true); ?>
        </div>
    </div>
</div>

<!-- MOBILE SIGN PETITION BUTTON -->
<div class="ui sticky" id="mobile-sign-btn">
    <div class="ui attached segment">
        <div class="ui grid mobile only">
            <div class="sixteen wide column">
            <?php if(is_user_logged_in()) { ?>
                <?php if ($sign != '') { 
                    if (in_array($petition_id, $sign) === false && $status == '0') { ?>
                        <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('SUPPORT ISSUE', 'petition') ?></button>
                    <?php } else { ?>
                        <button class="ui primary fluid button"><i class="share icon"></i><?php esc_html_e('Share this Issue', 'petition') ?></button>
                <?php   }
                    } else {
                    if ($status == '0') { ?>
                        <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('SUPPORT ISSUE', 'petition') ?></button>
                    <?php } else { ?>
                        <button class="ui primary fluid button"><i class="share icon"></i><?php esc_html_e('Share this Issue', 'petition') ?></button>
                <?php   }
                } ?>
            <?php } else { ?>
                <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('SUPPORT ISSUE', 'petition') ?></button>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if($fb_login && is_user_logged_in()) { ?>
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : <?php echo esc_js($fb_app_id); ?>,
                status     : true,
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
<?php } ?>

<?php get_footer(); ?>