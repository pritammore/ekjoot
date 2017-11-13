<?php
/*
Template Name: Edit Petition
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
$cat_taxonomies = array( 
    'petition_category'
);
$cat_args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => false
); 
$cat_terms = get_terms($cat_taxonomies, $cat_args);
$type_taxonomies = array( 
    'petition_topics'
);
$type_args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => false
);
$type_terms = get_terms($type_taxonomies, $type_args);

$conikal_general_settings = get_option('conikal_general_settings');
$number_sign_change_goal = isset($conikal_general_settings['conikal_number_sign_change_field']) ? $conikal_general_settings['conikal_number_sign_change_field'] : '';
$conikal_petition_fields_settings = get_option('conikal_petition_fields_settings');
$p_content = isset($conikal_petition_fields_settings['conikal_p_content_field']) ? $conikal_petition_fields_settings['conikal_p_content_field'] : 'enabled';
$p_content_r = isset($conikal_petition_fields_settings['conikal_p_content_r_field']) ? $conikal_petition_fields_settings['conikal_p_content_r_field'] : 'required';
$p_category = isset($conikal_petition_fields_settings['conikal_p_category_field']) ? $conikal_petition_fields_settings['conikal_p_category_field'] : 'enabled';
$p_category_r = isset($conikal_petition_fields_settings['conikal_p_category_r_field']) ? $conikal_petition_fields_settings['conikal_p_category_r_field'] : 'required';
$p_topics = isset($conikal_petition_fields_settings['conikal_p_topics_field']) ? $conikal_petition_fields_settings['conikal_p_topics_field'] : 'enabled';
$p_topics_r = isset($conikal_petition_fields_settings['conikal_p_topics_r_field']) ? $conikal_petition_fields_settings['conikal_p_topics_r_field'] : 'required';
$p_city = isset($conikal_petition_fields_settings['conikal_p_city_field']) ? $conikal_petition_fields_settings['conikal_p_city_field'] : 'enabled';
$p_city_r = isset($conikal_petition_fields_settings['conikal_p_city_r_field']) ? $conikal_petition_fields_settings['conikal_p_city_r_field'] : 'required';
$p_coordinates = isset($conikal_petition_fields_settings['conikal_p_coordinates_field']) ? $conikal_petition_fields_settings['conikal_p_coordinates_field'] : 'enabled';
$p_coordinates_r = isset($conikal_petition_fields_settings['conikal_p_coordinates_r_field']) ? $conikal_petition_fields_settings['conikal_p_coordinates_r_field'] : 'required';
$p_address = isset($conikal_petition_fields_settings['conikal_p_address_field']) ? $conikal_petition_fields_settings['conikal_p_address_field'] : 'enabled';
$p_address_r = isset($conikal_petition_fields_settings['conikal_p_address_r_field']) ? $conikal_petition_fields_settings['conikal_p_address_r_field'] : 'required';
$p_neighborhood = isset($conikal_petition_fields_settings['conikal_p_neighborhood_field']) ? $conikal_petition_fields_settings['conikal_p_neighborhood_field'] : 'enabled';
$p_neighborhood_r = isset($conikal_petition_fields_settings['conikal_p_neighborhood_r_field']) ? $conikal_petition_fields_settings['conikal_p_neighborhood_r_field'] : 'required';
$p_zip = isset($conikal_petition_fields_settings['conikal_p_zip_field']) ? $conikal_petition_fields_settings['conikal_p_zip_field'] : 'enabled';
$p_zip_r = isset($conikal_petition_fields_settings['conikal_p_zip_r_field']) ? $conikal_petition_fields_settings['conikal_p_zip_r_field'] : 'required';
$p_state = isset($conikal_petition_fields_settings['conikal_p_state_field']) ? $conikal_petition_fields_settings['conikal_p_state_field'] : 'enabled';
$p_state_r = isset($conikal_petition_fields_settings['conikal_p_state_r_field']) ? $conikal_petition_fields_settings['conikal_p_state_r_field'] : 'required';
$p_country = isset($conikal_petition_fields_settings['conikal_p_country_field']) ? $conikal_petition_fields_settings['conikal_p_country_field'] : 'enabled';
$p_country_r = isset($conikal_petition_fields_settings['conikal_p_country_r_field']) ? $conikal_petition_fields_settings['conikal_p_country_r_field'] : 'required';
$p_receiver = isset($conikal_petition_fields_settings['conikal_p_receiver_field']) ? $conikal_petition_fields_settings['conikal_p_receiver_field'] : 'enabled';
$p_receiver_r = isset($conikal_petition_fields_settings['conikal_p_receiver_r_field']) ? $conikal_petition_fields_settings['conikal_p_receiver_r_field'] : 'required';
$p_position = isset($conikal_petition_fields_settings['conikal_p_position_field']) ? $conikal_petition_fields_settings['conikal_p_position_field'] : 'enabled';
$p_position_r = isset($conikal_petition_fields_settings['conikal_p_position_r_field']) ? $conikal_petition_fields_settings['conikal_p_position_r_field'] : 'required';
$p_goal = isset($conikal_prop_fields_settings['conikal_p_goal_field']) ? $conikal_prop_fields_settings['conikal_p_goal_field'] : '';
$p_goal_r = isset($conikal_prop_fields_settings['conikal_p_goal_r_field']) ? $conikal_prop_fields_settings['conikal_p_goal_r_field'] : '';
$p_goal_d = isset($conikal_prop_fields_settings['conikal_p_goal_default_field']) ? $conikal_prop_fields_settings['conikal_p_goal_default_field'] : '100';
$p_video = isset($conikal_petition_fields_settings['conikal_p_video_field']) ? $conikal_petition_fields_settings['conikal_p_video_field'] : 'enabled';
$p_media_upload = isset($conikal_petition_fields_settings['conikal_p_media_upload_field']) ? $conikal_petition_fields_settings['conikal_p_media_upload_field'] : 'enabled';
$p_media_upload = $p_media_upload === 'enabled' ? true : false; 
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
                $id = get_the_ID();
                $link = get_permalink($id);
                $title = get_the_title($id);
                $content = get_the_content($id);
                $category =  wp_get_post_terms($id, 'petition_category', true);
                $category_id = $category ? $category[0]->term_id : '';
                $topics =  wp_get_post_terms($id, 'petition_topics');
                $excerpt = conikal_get_excerpt_by_id($id);
                $comments = wp_count_comments($id);
                $gallery = get_post_meta($id, 'petition_gallery', true);
                $images = explode("~~~", $gallery);
                $video = get_post_meta($id, 'petition_video', true);
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
                $decisionmakers = get_post_meta($id, 'petition_decisionmakers', true);
                $decisionmakers = explode(',', $decisionmakers);
                $goal = get_post_meta($id, 'petition_goal', true);
                $sign = get_post_meta($id, 'petition_sign', true);
                $updates = get_post_meta($id, 'petition_update', true);
                $thumb = get_post_meta($id, 'petition_thumb', true);
                $status = get_post_meta($id, 'petition_status', true);
                $post_author_id = get_post_field( 'post_author', $id );
                $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
                $attach_id = get_post_thumbnail_id($id);

            }
        }
        wp_reset_postdata();
        wp_reset_query();
    } else {
        $edit_id = isset($_GET['edit_id']) ? sanitize_text_field($_GET['edit_id']) : '';
        $link = get_permalink($edit_id);
    }
?>
<?php if ( $post_author_id == $current_user->ID || current_user_can('editor') || current_user_can('administrator') ) { ?>
    <div id="wrapper" class="wrapper">
        <div class="color silver">
            <div class="ui large secondary pointing grey menu" id="control-menu">
                <div class="ui container">
                        <a href="<?php echo isset($link) ? $link : '' ?>" class="item" data-bjax><?php _e('Campaign', 'petition') ?></a>
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
                                $page_link = get_permalink($page_id) . '?edit_id=' . $edit_id;
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
                                $page_link = get_permalink($page_id) . '?petition_id=' . $edit_id . '&type=update';
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        ?>
                        <a href="<?php echo ($page_link ? $page_link : '') ?>" class="item" data-bjax><?php _e('Update', 'petition') ?></a>
                        <?php if ( $post_author_id == $current_user->ID || current_user_can('administrator')) { ?>
                        <a href="#" class="active item"><?php _e('Edit', 'petition') ?></a>
                        <?php } ?>
                </div>
            </div>
        </div>
        <div class="ui container submit-petition">
            <div class="ui center aligned header submit-petition-title">
                <div class="content">
                    <?php the_title() ?>
                </div>
            </div>
            <div class="ui centered grid">
                <div class="sixteen wide mobile fourteen wide tablet ten wide computer left aligned column">
                        <div id="save-response" class="respon-message"></div>
                        <div class="ui form">
                        <?php wp_nonce_field('submit_petition_ajax_nonce', 'securitySubmitPetition', true); ?>
                        <input type="hidden" id="current_user" name="current_user" value="<?php echo esc_attr($post_author_id); ?>">
                        <input type="hidden" id="new_id" name="new_id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
                        <input type="hidden" id="new_goal_d" name="new_goal_d" value="<?php echo ($goal ? esc_attr($goal) : esc_attr($p_goal_d) ) ?>">
                        <input type="hidden" name="new_status" id="new_status" value="<?php echo isset($status) ? $status : 0; ?>">

                        <!-- STEP ONE -->
                                <div class="required field">
                                    <label><?php _e('Title', 'petition') ?></label>
                                    <div class="ui large fluid input">
                                        <input type="text" id="new_title" name="new_title" placeholder="<?php esc_html_e('What do you want to achieve?', 'petition'); ?>" value="<?php echo isset($title) ? esc_attr($title) : ''; ?>">
                                    </div>
                                </div>
                                <?php if($p_category != '' && $p_category == 'enabled') { ?>
                                <div class="<?php ($p_category_r == 'required' ? 'required ' : '') ?>field">
                                    <label><?php _e('Category', 'petition') ?></label>                        
                                    <select class="ui dropdown large fluid input category-select" name="new_category" id="new_category">
                                        <option value=""><?php _e('Select a category', 'petition') ?></option>
                                        <?php foreach($cat_terms as $cat_term) { ?>
                                            <option value="<?php echo esc_attr($cat_term->term_id); ?>"><?php echo esc_html($cat_term->name); ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if(isset($category_id)) { ?>
                                        <input type="hidden" id="category_id" value="<?php echo isset($category_id) ? esc_attr($category_id) : ''; ?>">
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            <div class="ui section divider"></div>


                        <!-- STEP TWO -->
                            <h2 class="ui header">
                                <div class="content"><?php _e('Choose a leader', 'petition') ?>
                            </h2>
                                <div class="input-fields-wrap">
                                    <div class="ui grid search decision-search">
                                        <?php if($p_receiver != '' && $p_receiver == 'enabled') { ?>
                                        <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                            <div class="<?php ($p_receiver_r == 'required' ? 'required ' : '') ?>field">
                                                <label><?php _e('Full name', 'petition') ?></label>
                                                <div class="ui large fluid input">
                                                    <input class="prompt" type="text" id="new_receiver" name="new_receiver[]" placeholder="<?php esc_html_e('Who can make this happen?', 'petition'); ?>" value="<?php echo isset($receiver[0]) ? $receiver[0] : ''; ?>">
                                                    <input class="new_decisionmakers" type="hidden" name="new_decisionmakers[]" value="<?php echo isset($decisionmakers[0]) ? $decisionmakers[0] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if($p_position != '' && $p_position == 'enabled') { ?>
                                        <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                            <div class="<?php ($p_position_r == 'required' ? 'required ' : '') ?>field">
                                                <?php if (!wp_is_mobile()) { ?>
                                                    <label><?php _e('Title or organization', 'petition') ?></label>
                                                <?php } ?>
                                                <div class="ui large fluid input">
                                                    <input class="decision-title" type="text" id="new_position" name="new_position[]" placeholder="<?php esc_html_e('What is their position?', 'petition'); ?>" value="<?php echo isset($position[0]) ? $position[0] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="results"></div>
                                    </div>

                                    <?php if($p_receiver != '' && $p_receiver == 'enabled' && isset($receiver)) { 
                                        for ($i=1; $i < count($receiver); $i++) { 
                                            if ($receiver[$i]) { ?>
                                            <div class="ui grid search decision-search">
                                                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                                    <div class="<?php ($p_receiver_r == 'required' ? 'required ' : '') ?>field">
                                                        <div class="ui large fluid input">
                                                            <input class="prompt" type="text" id="new_receiver" name="new_receiver[]" placeholder="<?php esc_html_e('Who can make this happen?', 'petition'); ?>" value="<?php echo esc_html($receiver[$i]) ?>">
                                                            <i class="search icon"></i>
                                                            <input class="new_decisionmakers" type="hidden" name="new_decisionmakers[]" value="<?php echo isset($decisionmakers[$i]) ? $decisionmakers[$i] : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                                    <div class="<?php ($p_position_r == 'required' ? 'required ' : '') ?>field">
                                                        <div class="ui large fluid input">
                                                            <input class="decision-title" type="text" id="new_position" name="new_position[]" placeholder="<?php esc_html_e('What is their position?', 'petition'); ?>" value="<?php echo ($position[$i] ? $position[$i] : '') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="results"></div>
                                                <a href="#" class="remove-field"><i class="inverted circular close link icon"></i></a>
                                            </div>
                                    <?php   }
                                        }
                                    } ?>
                                </div>
                                <div class="ui basic segment" style="padding: 0">
                                    <button class="ui primary tiny right floated button add-field-button"><i class="plus icon"></i><?php _e('Add', 'petition') ?></button>
                                </div>
                                
                                <?php if($p_address != '' && $p_address == 'enabled') { ?>
                                <div class="<?php ($p_address_r == 'required' ? 'required ' : '') ?>field">
                                    <label><?php _e('Add a place', 'petition') ?></label>
                                    <div class="ui large fluid input">
                                        <input type="text" id="new_address" name="new_address" value="<?php echo isset($address) ? esc_attr($address) : ''; ?>" placeholder="<?php esc_html_e('Add a neighborhood, state, city or country', 'petition'); ?>">
                                    <?php if($p_city != '' && $p_city == 'enabled') { ?>
                                        <input type="hidden" id="new_city" name="new_city" value="<?php echo isset($city) ? esc_attr($city) : ''; ?>">
                                    <?php } ?>
                                    <?php if($p_state != '' && $p_state == 'enabled') { ?>
                                        <input type="hidden" id="new_state" name="new_state" value="<?php echo isset($state) ? esc_attr($state) : ''; ?>">
                                    <?php } ?>
                                    <?php if($p_neighborhood != '' && $p_neighborhood == 'enabled') { ?>
                                        <input type="hidden" id="new_neighborhood" name="new_neighborhood" value="<?php echo isset($neighborhood) ? esc_attr($neighborhood) : ''; ?>">
                                    <?php } ?>
                                    <?php if($p_country != '' && $p_country == 'enabled') { ?>
                                        <input type="hidden" id="new_country" name="new_country" value="<?php echo isset($country) ? esc_attr($country) : ''; ?>">
                                    <?php } ?>
                                    <?php if($p_zip != '' && $p_zip == 'enabled') { ?>
                                        <input type="hidden" id="new_zip" name="new_zip" value="<?php echo isset($zip) ? esc_attr($zip) : ''; ?>">
                                    <?php } ?>
                                    <?php if($p_coordinates != '' && $p_coordinates == 'enabled') { ?>
                                        <input type="hidden" id="new_lat" name="new_lat" value="<?php echo isset($lat) ? esc_attr($lat) : ''; ?>">
                                        <input type="hidden" id="new_lng" name="new_lng" value="<?php echo isset($lng) ? esc_attr($lng) : ''; ?>">
                                    <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            <!--<div data-tags-input-name="decision-maker" id="decision-maker"></div>-->

                            <div class="ui section divider"></div>


                        <!-- STEP THREE -->
                            <h2 class="ui header">
                                <div class="content"><?php _e('Explain the problem you want to solve', 'petition') ?>
                            </h2>
                                <div class="required field">
                                    <label><?php _e('Content', 'petition') ?></label>
                                    <div class="ui top attached segment" id="isDesc">
                                    <?php 
                                        $html_content = isset($content) ? $content : '';
                                        $settings = array(
                                            'media_buttons'         => $p_media_upload,
                                            'textarea_rows'         => 10,
                                            'drag_drop_upload'      => true,
                                            'quicktags'             => false,
                                            'dfw'                   => true,
                                            'editor_height'         => '300px',
                                            );
                                        wp_editor($html_content, 'new_content', $settings);
                                    ?>
                                    </div>
                                </div>
                                <?php if($p_topics != '' && $p_topics == 'enabled') { ?>
                                <div class="<?php ($p_topics_r == 'required' ? 'required ' : '') ?>field">
                                    <label><?php _e('Add topics', 'petition') ?></label>
                                    <div class="ui fluid multiple search selection large dropdown" id="topics-search">
                                        <input name="new_topics" id="new_topics" type="hidden">
                                        <i class="dropdown icon"></i>
                                        <div class="default text"><?php _e('Keywords related this petition', 'petition') ?></div>
                                        <div class="menu">
                                        </div>
                                    </div>

                                    <?php if (isset($topics)) { ?>
                                        <?php foreach($topics as $topic) {
                                            echo '<input type="hidden" name="current_topics[]" id="current_topics" value="' . $topic->name . '">'; 
                                        } ?>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            <div class="ui section divider"></div>

                        <!-- STEP FOUR -->
                            <h2 class="ui header">
                                <div class="content"><?php _e('Add a photo or video', 'petition') ?>
                            </h2>
                            <input type="hidden" id="edit_gallery" value="<?php echo isset($gallery) ? esc_attr($gallery) : ''; ?>">
                            <input type="hidden" id="edit_attach" value="<?php echo isset($attach_id) ? esc_attr($attach_id) : ''; ?>">
                            <input type="hidden" id="edit_video" value="<?php echo isset($video) ? esc_attr($video) : ''; ?>">
                            <?php get_template_part('templates/gallery_upload'); ?>
                        </div>
                        <br/>
                        <div class="ui right floated header" style="margin-right: 0">
                            <button class="ui primary large button" id="finish-btn"><?php _e('Save', 'petition') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <?php get_template_part('404') ?>
<?php } ?>

<?php get_footer(); ?>