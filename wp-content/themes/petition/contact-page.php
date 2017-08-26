<?php
/*
Template Name: Contact Page
*/

/**
 * @package WordPress
 * @subpackage Petition
 */


global $post;
get_header();
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ?  $conikal_appearance_settings['conikal_sidebar_field'] : '';
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$conikal_contact_settings = get_option('conikal_contact_settings','');
$c_name = isset($conikal_contact_settings['conikal_company_name_field']) ? $conikal_contact_settings['conikal_company_name_field'] : '';
$c_email = isset($conikal_contact_settings['conikal_company_email_field']) ? $conikal_contact_settings['conikal_company_email_field'] : '';
$c_phone = isset($conikal_contact_settings['conikal_company_phone_field']) ? $conikal_contact_settings['conikal_company_phone_field'] : '';
$c_mobile = isset($conikal_contact_settings['conikal_company_mobile_field']) ? $conikal_contact_settings['conikal_company_mobile_field'] : '';
$c_skype = isset($conikal_contact_settings['conikal_company_skype_field']) ? $conikal_contact_settings['conikal_company_skype_field'] : '';
$c_address = isset($conikal_contact_settings['conikal_company_address_field']) ? $conikal_contact_settings['conikal_company_address_field'] : '';
$c_facebook = isset($conikal_contact_settings['conikal_company_facebook_field']) ? $conikal_contact_settings['conikal_company_facebook_field'] : '';
$c_twitter = isset($conikal_contact_settings['conikal_company_twitter_field']) ? $conikal_contact_settings['conikal_company_twitter_field'] : '';
$c_google = isset($conikal_contact_settings['conikal_company_google_field']) ? $conikal_contact_settings['conikal_company_google_field'] : '';
$c_linkedin = isset($conikal_contact_settings['conikal_company_linkedin_field']) ? $conikal_contact_settings['conikal_company_linkedin_field'] : '';
?>

<div class="ui container">
    <div class="page content">
        <div class="ui centered grid">
            <div class="sixteen wide mobile sixteen wide tablet eleven wide computer left aligned column" id="content">
                <?php if($show_bc != '') {
                    conikal_petition_breadcrumbs();
                } else {
                    print '<br/>';
                } ?>
                <?php while(have_posts()) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="ui centered header"><?php echo esc_html($c_name); ?></h1>
                    <div class="ui segment">
                        <div class="ui grid">
                            <div class="sixteen wide mobile ten wide tablet ten wide computer column">
                                <h3 class="ui dividing header"><?php esc_html_e('Contact Details', 'petition'); ?></h3>
                                <div class="ui large list">
                                <?php if($c_phone && $c_phone != '') { ?>
                                    <div class="item"><i class="phone icon"></i> <?php echo esc_html($c_phone); ?></div>
                                <?php } ?>
                                <?php if($c_mobile && $c_mobile != '') { ?>
                                    <div class="item"><i class="mobile icon"></i> <?php echo esc_html($c_mobile); ?></div>
                                <?php } ?>
                                <?php if($c_email && $c_email != '') { ?>
                                    <div class="item"><i class="envelope icon"></i> <?php echo esc_html($c_email); ?></div>
                                <?php } ?>
                                <?php if($c_skype && $c_skype != '') { ?>
                                    <div class="item"><i class="skype icon"></i> <?php echo esc_html($c_skype); ?></div>
                                <?php } ?>
                                <?php if($c_address && $c_address != '') { ?>
                                    <div class="icon"><i class="marker icon"></i> <?php echo esc_html($c_address); ?></div>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="sixteen wide mobile six wide tablet six wide computer column">
                                <?php if(($c_facebook && $c_facebook != '') || ($c_twitter && $c_twitter != '') || ($c_google && $c_google != '') || ($c_linkedin && $c_linkedin != '')) { ?>
                                    <h3 class="ui dividing header"><?php esc_html_e('Follow Us', 'petition'); ?></h3>
                                    <?php if($c_facebook && $c_facebook != '') { ?>
                                        <a href="<?php echo esc_url($c_facebook); ?>" class="ui facebook icon button"><i class="facebook f icon"></i></a>
                                    <?php } ?>
                                    <?php if($c_twitter && $c_twitter != '') { ?>
                                        <a href="<?php echo esc_url($c_twitter); ?>" class="ui twitter icon button"><i class="twitter icon"></i></a>
                                    <?php } ?>
                                    <?php if($c_google && $c_google != '') { ?>
                                        <a href="<?php echo esc_url($c_google); ?>" class="ui google plus icon button"><i class="google plus icon"></i></a>
                                    <?php } ?>
                                    <?php if($c_linkedin && $c_linkedin != '') { ?>
                                        <a href="<?php echo esc_url($c_linkedin); ?>" class="ui linkedin icon button"><i class="linkedin icon"></i></a>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="entry-content">
                        <?php the_content(); ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="ui segment">

                        <div class="respon-message" id="cp_response"></div>
                        <form class="ui form">
                            <h3 class="ui dividing header"><?php esc_html_e('Send Us a Message', 'petition'); ?></h3>
                            <input type="hidden" id="company_email" name="company_email" value="<?php echo esc_attr($c_email); ?>">
                            <div class="fields">
                                <div class="eight wide required field">
                                        <label><?php esc_html_e('Name', 'petition'); ?></label>
                                        <input type="text" id="cp_name" name="cp_name" placeholder="<?php esc_html_e('Enter your name', 'petition'); ?>">
                                 </div>
                                <div class="eight wide required field">
                                        <label><?php esc_html_e('Email', 'petition'); ?></label>
                                        <input type="text" id="cp_email" name="cp_email" placeholder="<?php esc_html_e('Enter your email', 'petition'); ?>">
                                </div>
                            </div>
                            <div class="required field">
                                        <label><?php esc_html_e('Subject', 'petition'); ?></label>
                                        <input type="text" id="cp_subject" name="cp_subject" placeholder="<?php esc_html_e('Enter the subject', 'petition'); ?>">
                            </div>
                            <div class="required field">
                                        <label><?php esc_html_e('Message', 'petition'); ?></label>
                                        <textarea id="cp_message" name="cp_message" placeholder="<?php esc_html_e('Type your message', 'petition'); ?>" rows="5"></textarea>
                            </div>
                            <div class="field">
                                <a href="javascript:void(0);" class="ui primary button" id="sendContactMessageBtn"><?php esc_html_e('Send Message', 'petition'); ?></a>
                            </div>
                            <?php wp_nonce_field('contact_page_ajax_nonce', 'securityContactPage', true); ?>
                        </form>
                    </div>
                </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>