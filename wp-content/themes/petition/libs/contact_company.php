<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Function that sends email message from contact page form
 */
if( !function_exists('conikal_send_message_to_company') ): 
    function conikal_send_message_to_company() {
        check_ajax_referer('contact_page_ajax_nonce', 'security');

        $company_email = isset($_POST['company_email']) ? sanitize_email($_POST['company_email']) : '';
        $client_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $client_email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $client_subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $client_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';

        if(empty($client_name) || empty($client_email) || empty($client_subject) || empty($client_message)) {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
            exit();
        }

        $headers = 'From: ' . $client_name . '  <' . $client_email . '>' . "\r\n" .
                'Reply-To: ' . $client_name . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        $send = wp_mail(
            $company_email,
            sprintf( __('[%s Contact] %s', 'petition'), get_option('blogname'), $client_subject ),
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
add_action( 'wp_ajax_nopriv_conikal_send_message_to_company', 'conikal_send_message_to_company' );
add_action( 'wp_ajax_conikal_send_message_to_company', 'conikal_send_message_to_company' );

?>