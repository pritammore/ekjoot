<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php get_template_part('templates/social_meta'); ?>
    <?php wp_head(); ?>
</head>

<?php
$conikal_home_settings = get_option('conikal_home_settings','');
$home_header = isset($conikal_home_settings['conikal_home_header_field']) ? $conikal_home_settings['conikal_home_header_field'] : '';
$home_caption = isset($conikal_home_settings['conikal_home_caption_field']) ? $conikal_home_settings['conikal_home_caption_field'] : '';
$home_spotlight = isset($conikal_home_settings['conikal_home_spotlight_field']) ? $conikal_home_settings['conikal_home_spotlight_field'] : '';
$home_victory = isset($conikal_home_settings['conikal_home_victory_field']) ? $conikal_home_settings['conikal_home_victory_field'] : '';
$home_victory_hide_logined = isset($conikal_home_settings['conikal_home_victory_hide_logined_field']) ? $conikal_home_settings['conikal_home_victory_hide_logined_field'] : '';
$home_header_hide_logined = isset($conikal_home_settings['conikal_home_header_hide_logined_field']) ? $conikal_home_settings['conikal_home_header_hide_logined_field'] : ''; 
?>

<body <?php body_class(); ?>>
    <?php get_template_part('templates/leftside_menu'); ?>
    
    <?php
        if(is_front_page()){
            get_template_part('templates/front_hero');
        } else if(is_home()) {
            get_template_part('templates/blog_hero');
        } else if(is_single() && !is_singular('petition') && !is_singular('update')) { 
            get_template_part('templates/post_hero');
        } else if(!is_page_template('petitions-search-results.php') && 
                    !is_page_template('submit-petition.php') && 
                    !is_page_template('edit-petition.php') &&
                    !is_page_template('dashboard-petition.php') &&
                    !is_page_template('add-update.php') &&
                    !is_singular('petition') &&
                    !is_singular('update') &&
                    !is_404() && 
                    !is_page_template('all-issues.php') && 
                    !is_page_template('all-leaders.php')) { 
            get_template_part('templates/page_hero');
        }

        if(is_page_template('petitions-search-results.php') || 
                is_singular('petition') || 
                is_singular('update') || 
                is_page_template('submit-petition.php') ||
                is_page_template('dashboard-petition.php') ||
                is_page_template('edit-petition.php') ||
                is_page_template('add-update.php') ||
                is_page_template('all-issues.php') || 
                is_page_template('all-leaders.php') || 
                is_404()) { 
            get_template_part('templates/app_header');
        } else {
            if ( is_front_page() && $home_header != 'none' && ($home_header_hide_logined != '') ) {
                if (is_user_logged_in()) {
                    get_template_part('templates/app_header');
                } else {
                    get_template_part('templates/home_header');
                }
            } else if ( is_front_page() && $home_header != 'none' ) {
                get_template_part('templates/home_header');
            } else if ( is_front_page() && $home_header === 'none' ) {
                get_template_part('templates/app_header');
            } else {
                get_template_part('templates/home_header');
            }
        }

        if ( is_front_page() && ($home_header != 'none') && ($home_header_hide_logined != '') ) {
            if (!is_user_logged_in()) {
                get_template_part('templates/home_caption');
            }
        } else if (is_front_page() && $home_header != 'none') {
            get_template_part('templates/home_caption');
        }

        if(!is_front_page() && 
                !is_home() && 
                !is_search() && 
                !is_single() && 
                !is_404() && 
                !is_page_template('petitions-search-results.php') && 
                !is_singular('ds-idx-listings-page') && 
                !is_page_template('idx-listings.php') && 
                !is_page_template('submit-petition.php') &&
                !is_page_template('edit-petition.php') &&
                !is_page_template('dashboard-petition.php') &&
                !is_page_template('add-update.php') && 
                !is_page_template('all-issues.php') && 
                !is_page_template('all-leaders.php')) {
            get_template_part('templates/page_caption');
        } else if (is_home()) {
            get_template_part('templates/blog_featured');
        }
        ?>

        </div>

        <?php
        /*if(is_front_page() && $home_victory && $home_victory_hide_logined) {
            if (!is_user_logged_in()) {
                get_template_part('templates/victory_petitions');
            }
        } else if (is_front_page() && $home_victory) {
            get_template_part('templates/victory_petitions');
        }*/
        
        /*if(is_front_page() && $home_spotlight) {
            get_template_part('templates/home_spotlight');  
        }*/
    ?>
