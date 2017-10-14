<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_header_settings = get_option('conikal_header_settings','');
$conikal_general_settings = get_option('conikal_general_settings','');
$conikal_colors_settings = get_option('conikal_colors_settings');
$header_menu_color = isset($conikal_colors_settings['conikal_header_menu_color_field']) ? $conikal_colors_settings['conikal_header_menu_color_field'] : '';
$user_menu = isset($conikal_header_settings['conikal_user_menu_field']) ? $conikal_header_settings['conikal_user_menu_field'] : false;
$submit_button = isset($conikal_header_settings['conikal_submit_button_field']) ? $conikal_header_settings['conikal_submit_button_field'] : false;
$style_menu = isset($conikal_header_settings['conikal_style_header_menu_field']) ? $conikal_header_settings['conikal_style_header_menu_field'] : 'boxed';
?>

<div id="header">
    <!-- header desktop menu  -->
    <div class="ui grid" style="margin: auto 0">
        <!-- search link -->
        <div class="ui secondary top fixed search-menu menu" style="margin: auto 0; display: none;">
            <div class="ui container">
                <div class="item" style="padding: 15px 10px 0 0; height: 45px; width: 100%">
                    <div class="ui fluid category search petitions-search" style="width: 100%">
                        <div class="ui icon fluid input">
                          <input class="prompt search-input" type="text" placeholder="<?php esc_html_e('Search...', 'petition') ?>">
                          <i class="remove link icon" id="closeSearch"></i>
                        </div>
                        <div class="results"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- menu -->
        <div class="sixteen wide column computer only" style="padding: 0">
            <div class="ui header-menu secondary fixed menu" style="margin: auto 0">
                <?php echo ($style_menu === 'boxed' ? '<div class="ui container">' : '') ?>
                    <div class="item" style="padding: 5px 0 0 0">
                        <a class="fixed-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-bjax>
                            <?php
                            $logo = isset($conikal_general_settings['conikal_logo_field']) ? $conikal_general_settings['conikal_logo_field'] : '';
                            if($logo != '') {
                                print '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" height="45"/>';
                            } else {
                                print '<div class="ui header">' . esc_html(get_bloginfo('name')) . '</div>';
                            }
                            ?>
                        </a>
                    </div>
                    <div class="right menu">
                        <a href="javascript:void(0)" class="item searchBtn" id="searchBtn"><i class="search icon"></i><?php esc_html_e('Search', 'petition') ?></a>
                        <?php 
                            conikal_custom_menu('primary');

                            if(is_user_logged_in()) {
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

                        if ($submit_button) { ?>
                            <form action="<?php echo esc_url($page_link); ?>" class="item">
                                <button class="ui labeled icon <?php echo ($header_menu_color != '#ffffff' ? 'basic inverted ' : 'primary button submit-petition-btn') ?>" id="add-petition-btn" data-bjax><i class="write icon"></i> <?php echo esc_html($page_title); ?></button>
                            </form>
                        <?php } 
                        } else { 
                        if ($submit_button) { ?>
                            <div class="item">
                                <button href="#" class="submit-signin-btn ui labeled icon <?php echo ($header_menu_color != '#ffffff' ? 'basic inverted ' : 'primary button submit-petition-btn ') ?>" id="add-petition-btn"><i class="write icon"></i> <?php esc_html_e('Start a Petition', 'petition'); ?></button>
                            </div>
                        <?php }
                        }
                            if($user_menu) {
                                get_template_part('templates/app_user_menu');
                            }
                        ?>
                    </div>
                <?php echo ($style_menu === 'boxed' ? '</div>' : '') ?>
            </div>
        </div>
    </div>
    <!-- end header desktop menu -->
    
    <!-- header mobile menu -->
    <div class="ui grid" style="margin: auto 0">
        <div class="sixteen wide column mobile tablet only" style="padding: 0">
            <div class="ui header-menu secondary fixed menu" style="margin: auto 0">
                <div class="ui container">
                    <button class="icon item" id="left-menu-btn">
                        <i class="sidebar large icon"></i>
                    </button>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-top: 10px" data-bjax>
                        <?php
                        $logo = isset($conikal_general_settings['conikal_logo_field']) ? $conikal_general_settings['conikal_logo_field'] : '';
                        if($logo != '') {
                            print '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" height="40"/>';
                        } else {
                            print '<div class="ui header" style="padding-top: 10px">' . esc_html(get_bloginfo('name')) . '</div>';
                        }
                        ?>
                        </a>
                    <div class="right menu">
                        <?php get_template_part('templates/app_user_menu'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header mobile menu -->
</div>
<?php get_template_part('templates/user_modals'); ?>