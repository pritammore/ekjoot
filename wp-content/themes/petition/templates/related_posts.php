<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>

<?php
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';
$related_post_per_page = isset($conikal_appearance_settings['conikal_similar_related_per_page_field']) ? $conikal_appearance_settings['conikal_similar_related_per_page_field'] : 4;
$orig_post = $post;
$tags = wp_get_post_tags($post->ID);

    if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => $related_post_per_page,
            'ignore_sticky_posts' => false
        );

        $my_query = new wp_query($args);
        if($my_query->have_posts()) { ?>
        <div class="ui hidden divider"></div>
        <h2 class="ui header "><?php esc_html_e('Related Articles', 'petition'); ?></h2>
        <div class="title-divider"></div>
        <div class="ui four stackable cards">
        <?php while( $my_query->have_posts() ) {
            $my_query->the_post();
            $r_id = get_the_ID();
            $r_link = get_permalink($r_id);
            $r_title = get_the_title($r_id);
            $r_comments = wp_count_comments($r_id);
            $r_image = wp_get_attachment_image_src( get_post_thumbnail_id( $r_id ), 'petition-thumbnail' );
            $r_excerpt = conikal_get_excerpt_by_id($r_id);
            $r_author = get_the_author();
            $r_categories = get_the_category();
            $r_date = get_the_date();
            $r_view = conikal_format_number('%!,0i', (int) conikal_get_post_views($r_id), true);
        ?>

            <div class="card blogs post petition-card">
                <a href="<?php echo esc_url($r_link); ?>" target="_blank" class="image blurring" data-bjax>
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                            <div class="ui icon inverted circular button"><i class="external icon"></i></div>
                            </div>
                            <div class="view-counter">
                            <i class="comments icon"></i>
                            <?php echo esc_html($r_comments->approved); ?>

                            <?php if ($view_counter != '') { ?>
                                <i class="eye icon"></i>
                                <?php echo esc_html($r_view); ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if (has_post_thumbnail()) { ?>
                    <img class="ui fluid image" src="<?php echo esc_url($r_image[0]) ?>" alt="<?php echo esc_attr($r_title) ?>">
                    <?php } else { ?>
                    <img class="ui fluid image" src="<?php echo get_template_directory_uri() . '/images/thumbnail.svg'; ?>" alt="<?php echo esc_attr($r_title) ?>">
                    <?php } ?>
                </a>
                <div class="content similar-content">
                    <a href="<?php echo esc_url($r_link) ?>" class="header card-post-title" data-bjax><?php echo esc_html($r_title); ?></a>
                    <div class="meta">
                        <?php
                        $categories = get_the_category();
                        $separator = ' ';
                        $output = '';
                        if($categories) {
                            foreach($categories as $category) {
                                $output .= '<a href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "petition" ), $category->name ) ) . '" data-bjax>' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                            }
                            echo trim($output, $separator);
                        }
                        ?>
                    </div>
                    <br/>
                </div>
                <div class="extra content">
                    <?php if($r_comments->approved != 0) { ?>
                        <span class="right floated">
                            <a href="<?php echo esc_url($r_link) ?>" class="header" data-bjax>
                            <i class="comments icon"></i>
                            <?php echo esc_html($r_comments->approved); ?>
                            </a>
                        </span>
                    <?php } ?>
                    <span><i class="calendar outline icon"></i><?php echo esc_html($r_date); ?></span>
                </div>
            </div>
    <?php } ?>
        </div>
        <div class="ui hidden section divider"></div>
    <?php }
    }
    $post = $orig_post;
    wp_reset_query();
    ?>
