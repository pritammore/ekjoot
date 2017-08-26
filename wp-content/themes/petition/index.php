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
    } ?>
    <div id="wrapper" style="padding-top: 40px;">
        <div class="page content">
            <div class="ui grid">
                <div class="sixteen wide moble sixteen tablet sixteen wide computer column">
                        <?php 
                        $postslist = null;
                        $temp = isset($postslist) ? $postslist : null;
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $posts_per_page = get_option('posts_per_page');
                        $args = array( 
                            'posts_per_page' => $posts_per_page,
                            'paged' => $paged,
                            'post_type' => 'post'
                        );

                        $postslist = new WP_Query( $args );

                        if($postslist) {
                            $total_p = $postslist->found_posts;
                        } else {
                            $total_p = 0;
                        }

                        if ( $postslist->have_posts() ) : ?>
                            <div class="ui three stackable cards petition-cards" id="content">
                            <?php while( $postslist->have_posts() ) : $postslist->the_post();
                                $p_id = get_the_ID();
                                $p_link = get_permalink($p_id);
                                $p_title = get_the_title($p_id);
                                $p_comments = wp_count_comments($p_id);
                                $p_image = wp_get_attachment_image_src( get_post_thumbnail_id( $p_id ), 'petition-thumbnail' );
                                $p_excerpt = conikal_get_excerpt_by_id($p_id, 12);
                                $p_author = get_the_author();
                                $p_categories = get_the_category();
                                $p_date = get_the_date(); ?>

                                <div class="card blogs post petition-card">
                                    <a href="<?php echo esc_url($p_link); ?>" target="_blank" class="image" data-bjax>
                                        <div class="ui dimmer">
                                            <div class="content">
                                              <div class="center">
                                                <div class="ui icon inverted circular big button"><i class="external icon"></i></div>
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
                                        <a href="<?php echo esc_url($p_link) ?>" class="card-post-title" data-bjax><?php echo esc_html($p_title); ?></a>
                                        <?php if($p_comments->approved != 0) { ?>
                                            <span class="ui circular label">
                                                <i class="comments icon"></i>
                                                <?php echo esc_html($p_comments->approved); ?>
                                            </span>
                                        <?php } ?>
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
                                        <div class="description text grey" style="height: 60px">
                                            <?php echo esc_html($p_excerpt); ?>
                                        </div>
                                    </div>
                                    <div class="extra content">
                                        <span><i class="calendar outline icon"></i><?php echo esc_html($p_date); ?></span>
                                        <a class="right floated star" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )); ?>" data-bjax>
                                          <?php echo esc_html($p_author) ?>
                                        </a>
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
                    <!-- LOAD MORE BUTTON -->
                    <?php if ($total_p > $posts_per_page) { ?>
                    <button class="ui basic fluid large button" id="load-posts-more" data-page="2" data-type="conikal_load_posts"><i class="long arrow down icon"></i><?php echo __('Load more...', 'petition') . ' (<span id="post-number">' . esc_html($posts_per_page) . '</span>' . __(' of ', 'petition') . esc_html($total_p) . ')'; ?></button>
                    <?php wp_nonce_field('load_posts_ajax_nonce', 'securityPosts', true); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>