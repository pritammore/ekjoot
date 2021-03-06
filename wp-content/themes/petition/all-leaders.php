<?php
/*
Template Name: All Leaders
*/

/**
 * @package WordPress
 * @subpackage Petition
 */

get_header();
$current_user = wp_get_current_user();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
$posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';

//$users = get_users(); # Was used for showing leader's followers
$conikal_general_settings = get_option('conikal_general_settings','');

$keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$paged = 1;
$args = array(
    'post_type' => 'decisionmakers',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'post_status' => array('publish'),
    's' => $keyword
);
$args['meta_query'] = array('relation' => 'AND');

array_push($args['meta_query'], array(
    'key'     => 'post_whomi',
    'value'   => 0,
    'type'    => 'NUMERIC',
    'compare' => '='
));

$decisionmakers = new WP_Query($args);
//echo "Last SQL-Query: {$decisionmakers->request}";exit;
wp_reset_query();
wp_reset_postdata();

$arrayDecisionmakers = array();
if($decisionmakers->have_posts()) {
    while ( $decisionmakers->have_posts() ) {
        $decisionmakers->the_post();
        $id = get_the_ID();
        $name = get_the_title($id);
        $title =  wp_get_post_terms($id, 'decisionmakers_title', true);
        $title_name = ($title ? $title[0]->name : '');
        $organization =  wp_get_post_terms($id, 'decisionmakers_organization', true);
        $organization_name = ($organization ? $organization[0]->name : '');
        $excerpt = conikal_get_excerpt_by_id($id);
        $author = get_the_author_meta('ID');
        $user_data = get_userdata(intval($author));
        $user_login_name = $user_data->data->user_login;
        $file = home_url( '/' );
        $link = $file . 'author/'. $user_login_name;

        $arrayDecision = array(
                'id' => $id, 
                'link' => $link,
                'name' => $name,
                'title' => $title_name,
                'organization' => $organization_name,
                'description' => $title_name . __(' of ', 'petition') . $organization_name,
                'excerpt' => $excerpt,
                'avatar' => $avatar,
                'author' => $author,
            );

        $arrayDecision = (object) $arrayDecision;
        array_push($arrayDecisionmakers, $arrayDecision);
    }
}
//echo "<pre>"; print_r($arrayDecisionmakers); echo "</pre>";
?>
<!-- <div id="wrapper" class="wrapper read">
<div class="ui container mobile">
    <div class="page-content"> -->
<br/><br/><br/>
<div class="ui container mobile-full">
    <div class="ui grid">    
    <br/>
    <div class="ui grid mobile-full">
        <?php if($sidebar_position == 'left') { ?>
        <div class="five wide column computer only">
            <?php get_sidebar(); ?>
        </div>
        <?php } ?>

        <div class="sixteen wide mobile sixteen wide computer column">
            <div class="ui hidden divider"></div>
            <div class="field left"><h3 class="ui header widget-title">Support an Issue. Enter the Unique Issue Code here.</h3></div>
            <!-- <div class="ui hidden divider"></div> -->
            <div class="ui fluid category search petitions-search focus">
                <div class="ui icon fluid input">
                  <input class="prompt search-input" type="text" placeholder="<?php esc_html_e('UIC Code / Title / Catergory', 'petition') ?>">
                  <i class="search link icon"></i>
                </div>
            </div>
            <!-- <div class="ui hidden divider"></div> -->
        </div>

        <div class="sixteen wide mobile eleven wide computer column mobile-full" id="main-content">
            <div class="ui sticky" id="tab-sticky" style="margin-top: 0px;">
                <div class="ui pointing secondary menu" id="petition-tab">
                    <a class="item active" data-tab="newsfeed" id="newsfeed"><?php echo ( !is_user_logged_in() ? '<i class="fire icon"></i>' . __('Individual', 'petition') : '<i class="newspaper icon"></i>' . __('Individual', 'petition') ) ?></a>
                    <a class="item" data-tab="institutions" id="institutions"><i class="lightning icon"></i><?php _e('Institutional', 'petition') ?></a>
                </div>
            </div>
            <br/>
            <div class="ui tab active" data-tab="newsfeed">
                <div id="content">
                <!-- PUPULAR PETITION -->
                <?php
                if(count($arrayDecisionmakers)>0) {
                    foreach ( $arrayDecisionmakers as $decisionmakers ) {
                        $up_id = $decisionmakers->ID;
                        $up_link = $decisionmakers->link;
                        $up_decisionmaker_name = $decisionmakers->name;
                        $up_author_id = $decisionmakers->author;
                        $up_author_name = $decisionmakers->title_name;
                        $up_details = get_user_by( 'ID', $up_author_id );
                        $up_bio = conikal_get_biographical_by_id($up_author_id);
                        $up_type = get_user_meta($up_author_id, 'user_type', true);
                        $up_birthday = get_user_meta($up_author_id, 'user_birthday', true);
                        $up_gender = get_user_meta($up_author_id, 'user_gender', true);
                        $up_address = get_user_meta($up_author_id, 'user_address', true);
                        $up_pincode = get_user_meta($up_author_id, 'user_pincode', true);
                        $up_neighborhood = get_user_meta($up_author_id, 'user_neighborhood', true);
                        $up_state = get_user_meta($up_author_id, 'user_state', true);
                        $up_city = get_user_meta($up_author_id, 'user_city', true);
                        $up_country = get_user_meta($up_author_id, 'user_country', true);
                        $up_lat = get_user_meta($up_author_id, 'user_lat', true);
                        $up_lng = get_user_meta($up_author_id, 'user_lng', true);

                        $user_meta = get_user_meta($up_author_id);
                        $up_avatar_orginal = get_user_meta($up_author_id, 'avatar_orginal', true);
                        $up_avatar_id = get_user_meta($up_author_id, 'avatar_id', true);
                        if ($up_avatar_orginal != '') {
                            $avatar = $up_avatar_orginal;
                        } else {
                            $avatar = get_template_directory_uri().'/images/avatar.svg';
                        }

                        $author_petitions = conikal_author_petitions($up_author_id);

                        if($author_petitions) {
                            $total_p = $author_petitions->found_posts;
                        } else {
                            $total_p = 0;
                        }

                        /*$following = $up_details->follow_user;
                        $followers = array();
                        foreach ($users as $user) {
                            $follow_user = get_user_meta($user->data->ID, 'follow_user', true);
                            if(is_array($follow_user) && in_array($up_details->ID, $follow_user)) {
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
                        }*/
                        $decision_id = get_user_meta($up_author_id, 'user_decision', true);
                        $decision_status = get_post_status( $decision_id );
                        $decision_title = wp_get_post_terms( $decision_id, 'decisionmakers_title' );
                        $decision_title = $decision_title ? $decision_title[0]->name : '';
                        $decision_organization = wp_get_post_terms($decision_id, 'decisionmakers_organization');
                        $decision_organization = $decision_organization ? $decision_organization[0]->name : '';
                    ?>
                    <div class="ui segments petition-list-card">
                        <div class="ui segment">
                            <div class="ui grid">
                                <div class="sixteen wide mobile six wide tablet six wide computer column" style="width:15% !important;float: left">
                                    <a class="ui fluid" href="<?php echo esc_url($up_link) ?>" target="_blank" data-bjax>
                                        <img class="ui image" src="<?php echo esc_url($avatar) ?>" alt="<?php echo esc_attr($title) ?>">
                                    </a>
                                </div>
                                <div class="sixteen wide mobile ten wide tablet ten wide computer column" style="width:85% !important;float: left">
                                    <div class="">
                                        <div class="ui grid">
                                            <div class="sixteen wide column">
                                                <div class="ui header mar-bot2">
                                                    <div class="content">
                                                        <a href="<?php echo esc_url($up_link) ?>" data-bjax><?php echo esc_html($up_decisionmaker_name) ?></a>
                                                    </div>
                                                </div>
                                                <?php if ($up_bio) { ?>
                                                <span class="text grey"><?php echo ($up_bio ? esc_html($up_bio):'') ?></span><br>
                                                <?php } ?>
                                                <div class="col-sm-12 mar-top10">
                                                    <?php if ($decision_title) { ?>
                                                    <div class="col-sm-6">
                                                        <div class="">
                                                            <strong>
                                                                <?php esc_html_e('Title', 'Title') ?> : 
                                                                <?php echo ($decision_title ? esc_html($decision_title):''); ?>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($decision_organization) { ?>
                                                    <div class="col-sm-6">
                                                        <div class="">
                                                            <strong>
                                                                <?php esc_html_e('Organization', 'Organization') ?> : 
                                                                <?php echo ($decision_organization ? esc_html($decision_organization):''); ?>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    } else {
                        print '<div class="not-found" id="content">';
                        print '<div class="ui warning message">' . __('No Leader found.', 'decisionmakers') . '</div>';
                        print '</div>';
                    }
                    ?>
                </div>
                <br/>
                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-more-leaders" data-page="2" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="conikal_load_leadersfeed"><i class="long arrow down icon"></i><?php echo __('Load more...', 'decisionmakers'); ?></button>
            </div>  
            <div class="ui tab" data-tab="institutions">
                <div id="content-institutions">
                </div>
                <br/>
                <!-- LOAD MORE BUTTON -->
                <button class="ui basic fluid large button" id="load-more-institutions" data-page="1" data-number="<?php echo esc_attr($posts_per_page) ?>" data-author="<?php echo esc_attr($current_user->ID) ?>" data-type="conikal_load_institutionsfeed"><i class="long arrow down icon"></i><?php echo __('Load more...', 'decisionmakers'); ?></button>
            </div>
        </div>
        <?php wp_nonce_field('load_petitions_ajax_nonce', 'securityPetitions', true); ?>
        <!-- SIDEBAR RIGHT -->
        <?php if($sidebar_position == 'right') { ?>
        <div class="five wide column computer only">
            <?php get_sidebar(); ?>
        </div>
        <?php } ?>
    </div>
</div>

<!-- </div>
</div>
</div> -->
<?php get_footer(); ?>