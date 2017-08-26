<?php
/**
 * @package WordPress
 * @subpackage Petition
 */


get_header();
?>

<div id="wrapper" style="padding-top: 80px">
    <div class="ui container">
        <div class="ui centered grid">
            <div class="sixteen wide mobile sixteen wide tablet eleven wide computer left aligned column">
            	<div class="ui basic very padded segment">
            	<img class="ui large centered image" src="<?php echo get_template_directory_uri() ?>/images/404-error.svg" />
                <h2 class="ui header"><?php esc_html_e('Sorry, we have a broken link!', 'petition'); ?></h2>
                <p><?php esc_html_e('The page you are looking for was moved, removed, renamed, or might never existed.', 'petition'); ?></p>
                <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ui button" data-bjax><i class="home icon"></i><?php esc_html_e('Go Home', 'petition'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>