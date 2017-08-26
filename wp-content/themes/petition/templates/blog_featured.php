<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$args = array(
    'posts_per_page'   => 6,
    'post_type'        => 'post',
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'meta_key'         => 'post_featured',
    'meta_value'       => '1',
    'post_status'      => 'publish'
);

$posts = new wp_query($args);
$t_posts = $posts->found_posts;
?>
<div class="ui container site__wrapper" id="blog-featured">
<?php
while( $posts->have_posts() ) {
    $posts->the_post();

    $post_id = get_the_ID();
    $post_title = get_the_title($post_id);
    $post_link = get_permalink($post_id);
    $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
    $post_excerpt = get_the_excerpt($post_id);
    $post_categories = get_the_category($post_id);
    $post_date = get_the_date($post_id);
    $post_time = human_time_diff(get_the_time('U', $post_id), current_time('timestamp'));
    $author = get_the_author();
    $author_avatar = get_the_author_meta('avatar');

    if($author_avatar != '') {
        $author_avatar_src = $author_avatar;
    } else {
        $author_avatar_src = get_template_directory_uri().'/images/avatar.svg';
    }
    $author_avatar_src = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 35, 'default' => $author_avatar_src) );
    $post_date = get_the_date();
    $overlay_color = array('primary', 'secondary');
    ?>

    <div class="grid">
        <div class="card">
          <div class="card__image">
            <img src="<?php echo esc_url($post_image[0]) ?>" alt="<?php echo esc_html($post_title) ?>">

            <div class="card__overlay card__overlay--<?php echo esc_html($overlay_color[wp_rand(0, count($overlay_color)-1)]) ?>">
              <div class="card__overlay-content">
                <a href="<?php echo esc_url($post_link) ?>" class="card__title"><?php echo esc_html($post_title) ?></a>
                <ul class="card__meta card__meta--last">
                    <li><i class="tag icon"></i> 
                        <?php
                            $separator = '/';
                            $output = '';
                            if($post_categories) {
                                foreach($post_categories as $category) {
                                    $output .= '<a href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "petition" ), $category->name ) ) . '">' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                                }
                                echo trim($output, $separator);
                            }
                        ?>
                    </li>
                    <li><i class="clock icon"></i> <?php echo esc_html($post_time) ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
    </div>

<?php }
wp_reset_postdata();
wp_reset_query();

?>
</div>