<?php
/*
Template Name: Petitions Search Results
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
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
<div id="wrapper" class="wrapper read">
<div class="ui container mobile">
    <div class="page-content">
        <div class="ui centered grid">
            <div class="sixteen wide mobile sixteen wide computer column">
                <div class="ui hidden divider"></div>
                <div class="ui fluid category search page-search">
                    <div class="ui icon fluid input">
                      <input class="prompt search-input" type="text" value="<?php echo ($search_key ? esc_html($search_key) : '') ?>" placeholder="<?php esc_html_e('Search...', 'petition') ?>">
                      <i class="search link icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
                <div class="ui hidden divider"></div>
                <p class="ui header"><span class="results-number"><?php echo esc_html($total_p) ?></span> <?php esc_html_e(' results for ', 'petition') ?> "<span class="search-keywords"><?php echo esc_html($search_key) ?></span>"</p>
            </div>
        </div>
        <div class="ui grid">
            <div class="sixteen wide mobile twelve wide computer column">
            <?php if($searched_posts != false) { ?>
                <div class="ui divided padded link items" id="search-results">
                    <?php while ( $searched_posts->have_posts() ) {
                        $searched_posts->the_post();
                        $id = get_the_ID();
                        $link = get_permalink($id);
                        $title = get_the_title($id);
                        $category =  wp_get_post_terms($id, 'petition_category', true);
                        $topics =  wp_get_post_terms($id, 'petition_topics', true);
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
                        $thumb = ( !wp_is_mobile() ? conikal_video_thumbnail($thumb) : $thumb );
                        $status = get_post_meta($id, 'petition_status', true);
                        $petition_uic = get_post_meta($id, 'petition_uic', true);

                        $author_url = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
                        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
                        if($user_avatar != '') {
                            $avatar = $user_avatar;
                        } else {
                            $avatar = get_template_directory_uri().'/images/avatar.svg';
                        }
                        $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );

                        if ( !in_array($city, $search_cities) && $city != '') {
                            array_push($search_cities, $city);
                        }

                        if ( !in_array($state, $search_states) && $state != '') {
                            array_push($search_states, $state);
                        }

                        if ( !in_array($neighborhood, $search_neighborhoods) && $neighborhood != '') {
                            array_push($search_neighborhoods, $neighborhood);
                        }

                        if ( !in_array($category[0]->name, $search_categories) && $category) {
                            $search_categories[$category[0]->term_id] = $category[0]->name;
                        }

                        if ($topics) {
                            foreach ($topics as $topic) {
                                if ( !in_array($topic->name, $search_topics) && $topic) {
                                    $search_topics[$topic->term_id] = $topic->name;
                                }
                            }
                        }

                    ?>
                        <div class="item">
                            <a href="<?php echo esc_url($link) ?>" class="image">
                                <?php if ($sign >= $goal || $status == '1') { ?>
                                    <span class="ui primary left corner label victory-label">
                                            <i class="flag icon"></i>
                                    </span>
                                <?php } ?>
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
                            <div class="content">
                                <div class="sub header truncate"><i class="filter icon"></i><a href="<?php echo esc_url($link) ?>" data-bjax> <?php echo esc_html($petition_uic) ?></a></div>
                                <a class="header list-petition-title" href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                <div class="description">
                                    <div class="text grey"><?php echo esc_html($excerpt) ?></div>
                                </div>
                                <div class="extra">
                                    <?php if ( !wp_is_mobile() ) { ?> 
                                        <div class="ui right floated tiny header">
                                            <a href="<?php echo esc_url($author_url) ?>">
                                                <strong><?php the_author() ?></strong>
                                                <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
                                            </a>
                                        </div>
                                        <div class="ui primary label"><i class="user icon"></i><?php echo conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') ?></div>
                                        <div class="ui label"><i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition'); ?></div>
                                        <?php if($category) { ?>
                                            <a class="ui label" href="<?php echo get_category_link($category[0]->term_id) ?>">
                                                <i class="tag icon"></i><?php echo esc_html($category[0]->name); ?>
                                            </a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="ui right floated tiny header">
                                            <a href="<?php echo esc_url($author_url) ?>">
                                                <img class="ui avatar bordered image" src="<?php echo esc_url($avatar) ?>" alt="<?php the_author() ?>" />
                                            </a>
                                        </div>
                                        <div class="ui primary label"><i class="user icon"></i><?php echo conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition'); ?></div>
                                        <div class="ui label"><i class="comments icon"></i><?php echo conikal_format_number('%!,0i', $comments->approved, true) ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <br/>

                <!-- PAGINATION -->
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

                <?php } else {
                    print '<div class="not-found" id="content">';
                    print '<div class="ui warning message">' . __('No petitions found.', 'petition') . '</div>';
                    print '</div>';
                }
                wp_reset_query();
                ?>
            </div>
            <div class="sixteen wide mobile four wide computer column">
                <div class="ui dividing header"><i class="filter icon"></i><?php esc_html_e('Filter', 'petition') ?></div>
                <form class="ui form" id="form-filter">
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
                    <div class="grouped fields">
                        <label><?php esc_html_e('Category', 'petition') ?></label>
                        <?php foreach ($search_categories as $id => $category) { ?>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="search_category[]" value="<?php echo esc_html($id) ?>" tabindex="0" class="hidden">
                                    <label><?php echo esc_html($category) ?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($search_neighborhoods && $filter_neighborhood == 'enabled') { ?>
                    <div class="grouped fields">
                        <label><?php esc_html_e('Neighborhood', 'petition') ?></label>
                        <?php foreach ($search_neighborhoods as $neighborhood) { ?>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="search_neighborhood[]" value="<?php echo esc_html($neighborhood) ?>" tabindex="0" class="hidden">
                                    <label><?php echo esc_html($neighborhood) ?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($search_cities && $filter_city == 'enabled') { ?>
                    <div class="grouped fields">
                        <label><?php esc_html_e('City', 'petition') ?></label>
                        <?php foreach ($search_cities as $city) { ?>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="search_city[]" value="<?php echo esc_attr($city) ?>" tabindex="0" class="hidden">
                                    <label><?php echo esc_html($city) ?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($search_states && $filter_state == 'enabled') { ?>
                    <div class="grouped fields">
                        <label><?php esc_html_e('State', 'petition') ?></label>
                        <?php foreach ($search_states as $state) { ?>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="search_state[]" value="<?php echo esc_html($state) ?>" tabindex="0" class="hidden">
                                    <label><?php echo esc_html($state) ?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($filter_country == 'enabled') { ?>
                    <div class="field">
                        <label><?php esc_html_e('Country', 'petition') ?></label>
                        <?php echo conikal_search_country_list('all') ?>
                    </div>
                <?php } ?>

                <div class="field right aligned">
                    <a href="javascript:void(0)" class="ui tiny button" id="reset-filter"><?php esc_html_e('Reset Filter', 'petition') ?></a>
                </div>
                <?php wp_nonce_field('load_petitions_ajax_nonce', 'securitySearch', true); ?>

                </form>
            </div>
        </div>
    </div>  

</div>
</div>

<?php get_footer(); ?>