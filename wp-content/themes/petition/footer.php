<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

$conikal_auth_settings = get_option('conikal_auth_settings','');
$conikal_general_settings = get_option('conikal_general_settings','');
$google_analytics = isset($conikal_general_settings['conikal_google_analytics_field']) ? $conikal_general_settings['conikal_google_analytics_field'] : '';
$fb_login = isset($conikal_auth_settings['conikal_fb_login_field']) ? $conikal_auth_settings['conikal_fb_login_field'] : false;
$fb_app_id = isset($conikal_auth_settings['conikal_fb_id_field']) ? $conikal_auth_settings['conikal_fb_id_field'] : '';
?>

<?php
    if( !is_page_template('my-petitions.php') && 
        !is_page_template('signed-petitions.php') && 
        !is_page_template('bookmark-petitions.php') && 
        !is_page_template('homepage.php') && 
        !is_page_template('all-issues.php') && 
        !is_page_template('all-leaders.php') &&
        !is_page_template('single-petition.php') &&
        !is_author() ) { 
        get_template_part('templates/app_footer');
    }
?>  
    <a href="javascript:void(0)" id="back-to-top"><i class="angle up icon"></i></a>

    <?php if($fb_login && !is_user_logged_in()) { ?>
        <div id="fb-root"></div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : <?php echo esc_js($fb_app_id); ?>,
                    status     : true,
                    cookie     : true,
                    xfbml      : true,
                    version    : 'v2.8'
                });
            };
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    <?php } 
        if ($google_analytics != '') {
            echo $google_analytics;
        }
    ?>

    <?php wp_footer(); ?>
</body>
</html>