<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Sends email message from contact user form
 */
if( !function_exists('conikal_send_message_to_user') ): 
    function conikal_send_message_to_user() {
        check_ajax_referer('contact_user_ajax_nonce', 'security');

        $allowed_html = array();
        $user_email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';
        $client_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $client_email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $client_subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $client_message = isset($_POST['message']) ? $_POST['message'] : '';
        $client_message_for = isset($_POST['messageFor']) ? $_POST['messageFor'] : '';

        if(empty($client_name) || empty($client_email) || empty($client_subject) || empty($client_message)) {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
            exit();
        }

        if($client_message_for == 'RequestUICSupport') {
            if(validate_uic($client_subject))
                $client_subject = "Request for Support in leading Issue " . $client_subject;
            else {
                echo json_encode(array('sent'=>false, 'message'=>__('Your Unique Issue Code is not valid. Please try again.', 'petition')));
                exit();
            }
        }

        $headers = 'From: ' . $client_name . '  <' . $client_email . '>' . "\r\n" .
                'Reply-To: ' . $client_name . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        $message .= sprintf(__('%s send a message to you:', 'petition'), $client_name) . "\r\n\r\n";
        $send = wp_mail(
            $user_email,
            sprintf( __('[%s Message] %s', 'petition'), get_option('blogname'), $client_subject ),
            $client_message,
            $headers
        );

        if($send) {
            echo json_encode(array('sent'=>true, 'message'=>__('Your message was successfully sent.', 'petition')));
            exit();
        } else {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_send_message_to_user', 'conikal_send_message_to_user' );
add_action( 'wp_ajax_conikal_send_message_to_user', 'conikal_send_message_to_user' );


/**
 * Sends invitation letter to decision makers
 */

if( !function_exists('conikal_send_invatation') ): 
    function conikal_send_invatation() {
        check_ajax_referer('invitation_ajax_nonce', 'security');

        $allowed_html = array();
        $user_email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';
        $invite_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $invite_email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $invite_subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $invite_message = isset($_POST['message']) ? $_POST['message'] : '';

        if(empty($invite_name) || empty($invite_email) || empty($invite_subject) || empty($invite_message)) {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
            exit();
        }

        $headers = 'From: ' . $invite_name . '  <' . $user_email . '>' . "\r\n" .
                'Reply-To: ' . $invite_name . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        $message .= sprintf(__('%s send a invitation to you:', 'petition'), $invite_name) . "\r\n\r\n";
        $send = wp_mail(
            $invite_email,
            sprintf( __('[%s Invitation Response] %s', 'petition'), get_option('blogname'), $invite_subject ),
            $invite_message,
            $headers
        );

        if($send) {
            echo json_encode(array('sent'=>true, 'message'=>__('Your message was successfully sent.', 'petition')));
            exit();
        } else {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent.', 'petition')));
            exit();
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_send_invatation', 'conikal_send_invatation' );
add_action( 'wp_ajax_conikal_send_invatation', 'conikal_send_invatation' );

?>