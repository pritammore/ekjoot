<?php
/*
Template Name: All Petitions
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';
$show_type_label = isset($conikal_appearance_settings['conikal_type_label_field']) ? $conikal_appearance_settings['conikal_type_label_field'] : '';
$conikal_filter_settings = get_option('conikal_filter_settings','');
$filter_category = isset($conikal_filter_settings['conikal_f_category_field']) ? $conikal_filter_settings['conikal_f_category_field'] : 'enabled';
$filter_topic = isset($conikal_filter_settings['conikal_f_topic_field']) ? $conikal_filter_settings['conikal_f_topic_field'] : 'enabled';
$filter_country = isset($conikal_filter_settings['conikal_f_country_field']) ? $conikal_filter_settings['conikal_f_country_field'] : 'disabled';
$filter_state = isset($conikal_filter_settings['conikal_f_state_field']) ? $conikal_filter_settings['conikal_f_state_field'] : 'enabled';
$filter_city = isset($conikal_filter_settings['conikal_f_city_field']) ? $conikal_filter_settings['conikal_f_city_field'] : 'enabled';
$filter_neighborhood = isset($conikal_filter_settings['conikal_f_neighborhood_field']) ? $conikal_filter_settings['conikal_f_neighborhood_field'] : 'enabled';

$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';
$search_key = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$searched_posts = conikal_search_petitions();
$total_p = $searched_posts->found_posts;
$users = get_users();
$search_cities = array();
$search_states = array();
$search_neighborhoods = array();
$search_categories = array();
$search_topics = array();
?>
<div id="wrapper">
<div class="ui container mobile">
    <div class="page-content">
        <?php if($show_bc != '') {
            conikal_petition_breadcrumbs();
        } ?>
        <div class="ui three stackable cards petition-cards"">
                <?php if($searched_posts != false) { ?>
                    <?php while ( $searched_posts->have_posts() ) {
                        $searched_posts->the_post();
                        $id = get_the_ID();
                        $link = get_permalink($id);
                        $title = get_the_title($id);
                        $category =  wp_get_post_terms($id, 'petition_category', true);
                        $topics =  wp_get_post_terms($id, 'petition_topics', true);
                        $excerpt = conikal_get_excerpt_by_id($id, 15);
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
                        $thumb = ( !wp_is_mobile() ? conikal_video_thumbnail($thumb) : $thumb );
                        $status = get_post_meta($id, 'petition_status', true);

                        $author_url = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
                        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
                        if($user_avatar != '') {
                            $avatar = $user_avatar;
                        } else {
                            $avatar = get_template_directory_uri().'/images/avatar.svg';
                        }
                        $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );

                        if ($topics) {
                            foreach ($topics as $topic) {
                                if ( !in_array($topic->name, $search_topics) && $topic) {
                                    $search_topics[$topic->term_id] = $topic->name;
                                }
                            }
                        }

                    ?>
                        <div class="card petition-card">
                            <?php if ($sign >= $goal || $status == '1') { ?>
                                <span class="ui primary right large corner label victory-label">
                                    <?php echo conikal_custom_icon('victory') ?>
                                </span>
                            <?php } ?>
                            <a href="<?php echo esc_url($link) ?>"  target="_blank" class="image blurring">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <div class="ui icon inverted circular big button"><i class="external icon"></i></div>
                                        </div>
                                        <?php if ($country || $state || $city) { ?>
                                            <div class="petition-location"><i class="marker icon"></i><?php echo ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></div>
                                        <?php } ?>
                                        <?php if ($view_counter != '') { ?>
                                        <div class="view-counter">
                                            <i class="eye icon"></i>
                                            <?php echo esc_html($view); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if(has_post_thumbnail()) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url(the_post_thumbnail_url('petition-thumbnail')) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($gallery) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url($images[1]) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } elseif ($thumb) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url($thumb) ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } else { ?>
                                    <img class="ui fluid  image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
                                <?php } ?>
                            </a>
                            <div class="content petition-content">
                                <div class="meta">
                                    <span class="receiver"><i class="send icon"></i> <?php _e('Petition to', 'petition') ?> <?php echo esc_html($receiver[0]) ?></span>
                                </div>
                                <div class="header card-petition-title">
                                    <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                </div>
                                <div class="description">
                                    <div class="text grey"><?php echo esc_html($excerpt) ?></div>
                                </div>
                            </div>
                            <div class="extra content">
                                <span class="right floated">
                                    <a href="<?php echo esc_url($author_url) ?>">
                                        <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
                                    </a>
                                </span>
                                <span class="ui primary label"><?php echo conikal_custom_icon('supporter') . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition'); ?></span>
                                <?php if ($comments->approved != 0) { ?>
                                    <span class="ui label"><i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved, true) ?></span>
                                <?php } ?>
                            </div>
                            <div class="ui bottom attached indicating primary progress petition-goal" data-value="<?php echo esc_html($sign) ?>" data-total="<?php echo ($status == '1' ? esc_html($sign) : esc_html($goal) ) ?>">
                                <div class="bar">
                                    <div class="progress"></div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
        </div>

        <!-- PAGINATION -->
        <div class="ui hidden divider"></div>
        <div class="ui two column grid ">
            <div class="column">
                <?php conikal_pagination($searched_posts->max_num_pages) ?>
            </div>
            <div class="right aligned column">
                <?php
                    $conikal_appearance_settings = get_option('conikal_appearance_settings');
                    $per_p_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
                    $per_p = $per_p_setting != '' ? intval($per_p_setting) : 10;
                    $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $from_p = ($page_no == 1) ? 1 : $per_p * ($page_no - 1) + 1;
                    $to_p = ($total_p - ($page_no - 1) * $per_p > $per_p) ? $per_p * $page_no : $total_p;
                    echo esc_html($from_p) . ' - ' . esc_html($to_p) . __(' of ', 'petition') . esc_html($total_p) . __(' Petitions', 'petition');
                ?>
            </div>
        </div>
        <div class="ui hidden divider"></div>

        <!--<div class="ui hidden divider"></div>
        <div class="ui accordion">
            <div class="active title">
                <h3><i class="filter icon"></i><?php esc_html_e('Filter', 'petition') ?></h3>
            </div>
            <div class="active content">
                <form class="ui form" id="form-filter">
                    <div class="two fields">
                    <?php if ($search_topics && $filter_topic == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('Topics', 'petition') ?></label>
                            <div class="ui fluid multiple search selection dropdown" id="search_topics">
                                <input type="hidden" name="search_topics[]">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php esc_html_e('Select Topics', 'petition') ?></div>
                                <div class="menu">
                                <?php foreach ($search_topics as $id => $topic) { ?>
                                    <div class="item" data-value="<?php echo esc_html($id) ?>"><?php echo esc_html($topic) ?></div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($search_categories && $filter_category == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('Category', 'petition') ?></label>
                            <select name="search_category" multiple="" class="ui fluid dropdown">
                                <option value=""><?php _e('Select Category', 'petition') ?></option>
                                <?php foreach ($search_categories as $id => $category) { ?>
                                    <option class="<?php echo esc_html($id) ?>"><?php echo esc_html($category) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    </div>
                    <div class="four fields">

                    <?php if ($search_neighborhoods && $filter_neighborhood == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('Neighborhood', 'petition') ?></label>
                            <select name="search_neighborhood" multiple="" class="ui fluid dropdown">
                                <option value=""><?php _e('Select Neighborhood', 'petition') ?></option>
                                <?php foreach ($search_neighborhoods as $neighborhood) { ?>
                                    <option class="<?php echo esc_html($id) ?>"><?php echo esc_html($neighborhood) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    <?php if ($search_cities && $filter_city == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('City', 'petition') ?></label>
                            <select name="search_city" multiple="" class="ui fluid dropdown">
                                <option value=""><?php _e('Select City', 'petition') ?></option>
                            <?php foreach ($search_cities as $city) { ?>
                                <option class="<?php echo esc_html($id) ?>"><?php echo esc_html($city) ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    <?php if ($search_states && $filter_state == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('State', 'petition') ?></label>
                            <select name="search_state" multiple="" class="ui fluid dropdown">
                                <option value=""><?php _e('Select State', 'petition') ?></option>
                            <?php foreach ($search_states as $state) { ?>
                                <option class="<?php echo esc_html($id) ?>"><?php echo esc_html($state) ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    <?php if ($filter_country == 'enabled') { ?>
                        <div class="field">
                            <label><?php esc_html_e('Country', 'petition') ?></label>
                            <?php echo conikal_search_country_list('all') ?>
                        </div>
                    <?php } ?>

                    </div>

                    <div class="field right aligned">
                        <a href="javascript:void(0)" class="ui tiny button" id="reset-filter"><?php esc_html_e('Reset Filter', 'petition') ?></a>
                    </div>
                    <?php wp_nonce_field('load_petitions_ajax_nonce', 'securitySearch', true); ?>
                </form>
            </div>
        </div>-->
    </div>  
</div>
</div>

<?php get_footer(); ?>