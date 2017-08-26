<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

class Featured_Petitions_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'featured_petitions_sidebar', 'description' => 'Featured petitions.');
        $control_ops = array('id_base' => 'featured_petitions_widget');
        parent::__construct('featured_petitions_widget', 'Petition WP Featured', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array(
            'title' => '',
            'limit' => ''
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $display = '
            <p>
                <label for="' . esc_attr($this->get_field_id('title')) . '">' . __('Title', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . esc_attr($instance['title']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('limit')) . '">' . __('Number of petitions to show', 'petition') . ':</label>
                <input type="text" size="3" id="' . esc_attr($this->get_field_id('limit')) . '" name="' . esc_attr($this->get_field_name('limit')) . '" value="' . esc_attr($instance['limit']) . '" />
            </p>
        ';

        print $display;
    }


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['limit'] = sanitize_text_field($new_instance['limit']);

        if(function_exists('icl_register_string')) {
            icl_register_string('conikal_featured_petitions_widget', 'featured_petitions_widget_title', sanitize_text_field($new_instance['title']));
            icl_register_string('conikal_featured_petitions_widget', 'featured_petitions_widget_limit', sanitize_text_field($new_instance['limit']));
        }

        return $instance;
    }

    function widget($args, $instance) {
        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        extract($args);
        $display = '';
        $title = apply_filters('widget_title', $instance['title']);

        print $before_widget;

        if($title) {
            print $before_title . esc_html($title) . $after_title;
        }

        if($instance['limit'] && $instance['limit'] != '') {
            $limit = $instance['limit'];
        } else {
            $limit = 4;
        }

        $args = array(
            'posts_per_page'   => $instance['limit'],
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'meta_key'         => 'petition_featured',
            'meta_value'       => '1',
            'post_status'      => 'publish' );

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

        $posts = get_posts($args);

        $display .= '<div class="ui relaxed items">';
        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
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
            $thumb = conikal_video_thumbnail($thumb);
            $author_link = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));

            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.svg';
            }
            $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            $display .= '<div class="item">';
            $display .= '<a class="ui tiny image" href="' . esc_url($link) . '" data-bjax>';
            $display .= '<img src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '" />';
            $display .= '</a>';
            $display .= '<div class="content">';
            $display .= '<a href="' . esc_url($link) . '" data-bjax><strong>' . esc_html($title) . '</strong></a>';
            $display .= '<div class="meta">' . conikal_format_number('%!,0i', $sign) . ' ' . __('supporters', 'petition') . '</div>';
            $display .= '</div>';
            $display .= '</div>';
        endforeach;

        $display .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        print $display;
        print $after_widget;
    }

}

?>