<?php
/*
Template Name: Petition Signed
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
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
$posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
$signed_posts = conikal_signed_petitions($current_user->ID);
if($signed_posts) {
    $total_p = $signed_posts->found_posts;
} else {
    $total_p = 0;
}
$users = get_users();
?>

<div class="ui container mobile mobile-full">
    <?php if($show_bc != '') {
        conikal_petition_breadcrumbs();
    } else {
        print '<br/>';
    } ?>
    <div class="page-content">
        <div class="ui grid mobile-full">
            <?php if($sidebar_position == 'left') { ?>
            <div class="five wide column computer only">
                <?php get_sidebar(); ?>
            </div>
            <?php } ?>
            <div class="sixteen wide mobile eleven wide computer column mobile-full">
            <?php if($signed_posts != false) { ?>
                <div id="content">
                    <?php while ( $signed_posts->have_posts() ) {
                        $signed_posts->the_post();
                        $id = get_the_ID();
                        $link = get_permalink($id);
                        $title = get_the_title($id);
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

                        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
                        if($user_avatar != '') {
                            $avatar = $user_avatar;
                        } else {
                            $avatar = get_template_directory_uri().'/images/avatar.svg';
                        }
                        $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );
                    ?>
                    <div class="ui segments">
                        <div class="ui segment">
                            <?php if ($sign >= $goal || $status == '1') { ?>
                                <div class="ui primary right corner large label victory-label">
                                        <i class="flag icon"></i>
                                </div>
                            <?php } ?>
                            <div class="ui grid">
                                <div class="sixteen wide mobile ten wide tablet ten wide computer column">
                                    <div class="petition-content">
                                        <div class="ui grid">
                                            <div class="sixteen wide column">
                                                <div class="ui header list-petition-title">
                                                    <div class="content">
                                                        <div class="sub header truncate"><i class="send icon"></i><?php esc_html_e('Petition to', 'petition') ?> <?php echo esc_html($receiver[0]) ?></div>
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
                                                <span class="text grey"><i class="marker icon"></i><?php echo ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></span>
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
                                    <a class="ui fluid image" href="<?php echo esc_url($link) ?>" data-bjax>
                                        <?php if(has_post_thumbnail()) { ?>
                                            <img class="ui fluid image" src="<?php echo esc_url(the_post_thumbnail_url('petition-thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                        <?php } elseif ($gallery) { ?>
                                            <img class="ui fluid image" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                        <?php } elseif ($thumb) { ?>
                                            <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                        <?php } else { ?>
                                            <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
                                        <?php } ?>
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
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                                        <strong><?php the_author() ?></strong>
                                        <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
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
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                                        <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <br/>

                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-more" data-page="2" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="conikal_load_signed_petitions"><i class="long arrow down icon"></i><?php echo __('Load more...', 'petition'); ?></button>
                <?php } else {
                    print '<div class="not-found" id="content">';
                    print '<div class="ui warning message">' . __('No petitions found.', 'petition') . '</div>';
                    print '</div>';
                }
                wp_reset_query();
                ?>
                <?php wp_nonce_field('load_petitions_ajax_nonce', 'securityPetitions', true); ?>
            </div>
            <?php if($sidebar_position == 'right') { ?>
            <div class="five wide column computer only">
                <?php get_sidebar(); ?>
            </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>