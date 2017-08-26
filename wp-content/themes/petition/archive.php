<?php 

/**
 * @package WordPress
 * @subpackage Petition
 */

global $post;

get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
?>

<div class="ui container">
    <?php if($show_bc != '') {
        conikal_petition_breadcrumbs();
    } else {
        print '<br/>';
    } ?>
    <div class="page content">
        <div class="ui grid">
            <?php if($sidebar_position == 'left') { ?>
            <div class="five wide computer only column">
                <?php get_sidebar('blog'); ?>
            </div>
            <?php } ?>
            <div class="sixteen wide mobile sixteen wide tablet eleven wide computer column" id="content">
                    <?php 
                    $term = get_queried_object();
                    $term_id = $term ? $term->term_id : '';
                    $year     = get_query_var('year');
                    $monthnum = get_query_var('monthnum');
                    $day = get_query_var('day');
                    $temp = isset($postslist) ? $postslist : null;
                    $postslist = null; 
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array( 
                        'posts_per_page' => get_option('posts_per_page'),
                        'paged' => $paged,
                        'post_type' => 'post'
                    );

                    if(is_date()) {
                        $args['year'] = $year;
                        $args['monthnum'] = $monthnum;
                        $args['day'] = $day;
                    } else {
                        $args['tax_query'] = array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'category',
                                'terms'    => $term_id,
                            )
                        );
                        $args['tag_id'] = $term_id;
                    }

                    $postslist = new WP_Query( $args );
                    if ( $postslist->have_posts() ) : ?>
                        <div class="ui two stackable cards">
                        <?php while( $postslist->have_posts() ) : $postslist->the_post();
                            $p_id = get_the_ID();
                            $p_link = get_permalink($p_id);
                            $p_title = get_the_title($p_id);
                            $p_comments = wp_count_comments($p_id);
                            $p_image = wp_get_attachment_image_src( get_post_thumbnail_id( $p_id ), 'petition-thumbnail' );
                            $p_excerpt = conikal_get_excerpt_by_id($p_id);
                            $p_author = get_the_author();
                            $p_categories = get_the_category();
                            $p_date = get_the_date(); ?>

                            <div class="card blogs post">
                                <a href="<?php echo esc_url($p_link); ?>" class="image">
                                    <div class="ui dimmer">
                                        <div class="content">
                                          <div class="center">
                                            <div class="ui icon inverted basic circular big button"><i class="external icon"></i></div>
                                          </div>
                                        </div>
                                    </div>
                                    <?php if (has_post_thumbnail()) { ?>
                                    <img class="ui fluid image" src="<?php echo esc_url($p_image[0]) ?>" alt="<?php echo esc_attr($p_title) ?>">
                                    <?php } else { ?>
                                    <img class="ui fluid image" src="<?php echo get_template_directory_uri() . '/images/thumbnail.svg'; ?>" alt="<?php echo esc_attr($p_title) ?>">
                                    <?php } ?>
                                </a>
                                <div class="content">
                                    <a href="<?php echo esc_url($p_link) ?>" class="header card-post-title"><?php echo esc_html($p_title); ?></a>
                                    <div class="meta">
                                        <?php
                                        $categories = get_the_category();
                                        $separator = ' ';
                                        $output = '';
                                        if($categories) {
                                            foreach($categories as $category) {
                                                $output .= '<a href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "petition" ), $category->name ) ) . '">' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                                            }
                                            echo trim($output, $separator);
                                        }
                                        ?>
                                    </div>
                                    <div class="description text grey">
                                        <?php echo esc_html($p_excerpt); ?>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <?php if($p_comments->approved != 0) { ?>
                                        <span class="right floated">
                                            <i class="comments icon"></i>
                                            <?php echo esc_html($p_comments->approved); ?>
                                        </span>
                                    <?php } ?>
                                    <span><i class="calendar outline icon"></i><?php echo esc_html($p_date); ?></span>
                                </div>
                            </div>

                        <?php 
                        endwhile; ?>
                        </div>
                    <?php else : 
                        print '<div class="not-found" id="content">';
                        print '<div class="ui warning message">' . __('No posts found.', 'petition') . '</div>';
                        print '</div>';
                    endif;
                    wp_reset_postdata();
                    ?>
                <?php $postslist = null;
                $postslist = $temp; ?>
                <br/>
                <?php conikal_pagination() ?>
            </div>
            <?php if($sidebar_position == 'right') { ?>
            <div class="five wide computer only column">
                <?php get_sidebar('blog'); ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>