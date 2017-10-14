<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$current_user = wp_get_current_user();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$conikal_auth_settings = get_option('conikal_auth_settings','');
$fb_login = isset($conikal_auth_settings['conikal_fb_login_field']) ? $conikal_auth_settings['conikal_fb_login_field'] : false;
$fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';
?>

<div class="wrapper read" style="padding-top: 20px">
    <div class="ui container">
        <div class="ui centered grid">
            <div class="two wide right aligned column computer only">
                <!-- Sticy Menu Share -->
                <div class="ui sticky" id="share-post">
                    <div class="ui icon vertical menu social-share">
                        <a class="item text grey" href="<?php echo esc_url('mailto://?subject=' . esc_html($post->post_title) . '&body=' . esc_url(wp_get_shortlink())) ?>" id="send-mail" data-content="<?php _e('Send an Email' ,'petition') ?>" data-variation="small" data-position="left center">
                            <i class="mail icon"></i>
                        </a>
                        <a class="item text grey send-message" href="javascript:void(0)" data-content="<?php _e('Send a Message' ,'petition') ?>" data-variation="small" data-position="left center">
                            <i class="comment icon"></i>
                        <a class="item text grey share-facebook" href="javascript:void(0)" data-content="<?php _e('Share on Facebook' ,'petition') ?>" data-variation="small" data-position="left center">
                            <i class="facebook f icon"></i>
                        </a>
                        <a class="item text grey" href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="left center">
                            <i class="twitter icon"></i>
                        </a>

                    </div>
                </div>
            </div>
            <div class="sixteen wide mobile sixteen wide tablet ten wide computer left aligned column" id="content">
                
            <?php while(have_posts()) : the_post();
                $post_id = get_the_ID(); 
                $post_title = get_the_title();
                $post_date = get_the_date();
                $post_category = get_the_category();
                $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
                $post_excerpt = get_the_excerpt();
                $post_tags = get_the_tags();
                $post_url = get_permalink();
                $post_view = conikal_format_number('%!,0i', (int) conikal_get_post_views($post_id), true);

                $author_id = get_the_author_meta( 'ID' );
                $author_name = get_the_author();
                $author_bio = get_the_author_meta('description');
                $author_avatar = get_the_author_meta('avatar');
                if($author_avatar != '') {
                    $author_avatar_src = $author_avatar;
                } else {
                    $author_avatar_src = get_template_directory_uri().'/images/avatar.svg';
                }
                $author_avatar_src = conikal_get_avatar_url( $author_id, array('size' => 80, 'default' => $author_avatar_src) );
                $author_address = get_the_author_meta( 'user_address' );
                $author_country = get_the_author_meta( 'user_country' );
                $author_city = get_the_author_meta( 'user_city' );
                $author_state = get_the_author_meta( 'user_state' );
                $author_neighborhood = get_the_author_meta( 'user_neightborhood' );
                $author_post_count = count_user_posts( $author_id );

                $users = get_users();
                $followers = array();
                foreach ($users as $user) {
                    $follow_user = get_user_meta($user->data->ID, 'follow_user', true);
                    if(is_array($follow_user) && in_array($author_id, $follow_user)) {
                        $user_id = $user->ID;
                        $user_name = $user->display_name;
                        $follower = array(  'ID' => $user_id,
                                            'name' => $user_name,
                                        );
                        $follower = (object) $follower;
                        array_push($followers, $follower);
                    }
                }
                $follow_user = get_user_meta($current_user->ID, 'follow_user', true);

                // set view
                conikal_set_post_views($post_id);
                ?>
                <!-- Date and Category -->
                <div class="ui grid">
                    <div class="sixteen wide mobile ten wide tablet ten wide computer column">
                        <p class="font small">
                            <?php echo __('Posted on ', 'petition') . esc_html($post_date) . __(' in ', 'petition') ?>
                            <a class="ui label" href="<?php echo ($post_category ? get_category_link($post_category[0]->term_id) : '') ?>" data-bjax><?php echo esc_html($post_category[0]->name) ?></a>
                            <?php if ($view_counter != '') { ?>
                                <span class="ui label"><i class="eye icon"></i><?php echo esc_html($post_view) . __(' view', 'petition'); ?></span>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="six wide right aligned column tablet computer only">
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                            <img class="ui avatar image" src="<?php echo esc_url($author_avatar_src); ?>" alt="<?php echo esc_attr($author_name); ?>">
                            <span><?php echo esc_html($author_name); ?></span>
                        </a>
                    </div>
                </div>
                <div class="ui divider"></div>

                <!-- Main Content -->
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
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
                <br/>
                <?php if ($post_tags) { ?>
                    <div class="ui labels">
                        <?php foreach($post_tags as $tag) {
                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="ui label" data-bjax>#' . $tag->name . '</a>';
                        } ?>
                    </div>
                <?php } ?>
                <br/>

                <!-- Social Share -->
                <div class="ui grid">
                    <div class="six wide mobile eight wide tablet eight wide computer column">
                        <div class="fb-like" data-href="<?php echo esc_url($post_url) ?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
                    </div>
                    <div class="ten wide mobile eight wide tablet eight wide computer right aligned column social-share">
                        <?php if (wp_is_mobile()) { ?>
                            <a href="<?php echo esc_url('sms://&body=' . $post_title . ' - ' . wp_get_shortlink()) ?>" id="send-sms" class="ui circular basic icon button" data-content="<?php _e('Send an SMS' ,'petition') ?>" data-variation="small" data-position="top center">
                                <i class="comment outline icon"></i>
                            </a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" class="ui circular basic icon button send-message" data-content="<?php _e('Send a Message' ,'petition') ?>" data-variation="small" data-position="top center">
                            <i class="comment outline icon"></i>
                        </a>
                        <?php } ?>
                        <a href="javascript:void(0)" class="ui circular basic icon button share-facebook" data-content="<?php _e('Share on Facebook' ,'petition') ?>" data-variation="small" data-position="top center">
                            <i class="facebook f icon"></i>
                        </a>
                        <a href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="ui circular basic icon button" data-content="<?php _e('Share on Twitter' ,'petition') ?>" data-variation="small" data-position="top center">
                            <i class="twitter icon"></i>
                        </a>
                        <div class="ui icon top right pointing dropdown circular basic icon button more-share" data-content="<?php _e('More social' ,'petition') ?>" data-variation="small" data-position="top center">
                            <i class="ellipsis horizontal icon"></i>
                            <div class="menu">
                                <a href="<?php echo esc_url('mailto://?subject=' . esc_html($post_title) . '&body=' . esc_url(wp_get_shortlink())) ?>" id="send-mail" class="item">
                                    <i class="mail icon"></i><?php esc_html_e('E-mail', 'petition') ?>
                                </a>
                                <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
                            target="_blank" class="item">
                                    <i class="google plus square icon"></i><?php esc_html_e('Google+', 'petition') ?>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="item">
                                    <i class="linkedin square icon"></i><?php esc_html_e('LinkedIn', 'petition') ?>
                                </a>
                                <a href="http://www.tumblr.com/share/link?url=<?php the_permalink(); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="item">
                                    <i class="tumblr square icon"></i><?php esc_html_e('Tumblr', 'petition') ?>
                                </a>
                                <a href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo urlencode($post_image[0]) ?>&url=<?php the_permalink(); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="item">
                                    <i class="pinterest square icon"></i><?php esc_html_e('Pinterest', 'petition') ?>
                                </a>
                                <a href="http://reddit.com/submit?url=<?php the_permalink(); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="item">
                                    <i class="reddit square icon"></i><?php esc_html_e('Reddit', 'petition') ?>
                                </a>
                                <a href="http://wordpress.com/press-this.php?u=<?php the_permalink(); ?>&t=<?php echo urlencode(get_the_title()); ?>&s=<?php echo urlencode($post_excerpt); ?>&i=<?php echo urlencode($post_image[0]) ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" class="item">
                                    <i class="wordpress square icon"></i><?php esc_html_e('WordPress', 'petition') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <!-- Author -->
                <div class="ui divider"></div>
                <div class="ui basic segment">
                    <div class="ui grid">
                        <div class="two wide computer four wide mobile right aligned column">
                            <img class="ui circular bordered tiny image" src="<?php echo esc_url($author_avatar_src); ?>" alt="<?php echo esc_attr($author_name); ?>">
                        </div>
                        <div class="ten wide computer twelve wide mobile column">
                            <h3 class="ui header">
                                <div class="content">
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                                        <?php echo esc_html($author_name); ?>
                                    </a>
                                    <?php if(is_user_logged_in()) {
                                        if (wp_is_mobile()) {
                                            if($follow_user != '') {
                                                if(in_array($author_id, $follow_user) === false) { ?>
                                                    <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui mini icon basic circular button follow-page follow" data-id="<?php echo esc_attr($author_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui mini icon primary circular button follow-page following" data-id="<?php echo esc_attr($author_id); ?>"><i class="checkmark icon"></i><?php _e('Following', 'petition') ?></a>
                                            <?php } 
                                                } else { ?>
                                                <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui mini icon basic circular button follow-page follow" data-id="<?php echo esc_attr($author_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
                                            <?php }
                                        } else { ?>
                                            <span class="font tiny text grey">
                                                <?php echo esc_html( conikal_format_number('%!.0i', count($followers), true) ) . ' ' . esc_html('followers', 'petition') . ' · ' . conikal_format_number('%!.0i', esc_html($author_post_count), true) . ' ' . esc_html('posts', 'petition'); ?>
                                            </span>
                                        <?php }
                                    } ?>
                                    
                                    <div class="sub header">
                                        <p class="text grey"><?php echo esc_html($author_bio) ?></p>
                                    </div>
                                </div>
                            </h3>
                        </div>
                        <div class="four wide right aligned column computer only">
                            <?php if(is_user_logged_in()) {
                                if($follow_user != '') {
                                    if(in_array($author_id, $follow_user) === false) { ?>
                                        <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui tiny basic circular button follow-page follow" data-id="<?php echo esc_attr($author_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui tiny primary circular button follow-page following" data-id="<?php echo esc_attr($author_id); ?>"><i class="checkmark icon"></i><?php _e('Following', 'petition') ?></a>
                                <?php } 
                                    } else { ?>
                                    <a href="javascript:void(0)" id="follow-user-<?php echo esc_attr($author_id); ?>" class="ui tiny basic circular button follow-page follow" data-id="<?php echo esc_attr($author_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
                                <?php }
                                wp_nonce_field('follow_ajax_nonce', 'securityFollow', true);
                            } ?>
                        </div>
                    </div>
                </div>

                <!-- Paningation -->
                <?php $prev_post = get_previous_post();
                $next_post = get_next_post(); ?>

                <div class="f-pn-articles">
                    <a href="<?php if (!empty( $prev_post )): echo esc_url(get_permalink( $prev_post->ID )); endif; ?>" class="f-p-article">
                        <?php if (!empty( $prev_post )): ?>
                        <div class="fpna-title"><?php esc_html_e('Previous post', 'petition') ?></div>
                        <span class="fpna-header"><?php echo esc_html($prev_post->post_title); ?></span>
                        <span class="pn-icon"><i class="angle left icon"></i></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php if (!empty( $next_post )): echo esc_url(get_permalink( $next_post->ID )); endif; ?>" class="f-n-article">
                        <?php if (!empty( $next_post )): ?>
                        <div class="fpna-title"><?php esc_html_e('Next post', 'petition') ?></div>
                        <span class="fpna-header"><?php echo esc_html($next_post->post_title); ?></span>
                        <span class="pn-icon"><i class="angle right icon"></i></span>
                        <?php endif; ?>
                    </a>
                    <div class="clearfix"></div>
                </div>


                <!-- Comment -->
                <?php if(comments_open()) {
                    comments_template();
                }
            endwhile; ?>
            </div>
        </div>
    </div>
</div>
<div class="ui container">
    <?php
        $related = isset($conikal_appearance_settings['conikal_related_field']) ? $conikal_appearance_settings['conikal_related_field'] : false;
        if($related) { ?>
        <div class="ui basic vertical segment">
            <?php get_template_part('templates/related_posts'); ?>
        </div>
    <?php } ?>
</div>

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