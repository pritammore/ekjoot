<?php

/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
$current_user = wp_get_current_user();
$update_posts = conikal_update_petition($post->ID);
$conikal_appearance_settings = get_option('conikal_appearance_settings');
$updates_per_page_setting = isset($conikal_appearance_settings['conikal_updates_per_page_field']) ? $conikal_appearance_settings['conikal_updates_per_page_field'] : '';
$updates_per_page = $updates_per_page_setting != '' ? $updates_per_page_setting : 5;

if($update_posts) {
    $total_p = $update_posts->found_posts;
} else {
    $total_p = 0;
}
$users = get_users();
?>
<div id="update-list">
    <?php
    if ($update_posts->have_posts()) : 
        while ( $update_posts->have_posts() ) :
            $update_posts->the_post();
            $update_id = get_the_ID();
            $link = get_permalink($update_id);
            $title = get_the_title($update_id);
            $excerpt = conikal_get_excerpt_by_id($update_id);
            $date = get_the_date('', $update_id);
            $time = human_time_diff(get_the_time('U', $update_id), current_time('timestamp'));
            $type =  get_post_meta($update_id, 'update_type', true);
            $petition_id =  get_post_meta($update_id, 'update_post_id', true);
            $media = get_post_meta($update_id, 'petition_media', true);
            $gallery = get_post_meta($update_id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumb_id = get_post_thumbnail_id($update_id);
            $thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
            $thumb_video = get_post_meta($id, 'petition_thumb', true);
            $comments = wp_count_comments($update_id);

            $content_post = get_post($update_id);
            $content = $content_post->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
        ?>

            <?php if($type == 'victory') {  ?>
                <div class="ui fluid card" id="update-<?php echo esc_html($update_id) ?>">
                    <div class="content">
                         <?php if ( get_the_author_meta( 'ID' ) == $current_user->ID ) { ?>
                            <div class="right floated meta">
                                <div class="ui icon top right pointing dropdown edit-update">
                                    <i class="angle down icon"></i>
                                    <div class="menu">
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
                                                $page_link = get_permalink($page_id). '?edit_id=' . $update_id;
                                            }
                                            wp_reset_postdata();
                                            wp_reset_query();
                                        ?>
                                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                                        <a href="javascript:void(0)" class="item delete-update" data-id="<?php echo esc_html($update_id) ?>"><?php _e('Delete', 'petition') ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="ui center aligned huge icon header victory-update-title">
                            <?php echo conikal_custom_icon('victory_inverse') ?>
                            <div class="content">
                                <a href="<?php echo esc_url($link) ?>" data-bjax><?php echo esc_html($title) ?></a>
                                <div class="sub header"><?php echo esc_html($date) ?></div>
                            </div>
                        </div>
                        <div class="description font medium" style="text-align: center;">
                            <?php echo esc_html($excerpt) ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
            <div class="ui fluid card" id="update-<?php echo esc_html($update_id) ?>">
                <div class="content">
                    <?php if ( get_the_author_meta( 'ID' ) == $current_user->ID ) { ?>
                        <div class="right floated meta">
                            <div class="ui icon top right pointing dropdown edit-update">
                                <i class="angle down icon"></i>
                                <div class="menu">
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
                                            $page_link = get_permalink($page_id);
                                            $page_link = add_query_arg(array('edit_id' => $update_id), $page_link);
                                        }
                                        wp_reset_postdata();
                                        wp_reset_query();
                                    ?>
                                    <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                                    <a href="javascript:void(0)" class="item delete-update" data-id="<?php echo esc_html($update_id) ?>"><?php _e('Delete', 'petition') ?></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="header">
                        <a href="<?php echo esc_url($link) ?>" data-bjax>
                            <?php echo esc_html($title) ?>
                        </a>
                    </div>
                    <div class="description">
                        <div class="ui grid">
                            <div class="sixteen wide mobile sixteen tablet thirteen wide computer column update-excertp">
                                <?php echo esc_html($excerpt) ?>
                            </div>
                            <div class="three wide column computer only">
                                <a href="<?php echo esc_url($link) ?>" data-bjax>
                                    <?php if(has_post_thumbnail($update_id)) { ?>
                                        <img class="ui fluid image" id="thumbnail-post" src="<?php echo esc_url($thumbnail[0]) ?>" alt="<?php echo esc_attr($title) ?>">
                                    <?php } elseif ($gallery) { ?>
                                        <img class="ui fluid image" id="gallery-post" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                    <?php } elseif ($thumb_video) { ?>
                                        <img class="ui fluid image" src="<?php echo esc_url($thumb_video) ?>" alt="<?php echo esc_attr($title) ?>">
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="extra content">
                    <?php if($comments->approved != 0) { ?>
                        <span>
                            <i class="comments icon"></i>
                            <?php echo esc_html($comments->approved) . ' ' . __('comments', 'petition'); ?>
                        </span>
                    <?php } ?>
                    <span class="right floated">
                        <?php echo esc_html($time) . __(' ago', 'petition') ?>
                    </span>
                </div>
            </div>
            <?php } ?>
    <?php endwhile;
        wp_reset_postdata();
        wp_reset_query();
    endif; ?>
</div>
<?php if ($total_p > $updates_per_page) { ?>
    <br/>
    <div class="ui basic fluid button" id="updates-more" data-offset="<?php echo esc_attr($updates_per_page) ?>"><i class="long arrow down icon"></i><?php _e('More updates...', 'petition') ?></div>
<?php } ?>
