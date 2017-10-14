<?php

/**
 * Category shortcode
 */

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


if( !function_exists('conikal_category_shortcode') ): 
    function conikal_category_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Categories',
            'type' => 'category',
            'slugs' => ''
        ), $attrs));

        $conikal_general_settings = get_option('conikal_general_settings','');
        $minimum_signature = isset($conikal_general_settings['conikal_minimum_signature_field']) ? $conikal_general_settings['conikal_minimum_signature_field'] : '';

        $slugs = explode(',', $slugs);

        $col_count = 0;
        $total     = count( $slugs );
        $spans     = array();

        for ( $i = 0; $i < $total; $i++ ) {
            $span = 4;

            if ( $i == 0 ) {
                $span = 8;
            } elseif( $i == $total - 1 ) {
                $span = 16 - $col_count;
            } elseif ( $i == rand(1, $total) ) {
                $span = 8;
            }

            $col_count = $col_count + $span;

            if ( $col_count > 16 ) {
                $span = 16 - $col_count + $span;
            }

            if ( $span < 4 ) {
                $spans[ $i - 1 ] = $spans[ $i - 1 ] - 1;
                $span = 4;
            }

            if ( $col_count >= 16 ) {
                $col_count = 0;
            }

            $spans[$i] = $span;
        }


        $return_string = '<div class="ui center aligned basic segment"><h1 class="ui header">' . esc_html($title) . '</h1>';
        $return_string .= '<div class="title-divider"></div></div>';
        $return_string .= '<div class="ui grid">';

        if ($type === 'category') {
            $taxonomy_name = 'petition_category';
            $term_meta_image = 'petition_category_image';
        } else {
            $taxonomy_name = 'petition_topics';
            $term_meta_image = 'petition_topics_image';
        }

        foreach ($slugs as $key => $id_slug) {
            $id_slug = str_replace(' ', '', $id_slug);
            $term = get_term_by('id', $id_slug, $taxonomy_name);
            if (!$term) {
                $term = get_term_by('slug', $id_slug, $taxonomy_name);
            }

            if ($term) {
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

                // get link
                $term_link  = get_term_link($term->term_id, $taxonomy_name);


                // get image cover
                $term_image = get_term_meta($term->term_id, $term_meta_image, true);

                if ($term_image == '') {
                    if ( $postslist->have_posts() ) {
                        $term_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                        if ($term_image) {
                            $term_image = $term_image[0];
                        } else {
                            $term_image = get_template_directory_uri().'/images/cover.svg';
                        }
                    } else {
                        $term_image = get_template_directory_uri().'/images/cover.svg';
                    }
                }

                // return string
                $return_string .= '<div class="sixteen wide mobile eight wide tablet ' . convert_number_to_words($spans[$key]) . ' wide computer column">';
                $return_string .= '<a href="' . esc_url($term_link) . '">';
                $return_string .= '<div class="topic-card snip category">';
                $return_string .= '<img src="' . ($term_image ? esc_url($term_image) : '') . '" alt="' . $term->name . '"/>';
                $return_string .= '<div href="' . esc_url($term_link) . '" class="caption">';
                $return_string .= '<h3>' . $term->name . '</h3>';
                $return_string .= '</div>';
                $return_string .= '</div>';
                $return_string .= '</a>';
                $return_string .= '</div>';
            }
        }

        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;


// interact with visual composer

add_action( 'vc_before_init', 'conikal_vc_category_shortcode' );
function conikal_vc_category_shortcode() {
   vc_map( array(
      "name" => __('Categories', 'petition'),
      "base" => 'category',
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
            "value" => '',
            "description" => __('Title of Segment', 'petition')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Type', 'petition'),
            "param_name" => 'type',
            "value" => array(
                'Category' => 'category',
                'Topics' => 'topics',
                ),
            "std" => 'category',
            "description" => __('Display Topics or Category', 'petition')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => __('Slug or ID (separate by commas)', 'petition'),
            "param_name" => 'slugs',
            "value" => '',
            "description" => __('Slug or ID (separate by commas)', 'petition')
        )
      )
   ) );
}

?>