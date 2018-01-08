<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Admin notification when new petition submitted
 */
if( !function_exists('conikal_admin_petition_notification') ): 
    function conikal_admin_petition_notification($petition_id, $user_id, $edit) {
        $user_info = get_userdata($user_id);
        $petition_title = get_the_title($petition_id);
        $petition_link = get_permalink($petition_id);
        if($edit == '') {
            $message = sprintf( __('A new petition was submitted on %s:','petition'), get_option('blogname') ) . "\r\n\r\n";
            $message .= sprintf( __('Petition title: %s','petition'), esc_html($petition_title) ) . "\r\n\r\n";
            $message .= sprintf( __('Petition link: %s','petition'), esc_html($petition_link) ) . "\r\n\r\n";
            $message .= sprintf( __('User: %s','petition'), $user_info->display_name ) . "\r\n";
            $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                    'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            wp_mail(
                get_option('admin_email'),
                sprintf(__('[Petition Submitted] %s','petition'), esc_html($petition_title) ),
                $message,
                $headers
            );
        } else { 
            $message = sprintf( __('A petition was updated on %s:','petition'), get_option('blogname') ) . "\r\n\r\n";
            $message .= sprintf( __('Petition title: %s','petition'), esc_html($petition_title) ) . "\r\n\r\n";
            $message .= sprintf( __('Petition link: %s','petition'), esc_html($petition_link) ) . "\r\n\r\n";
            $message .= sprintf( __('User: %s','petition'), $user_info->display_name ) . "\r\n";
            $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                    'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            wp_mail(
                get_option('admin_email'),
                sprintf(__('[Petition Updated] %s','petition'), esc_html($petition_title) ),
                $message,
                $headers
            );
        }
    }
endif;

/*
** Generate UIC [ Unique Issue Code ] for Petition
*  Pattern will be CityCode+PetitionID : UserFirstNameChar+UserLastNameChar+PetitionID : EK+PetitionID
*/
/*if( !function_exists('conikal_get_UIC') ): 
    function conikal_get_UIC($petition_id, $user_id, $city) {

        if ($city != ""){
            echo $city.$petition_id;
            break;
        }
        else {

            $user = get_user_by( 'user_id', $user_id );
            if (($user->first_name != '' && $user->last_name != ''){
                echo strtoupper(substr($user->first_name, 0, 1)).strtoupper(substr($user->last_name, 0, 1)).$petition_id;
                break;
            }
            else{
                echo 'EK'.$petition_id;
                break;
            }

        }
    }
endif;*/

/**
 * Save petition
 */
if( !function_exists('conikal_save_petition') ): 
    function conikal_save_petition() {
        check_ajax_referer('submit_petition_ajax_nonce', 'security');

        $conikal_prop_fields_settings = get_option('conikal_prop_fields_settings');
        $p_content = isset($conikal_prop_fields_settings['conikal_p_content_field']) ? $conikal_prop_fields_settings['conikal_p_content_field'] : '';
        $p_content_r = isset($conikal_prop_fields_settings['conikal_p_content_r_field']) ? $conikal_prop_fields_settings['conikal_p_content_r_field'] : '';
        $p_category = isset($conikal_prop_fields_settings['conikal_p_category_field']) ? $conikal_prop_fields_settings['conikal_p_category_field'] : '';
        $p_category_r = isset($conikal_prop_fields_settings['conikal_p_category_r_field']) ? $conikal_prop_fields_settings['conikal_p_category_r_field'] : '';
        $p_topics = isset($conikal_prop_fields_settings['conikal_p_topics_field']) ? $conikal_prop_fields_settings['conikal_p_topics_field'] : '';
        $p_topics_r = isset($conikal_prop_fields_settings['conikal_p_topics_r_field']) ? $conikal_prop_fields_settings['conikal_p_topics_r_field'] : '';
        $p_city = isset($conikal_prop_fields_settings['conikal_p_city_field']) ? $conikal_prop_fields_settings['conikal_p_city_field'] : '';
        $p_city_r = isset($conikal_prop_fields_settings['conikal_p_city_r_field']) ? $conikal_prop_fields_settings['conikal_p_city_r_field'] : '';
        $p_coordinates = isset($conikal_prop_fields_settings['conikal_p_coordinates_field']) ? $conikal_prop_fields_settings['conikal_p_coordinates_field'] : '';
        $p_coordinates_r = isset($conikal_prop_fields_settings['conikal_p_coordinates_r_field']) ? $conikal_prop_fields_settings['conikal_p_coordinates_r_field'] : '';
        $p_address = isset($conikal_prop_fields_settings['conikal_p_address_field']) ? $conikal_prop_fields_settings['conikal_p_address_field'] : '';
        $p_address_r = isset($conikal_prop_fields_settings['conikal_p_address_r_field']) ? $conikal_prop_fields_settings['conikal_p_address_r_field'] : '';
        $p_neighborhood = isset($conikal_prop_fields_settings['conikal_p_neighborhood_field']) ? $conikal_prop_fields_settings['conikal_p_neighborhood_field'] : '';
        $p_neighborhood_r = isset($conikal_prop_fields_settings['conikal_p_neighborhood_r_field']) ? $conikal_prop_fields_settings['conikal_p_neighborhood_r_field'] : '';
        $p_zip = isset($conikal_prop_fields_settings['conikal_p_zip_field']) ? $conikal_prop_fields_settings['conikal_p_zip_field'] : '';
        $p_zip_r = isset($conikal_prop_fields_settings['conikal_p_zip_r_field']) ? $conikal_prop_fields_settings['conikal_p_zip_r_field'] : '';
        $p_state = isset($conikal_prop_fields_settings['conikal_p_state_field']) ? $conikal_prop_fields_settings['conikal_p_state_field'] : '';
        $p_state_r = isset($conikal_prop_fields_settings['conikal_p_state_r_field']) ? $conikal_prop_fields_settings['conikal_p_state_r_field'] : '';
        $p_country = isset($conikal_prop_fields_settings['conikal_p_country_field']) ? $conikal_prop_fields_settings['conikal_p_country_field'] : '';
        $p_country_r = isset($conikal_prop_fields_settings['conikal_p_country_r_field']) ? $conikal_prop_fields_settings['conikal_p_country_r_field'] : '';
        $p_receiver = isset($conikal_prop_fields_settings['conikal_p_receiver_field']) ? $conikal_prop_fields_settings['conikal_p_receiver_field'] : '';
        $p_receiver_r = isset($conikal_prop_fields_settings['conikal_p_receiver_r_field']) ? $conikal_prop_fields_settings['conikal_p_receiver_r_field'] : '';
        $p_position = isset($conikal_prop_fields_settings['conikal_p_position_field']) ? $conikal_prop_fields_settings['conikal_p_position_field'] : '';
        $p_position_r = isset($conikal_prop_fields_settings['conikal_p_position_r_field']) ? $conikal_prop_fields_settings['conikal_p_position_r_field'] : '';
        $p_supporters = isset($conikal_prop_fields_settings['conikal_p_supporters_field']) ? $conikal_prop_fields_settings['conikal_p_supporters_field'] : '';
        $p_goal = isset($conikal_prop_fields_settings['conikal_p_goal_field']) ? $conikal_prop_fields_settings['conikal_p_goal_field'] : '';
        $p_goal_r = isset($conikal_prop_fields_settings['conikal_p_goal_r_field']) ? $conikal_prop_fields_settings['conikal_p_goal_r_field'] : '';
        $p_goal_d = isset($conikal_prop_fields_settings['conikal_p_goal_default_field']) ? $conikal_prop_fields_settings['conikal_p_goal_default_field'] : '';
        $p_video = isset($conikal_prop_fields_settings['conikal_p_video_field']) ? $conikal_prop_fields_settings['conikal_p_video_field'] : '';

        $user_id = isset($_POST['user']) ? sanitize_text_field($_POST['user']) : '';
        $new_id = isset($_POST['new_id']) ? sanitize_text_field($_POST['new_id']) : '';
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '0';
        $topics = isset($_POST['topics']) ? sanitize_text_field($_POST['topics']) : '0';
        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $lat = isset($_POST['lat']) ? sanitize_text_field($_POST['lat']) : '';
        $lng = isset($_POST['lng']) ? sanitize_text_field($_POST['lng']) : '';
        $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
        $neighborhood = isset($_POST['neighborhood']) ? sanitize_text_field($_POST['neighborhood']) : '';
        $zip = isset($_POST['zip']) ? sanitize_text_field($_POST['zip']) : '';
        $state = isset($_POST['state']) ? sanitize_text_field($_POST['state']) : '';
        $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $receiver = isset($_POST['receiver']) ? sanitize_text_field($_POST['receiver']) : '';
        $position = isset($_POST['position']) ? sanitize_text_field($_POST['position']) : '';
        $decisionmakers = isset($_POST['decisionmakers']) ? sanitize_text_field($_POST['decisionmakers']) : '';
        $goal = isset($_POST['goal']) ? sanitize_text_field($_POST['goal']) : '';
        $video = isset($_POST['video']) ? sanitize_text_field($_POST['video']) : '';
        $thumb = isset($_POST['thumb']) ? sanitize_text_field($_POST['thumb']) : '';
        $gallery = isset($_POST['gallery']) ? sanitize_text_field($_POST['gallery']) : '';
        $attach_id = isset($_POST['attach']) ? sanitize_text_field($_POST['attach']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 0;

        $conikal_general_settings = get_option('conikal_general_settings');
        $review = isset($conikal_general_settings['conikal_review_field']) ? $conikal_general_settings['conikal_review_field'] : '';
        if($review != '' || user_can($user_id, 'administrator') || user_can($user_id, 'editor')) {
            $prop_status = 'publish';
        } else {
            $prop_status = 'pending';
        }

        $prop = array(
            'post_title' => $title,
            'post_content' => $content,
            'post_type' => 'petition',
            'post_author' => $user_id
        );

        if($new_id != '') {
            $prop['ID'] = $new_id;
        } else {
            $prop['post_status'] = $prop_status;
        }

        if($title == '') {
            echo json_encode(array('save'=>false, 'message'=>__('Title field is mandatory.', 'petition')));
            exit();
        }
        if($content == '' && $p_content != '' && $p_content == 'enabled' && $p_content_r != '' && $p_content_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Content field is mandatory.', 'petition')));
            exit();
        }
        if($category == '' && $p_category != '' && $p_category == 'enabled' && $p_category_r != '' && $p_category_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Category field is mandatory.', 'petition')));
            exit();
        }
        if($topics == '' && $p_topics != '' && $p_topics == 'enabled' && $p_topics_r != '' && $p_topics_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Topics field is mandatory.', 'petition')));
            exit();
        }
        if($lat == '' && $lng == '' && $p_coordinates != '' && $p_coordinates == 'enabled' && $p_coordinates_r != '' && $p_coordinates_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Coordinates fields are mandatory.', 'petition')));
            exit();
        }
        if($address == '' && $p_address != '' && $p_address == 'enabled' && $p_address_r != '' && $p_address_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Address field is mandatory.', 'petition')));
            exit();
        }
        if($neighborhood == '' && $p_neighborhood != '' && $p_neighborhood == 'enabled' && $p_neighborhood_r != '' && $p_neighborhood_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Neighborhood field is mandatory.', 'petition')));
            exit();
        }
        if($zip == '' && $p_zip != '' && $p_zip == 'enabled' && $p_zip_r != '' && $p_zip_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Zip Code field is mandatory.', 'petition')));
            exit();
        }
        if($state == '' && $p_state != '' && $p_state == 'enabled' && $p_state_r != '' && $p_state_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('County/State field is mandatory.', 'petition')));
            exit();
        }
        if($country == '' && $p_country != '' && $p_country == 'enabled' && $p_country_r != '' && $p_country_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Country field is mandatory.', 'petition')));
            exit();
        }
        if($receiver == '' && $p_receiver != '' && $p_receiver == 'enabled' && $p_receiver_r != '' && $p_receiver_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Receiver field is mandatory.', 'petition')));
            exit();
        }

        if($position == '' && $p_position != '' && $p_position == 'enabled' && $p_position_r != '' && $p_position_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Position field is mandatory.', 'petition')));
            exit();
        }

        if($goal == '' && $p_goal != '' && $p_goal == 'enabled' && $p_goal_r != '' && $p_goal_r == 'required') {
            echo json_encode(array('save'=>false, 'message'=>__('Goal field is mandatory.', 'petition')));
            exit();
        }

        if($gallery == '' && $video == '') {
            echo json_encode(array('save'=>false, 'message'=>__('Upload at least 1 image in gallery.', 'petition')));
            exit();
        }

        if ($topics != '') {
            $topics = explode(',', $topics);
        }

        if ($new_id != '') {
            $prop_id = wp_update_post($prop);
        } else {
            $prop_id = wp_insert_post($prop);
            update_post_meta($prop_id, 'petition_letter', $title);

            /* Setting UIC CODE */
            if ($city != "") {
                $UIC = strtoupper(substr($city, 0, 2)).$prop_id;
            }
            else 
            {
                $user = get_user_by( 'ID', $user_id );
                if (($user->first_name != '') && ($user->last_name != ''))
                {
                    $UIC = strtoupper(substr($user->first_name, 0, 1)).strtoupper(substr($user->last_name, 0, 1)).$prop_id;
                }
                else
                {
                    $UIC = 'EK'.$prop_id;
                }
            }
            $UIC = 'EK'.$prop_id;
            update_post_meta($prop_id, 'petition_uic', $UIC);
            /* ENDS */
            
        }

        wp_set_object_terms($prop_id, array(intval($category)), 'petition_category');
        wp_set_object_terms($prop_id, $topics, 'petition_topics');

        update_post_meta($prop_id, 'petition_city', $city);
        update_post_meta($prop_id, 'petition_lat', $lat);
        update_post_meta($prop_id, 'petition_lng', $lng);
        update_post_meta($prop_id, 'petition_address', $address);
        update_post_meta($prop_id, 'petition_neighborhood', $neighborhood);
        update_post_meta($prop_id, 'petition_zip', $zip);
        update_post_meta($prop_id, 'petition_state', $state);
        update_post_meta($prop_id, 'petition_country', $country);
        update_post_meta($prop_id, 'petition_receiver', $receiver);
        update_post_meta($prop_id, 'petition_position', $position);
        update_post_meta($prop_id, 'petition_decisionmakers', $decisionmakers);
        update_post_meta($prop_id, 'petition_goal', $goal);
        update_post_meta($prop_id, 'petition_video', $video);
        update_post_meta($prop_id, 'petition_thumb', $thumb);
        update_post_meta($prop_id, 'petition_gallery', $gallery);
        update_post_meta($prop_id, 'petition_status', $status);


        $default_leader = array( $user_id );
        update_post_meta( $prop_id, 'lp_post_ids', $default_leader );

        $post_thumbnail = set_post_thumbnail( $prop_id, $attach_id );
        $addsign = conikal_add_to_signatures_plus( $user_id, $prop_id, '' );
        $approve = get_post_status($prop_id);

        if ($approve == 'pending') {
            $args = array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'meta_key' => '_wp_page_template',
                'meta_value' => 'my-petitions.php'
            );

            $query = new WP_Query($args);

            while($query->have_posts()) {
                $query->the_post();
                $page_id = get_the_ID();
                $prop_link = get_permalink($page_id);
            }
            wp_reset_postdata();
            wp_reset_query();
        } else {
            $prop_link = get_permalink($prop_id);
        }

        conikal_admin_petition_notification($prop_id, $user_id, $new_id);

        if($prop_id != 0) {
            if($review != '') {
                echo json_encode(array('save'=>true, 'propID'=>$prop_id, 'propLink'=>$prop_link, 'addsign' => $addsign, 'thumbnail' => $post_thumbnail, 'propStatus'=>'publish', 'message'=>__('The issue was successfully saved and published.', 'petition')));
                exit();
            } else {
                echo json_encode(array('save'=>true, 'propID'=>$prop_id, 'propLink'=>$prop_link, 'addsign' => $addsign, 'thumbnail' => $post_thumbnail, 'propStatus'=>'pending', 'message'=>__('The issue was successfully saved and pending for approval.', 'petition')));
                exit();
            }
        } else {
            echo json_encode(array('save'=>false, 'message'=>__('Something went wrong. The petition was not saved.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_save_petition', 'conikal_save_petition' );
add_action( 'wp_ajax_conikal_save_petition', 'conikal_save_petition' );

/*
** Update letter
*/
if( !function_exists('conikal_update_letter') ): 
    function conikal_update_letter() {
        check_ajax_referer('letter_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $letter = isset($_POST['letter']) ? $_POST['letter'] : '';
        
        if($letter == '') {
            echo json_encode(array('save'=>false, 'message'=>__('Letter field is mandatory.', 'petition')));
            exit();
        }

        update_post_meta($post_id, 'petition_letter', $letter);
        
        echo json_encode(array('save'=>true, 'message' => 'The petition was successfully saved'));

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_update_letter', 'conikal_update_letter' );
add_action( 'wp_ajax_conikal_update_letter', 'conikal_update_letter' );


/*
** Set new goal
*/
if( !function_exists('conikal_set_goal') ): 
    function conikal_set_goal() {
        check_ajax_referer('dashboard_petition_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $goal = isset($_POST['goal']) ? sanitize_text_field($_POST['goal']) : '';
        
        if($goal == '') {
            echo json_encode(array('status'=>false, 'message'=>__('Goal field is mandatory.', 'petition')));
            exit();
        }

        update_post_meta($post_id, 'petition_goal', $goal);
        $link = get_permalink($post_id);
        
        echo json_encode(array('status'=>true, 'link' => $link, 'message' => 'The new goal was successfully saved'));

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_set_goal', 'conikal_set_goal' );
add_action( 'wp_ajax_conikal_set_goal', 'conikal_set_goal' );

/*
** Reopen petition
*/
if( !function_exists('conikal_status_petition') ): 
    function conikal_status_petition() {
        check_ajax_referer('dashboard_petition_ajax_nonce', 'security');

        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 0;

        update_post_meta($post_id, 'petition_status', $status);
        $link = get_permalink($post_id);

        echo json_encode(array('status'=>true, 'link' => $link, 'message' => 'The new goal was successfully saved'));

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_status_petition', 'conikal_status_petition' );
add_action( 'wp_ajax_conikal_status_petition', 'conikal_status_petition' );


/**
 * Delete petition
 */
if( !function_exists('conikal_delete_petition') ): 
    function conikal_delete_petition() {
        check_ajax_referer('submit_petition_ajax_nonce', 'security');

        $del_id = isset($_POST['new_id']) ? sanitize_text_field($_POST['new_id']) : '';

        $del_prop = wp_delete_post($del_id);

        if($del_prop) {
            echo json_encode(array('delete'=>true, 'message'=>__('The petition was successfully deleted. Redirecting...', 'petition')));
            exit();
        } else {
            echo json_encode(array('delete'=>false, 'message'=>__('Something went wrong. The petition was not deleted.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_delete_petition', 'conikal_delete_petition' );
add_action( 'wp_ajax_conikal_delete_petition', 'conikal_delete_petition' );


?>