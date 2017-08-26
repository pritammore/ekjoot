<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
?>

<div id="" class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <?php if($sidebar_position == 'left') {
                get_sidebar();
            } ?>
            <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <?php if($show_bc != '') {
                    conikal_petition_breadcrumbs();
                } else {
                    print '<br/>';
                } ?>
                <h2 class="pageHeader"><?php printf( __( 'Search Results for: %s', 'petition'), '<span>' . esc_html(get_search_query()) . '</span>' ); ?></h2>
                    <?php 
                    $keyword = get_search_query();
                    $temp = isset($postslist) ? $postslist : null;
                    $postslist = null; 
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array( 
                        'posts_per_page' => get_option('posts_per_page'),
                        'paged' => $paged,
                        'post_type' => 'post',
                        's' => $keyword
                    );

                    $postslist = new WP_Query( $args );
                    if ( $postslist->have_posts() ) : ?>
                    <div class="row">
                        <?php 
                        while( $postslist->have_posts() ) : $postslist->the_post();
                            $post_class = 'col-xxs-12 col-xs-12 col-sm-4 col-md-4 col-lg-4';
                            $show_excerpt = false;

                            $p_id = get_the_ID();
                            $p_link = get_permalink($p_id);
                            $p_title = get_the_title($p_id);
                            $p_image = wp_get_attachment_image_src( get_post_thumbnail_id( $p_id ), 'single-post-thumbnail' );
                            $p_excerpt = get_the_excerpt();
                            $p_author = get_the_author();
                            $p_date = get_the_date(); ?>

                            <div class="<?php echo esc_attr($post_class); ?>">
                                <div class="article bg-w">
                                    <a href="<?php echo esc_url($p_link); ?>" class="image">
                                        <div class="img" style="background-image: url(<?php echo esc_url($p_image[0]); ?>);"></div>
                                    </a>
                                    <div class="article-category">
                                        <?php
                                        $categories = get_the_category();
                                        $separator = ' ';
                                        $output = '';
                                        if($categories) {
                                            foreach($categories as $category) {
                                                $output .= '<a class="text-green" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "petition" ), $category->name ) ) . '">' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                                            }
                                            echo trim($output, $separator);
                                        }
                                        ?>
                                    </div>
                                    <h3><a href="<?php echo esc_url($p_link); ?>"><?php echo esc_html($p_title); ?></a></h3>
                                    <?php if($show_excerpt ){ ?>
                                    <p><?php echo esc_html($p_excerpt); ?></p>
                                    <?php } ?>
                                    <div class="footer"><?php echo esc_html($p_author); ?>, <?php echo esc_html($p_date); ?></div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                </div>
                    <?php else : 
                        esc_html_e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'petition');
                    endif;
                    wp_reset_postdata();
                    ?>
                
                <div class="blog-pagination">
                    <div class="pull-left"><?php next_posts_link( '<span class="fa fa-angle-left"></span> ' . __('Older Articles', 'petition'), esc_html($postslist->max_num_pages) ); ?></div>
                    <div class="pull-right"><?php previous_posts_link( __('Newer Articles', 'petition') . ' <span class="fa fa-angle-right"></span>' ); ?></div>
                    <div class="clearfix"></div>
                </div>
                <?php $postslist = null;
                $postslist = $temp; ?>
            </div>
            <?php if($sidebar_position == 'right') {
                get_sidebar();
            } ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>