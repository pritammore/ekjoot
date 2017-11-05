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
        $uic = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $client_message = isset($_POST['message']) ? $_POST['message'] : '';
        $client_message_for = isset($_POST['messageFor']) ? $_POST['messageFor'] : '';
        $admin_email_for_cc = get_option( 'admin_email' );

        if(empty($client_name) || empty($client_email) || empty($uic)) {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
            exit();
        }
        if($client_message_for == 'RequestUICSupport') {
            if(validate_uic($uic)){
                $client_subject = "Request for Support in leading Issue " . $uic;
                $client_message = get_email_tempalte($admin_email_for_cc, $uic, $user_email);
            } else {
                echo json_encode(array('sent'=>false, 'message'=>__('Your Unique Issue Code is not valid. Please try again.', 'petition')));
                exit();
            }
        }else {
            if(empty($client_message)) {
                echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
                exit();
            }
        }

        $headers = 'From: ' . $client_name . '  <' . $client_email . '>' . "\r\n" .
                'cc: ' . 'Ekjoot Admin' . '  <' . $admin_email_for_cc . '>' . "\r\n" .
                'Reply-To: ' . $client_name . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n".
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
        $admin_email_for_cc = get_option( 'admin_email' );

        if(empty($invite_name) || empty($invite_email) || empty($invite_subject) || empty($invite_message)) {
            echo json_encode(array('sent'=>false, 'message'=>__('Your message failed to be sent. Please check your fields.', 'petition')));
            exit();
        }

        $headers = 'From: ' . $client_name . '  <' . $client_email . '>' . "\r\n" .
                'cc: ' . 'Ekjoot Admin' . '  <' . $admin_email_for_cc . '>' . "\r\n" .
                'Reply-To: ' . $client_name . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n".
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

function get_email_tempalte($client_message_for, $uic, $user_email) {

    $email_template = '';
    $conikal_general_settings = get_option('conikal_general_settings','');
    $logo = isset($conikal_general_settings['conikal_logo_field']) ? $conikal_general_settings['conikal_logo_field'] : '';
    if($logo != '') {
        $logo = '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" height="45"/>';
    } else {
        $logo = '<div class="ui header">' . esc_html(get_bloginfo('name')) . '</div>';
    }
    
    $petition = get_petition_data($uic);
    if($petition)
    {
    $toUser_display_name = "";
    $toUsername = get_user_by( 'email',  $user_email);
    
    global $current_user;
    get_currentuserinfo();    
    $current_user_display_name = $current_user->display_name;

    if($toUsername->display_name != "") {
        $toUser_display_name = $toUsername->display_name;
    }

    $copyright = isset($conikal_appearance_settings['conikal_copyright_field']) ? $conikal_appearance_settings['conikal_copyright_field'] : '';
    $site_url = get_site_url();
    $site_name = get_bloginfo();
    $email_template = '
    <!doctype html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Simple Transactional Email</title>
        <style>
        /* -------------------------------------
            INLINED WITH htmlemail.io/inline
        ------------------------------------- */
        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
          table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
          }
          table[class=body] p,
                table[class=body] ul,
                table[class=body] ol,
                table[class=body] td,
                table[class=body] span,
                table[class=body] a {
            font-size: 16px !important;
          }
          table[class=body] .wrapper,
                table[class=body] .article {
            padding: 10px !important;
          }
          table[class=body] .content {
            padding: 0 !important;
          }
          table[class=body] .container {
            padding: 0 !important;
            width: 100% !important;
          }
          table[class=body] .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
          }
          table[class=body] .btn table {
            width: 100% !important;
          }
          table[class=body] .btn a {
            width: 100% !important;
          }
          table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
          }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
          .ExternalClass {
            width: 100%;
          }
          .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
            line-height: 100%;
          }
          .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
          }
          .btn-primary table td:hover {
            background-color: #34495e !important;
          }
          .btn-primary a:hover {
            background-color: #34495e !important;
            border-color: #34495e !important;
          }
        }
        </style>
      </head>
      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
          <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                <!-- START CENTERED WHITE CONTAINER -->
                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; text-align:center; vertical-align: top; box-sizing: border-box;">
                      <span>' . $logo . '</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                        <tr>
                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi ' . $toUser_display_name . ',</p>
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Ekjoot User ' . $current_user_display_name . ' have request you to support an Issue UIC ' . $uic . ' - ' . $petition['post_title'] . '</p>
                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                              <tbody>
                                <tr>
                                  <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                      <tbody>
                                        <tr>
                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #8a8a8a; border-radius: 5px; text-align: center;"> <a href="'. $petition['post_url'] .'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #8a8a8a; border: solid 1px #8a8a8a; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #8a8a8a;">Lead this Issue</a> </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">You need to go and click on the lead this button after visting the Issue page. Then after Admin/Issue creator will look for your request and accept it when ever they see the request in Issue dashboard. </p>
                            <p>To Solve this issue you can use your contacts.</p>
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Good luck! Hope you will help this to resolve this issue.</p>
                            <p>On a sincer note thank you!</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                <!-- END MAIN CONTENT AREA -->
                </table>

                <!-- START FOOTER -->
                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">SUN MEDIANET, 2/12 Prem Nivas, Bhaijivanji Lane, J.S.S. Road, Mumbai- 400002</span>
                        <br> Don\'t like these emails? <a href="'.$site_url.'" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">Unsubscribe</a>.
                      </td>
                    </tr>
                    <tr>
                      <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                        Powered by <a href="http://htmlemail.io" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">' . $site_name . '</a>.
                      </td>
                    </tr>
                  </table>
                </div>
                <!-- END FOOTER -->

              <!-- END CENTERED WHITE CONTAINER -->
              </div>
            </td>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
          </tr>
        </table>
      </body>
    </html>
    ';
    }
    return $email_template;
}

?>