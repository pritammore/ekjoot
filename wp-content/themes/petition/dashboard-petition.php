<?php
/*
Template Name: Dashboard Petition
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
$conikal_general_settings = get_option('conikal_general_settings');
$number_sign_change_goal = isset($conikal_general_settings['conikal_number_sign_change_field']) ? $conikal_general_settings['conikal_number_sign_change_field'] : '';
$conikal_colors_settings = get_option('conikal_colors_settings');
$main_color = isset($conikal_colors_settings['conikal_main_color_field']) ? $conikal_colors_settings['conikal_main_color_field'] : '';
?>
<?php 
    if (isset($_GET['edit_id']) && $_GET['edit_id'] != '') {
        $edit_id = sanitize_text_field($_GET['edit_id']);

        $args = array(
            'p' => $edit_id,
            'post_type' => 'petition',
            'post_status' => array('publish', 'pending')
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $link = get_permalink($edit_id);
                $title = get_the_title($edit_id);
                $content = get_the_content($edit_id);
                $category =  wp_get_post_terms($edit_id, 'petition_category', true);
                $category_id = $category ? $category[0]->term_id : '';
                $topics =  wp_get_post_terms($edit_id, 'petition_topics');
                $excerpt = conikal_get_excerpt_by_id($edit_id);
                $comments = wp_count_comments($edit_id);
                $gallery = get_post_meta($edit_id, 'petition_gallery', true);
                $images = explode("~~~", $gallery);
                $video = get_post_meta($edit_id, 'petition_video', true);
                $address = get_post_meta($edit_id, 'petition_address', true);
                $city = get_post_meta($edit_id, 'petition_city', true);
                $state = get_post_meta($edit_id, 'petition_state', true);
                $neighborhood = get_post_meta($edit_id, 'petition_neighborhood', true);
                $zip = get_post_meta($edit_id, 'petition_zip', true);
                $country = get_post_meta($edit_id, 'petition_country', true);
                $lat = get_post_meta($edit_id, 'petition_lat', true);
                $lng = get_post_meta($edit_id, 'petition_lng', true);
                $decisionmakers = get_post_meta($edit_id, 'petition_decisionmakers', true);
                $decisionmakers = array_unique(explode(',', $decisionmakers));
                $receiver = get_post_meta($edit_id, 'petition_receiver', true);
                $receiver = explode(',', $receiver);
                $position = get_post_meta($edit_id, 'petition_position', true);
                $position = explode(',', $position);
                $goal = get_post_meta($edit_id, 'petition_goal', true);
                $users_sign = get_post_meta($edit_id, 'petition_users', true);
                $sign = get_post_meta($edit_id, 'petition_sign', true);
                $sign = isset($sign) ? intval($sign) : 0;
                $updates = get_post_meta($edit_id, 'petition_update', true);
                $thumb = get_post_meta($edit_id, 'petition_thumb', true);
                $letter = get_post_meta($edit_id, 'petition_letter', true);
                $status = get_post_meta($edit_id, 'petition_status', true);

                $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
                if($user_avatar != '') {
                    $avatar = $user_avatar;
                } else {
                    $avatar = get_template_directory_uri().'/images/avatar.svg';
                }
                $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $avatar) );
            }
        }
        wp_reset_postdata();
        wp_reset_query();
    } else {
        $edit_id = isset($_GET['edit_id']) ? sanitize_text_field($_GET['edit_id']) : '';
        $link = get_permalink($edit_id);
    }
    $post_author_id = get_post_field( 'post_author', $edit_id );
?>
<?php if ( $edit_id != '' && ($post_author_id == $current_user->ID || current_user_can('editor') || current_user_can('administrator')) ) { ?>
    <div id="wrapper" class="wrapper">
        <div class="color silver">
            <div class="ui large secondary pointing grey menu" id="control-menu">
                <div class="ui container">
                        <a href="<?php echo isset($link) ? $link : '' ?>" class="item" data-bjax><?php _e('Campaign', 'petition') ?></a>
                        <a href="#" class="active item"><?php _e('Dashboard', 'petition') ?></a>
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
                                $page_link = get_permalink($page_id) . '?petition_id=' . $edit_id . '&type=update';
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
                                $page_link = get_permalink($page_id) . '?edit_id=' . $edit_id;
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                </div>
            </div>
        </div>
    
        <div class="ui container">
            <div class="ui hidden divider"></div>
            <div class="ui segment">
                <div class="ui three small statistics">
                    <div class="statistic">
                        <div class="value">
                            <?php echo esc_html( conikal_format_number('%!,0i', esc_html(conikal_get_post_views($edit_id)), true) ); ?>
                        </div>
                        <div class="label">
                            <?php _e('Views', 'petition') ?>
                        </div>
                    </div>
                    <div class="statistic">
                        <div class="value">
                            <?php echo esc_html( conikal_format_number('%!.0i', esc_html($sign), true) ); ?>
                        </div>
                        <div class="label">
                            <?php _e('Supporters', 'petition') ?>
                        </div>
                    </div>
                    <div class="statistic">
                        <div class="value">
                            <?php echo esc_html( conikal_format_number('%!.0i', esc_html($comments->approved), true) ); ?>
                        </div>
                        <div class="label">
                            <?php _e('Comments', 'petition') ?>
                        </div>
                    </div>
                </div>
                <div class="ui section divider"></div>
                <div class="ui grid">
                    <div class="sixteen wide mobile eight wide tablet eight wide computer center aligned column">
                        <div class="ui form">
                            <div class="inline field">
                                <label><?php esc_html_e('Set new goals', 'petition') ?></label>
                                <div class="ui action <?php echo ($sign >= $number_sign_change_goal || current_user_can('editor') || current_user_can('administrator') ? '' : 'disabled ') ?>input">
                                  <input type="number" id="new-goal" placeholder="<?php _e('Enter a new goal', 'petition') ?>" value="<?php echo (isset($goal) ? esc_attr($goal) : '') ?>">  
                                  <button class="ui primary <?php echo ($sign >= $number_sign_change_goal || current_user_can('editor') || current_user_can('administrator') ? '' : 'disabled ') ?>button" id="set-goal"><?php _e('Save', 'petition') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sixteen wide mobile eight wide tablet eight wide computer center aligned column">
                            
                            <?php if (!$status || $status == 0) { ?>
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
                                        $page_link = get_permalink($page_id) . '?petition_id=' . $edit_id . '&type=victory' . '&status=1';
                                    }
                                    wp_reset_postdata();
                                    wp_reset_query();
                                ?>
                                <a href="<?php echo ($page_link ? $page_link : '') ?>" class="ui primary button" data-bjax><?php _e('Declare victory', 'petition') ?></a>
                                
                                <?php
                                    $args = array(
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'meta_key' => '_wp_page_template',
                                        'meta_value' => 'download-csv.php'
                                    );

                                    $query = new WP_Query($args);

                                    while($query->have_posts()) {
                                        $query->the_post();
                                        $page_id = get_the_ID();
                                        $page_link = get_permalink($page_id) . '?petition_id=' . $edit_id . '&download=signatures';
                                    }
                                    wp_reset_postdata();
                                    wp_reset_query();
                                    
                                ?>
                                <a class="ui primary button" href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Download CSV', 'petition') ?></a>
                                <button class="ui button" id="close-petition"><?php _e('Close petition', 'petition') ?></button>
                            <?php } else { ?>
                                <button class="ui primary button" id="reopen-petition"><?php _e('Reopen Petition', 'petition') ?></button>
                                <?php
                                    $args = array(
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'meta_key' => '_wp_page_template',
                                        'meta_value' => 'download-csv.php'
                                    );

                                    $query = new WP_Query($args);

                                    while($query->have_posts()) {
                                        $query->the_post();
                                        $page_id = get_the_ID();
                                        $page_link = get_permalink($page_id) . '?petition_id=' . $edit_id . '&download=signatures';
                                    }
                                    wp_reset_postdata();
                                    wp_reset_query();
                                    
                                ?>
                                <a class="ui primary button" href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Download CSV', 'petition') ?></a>
                            <?php } ?>
                    </div>
                </div>
                <div class="ui section divider"></div>
                <canvas id="supportersChart" width="1000" height="380"></canvas>
                <?php
                    $date = current_time('mysql');
                    $date = strtotime($date);
                    $arrDate = array();
                    for ($i=0; $i <= 10; $i++) { 
                        $date = strtotime('-'.$i.' day', $date);
                        array_push($arrDate, date('m/d', $date));
                        $date = current_time('mysql');
                        $date = strtotime($date);
                    }
                    $sign_users = get_post_meta($edit_id, 'petition_users', true);
                    $usrDate = array();
                    foreach ($sign_users as $user) {
                        $user_date = $date = strtotime($user['date']);
                        $user_date = date('m/d', $user_date);
                        array_push($usrDate, $user_date);
                    }
                    $usrDate = array_count_values($usrDate);
                    $chartData = array();
                    $chartDate = array();
                    $totalData = array();
                    foreach ($usrDate as $sign_date => $sign_count) {
                        if ( in_array($sign_date, $arrDate) ) {
                            $totalData[$sign_date] = $sign_count;
                        }
                    }
                    foreach ($arrDate as $date) {
                        if ( array_key_exists($date, $totalData) ) {
                            
                        } else {
                            $totalData[$date] = 0;
                        }
                    }
                    ksort($totalData);
                    foreach ($totalData as $date => $count) {
                        array_push($chartData, $count);
                        array_push($chartDate, $date);
                    }
                    $chartData = json_encode( $chartData );
                    $chartDate = json_encode( $chartDate );
                ?>
            </div>
            <?php if( isset($decisionmakers[1]) ) { ?>
            <div class="ui segment">
                <div class="ui dividing header widget-title"><?php esc_html_e('Decision Makers', 'petition'); ?></div>
                <div class="ui four column stackable grid">
                    <?php foreach ($decisionmakers as $id) { 
                        if ($id) {
                            $user = get_userdata($id);
                            $user_id = $user->ID;
                            $user_name = $user->display_name;
                            $user_email = $user->user_email;
                            $user_address = get_user_meta($user_id, 'user_address', true);
                            $user_neigborhood = get_user_meta($user_id, 'user_neigborhood', true);
                            $user_city = get_user_meta($user_id, 'user_city', true);
                            $user_state = get_user_meta($user_id, 'user_state', true);
                            $user_country = get_user_meta($user_id, 'user_country', true);
                            $user_lat = get_user_meta($user_id, 'user_lat', true);
                            $user_lng = get_user_meta($user_id, 'user_lng', true);
                            $user_gender = get_user_meta($user_id, 'user_gender', true);
                            $user_birthday = get_user_meta($user_id, 'user_birthday', true);
                            $user_avatar = $user->avatar;

                            $user_decisionmakers = get_user_meta($user_id, 'user_decision', true);
                            $decision_title =  wp_get_post_terms($user_decisionmakers, 'decisionmakers_title', true);
                            $decision_title = ($decision_title ? $decision_title[0]->name : '');
                            $organization =  wp_get_post_terms($user_decisionmakers, 'decisionmakers_organization', true);
                            $organization = ($organization ? $organization[0]->name : '');
                            
                            if (!$user_avatar) {
                                $user_avatar = get_template_directory_uri().'/images/avatar.svg';
                            }
                            $user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $user_avatar) );
                    ?>
                    <div class="column">
                        <div class="ui fluid card">
                            <div class="content">
                                <img class="right floated mini ui image" src="<?php echo esc_attr($user_avatar) ?>">
                                <div class="header">
                                    <a href="<?php echo get_author_posts_url($user_id) ?>" data-bjax><?php echo esc_html($user_name) ?></a>
                                </div>
                                <div class="meta">
                                    <?php echo esc_html($decision_title) . __(' of ', 'petition') . esc_html($organization) ?>
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="ui primary small fluid button invite-responsive" data-email="<?php echo esc_attr($user_email) ?>"><i class="send icon"></i><?php esc_html_e('Invite Response', 'petition') ?></div>
                            </div>
                      </div>
                    </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <?php } ?>

            <div class="ui grid">
                <div class="sixteen wide mobile wide eight wide tablet eight wide computer column">
                    <div class="ui segment">
                    <h2 class="ui dividing header widget-title"><?php echo esc_html( conikal_format_number('%!.0i', $sign) ) . esc_html(' supporters', 'petition'); ?></h2>
                        <div class="ui relaxed divided list" id="supporters-list" style="padding-right: 8px;">
                            <?php
                                $users = get_users();
                                $followers = 0;
                                $users_gender = array();
                                $users_age = array();
                                $users_regions = array();
                                $current_user_follows = get_user_meta($current_user->ID, 'follow_user', true);
                                foreach ($users as $user) {
                                    $user_sign = get_user_meta($user->data->ID, 'petition_sign', true);
                                    if(is_array($user_sign) && in_array($edit_id, $user_sign)) {
                                        $user_id = $user->ID;
                                        $user_name = $user->display_name;
                                        $user_address = get_user_meta($user_id, 'user_address', true);
                                        $user_neigborhood = get_user_meta($user_id, 'user_neigborhood', true);
                                        $user_city = get_user_meta($user_id, 'user_city', true);
                                        $user_state = get_user_meta($user_id, 'user_state', true);
                                        $user_country = get_user_meta($user_id, 'user_country', true);
                                        $user_lat = get_user_meta($user_id, 'user_lat', true);
                                        $user_lng = get_user_meta($user_id, 'user_lng', true);
                                        $user_gender = get_user_meta($user_id, 'user_gender', true);
                                        $user_birthday = get_user_meta($user_id, 'user_birthday', true);
                                        $user_avatar = $user->avatar;
                                        $user_petition_count = count_user_posts( $user_id, 'petition' );
                                        
                                        if (!$user_avatar) {
                                            $user_avatar = get_template_directory_uri().'/images/avatar.svg';
                                        }
                                        $user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $user_avatar) );

                                        foreach ($users as $user_f) {
                                            $follow_user = get_user_meta($user_f->data->ID, 'follow_user', true);
                                            if(is_array($follow_user) && in_array($user_id, $follow_user)) {
                                                $followers = $followers + 1;
                                            }
                                        }
                                        if ($user_city != '' || $user_state != '' || $user_country != '') {
                                            array_push($users_regions, $user_city . ', ' . $user_state . ', ' . $user_country);
                                        } else {
                                            array_push($users_regions, 'unknown');
                                        }

                                        if ( $user_gender === 'male' ) {
                                            array_push($users_gender, 'male');
                                        } elseif ( $user_gender === 'famale' ) {
                                            array_push($users_gender, 'famale');
                                        } else {
                                            array_push($users_gender, 'unknown');
                                        }

                                        if ($user_birthday) {
                                            $user_age = conikal_get_age($user_birthday);
                                            if ($user_age <= 17) {
                                                array_push($users_age, '13');
                                            } elseif ($user_age >= 18 && $user_age <= 24) {
                                                array_push($users_age, '18');
                                            } elseif ($user_age >= 25 && $user_age <= 34 ) {
                                                array_push($users_age, '25');
                                            } elseif ($user_age >= 35 && $user_age <= 44) {
                                                array_push($users_age, '35');
                                            } elseif ($user_age >= 45 && $user_age <= 54) {
                                                array_push($users_age, '45');
                                            } elseif ($user_age >= 55 && $user_age <= 64) {
                                                array_push($users_age, '55');
                                            } elseif ($user_age >= 65) {
                                                array_push($users_age, '65');
                                            }
                                        }
                                    ?>
                                    <div class="item">
                                        <div class="right floated content">
                                            <?php if(is_user_logged_in()) {
                                                if($current_user_follows != '') {
                                                    if(in_array($user_id, $current_user_follows) === false) { ?>
                                                        <a href="javascript:void(0)" id="follow-user-<?php echo esc_html($user_id) ?>" class="ui mini icon basic button follow-user follow" data-id="<?php echo esc_html($user_id); ?>"><i class="plus icon"></i></a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0)" id="follow-user-<?php echo esc_html($user_id) ?>" class="ui mini icon primary button follow-user following" data-id="<?php echo esc_html($user_id); ?>"><i class="checkmark user icon"></i></a>
                                                <?php } 
                                                    } else { ?>
                                                    <a href="javascript:void(0)" id="follow-user-<?php echo esc_html($user_id) ?>" class="ui mini icon basic button follow-user follow" data-id="<?php echo esc_html($user_id); ?>"><i class="plus icon"></i></a>
                                                <?php }
                                            } ?>
                                        </div>
                                        <img class="ui avatar image" src="<?php echo esc_html($user_avatar); ?>" />
                                        <div class="content">
                                            <a href="<?php echo get_author_posts_url($user_id) ?>" class="header" data-bjax><?php echo esc_html($user_name) ?></a>
                                            <span class="text grey"><?php echo esc_html( conikal_format_number('%!.0i', $followers, true) ) . ' ' . esc_html('followers', 'petition'); ?></span>
                                        </div>
                                    </div>
                                    <?php }  else {
                                        $followers = 0;
                                    }
                                }
                                wp_nonce_field('follow_ajax_nonce', 'securityFollow', true);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="sixteen wide mobile wide eight wide tablet eight wide computer column">
                    <div class="ui segment">
                        <h2 class="ui dividing header widget-title"><?php esc_html_e('Geography', 'petition'); ?></h2>
                        <div class="ui list" id="region-list" style="padding-right: 8px;">
                        <?php
                            $users_regions = array_count_values($users_regions);
                            arsort($users_regions);
                            foreach ($users_regions as $region => $users) { ?>
                            <div class="item">
                                <div class="right floated content">
                                    <?php echo esc_html( conikal_format_number('%!,0i', $users) ) ?>
                                </div>
                                <div class="content">
                                    <i class="marker icon"></i><?php echo esc_html($region) ?>
                                </div>
                            </div>
                        <?php   } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($sign > 0) {
                $users_gender = array_count_values($users_gender);
                if (!array_key_exists('male', $users_gender)) {
                    $users_gender['male'] = 0;
                } elseif (!array_key_exists('famale', $users_gender)) {
                    $users_gender['famale'] = 0;
                } elseif (!array_key_exists('unknown', $users_gender)) {
                    $users_gender['unknown'] = 0;
                }
                ksort($users_gender);
                $genderData = array();
                $totalGender = 0;
                foreach ($users_gender as $gender) {
                    $totalGender = $totalGender + $gender;
                }
                foreach ($users_gender as $gender) {
                    $percent = ($gender / $totalGender) * 100;
                    $percent = round($percent, 0);
                    array_push($genderData, $percent);
                }
                $genderData = json_encode($genderData);

                $users_age = array_count_values($users_age);
                for ($i=1; $i<=7; $i++) {
                    if (!array_key_exists('13', $users_age)) {
                        $users_age['13'] = 0;
                    } elseif (!array_key_exists('18', $users_age)) {
                        $users_age['18'] = 0;
                    } elseif (!array_key_exists('25', $users_age)) {
                        $users_age['25'] = 0;
                    } elseif (!array_key_exists('35', $users_age)) {
                        $users_age['35'] = 0;
                    } elseif (!array_key_exists('45', $users_age)) {
                        $users_age['45'] = 0;
                    } elseif (!array_key_exists('55', $users_age)) {
                        $users_age['55'] = 0;
                    } elseif (!array_key_exists('65', $users_age)) {
                        $users_age['65'] = 0;
                    }
                }
                ksort($users_age);
                $ageData = array();
                $totalAge = 0;
                foreach ($users_age as $age) {
                    $totalAge = $totalAge + $age;
                }
                foreach ($users_age as $age) {
                    $percent = ($age / $totalAge) * 100;
                    $percent = round($percent, 0);
                    array_push($ageData, $percent);
                }
                $ageData = json_encode($ageData);
            ?>
            <div class="ui grid">
                <div class="sixteen wide mobile wide eight wide tablet eight wide computer column">
                    <div class="ui segment">
                        <canvas id="genderChart" width="1000" height="700"></canvas>
                    </div>
                </div>
                <div class="sixteen wide mobile wide eight wide tablet eight wide computer column">
                    <div class="ui segment">
                        <canvas id="ageChart" width="1000" height="700"></canvas>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

<div class="ui small modal" id="invite-modal">
    <div class="content">
        <div class="ui header"><?php esc_html_e('Invitation letter', 'petition') ?></div>
        <div id="invitation-response" class="respon-message"></div>
        <div class="ui form">
            <div class="field">
                <input type="hidden" name="user_email" id="user_email" value="<?php echo esc_attr($current_user->user_email) ?>">
                <input type="hidden" name="invite_name" id="invite_name" value="<?php echo esc_attr($current_user->display_name) ?>">
                <input type="hidden" name="invite_email" id="invite_email" value="">
                <input type="hidden" name="invite_subject" id="invite_subject" value="<?php echo esc_html($title) ?>">
                <textarea class="auto-height font letter medium" id="invite_message" style="height: 653px;"><?php _e("Dear \n", 'petition') ?><?php for ($i=0; $i < count($receiver); $i++) { 
                        if ($receiver[$i]) {
                            echo ($position[$i] ? $position[$i] . ', ' : '') . $receiver[$i] . "\n";
                        }
                    } ?>
                    <?php echo "\n\n" ?>
                    <?php echo (isset($letter) ? esc_attr(str_replace(array("<br />","<br>","<br/>"), "\n", $letter)) : esc_attr($title)) ?>
                </textarea>
                <textarea name="invite_link" id="invite_link" style="display:none;">
                    <?php echo "\n\n" . esc_html('Go to the petition and response on:', 'petition') . "\n" . esc_url($link) ?>
                </textarea>
            </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui grid">
            <div class="sixteen right aligned column">
                <div class="ui cancel button" id="invita-cancel"><?php esc_html_e('Cancel', 'petition') ?></div>
                <div class="ui positive right labeled icon button" id="send-invite" data-id="<?php echo esc_attr($edit_id) ?>"><?php esc_html_e('Send', 'petition') ?><i class="send icon"></i></div>
            </div>
        </div>
    </div>

</div>

<div class="ui small modal" id="set-goal-confirm">
    <div class="content">
        <div class="ui header"><?php esc_html_e('Are you sure change the goal is', 'petition') ?> <span id="goal-number"></span> <?php esc_html_e('signatures', 'petition') ?></div>
    </div>
    <div class="actions">
        <div class="ui cancel button"><?php esc_html_e('Cancel', 'petition') ?></div>
        <div class="ui positive right labeled icon button" id="approve-goal" data-id="<?php echo esc_attr($edit_id) ?>"><?php esc_html_e('Yes', 'petition') ?><i class="checkmark icon"></i></div>
    </div>
</div>

<div class="ui small modal" id="reopen-confirm">
    <div class="content">
        <div class="ui header"><?php esc_html_e('Are you sure reopen this petition', 'petition') ?></div>
    </div>
    <div class="actions">
        <div class="ui cancel button"><?php esc_html_e('Cancel', 'petition') ?></div>
        <div class="ui positive right labeled icon button" id="approve-reopen" data-id="<?php echo esc_attr($edit_id) ?>"><?php esc_html_e('Yes', 'petition') ?><i class="checkmark icon"></i></div>
    </div>
</div>

<div class="ui small modal" id="close-confirm">
    <div class="content">
        <div class="ui header"><?php esc_html_e('Are you sure close this petition', 'petition') ?></div>
    </div>
    <div class="actions">
        <div class="ui cancel button"><?php esc_html_e('Cancel', 'petition') ?></div>
        <div class="ui positive right labeled icon button" id="approve-close" data-id="<?php echo esc_attr($edit_id) ?>"><?php esc_html_e('Yes', 'petition') ?><i class="checkmark icon"></i></div>
    </div>
</div>
<?php wp_nonce_field('dashboard_petition_ajax_nonce', 'securityDashboard', true); ?>
<?php wp_nonce_field('invitation_ajax_nonce', 'securityInvitation', true); ?>
<?php } else { ?>
    <?php get_template_part('404') ?>
<?php } ?>
<?php get_footer(); ?>
<script type="text/javascript">
    var myChart = new Chart(document.getElementById("supportersChart"), {
        type: 'line',
        data: {
            labels: <?php print $chartDate ?>,
            datasets: [{
                label: "<?php esc_html_e('Supporters', 'petition') ?>",
                data: <?php print $chartData ?>,
                fill: false,
                lineTension: 0,
                backgroundColor: "<?php print $main_color ?>",
                borderColor: "<?php print $main_color ?>",
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    // Gender pie chart
    var myPieChart = new Chart(document.getElementById("genderChart"),{
        data: {
            datasets: [{
                data: <?php print isset($genderData) ? $genderData : '[0,0,0]' ?>,
                label: "<?php esc_html_e('Gender (%)', 'petition') ?>",
                backgroundColor: [
                    "#EC407A",
                    "#42A5F5",
                    "#BDBDBD"
                ],
                label: 'My dataset' // for legend
            }],
            labels: [
                "<?php esc_html_e('Famale (%)', 'petition') ?>",
                "<?php esc_html_e('Male (%)', 'petition') ?>",
                "<?php esc_html_e('Unknown (%)', 'petition') ?>"
            ]
        },
        type: "pie",
        options: {
            elements: {
                arc: {
                    borderColor: "#ffffff"
                }
            }
        }
    });

    var myBarChart = new Chart(document.getElementById("ageChart"), {
        type: 'horizontalBar',
        data: {
            labels: ["13-17", "18-24", "25-34", "35-44", "45-54", "55-65", "65+"],
            datasets: [
                {
                    data: <?php print isset($ageData) ? $ageData : '[0,0,0,0,0,0,0]' ?>,
                    label: "<?php esc_html_e('Age (%)', 'petition') ?>",
                    backgroundColor: [
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>"
                    ],
                    borderColor: [
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>",
                        "<?php print $main_color ?>"
                    ],
                    borderWidth: 1,
                }
            ]
        },
        options: {
            elements: {
                arc: {
                    borderColor: "#ffffff"
                }
            }
        }
    });
    // Age bar chart
</script>