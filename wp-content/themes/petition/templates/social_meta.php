<?php
/**
 * @package WordPress
 * @subpackage Reales
 */


$conikal_auth_settings = get_option('conikal_auth_settings','');
$google_login = isset($conikal_auth_settings['conikal_google_login_field']) ? $conikal_auth_settings['conikal_google_login_field'] : false;
$google_client_id = isset($conikal_auth_settings['conikal_google_id_field']) ? $conikal_auth_settings['conikal_google_id_field'] : false;
$google_client_secret = isset($conikal_auth_settings['conikal_google_secret_field']) ? $conikal_auth_settings['conikal_google_secret_field'] : false;
?>

<?php if($google_login && $google_client_id) { ?>
    <meta name="google-signin-clientid" content="<?php echo esc_attr($google_client_id); ?>" />
    <meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login" />
    <meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
    <meta name="google-signin-cookiepolicy" content="single_host_origin" />
<?php } ?>