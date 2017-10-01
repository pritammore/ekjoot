<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_auth_settings = get_option('conikal_auth_settings','');
$fb_login = isset($conikal_auth_settings['conikal_fb_login_field']) ? $conikal_auth_settings['conikal_fb_login_field'] : false;
$fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
$google_login = isset($conikal_auth_settings['conikal_google_login_field']) ? $conikal_auth_settings['conikal_google_login_field'] : false;
$google_client_id = isset($conikal_auth_settings['conikal_google_id_field']) ? $conikal_auth_settings['conikal_google_id_field'] : '';
$google_client_secret = isset($conikal_auth_settings['conikal_google_secret_field']) ? $conikal_auth_settings['conikal_google_secret_field'] : '';

?>

<?php if(!is_user_logged_in()) { ?>
    <!-- SIGN IN AND SIGN UP MODAL -->
    <div class="ui modal" id="signinModal">
        <div class="content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="ui two column middle aligned stackable internally celled grid">
                <div class="column">
                    <div class="respon-message" id="signinMessage"></div>
                    <form class="ui form" id="userSignupForm">
                        <div class="required field">
                            <label><?php _e('Full Name', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="text" name="nameSignup" id="nameSignup" placeholder="<?php _e('Enter your fullname', 'petition') ?>">
                                <i class="user icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Email', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="text" name="emailSignup" id="emailSignup" placeholder="<?php _e('Enter your e-mail', 'petition') ?>">
                                <i class="mail icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Address', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="text" name="addressSignup" id="addressSignup" placeholder="<?php _e('Enter your address', 'petition') ?>">
                                <i class="marker icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Pincode', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="text" name="pincodeSignup" id="pincodeSignup" placeholder="<?php _e('Enter your pincode', 'petition') ?>">
                                <i class="location arrow icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Password', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="password" name="passSignup" id="passSignup" placeholder="<?php _e('Enter your password', 'petition') ?>">
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Repeat Password', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="password" name="repassSignup" id="repassSignup" placeholder="<?php _e('Repeat your password', 'petition') ?>">
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <div class="ui grid">
                            <div class="eight wide column">
                                <a class="ui primary button" id="submitSignup"><?php _e('Sign Up', 'petition') ?></a>
                            </div>
                            <div class="eight wide right aligned column">
                                <a href="#" class="signin-btn"><?php _e('Sign In', 'petition') ?></a>
                            </div>
                        </div>
                        <input type="hidden" id="citySignup" name="citySignup" value="">
                        <input type="hidden" id="stateSignup" name="stateSignup" value="">
                        <input type="hidden" id="neighborhoodSignup" name="neighborhoodSignup" value="">
                        <input type="hidden" id="countrySignup" name="countrySignup" value="">
                        <input type="hidden" id="latSignup" name="latSignup" value="">
                        <input type="hidden" id="lngSignup" name="lngSignup" value="">
                        <?php wp_nonce_field('signup_ajax_nonce', 'securitySignup', true); ?>
                    </form>

                    <form class="ui form" id="userLoginForm" style="display: none">
                        <div class="required field">
                            <label><?php _e('Email', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="text" name="usernameSignin" id="usernameSignin" placeholder="<?php _e('Username', 'petition') ?>">
                                <i class="user icon"></i>
                            </div>
                        </div>
                        <div class="required field">
                            <label><?php _e('Password', 'petition') ?></label>
                            <div class="ui right icon input">
                                <input type="password" name="passwordSignin" id="passwordSignin" placeholder="<?php _e('Password', 'petition') ?>">
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <?php wp_nonce_field('signin_ajax_nonce', 'securitySignin', true); ?>
                        <?php wp_referer_field(); ?>
                        <input type="hidden" name="signSignin" id="signSignin" value="">
                        <div class="inline field">
                            <div class="ui toggle checkbox">
                                <input type="checkbox" name="rememberme" id="rememberSignin" class="hidden">
                                <label><?php _e('Remember me', 'petition') ?></label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui grid">
                                <div class="nine wide column">
                                    <a href="#" class="ui primary button" id="submitSignin"><?php _e('Sign In', 'petition') ?></a>
                                </div>
                                <div class="seven wide right aligned column">
                                    <a href="#" class="forgot-password" id="forgotPass"><?php _e('Forgot password?', 'petition') ?></a>
                                </div> 
                            </div>
                        </div>
                    </form>
                </div>
                <div class="center aligned column">
                    <button class="signup-btn ui big labeled icon button signup-btn-style btn-modal" id="signup-button">
                      <i class="signup icon"></i>
                      <?php _e('Sign Up', 'petition') ?>
                    </button>
                    <button class="signin-btn ui big primary labeled icon button btn-modal" id="signin-button">
                      <i class="sign in icon"></i>
                      <?php _e('Sign In', 'petition') ?>
                    </button>
                    <?php if($fb_login || $google_login) { ?>
                        <br/>
                        <br/>
                        <div class="ui horizontal divider"><?php _e('And', 'petition') ?></div>
                        <br/>
                    <?php } ?>
                    <?php if($fb_login) { ?>
                        <button class="ui facebook button signinFBText" id="fbLoginBtn"><i class="facebook f icon"></i><?php _e('Facebook', 'petition') ?></button>
                    <?php } ?>
                    <?php if($google_login) { ?>
                        <button class="ui google plus button" id="googleSigninBtn"><i class="google icon"></i><?php _e('Google', 'petition') ?></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- FORGOT PASSWORD MODAL -->
    <div class="ui small modal" id="forgot-password">
        <div class="header">
            <?php _e('Forgot Password', 'petition') ?>
        </div>
        <div class="content">
            <div class="respon-message" id="forgotMessage"></div>
            <form class="ui form" id="userForgotPassForm" method="post">
                <div class="field">
                    <label><?php _e('Username or Email', 'petition') ?></label>
                    <div class="ui right icon input">
                        <input type="text" name="emailForgot" id="emailForgot" placeholder="<?php _e('Username or Email', 'petition') ?>">
                        <i class="mail icon"></i>
                    </div>
                </div>
                <?php wp_nonce_field('forgot_ajax_nonce', 'securityForgot', true); ?>
                <a class="ui primary button" id="submitForgot"><?php _e('Get New Password', 'petition') ?></a>
            </form>
        </div>
    </div>

    <!-- RESET PASSWORD MODAL -->
    <div class="ui small modal" id="resetpass">
        <div class="header">
           <?php _e('Reset Password', 'petition') ?>
        </div>
        <div class="content">
            <div class="respon-message" id="resetPassMessage"></div>
            <form class="ui form" id="userResetPassForm" method="post">
                <div class="field">
                    <div class="ui right icon input">
                        <input type="text" name="resetKey" id="resetKey" placeholder="<?php _e('Security Code', 'petition') ?>">
                        <i class="barcode icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui right icon input">
                        <input type="password" name="resetPass_1" id="resetPass_1" placeholder="<?php _e('New Password', 'petition') ?>">
                        <i class="lock icon"></i>
                    </div>
                </div>
                <div class="field">
                    <div class="ui right icon input">
                        <input type="password" name="resetPass_2" id="resetPass_2" placeholder="<?php _e('Confirm Password', 'petition') ?>">
                        <i class="lock icon"></i>
                    </div>
                </div>
                <input type="hidden" name="resetLogin" id="resetLogin">
                <p class="help-block"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).', 'petition') ?></p>
                <?php wp_nonce_field('resetpass_ajax_nonce', 'securityResetpass', true); ?>
                <a class="ui primary button" id="submitResetPass"><?php _e('Reset Password', 'petition') ?></a>
            </form>
        </div>
    </div>
<?php } ?>

<?php if( is_user_logged_in() ) { ?>

    <!-- MAKE DECISIONER MODAL -->
    <div class="ui small modal" id="makeDecisioner">
        <div class="header">
            <?php _e('Update your profile to leader', 'petition') ?>
        </div>
        <div class="content">
            <div class="respon-message" id="makeDecisionerMessage">
                <?php _e('Sorry !! You need to become Leader to lead this issue. your current profile is Petitioner on Ekjoot portal. you need to upgrade your profile to leader so as to lead any issue on Ekjoot Profile.', 'petition') ?>
            </div><br>
            <form class="ui form" id="makeDecisionerForm" method="post">
                <div class="field">
                    <label><?php _e('Steps to request for a Leader Position on Ekjoot Portal', 'petition') ?></label>
                    <ul>
                        <li><?php _e('Go to Account Setting Page.', 'petition') ?></li>
                        <li><?php _e('Scroll Down to Manage Profile.', 'petition') ?></li>
                        <li><?php _e('Click on Leader Maker Tab in Account Setting form and submit the form.', 'petition') ?></li>
                        <li><?php _e('On successfully submittion of form Request to become is submitted to Admin/Editor of Ekjoot Portal and will be updated to you soon.', 'petition') ?></li>
                    </ul> 
                
                <?php wp_nonce_field('forgot_ajax_nonce', 'securityForgot', true); ?>
                <?php
                $args = array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'user-account.php'
                );

                $query = new WP_Query($args);

                while($query->have_posts()) {
                    $query->the_post();
                    $page_id = get_the_ID();
                    $page_title = get_the_title($page_id);
                    $page_link = get_permalink($page_id);
                }
                wp_reset_postdata();
                wp_reset_query();
                ?>
                <a class="ui primary button" href="<?php echo esc_url($page_link); ?>" data-bjax></i><?php echo esc_html($page_title); ?></a>
                </div>
            </form>
        </div>
    </div>
    

    <div class="ui small modal" id="requestForDecisionerWaiting">
        <div class="header">
            <?php _e('Update your profile to leader', 'petition') ?>
        </div>
        <div class="content">
            <div class="respon-message" id="requestForDecisionerWaitingMessage">
                <?php _e('Sorry !! Your request to become Leader is not yet confirmed by Admin. 
                    your current profile is Petitioner on Ekjoot portal and hence cannot lead any issue on Ekjoot Portal. Please contact Admin for more details.', 'petition') ?>
            </div><br>
            <form class="ui form" id="requestForDecisionerWaitingForm" method="post">
                <div class="field">
                <label><?php _e('Request for a Leader Position on Ekjoot Portal is submitted to Admin.', 'petition') ?></label> 
                
                <?php wp_nonce_field('forgot_ajax_nonce', 'securityForgot', true); ?>
                <?php
                $args = array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'user-account.php'
                );

                $query = new WP_Query($args);

                while($query->have_posts()) {
                    $query->the_post();
                    $page_id = get_the_ID();
                    $page_title = get_the_title($page_id);
                    $page_link = get_permalink($page_id);
                }
                wp_reset_postdata();
                wp_reset_query();
                ?>
                <a class="ui primary button" href="<?php echo esc_url($page_link); ?>" data-bjax></i><?php echo esc_html("View your Account"); ?></a>
                </div>
            </form>
        </div>
    </div>

<?php } ?>