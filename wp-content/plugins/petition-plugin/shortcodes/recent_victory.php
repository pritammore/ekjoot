<?php

/**
 * Recent victory petitions shortcode
 */
if( !function_exists('conikal_recent_victory_shortcode') ): 
    function conikal_recent_victory_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Recent Victory',
            'show' => '4',
            'category' => '',
            'style' => 'grid',
            'carousel' => 'no',
            'column' => 'four'
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';
        $conikal_appearance_settings = get_option('conikal_appearance_settings','');
        $view_counter = isset($conikal_appearance_settings['conikal_view_counter_field']) ? $conikal_appearance_settings['conikal_view_counter_field'] : '';

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'petition',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish' );

        if ($category != '') {
            $category = explode(',', $category);
            $categories = array();
            foreach ($category as $id_slug) {
                $id_slug = str_replace(' ', '', $id_slug);
                $term = get_term_by('slug', $id_slug, 'petition_category');
                if (!$term) {
                    $term = get_term_by('id', $id_slug, 'petition_category');
                }
                array_push($categories, $term->term_id);
            }

            $args['tax_query'] = array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'petition_category',
                    'terms'    => $categories,
                )
            );
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

        $posts = get_posts($args);

        $return_string = '';
        if ($title != '') {
            $return_string .= '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
            $return_string .= '<div class="title-divider"></div></div>';
        }

        if ($style == 'grid') {
            if ( $carousel == 'no') {
                $return_string .= '<div class="ui ' . $column . ' stackable cards petition-cards">';
            } else {
                $return_string .= '<div class="post-carousel">';
            }
        }

        foreach($posts as $post) : setup_postdata($post);
            $id = $post->ID;
            $author_id = $post->post_author;
            $link = get_permalink($id);
            $title = get_the_title($id);
            $category =  wp_get_post_terms($id, 'petition_category', true);
            $excerpt = conikal_get_excerpt_by_id($id, 15);
            $comments = wp_count_comments($id);
            $view = conikal_format_number('%!,0i', (int) conikal_get_post_views($id), true);
            $gallery = get_post_meta($id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'petition-medium' );
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

            $author_url = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
            $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
            if($user_avatar != '') {
                $avatar = $user_avatar;
            } else {
                $avatar = get_template_directory_uri().'/images/avatar.svg';
            }
            $avatar = conikal_get_avatar_url( $author_id, array('size' => 35, 'default' => $avatar) );

            if(has_post_thumbnail($id)) {
                $thumb_id = get_post_thumbnail_id($id);
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
                $thumbnail = $thumbnail[0];
            } elseif ($gallery) {
                $thumbnail = $images[1];
            } elseif ($thumb) {
                $thumbnail = $thumb;
            } else {
                $thumbnail = get_template_directory_uri() . '/images/thumbnail-small.svg';
            }

            if ($style == 'grid') {
                if ($sign >= $goal || $status == '1') {
                    if ( $carousel == 'no') {
                        $return_string .= '<div class="card petition-card">';
                    } else {
                        $return_string .= '<div>';
                        $return_string .= '<div class="ui card petition-card" style="margin-bottom: 2px;">';
                    }
                    if ($sign >= $goal || $status == '1') {
                        $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                    }
                    $return_string .= '<a href="' . esc_url($link) . '" target="_blank" class="image blurring" data-bjax>';
                    $return_string .= '<div class="ui dimmer"><div class="content">';
                    $return_string .= '<div class="center"><div class="ui icon inverted circular ' . ($column == 'three' ? 'big ' : '') . 'button"><i class="external icon"></i></div></div>';
                    if ($country || $state || $city) { 
                        $return_string .= '<div class="petition-location"><i class="marker icon"></i>' . ($city && $column == 'three' ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</div>';
                    }
                    if ($view_counter != '') {
                        $return_string .= '<div class="view-counter"><i class="eye icon"></i>' . esc_html($view) . '</div>';
                    }
                    $return_string .= '</div></div>';
                    $return_string .= '<img class="ui fluid image" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                    $return_string .= '</a>';
                    $return_string .= '<div class="content petition-content">';
                    if ($column == 'three') {
                        $return_string .= '<div class="meta">';
                        $return_string .= '<span class="receiver"><i class="send icon"></i> ' . __('Petition to', 'petition') . ' ' . esc_html($receiver[0]) . '</span>';
                        $return_string .= '</div>';
                    }
                    $return_string .= '<div class="header card-petition-title"><a href="' . esc_url($link) . '" data-bjax>' . esc_attr($title) . '</a></div>';
                    if ($column != 'three') {
                        $return_string .= '<div class="meta">';
                        $return_string .= esc_html('by ', 'petition') . '<a href="' . get_author_posts_url( $author_id ) . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
                        $return_string .= '</div>';
                    } else {
                        $return_string .= '<div class="description">';
                        $return_string .= '<div class="text grey">' . esc_html($excerpt) . '</div>';
                        $return_string .= '</div>';
                    }
                    $return_string .= '</div>';
                    $return_string .= '<div class="extra content">';
                    if ($column == 'three') {
                        $return_string .= '<span class="right floated">';
                        $return_string .= '<a href="' . esc_url($author_url) . '">';
                        $return_string .= '<img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                        $return_string .= '</a>';
                        $return_string .= '</span>';
                    }
                    $return_string .= '<span class="ui primary label">' . conikal_custom_icon('supporter') . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                    if($comments->approved != 0) {
                        $return_string .= '<span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                    }
                    $return_string .= '</div>';
                    $return_string .= '<div class="ui bottom attached indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . esc_html($goal) . '">';
                    $return_string .= '<div class="bar"><div class="progress"></div></div>';
                    $return_string .= '</div>';

                    $return_string .= '</div>';

                    if ( $carousel != 'no') {
                        $return_string .= '</div>';
                    }
                }
            } else {
                if ($sign >= $goal || $status == '1') {
                    $return_string .= '<div class="ui segments">';
                    $return_string .= '<div class="ui segment">';
                    if ($sign >= $goal || $status == '1') {
                        $return_string .= '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                    }
                    $return_string .= '<div class="ui grid">';
                    $return_string .= '<div class="sixteen wide mobile ten wide tablet ten wide computer column">';
                    $return_string .= ' <div class="petition-content">';
                    $return_string .= '     <div class="ui grid">';
                    $return_string .= '         <div class="sixteen wide column">';
                    $return_string .= '             <div class="ui header">';
                    $return_string .= '                 <div class="content">';
                    $return_string .= '                     <div class="sub header"><i class="send icon"></i>' . __('Petition to', 'petition') . ' ' . $receiver[0] . '</div>';
                    $return_string .= '                     <a href="'. esc_url($link) . '" data-bjax>' . esc_html($title) . '</a>';
                    $return_string .= '                 </div>';
                    $return_string .= '             </div>';
                    $return_string .= '         </div>';
                    $return_string .= '         <div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">';
                    $return_string .= '             <div class="text grey">' . esc_html($excerpt) . '</div>';
                    $return_string .= '         </div>';
                    $return_string .= '     </div>';
                    $return_string .= ' </div>';
                    $return_string .= ' <div class="ui grid">';
                    $return_string .= '      <div class="petition-footer">';
                    $return_string .= '         <div class="sixteen wide column">';
                    if ($country || $state || $city) { 
                        $return_string .= '         <span class="text grey"><i class="marker icon"></i>' . ($city ? esc_html($city) . ', ' : '') . ($state ? esc_html($state) . ', ' : '') . ($country ? esc_html($country) : '') . '</span>';
                    }
                    $return_string .= '             <div class="ui tiny indicating primary progress petition-goal" data-value="' . esc_html($sign) . '" data-total="' . ($status == '1' ? esc_html($sign) : esc_html($goal) ) . '">';
                    $return_string .= '                 <div class="bar">';
                    $return_string .= '                     <div class="progress"></div>';
                    $return_string .= '                 </div>';
                    $return_string .= '             </div>';
                    $return_string .= '         </div>';
                    $return_string .= '     </div>';
                    $return_string .= ' </div>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="sixteen wide mobile six wide tablet six wide computer column">';
                    $return_string .= ' <a class="ui fluid image" href="' . esc_url($link) . '" data-bjax>';
                    $return_string .= '     <img class="ui fluid image"src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">';
                    $return_string .= '<div class="ui grid">';
                    $return_string .= '<div class="ten wide tablet ten wide computer column tablet computer only">';
                    $return_string .= '     <span class="ui primary label">' . conikal_custom_icon('supporter') . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                    $return_string .= '     <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . ' ' . __('comments', 'petition') . '</span>';
                    if($category) {
                        $return_string .= ' <a class="ui label" href="' . get_category_link($category[0]->term_id) . '" data-bjax><i class="tag icon"></i>' . esc_html($category[0]->name) . '</a>';
                    }
                    $return_string .= '</div>';
                    $return_string .= '<div class="six wide tablet six wide computer right aligned column tablet computer only">';
                    $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax><strong>' . get_the_author_meta( 'display_name' , $author_id ) . '</strong>';
                    $return_string .= '      <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';

                    $return_string .= '<div class="thirteen wide column mobile only">';
                    $return_string .= ' <span class="ui primary label">' . conikal_custom_icon('supporter') . conikal_format_number('%!,0i', $sign, true) . ' ' . __('supporters', 'petition') . '</span>';
                    $return_string .= ' <span class="ui label"><i class="comments icon"></i>' . conikal_format_number('%!,0i', $comments->approved, true) . '</span>';
                    $return_string .= '</div>';
                    $return_string .= '<div class="three wide right aligned column mobile only">';
                    $return_string .= ' <a href="' . get_author_posts_url($author_id) . '" data-bjax>';
                    $return_string .= '     <img class="ui avatar bordered image" src="' . esc_url($avatar) . '" alt="' . get_the_author_meta( 'display_name' , $author_id ) . '" />';
                    $return_string .= ' </a>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                    $return_string .= '</div>';
                }
            }
        endforeach;

        if ($style == 'grid') {
            $return_string .= '</div>';
        }

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_recent_victory_shortcode' );
function conikal_vc_recent_victory_shortcode() {
   vc_map( array(
      "name" => __('Recent Victory Petition', 'petition'),
      "base" => 'recent_victory',
      "class" => '',
      "category" => __('Petition WP', 'petition'),
      'admin_enqueue_js' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.js',
      'admin_enqueue_css' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.css',
      "icon" => plugin_dir_url( __FILE__ ) . 'images/petition-vc-icon.svg',
      "params" => array(
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Title', 'petition'),
            "param_name" => 'title',
            "value" => 'Recent Victory',
            "description" => __('Title of Segment', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Show Number', 'petition'),
            "param_name" => 'show',
            "value" => 4,
            "description" => __('Number of Petitions', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Category IDs or Slugs (separated by comma)', 'petition'),
            "param_name" => 'category',
            "value" => '',
            "description" => __('Category ID or Slugs comma-separated list of IDs (this or any children)', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Style', 'petition'),
            "param_name" => 'style',
            "value" => array(
                'Grid' => 'grid',
                'List' => 'list'
                ),
            "std" => 'grid',
            "description" => __('Style Display of Petition', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Carousel Mode', 'petition'),
            "param_name" => 'carousel',
            "value" => array(
                'No' => 'no',
                'Yes' => 'yes',
                ),
            "std" => 'no',
            "description" => __('Display Petitions follow Carousel style', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Column', 'petition'),
            "param_name" => 'column',
            "value" => array(
                '1' => 'one',
                '2' => 'two',
                '3' => 'three',
                '4' => 'four',
                '5' => 'five'
                ),
            "std" => 'four',
            "description" => __('Column of Petitions', 'petition')
        )
      )
   ) );
}


?>