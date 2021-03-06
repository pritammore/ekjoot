<?php
/*
Template Name: User Account
*/

/**
 * @package WordPress
 * @subpackage Petition
 */


$current_user = wp_get_current_user();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';

$user_meta = get_user_meta($current_user->ID);
$up_nickname = $current_user->user_login;
$up_full_name = $current_user->display_name;
$up_firstname = $current_user->user_firstname ;
$up_lastname = $current_user->user_lastname ;
$up_email = $current_user->user_email;
$up_bio = $current_user->description;
$up_website = $current_user->user_url;
$up_type = get_user_meta($current_user->ID, 'user_type', true);
$up_birthday = get_user_meta($current_user->ID, 'user_birthday', true);
$up_gender = get_user_meta($current_user->ID, 'user_gender', true);
$up_address = get_user_meta($current_user->ID, 'user_address', true);
$up_pincode = get_user_meta($current_user->ID, 'user_pincode', true);
$up_neighborhood = get_user_meta($current_user->ID, 'user_neighborhood', true);
$up_state = get_user_meta($current_user->ID, 'user_state', true);
$up_city = get_user_meta($current_user->ID, 'user_city', true);
$up_country = get_user_meta($current_user->ID, 'user_country', true);
$up_lat = get_user_meta($current_user->ID, 'user_lat', true);
$up_lng = get_user_meta($current_user->ID, 'user_lng', true);
$up_mobile = get_user_meta($current_user->ID, 'user_mobile', true);
$up_hidemobile = get_user_meta($current_user->ID, 'user_hidemobile', true);
if($up_hidemobile == '') $up_hidemobile = 'yes';
$avatar_default = get_template_directory_uri().'/images/avatar.svg';
$up_avatar = isset($user_meta['avatar']) ? $user_meta['avatar'] : $avatar_default;

$display_names = array($up_firstname, $up_lastname, $up_firstname . ' ' . $up_lastname, $up_lastname . ' ' . $up_firstname);

$decision_id = get_user_meta($current_user->ID, 'user_decision', true);
$decision_status = get_post_status( $decision_id );
$decision_title = wp_get_post_terms( $decision_id, 'decisionmakers_title' );
$decision_title = $decision_title ? $decision_title[0]->term_id : '';
$aPost = get_post( $decision_id );
//echo "<pre>"; print_r($aPost); echo "</pre>";exit;
$up_ekwhomi = get_post_meta($decision_id, 'post_whomi', true);
$up_ekorganizationname = get_post_meta($decision_id, 'user_ekorganizationname', true);

$decision_organization = wp_get_post_terms($decision_id, 'decisionmakers_organization');
$decision_organization = $decision_organization ? $decision_organization[0]->name : '';

$decision_title_option = get_terms( 'decisionmakers_title', array(
    'hide_empty' => false,
) );

?>

<div class="ui container">
    <?php if($show_bc != '') {
        conikal_petition_breadcrumbs();
    } ?>
    <div class="page content">
        <br/>
        <div class="ui grid">
            <div class="sixteen wide mobile five wide tablet four wide computer column">
                <?php get_template_part('templates/avatar_upload'); ?>
            </div>
            <div class="sixteen wide mobile eleven wide tablet eight wide computer column">
                <h1 class="ui header"><?php esc_html_e('Manage Profile', 'petition'); ?></h1>
                <?php while(have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ($decision_status == 'pending') { ?>
                        <div id="decision_status">
                            <div class="ui warning message">
                                <i class="warning icon"></i>
                                <?php _e('Leader account confirmation is pending approval!', 'petition') ?>
                            </div>
                        </div>
                    <?php } else if ($decision_status == 'trash') { ?>
                        <div id="decision_status">
                            <div class="ui warning message">
                                <i class="warning icon"></i>
                                <?php _e('Leader account confirmation is Rejected!', 'petition') ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div id="up_response" class="respon-message"></div>
                    <form class="ui form">
                        <input type="hidden" name="decision_id" id="decision_id" value="<?php echo (isset($decision_id) && $decision_id != '' ? $decision_id : ''); ?>">
                        <div class="fields">
                            <div class="eight wide field">
                                <div class="typeUser ui radio checkbox fluid <?php echo (isset($up_type) && $up_type == 'petitioner' ? 'primary' : 'grey'); ?> button" id="petitioner">
                                    <input type="radio" name="typeUser" tabindex="0" class="hidden" value="petitioner" <?php echo (isset($up_type) && $up_type == 'petitioner' ? 'checked' : ''); ?>>
                                    <label style="color: #fff"><?php esc_html_e('Petitioner', 'petition') ?></label>
                                </div>
                            </div>
                            <div class="eight wide field">
                                <div class="typeUser ui radio checkbox fluid <?php echo (isset($up_type) && $up_type == 'decisioner' ? 'primary' : 'grey'); ?> button" id="decisioner">
                                    <input type="radio" name="typeUser" tabindex="0" class="hidden" value="decisioner" <?php echo (isset($up_type) && $up_type == 'decisioner' ? 'checked' : ''); ?>>
                                    <label style="color: #fff"><?php esc_html_e('Leader', 'petition') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="ui hidden divider"></div>
                        <div class="fields">
                            <div class="ten wide field required">
                                <label><?php esc_html_e('Display name', 'petition'); ?></label>
                                <select class="ui dropdown" id="nameUser" name="nameUser">
                                    <?php foreach ($display_names as $name) { ?>
                                       <option value="<?php echo esc_attr($name) ?>" <?php echo ($up_full_name === $name ? 'selected' : '') ?>><?php echo esc_attr($name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="six wide field required">
                                <label><?php esc_html_e('Gender', 'petition') ?></label>
                                <div class="fields" style="padding-top: 10px;">
                                    <div class="eight wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="genderUser" tabindex="0" class="hidden" value="male" <?php echo (isset($up_gender) && $up_gender == 'male' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('Male', 'petition') ?></label>
                                        </div>
                                    </div>
                                    <div class="eight wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="genderUser" tabindex="0" class="hidden" value="famale" <?php echo (isset($up_gender) && $up_gender == 'famale' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('Female', 'petition') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="eight wide field required">
                                <label><?php _e('First Name', 'petition'); ?></label>
                                <input class="text-input" name="firstnameUser" type="text" id="firstnameUser" value="<?php echo isset($up_firstname) ? esc_attr($up_firstname) : ''; ?>" />
                            </div>
                            <div class="eight wide field required">
                                <label><?php _e('Last Name', 'petition'); ?></label>
                                <input class="text-input" name="lastnameUser" type="text" id="lastnameUser" value="<?php echo isset($up_lastname) ? esc_attr($up_lastname) : ''; ?>" />
                            </div>
                        </div>
                        <div class="fields ui <?php echo isset($decision_status) && $decision_status == 'publish' ? 'info' : 'warning'; ?> message" id="decision-fields" style="padding: 0.8em 0.3em; <?php echo (isset($up_type) && $up_type == 'decisioner' ? 'display: flex' : 'display: none'); ?>">
                            <div class="eight wide field required">
                                <label><?php esc_html_e('Title or Position', 'petition'); ?></label>
                                <select class="ui search dropdown decision-title-select" id="titleUser" name="titleUser">
                                    <?php foreach ($decision_title_option as $title) { ?>
                                       <option value="<?php echo esc_attr($title->term_id) ?>"><?php echo esc_attr($title->name) ?></option>
                                    <?php } ?>
                                </select>
                                <?php if(isset($decision_title)) { ?>
                                    <input type="hidden" id="decision_title_id" value="<?php echo isset($decision_title) ? esc_attr($decision_title) : ''; ?>">
                                <?php } ?>
                            </div>
                            <div class="eight wide field required">
                                <label><?php _e('Office or Organization Category', 'petition'); ?></label>
                                <div class="ui fluid multiple search selection dropdown" id="organization-search">
                                    <input name="organizationUser" id="organizationUser" type="hidden">
                                    <i class="dropdown icon"></i>
                                    <div class="default text"><?php _e('Organization', 'petition') ?></div>
                                    <div class="menu">
                                    </div>
                                </div>
                                <?php if(isset($decision_organization)) { ?>
                                    <input type="hidden" id="decision_organization_name" value="<?php echo isset($decision_organization) ? esc_attr($decision_organization) : ''; ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="fields ui info <?php echo isset($decision_status) && $decision_status == 'publish' ? 'info' : 'warning'; ?> message"  id="decision-custom-fields" style="padding: 0.8em 0.3em; <?php echo (isset($up_type) && $up_type == 'decisioner' ? 'display: flex' : 'display: none'); ?>">
                            <div class="seven wide field required">
                                <label><?php esc_html_e('I am / We are ', 'petition'); ?></label>
                                <div class="ui fields" style="padding-top: 10px;">
                                    <div class="seven wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="ekwhomi" tabindex="0" class="hidden" value="0" <?php echo (isset($up_ekwhomi) && $up_ekwhomi == '0' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('Individual', 'petition') ?></label>
                                        </div>
                                    </div>
                                    <div class="seven wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="ekwhomi" tabindex="0" class="hidden" value="1" <?php echo (isset($up_ekwhomi) && $up_ekwhomi == '1' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('Organization', 'petition') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nine wide field required">
                                <label><?php esc_html_e('Organization Name', 'petition'); ?></label>
                                <div class="ui field input right icon">
                                    <i class="users icon"></i>
                                    <input type="text" id="ekorganizationname" name="ekorganizationname" placeholder="<?php esc_html_e('Enter organization you represent', 'petition'); ?>" value="<?php echo isset($up_ekorganizationname) ? esc_attr($up_ekorganizationname) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('E-mail', 'petition'); ?></label>
                            <div class="ui input right icon">
                                <i class="mail icon"></i>
                                <input type="text" id="emailUser" name="emailUser" placeholder="<?php esc_html_e('Enter your e-mail address', 'petition'); ?>" value="<?php echo isset($up_email) ? esc_attr($up_email) : ''; ?>">
                            </div>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('Birthday', 'petition') ?></label>
                            <div class="ui calendar" id="up_birthday">
                                <div class="ui input right icon">
                                    <i class="calendar icon"></i>
                                    <input type="text" name="birthdayUser" id="birthdayUser" placeholder="<?php esc_html_e('Choose your birthday', 'petition'); ?>" value="<?php echo isset($up_birthday) ? esc_attr($up_birthday) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('Address', 'petition') ?></label>
                            <div class="ui input right icon">
                                <i class="marker icon"></i>
                                <input type="text" name="addressUser" id="addressUser" placeholder="<?php esc_html_e('Enter your address', 'petition'); ?>" value="<?php echo isset($up_address) ? esc_attr($up_address) : ''; ?>"></input>
                            </div>
                            <input type="hidden" name="neighborhoodUser" id="neighborhoodUser" value="<?php echo isset($up_neighborhood) ? esc_attr($up_neighborhood) : ''; ?>"></input>
                            <input type="hidden" name="stateUser" id="stateUser" value="<?php echo isset($up_state) ? esc_attr($up_state) : ''; ?>"></input>
                            <input type="hidden" name="cityUser" id="cityUser" value="<?php echo isset($up_city) ? esc_attr($up_city) : ''; ?>"></input>
                            <input type="hidden" name="countryUser" id="countryUser" value="<?php echo isset($up_country) ? esc_attr($up_country) : ''; ?>"></input>
                            <input type="hidden" name="latUser" id="latUser" value="<?php echo isset($up_lat) ? esc_attr($up_lat) : ''; ?>"></input>
                            <input type="hidden" name="lngUser" id="lngUser" value="<?php echo isset($up_lng) ? esc_attr($up_lng) : ''; ?>"></input>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('Pincode', 'petition') ?></label>
                            <div class="ui input right icon">
                                <i class="location arrow icon"></i>
                                <input type="text" name="pincodeUser" id="pincodeUser" placeholder="<?php esc_html_e('', 'petition') ?>" value="<?php echo isset($up_pincode) ? esc_attr($up_pincode) : ''; ?>">
                            </div>
                        </div>
                        <div class="fields">
                            <div class="eight wide field required">
                                <label><?php esc_html_e('Mobile', 'petition') ?></label>
                                <div class="ui input right icon">
                                    <i class="call icon"></i>
                                    <input type="text" name="mobile" id="mobile" placeholder="<?php esc_html_e('Mobile', 'petition') ?>" value="<?php echo isset($up_mobile) ? esc_attr($up_mobile) : ''; ?>">
                                </div>
                            </div>
                            <div class="six wide field required">
                                <label><?php esc_html_e('Hide Mobile No. from visitors', 'petition') ?></label>
                                <div class="fields" style="padding-top: 10px;">
                                    <div class="eight wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="hidemobile" tabindex="0" class="hidden" value="yes" <?php echo (isset($up_hidemobile) && $up_hidemobile == 'yes' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('Yes', 'petition') ?></label>
                                        </div>
                                    </div>
                                    <div class="eight wide field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="hidemobile" tabindex="0" class="hidden" value="no" <?php echo (isset($up_hidemobile) && $up_hidemobile == 'no' ? 'checked' : ''); ?>>
                                            <label><?php esc_html_e('No', 'petition') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label><?php esc_html_e('Website', 'petition') ?></label>
                            <div class="ui input right icon">
                                <i class="linkify icon"></i>
                                <input type="text" name="websiteUser" id="websiteUser" placeholder="<?php esc_html_e('http://', 'petition') ?>" value="<?php echo isset($up_website) ? esc_url($up_website) : ''; ?>">
                            </div>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('Biographical', 'petition') ?> <span style="float: right;"><?php esc_html_e('Max 1000 Characters') ?></span></label>
                            <textarea id="bioUser" rows="8" placeholder="<?php esc_html_e('Introduce about yourself', 'petition'); ?>"><?php echo isset($up_bio) ? $up_bio : ''; ?></textarea>
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('URL profile', 'petition'); ?></label>
                            <div class="ui labeled input">
                                <div class="ui label"><?php echo '/author/' ?></div>
                                <input type="text" id="nicknameUser" name="nicknameUser" placeholder="<?php esc_html_e('Enter your nickname', 'petition'); ?>" value="<?php echo isset($up_nickname) ? esc_attr($up_nickname) : ''; ?>" disabled>
                            </div>
                        </div>
                        <h3 class="ui header"><?php _e('Reset password', 'petition') ?></h3>
                        <h5 class="ui header"><?php _e('<i>Note: Reset password only if required OR leave blank to use your existing password.<br>
                        If you have registered using facebook; after resetting password you would not able to login with facebook. </br>
                        Reset password only if you login using Email Id. facebook user don\'t reset the password.</i>', 'petition') ?></h5>

                        <div class="field required">
                            <label><?php esc_html_e('New Password', 'petition'); ?></label>
                            <input type="password" id="passUser" name="passwordUser" placeholder="<?php esc_html_e('Enter your new password', 'petition'); ?>">
                        </div>
                        <div class="field required">
                            <label><?php esc_html_e('Repeat New Password', 'petition'); ?></label>
                            <input type="password" id="repassUser" name="repassUser" placeholder="<?php esc_html_e('Repeat your new password', 'petition'); ?>">
                        </div>
                        <input type="hidden" name="idUser" id="idUser" value="<?php echo esc_attr($current_user->ID); ?>">
                        
                        <div class="field">
                            <a href="javascript:void(0);" class="ui primary button" id="updateProfileBtn"><?php esc_html_e('Update Profile', 'petition'); ?></a>
                        </div>

                        <?php wp_nonce_field('user_profile_ajax_nonce', 'securityUserProfile', true); ?>
                    </form>
                </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>