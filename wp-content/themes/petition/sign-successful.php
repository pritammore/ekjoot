<?php
/*
Template Name: Sign Successful
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

$current_user = wp_get_current_user();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

global $post;
global $current_user;
get_header();

    if (isset($_GET['petition_id']) && $_GET['petition_id'] != '') {
        $petition_id = sanitize_text_field($_GET['petition_id']);

        $args = array(
            'p' => $petition_id,
            'post_type' => 'petition',
            'post_status' => array('publish', 'pending')
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $approve = get_post_status($petition_id);
                $gallery = get_post_meta($petition_id, 'petition_gallery', true);
                $images = explode("~~~", $gallery);
                $thumb_id = get_post_thumbnail_id($petition_id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'large', true);
                $title = get_the_title($petition_id);
                $category =  wp_get_post_terms($petition_id, 'petition_category');
                $topics =  wp_get_post_terms($petition_id, 'petition_topics');
                $content = get_the_content($petition_id);
                $excerpt = conikal_get_excerpt_by_id($petition_id);
                $link = get_permalink($petition_id);
                $date = get_the_date('', $petition_id);
                $time = human_time_diff(get_the_time('U', $petition_id), current_time('timestamp'));
                $address = get_post_meta($petition_id, 'petition_address', true);
                $city = get_post_meta($petition_id, 'petition_city', true);
                $state = get_post_meta($petition_id, 'petition_state', true);
                $neighborhood = get_post_meta($petition_id, 'petition_neighborhood', true);
                $zip = get_post_meta($petition_id, 'petition_zip', true);
                $country = get_post_meta($petition_id, 'petition_country', true);
                $lat = get_post_meta($petition_id, 'petition_lat', true);
                $lng = get_post_meta($petition_id, 'petition_lng', true);
                $decisionmakers = get_post_meta($petition_id, 'petition_decisionmakers', true);
                $decisionmakers = array_unique(explode(',', $decisionmakers));
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

                // get form option
                $form_id = get_post_meta($petition_id, 'petition_contribute', true);
                $contribute_approve = get_post_status($form_id);
                if ($contribute_approve === 'pending') {
                    $form_id = '';
                }
                $give_prefix = '_give_';
                $goal_option = get_post_meta($form_id, $give_prefix . 'goal_option', true);
                $set_goal = get_post_meta($form_id, $give_prefix . 'set_goal', true);
                $goal_format = get_post_meta($form_id, $give_prefix . 'goal_format', true);
                $close_form_when_goal_achieved = get_post_meta($form_id, $give_prefix . 'close_form_when_goal_achieved', true);
                $goal_achieved_message = get_post_meta($form_id, $give_prefix . 'form_goal_achieved_message', true);
                $custom_amount_minimum = get_post_meta($form_id, $give_prefix . 'custom_amount_minimum', true);
                $donation_levels = get_post_meta($form_id, $give_prefix . 'donation_levels', true);
                $reveal_label = get_post_meta($form_id, $give_prefix . 'reveal_label', true);
                $form_content = get_post_meta($form_id, $give_prefix . 'form_content', true);
            }
        }
        wp_reset_postdata();
        wp_reset_query();
    } else {
        $petition_id = isset($_GET['petition_id']) ? sanitize_text_field($_GET['petition_id']) : '';
        $link = get_permalink($petition_id);
    }
    $post_author_id = get_post_field( 'post_author', $petition_id );
?>
<?php if ( $petition_id != '' ) { ?>
    <div id="wrapper" class="wrapper read">
		<div class="ui container">
            <div class="ui basic center aligned segment" style="padding-top: 100px;">
                <h1 class="ui icon green header">
                    <i class="circular checkmark icon"></i>
                    <?php _e('You are signed Successfully!' ,'petition') ?>
                </h1>
                <p class="font large">
                    <?php echo sprintf(__('You’re one of %2$s people to sign this petition. Now help find %1$s more people to reach the goal.', 'petition'), conikal_format_number('%!,0i', $goal - $sign_num), conikal_format_number('%!,0i', $sign_num)) ?>
                </p>
            </div>
			<div class="ui centered grid" style="padding-top: 50px; padding-bottom: 20px;">
                <div class="sixteen wide mobile eight wide tablet seven wide computer left aligned column share-column">
                    <!-- FACEBOOK SHARE -->
                    <h2 class="ui header">
                    <i class="dropdown icon"></i>
                    <?php _e('Share on Facebook', 'petition') ?>
                    </h2>
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

                    <div class="ui hidden divider"></div>
                    <!-- SOCIAL SHARE BUTTON -->
                    <div class="ui seven column grid social-share">
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
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($link) ?>&title=<?php echo urlencode($title); ?>"
                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                target="_blank" class="ui basic icon button" id="share-linkedin" data-content="<?php _e('Share on LinkedIn' ,'petition') ?>" data-variation="small" data-position="top center">
                                        <i class="linkedin square icon"></i>
                                    </a>
                        </div>
                        <div class="column">
                            <div class="ui icon top right pointing dropdown basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                                <i class="ellipsis horizontal icon"></i>
                                <div class="menu">
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
                </div>
                <?php if (isset($form_id) && $form_id != '') { ?>
                <div class="sixteen wide mobile eight wide tablet seven wide computer left aligned column contribute-column">
                    <h2 class="ui header">
                    <i class="dropdown icon"></i>
                    <?php echo esc_html($reveal_label) . __(' for Campaign', 'petition') ?>
                    </h2>

                    <?php echo do_shortcode('[give_form id="' . $form_id . '"]') ?>
                </div>
                <?php } ?>
		    </div>
            <div class="ui hidden divider"></div>
            <div class="ui grid">
                <div class="sixteen wide center aligned column">
                    <a href="<?php echo esc_url($link) ?>" class="ui basic large button"><i class="angle left icon"></i><?php _e('Back to Petition', 'petition') ?></a>
                    <a href="<?php echo home_url() ?>" class="ui basic large button"><?php _e('Go to Homepage', 'petition') ?><i class="angle right icon"></i></a>
                </div>
            </div>
		</div>
	</div>
<?php } else { ?>
    <?php get_template_part('404') ?>
<?php } ?>
<?php get_footer(); ?>