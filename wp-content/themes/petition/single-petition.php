<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


get_header();
global $post;
global $current_user;
$current_user = wp_get_current_user();
$conikal_general_settings = get_option('conikal_general_settings','');
$conikal_auth_settings = get_option('conikal_auth_settings','');
$fb_login = isset($conikal_auth_settings['conikal_fb_login_field']) ? $conikal_auth_settings['conikal_fb_login_field'] : false;
$fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
$minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$comments_per_page_setting = isset($conikal_appearance_settings['conikal_comments_per_page_field']) ? $conikal_appearance_settings['conikal_comments_per_page_field'] : '';
$comments_per_page = $comments_per_page_setting != '' ? $comments_per_page_setting : 10;
$reply_per_comment_setting = isset($conikal_appearance_settings['conikal_reply_per_comment_field']) ? $conikal_appearance_settings['conikal_reply_per_comment_field'] : '';
$reply_per_comment = $reply_per_comment_setting != '' ? $reply_per_comment_setting : 3;
?>

<?php while(have_posts()) : the_post();
    $petition_id = get_the_ID();
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
    $conikal_general_settings = get_option('conikal_general_settings');
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
    $approvedleaders = get_post_meta($petition_id, 'lp_post_ids', true );
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

    conikal_set_post_views($petition_id);

    $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
    if($user_avatar != '') {
        $avatar = $user_avatar;
    } else {
        $avatar = get_template_directory_uri().'/images/avatar.svg';
    }
    $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $avatar) );

    $user = wp_get_current_user();
    // delete_user_meta($user->ID, 'petition_sign');
    $sign = get_user_meta($user->ID, 'petition_sign', true);
    $bookmarks = get_user_meta($user->ID, 'petition_bookmark', true);
    $users = get_users();
    $signs = 0;

    foreach ($users as $user) {
        $user_sign = get_user_meta($user->data->ID, 'petition_sign', true);
        if(is_array($user_sign) && in_array($petition_id, $user_sign)) {
            $signs = $signs + 1;
        }
    }

    $current_user_avatar = $current_user->avatar;
    if (!$current_user_avatar) {
        $current_user_avatar = get_template_directory_uri().'/images/avatar.svg';
    }
    $current_user_avatar = conikal_get_avatar_url( $current_user->ID, array('size' => 35, 'default' => $current_user_avatar) );
?>

<div id="wrapper" class="wrapper read">
    <?php if ( get_the_author_meta('ID') == $current_user->ID || current_user_can('administrator') || (!empty($approvedleaders) && in_array($current_user->ID, $approvedleaders)) ) { ?>
        <div class="color silver">
            <div class="ui large secondary pointing grey menu" id="control-menu">
                <div class="ui container">
                        <a href="javascript:void(0)" class="active item" data-bjax><?php _e('Campaign', 'petition') ?></a>
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'dashboard-petition.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id) . '?edit_id=' . $petition_id;
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Dashboard', 'petition') ?></a>
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'add-update.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id) . '?petition_id=' . $petition_id . '&type=update';
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Update', 'petition') ?></a>
                        <?php
                            $args = array(
                                'post_type' => 'page',
                                'post_status' => 'publish',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'edit-petition.php'
                            );

                            $query = new WP_Query($args);

                            while($query->have_posts()) {
                                $query->the_post();
                                $page_id = get_the_ID();
                                $page_link = get_permalink($page_id) . '?edit_id=' . $petition_id;
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <?php if ( get_the_author_meta('ID') == $current_user->ID || current_user_can('administrator')) { ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                        <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="ui container">
        <?php if ($approve == 'pending' || $sign_num < $minimum_signature) { ?>
            <!-- ALERT PEITITION -->
            <div class="ui basic segment">
            <?php if ($approve == 'pending') { ?>
                <div class="ui large warning message">
                    <i class="warning icon"></i>
                    <?php _e('Petition is pending approval!', 'petition') ?>
                </div>
            <?php } ?>
            <?php if ($sign_num < $minimum_signature) { ?>
                <div class="ui large warning message">
                    <i class="warning icon"></i>
                    <?php echo __('Getting to', 'petition') . ' <strong>' . $minimum_signature . '</strong> ' . __('signatures makes your petition visible to the whole community', 'petition'); ?>
                </div>
            <?php } ?>
            </div>
        <?php } ?>
        <div class="ui hidden divider"></div>

        <!-- TITLE AND AUTHOR OF PETITION -->
        <div class="ui basic padded vertical segment petition-title-block">
            <div class="ui left aligned header petition-title">
                <div class="content">
                    <div class="sub header"><i class="filter icon"></i><?php _e('UIC', 'petition') ?> <strong><?php echo esc_html($uic) ?></strong></div>
                    <?php echo esc_html($title) ?>
                </div>
            </div>
            <div class="ui center aligned small header">
                <div class="sub header">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                        <img src="<?php echo esc_url($avatar); ?>" class="ui avatar bordered image" alt="<?php the_author(); ?>">
                        <strong><?php the_author(); ?></strong>
                    </a>
                    <?php if ($user_country || $user_state || $user_city) { ?>
                    <span class="text grey"><?php echo ' · ' . ($user_city ? esc_html($user_city) . ', ' : '') . ($user_state ? esc_html($user_state) . ', ' : '') . ($user_country ? esc_html($user_country) : '') ?></span>
                    <?php } ?>
                    <?php //echo $petition_id; ?>
                </div>
            </div>
        </div>

        <div class="ui grid">
            <div class="sixteen wide mobile ten wide tablet ten wide computer column" id="content">

                <!-- MENU NAVIGATION -->
                <?php if (!wp_is_mobile()) { ?>
                <br/>
                <div class="ui sticky" id="navigation-sticky">
                    <div class="ui pointing secondary menu" id="navigation-menu">
                        <a href="#story" class="item active"><?php _e('Story', 'petition') ?></a>
                        <a href="#letter" class="item"><?php _e('Letter', 'petition') ?></a>
                        <a href="#updates" class="item"><?php _e('Updates', 'petition') ?></a>
                        <a href="#comments-list" class="item"><?php _e('Comments', 'petition') ?></a>
                    </div>
                </div>
                <?php } ?>

                <!-- PETITION CONTENT -->
                <div id="main-petition">
                    <div class="ui basic vertical segment" id="story">
                        <!-- THUMBNAIL OF PETITION -->
                        <?php
                            if ($gallery) { 
                                if (has_post_thumbnail()) { ?>
                                <img class="ui fluid image" src="<?php echo esc_url($thumbnail[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($gallery) { ?>
                                <img class="ui fluid image" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } ?>
                            <?php } elseif ($video) { ?>
                                <div class="ui embed" id="media-embed"></div>
                                <input type="hidden" id="video-url" value="<?php echo esc_url($video) ?>">
                                <?php if (!wp_is_mobile()) { ?>
                                    <input type="hidden" id="thumb-url" value="<?php echo esc_url($thumb_placeholder) ?>">
                                <?php } ?>
                            <?php } else { ?>
                                <img class="ui fluid bordered image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
                        <?php } ?>

                        <!-- LOCATION AND BOOKMARK BUTTON -->
                        <div class="ui basic vertical segment">
                            <div class="ui grid">
                                <div class="eleven wide column" style="padding-right: 0">
                                    <?php if ($country || $state || $city) { ?>
                                        <div class="truncate text grey"><i class="marker icon"></i><?php echo ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="five wide right aligned column" style="padding-left: 0">
                                    <?php
                                        if($bookmarks) {
                                            if(is_user_logged_in()) {
                                                if(in_array($petition_id, $bookmarks) === false) {
                                                    print '<a href="javascript:void(0)" class="bookmarkPetition" id="bookmarkBtn"><i class="remove bookmark icon"></i>' . esc_html('Bookmark', 'petition') . '</a>';
                                                } else {
                                                    print '<a href="javascript:void(0)" class="bookmarkedPetition" id="bookmarkBtn"><i class="bookmark icon"></i>' . esc_html('Bookmark', 'petition') . '</a>';
                                                }
                                            } else {
                                                print '<a href="javascript:void(0)" class="signin-btn"><i class="remove bookmark icon"></i>' . esc_html('Bookmark', 'petition') . '</a>';
                                            }
                                        } else {
                                            if(is_user_logged_in()) {
                                                print '<a href="javascript:void(0)" class="bookmarkPetition" id="bookmarkBtn"><i class="remove bookmark icon"></i>' . esc_html('Bookmark', 'petition') . '</a>';
                                            } else {
                                                print '<a href="javascript:void(0)" class="signin-btn"><i class="remove bookmark icon"></i>' . esc_html('Bookmark', 'petition') . '</a>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php wp_nonce_field('bookmark_ajax_nonce', 'securityBookmark', true); ?>
                        </div>

                        <!-- MAIN CONTENT PETITION -->
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="entry-content">
                                <?php the_content(); ?>         <!-- Here is the main content of the post. Add Show more link -->
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
                        <div class="ui hidden divider"></div>
                        <div class="ui right floated tiny header"><?php echo esc_html($date) ?></div>
                        <?php if ($topics) { ?>
                            <div class="ui labels">
                                <?php foreach($topics as $topic) {
                                    echo '<a href="' . get_tag_link($topic->term_id) . '" class="ui label" data-bjax>' . $topic->name . '</a>';
                                } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- LETTER TO -->
                    <!-- <div class="ui piled segment" id="letter">
                        <div class="ui grid">
                            <div class="twelve wide column">
                                <div class="letter-title text grey"><?php //_e('Letter to', 'petition') ?></div>
                            </div>
                            <div class="four wide right aligned column">
                                <div class="letter-title text grey">
                                    <?php /*if ( get_the_author_meta( 'ID' ) == $current_user->ID || current_user_can('administrator') ) { ?>
                                    <a href="javascript:void(0)" class="font medium" id="edit-letter"><i class="pencil icon"></i></a == true>
                                    <?php }*/ ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                        /*for ($i=0; $i < count($receiver); $i++) { 
                            if ($receiver[$i]) {
                                echo '<div class="text grey font medium letter">' . ($position[$i] ? $position[$i] . ', ' : '') . '<strong>' . $receiver[$i] . '</strong></div>';
                            }
                        }*/
                        ?>
                        <div class="ui hidden divider"></div>
                        <div class="font letter medium" id="content-letter"><?php //echo ( $letter ? esc_html($letter) : esc_html($title) ) ?></div>
                        <div class="ui basic segment">
                            <button class="ui primary button" id="save-letter" style="display: none"><?php //_e('Save', 'petition') ?></button>
                        </div>
                        <div id="letter-response"></div>
                        <?php //wp_nonce_field('letter_ajax_nonce', 'securityLetter', true); ?>
                    </div> -->

                    <!-- UPDATES -->
                    <div id="updates">
                    <h3 class="ui dividing header"><?php _e('Updates', 'petition') ?></h3>
                    <?php if ( get_the_author_meta( 'ID' ) == $current_user->ID || current_user_can('editor') || current_user_can('administrator') || in_array($current_user->ID, $decisionmakers) && is_user_logged_in() ) { ?>
                        <div class="ui secondary segment">
                            <div class="ui grid">
                                <div class="sixteen wide mobile six wide tablet four wide computer column">
                                    <?php
                                        $args = array(
                                            'post_type' => 'page',
                                            'post_status' => 'publish',
                                            'meta_key' => '_wp_page_template',
                                            'meta_value' => 'add-update.php'
                                        );

                                        $query = new WP_Query($args);

                                        while($query->have_posts()) {
                                            $query->the_post();
                                            $page_id = get_the_ID();
                                            $page_link = get_permalink($page_id) . '?petition_id=' . $petition_id . (in_array($current_user->ID, $decisionmakers) && !current_user_can('editor') && !current_user_can('administrator') ? '&type=responsive' : '&type=update');
                                        }
                                        wp_reset_postdata();
                                        wp_reset_query();
                                    ?>
                                    <a class="ui large primary fluid button" href="<?php echo ($page_link ? $page_link : '') ?>" data-bjax>
                                        <?php (in_array($current_user->ID, $decisionmakers) && !current_user_can('editor') && !current_user_can('administrator') ? _e('Response', 'petition') : _e('Post Update', 'petition')) ?>        
                                    </a>
                                </div>
                                <div class="sixteen wide mobile ten wide tablet twelve wide computer column">
                                    <?php if (in_array($current_user->ID, $decisionmakers) && !current_user_can('editor') && !current_user_can('administrator')) { ?>
                                        <p class="font medium"><?php _e('This petition is sent to you, let you clearly respond the problems stated  in this petition for supporters of petition.', 'petition') ?></p>
                                    <?php } else { ?>
                                        <p class="font medium"><?php _e('Keep your supporters engaged with a news update. Every update you post will be sent as a separate email to signers of your petition.', 'petition') ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php get_template_part('templates/update_petition'); ?>
                    <?php wp_nonce_field('update_petition_ajax_nonce', 'securityUpdate', true); ?>
                    <div class="ui secondary segment grid">
                        <div class="ten wide column">
                            <strong><?php the_author() ?> <?php _e('start this petition', 'petition') ?></strong>
                        </div>
                        <div class="six wide right aligned column ">
                            <?php echo esc_html($time) . __(' ago', 'petition') ?>
                        </div>
                    </div>
                    <div class="ui hidden divider"></div>
                    </div>
                </div>

                <!-- COMMENT PETITION -->
                <?php if(comments_open() || get_comments_number()) {
                        comments_template();
                    } ?>
            </div>
            <div class="six wide tablet six wide computer column tablet computer only" >
                <!-- Here is the Leaders supporting this issue box must come. -->
                <h2><i class="user icon"></i><span class="fav_no"></span><?php  _e('Leaders Supporting this petition', 'petition') ?></h2>
                <?php the_widget( 'LP_Widget' ); //get_sidebar(); ?>
                <br>

                <!-- SIGN AND SHARE PETITION -->
                <div class="ui sticky" id="sign-sticky">
                    <div class="ui basic vertical segment">
                        <?php if ($sign_num >= $goal || $status == '1') { ?>
                            <h2 class="ui text victory"><i class="flag icon"></i><?php echo ( $status == '1' ? __('Confirm Victory!', 'petition') : __('Victory!', 'petition') ); ?></h2>
                            <div class="ui indicating small victory progress petition-goal" data-value="<?php echo esc_html($goal) ?>" data-total="<?php echo esc_html($goal) ?>">
                                <div class="bar">
                                    <div class="progress"></div>
                                </div>
                                <div class="label">
                                    <span><?php _e('This petition won with', 'petition') ?><?php echo ' ' . conikal_format_number('%!,0i', esc_html($sign_num)) . ' ' ?><?php _e('supporters', 'petition') ?></span>
                                </div>
                            </div>
                        <?php } else if ($status == '2') { ?>
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
                        <?php } ?>
                        
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
                                                <!-- Added by Pritam  -->
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
                                                <!-- ENDS -->
                                            </div>
                                            <div class="ui message" style="margin-top: 0">
                                                <div class="fb-publish ui toggle checkbox <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : 'checked'); ?>">
                                                    <input type="checkbox" name="fb-publish" class="hidden" <?php echo ($current_user->fb_publish == 'true' ? esc_attr('checked') : 'checked'); ?> disabled="disabled" >
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
                    <div class="thirteen wide column">
                        <h3 class="ui text victory"><i class="flag icon"></i><?php echo ( $status == '1' ? __('Confirm Victory!', 'petition') : __('Victory!', 'petition') ); ?></h3>
                    </div>
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <div class="ui indicating tiny victory progress petition-goal" data-value="<?php echo esc_html($goal) ?>" data-total="<?php echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span><?php _e('This petition won with', 'petition') ?><?php echo ' ' . conikal_format_number('%!,0i', esc_html($sign_num)) . ' ' ?><?php _e('supporters', 'petition') ?></span>
                    </div>
                </div>
            <?php } else if ($status == '2') { ?>
                <div class="ui grid">
                    <div class="thirteen wide column">
                        <h3><i class="lock icon"></i><span class="fav_no"><?php  _e('Petition closed', 'petition') ?></span></h3>
                    </div>
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <div class="ui tiny progress petition-goal" data-value="<?php echo esc_html($sign_num) ?>" data-total="<?php echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span class="ned_no"><?php print conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="ui grid">
                    <div class="thirteen wide column">
                        <h3><i class="user icon"></i><span class="fav_no"><?php echo conikal_format_number('%!,0i', esc_html($sign_num)) ?></span> <?php  _e('Supporters', 'petition') ?></h3>
                    </div>
                    <div class="three wide right aligned column">
                        <a href="javascript:void(0)" class="font big" id="close-mobile-sign"><i class="angle down icon"></i></a>
                    </div>
                </div>
                <div class="ui indicating tiny primary progress petition-goal" data-value="<?php echo esc_html($sign_num) ?>" data-total="<?php echo esc_html($goal) ?>">
                    <div class="bar">
                        <div class="progress"></div>
                    </div>
                    <div class="label">
                        <span class="ned_no"><?php print conikal_format_number('%!,0i', esc_html($goal - $sign_num)) ?></span> <?php echo _e('needed to reach', 'petition') . ' ' . conikal_format_number('%!,0i', esc_html($goal)) ?>
                    </div>
                </div>
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
                        <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('Sign this Petition', 'petition') ?></button>
                    <?php } else { ?>
                        <button class="ui primary fluid button"><i class="share icon"></i><?php esc_html_e('Share this Petition', 'petition') ?></button>
                <?php   }
                    } else {
                    if ($status == '0') { ?>
                        <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('Sign this Petition', 'petition') ?></button>
                    <?php } else { ?>
                        <button class="ui primary fluid button"><i class="share icon"></i><?php esc_html_e('Share this Petition', 'petition') ?></button>
                <?php   }
                } ?>
            <?php } else { ?>
                <button class="ui primary fluid button"><i class="write icon"></i><?php esc_html_e('Sign this Petition', 'petition') ?></button>
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