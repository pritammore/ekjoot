<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

global $current_user;
$current_user = wp_get_current_user();
$user_avatar = $current_user->avatar;
$conikal_general_settings = get_option('conikal_general_settings','');
$conikal_header_settings = get_option('conikal_header_settings','');
$conikal_colors_settings = get_option('conikal_colors_settings');
$conikal_home_settings = get_option('conikal_home_settings');
$shadow_opacity = isset($conikal_home_settings['conikal_shadow_opacity_field']) ? $conikal_home_settings['conikal_shadow_opacity_field'] : '';
$header_menu_color = isset($conikal_colors_settings['conikal_header_menu_color_field']) ? $conikal_colors_settings['conikal_header_menu_color_field'] : '';
$display_name_setting = isset($conikal_header_settings['conikal_user_menu_name_field']) ? $conikal_header_settings['conikal_user_menu_name_field'] : 'none';

if($user_avatar != '') {
    $avatar = $user_avatar;
} else {
    $avatar = get_template_directory_uri().'/images/avatar.svg';
}
$avatar = conikal_get_avatar_url(  $current_user->ID, array('size' => 28, 'default' => $avatar) );

if ($display_name_setting == 'fullname') {
    $username = $current_user->display_name;
} else if ($display_name_setting == 'firstname') {
    $username = $current_user->user_firstname;
} else if ($display_name_setting == 'lastname') {
    $username = $current_user->user_lastname;
} else if ($display_name_setting == 'nickname') {
    $username = $current_user->user_login;
} else {
    $username = '';
}
?>

<?php if(is_user_logged_in()) { ?>
    <?php 
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'submit-petition.php'
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
    <div class="ui inline dropdown item user-menu">
        <div class="text">
            <img class="ui avatar bordered image" src="<?php echo esc_url($avatar); ?>" style="margin-right: 0" />
            <span class="user-menu-label"><?php echo esc_html($username). '<i class="dropdown icon"></i>'; ?></span>
        </div>
        <div class="menu">
            <a class="item" href="<?php echo esc_url($page_link); ?>" data-bjax><i class="write icon"></i> <?php echo esc_html($page_title); ?></a>
            
            <?php 
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
                    $page_title = get_the_title($page_id);
                    $page_link = get_permalink($page_id);
                }
                wp_reset_postdata();
                wp_reset_query();
            ?>
            <a class="item" href="<?php echo esc_url($page_link); ?>" data-bjax><i class="folder icon"></i> <?php echo esc_html($page_title); ?></a>
            <?php
            $args = array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'meta_key' => '_wp_page_template',
                'meta_value' => 'signed-petitions.php'
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
            <a class="item" href="<?php echo esc_url($page_link); ?>" data-bjax><i class="check icon"></i> <?php echo esc_html($page_title); ?></a>
            <?php
            $args = array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'meta_key' => '_wp_page_template',
                'meta_value' => 'bookmark-petitions.php'
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
            <a class="item" href="<?php echo esc_url($page_link); ?>" data-bjax><i class="bookmark icon"></i> <?php echo esc_html($page_title); ?></a>
            
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
            <a class="item" href="<?php echo esc_url($page_link); ?>" data-bjax><i class="user icon"></i> <?php echo esc_html($page_title); ?></a>
            <div class="ui divider"></div>
                <a class="item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="sign out icon"></i> <?php esc_html_e('Logout', 'petition'); ?></a>
        </div>
    </div>
<?php } else { ?>
    <!-- Sign in and sign up buttons -->
    <div class="item">
        <div class="ui grid">
            <div class="column tablet computer only">
                <div class="ui buttons">
                    <button class="signup-btn ui <?php echo ($header_menu_color != '#ffffff' ? 'inverted ' : 'green signup-btn-style ') ?>button"><?php _e('Sign Up', 'petition') ?></button>
                    <div class="or"></div>
                    <button class="signin-btn ui <?php echo ($header_menu_color != '#ffffff' ? 'inverted ' : 'primary ') ?>button"><?php _e('Sign In', 'petition') ?></button>
                </div>
            </div>
            <div class="column mobile only">
                <div class="ui icon dropdown item user-menu">
                    <i class="ellipsis vertical large icon"></i>
                    <div class="menu">
                        <a href="javascript:void(0)" class="item signin-btn"><i class="sign in icon"></i><?php _e('Sign In', 'petition') ?></a>
                        <a href="javascript:void(0)" class="item signup-btn"><i class="add user icon"></i><?php _e('Sign Up', 'petition') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>