<?php
/*
Template Name: All Issues
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

get_header();
$current_user = wp_get_current_user();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
$posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$newsfeed_petitions = conikal_newsfeed_petitions($current_user->ID, 1);
if ( !is_user_logged_in() ) {
    $newsfeed_petitions = conikal_featured_petitions();
}
$recently_petitions = conikal_recent_petitions();
$trending_petitions = conikal_trending_petitions();
$users = get_users();
?>
<!-- <div id="wrapper" class="wrapper read">
<div class="ui container mobile">
    <div class="page-content"> -->
<br/><br/><br/>
<div class="ui container mobile-full">
    <div class="ui grid">    
    <br/>
    <div class="ui grid mobile-full">
        <?php if($sidebar_position == 'left') { ?>
        <div class="five wide column computer only">
            <?php get_sidebar(); ?>
        </div>
        <?php } ?>

        <div class="sixteen wide mobile sixteen wide computer column">
            <div class="ui hidden divider"></div>
            <div class="field left"><h3 class="ui header widget-title">Support an Issue. Enter the Unique Issue Code here.</h3></div>
            <!-- <div class="ui hidden divider"></div> -->
            <div class="ui fluid category search petitions-search focus">
                <div class="ui icon fluid input">
                  <input class="prompt search-input" type="text" placeholder="<?php esc_html_e('UIC Code / Title / Catergory', 'petition') ?>">
                  <i class="search link icon"></i>
                </div>
            </div>
            <!-- <div class="ui hidden divider"></div> -->
        </div>

        <div class="sixteen wide mobile eleven wide computer column mobile-full" id="main-content">
            <div class="ui sticky" id="tab-sticky" style="margin-top: 0px;">
                <div class="ui pointing secondary menu" id="petition-tab">
                    <a class="item active" data-tab="newsfeed" id="newsfeed"><?php echo ( !is_user_logged_in() ? '<i class="fire icon"></i>' . __('Featured', 'petition') : '<i class="newspaper icon"></i>' . __('Feed', 'petition') ) ?></a>
                    <a class="item" data-tab="trending" id="trending"><i class="lightning icon"></i><?php _e('Trending', 'petition') ?></a>
                    <a class="item" data-tab="recent" id="recent"><i class="wait icon"></i><?php _e('Recent', 'petition') ?></a>
                </div>
            </div>
            <br/>
            <div class="ui tab active" data-tab="newsfeed">
                <div id="content">
                <!-- PUPULAR PETITION -->
                <?php
                if($newsfeed_petitions->post_count) {
                    foreach ( $newsfeed_petitions->posts as $post ) {
                        $id = $post->ID;
                        $link = get_permalink($id);
                        $title = get_the_title($id);
                        $author_id = $post->post_author;
                        $author_name = get_the_author_meta('display_name', $author_id);
                        $author_link = get_author_posts_url( $author_id );
                        $category =  wp_get_post_terms($id, 'petition_category', true);
                        $excerpt = conikal_get_excerpt_by_id($id);
                        $comments = wp_count_comments($id);
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
                        $updates = get_post_meta($id, 'petition_update', true);
                        $thumb = get_post_meta($id, 'petition_thumb', true);
                        $thumb = conikal_video_thumbnail($thumb);
                        $status = get_post_meta($id, 'petition_status', true);
                        $petition_uic = get_post_meta($id, 'petition_uic', true);

                        $user_avatar = get_the_author_meta('avatar' , $author_id);
                        if($user_avatar != '') {
                            $avatar = $user_avatar;
                        } else {
                            $avatar = get_template_directory_uri().'/images/avatar.svg';
                        }
                        $avatar = conikal_get_avatar_url( $author_id, array('size' => 28, 'default' => $avatar) );

                        if(has_post_thumbnail($id)) {
                            $thumb_id = get_post_thumbnail_id($id);
                            $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                            $thumbnail = $thumbnail[0];
                        } elseif ($gallery) {
                            $thumbnail = $images[1];
                        } elseif ($thumb) {
                            $thumbnail = $thumb;
                        } else {
                            $thumbnail = get_template_directory_uri() . '/images/thumbnail.svg';
                        }
                    ?>
                    <div class="ui segments petition-list-card">
                        <div class="ui segment">
                            <?php /*if ($sign >= $goal || $status == '1') { ?>
                                <span class="ui primary right corner large label victory-label">
                                        <i class="flag icon"></i>
                                </span>
                            <?php }*/ ?>
                            <div class="ui grid">
                                <div class="sixteen wide mobile ten wide tablet ten wide computer column">
                                    <div class="petition-content">
                                        <div class="ui grid">
                                            <div class="sixteen wide column">
                                                <div class="ui header list-petition-title">
                                                    <div class="content">
                                                        <?php if($petition_uic != "") { ?>
                                                        <div class="sub header"><a class="ui orange button label small" style="margin-left: 0px;" href="<?php echo esc_url($link) ?>" data-bjax><i class="filter icon"></i> <?php echo esc_html($petition_uic) ?></a>
                                                        </div>
                                                        <?php } ?>
                                                        <a href="<?php echo esc_url($link) ?>" data-bjax><?php echo esc_html($title) ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">
                                                <div class="text grey"><?php echo esc_html($excerpt) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui grid">
                                        <div class="petition-footer">
                                            <div class="sixteen wide column">
                                                <?php if ($country || $state || $city) { ?>
                                                <span class="text grey place"><i class="marker icon"></i><?php echo ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></span>
                                                <?php } ?>
                                                <div class="ui tiny indicating primary progress petition-goal" data-value="<?php echo esc_html($sign) ?>" data-total="<?php echo ($status == '1' ? esc_html($sign) : esc_html($goal) ) ?>">
                                                    <div class="bar">
                                                        <div class="progress"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sixteen wide mobile six wide tablet six wide computer column">
                                    <a class="ui fluid image" href="<?php echo esc_url($link) ?>" target="_blank" data-bjax>
                                        <div class="ui dimmer">
                                            <div class="content">
                                              <div class="center">
                                                <div class="ui icon inverted circular large button"><i class="external icon"></i></div>
                                              </div>
                                            </div>
                                        </div>
                                        <img class="ui fluid image" src="<?php echo esc_url($thumbnail) ?>" alt="<?php echo esc_attr($title) ?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">
                            <div class="ui grid">
                                <div class="ten wide tablet ten wide computer column tablet computer only">
                                    <span class="ui primary label">
                                    <i class="user icon"></i><?php echo conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') ?>
                                    </span>
                                    <span class="ui label">
                                        <i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition'); ?>
                                    </span>
                                    <?php if($category) { ?>
                                        <a class="ui label" href="<?php echo get_category_link($category[0]->term_id) ?>" data-bjax>
                                            <i class="tag icon"></i><?php echo esc_html($category[0]->name); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="six wide tablet six wide computer right aligned column tablet computer only">
                                    <a href="<?php echo esc_url($author_link); ?>" data-bjax>
                                        <strong><?php echo esc_html($author_name) ?></strong>
                                        <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php //echo esc_attr($author_name) ?>" />
                                    </a>
                                </div>

                                <div class="thirteen wide column mobile only">
                                    <span class="ui primary label">
                                        <i class="user icon"></i><?php echo conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') ?>
                                    </span>
                                    <span class="ui label">
                                        <i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved, true); ?>
                                    </span>
                                </div>
                                <div class="three wide right aligned column mobile only">
                                    <a href="<?php echo esc_url($author_link); ?>" data-bjax>
                                        <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php echo esc_attr($author_name) ?>" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    } else {
                        print '<div class="not-found" id="content">';
                        print '<div class="ui warning message">' . __('No petitions found.', 'petition') . '</div>';
                        print '</div>';
                    }
                    ?>
                </div>
                <br/>
                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-more" data-page="2" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="<?php echo ( !is_user_logged_in() ? 'conikal_load_featured_petitions' : 'conikal_load_newsfeed_petitions' ) ?>"><i class="long arrow down icon"></i><?php echo __('Load more...', 'petition'); ?></button>
            </div>
            <div class="ui tab" data-tab="trending">
                <div id="content-trending">
                </div>
                <br/>
                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-trending" data-page="1" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="conikal_load_trending_petitions"><i class="long arrow down icon"></i><?php echo __('Load more...', 'petition'); ?></button>
            </div>
            <div class="ui tab" data-tab="recent">
                <div id="content-recent">
                </div>
                <br/>
                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-recent" data-page="1" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="conikal_load_recent_petitions"><i class="long arrow down icon"></i><?php echo __('Load more...', 'petition'); ?></button>
            </div>
        </div>
        <?php wp_nonce_field('load_petitions_ajax_nonce', 'securityPetitions', true); ?>
        <!-- SIDEBAR RIGHT -->
        <?php if($sidebar_position == 'right') { ?>
        <div class="five wide column computer only">
            <?php get_sidebar(); ?>
        </div>
        <?php } ?>
    </div>
</div>

<!-- </div>
</div>
</div> -->
<?php get_footer(); ?>