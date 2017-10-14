<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
global $current_user;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';
$posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
$copyright = isset($conikal_appearance_settings['conikal_copyright_field']) ? $conikal_appearance_settings['conikal_copyright_field'] : '';
$posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;

?>


<div class="ui container mobile-full">
    <?php if($show_bc != '') {
        conikal_petition_breadcrumbs();
    } else {
        print '<br/>';
    } ?>
    <div class="page content">
    <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

    <?php 
        $author_petitions = conikal_author_petitions($curauth->ID);

        if($author_petitions) {
            $total_p = $author_petitions->found_posts;
        } else {
            $total_p = 0;
        }
    ?>

    <?php
        $users = get_users();
        $following = $curauth->follow_user;
        $followers = array();
        foreach ($users as $user) {
            $follow_user = get_user_meta($user->data->ID, 'follow_user', true);
            if(is_array($follow_user) && in_array($curauth->ID, $follow_user)) {
                $user_id = $user->ID;
                $user_name = $user->display_name;
                $user_avatar = $user->avatar;
                if (!$user_avatar) {
                    $user_avatar = get_template_directory_uri().'/images/avatar.svg';
                }
                $user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $user_avatar) );
                $follower = array(  'ID' => $user_id,
                                    'name' => $user_name,
                                    'avatar' => $user_avatar
                                );
                $follower = (object) $follower;
                array_push($followers, $follower);
            }
        }
    ?>
    <div class="ui grid mobile-full">
        <!-- RIGHT SIDEBAR -->
        <?php if( !wp_is_mobile() ) { ?>
            <div class="five wide column computer only">
                <div class="ui sticky" id="about-sticky">
                    <div class="ui segment">
                        <div class="ui header"><?php esc_html_e('About', 'petition') ?></div>
                        <?php echo ($curauth->description) ? esc_html($curauth->description) : ''; ?>
                        <div class="ui list">
                            <?php if ($curauth->user_country || $curauth->user_state || $curauth->user_city) { ?>
                                <div class="item"><i class="marker icon"></i>
                                    <div class="content">
                                    <?php echo ($curauth->user_city ? esc_html($curauth->user_city . ', ') : '') . ($curauth->user_state ? esc_html($curauth->user_state . ', ') : '') . ($curauth->user_country ? esc_html($curauth->user_country) : '') ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($curauth->user_url) { ?>
                                <div class="item"><i class="linkify icon" style="float: left;"></i>
                                    <div class="content truncate">
                                    <a target="_blank" href="<?php echo esc_url($curauth->user_url) ?>"><?php echo esc_html($curauth->user_url) ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($curauth->user_birthday) { ?>
                                <div class="item"><i class="birthday icon"></i>
                                    <div class="content">
                                    <?php echo esc_html('Born on ', 'petition') . esc_html( date('d F Y', strtotime($curauth->user_birthday)) ) ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="item"><i class="calendar outline icon"></i>
                                <div class="content">
                                <?php echo esc_html('Joined ', 'petition') . esc_html( date('d F Y', strtotime($curauth->user_registered)) ) ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($followers) { ?>
                            <div class="ui divider"></div>
                            <p style="font-weight: bold"><?php esc_html_e('Who is following?', 'petition') ?></p>
                            <div class="ui mini images">
                            <?php
                                $i = 1;
                                foreach ($followers as $follower) : 
                                    if ($i <= 14) {
                            ?>
                                <a class="ui bordered image" href="<?php echo get_author_posts_url($follower->ID) ?>">
                                    <img src="<?php echo esc_url($follower->avatar) ?>" alt="<?php echo esc_attr($follower->name) ?>" />
                                </a>
                            <?php   }
                                $i++;
                            endforeach; ?>
                            </div>
                        <?php } ?>
                        <div class="ui divider"></div>
                        <div class="ui mini three statistics">
                            <div class="statistic">
                                <div class="value">
                                    <?php echo esc_html( conikal_format_number('%!.0i', $total_p, true) ); ?>
                                </div>
                                <div class="label" style="font-size: 11px;"><?php esc_html_e('Petitions', 'petition') ?></div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <?php echo esc_html( conikal_format_number('%!.0i', count($followers), true) ); ?>
                                </div>
                                <div class="label" style="font-size: 11px;"><?php esc_html_e('Followers', 'petition') ?></div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <?php echo esc_html( conikal_format_number('%!.0i', count($following), true) ); ?>
                                </div>
                                <div class="label" style="font-size: 11px;"><?php esc_html_e('Following', 'petition') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="ui text small right menu">
                            <?php conikal_custom_menu('footer') ?>
                    </div>
                    <?php if($copyright && $copyright != '') { ?>
                        <div class="copyright"><?php echo esc_html($copyright); ?></div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="sixteen wide column mobile tablet only mobile-full">
                <div class="ui segment">
                    <div class="ui header"><?php esc_html_e('About', 'petition') ?></div>
                    <?php echo ($curauth->description) ? esc_html($curauth->description) : ''; ?>
                    <div class="ui list">
                        <?php if ($curauth->user_country || $curauth->user_state || $curauth->user_city) { ?>
                            <div class="item"><i class="marker icon"></i>
                                <div class="content">
                                <?php echo ($curauth->user_city ? esc_html($curauth->user_city . ', ') : '') . ($curauth->user_state ? esc_html($curauth->user_state . ', ') : '') . ($curauth->user_country ? esc_html($curauth->user_country) : '') ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($curauth->user_url) { ?>
                            <div class="item"><i class="linkify icon" style="float: left;"></i>
                                <div class="content truncate">
                                <a target="_blank" href="<?php echo esc_attr($curauth->user_url) ?>"><?php echo esc_html($curauth->user_url) ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($curauth->user_birthday) { ?>
                            <div class="item"><i class="birthday icon"></i>
                                <div class="content">
                                <?php echo esc_html('Born on ', 'petition') . esc_html( date('d F Y', strtotime($curauth->user_birthday)) ) ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="item"><i class="calendar outline icon"></i>
                            <div class="content">
                            <?php echo esc_html('Joined ', 'petition') . esc_html( date('d F Y', strtotime($curauth->user_registered)) ) ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($followers) { ?>
                        <div class="ui divider"></div>
                        <p style="font-weight: bold"><?php esc_html_e('Who is following?', 'petition') ?></p>
                        <div class="ui mini images">
                        <?php
                            $i = 1;
                            foreach ($followers as $follower) : 
                                if ($i <= 14) {
                        ?>
                            <a class="ui bordered image" href="<?php echo get_author_posts_url($follower->ID) ?>">
                                <img src="<?php echo esc_url($follower->avatar) ?>" alt="<?php echo esc_attr($follower->name) ?>" />
                            </a>
                        <?php   }
                            $i++;
                        endforeach; ?>
                        </div>
                    <?php } ?>
                    <div class="ui divider"></div>
                    <div class="ui mini three statistics">
                        <div class="statistic">
                            <div class="value">
                                <?php echo esc_html( conikal_format_number('%!.0i', $total_p, true) ); ?>
                            </div>
                            <div class="label" style="font-size: 11px;"><?php esc_html_e('Petitions', 'petition') ?></div>
                        </div>
                        <div class="statistic">
                            <div class="value">
                                <?php echo esc_html( conikal_format_number('%!.0i', count($followers), true) ); ?>
                            </div>
                            <div class="label" style="font-size: 11px;"><?php esc_html_e('Followers', 'petition') ?></div>
                        </div>
                        <div class="statistic">
                            <div class="value">
                                <?php echo esc_html( conikal_format_number('%!.0i', count($following), true) ); ?>
                            </div>
                            <div class="label" style="font-size: 11px;"><?php esc_html_e('Following', 'petition') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="sixteen wide mobile eleven wide computer column mobile-full">
        <?php if($author_petitions->have_posts()) { ?>
            <div id="content">
                <?php while( $author_petitions->have_posts() ) {
                    $author_petitions->the_post();
                    $id = get_the_ID();
                    $link = get_permalink($id);
                    $title = get_the_title($id);
                    $category =  wp_get_post_terms($id, 'petition_category', true);
                    $excerpt = conikal_get_excerpt_by_id($id);
                    $comments = wp_count_comments($id);
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
                    $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $avatar) );
                ?>
                <div class="ui segments petition-list-card">
                    <div class="ui segment">
                        <?php if ($sign >= $goal || $status == '1') { ?>
                            <div class="ui primary right corner large label victory-label">
                                <?php echo conikal_custom_icon('victory') ?>
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
                                <a class="ui fluid image blurring" href="<?php echo esc_url($link) ?>" target="_blank" data-bjax>
                                    <div class="ui dimmer">
                                        <div class="content">
                                            <div class="center">
                                                <div class="ui icon inverted circular large button"><i class="external icon"></i></div>
                                            </div>
                                            <div class="view-counter">
                                            <?php if ($view_counter != '') { ?>
                                                <i class="eye icon"></i>
                                                <?php echo esc_html($view); ?>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
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
                                    <?php echo conikal_custom_icon('supporter') ?><?php echo esc_html(conikal_format_number('%!,0i', $sign)) . ' ' . __('supporters', 'petition') ?>
                                </span>
                                <span class="ui label">
                                    <i class="comments icon"></i><?php echo esc_html(conikal_format_number('%!,0i', $comments->approved, true)) . ' ' . __('comments', 'petition'); ?>
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
                                    <?php echo conikal_custom_icon('supporter') ?><?php echo esc_html(conikal_format_number('%!,0i', $sign, true)) . ' ' . __('supporters', 'petition') ?>
                                </span>
                                <span class="ui label">
                                    <i class="comments icon"></i><?php echo esc_html(conikal_format_number('%!,0i', $comments->approved, true)); ?>
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
            <button class="ui basic fluid large button" id="load-more" data-page="2" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($curauth->ID) ?>" data-type="conikal_load_author_petitions"><i class="long arrow down icon"></i><?php _e('Load more...', 'petition'); ?></button>     
            <?php } else {
                print '<div class="not-found" id="content">';
                print '<div class="ui warning message">' . __('No petitions found.', 'petition') . '</div>';
                print '</div>';
            }
            wp_reset_query();
            ?>
            <?php wp_nonce_field('load_petitions_ajax_nonce', 'securityPetitions', true); ?>
        </div>
    </div>
    </div>
</div>

<?php get_footer(); ?>