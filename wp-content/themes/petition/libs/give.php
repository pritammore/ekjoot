<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


/**
 * Admin notification when new contribute submitted
 */
if( !function_exists('conikal_admin_contribute_notification') ): 
    function conikal_admin_contribute_notification($petition_id, $user_id, $edit) {
        $user_info = get_userdata($user_id);
        $petition_title = get_the_title($petition_id);
        $petition_link = get_permalink($petition_id);
        if($edit == '') {
            $message = sprintf( __('A new contribute was submitted on %s:','petition'), get_option('blogname') ) . "\r\n\r\n";
            $message .= sprintf( __('Petition title: %s','petition'), esc_html($petition_title) ) . "\r\n\r\n";
            $message .= sprintf( __('Petition link: %s','petition'), esc_html($petition_link) ) . "\r\n\r\n";
            $message .= sprintf( __('User: %s','petition'), $user_info->display_name ) . "\r\n";
            $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                    'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            wp_mail(
                get_option('admin_email'),
                sprintf(__('[Contribute Submitted] %s','petition'), esc_html($petition_title) ),
                $message,
                $headers
            );
        } else { 
            $message = sprintf( __('A contribute was updated on %s:','petition'), get_option('blogname') ) . "\r\n\r\n";
            $message .= sprintf( __('Petition title: %s','petition'), esc_html($petition_title) ) . "\r\n\r\n";
            $message .= sprintf( __('Petition link: %s','petition'), esc_html($petition_link) ) . "\r\n\r\n";
            $message .= sprintf( __('User: %s','petition'), $user_info->display_name ) . "\r\n";
            $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                    'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            wp_mail(
                get_option('admin_email'),
                sprintf(__('[Contribute Updated] %s','petition'), esc_html($petition_title) ),
                $message,
                $headers
            );
        }
    }
endif;


/**
 * Admin notification when new contribute submitted
 */
if( !function_exists('conikal_give_save_form') ):
	function conikal_give_save_form() {
		check_ajax_referer('submit_contribute_ajax_nonce', 'security');

		$user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $new_form_id = isset($_POST['form_id']) ? sanitize_text_field($_POST['form_id']) : '';
        $petition_id = isset($_POST['petition_id']) ? sanitize_text_field($_POST['petition_id']) : '';
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $draft_status = isset($_POST['draft_status']) ? sanitize_text_field($_POST['draft_status']) : '';
        $amount_level = isset($_POST['amount_level']) ? sanitize_text_field($_POST['amount_level']) : '';
        $amount_level = substr($amount_level, 0, -1);
        $amount_level = explode(',', $amount_level);
        $name_level = isset($_POST['name_level']) ? sanitize_text_field($_POST['name_level']) : '';
        $name_level = substr($name_level, 0, -1);
        $name_level = explode(',', $name_level);

        $donation_levels = array();
        for ($i=0; $i < count($amount_level); $i++) {
        	$level = array(
        		'_give_amount' => $amount_level[$i],
        		'_give_text' => $name_level[$i],
        	);
            $level['_give_id']['level_id'] = $i;
        	if ($i === 0) $level['_give_default'] = 'default';

        	array_push($donation_levels, $level);
        }

      	// general option
      	$custom_amount = 'enabled';
      	$custom_amount_text = __('Custom', 'petition');
      	$custom_amount_minimum = isset($_POST['custom_amount_minimum']) ? sanitize_text_field($_POST['custom_amount_minimum']) : '';
      	$price_option = 'multi';
      	$set_price = isset($_POST['custom_amount_minimum']) ? sanitize_text_field($_POST['custom_amount_minimum']) : '';
      	$display_style = 'buttons';
        $levels_minimum_amount = $amount_level[0];
        $levels_maxinum_amount = $amount_level[count($amount_level)];

        // display option
      	$form_floating_labels = 'global';
      	$show_register_form = 'none';
      	$logged_in_only = 'enabled';
      	$default_gateway = 'global';
      	$checkout_label = isset($_POST['button_label']) ? sanitize_text_field($_POST['button_label']) : '';
      	$reveal_label = isset($_POST['button_label']) ? sanitize_text_field($_POST['button_label']) : '';
      	$payment_display = 'modal';

      	// form content
      	$display_content = 'enabled';
      	$form_content = isset($_POST['form_content']) ? sanitize_textarea_field($_POST['form_content']) : '';
      	$content_placement = 'give_pre_form';

      	// goal option
      	$close_form_when_goal_achieved = isset($_POST['close_form_when_goal_achieved']) ? sanitize_text_field($_POST['close_form_when_goal_achieved']) : '';
        $goal_achieved_message = isset($_POST['goal_achieved_message']) ? sanitize_textarea_field($_POST['goal_achieved_message']) : '';
      	$goal_option = isset($_POST['goal_option']) ? sanitize_text_field($_POST['goal_option']) : '';
      	$goal_format = isset($_POST['goal_format']) ? sanitize_text_field($_POST['goal_format']) : '';
      	$set_goal = isset($_POST['set_goal']) ? sanitize_text_field($_POST['set_goal']) : '';
      	$goal_color = '#2bc253';

      	// terms & condition option
      	$terms_option = 'global';
      	$agree_text = '';
      	$agree_label = '';

        // offline donation
        $customize_offline_donations = 'global';
        $offline_donation_email = '';
      	$offline_donation_subject = '';
      	$offline_checkout_notes = '';
      	$offline_donation_enable_billing_fields_single = 'disabled';

        $conikal_general_settings = get_option('conikal_general_settings');
        $review = isset($conikal_general_settings['conikal_review_contribute_field']) ? $conikal_general_settings['conikal_review_contribute_field'] : '';
        if($review != '' || user_can($user_id, 'administrator') || user_can($user_id, 'editor')) {
            $form_status = 'publish';
        } else {
            $form_status = 'pending';
        }

        // add new post type
        $form = array(
            'post_title' => $title,
            'post_type' => 'give_forms',
            'post_author' => $user_id
        );

        if($new_form_id != '') {
            $form['ID'] = $new_form_id;
            
            if ($draft_status != '') {
                $form['post_status'] = 'draft';
            } else {
                $form['post_status'] = 'publish';
            }
        } else {
            $form['post_status'] = $form_status;
        }

        if ($new_form_id != '') {
            $form_id = wp_update_post($form);
        } else {
            $form_id = wp_insert_post($form);
        }

        $give_prefix = '_give_';

        // update post meta
        update_post_meta($form_id, $give_prefix . 'custom_amount', $custom_amount);
        update_post_meta($form_id, $give_prefix . 'custom_amount_text', $custom_amount_text);
        update_post_meta($form_id, $give_prefix . 'custom_amount_minimum', $custom_amount_minimum);
        update_post_meta($form_id, $give_prefix . 'price_option', $price_option);
        update_post_meta($form_id, $give_prefix . 'set_price', $set_price);
        update_post_meta($form_id, $give_prefix . 'display_style', $display_style);
        update_post_meta($form_id, $give_prefix . 'levels_minimum_amount', $levels_minimum_amount);
        update_post_meta($form_id, $give_prefix . 'levels_maxinum_amount', $levels_maxinum_amount);

        update_post_meta($form_id, $give_prefix . 'form_floating_labels', $form_floating_labels);
        update_post_meta($form_id, $give_prefix . 'show_register_form', $show_register_form);
        update_post_meta($form_id, $give_prefix . 'logged_in_only', $logged_in_only);
        update_post_meta($form_id, $give_prefix . 'default_gateway', $default_gateway);
        update_post_meta($form_id, $give_prefix . 'checkout_label', $checkout_label);
        update_post_meta($form_id, $give_prefix . 'reveal_label', $reveal_label);
        update_post_meta($form_id, $give_prefix . 'payment_display', $payment_display);

        update_post_meta($form_id, $give_prefix . 'display_content', $display_content);
        update_post_meta($form_id, $give_prefix . 'form_content', $form_content);
        update_post_meta($form_id, $give_prefix . 'content_placement', $content_placement);

        update_post_meta($form_id, $give_prefix . 'close_form_when_goal_achieved', $close_form_when_goal_achieved);
        update_post_meta($form_id, $give_prefix . 'form_goal_achieved_message', $goal_achieved_message);
        update_post_meta($form_id, $give_prefix . 'goal_option', $goal_option);
        update_post_meta($form_id, $give_prefix . 'goal_format', $goal_format);
        update_post_meta($form_id, $give_prefix . 'goal_color', $goal_color);
        update_post_meta($form_id, $give_prefix . 'set_goal', $set_goal);
        update_post_meta($form_id, $give_prefix . 'donation_levels', $donation_levels);

        update_post_meta($form_id, $give_prefix . 'terms_option', $terms_option);
        update_post_meta($form_id, $give_prefix . 'agree_text', $agree_text);
        update_post_meta($form_id, $give_prefix . 'agree_label', $agree_label);

        update_post_meta($form_id, $give_prefix . 'customize_offline_donations', $customize_offline_donations);
        update_post_meta($form_id, $give_prefix . 'offline_donation_email', $offline_donation_email);
        update_post_meta($form_id, $give_prefix . 'offline_donation_subject', $offline_donation_subject);
        update_post_meta($form_id, $give_prefix . 'offline_checkout_notes', $offline_checkout_notes);
        update_post_meta($form_id, $give_prefix . 'offline_donation_enable_billing_fields_single', $offline_donation_enable_billing_fields_single);

        update_post_meta($form_id, $give_prefix . 'petition_id', $petition_id);
        update_post_meta($petition_id, 'petition_contribute', $form_id);

        $approve = get_post_status($form_id);
        $petition_link = get_permalink($petition_id);
        conikal_admin_contribute_notification($form_id, $user_id, $new_form_id);

        if($form_id != 0) {
            if($approve == 'publish') {
                echo json_encode(array('save'=>true, 'form_id'=>$form_id, 'link'=>$petition_link, 'status'=>$approve, 'message'=>__('The contribute was successfully saved and published.', 'petition')));
                exit();
            } elseif ($approve == 'pending') {
                echo json_encode(array('save'=>true, 'form_id'=>$form_id, 'link'=>$petition_link, 'status'=>$approve, 'message'=>__('The contribute was successfully saved and pending for approval.', 'petition')));
                exit();
            } else {
                echo json_encode(array('save'=>true, 'form_id'=>$form_id, 'link'=>$petition_link, 'status'=>$approve, 'message'=>__("The contribute was successfully saved but doesn't show on petition", "petition")));
                exit();
            }
        } else {
            echo json_encode(array('save'=>false, 'message'=>__('Something went wrong. The contribute was not saved.', 'petition')));
            exit();
        }

        die();
	}
endif;
add_action( 'wp_ajax_nopriv_conikal_give_save_form', 'conikal_give_save_form' );
add_action( 'wp_ajax_conikal_give_save_form', 'conikal_give_save_form' );


?>