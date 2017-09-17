<?php
/*
Template Name: Add Update
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
?>
<?php 
    if (isset($_GET['edit_id']) && $_GET['edit_id'] != '') {
        $edit_id = sanitize_text_field($_GET['edit_id']);

        $args = array(
            'p' => $edit_id,
            'post_type' => 'update',
            'post_status' => array('publish', 'pending')
        );

        $updates = new WP_Query($args);

        if ($updates->have_posts()) {
            while($updates->have_posts()) {
                $updates->the_post();
                $link = get_permalink($edit_id);
                $title = get_the_title($edit_id);
                $content = get_the_content($edit_id);
                $excerpt = conikal_get_excerpt_by_id($edit_id);
                $date = get_the_date('', $edit_id);
                $type =  get_post_meta($edit_id, 'update_type', true);
                $petition_id =  get_post_meta($edit_id, 'update_post_id', true);
                $media =  get_post_meta($edit_id, 'update_media', true);
                $gallery = get_post_meta($edit_id, 'update_gallery', true);
                $images = explode("~~~", $gallery);
                $thumb_id = get_post_thumbnail_id($edit_id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'full', true);
                $video = get_post_meta($edit_id, 'update_video', true);
                $thumb = get_post_meta($edit_id, 'update_thumb', true);
                $comments = wp_count_comments($edit_id);

                $p_link = get_permalink($petition_id);
                $status = get_post_meta($petition_id, 'petition_status', true);
                $decisionmakers = get_post_meta($petition_id, 'petition_decisionmakers', true);
                $decisionmakers = array_unique(explode(',', $decisionmakers));
                $approvedleaders = get_post_meta($petition_id, 'lp_post_ids', true );
            }
        wp_reset_postdata();
        wp_reset_query();
        }
    } else {
        $petition_id = isset($_GET['petition_id']) ? sanitize_text_field($_GET['petition_id']) : '';
        $p_link = get_permalink($petition_id);
        $status = get_post_meta($petition_id, 'petition_status', true);
        $decisionmakers = get_post_meta($petition_id, 'petition_decisionmakers', true);
        $decisionmakers = array_unique(explode(',', $decisionmakers));
        $approvedleaders = get_post_meta($petition_id, 'lp_post_ids', true );
    }

    $update_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : $type;
    $petition_status = isset($_GET['status']) ? $_GET['status'] : $status;
    $post_author_id = get_post_field( 'post_author', $petition_id );
?>
<?php if ( $post_author_id == $current_user->ID || current_user_can('editor') || current_user_can('administrator') || in_array($current_user->ID, $decisionmakers) || (!empty($approvedleaders) && in_array($current_user->ID, $approvedleaders)) ) { ?>
    <div id="wrapper" class="wrapper">
        <div class="color silver">
            <div class="ui large secondary pointing grey menu" id="control-menu">
                <div class="ui container">
                        <a href="<?php echo isset($p_link) ? $p_link : '' ?>" class="item" data-bjax><?php _e('Campaign', 'petition') ?></a>
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
                        <a href="#" class="active item"><?php _e('Update', 'petition') ?></a>
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
                        <?php if ( $post_author_id == $current_user->ID || current_user_can('administrator')) { ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Edit', 'petition') ?></a>
                        <?php } ?>
                </div>
            </div>
        </div>
        <div class="ui container add-update">
            <div class="ui center aligned header add-update-title">
                <div class="content">
                    <?php the_title() ?>
                </div>
            </div>
            <div class="ui centered left aligned grid">
                <div class="sixteen wide mobile fourteen wide tablet ten wide computer column">
                    <div class="respon-message" id="update-response"></div>
                    <form class="ui form">
                        <input type="hidden" name="update_id" id="update_id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
                        <input type="hidden" name="petition_id" id="petition_id" value="<?php echo isset($petition_id) ? $petition_id : ''; ?>">
                        <input type="hidden" name="update_type" id="update_type"  value="<?php echo isset($update_type) ? $update_type : 'update'; ?>">
                        <input type="hidden" name="status" id="status" value="<?php echo esc_attr($petition_status) ?>">
                        <div class="required field">
                            <label><?php _e('Title', 'petition') ?></label>
                            <div class="ui large input">
                                <input class="ui large input" type="text" name="update_title" id="update_title" value="<?php echo isset($title) ? $title : ($petition_status == 1 ? __('Victory!', 'petition') : ''); ?>">
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Your latest development', 'petition') ?></label>
                            <div class="ui top attached segment" id="isDesc">
                            <?php 
                                $html_content = isset($content) ? $content : '';
                                $settings = array(
                                    'media_buttons'         => false,
                                    'textarea_rows'         => 10,
                                    'drag_drop_upload'      => false,
                                    'quicktags'             => false,
                                    'dfw'                   => true,
                                    'editor_height'         => '300px',
                                    );
                                wp_editor($html_content, 'update_content', $settings);
                            ?>
                            </div>
                        </div>
                        <div class="field">
                            <label><?php _e('URL for an article', 'petition') ?></label>
                            <div class="ui large input">
                                <input type="text" name="update_media" id="update_media" placeholder="http://" value="<?php echo (isset($media) ? $media : '') ?>">
                            </div>
                        </div>
                        <div class="field">
                            <label><?php _e('Add a photo or video', 'petition') ?></label>
                            <input type="hidden" id="edit_gallery" value="<?php echo isset($gallery) ? esc_attr($gallery) : ''; ?>">
                            <input type="hidden" id="edit_video" value="<?php echo isset($video) ? esc_attr($video) : ''; ?>">
                            <?php get_template_part('templates/gallery_upload'); ?>
                        </div>
                        <div class="field">
                            <a class="ui primary large right floated button" id="submitUpdate"><?php _e('Post update', 'petition') ?></a>
                        </div>
                        <?php wp_nonce_field('update_petition_ajax_nonce', 'securityUpdate', true); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <?php get_template_part('404') ?>
<?php } ?>
<?php get_footer(); ?>