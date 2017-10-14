<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

/**
 * Sign Up Notifications
 */
if( !function_exists('conikal_signup_notifications') ): 
    function conikal_signup_notifications($user, $user_pass = '') {
        $new_user = new WP_User($user);

        $user_login = stripslashes($new_user->user_login);
        $user_email = stripslashes($new_user->user_email);
        $user_first_name = stripslashes($new_user->first_name);

        $message = sprintf( __('New user Sign Up on %s:','petition'), get_option('blogname') ) . "\r\n\r\n";
        $message .= sprintf( __('Username: %s','petition'), esc_html($user_login) ) . "\r\n\r\n";
        $message .= sprintf( __('E-mail: %s','petition'), esc_html($user_email) ) . "\r\n";
        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        wp_mail(
            get_option('admin_email'),
            sprintf(__('[%s] New User Sign Up','petition'), get_option('blogname') ),
            $message,
            $headers
        );

        if(empty($user_pass)) return;

        $message  = sprintf( __('Welcome, %s!','petition'), esc_html($user_first_name) ) . "\r\n\r\n";
        $message .= __('Thank you for signing up with us. Your new account has been setup and you can now login using the details below.','petition') . "\r\n\r\n";
        $message .= sprintf( __('Username: %s','petition'), esc_html($user_login) ) . "\r\n";
        $message .= sprintf( __('Password: %s','petition'), esc_html($user_pass) ) . "\r\n\r\n";
        $message .= __('Thank you,','petition') . "\r\n";
        $message .= sprintf( __('%s Team','petition'), get_option('blogname') );
        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n" .
                'Reply-To: noreply@' . $_SERVER['HTTP_HOST'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        wp_mail(
            esc_html($user_email),
            sprintf( __('[%s] Your username and password','petition'), get_option('blogname') ),
            $message,
            $headers
        );
    }
endif;

/**
 * User Sign Up Function
 */
if( !function_exists('conikal_user_signup_form') ): 
    function conikal_user_signup_form() {
        check_ajax_referer('signup_ajax_nonce', 'security');
        $conikal_general_settings = get_option('conikal_general_settings');
        $format_separate = isset($conikal_general_settings['conikal_format_separate_fullname_field']) ? $conikal_general_settings['conikal_format_separate_fullname_field'] : 'first_s_middle_last';
        $signup_user = isset($_POST['signup_user']) ? sanitize_text_field( $_POST['signup_user'] ) : '';
        $signup_name = isset($_POST['signup_name']) ? sanitize_text_field( $_POST['signup_name'] ) : '';
        $signup_email = isset($_POST['signup_email']) ? sanitize_email( $_POST['signup_email'] ) : '';
        $signup_pass = isset($_POST['signup_pass']) ? $_POST['signup_pass'] : '';
        $signup_repass = isset($_POST['signup_repass']) ? $_POST['signup_repass'] : '';
        $signup_address = isset($_POST['signup_address']) ? sanitize_text_field( $_POST['signup_address'] ) : '';
        $signup_city = isset($_POST['signup_city']) ? sanitize_text_field( $_POST['signup_city'] ) : '';
        $signup_state = isset($_POST['signup_state']) ? sanitize_text_field( $_POST['signup_state'] ) : '';
        $signup_neighborhood = isset($_POST['signup_neighborhood']) ? sanitize_text_field( $_POST['signup_neighborhood'] ) : '';
        $signup_country = isset($_POST['signup_country']) ? sanitize_text_field( $_POST['signup_country'] ) : '';
        $signup_lat = isset($_POST['signup_lat']) ? sanitize_text_field( $_POST['signup_lat'] ) : '';
        $signup_lng = isset($_POST['signup_lng']) ? sanitize_text_field( $_POST['signup_lng'] ) : '';

        $parse_name = explode(' ', $signup_name);
        $signup_firstname = '';
        $signup_middle = '';
        $signup_lastname = '';


        // separate fullname
        foreach ($parse_name as $key => $value) {
            if (count($parse_name) <= 2) {
                if ($key == 0) {
                    $signup_firstname .= $value;
                } else {
                    $signup_lastname .= $value;
                }
            } else {
                if ($key == 0) {
                    $signup_firstname .= $value;
                } elseif ($key == 1) {
                    $signup_middle .= $value;
                } elseif ($key >= 2) {
                    $signup_lastname .= $value . ' ';
                }
            }
        }

        // reformat fullname
        switch ($format_separate) {
            case 'first_s_middle_last':
                $signup_lastname = ($signup_middle != '' ? $signup_middle . ' ' : '') . $signup_lastname;
                break;

            case 'first_middle_s_last':
                $signup_firstname = $signup_firstname . ($signup_middle != '' ? ' ' . $signup_middle : '');
                break;

            case 'last_s_middle_first':
                $signup_lastname_format = ($signup_middle != '' ? $signup_middle . ' ' : '') . $signup_firstname;
                $signup_firstname = $signup_lastname;
                $signup_lastname = $signup_lastname_format;
                break;

            case 'last_middle_s_first':
                $signup_firstname_format = $signup_lastname . ($signup_middle != '' ? ' ' . $signup_middle : '');
                $signup_lastname = $signup_firstname;
                $signup_firstname = $signup_firstname_format;
                break;
            
            default:
                $signup_lastname = ($signup_middle != '' ? $signup_middle . ' ' : '') . $signup_lastname;
                break;
        }

        if(empty($signup_user) || empty($signup_name) || empty($signup_email) || empty($signup_pass) || empty($signup_repass)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Required form fields are empty!','petition')));
            exit();
        }
        if(strlen($signup_user) < 4) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Username too short. Please enter at least 4 characters!','petition')));
            exit();
        }
        if(username_exists($signup_user)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Username already exists!','petition')));
            exit();
        }
        if(!validate_username($signup_user)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Invalid Username!','petition')));
            exit();
        }
        if(!is_email($signup_email)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Invalid Email!','petition')));
            exit();
        }

        if(email_exists($signup_email)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Email already exists!','petition')));
            exit();
        }
        if(strlen($signup_pass) < 6) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Password too short. Please enter at least 6 characters!','petition')));
            exit();
        }
        if($signup_pass != $signup_repass) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Password is not correct!','petition')));
            exit();
        }

        $user_data = array(
            'user_login' => sanitize_user($signup_user),
            'user_email' => sanitize_email($signup_email),
            'user_pass'  => sanitize_text_field($signup_pass),
            'first_name' => sanitize_text_field($signup_firstname),
            'last_name'  => sanitize_text_field($signup_lastname),
            'display_name' => sanitize_text_field($signup_name)
        );

        $new_user = wp_insert_user($user_data);

        update_user_meta($new_user, 'user_type', 'petitioner');
        update_user_meta($new_user, 'user_address', $signup_address);
        update_user_meta($new_user, 'user_city', $signup_city);
        update_user_meta($new_user, 'user_state', $signup_state);
        update_user_meta($new_user, 'user_neighborhood', $signup_neighborhood);
        update_user_meta($new_user, 'user_country', $signup_country);
        update_user_meta($new_user, 'user_lat', $signup_lat);
        update_user_meta($new_user, 'user_lng', $signup_lng);

        if(is_wp_error($new_user)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Something went wrong!','petition')));
            exit();
        } else {
            echo json_encode(array('signedup'=>true, 'ID' => $new_user, 'message'=>__('Congratulations! You have successfully signed up.','petition')));
            conikal_signup_notifications($new_user, $signup_pass);
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_conikal_user_signup_form', 'conikal_user_signup_form');
add_action('wp_ajax_conikal_user_signup_form', 'conikal_user_signup_form');


/**
 * User Sign In Function
 */
if( !function_exists('conikal_user_signin_form') ): 
    function conikal_user_signin_form() {
        if(is_user_logged_in()) { 
            echo json_encode(array('signedin'=>true, 'message'=>__('You are already signed in, redirecting...','petition')));
            exit();
        }
        check_ajax_referer('signin_ajax_nonce', 'security');
        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $signin_pass = isset($_POST['signin_pass']) ? $_POST['signin_pass'] : '';
        $remember = isset($_POST['remember']) ? sanitize_text_field($_POST['remember']) : '';
        $referent = isset($_POST['referent']) ? sanitize_text_field($_POST['referent']) : '';
        $signature = isset($_POST['signature']) ? sanitize_text_field($_POST['signature']) : '';
        $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
        $comment = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';
        $notice = isset($_POST['notice']) ? $_POST['notice'] : false;

        if ($signin_user == '' || $signin_pass == '') {
            echo json_encode(array('signedin'=>false, 'message'=>__('Invalid username or password!','petition')));
            exit();
        }

        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID');
            session_start();
        }

        wp_clear_auth_cookie();
        $data = array();
        $data['user_login'] = $signin_user;
        $data['user_password'] = $signin_pass;
        $data['remember'] = $remember;

        $user_signon = wp_signon($data, false);

        if(is_wp_error($user_signon)) {
            echo json_encode(array('signedin'=>false, 'message'=>__('Invalid username or password!','petition')));
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();

            if ($signature == 'true') {
                $addsign = conikal_add_to_signatures_plus($user_signon->ID, $post_id, $comment, $notice);
                if ($comment != '') {
                    conikal_add_comment_sign($user_signon->ID, $post_id, $comment);
                }
            } else {
                $addsign = false;
            }

            echo json_encode(array('signedin'=>true,'newuser'=>$user_signon->ID, 'referent'=>$referent, 'addsign'=>$addsign, 'message'=>__('Sign in successful, redirecting...','petition')));
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_conikal_user_signin_form', 'conikal_user_signin_form');
add_action('wp_ajax_conikal_user_signin_form', 'conikal_user_signin_form');

/**
 * Forgot Password Function
 */
if( !function_exists('conikal_forgot_pass_form') ): 
    function conikal_forgot_pass_form() {
        global $wpdb, $wp_hasher;

        $forgot_email = isset($_POST['forgot_email']) ? sanitize_text_field($_POST['forgot_email']) : '';

        if($forgot_email == '') {
            echo json_encode(array('sent'=>false, 'message'=>__('Email field is empty!','petition')));
            exit();
        }

        $user_input = trim($forgot_email);

        if(strpos($user_input, '@')) {
            $user_data = get_user_by('email', $user_input);
            if(empty($user_data)) {
                echo json_encode(array('sent'=>false, 'message'=>__('Invalid email address!','petition')));
                exit();
            }
        } else {
            $user_data = get_user_by('login', $user_input);
            if(empty($user_data)) {
                echo json_encode(array('sent'=>false, 'message'=>__('Invalid username!','petition')));
                exit();
            }
        }

        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        $key = wp_generate_password( 20, false );
        do_action( 'retrieve_password_key', $user_login, $key );

        if ( empty( $wp_hasher ) ) {
            require_once ABSPATH . WPINC . '/class-phpass.php';
            $wp_hasher = new PasswordHash( 8, true );
        }
        $hashed = time() . ':' . $wp_hasher->HashPassword( $key );
        $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message = __('Someone has asked to reset the password for the following site and username.', 'petition') . "\r\n\r\n";
        $message .= get_option('siteurl') . "\r\n\r\n";
        $message .= sprintf(__('Username: %s', 'petition'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('Security Code: %s', 'petition'), $key) . "\r\n\r\n";
        $message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.', 'petition') . "\r\n\r\n";
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $title = sprintf( __('[%s] Request Password Reset', 'petition'), $blogname );
        $message .= network_site_url("?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";
        $send = wp_mail($user_email, wp_specialchars_decode( $title ), $message, $headers);

        if($message && !$send) {
            echo json_encode(array('sent'=>false, 'login' => $user_login, 'message'=>__('Email failed to send for some unknown reason.','petition')));
            exit();
        } else {
            echo json_encode(array('sent'=>true, 'login' => $user_login, 'message'=>__('An email with password reset instructions was sent to you.','petition')));
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_conikal_forgot_pass_form', 'conikal_forgot_pass_form');
add_action('wp_ajax_conikal_forgot_pass_form', 'conikal_forgot_pass_form');

/**
 * Reset Password Function
 */
if( !function_exists('conikal_reset_pass_form') ): 
    function conikal_reset_pass_form() {
        $allowed_html = array();
        $pass_1 = isset($_POST['pass_1']) ? wp_kses($_POST['pass_1'], $allowed_html) : '';
        $pass_2 = isset($_POST['pass_2']) ? wp_kses($_POST['pass_2'], $allowed_html) : '';
        $key = isset($_POST['key']) ? wp_kses($_POST['key'], $allowed_html) : '';
        $login = isset($_POST['login']) ? wp_kses($_POST['login'], $allowed_html) : '';

        if($pass_1 == '' || $pass_2 == '') {
            echo json_encode(array('reset'=>false, 'message'=>__('Password field empty!','petition')));
            exit();
        }

        $user = check_password_reset_key($key, $login);

        if(is_wp_error($user)) {
            if($user->get_error_code() === 'expired_key') {
                echo json_encode(array('reset'=>false, 'error' => $user->get_error_code(), 'message'=>__('Sorry, the link does not appear to be valid or is expired!','petition')));
                exit();
            } else {
                echo json_encode(array('reset'=>false, 'error' => $user->get_error_code(), 'message'=>__('Sorry, the link does not appear to be valid or is expired!','petition')));
                exit();
            }
        }

        if(isset($pass_1) && $pass_1 != $pass_2 ) {
            echo json_encode(array('reset'=>false, 'message'=>__('The passwords do not match!','petition')));
            exit();
        } else {
            reset_password($user, $pass_1);
            echo json_encode(array('reset'=>true, 'message'=>__('Your password has been reset.','petition')));
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_conikal_reset_pass_form', 'conikal_reset_pass_form');
add_action('wp_ajax_conikal_reset_pass_form', 'conikal_reset_pass_form');

/**
 * Facebook Login Function
 */
if( !function_exists('conikal_facebook_login') ): 
    function conikal_facebook_login() {
        if(is_user_logged_in()) { 
            echo json_encode(array('signedin'=>true, 'message'=>__('You are already signed in, redirecting...','petition')));
            exit();
        }
        check_ajax_referer('signin_ajax_nonce', 'security');

        $conikal_auth_settings = get_option('conikal_auth_settings','');
        $fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
        $fb_app_secret = isset($conikal_auth_settings['conikal_fb_secret_field']) ? $conikal_auth_settings['conikal_fb_secret_field'] : '';

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $full_name = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $birthday = isset($_POST['birthday']) ? sanitize_text_field($_POST['birthday']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $url = isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
        $cover = isset($_POST['cover']) ? sanitize_text_field($_POST['cover']) : '';
        $avatar = isset($_POST['avatar']) ? sanitize_text_field($_POST['avatar']) : '';
        $signin_pass = $fb_app_secret.$user_id;

        conikal_social_signup($email, $signin_user, $full_name, $first_name, $last_name, $birthday, $gender, $cover, $signin_pass);

        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID');
            session_start();
        }

        wp_clear_auth_cookie();
        $data = array();
        $data['user_login'] = $signin_user;
        $data['user_password'] = $signin_pass;
        $data['remember'] = true;

        $user_signon = wp_signon($data, false);
        update_user_meta($user_signon->ID, 'avatar', $avatar);

        if(is_wp_error($user_signon)) {
            echo json_encode(array('signedin'=>false, 'message'=>__('Something went wrong!','petition')));
            exit();
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('signedin'=>true, 'message'=>__('Sign in successful, redirecting...','petition')));
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_facebook_login', 'conikal_facebook_login' );
add_action( 'wp_ajax_conikal_facebook_login', 'conikal_facebook_login' );

/**
 * Google Signin Function
 */
if( !function_exists('conikal_google_signin') ): 
    function conikal_google_signin() {
        if(is_user_logged_in()) { 
            echo json_encode(array('signedin'=>true, 'message'=>__('You are already signed in, redirecting...','petition')));
            exit();
        }
        check_ajax_referer('signin_ajax_nonce', 'security');

        $conikal_auth_settings = get_option('conikal_auth_settings','');
        $google_client_id = isset($conikal_auth_settings['conikal_google_id_field']) ? $conikal_auth_settings['conikal_google_id_field'] : '';
        $google_client_secret = isset($conikal_auth_settings['conikal_google_secret_field']) ? $conikal_auth_settings['conikal_google_secret_field'] : '';

        $user_id = isset($_POST['userid']) ? sanitize_text_field($_POST['userid']) : '';
        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $full_name = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $birthday = isset($_POST['birthday']) ? sanitize_text_field($_POST['birthday']) : '';
        $birthday = explode('-', $birthday);
        $birthday = $birthday[1] . '/' . $birthday[2] . '/' . $birthday[0];
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $url = isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
        $cover = isset($_POST['cover']) ? sanitize_text_field($_POST['cover']) : '';
        $avatar = isset($_POST['avatar']) ? sanitize_text_field($_POST['avatar']) : '';
        $signin_pass = $google_client_secret.$user_id;

        conikal_social_signup($email, $signin_user, $full_name, $first_name, $last_name, $birthday, $gender, $cover, $signin_pass);

        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID');
            session_start();
        }

        wp_clear_auth_cookie();
        $data = array();
        $data['user_login'] = $signin_user;
        $data['user_password'] = $signin_pass;
        $data['remember'] = true;

        $user_signon = wp_signon($data, false);
        update_user_meta($user_signon->ID, 'avatar', $avatar);

        if(is_wp_error($user_signon)) {
            echo json_encode(array('signedin'=>false, 'message'=>__('Something went wrong!','petition')));
            exit();
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('signedin'=>true, 'message'=>__('Sign in successful, redirecting...','petition')));
        }

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_google_signin', 'conikal_google_signin' );
add_action( 'wp_ajax_conikal_google_signin', 'conikal_google_signin' );

/**
 * Social Sign Up Function
 */
if( !function_exists('conikal_social_signup') ): 
    function conikal_social_signup($email, $signin_user, $full_name, $first_name, $last_name, $birthday, $gender, $cover, $pass) {
        $user_data = array(
            'user_login' => $signin_user,
            'user_email' => $email,
            'user_pass'  => $pass,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'display_name' => $full_name,
        );

        if(email_exists($email)) {
            if(username_exists($signin_user)) {
                return;
            } else {
                $user_data['user_email'] = ' ';
                $user_id  = wp_insert_user($user_data);
                update_user_meta($user_id, 'user_birthday', $birthday);
                update_user_meta($user_id, 'user_gender', $gender);
                update_user_meta($user_id, 'user_cover', $cover);

                if(is_wp_error($user_id)) {
                    // social user signup failed
                }
            }
        } else {
            if(username_exists($signin_user)) {
                return;
            } else {
                $user_id = wp_insert_user($user_data);
                update_user_meta($user_id, 'user_birthday', $birthday);
                update_user_meta($user_id, 'user_gender', $gender);
                update_user_meta($user_id, 'user_cover', $cover);

                if(is_wp_error($user_id)) {
                    // social user signup failed
                }
            }
        }
    }
endif;


/**
 * Update user profile
 */
if( !function_exists('conikal_update_user_profile') ): 
    function conikal_update_user_profile() {
        check_ajax_referer('user_profile_ajax_nonce', 'security');

        $allowed_html = array();
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $user_type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
        $full_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $first_name = isset($_POST['firstname']) ? sanitize_text_field($_POST['firstname']) : '';
        $last_name = isset($_POST['lastname']) ? sanitize_text_field($_POST['lastname']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $nickname = isset($_POST['nickname']) ? sanitize_text_field($_POST['nickname']) : '';
        $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
        $birthday = isset($_POST['birthday']) ? sanitize_text_field($_POST['birthday']) : '';
        $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
        $neighborhood = isset($_POST['neighborhood']) ? sanitize_text_field($_POST['neighborhood']) : '';
        $state = isset($_POST['state']) ? sanitize_text_field($_POST['state']) : '';
        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
        $lat = isset($_POST['lat']) ? sanitize_text_field($_POST['lat']) : '';
        $lng = isset($_POST['lng']) ? sanitize_text_field($_POST['lng']) : '';
        $website = isset($_POST['website']) ? sanitize_text_field($_POST['website']) : '';
        $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
        $re_password = isset($_POST['re_password']) ? sanitize_text_field($_POST['re_password']) : '';
        $avatar = isset($_POST['avatar']) ? sanitize_text_field($_POST['avatar']) : '';
        $avatar_id = isset($_POST['avatar_id']) ? sanitize_text_field($_POST['avatar_id']) : '';
        $user_data = get_userdata($user_id);
        $current_email = $user_data->user_email;

        $decision_maker = isset($_POST['decision_id']) ? sanitize_text_field($_POST['decision_id']) : '';
        $decision_title = isset($_POST['decision_title']) ? sanitize_text_field($_POST['decision_title']) : '';
        $decision_organization = isset($_POST['decision_organization']) ? sanitize_text_field($_POST['decision_organization']) : '';

        if(empty($first_name) || empty($last_name) || empty($gender) || empty($email) || empty($birthday) || empty($address)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Required form fields are empty!','petition')));
            exit();
        }
        if($user_type == 'decisioner') {
          if(empty($decision_title) || empty($decision_organization)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Required form fields are empty!','petition')));
            exit();
          } 
        }
        if(!is_email($email)) {
            echo json_encode(array('signedup'=>false, 'message'=>__('Invalid Email!','petition')));
            exit();
        }
        if($current_email != $email) {
            if (email_exists($email)) {
                echo json_encode(array('signedup'=>false, 'message'=>__('Email already exists!','petition')));
                exit();
            }
        }
        if($password != '' && 6 > strlen($password)) {
            echo json_encode(array('save'=>false, 'message'=>__('Password too short. Please enter at least 6 characters!','petition')));
            exit();
        }
        if($password != '' && $password != $re_password) {
            echo json_encode(array('reset'=>false, 'message'=>__('The passwords do not match!','petition')));
            exit();
        }
        $images = array('', '');
        if ($avatar != '') {
            $images = explode("~~~", $avatar);
            if ($avatar_id != '') {
                $avatar_url = wp_get_attachment_image_src($avatar_id, 'petition-avatar', true);
                $avatar_url = $avatar_url[0];
            } else {
                $avatar_url = $images[1];
            }
        } else {
            $avatar_url = '';
        }

        if (empty($full_name)) {
            $full_name = $first_name . ' ' . $last_name;
        }


        // insert decision maker
        $conikal_general_settings = get_option('conikal_general_settings');
        $review = isset($conikal_general_settings['conikal_review_decision_field']) ? $conikal_general_settings['conikal_review_decision_field'] : '';
        if($review != '' || user_can($user_id, 'administrator') || user_can($user_id, 'editor')) {
            $prop_status = 'publish';
        } else {
            $prop_status = 'pending';
        }

        if ($user_type == 'decisioner') {
            $prop = array(
                'post_title' => $full_name,
                'post_content' => $bio,
                'post_type' => 'decisionmakers',
                'post_author' => $user_id
            );

            if($decision_maker != '') {
                $prop['ID'] = $decision_maker;
            } else {
                $prop['post_status'] = $prop_status;
            }

            if ($decision_maker != '') {
                $decision_id = wp_update_post($prop);
            } else {
                $decision_id = wp_insert_post($prop);
            }

            wp_set_object_terms($decision_id, array(intval($decision_title)), 'decisionmakers_title');
            wp_set_object_terms($decision_id, $decision_organization, 'decisionmakers_organization');
        } else {
            wp_delete_post($decision_maker);
        }


        // update user info
        $user_data = array(
            'ID' => $user_id,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'display_name' => $full_name,
            'user_url' => $website,
            'description' => $bio,
        );

        update_user_meta($user_id, 'user_type', $user_type);
        update_user_meta($user_id, 'user_decision', $decision_id);
        update_user_meta($user_id, 'user_birthday', $birthday);
        update_user_meta($user_id, 'user_gender', $gender);
        update_user_meta($user_id, 'avatar', $avatar_url);
        update_user_meta($user_id, 'avatar_id', $avatar_id);
        update_user_meta($user_id, 'avatar_orginal', $images[1]);
        update_user_meta($user_id, 'user_address', $address);
        update_user_meta($user_id, 'user_neighborhood', $neighborhood);
        update_user_meta($user_id, 'user_state', $state);
        update_user_meta($user_id, 'user_city', $city);
        update_user_meta($user_id, 'user_country', $country);
        update_user_meta($user_id, 'user_lat', $lat);
        update_user_meta($user_id, 'user_lng', $lng);

        wp_update_user($user_data);

        $author_url = get_author_posts_url( $user_id );

        if ($password != '') {
            wp_update_user(array( 'ID' => $user_id, 'user_email' => $email, 'user_pass' => $password ));
        }

        echo json_encode(array('save'=>true, 'author_url' => $author_url, 'decision_id' => $decision_id, 'message'=>__('Your profile was successfully updated.', 'petition')));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_update_user_profile', 'conikal_update_user_profile' );
add_action( 'wp_ajax_conikal_update_user_profile', 'conikal_update_user_profile' );


/**
 * Facebook puhlishing option
 */
if( !function_exists('conikal_facebook_publish') ): 
    function conikal_facebook_publish() {
        check_ajax_referer('sign_ajax_nonce', 'security');

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $publish = isset($_POST['publish']) ? sanitize_text_field($_POST['publish']) : false;
        update_user_meta($user_id, 'fb_publish', $publish);

        echo json_encode(array('save'=>true, 'message'=>__('Facebook publishing has changed successfully.', 'petition')));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_facebook_publish', 'conikal_facebook_publish' );
add_action( 'wp_ajax_conikal_facebook_publish', 'conikal_facebook_publish' );

/**
 * Email notice option
 */
if( !function_exists('conikal_email_notice') ): 
    function conikal_email_notice() {
        check_ajax_referer('sign_ajax_nonce', 'security');

        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $notice = isset($_POST['notice']) ? sanitize_text_field($_POST['notice']) : false;
        update_user_meta($user_id, 'notice', $notice);

        echo json_encode(array('save'=>true, 'message'=>__('Email notice has changed successfully.', 'petition')));
        exit();

        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_email_notice', 'conikal_email_notice' );
add_action( 'wp_ajax_conikal_email_notice', 'conikal_email_notice' );

?>