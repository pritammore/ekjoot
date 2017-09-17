<?php
/*
Template Name: Submit Petition
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
$conikal_petition_fields_settings = get_option('conikal_petition_fields_settings');
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
$p_goal = isset($conikal_petition_fields_settings['conikal_p_goal_field']) ? $conikal_petition_fields_settings['conikal_p_goal_field'] : 'disabled';
$p_goal_r = isset($conikal_petition_fields_settings['conikal_p_goal_r_field']) ? $conikal_petition_fields_settings['conikal_p_goal_r_field'] : 'required';
$p_goal_d = isset($conikal_petition_fields_settings['conikal_p_goal_default_field']) ? $conikal_petition_fields_settings['conikal_p_goal_default_field'] : '100';
$p_video = isset($conikal_petition_fields_settings['conikal_p_video_field']) ? $conikal_petition_fields_settings['conikal_p_video_field'] : 'enabled';
$p_media_upload = isset($conikal_petition_fields_settings['conikal_p_media_upload_field']) ? $conikal_petition_fields_settings['conikal_p_media_upload_field'] : 'enabled';
$p_media_upload = $p_media_upload === 'enabled' ? true : false; 

?>

<div id="wrapper" class="wrapper">
    <div class="ui container submit-petition">
        <div class="ui center aligned header submit-petition-title">
            <div class="content">
                <?php the_title() ?>
            </div>
        </div>
        <!-- STEP BY STEP TITLE -->
        <div class="ui centered left aligned grid tablet computer only" style="margin-top:20px"> 
            <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
                <div class="ui four top ordered steps">
                    <div class="active step" id="step-one">
                        <div class="content">
                          <a href="#" class="title" data-tab="step-one"><?php _e('Title', 'petition') ?></a>
                        </div>
                    </div>
                    <div class="disabled step" id="step-two">
                        <div class="content">
                          <a href="#" class="title" data-tab="step-two"><?php _e('Invite Leader', 'petition') ?></a>
                        </div>
                    </div>
                    <div class="disabled step" id="step-three">
                        <div class="content">
                          <a href="#" class="title" data-tab="step-three"><?php _e('Problem', 'petition') ?></a>
                        </div>
                    </div>
                    <div class="disabled step" id="step-four">
                        <div class="content">
                          <a href="#" class="title" data-tab="step-four"><?php _e('Photo', 'petition') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP BY STEP CONTENT -->
        <div class="ui centered left aligned grid">
            <div class="sixteen wide mobile fourteen wide tablet ten wide computer column">
                <div id="save-response" class="respon-message"></div>
                <div class="ui form">
                    <?php wp_nonce_field('submit_petition_ajax_nonce', 'securitySubmitPetition', true); ?>
                    <input type="hidden" id="current_user" name="current_user" value="<?php echo esc_attr($current_user->ID); ?>">
                    <input type="hidden" id="new_id" name="new_id" value="">
                    <input type="hidden" name="new_status" id="new_status" value="0">
                    <!-- STEP ONE -->
                    <div class="ui active tab step-one" data-tab="step-one">
                        <h2 class="ui header">
                            <div class="content"><?php _e('Write your petition title', 'petition') ?>
                                <div class="sub header">
                                    <p><?php _e('This is the first thing people will see about your petition. Get their attention with a short title that focuses on the change you’d like them to support.', 'petition') ?></p>
                                </div>
                            </div>
                        </h2>
                        <div class="required field">
                            <label><?php _e('Title', 'petition') ?></label>
                            <div class="ui large fluid input">
                                <input type="text" id="new_title" name="new_title" placeholder="<?php esc_html_e('What do you want to achieve?', 'petition'); ?>" value="">
                            </div>
                        </div>
                        <?php if ($p_goal != '' && $p_goal == 'enabled') { ?>
                            <div class="two fields">
                                <div class="<?php ($p_goal_r == 'required' ? 'required ' : '') ?>field">
                                    <label><?php _e('Goal', 'petition') ?></label>
                                    <div class="ui large fluid input">
                                        <input type="text" id="new_goal_d" name="new_goal_d" value="" placeholder="<?php esc_html_e('Number of signature goal?', 'petition'); ?>">
                                    </div>
                                </div>
                        <?php } else { ?>
                                <input type="hidden" id="new_goal_d" name="new_goal_d" value="<?php echo esc_attr($p_goal_d); ?>">
                        <?php } ?>
                        <?php if($p_category != '' && $p_category == 'enabled') { ?>
                                <div class="<?php ($p_category_r == 'required' ? 'required ' : '') ?>field">
                                    <label><?php _e('Category', 'petition') ?></label>                        
                                    <select class="ui dropdown large fluid input category-select" name="new_category" id="new_category">
                                        <option value=""><?php _e('Select a category', 'petition') ?></option>
                                        <?php foreach($cat_terms as $cat_term) { ?>
                                            <option value="<?php echo esc_attr($cat_term->term_id); ?>"><?php echo esc_html($cat_term->name); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        <?php if ($p_goal != '' && $p_goal == 'enabled') { ?>
                            </div>
                        <?php } ?>
                        <?php } ?>
                        <div class="ui hidden divider"></div>
                        
                        <div class="ui accordion">
                            <div class="title">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('How to write a great title?', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content">
                                <div class="ui large bulleted list">
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Keep it short and to the point', 'petition') ?></div>
                                            <div class="description"><?php _e('Example: "Buy organic, free-range eggs for your restaurants".', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Focus on the solution', 'petition') ?></div>
                                            <div class="description"><?php _e('Example: "Raise the minimum wage in Minneapolis to $15 an hour".', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Communicate urgency', 'petition') ?></div>
                                            <div class="description"><?php _e('Example: "Approve life-saving medication for my daughter’s insurance before it’s too late".', 'petition') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- STEP TWO -->
                    <div class="ui tab step-two" data-tab="step-two">
                        <h2 class="ui header">
                            <div class="content"><?php _e('Choose a leader', 'petition') ?>
                                <div class="sub header">
                                    <p><?php _e('This is the person, organization, or group that can make a leader about your petition. We will send them updates on your petition and encourage a response.', 'petition') ?></p>
                                </div>
                            </div>
                        </h2>
                            <div class="input-fields-wrap">
                                <div class="ui grid search decision-search">
                                    <?php if($p_receiver != '' && $p_receiver == 'enabled') { ?>
                                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                                        <div class="<?php ($p_receiver_r == 'required' ? 'required ' : '') ?>field">
                                            <label><?php _e('Full name', 'petition') ?></label>
                                            <div class="ui large fluid input">
                                                <input class="prompt" type="text" id="new_receiver" name="new_receiver[]" placeholder="<?php esc_html_e('Who can make this happen?', 'petition'); ?>" value="">
                                                <input class="new_decisionmakers" type="hidden" name="new_decisionmakers[]" value="">
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
                                                <input class="decision-title" type="text" id="new_position" name="new_position[]" placeholder="<?php esc_html_e('What is their position?', 'petition'); ?>" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="results"></div>
                                </div>
                            </div>
                            <div class="ui basic segment" style="padding: 0">
                                <button class="ui primary tiny right floated button add-field-button"><i class="plus icon"></i><?php _e('Add', 'petition') ?></button>
                            </div>
                            
                            <?php if($p_address != '' && $p_address == 'enabled') { ?>
                            <div class="<?php ($p_address_r == 'required' ? 'required ' : '') ?>field">
                                <label><?php _e('Add a place', 'petition') ?></label>
                                <div class="ui large fluid input">
                                    <input type="text" id="new_address" name="new_address" value="" placeholder="<?php esc_html_e('Add a neighborhood, state, city or country', 'petition'); ?>" value="">
                                <?php if($p_city != '' && $p_city == 'enabled') { ?>
                                    <input type="hidden" id="new_city" name="new_city" value="">
                                <?php } ?>
                                <?php if($p_state != '' && $p_state == 'enabled') { ?>
                                    <input type="hidden" id="new_state" name="new_state" value="">
                                <?php } ?>
                                <?php if($p_neighborhood != '' && $p_neighborhood == 'enabled') { ?>
                                    <input type="hidden" id="new_neighborhood" name="new_neighborhood" value="">
                                <?php } ?>
                                <?php if($p_country != '' && $p_country == 'enabled') { ?>
                                    <input type="hidden" id="new_country" name="new_country" value="">
                                <?php } ?>
                                <?php if($p_zip != '' && $p_zip == 'enabled') { ?>
                                    <input type="hidden" id="new_zip" name="new_zip" value="">
                                <?php } ?>
                                <?php if($p_coordinates != '' && $p_coordinates == 'enabled') { ?>
                                    <input type="hidden" id="new_lat" name="new_lat" value="">
                                    <input type="hidden" id="new_lng" name="new_lng" value="">
                                <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        <!--<div data-tags-input-name="decision-maker" id="decision-maker"></div>-->

                        <div class="ui hidden divider"></div>

                        <div class="ui accordion">
                            <div class="title">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('How to find the right leader?', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content">
                                <div class="ui large bulleted list">
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Choose someone who can give you what you want', 'petition') ?></div>
                                            <div class="description"><?php _e('You might need to do some research to find the right person who can make or influence the leader.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Do not go straight to the top', 'petition') ?></div>
                                            <div class="description"><?php _e('You might see faster results if you choose a more junior person who is petitioned less often than more recognizable figures.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Choose someone you can work with', 'petition') ?></div>
                                            <div class="description"><?php _e('Your petition is most likely to win by reaching an agreement with your leader.', 'petition') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- STEP THREE -->
                    <div class="ui tab step-three" data-tab="step-three">
                        <h2 class="ui header">
                            <div class="content"><?php _e('Explain the problem', 'petition') ?>
                                <div class="sub header">
                                    <p><?php _e('People are more likely to support your petition if it’s clear why you care. Explain how this change will impact you, your family, or your community.', 'petition') ?></p>
                                </div>
                            </div>
                        </h2>
                        <div class="required field">
                            <label><?php _e('Content', 'petition') ?></label>
                            <div class="ui top attached segment" id="isDesc">
                            <?php 
                                $html_content = isset($edit_content) ? $edit_content : '';
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
                        <div class="<?php echo ($p_topics_r == 'required' ? esc_html('required ') : '') ?>field">
                            <label><?php _e('Add topics', 'petition') ?></label>
                            <div class="ui fluid multiple search selection large dropdown" id="topics-search">
                                <input name="new_topics" id="new_topics" type="hidden">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php _e('Keywords related this petition', 'petition') ?></div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="ui hidden divider"></div>

                        <div class="ui accordion">
                            <div class="title">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('How to inspire your readers to action?', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content">
                                <div class="ui large bulleted list">
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Describe the people involved and the problem they are facing', 'petition') ?></div>
                                            <div class="description"><?php _e('Readers are most likely to take action when they understand who is affected.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Describe the solution', 'petition') ?></div>
                                            <div class="description"><?php _e('Explain what needs to happen and who can make the change. Make it clear what happens if you win or lose.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Make it personal', 'petition') ?></div>
                                            <div class="description"><?php _e('Readers are more likely to sign and support your petition if it’s clear why you care.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Respect others', 'petition') ?></div>
                                            <div class="description"><?php _e('Don’t bully, use hate speech, threaten violence or make things up.', 'petition') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP FOUR -->
                    <div class="ui tab step-four" data-tab="step-four">
                        <h2 class="ui header">
                            <div class="content"><?php _e('Add a photo or video', 'petition') ?>
                                <div class="sub header">
                                    <p><?php _e('Petitions with a photo or video receive six times more signatures than those without. Include one that captures the emotion of your story.', 'petition') ?></p>
                                </div>
                            </div>
                        </h2>
                        <?php get_template_part('templates/gallery_upload'); ?>
                        <div class="ui hidden divider"></div>

                        <div class="ui accordion">
                            <div class="title">
                                <h3 class="ui header">
                                <i class="dropdown icon"></i>
                                <?php _e('Tips for adding a photo or video', 'petition') ?>
                                </h3>
                            </div>
                            <div class="content">
                                <div class="ui large bulleted list">
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Choose a photo that captures the emotion of your petition', 'petition') ?></div>
                                            <div class="description"><?php _e('Photos of people or animals work well.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Try to upload photos that are 1600 x 900 pixels or larger', 'petition') ?></div>
                                            <div class="description"><?php _e('Large photos look good on all screen sizes.', 'petition') ?></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="content">
                                            <div class="header"><?php _e('Keep it friendly for all audiences', 'petition') ?></div>
                                            <div class="description"><?php _e('Make sure your photo doesn’t include graphic violence or sexual content.', 'petition') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="ui grid">
                    <div class="eight wide left aligned column" style="margin-left: 0">
                        <button class="ui left labeled icon large button" id="back-one" style="display: none"><i class="arrow left icon"></i><?php _e('Back', 'petition') ?></button>
                        <button class="ui left labeled icon large button" id="back-two" style="display: none"><i class="arrow left icon"></i><?php _e('Back', 'petition') ?></button>
                        <button class="ui left labeled icon large button" id="back-three" style="display: none"><i class="arrow left icon"></i><?php _e('Back', 'petition') ?></button>
                    </div>
                    <div class="eight wide right aligned column" style="margin-right: 0">
                        <button class="ui primary right labeled icon large button" id="next-two"><?php _e('Next', 'petition') ?><i class="arrow right icon"></i></button>
                        <button class="ui primary right labeled icon large button" id="next-three" style="display: none"><?php _e('Next', 'petition') ?><i class="arrow right icon"></i></button>
                        <button class="ui primary right labeled icon large button" id="next-four" style="display: none"><?php _e('Next', 'petition') ?><i class="arrow right icon"></i></button>
                        <button class="ui primary right labeled icon large button" id="finish-btn" style="display: none"><?php _e('Finish', 'petition') ?><i class="send icon"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>