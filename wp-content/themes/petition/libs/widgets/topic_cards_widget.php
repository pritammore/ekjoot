<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

class Topic_Cards_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'topic_cards_sidebar', 'description' => 'Topic Cards.');
        $control_ops = array('id_base' => 'topic_cards_widget');
        parent::__construct('topic_cards_widget', 'Petition WP Topic Cards', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array(
            'title' => '',
            'topics' => '',
            'orderby' => 'count',
            'order' => 'random',
            'limit' => '3'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $orderby_array = array('id' => __('ID', 'petition'), 'count' => __('Count', 'petition'), 'name' => __('Name', 'petition'));
        $order_array = array('DESC' => __('Descending', 'petition'), 'ASC' => __('Ascending', 'petition'), 'random' => __('Random', 'petition'));
        $display = '
            <p>
                <label for="' . esc_attr($this->get_field_id('title')) . '">' . __('Title', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . esc_attr($instance['title']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('topics')) . '">' . __('Topics (id or slug, separate by commas)', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('topics')) . '" name="' . esc_attr($this->get_field_name('topics')) . '" value="' . esc_attr($instance['topics']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('orderby')) . '">' . __('Order by', 'petition') . ':</label>
                <select type="text" class="widefat" id="' . esc_attr($this->get_field_id('orderby')) . '" name="' . esc_attr($this->get_field_name('orderby')) . '">';

            foreach ($orderby_array as $value => $name) {
                $display .= '<option value="' . esc_attr($value) . '"' . ($instance['orderby'] === $value ? esc_attr(' selected="selected"') : '') . '>' . esc_html($name) . '</option>';
            }            
        $display .= '</select>
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('order')) . '">' . __('Order', 'petition') . ':</label>
                <select type="text" class="widefat" id="' . esc_attr($this->get_field_id('order')) . '" name="' . esc_attr($this->get_field_name('order')) . '">';

            foreach ($order_array as $value => $name) {
                $display .= '<option value="' . esc_attr($value) . '"' . ($instance['order'] === $value ? esc_attr(' selected="selected"') : '') . '>' . esc_html($name) . '</option>';
            }            
        $display .= '</select>
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('limit')) . '">' . __('Number of cards to show', 'petition') . ':</label>
                <input type="text" size="3" id="' . esc_attr($this->get_field_id('limit')) . '" name="' . esc_attr($this->get_field_name('limit')) . '" value="' . esc_attr($instance['limit']) . '" />
            </p>
        ';

        print $display;
    }


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['topics'] = sanitize_text_field($new_instance['topics']);
        $instance['orderby'] = sanitize_text_field($new_instance['orderby']);
        $instance['order'] = sanitize_text_field($new_instance['order']);
        $instance['limit'] = sanitize_text_field($new_instance['limit']);

        if(function_exists('icl_register_string')) {
            icl_register_string('conikal_topic_cards_widget', 'topic_cards_widget_title', sanitize_text_field($new_instance['title']));
            icl_register_string('conikal_topic_cards_widget', 'topic_cards_widget_title', sanitize_text_field($new_instance['topics']));
            icl_register_string('conikal_topic_cards_widget', 'topic_cards_widget_orderby', sanitize_text_field($new_instance['orderby']));
            icl_register_string('conikal_topic_cards_widget', 'topic_cards_widget_order', sanitize_text_field($new_instance['order']));
            icl_register_string('conikal_topic_cards_widget', 'topic_cards_widget_limit', sanitize_text_field($new_instance['limit']));
        }

        return $instance;
    }

    function widget($args, $instance) {
        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        extract($args);
        $display = '';
        $title = apply_filters('widget_title', $instance['title']);
        $slugs = $instance['topics'];
        $orderby = $instance['orderby'];
        $order = $instance['order'];

        // get follow topics
        $current_user = wp_get_current_user();
        $follow_topics = get_user_meta($current_user->ID, 'follow_topics', true);

        print $before_widget;

        if($title) {
            print $before_title . esc_html($title) . $after_title;
        }

        if($instance['limit'] && $instance['limit'] != '') {
            $limit = $instance['limit'];
        } else {
            $limit = 4;
        }

        if ($slugs != '') {
            $slugs = explode(',', $slugs);
        } else {
            $slugs = array();
            $terms = get_terms( array(
                'taxonomy' => 'petition_topics',
                'orderby' => $orderby,
                'order' => ($order != 'random' ? $order : 'DESC'),
                'hide_empty' => true, 
            ) );

            if ($order === 'random') {
                // Random order
                shuffle($terms);

                // Get first $max items
                $terms = array_slice($terms, 0, $limit);

                // Sort by name
                usort($terms, function($a, $b){
                  return strcasecmp($a->name, $b->name);
                });
            }


            if  ($terms) {
                foreach ($terms as $term ) {
                    array_push($slugs, $term->slug);
                }
            }
        }

        $taxonomy_name = 'petition_topics';
        $term_meta_image = 'petition_topics_image';
        $display .= '<div class="topic-cards">';

        for ($i=0; $i < $limit; $i++) {
            // get term
            $id_slug = str_replace(' ', '', $slugs[$i]);
            $term = get_term_by('id', $id_slug, $taxonomy_name);
            if (!$term) {
                $term = get_term_by('slug', $id_slug, $taxonomy_name);
            }

            // get post
            $args = array( 
                'posts_per_page' => 1,
                'paged' => 1,
                'post_type' => 'petition',
                'post_status' => 'publish'
            );

            $args['tax_query'] = array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'petition_topics',
                    'terms'    => $term->term_id,
                )
            );
            $args['tag_id'] = $term->term_id;
            $args['meta_query'] = array('relation' => 'AND');

            if ($minimum_signature != 0) {
                array_push($args['meta_query'], array(
                    'key'     => 'petition_sign',
                    'value'   => $minimum_signature,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                ));
            }
            $postslist = new WP_Query( $args );
            
            if ( $postslist->have_posts() ) {
                $post = $postslist->posts[0];
            }
            
            // display topics
            if ($term) {
                $term_image = get_term_meta($term->term_id, $term_meta_image, true);
                if ($term_image == '' && $postslist->have_posts() ) {
                    $term_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                    if ($term_image) {
                        $term_image = $term_image[0];
                    } else {
                        $term_image = get_template_directory_uri().'/images/cover.svg';
                    }
                } else {
                    $term_image = get_template_directory_uri().'/images/cover.svg';
                }

                $term_link  = get_term_link($term->term_id, $taxonomy_name);
                $display .= '<div class="topic-card snip">';
                $display .= '<img src="' . ($term_image ? esc_url($term_image) : '') . '" alt="' . $term->name . '"/>';
                $display .= '<a href="' . esc_url($term_link) . '" class="caption">';
                $display .= '<h3>' . $term->name . '</h3>';
                $display .= '</a>';

                // follow topic button
                if( is_user_logged_in()  ) {
                    if($follow_topics != '') {
                        if(in_array($term->term_id, $follow_topics) === false) {
                            $display .= '<button id="follow-topic-' . esc_attr($term->term_id) . '" class="follow-topic follow" data-id="' . esc_attr($term->term_id) . '">' . __('Follow', 'petition') . '</button>';
                        } else {
                            $display .= '<button id="follow-topic-' . esc_attr($term->term_id) . '" class="follow-topic following" data-id="' . esc_attr($term->term_id) . '">' . __('Following', 'petition') . '</button>';
                        }
                    } else {
                        $display .= '<button id="follow-topic-' . esc_attr($term->term_id) . '" class="follow-topic follow" data-id="' . esc_attr($term->term_id) . '">' . __('Follow', 'petition') . '</button>';
                    }
                } else {
                    $display .= '<button class="signin-btn follow-topic follow">' . __('Follow', 'petition') . '</button>';
                }

                $display .= '</div>';
            }
        }
        $display .= wp_nonce_field('follow_ajax_nonce', 'securityFollow', true);
        $display .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        print $display;
        print $after_widget;
    }

}

?>