<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
include get_template_directory() . '/admin/settings.php';
include get_template_directory() . '/libs/widgets.php';
include get_template_directory() . '/libs/newsfeed.php';
include get_template_directory() . '/libs/leadersfeed.php';
include get_template_directory() . '/libs/institutionsfeed.php';
include get_template_directory() . '/libs/search_petitions.php';
include get_template_directory() . '/libs/featured_petitions.php';
include get_template_directory() . '/libs/trending_petitions.php';
include get_template_directory() . '/libs/my_petitions.php';
include get_template_directory() . '/libs/sign_petitions.php';
include get_template_directory() . '/libs/author_petitions.php';
include get_template_directory() . '/libs/bookmark_petitions.php';
include get_template_directory() . '/libs/following.php';
include get_template_directory() . '/libs/comment_petition.php';
include get_template_directory() . '/libs/post_views.php';
include get_template_directory() . '/libs/petitions.php';
include get_template_directory() . '/libs/users.php';
include get_template_directory() . '/libs/ajax_upload.php';
include get_template_directory() . '/libs/save_petition.php';
include get_template_directory() . '/libs/save_update.php';
include get_template_directory() . '/libs/contact_company.php';
include get_template_directory() . '/libs/contact_user.php';
include get_template_directory() . '/libs/theme_setup.php';
include get_template_directory() . '/libs/class-tgm-plugin-activation.php';
// REGISTER REQUIRED PLUGINS
add_action( 'tgmpa_register', 'conikal_register_required_plugins' );
if( !function_exists('conikal_register_required_plugins') ): 
function conikal_register_required_plugins() {
    $plugins = array(
        array(
            'name'               => 'Petition Plugin', // The plugin name.
            'slug'               => 'petition-plugin', // The plugin slug (typically the folder name).
            'source'             => 'https://www.conikal.com/petition/plugins/petition-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.3.6',
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
    );
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'petition'),
            'menu_title'                      => __( 'Install Plugins', 'petition'),
            'installing'                      => __( 'Installing Plugin: %s', 'petition'), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'petition'),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'petition'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'petition'), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'petition'), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'petition'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'petition'), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'petition'), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'petition'), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'petition'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'petition'),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'petition'),
            'return'                          => __( 'Return to Required Plugins Installer', 'petition'),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'petition'),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'petition'), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa( $plugins, $config );
}
endif;
// ENQUEUE SCRIPTS ADN STYLES FOR THE FRONT END
if( !function_exists('petition_scripts') ): 
    function petition_scripts() {
        global $paged;
        global $post;
        $user = wp_get_current_user();
        $conikal_general_settings = get_option('conikal_general_settings');
        $conikal_header_settings = get_option('conikal_header_settings');
        $conikal_typography_settings = get_option('conikal_typography_settings');
        $smooth_scroll = isset($conikal_general_settings['conikal_smooth_scroll_field']) ? $conikal_general_settings['conikal_smooth_scroll_field'] : 'disabled';
        $ajax_pages = isset($conikal_general_settings['conikal_ajax_pages_field']) ? $conikal_general_settings['conikal_ajax_pages_field'] : 'disabled';
        $type_preloader = isset($conikal_general_settings['conikal_type_ajax_preloader_field']) ? $conikal_general_settings['conikal_type_ajax_preloader_field'] : 'none';
        $html_preloader = conikal_preloader_html($type_preloader);
        $type_menu = isset($conikal_header_settings['conikal_type_header_menu_field']) ? $conikal_header_settings['conikal_type_header_menu_field'] : 'scroll';
        $mobile_menu_animation = isset($conikal_header_settings['conikal_mobile_menu_animation_field']) ? $conikal_header_settings['conikal_mobile_menu_animation_field'] : 'overlay';
        $conikal_search_settings = get_option('conikal_search_settings');
        $min_characters = isset($conikal_search_settings['conikal_s_min_characters_field']) ? $conikal_search_settings['conikal_s_min_characters_field'] : 3;
        $max_results = isset($conikal_search_settings['conikal_s_max_results_field']) ? $conikal_search_settings['conikal_s_max_results_field'] : 7;
        $search_type = isset($conikal_search_settings['conikal_s_type_field']) ? $conikal_search_settings['conikal_s_type_field'] : 'category';
        $search_settings = $conikal_search_settings;
        array_splice($search_settings, 0, 3);
        $conikal_auth_settings = get_option('conikal_auth_settings','');
        $gmaps_key = (isset($conikal_auth_settings['conikal_gmaps_key_field']) && $conikal_auth_settings['conikal_gmaps_key_field'] !='') ? $conikal_auth_settings['conikal_gmaps_key_field'] : 'AIzaSyAUYuX_iOuWgl5b5gSdmaL1QeLgbmxbBnU';
        // Load Google Fonts
        $fonts_field = array(
                'conikal_typography_body_font_field',
                'conikal_typography_home_heading_font_field',
                'conikal_typography_home_subheading_font_field',
                'conikal_typography_heading_font_field',
                'conikal_typography_page_heading_font_field',
                'conikal_typography_widget_title_font_field',
                'conikal_typography_title_font_field',
                'conikal_typography_content_font_field',
                'conikal_typography_button_font_field'
            );
        $fonts = array();
        $string_fonts = '';
        foreach ($fonts_field as $id => $field) {
            $family = $conikal_typography_settings[$field];
            $family = explode(',', $family);
            $family = str_replace(" ", "+", $family[0]);
            array_push($fonts, $family);
        }
        $fonts = array_unique($fonts);
        
        foreach ($fonts as $font) {
            $string_fonts .= $font . ':regular|';
        }
        wp_enqueue_style('google-fonts','https://fonts.googleapis.com/css?family=' . $string_fonts, array(), '1.1.0', 'all');
        // Load stylesheets
        wp_enqueue_style('style',get_stylesheet_uri(), array(), '1.2.0', 'all');
        wp_enqueue_style('semantic-ui',get_template_directory_uri().'/css/semantic.min.css', array(), '2.2.2', 'all');
        wp_enqueue_style('semantic-calendar',get_template_directory_uri().'/css/calendar.min.css', array(), '2.1.4', 'all');
        // Load scripts
        wp_enqueue_script('semantic-ui', get_template_directory_uri().'/js/semantic.min.js',array('jquery'), '2.2.10', true);
        wp_enqueue_script('semantic-calendar', get_template_directory_uri().'/js/calendar.min.js',array('jquery'), '2.1.4', true);
        wp_enqueue_script('slick', get_template_directory_uri().'/js/slick.min.js',array('jquery'), '1.3.11', true);
        wp_enqueue_script('jarallax', get_template_directory_uri().'/js/jarallax.min.js',array('jquery'), '1.4.2', true);
        wp_enqueue_script('jarallax-video', get_template_directory_uri().'/js/jarallax-video.min.js',array('jquery'), '1.4.2', true);
        wp_enqueue_script('slimscroll', get_template_directory_uri().'/js/jquery.slimscroll.min.js',array('jquery'), '1.3.0', true);
        wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_key . '&amp;libraries=geometry&amp;libraries=places&amp;language=en',array('jquery'), '1.0', true);
        wp_enqueue_script('google-plus', 'https://plus.google.com/js/client:platform.js',array('jquery'), '1.0', true);
        if ($ajax_pages == 'activated') {
            wp_enqueue_script('bjax', get_template_directory_uri().'/js/bjax.min.js',array('jquery'), '1.0.2', true);
            if ($type_preloader != 'none') {
                wp_enqueue_style('spinkit',get_template_directory_uri().'/css/spinkit.min.css', array('jquery'), '1.2.5', 'all');
            }
        }
        if ($smooth_scroll == 'activated' && !wp_is_mobile()) {
            wp_enqueue_script('smoothscroll', get_template_directory_uri().'/js/smoothscroll.min.js',array('jquery'), '5.5.2', true);
        }
        if (is_page_template('dashboard-petition.php')) {
            wp_enqueue_script('chart', get_template_directory_uri().'/js/Chart.min.js',array('jquery'), '2.5.0', true);
        }
        //wp_enqueue_script('conikal-services', get_template_directory_uri().'/js/services.min.js',array('jquery'), '1.0', true);
        wp_enqueue_script('conikal-services', get_template_directory_uri().'/js/services.js',array('jquery'), '1.0', true);
        //wp_enqueue_script('conikal-theming', get_template_directory_uri().'/js/theming.min.js',array('jquery'), '1.0', true);
        wp_enqueue_script('conikal-theming', get_template_directory_uri().'/js/theming.js',array('jquery'), '1.0', true);
        $search_country = isset($_GET['search_country']) ? sanitize_text_field($_GET['search_country']) : '';
        $search_state = isset($_GET['search_state']) ? sanitize_text_field($_GET['search_state']) : '';
        $search_city = isset($_GET['search_city']) ? sanitize_text_field($_GET['search_city']) : '';
        $search_category = isset($_GET['search_category']) ? sanitize_text_field($_GET['search_category']) : '0';
        $search_lat = isset($_GET['search_lat']) ? sanitize_text_field($_GET['search_lat']) : '';
        $search_lng = isset($_GET['search_lng']) ? sanitize_text_field($_GET['search_lng']) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? sanitize_text_field($_GET['search_neighborhood']) : '';
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';
        wp_localize_script('conikal-services', 'services_vars', 
            array(  'admin_url' => get_admin_url(),
                    'signin_redirect' => home_url(),
                    'home_url' => home_url(),
                    'theme_url' => get_template_directory_uri(),
                    'is_mobile' => (wp_is_mobile() ? 'true' : 'false'),
                    'signup_text' => __('Sign Up','petition'),
                    'signin_text' => __('Sign In','petition'),
                    'forgot_text' => __('Get New Password','petition'),
                    'reset_pass_text' => __('Reset Password','petition'),
                    'fb_login_text' => __('Sign In with Facebook','petition'),
                    'fb_login_error' => __('Login cancelled or not fully authorized!','petition'),
                    'google_signin_text' => __('Sign In with Google','petition'),
                    'google_signin_error' => __('Signin cancelled or not fully authorized!','petition'),
                    'sort' => $sort,
                    'page' => $paged,
                    'post_id' => $post ? $post->ID : NULL,
                    'user_id' => $user->ID,
                    'administrator' => current_user_can('administrator'), 
                    'follow' => __('Follow', 'petition'),
                    'following' => __('Following', 'petition'),
                    'unfollow' => __('Unfollow', 'petition'),
                    'edit' => __('Edit', 'petition'),
                    'delete' => __('Delete', 'petition'),
                    'comments' => __('comments', 'petition'),
                    'comment_reply' => __('Reply', 'petition'),
                    'comment_placeholder' => __('Write comment here', 'petition'),
                    'comment_reply_to' => __('Reply to', 'petition'),
                    'comment_vote' => __('like', 'petition'),
                    'comment_up_vote' => __('Like', 'petition'),
                    'comment_down_vote' => __('Unlike', 'petition'),
                    'comment_view_all' => __('View all', 'petition'),
                    'comment_replies' => __('replies', 'petition'),
                    'comment_replies_hide' => __('Hide replies', 'petition'),
                    'petition_to' => __('Petition to', 'petition'),
                    'supporters' => __('supporters', 'petition'),
                    'min_characters' => $min_characters,
                    'max_results' => $max_results,
                    'search_type' => (wp_is_mobile() ? 'standard' : $search_type),
                    'search_settings' => json_encode($search_settings)
            )
        );
        wp_localize_script('conikal-theming', 'theming_vars', 
            array(  'admin_url' => get_admin_url(),
                    'home_url' => home_url(),
                    'theme_url' => get_template_directory_uri(),
                    'is_mobile' => (wp_is_mobile() ? 'true' : 'false'),
                    'full_name_holder' => __('Who can make this happen?','petition'),
                    'position_holder' => __('What is their position?','petition'),
                    'copy_clipboard' => __('Text copied to the clipboard.', 'petition'),
                    'copy_clipboard_err' => __('Copy not supported or blocked.  Press Ctrl+c to copy.', 'petition'),
                    'save' => __('Save', 'petition'),
                    'cancel' => __('Cancel', 'petition'),
                    'type_menu' => $type_menu,
                    'mobile_menu_animation' => $mobile_menu_animation,
                    'html_preloader' => $html_preloader
            )
        );
        if(current_user_can('manage_options')) {
            $top_admin_menu = true;
        } else {
            $top_admin_menu = false;
        }
        
        $max_file_size  = 100 * 1000 * 1000;
        $resize_image = array();
        if (is_page_template('submit-petition.php') || is_page_template('edit-petition.php')) {
            $resize_image = array('width' => 1600, 'height' => 900, 'crop' => true);
        } 
        if (is_page_template('user-account.php')) {
            $resize_image = array('width' => 300, 'height' => 300, 'crop' => true);
        }
        wp_enqueue_script('ajax-upload', get_template_directory_uri().'/js/ajax-upload.js',array('jquery','plupload-handlers'), '1.0', true);
        wp_localize_script('ajax-upload', 'ajax_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'nonce'             => wp_create_nonce('conikal_upload'),
                    'remove'            => wp_create_nonce('conikal_remove'),
                    'number'            => 1,
                    'upload_enabled'    => true,
                    'confirmMsg'        => __('Are you sure you want to delete this?','petition'),
                    'delete'            => __('Delete','petition'),
                    'plupload'          => array(
                                            'runtimes'          => 'html5,flash,silverlight,html4',
                                            'browse_button'     => 'aaiu-uploader',
                                            'container'         => 'aaiu-upload-container',
                                            'file_data_name'    => 'aaiu_upload_file',
                                            'max_file_size'     => $max_file_size . 'b',
                                            'url'               => admin_url('admin-ajax.php') . '?action=conikal_upload&nonce=' . wp_create_nonce('conikal_allow'),
                                            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
                                            'filters'           => array(array('title' => __('Allowed Files','petition'), 'extensions' => "jpeg,jpg,gif,png")),
                                            'multipart'         => true,
                                            'multi_selection'   => false,
                                            'dragdrop'          => true,
                                            'drop_element'      => 'box-upload',
                                            'urlstream_upload'  => true,
                                            'resize'            => $resize_image
                                        )
                )
        );
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
endif;
add_action( 'wp_enqueue_scripts', 'petition_scripts' );
// HEADER TITLE TAG
function theme_slug_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );
// DISABLE ADMIN BAR FOR EVERYONE BUT ADMINISTRATORS
if (!function_exists('conikal_disable_admin_bar')):
    function conikal_disable_admin_bar() {
        
        if (!current_user_can('manage_options')) {
        
            // for the admin page
            remove_action('admin_footer', 'wp_admin_bar_render', 1000);
            // for the front-end
            remove_action('wp_footer', 'wp_admin_bar_render', 1000);
            
            // css override for the admin page
            function conikal_remove_admin_bar_style_backend() { 
                echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
            }     
            add_filter('admin_head', 'conikal_remove_admin_bar_style_backend');
            
            // css override for the frontend
            function conikal_remove_admin_bar_style_frontend() {
                echo '<style type="text/css" media="screen">
                html { margin-top: 0px !important; }
                * html body { margin-top: 0px !important; }
                </style>';
            }
            add_filter('wp_head', 'conikal_remove_admin_bar_style_frontend', 99);
        } else {
            function conikal_add_admin_bar_style_frontend() {
                echo '';
            }
            add_filter('wp_head', 'conikal_add_admin_bar_style_frontend', 99);
        }
    }
endif;
add_action('init', 'conikal_disable_admin_bar');
// CUSTOM COLORS
if( !function_exists('conikal_add_custom_colors_typography') ): 
    function conikal_add_custom_colors_typography() {
        echo "<style type='text/css'>" ;
        require_once ('libs/colors.php');
        require_once ('libs/typography.php');
        echo "</style>";
    }
endif;
add_action('wp_head', 'conikal_add_custom_colors_typography');
// ADD CUSTOM FIELD TO MEDIA LIBRARY ITEMS
if( !function_exists('conikal_image_add_custom_fields') ): 
    function conikal_image_add_custom_fields($form_fields, $post) {
        $value = get_post_meta($post->ID, "show-in-slideshow", true);
        if($value) {
            $checked = "checked";
        } else {
            $checked = "";
        }
        $form_fields["show-in-slideshow"] = array(
            "label" => __("Show in Slideshow", "petition"),
            "input" => "html",
            "html" => "<input type='checkbox' name='attachments[{$post->ID}][show-in-slideshow]' id='attachments[{$post->ID}][show-in-slideshow]' $checked />"
        );
        return $form_fields;
    }
endif;
add_filter("attachment_fields_to_edit", "conikal_image_add_custom_fields", null, 2);
// SAVE CUSTOM FIELDS VALUE
if( !function_exists('conikal_image_save_custom_fields') ): 
    function conikal_image_save_custom_fields($post, $attachment) {
        if(isset($attachment['show-in-slideshow'])) {
            update_post_meta($post['ID'], 'show-in-slideshow', $attachment['show-in-slideshow']);
        } else {
            delete_post_meta($post['ID'], 'show-in-slideshow');
        }
        return $post;
    }
endif;
add_filter("attachment_fields_to_save", "conikal_image_save_custom_fields", null , 2);
// ADD SHOW IN SLIDESHOW COLUMN IN MEDIA LIBRARY
if( !function_exists('conikal_image_attachment_columns') ): 
    function conikal_image_attachment_columns($columns) {
        $columns['show-in-slideshow'] = __("Show in Slideshow", "petition");
        return $columns;
    }
endif;
add_filter("manage_media_columns", "conikal_image_attachment_columns", null, 2);
// ADD SHOW IN SLIDESHOW COLUMN DATE IN MEDIA LIBRARY
if( !function_exists('conikal_image_attachment_show_column') ): 
    function conikal_image_attachment_show_column($name) {
        global $post;
        switch ($name) {
            case 'show-in-slideshow':
                $value = get_post_meta($post->ID, "show-in-slideshow", true);
                if ($value) {
                    esc_html_e("yes", "petition");
                } else {
                    esc_html_e("no", "petition");
                }
                break;
        }
    }
endif;
add_action('manage_media_custom_column', 'conikal_image_attachment_show_column', null, 2);
// GET SLIDESHOW IMAGES
if( !function_exists('conikal_get_slideshow_images') ): 
    function conikal_get_slideshow_images() {
        $media_query = new WP_Query(
            array(
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
            )
        );
        $list = array();
        foreach ($media_query->posts as $post) {
            if (get_post_meta($post->ID, "show-in-slideshow", true)) {
                $list[] = wp_get_attachment_url($post->ID);
            }
        }
        return $list;
    }
endif;
add_action( 'wp_loaded', 'conikal_get_slideshow_images' );
// ADD CUSTOM PROFILE FIELD
if( !function_exists('conikal_add_custom_profile_fields') ): 
    function conikal_add_custom_profile_fields($profile_fields) {
        $profile_fields['avatar'] = 'Avatar URL';
        return $profile_fields;
    }
endif;
add_filter('user_contactmethods', 'conikal_add_custom_profile_fields');
// REGISTER SIDEBAR
if( !function_exists('conikal_widgets_init') ): 
    function conikal_widgets_init() {
        register_sidebar(array(
            'name' => __('Main Widget Area','petition'),
            'id' => 'main-widget-area',
            'description' => __('The main widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="ui dividing header widget-title">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
            'name' => __('Blog Widget Area','petition'),
            'id' => 'blog-widget-area',
            'description' => __('Blogs widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="ui dividing header widget-title">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
            'name' => __('1st Footer Widget Area','petition'),
            'id' => 'first-footer-widget-area',
            'description' => __('The first footer widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
            'name' => __('2nd Footer Widget Area','petition'),
            'id' => 'second-footer-widget-area',
            'description' => __('The second footer widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
            'name' => __('3rd Footer Widget Area','petition'),
            'id' => 'third-footer-widget-area',
            'description' => __('The third footer widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
            'name' => __('4th Footer Widget Area','petition'),
            'id' => 'fourth-footer-widget-area',
            'description' => __('The fourth footer widget area','petition'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ));
    }
endif;
add_action( 'widgets_init', 'conikal_widgets_init' );
// CUSTOM METABOXS IN POST
if( !function_exists('conikal_add_post_metaboxes') ): 
    function conikal_add_post_metaboxes() {
        add_meta_box('post-featured-section', __('Featured','petition'), 'conikal_post_featured_render', 'post', 'side', 'default');
    }
endif;
add_action('add_meta_boxes', 'conikal_add_post_metaboxes');
if( !function_exists('conikal_post_featured_render') ): 
    function conikal_post_featured_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'post_noncename');
        $post_id = '';
        if(isset($_GET['post'])) {
            $post_id = sanitize_text_field($_GET['post']);
        } else if(isset($_POST['post_ID'])) {
            $post_id = sanitize_text_field($_POST['post_ID']);
        }
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="post_featured" value="">
                            <input type="checkbox" name="post_featured" value="1" ';
                            if (esc_html(get_post_meta($post_id, 'post_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="post_featured">' . __('Set as Featured','petition') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;
if( !function_exists('conikal_post_meta_save') ): 
    function conikal_post_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['post_noncename']) && wp_verify_nonce($_POST['post_noncename'], basename(__FILE__))) ? 'true' : 'false';
        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }
        if(isset($_POST['post_featured'])) {
            update_post_meta($post_id, 'post_featured', sanitize_text_field($_POST['post_featured']));
        }
    }
endif;
add_action('save_post', 'conikal_post_meta_save');
// CUSTOM EXCERTP LENGTH
if( !function_exists('conikal_custom_excerpt_length') ): 
    function conikal_custom_excerpt_length( $length ) {
        return 30;
    }
endif;
add_filter( 'excerpt_length', 'conikal_custom_excerpt_length', 999 );
if( !function_exists('conikal_get_excerpt_by_id') ): 
    function conikal_get_excerpt_by_id($post_id, $excerpt_length = 30) {
        $the_post = get_post($post_id);
        $the_excerpt = $the_post->post_content;
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);
        if(count($words) > $excerpt_length) :
            array_pop($words);
            array_push($words, '...');
            $the_excerpt = implode(' ', $words);
        endif;
        return $the_excerpt;
    }
endif;

// CUSTOM EXCERTP LENGTH
if( !function_exists('conikal_custom_biographical_length') ): 
    function conikal_custom_biographical_length( $length ) {
        return 30;
    }
endif;
add_filter( 'biographical_length', 'conikal_custom_biographical_length', 999 );

if( !function_exists('conikal_get_biographical_by_id') ): 
    function conikal_get_biographical_by_id($user_id, $biographical_length = 30) {
        $the_biographical = get_user_meta($user_id, 'description', true);
        $the_biographical = strip_tags(strip_shortcodes($the_biographical));
        $words = explode(' ', $the_biographical, $biographical_length + 1);

        if(count($words) > $biographical_length) :
            array_pop($words);
            array_push($words, '...');
            $the_biographical = implode(' ', $words);
        endif;

        return $the_biographical;
    }
endif;

// SORT ARRAY BY VALUE
function conikal_array_sort($array, $sortby, $direction='asc') {
     
    $sortedArr = array();
    $tmp_Array = array();
     
    foreach($array as $k => $v) {
        $tmp_Array[] = strtolower($v->$sortby);
    }
     
    if($direction=='asc'){
        asort($tmp_Array);
    }else{
        arsort($tmp_Array);
    }
     
    foreach($tmp_Array as $k=>$tmp){
        $sortedArr[] = $array[$k];
    }
     
    return $sortedArr;
}
// ADD POST VIEW COLUMN IN ADMIN
if( !function_exists('conikal_posts_column_views') ): 
    function conikal_posts_column_views($defaults) {
        $defaults['post_views'] = __('Views','petition');
        return $defaults;
    }
endif;
add_filter('manage_posts_columns', 'conikal_posts_column_views');
if( !function_exists('conikal_posts_custom_column_views') ): 
    function conikal_posts_custom_column_views($column_name, $id) {
        if($column_name === 'post_views'){
            echo conikal_get_post_views(get_the_ID(), '');
        }
    }
endif;
add_action('manage_posts_custom_column', 'conikal_posts_custom_column_views', 5, 2);
// ADD PAGINATION
if( !function_exists('conikal_pagination') ): 
    function conikal_pagination($pages = '', $range = 2) {
        $showitems = ($range * 2)+1;
        global $paged;
        if(empty($paged)) $paged = 1;
        if($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages)
            {
                $pages = 1;
            }
        }
        if(1 != $pages) {
            echo '<div class="ui small basic icon buttons">';
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo '<a href="' . esc_url(get_pagenum_link(1)) . '" class="ui button" data-bjax><i class="angle double left icon"></i></a>';
            if($paged > 1 && $showitems < $pages) echo '<a href="' . esc_url(get_pagenum_link($paged - 1)) . '" class="ui button" data-bjax><i class="angle left icon"></i></a>';
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages &&( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    echo ($paged == $i)? '<a href="#" class="ui active button">' . esc_html($i) . '</a>' : '<a href="' . esc_url(get_pagenum_link($i)) . '" class="ui button" data-bjax>' . esc_html($i) . '</a>';
                }
            }
            if ($paged < $pages && $showitems < $pages) echo '<a href="' . esc_url(get_pagenum_link($paged + 1)) . '" class="ui button" data-bjax><i class="angle right icon"></i></a>';
            if ($paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages) echo '<a href="' . esc_url(get_pagenum_link($pages)) . '" class="ui button" data-bjax><i class="angle double right icon"></i></a>';
            echo '</div>';
        }
    }
endif;
add_filter('option_posts_per_page', 'tdd_tax_filter_posts_per_page');
function tdd_tax_filter_posts_per_page( $value ) {
    if (is_tax('petition_category') || is_tax('petition_topics')) {
        $value = 1;
    }
return $value;
}
// COUNTRY LIST ARRAY FOR SEARCH
if( !function_exists('conikal_search_country_list') ): 
    function conikal_search_country_list($selected = '') {
    $countries = array("AF"=>"Afghanistan","AL"=>"Albania","DZ"=>"Algeria","AS"=>"American Samoa","AD"=>"Andorra","AO"=>"Angola","AI"=>"Anguilla","AQ"=>"Antarctica","AG"=>"Antigua and Barbuda","AR"=>"Argentina","AM"=>"Armenia","AW"=>"Aruba","AU"=>"Australia","AT"=>"Austria","AZ"=>"Azerbaijan","BS"=>"Bahamas","BH"=>"Bahrain","BD"=>"Bangladesh","BB"=>"Barbados","BY"=>"Belarus","BE"=>"Belgium","BZ"=>"Belize","BJ"=>"Benin","BM"=>"Bermuda","BT"=>"Bhutan","BO"=>"Bolivia","BA"=>"Bosnia and Herzegovina","BW"=>"Botswana","BV"=>"Bouvet Island","BR"=>"Brazil","BQ"=>"British Antarctic Territory","IO"=>"British Indian Ocean Territory","VG"=>"British Virgin Islands","BN"=>"Brunei","BG"=>"Bulgaria","BF"=>"Burkina Faso","BI"=>"Burundi","KH"=>"Cambodia","CM"=>"Cameroon","CA"=>"Canada","CT"=>"Canton and Enderbury Islands","CV"=>"Cape Verde","KY"=>"Cayman Islands","CF"=>"Central African Republic","TD"=>"Chad","CL"=>"Chile","CN"=>"China","CX"=>"Christmas Island","CC"=>"Cocos [Keeling] Islands","CO"=>"Colombia","KM"=>"Comoros","CG"=>"Congo - Brazzaville","CD"=>"Congo - Kinshasa","CK"=>"Cook Islands","CR"=>"Costa Rica","HR"=>"Croatia","CU"=>"Cuba","CY"=>"Cyprus","CZ"=>"Czech Republic","CI"=>"Côte d’Ivoire","DK"=>"Denmark","DJ"=>"Djibouti","DM"=>"Dominica","DO"=>"Dominican Republic","NQ"=>"Dronning Maud Land","DD"=>"East Germany","EC"=>"Ecuador","EG"=>"Egypt","SV"=>"El Salvador","GQ"=>"Equatorial Guinea","ER"=>"Eritrea","EE"=>"Estonia","ET"=>"Ethiopia","FK"=>"Falkland Islands","FO"=>"Faroe Islands","FJ"=>"Fiji","FI"=>"Finland","FR"=>"France","GF"=>"French Guiana","PF"=>"French Polynesia","TF"=>"French Southern Territories","FQ"=>"French Southern and Antarctic Territories","GA"=>"Gabon","GM"=>"Gambia","GE"=>"Georgia","DE"=>"Germany","GH"=>"Ghana","GI"=>"Gibraltar","GR"=>"Greece","GL"=>"Greenland","GD"=>"Grenada","GP"=>"Guadeloupe","GU"=>"Guam","GT"=>"Guatemala","GG"=>"Guernsey","GN"=>"Guinea","GW"=>"Guinea-Bissau","GY"=>"Guyana","HT"=>"Haiti","HM"=>"Heard Island and McDonald Islands","HN"=>"Honduras","HK"=>"Hong Kong SAR China","HU"=>"Hungary","IS"=>"Iceland","IN"=>"India","ID"=>"Indonesia","IR"=>"Iran","IQ"=>"Iraq","IE"=>"Ireland","IM"=>"Isle of Man","IL"=>"Israel","IT"=>"Italy","JM"=>"Jamaica","JP"=>"Japan","JE"=>"Jersey","JT"=>"Johnston Island","JO"=>"Jordan","KZ"=>"Kazakhstan","KE"=>"Kenya","KI"=>"Kiribati","KW"=>"Kuwait","KG"=>"Kyrgyzstan","LA"=>"Laos","LV"=>"Latvia","LB"=>"Lebanon","LS"=>"Lesotho","LR"=>"Liberia","LY"=>"Libya","LI"=>"Liechtenstein","LT"=>"Lithuania","LU"=>"Luxembourg","MO"=>"Macau SAR China","MK"=>"Macedonia","MG"=>"Madagascar","MW"=>"Malawi","MY"=>"Malaysia","MV"=>"Maldives","ML"=>"Mali","MT"=>"Malta","MH"=>"Marshall Islands","MQ"=>"Martinique","MR"=>"Mauritania","MU"=>"Mauritius","YT"=>"Mayotte","FX"=>"Metropolitan France","MX"=>"Mexico","FM"=>"Micronesia","MI"=>"Midway Islands","MD"=>"Moldova","MC"=>"Monaco","MN"=>"Mongolia","ME"=>"Montenegro","MS"=>"Montserrat","MA"=>"Morocco","MZ"=>"Mozambique","MM"=>"Myanmar [Burma]","NA"=>"Namibia","NR"=>"Nauru","NP"=>"Nepal","NL"=>"Netherlands","AN"=>"Netherlands Antilles","NT"=>"Neutral Zone","NC"=>"New Caledonia","NZ"=>"New Zealand","NI"=>"Nicaragua","NE"=>"Niger","NG"=>"Nigeria","NU"=>"Niue","NF"=>"Norfolk Island","KP"=>"North Korea","VD"=>"North Vietnam","MP"=>"Northern Mariana Islands","NO"=>"Norway","OM"=>"Oman","PC"=>"Pacific Islands Trust Territory","PK"=>"Pakistan","PW"=>"Palau","PS"=>"Palestinian Territories","PA"=>"Panama","PZ"=>"Panama Canal Zone","PG"=>"Papua New Guinea","PY"=>"Paraguay","YD"=>"People's Democratic Republic of Yemen","PE"=>"Peru","PH"=>"Philippines","PN"=>"Pitcairn Islands","PL"=>"Poland","PT"=>"Portugal","PR"=>"Puerto Rico","QA"=>"Qatar","RO"=>"Romania","RU"=>"Russia","RW"=>"Rwanda","RE"=>"Réunion","BL"=>"Saint Barthélemy","SH"=>"Saint Helena","KN"=>"Saint Kitts and Nevis","LC"=>"Saint Lucia","MF"=>"Saint Martin","PM"=>"Saint Pierre and Miquelon","VC"=>"Saint Vincent and the Grenadines","WS"=>"Samoa","SM"=>"San Marino","SA"=>"Saudi Arabia","SN"=>"Senegal","RS"=>"Serbia","CS"=>"Serbia and Montenegro","SC"=>"Seychelles","SL"=>"Sierra Leone","SG"=>"Singapore","SK"=>"Slovakia","SI"=>"Slovenia","SB"=>"Solomon Islands","SO"=>"Somalia","ZA"=>"South Africa","GS"=>"South Georgia and the South Sandwich Islands","KR"=>"South Korea","ES"=>"Spain","LK"=>"Sri Lanka","SD"=>"Sudan","SR"=>"Suriname","SJ"=>"Svalbard and Jan Mayen","SZ"=>"Swaziland","SE"=>"Sweden","CH"=>"Switzerland","SY"=>"Syria","ST"=>"São Tomé and Príncipe","TW"=>"Taiwan","TJ"=>"Tajikistan","TZ"=>"Tanzania","TH"=>"Thailand","TL"=>"Timor-Leste","TG"=>"Togo","TK"=>"Tokelau","TO"=>"Tonga","TT"=>"Trinidad and Tobago","TN"=>"Tunisia","TR"=>"Turkey","TM"=>"Turkmenistan","TC"=>"Turks and Caicos Islands","TV"=>"Tuvalu","UM"=>"U.S. Minor Outlying Islands","PU"=>"U.S. Miscellaneous Pacific Islands","VI"=>"U.S. Virgin Islands","UG"=>"Uganda","UA"=>"Ukraine","SU"=>"Union of Soviet Socialist Republics","AE"=>"United Arab Emirates","GB"=>"United Kingdom","US"=>"United States","ZZ"=>"Unknown or Invalid Region","UY"=>"Uruguay","UZ"=>"Uzbekistan","VU"=>"Vanuatu","VA"=>"Vatican City","VE"=>"Venezuela","VN"=>"Vietnam","WK"=>"Wake Island","WF"=>"Wallis and Futuna","EH"=>"Western Sahara","YE"=>"Yemen","ZM"=>"Zambia","ZW"=>"Zimbabwe","AX"=>"Åland Islands",);
    
        $country_select = '<select id="search_country" name="search_country" class="ui search dropdown">';
        if ($selected == '') {
            $conikal_general_settings = get_option('conikal_general_settings');
            $selected = isset($conikal_general_settings['conikal_country_field']) ? $conikal_general_settings['conikal_country_field'] : '';
        } elseif ($selected == 'all') {
            $country_select .= '<option value="">' . esc_html('Select Country', 'petition') . '</option>';
        }
        foreach ($countries as $code => $country) {
            $country_select .= '<option value="' . esc_attr($code) . '"';
            if ($selected == $code) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }
        $country_select.='</select>';
        return $country_select;
    }
endif;
// ENTRY META
if (!function_exists('conikal_entry_meta')) :
    function conikal_entry_meta() {
        if ( is_sticky() && is_home() && ! is_paged() )
            echo '<span class="featured-post">' . __( 'Sticky', 'petition') . '</span>';
        if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
            conikal_entry_date();
        $categories_list = get_the_category_list( __( ', ', 'petition') );
        if ( $categories_list ) {
            echo '<span class="categories-links">' . esc_html($categories_list) . '</span>';
        }
        $tag_list = get_the_tag_list( '', __( ', ', 'petition') );
        if ( $tag_list ) {
            echo '<span class="tags-links">' . esc_html($tag_list) . '</span>';
        }
        if ( 'post' == get_post_type() ) {
            printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'petition'), get_the_author() ) ),
                get_the_author()
            );
        }
    }
endif;
// ENTRY DATE
if (!function_exists('conikal_entry_date')) :
    function conikal_entry_date( $echo = true ) {
        if ( has_post_format( array( 'chat', 'status' ) ) )
            $format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'petition');
        else
            $format_prefix = '%2$s';
        $date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
            esc_url( get_permalink() ),
            esc_attr( sprintf( __( 'Permalink to %s', 'petition'), the_title_attribute( 'echo=0' ) ) ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
        );
        if ( $echo )
            echo esc_html($date);
        return $date;
    }
endif;
// CULCULATE AGE FROM BIRTHDAY
if (!function_exists('conikal_get_age')) :
    function conikal_get_age($birthdate) {
        if ($birthdate) {
            $bits = explode('/', $birthdate);
            $age = date('Y') - $bits[2] - 1;
         
            $arr[0] = 'm';
            $arr[1] = 'd';
         
            for ($i = 0; $i < 2; $i++) {
                $n = date($arr[$i]);
                if ($n < $bits[$i])
                    break;
                if ($n > $bits[$i]) {
                    ++$age;
                    break;
                }
            }
        } else {
            $age = false;
        }
        return $age;
    }
endif;
if (!function_exists('conikal_wp_title')) :
    function conikal_wp_title( $title, $sep ) {
        global $page, $paged;
        $title .= get_bloginfo( 'name', 'display' );
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() || is_archive() || is_search() ) ) {
            $title .= " $sep $site_description";
        }
        return $title;
    }
endif;
add_filter( 'wp_title', 'conikal_wp_title', 10, 2 );
if (!function_exists('conikal_sanitize_item')) :
    function conikal_sanitize_item($item) {
        return sanitize_text_field($item);
    }
endif;
if (!function_exists('conikal_sanitize_multi_array')) :
    function conikal_sanitize_multi_array(&$item, $key) {
        $item = sanitize_text_field($item);
    }
endif;
// BREADCRUMBS SHOW
if (!function_exists('conikal_petition_breadcrumbs')) :
    function conikal_petition_breadcrumbs() {
        global $post;
        if (!is_front_page()) {
            echo '<div class="ui breadcrumb">';
            echo '<a class="section" href="' . esc_url( home_url() ) . '" data-bjax><i class="home icon"></i>' . esc_html(__('Home','petition')) . '</a>';
            echo '<i class="right angle icon divider"></i>';
            if (is_home()) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Blog','petition') . '</a>';
            }
            if (is_single()) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Blog','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                $category = get_the_category($post->ID);
                echo esc_html($category[0]->name);
            } elseif (is_page()) {
                the_title();
            } elseif (is_author()) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('User','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                echo _e('Profile', 'petition');
            } elseif (is_category()) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Category','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                single_cat_title();
            } elseif (is_tag()) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Tag','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                single_tag_title();
            } elseif (is_tax('petition_topics')) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Topics','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                single_term_title();
            } elseif (is_tax('petition_category')) {
                echo '<a class="section" href="#" data-bjax>' . esc_html('Category','petition') . '</a>';
                echo '<i class="right angle icon divider"></i>';
                single_term_title();
            }
            echo '</div>';
        }
    }
endif;
// CUSTOM MENU
function conikal_custom_menu( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
 
        $menu_list = '';
        $bool = false;
         
        foreach( $menu_items as $menu_item ) {
            if( $menu_item->menu_item_parent == 0 ) {
                 
                $parent = $menu_item->ID;
                $menu_level_2 = array();
                foreach( $menu_items as $submenu_2 ) {
                    if( $submenu_2->menu_item_parent == $parent ) {
                        $bool = true;
                        $menu_level_2[] = $submenu_2;
                    }
                }
                //menu level 2
                if( $bool == true && count( $menu_level_2 ) > 0 ) {
                    $menu_list .= '<div class="ui dropdown item nav-submenu">' ."\n";
                    $menu_list .= '<a class="text" href="' . $menu_item->url . '" data-bjax>' . $menu_item->title . '</a>' ."\n";
                    $menu_list .= '<i class="dropdown icon"></i>' ."\n";
                    $menu_list .= '<div class="menu">' ."\n";
                    foreach ($menu_level_2 as $item_2) {
                        $menu_level_3 = array();
                        $submenu_parent = $item_2->ID;
                        $menu_list .= '<div class="item">' ."\n";
                        
                        // start menu level 3
                        foreach( $menu_items as $submenu_3 ) {
                            if( $submenu_3->menu_item_parent == $submenu_parent ) {
                                $bool = true;
                                $menu_level_3[] = $submenu_3;
                            }
                        }
                        if( $bool == true && count( $menu_level_3 ) > 0 ) {
                            $menu_list .= '<i class="dropdown icon"></i>' ."\n";
                            $menu_list .= '<a class="text" href="' . $item_2->url . '" data-bjax>' . $item_2->title . '</a>' ."\n";
                            $menu_list .= '<div class="menu">' ."\n";
                            foreach ($menu_level_3 as $item_3) {
                                $menu_list .= '<div class="item">' ."\n";
                                $menu_list .= '<a href="' . $item_3->url . '" data-bjax>' . $item_3->title . '</a>' . "\n";
                                $menu_list .= '</div>' ."\n";
                            }
                            $menu_list .= '</div>' ."\n";
                        } else {
                            $menu_list .= '<a href="' . $item_2->url . '" data-bjax>' . $item_2->title . '</a>' . "\n";
                        }
                        // end menu level 3
                        $menu_list .= '</div>' ."\n";
                    }
                    $menu_list .= '</div>' ."\n";
                    $menu_list .= '</div>' ."\n";
                } else {
                    $menu_list .= '<a class="item" href="' . $menu_item->url . '" data-bjax>' . $menu_item->title . '</a>' ."\n";
                }
                 
            }
             
        }
 
    } else {
        $bool = false;
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}
function conikal_custom_menu_mobile( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
 
        $menu_list = '';
        $bool = false;
         
        foreach( $menu_items as $menu_item ) {
            if( $menu_item->menu_item_parent == 0 ) {
                 
                $parent = $menu_item->ID;
                $menu_level_2 = array();
                foreach( $menu_items as $submenu_2 ) {
                    if( $submenu_2->menu_item_parent == $parent ) {
                        $bool = true;
                        $menu_level_2[] = $submenu_2;
                    }
                }
                //menu level 2
                if( $bool == true && count( $menu_level_2 ) > 0 ) {
                    $menu_list .= '<div class="ui vertical fluid accordion menu mobile-menu-item">' ."\n";
                    $menu_list .= '<div class="item">' ."\n";
                    $menu_list .= '<div class="title">' . $menu_item->title . '<i class="dropdown icon"></i></div>' ."\n";
                    $menu_list .= '<div class="content">' ."\n";
                    foreach ($menu_level_2 as $item_2) {
                        $menu_level_3 = array();
                        $submenu_parent = $item_2->ID;
                        
                        // start menu level 3
                        foreach( $menu_items as $submenu_3 ) {
                            if( $submenu_3->menu_item_parent == $submenu_parent ) {
                                $bool = true;
                                $menu_level_3[] = $submenu_3;
                            }
                        }
                        if( $bool == true && count( $menu_level_3 ) > 0 ) {
                            $menu_list .= '<div class="accordion menu mobile-menu-item mobile-submenu">' ."\n";
                            $menu_list .= '<div class="item mobile-submenu-item">' ."\n";
                            $menu_list .= '<div class="title">' . $item_2->title . '<i class="dropdown icon"></i></div>' ."\n";
                            $menu_list .= '<div class="content">' ."\n";
                            foreach ($menu_level_3 as $item_3) {
                                $menu_list .= '<div class="item">' ."\n";
                                $menu_list .= '<a href="' . $item_3->url . '" data-bjax>' . $item_3->title . '</a>' . "\n";
                                $menu_list .= '</div>' ."\n";
                            }
                            $menu_list .= '</div>' ."\n";
                            $menu_list .= '</div>' ."\n";
                            $menu_list .= '</div>' ."\n";
                        } else {
                            $menu_list .= '<a class="item" href="' . $item_2->url . '" data-bjax>' . $item_2->title . '</a>' . "\n";
                        }
                        // end menu level 3
                    }
                    $menu_list .= '</div>' ."\n";
                    $menu_list .= '</div>' ."\n";
                    $menu_list .= '</div>' ."\n";
                } else {
                    $menu_list .= '<a class="item" href="' . $menu_item->url . '" data-bjax>' . $menu_item->title . '</a>' ."\n";
                }
                 
            }
             
        }
 
    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}
// DISPLAY NAVIGATION TO NEXT/PREVIOUS COMMENTS
if ( ! function_exists( 'conikal_comment_nav' ) ) :
function conikal_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    ?>
    <nav class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php _e('Comment navigation', 'petition'); ?></h2>
        <div class="nav-links">
            <?php
                if ( $prev_link = get_previous_comments_link( __('Older Comments', 'petition') ) ) :
                    printf( '<div class="nav-previous">%s</div>', $prev_link );
                endif;
                if ( $next_link = get_next_comments_link( __('Newer Comments', 'petition') ) ) :
                    printf( '<div class="nav-next">%s</div>', $next_link );
                endif;
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .comment-navigation -->
    <?php
    endif;
}
endif;
// CUSTOM COMMENTS LIST
function conikal_comment_callback($comment, $args, $depth) {
    if ( 'li' === $args['style'] ) {
        $tag       = 'li';
        $add_below = 'comment';
    } else {
        $tag       = 'div';
        $add_below = 'div-comment';
    }
    $author_data   = get_user_by('email', get_comment_author_email());
    if ($author_data) {
        $author_name    = $author_data->display_name;
    } else {
        $author_name    = get_comment_author();
    }
    $author_avatar = get_user_meta($author_data->ID, 'avatar', true);
    if (!$author_avatar) {
        $author_avatar = get_template_directory_uri().'/images/avatar.svg';
    }
    $votes = get_comment_meta(get_comment_ID(), 'comment_vote', true);
    ?>
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="comment-<?php comment_ID() ?>" class="comment">
    <?php endif; ?>
        <a href="<?php echo get_comment_author_url() ?>" class="avatar" data-bjax>
            <img class="ui bordered image" src="<?php echo conikal_get_avatar_url( get_comment_author_email(), array('size' => 35, 'default' => $author_avatar) ) ?>" alt="<?php echo get_comment_author() ?>" />
        </a>
        <div class="content">
            <a class="author" href="<?php echo comment_author_url() ?>" data-bjax><?php echo esc_html($author_name) ?></a>
            <div class="metadata">
                <div class="date">
                    <?php echo human_time_diff(strtotime(get_comment_date(), current_time('timestamp')), current_time('timestamp')) . __(' ago', 'petition'); ?>
                </div>
                <div class="date"> · </div>
                <div class="rating">
                    <?php echo '<span id="vote-num-' . get_comment_ID() . '">' . esc_html(count($votes)) . '</span> ' . __('like', 'petition'); ?>
                </div>
            </div>
            <div class="text" id="comment-content-<?php comment_ID() ?>">
                <?php comment_text(); ?>
            </div>
            <div class="actions">
                <?php if (is_array($votes) && in_array(get_current_user_id(), $votes)) { ?>
                    <a href="javascript:void(0)" class="vote down" id="vote-<?php echo esc_attr(get_comment_ID()) ?>" data-author="<?php echo esc_attr(comment_author()) ?>" data-id="<?php echo esc_attr(get_comment_ID()) ?>"><i class="thumbs down icon"></i><?php esc_html_e('Unlike', 'petition') ?></a>
                <?php } else { ?>
                    <a href="javascript:void(0)" class="vote up" id="vote-<?php echo esc_attr(get_comment_ID()) ?>" data-author="<?php echo esc_attr(comment_author()) ?>" data-id="<?php echo esc_attr(get_comment_ID()) ?>"><i class="thumbs up icon"></i><?php esc_html_e('Like', 'petition') ?></a>
                <?php } 
                    if ( is_user_logged_in() ) { ?>
                    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'reply_text' => '<i class="reply icon"></i>' . esc_html('Reply', 'petition'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                <?php if ( ($comment->user_id == get_current_user_id()) || current_user_can('administrator') ) { ?>
                    <a href="javascript:void(0)" class="edit" id="edit-<?php echo esc_attr(get_comment_ID()) ?>" data-author="<?php echo esc_attr(comment_author()) ?>" data-id="<?php echo esc_attr(get_comment_ID()) ?>"><i class="pencil icon"></i><?php esc_html_e('Edit', 'petition') ?></a>
                    <a href="javascript:void(0)" class="delete" id="delete-<?php echo esc_attr(get_comment_ID()) ?>" data-author="<?php echo esc_attr(comment_author()) ?>" data-id="<?php echo esc_attr(get_comment_ID()) ?>"><i class="delete icon"></i><?php esc_html_e('Delete', 'petition') ?></a>
                <?php }
                    }
                 ?>
            </div>
        </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'petition'); ?></em>
          <br />
    <?php endif; ?>
    </div>
    <?php
}
// CUSTOM IMAGE SIZE
add_action( 'after_setup_theme', 'petition_custom_images_size' );
function petition_custom_images_size() {
    add_image_size( 'petition-thumbnail', 300, 225, true );
    add_image_size( 'petition-medium', 550, 310, true );
    add_image_size( 'petition-small', 170, 95, true );
    add_image_size( 'petition-avatar', 35, 35, true );
}
// GET MEDIUM VIDEO THUMBNAIL
if( !function_exists('conikal_video_thumbnail') ):
    function conikal_video_thumbnail($thumb) {
        if (strpos($thumb, 'maxresdefault') !== false) {
            $thumb = str_replace('maxresdefault', 'hqdefault', $thumb);
        } else {
            $thumb = str_replace('_640.jpg', '_200x150.jpg', $thumb);
        }
        
        return $thumb;
        die();
    }
endif;
// LOAD MORE POST
if( !function_exists('conikal_load_posts') ): 
    function conikal_load_posts() {
        check_ajax_referer('load_posts_ajax_nonce', 'security');
        $conikal_appearance_settings = get_option('conikal_appearance_settings');
        $posts_per_page = get_option('posts_per_page');
        $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';
        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 2;
        $args = array(
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'post_type' => 'post',
            'post_status' => 'publish',
        );
        $postslist = new WP_Query($args);
        wp_reset_query();
        wp_reset_postdata();
        $arrayPosts = array();
        if($postslist->have_posts()) {
            while ( $postslist->have_posts() ) {
                $postslist->the_post();
                $p_id = get_the_ID();
                $p_link = get_permalink($p_id);
                $p_title = get_the_title($p_id);
                $p_comments = wp_count_comments($p_id);
                $p_image = wp_get_attachment_image_src( get_post_thumbnail_id( $p_id ), 'petition-thumbnail' );
                $p_excerpt = conikal_get_excerpt_by_id($p_id);
                $p_author = get_the_author($p_id);
                $p_categories = get_the_category($p_id);
                $p_date = get_the_date();
                $author_link = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
                if (has_post_thumbnail()) {
                    $thumbnail = $p_image[0];
                } else {
                    $thumbnail = get_template_directory_uri() . '/images/thumbnail.svg';
                }
                $arrayPost = array(
                        'id' => $p_id, 
                        'link' => $p_link,
                        'title' => $p_title,
                        'date' => $p_date,
                        'category_name' => $p_categories[0]->name,
                        'category_link' => get_category_link($p_categories[0]->term_id),
                        'excerpt' => $p_excerpt,
                        'comments' => $p_comments->approved,
                        'author_name' => $p_author,
                        'author_link' => $author_link,
                        'thumbnail' => $thumbnail
                    );
                $arrayPost = (object) $arrayPost;
                array_push($arrayPosts, $arrayPost);
            }
        }
        if ($arrayPosts) {
            echo json_encode(array('status' => true, 'found_posts' => count($arrayPosts), 'total' => $postslist->found_posts, 'per_page' => $posts_per_page, 'posts' => $arrayPosts, 'message' => __('Petitions was loaded successfully.', 'petition')));
            exit();
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found petitions.', 'petition')));
            exit();
        }
        die();
    }
endif;
add_action( 'wp_ajax_nopriv_conikal_load_posts', 'conikal_load_posts' );
add_action( 'wp_ajax_conikal_load_posts', 'conikal_load_posts' );
// FORMAT AND COMPACT NUMBER
if (!function_exists('conikal_format_number')) :
    function conikal_format_number($format, $number, $round = false) {
        if ($round == true) {
            $strnum = strlen($number);
            if ($strnum > 3 && $strnum < 7) {
                $number = $number / 1000;
                $number = round($number, 1);
                $number = $number . __('K', 'petition');
            } elseif ($strnum > 6 && $strnum < 10) {
                $number = $number / 1000000;
                $number = round($number, 2);
                $number = $number . __('M', 'petition');
            } elseif ($strnum > 9 && $strnum < 13) {
                $number = $number / 1000000000;
                $number = round($number, 3);
                $number = $number . __('B', 'petition');
            } elseif ($strnum > 12 && $strnum < 16) {
                $number = $number / 1000000000000;
                $number = round($number, 4);
                $number = $number . __('T', 'petition');
            } else {
                $number = $number;
            }
        }
        while (true) { 
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
            if ($replaced != $number) { 
                $number = $replaced; 
            } else { 
                break; 
            } 
        } 
        return $number; 
    }
endif;
// CONVERT HEXA DECIMAL COLOR CODE TO RGB EQUIVALENT    
if (!function_exists('conikal_hex_rbg')) :                                                                                  
    function conikal_hex_rbg($hexStr, $returnAsString = false, $seperator = ',') {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
endif;
// USER'S BROWSER DETECTION
if (!function_exists('conikal_get_browser_name')) :      
    function conikal_get_browser_name() {   
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
        elseif (strpos($user_agent, 'Edge')) return 'edge';
        elseif (strpos($user_agent, 'Chrome')) return 'chrome';
        elseif (strpos($user_agent, 'Safari')) return 'safari';
        elseif (strpos($user_agent, 'Firefox')) return 'firefox';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'trident/7')) return 'Internet Explorer';
        
        return 'other';
    }
endif;
// CONVERT ARRAY TO CSV FILE
if (!function_exists('conikal_convert_to_csv')) :    
    function conikal_convert_to_csv($input_array, $output_file_name, $delimiter) {
        // modify the header to be CSV format
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        // output the file to be downloaded
        $output = '';
        foreach ($input_array as $line) {
            // use the default csv handler
            foreach ($line as $value) {
               $output .= $value . $delimiter;
            }
            $output .= "\n";
        }
        print_r($output);
    }
endif;
// CHECK GRAVATAR EXIST OR NOT
if (!function_exists('conikal_validate_gravatar')) :    
    function conikal_validate_gravatar($id_or_email) {
      //id or email code borrowed from wp-includes/pluggable.php
        $email = '';
        if ( is_numeric($id_or_email) ) {
            $id = (int) $id_or_email;
            $user = get_userdata($id);
            if ( $user )
                $email = $user->user_email;
        } elseif ( is_object($id_or_email) ) {
            // No avatar for pingbacks or trackbacks
            $allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
            if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
                return false;
            if ( !empty($id_or_email->user_id) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_userdata($id);
                if ( $user)
                    $email = $user->user_email;
            } elseif ( !empty($id_or_email->comment_author_email) ) {
                $email = $id_or_email->comment_author_email;
            }
        } else {
            $email = $id_or_email;
        }
        $hashkey = md5(strtolower(trim($email)));
        $uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';
        $data = wp_cache_get($hashkey);
        if (false === $data) {
            $response = wp_remote_head($uri);
            if( is_wp_error($response) ) {
                $data = 'not200';
            } else {
                $data = $response['response']['code'];
            }
            wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);
        }       
        if ($data == '200'){
            return true;
        } else {
            return false;
        }
    }
endif;
// GET AVARTAR FROM GRAVATAR OR USE DEFAULT AVATAR
if (!function_exists('conikal_get_avatar_url')) :    
    function conikal_get_avatar_url($id_or_email, $args) {
        $gravatar = conikal_validate_gravatar($id_or_email);
        $avatar = get_avatar_url( $id_or_email, array('size' => $args['size']) );
        if ($gravatar) {
            $results = $avatar;
        } else {
            $results = $args['default'];
        }
        return $results;
    }
endif;
function hide_admin_bar_from_front_end(){
  if (is_blog_admin()) {
    return true;
  }
  return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );

//VALIDATE UIC CODE
if(!function_exists('validate_uic')) :
    function validate_uic($uic) {
        global $wpdb;
        $result = $wpdb->get_results( "select * from $wpdb->postmeta where meta_key = 'petition_uic' AND meta_value = '$uic'" );
        if ( ! empty( $result ) ) {
         return true;
        }
        return false;
    }
endif;
add_filter( 'validate_uic', 'validate_uic' );
// GET PETITION SEARCH RESULT FORMATED DATA
if(!function_exists('get_petition_search_result')) :
    function get_petition_search_result($petition_uic_post) {
        $id = $petition_uic_post->ID;
        $link = get_permalink($id);
        $title = get_the_title($id);
        $category =  wp_get_post_terms($id, 'petition_category', true);
        $excerpt = conikal_get_excerpt_by_id($id);
        $comments = wp_count_comments($id);
        $comments_fomated = conikal_format_number('%!,0i', $comments->approved, true);
        $gallery = get_post_meta($id, 'petition_gallery', true);
        $images = explode("~~~", $gallery);
        $address = get_post_meta($id, 'petition_address', true);
        $city = get_post_meta($id, 'petition_city', true);
        $state = get_post_meta($id, 'petition_state', true);
        $neighborhood = get_post_meta($id, 'petition_neighborhood', true);
        $zip = get_post_meta($id, 'petition_zip', true);
        $country = get_post_meta($id, 'petition_country', true);
        $lat = get_post_meta($id, 'petition_lat', true);
        $lng = get_post_meta($id, 'petition_lng', true);
        $receiver = get_post_meta($id, 'petition_receiver', true);
        $receiver = explode(',', $receiver);
        $position = get_post_meta($id, 'petition_position', true);
        $position = explode(',', $position);
        $goal = get_post_meta($id, 'petition_goal', true);
        $sign = get_post_meta($id, 'petition_sign', true);
        $sign_fomated = conikal_format_number('%!,0i', $sign);
        $sign_compact = conikal_format_number('%!,0i', $sign, true);
        $updates = get_post_meta($id, 'petition_update', true);
        $thumb = get_post_meta($id, 'petition_thumb', true);
        $thumb = conikal_video_thumbnail($thumb);
        $status = get_post_meta($id, 'petition_status', true);
        $petition_uic = get_post_meta($id, 'petition_uic', true);
        $author_link = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
        $user_avatar = get_the_author_meta('avatar' , get_the_author_meta('ID'));
        if($user_avatar != '') {
            $avatar = $user_avatar;
        } else {
            $avatar = get_template_directory_uri().'/images/avatar.svg';
        }
        $avatar = conikal_get_avatar_url( get_the_author_meta('ID'), array('size' => 28, 'default' => $avatar) );
        if(has_post_thumbnail()) {
            $thumb_id = get_post_thumbnail_id();
            $thumbnail = wp_get_attachment_image_src($thumb_id, 'petition-thumbnail', true);
            $thumbnail = $thumbnail[0];
        } elseif ($gallery) {
            $thumbnail = $images[1];
        } elseif ($thumb) {
            $thumbnail = $thumb;
        } else {
            $thumbnail = get_template_directory_uri() . '/images/thumbnail.svg';
        }
        $arrayPetition = array(
                'id' => $id, 
                'link' => $link,
                'title' => $title,
                'category_name' => $category[0]->name,
                'category_link' => get_category_link($category[0]->term_id),
                'excerpt' => $excerpt,
                'comments' => $comments->approved,
                'comments_fomated' => $comments_fomated,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'neighborhood' => $neighborhood,
                'zip' => $zip,
                'country' => $country,
                'lat' => $lat,
                'lng' => $lng,
                'receiver' => $receiver[0],
                'position' => $position[0],
                'goal' => $goal,
                'updates' => $updates,
                'thumbnail' => $thumbnail,
                'status' => $status,
                'author_avatar' => $avatar,
                'author_name' => get_the_author(),
                'author_link' => $author_link,
                'sign' => $sign,
                'sign_fomated' => $sign_fomated,
                'sign_compact' => $sign_compact . __(' supporters', 'petition'),
                'petition_uic' => $petition_uic
            );
        return $arrayPetition;
    }
endif;
add_action('get_petition_search_result', 'get_petition_search_result');
?>