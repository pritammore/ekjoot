<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


$current_user = wp_get_current_user();
$orig_post = $post;
$conikal_general_settings = get_option('conikal_general_settings','');
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';
$similar_base = isset($conikal_appearance_settings['conikal_similar_base_field']) ? $conikal_appearance_settings['conikal_similar_base_field'] : 'both';
$similar_per_page = isset($conikal_appearance_settings['conikal_similar_related_per_page_field']) ? $conikal_appearance_settings['conikal_similar_related_per_page_field'] : 4;
$minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : 2;
?>

    <?php
    $orig_categorys =  wp_get_post_terms($post->ID, 'petition_category', array('fields' => 'ids'));
    $orig_topics =  wp_get_post_terms($post->ID, 'petition_topics', array('fields' => 'ids'));

    $exclude_ids = array($post->ID);
    $args = array(
        'posts_per_page' => $similar_per_page,
        'post_type' => 'petition',
        'post_status' => 'publish',
        'post__not_in' => $exclude_ids
    );

    if ($similar_base === 'topics') {
        if($orig_topics) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_topics',
                    'field'    => 'id',
                    'terms'    => $orig_topics,
                ),
            );
        }
    } elseif ($similar_base === 'category') {
        if($orig_categorys) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $orig_categorys,
                )
            );
        }
    } else {
        if($orig_topics && $orig_categorys) {
            $args['tax_query'] = array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'petition_category',
                    'field'    => 'id',
                    'terms'    => $orig_categorys,
                ),
                array(
                    'taxonomy' => 'petition_topics',
                    'field'    => 'id',
                    'terms'    => $orig_topics,
                )
            );
        }
    }

    $args['meta_query'] = array('relation' => 'AND');

    if ($minimum_signature != 0) {
        array_push($args['meta_query'], array(
            'key'     => 'petition_sign',
            'value'   => $minimum_signature,
            'type'    => 'NUMERIC',
            'compare' => '>='
        ));
    }

        array_push($args['meta_query'], array(
            'key'     => 'petition_status',
            'value'   => '2',
            'compare' => '!='
        ));



    $my_query = new wp_query($args);

    if($my_query->have_posts() && $orig_topics && $orig_categorys) { ?>
    <div class="ui hidden divider"></div>
    <h2 class="ui header"><?php esc_html_e('Similar petitions', 'petition'); ?></h2>
    <div class="title-divider"></div>
    <div class="ui four stackable cards petition-cards">
        <?php while( $my_query->have_posts() ) {
            $my_query->the_post();
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
        ?>
        <div class="card petition-card">
            <?php if ($sign >= $goal || $status == '1') { ?>
                <div class="ui primary right corner large label victory-label">
                    <?php echo conikal_custom_icon('victory') ?>
                </div>
            <?php } ?>
            <a href="<?php echo esc_url($link) ?>" class="image blurring" target="_blank" data-bjax>
                <div class="ui dimmer">
                    <div class="content">
                        <div class="center">
                            <div class="ui icon inverted circular button"><i class="external icon"></i></div>
                        </div>
                        <?php if ($country || $state) { ?>
                            <div class="petition-location"><i class="marker icon"></i><?php echo ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') ?></div>
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
                    <img class="ui fluid image" src="<?php echo esc_url(get_template_directory_uri() . '/images/thumbnail.svg') ?>" alt="<?php echo esc_attr($title) ?>">
                <?php } ?>
            </a>
            <div class="content similar-content">
                <div class="header card-petition-title">
                    <a href="<?php echo esc_url($link) ?>" data-bjax><?php echo esc_html($title) ?></a>
                </div>
                <div class="meta">
                    <?php esc_html_e('by ', 'petition') ?> 
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                        <?php the_author() ?>
                    </a>
                </div>
            </div>
            <div class="extra content">
                <span class="ui primary label">
                <?php echo conikal_custom_icon('supporter') ?>
                   <?php echo conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') ?>
                </span>
            <?php if($comments->approved != 0) { ?>
                <span class="ui label">
                    <i class="comments icon"></i>
                    <?php echo conikal_format_number('%!,0i', $comments->approved, true) ?>
                </span>
            <?php } ?>
                
            </div>
            <div class="ui bottom attached indicating primary progress petition-goal" data-value="<?php echo esc_html($sign) ?>" data-total="<?php echo esc_html($goal) ?>">
                <div class="bar">
                    <div class="progress"></div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="ui hidden section divider"></div>

    <?php }
        $post = $orig_post;
        wp_reset_query();
    ?>
