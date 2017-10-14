<?php



/*
* Plugin Name: Petition Plugin
* Description: Creates shortcodes, register custom taxonomies and post types
* Version: 1.6.3
* Author: Conikal
* Author URI: https://www.conikal.com
*/

add_action( 'plugins_loaded', 'conikal_load_textdomain' );
function conikal_load_textdomain() {
    load_plugin_textdomain( 'petition', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

require_once 'social_meta.php';
require_once 'shortcodes.php';


/**
 *****************************************************************************
 * Custom post types
 *****************************************************************************
 */

/**
 * Register petition custom post type
 */
if( !function_exists('conikal_register_petition_type_init') ): 
    function conikal_register_petition_type_init() {
        wp_enqueue_style('conikal_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        $conikal_auth_settings = get_option('conikal_auth_settings','');
        $gmaps_key = (isset($conikal_auth_settings['conikal_gmaps_key_field']) && $conikal_auth_settings['conikal_gmaps_key_field'] !='') ? $conikal_auth_settings['conikal_gmaps_key_field'] : 'AIzaSyAUYuX_iOuWgl5b5gSdmaL1QeLgbmxbBnU';
        wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key='.$gmaps_key.'&amp;libraries=geometry&amp;libraries=places&amp;language='.get_locale(),array('jquery'), '1.0', true);
        wp_enqueue_script('petition', plugins_url( '/js/petition.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('petition', 'petition_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'plugins_url' => plugins_url( '/images/', __FILE__ ),
                  'browse_text' => __('Browse...', 'petition'),
                  'delete_photo' => __('Delete', 'petition')
            )
        );
    }
endif;
add_action('init', 'conikal_register_petition_type_init');

if( !function_exists('conikal_register_petition_type') ): 
    function conikal_register_petition_type() {
        register_post_type('petition', array(
            'labels' => array(
                'name'                  => __('Petitions', 'petition'),
                'singular_name'         => __('Petition', 'petition'),
                'add_new'               => __('Add New Petition', 'petition'),
                'add_new_item'          => __('Add Petition', 'petition'),
                'edit'                  => __('Edit', 'petition'),
                'edit_item'             => __('Edit Petition', 'petition'),
                'new_item'              => __('New Petition', 'petition'),
                'view'                  => __('View', 'petition'),
                'view_item'             => __('View Petition', 'petition'),
                'search_items'          => __('Search Petition', 'petition'),
                'not_found'             => __('No Petition found', 'petition'),
                'not_found_in_trash'    => __('No Petition found in Trash', 'petition'),
                'parent'                => __('Parent Petition', 'petition'),
            ),
            'public'                => true,
            'exclude_from_search '  => false,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'petition'),
            'supports'              => array('title', 'author', 'editor', 'thumbnail', 'comments'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'conikal_add_petition_metaboxes',
            'menu_icon'             => plugins_url( '/images/petition-icon.png', __FILE__ )
        ));

        // add petition category custom taxonomy
        register_taxonomy('petition_category', 'petition', array(
            'labels' => array(
                'name'              => __('Petition Categories', 'petition'),
                'add_new_item'      => __('Add New Petition Category', 'petition'),
                'new_item_name'     => __('New Petition Category', 'petition')
            ),
            'public'        => true,
            'show_ui'       => true,
            'hierarchical'  => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'cats')
        ));

        register_meta( 'petition_category', 'petition_category_image', array(
            'description' => 'The background image show on category archive and shortcodes',
            'single' => true,
            'show_in_rest' => true,
        ));


        // add petition type custom taxonomy
        register_taxonomy('petition_topics', 'petition', array(
            'labels' => array(
                'name'              => __('Petition Topics', 'petition'),
                'add_new_item'      => __('Add New Petition Topics', 'petition'),
                'new_item_name'     => __('New Petition Topics', 'petition')
            ),
            'public'        => true,
            'show_ui'       => true,
            'hierarchical'  => false,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'topics')
        ));
    }
endif;
add_action('init', 'conikal_register_petition_type');

if( !function_exists('conikal_insert_default_terms') ): 
    function conikal_insert_default_terms() {
        conikal_register_petition_type();
        wp_insert_term('Environment', 'petition_category', $args = array());
        wp_insert_term('Technology', 'petition_category', $args = array());
        wp_insert_term('Education', 'petition_category', $args = array());
        wp_insert_term('Human rights', 'petition_topics', $args = array());
        wp_insert_term('Disabled rights', 'petition_topics', $args = array());
    }
endif;
register_activation_hook( __FILE__, 'conikal_insert_default_terms' );

/**
 * Add petition post type metaboxes
 */
if( !function_exists('conikal_add_petition_metaboxes') ): 
    function conikal_add_petition_metaboxes() {
        add_meta_box('petition-location-section', __('Location', 'petition'), 'conikal_petition_location_render', 'petition', 'normal', 'default');
        add_meta_box('petition-details-section', __('Details', 'petition'), 'conikal_petition_details_render', 'petition', 'normal', 'default');
        add_meta_box('petition-letter-section', __('Letter', 'petition'), 'conikal_petition_letter_render', 'petition', 'normal', 'default');
        add_meta_box('petition-update-section', __('Update', 'petition'), 'conikal_petition_update_render', 'petition', 'normal', 'default');
        add_meta_box('petition-video-section', __('Video', 'petition'), 'conikal_petition_video_render', 'petition', 'normal', 'default');
        add_meta_box('petition-gallery-section', __('Photo Gallery', 'petition'), 'conikal_petition_gallery_render', 'petition', 'normal', 'default');
        add_meta_box('petition-featured-section', __('Featured', 'petition'), 'conikal_petition_featured_render', 'petition', 'side', 'default');
        add_meta_box('petition-victory-section', __('Victory Featured', 'petition'), 'conikal_petition_victory_render', 'petition', 'side', 'default');
    }
endif;

if( !function_exists('conikal_petition_location_render') ): 
    function conikal_petition_location_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_city">' . __('City', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_city" name="petition_city" placeholder="' . __('Enter a city name', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_city', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_lat">' . __('Latitude', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_lat" name="petition_lat" value="' . esc_attr(get_post_meta($post->ID, 'petition_lat', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_lng">' . __('Longitude', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_lng" name="petition_lng" value="' . esc_attr(get_post_meta($post->ID, 'petition_lng', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div id="propMapView"></div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_address">' . __('Address', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_address" name="petition_address" placeholder="' . __('Enter address', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_address', true)) . '" />
                            <input id="placePinBtn" type="button" class="button" value="' . __('Place pin by address', 'petition') . '">
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_state">' . __('County/State', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_state" name="petition_state" placeholder="' . __('Enter county/state', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_state', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_state">' . __('Neighborhood', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_neighborhood" name="petition_neighborhood" placeholder="' . __('Enter neighborhood', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_neighborhood', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_zip">' . __('Zip Code', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_zip" name="petition_zip" placeholder="' . __('Enter zip code', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_zip', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_country">' . __('Country', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_zip" name="petition_country" placeholder="' . __('Enter county', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_country', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_details_render') ): 
    function conikal_petition_details_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');
        $conikal_general_settings = get_option('conikal_general_settings');

        $goal = (esc_html(get_post_meta($post->ID, 'petition_goal', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_goal', true)) : 0;
        $sign = (esc_html(get_post_meta($post->ID, 'petition_sign', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_sign', true)) : 0;
        $sendinblue_list = (esc_html(get_post_meta($post->ID, 'petition_sendinblue_list', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_sendinblue_list', true)) : '';
        $decisionmakers = (esc_html(get_post_meta($post->ID, 'petition_decisionmakers', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_decisionmakers', true)) : '';
        $receiver = (esc_html(get_post_meta($post->ID, 'petition_receiver', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_receiver', true)) : '';
        $position = (esc_html(get_post_meta($post->ID, 'petition_position', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_position', true)) : '';

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_goal">' . __('Goal', 'petition') . '</label><br />
                            <input type="number" class="formInput" id="petition_goal" name="petition_goal" value="' . esc_attr($goal) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_sign">' . __('Signature', 'petition') . '</label><br />
                            <input type="number" class="formInput" id="petition_sign" name="petition_sign" value="' . esc_attr($sign) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_sendinblue_list">' . __('SendinBlue List ID', 'petition') . '</label><br />
                            <input type="number" class="formInput" id="petition_sendinblue_list" name="petition_sendinblue_list" value="' . esc_attr($sendinblue_list) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_receiver">' . __('Receivers (Separated by commas)', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_receiver" name="petition_receiver" placeholder="' . __('Enter Receiver', 'petition') . '" value="' . esc_attr($receiver) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_position">' . __('Positions (Separated by commas)', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_position" name="petition_position" placeholder="' . __('Enter Positions', 'petition') . '" value="' . esc_attr($position) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_decisionmakers">' . __('Decision makers (ID and Separated by commas)', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_decisionmakers" name="petition_decisionmakers" value="' . esc_attr($decisionmakers) . '" />
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_letter_render') ): 
    function conikal_petition_letter_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');
        $conikal_general_settings = get_option('conikal_general_settings');
        $letter = (esc_html(get_post_meta($post->ID, 'petition_letter', true)) != '') ? esc_html(get_post_meta($post->ID, 'petition_letter', true)) : '';

        print '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div class="adminField">
                            <textarea rows="6" class="formInput" id="petition_letter" name="petition_letter">' . esc_attr($letter) . '</textarea>
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_update_render') ): 
    function conikal_petition_update_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');
        $mypost = $post->ID;
        $originalpost = $post;
        $update_list = '';

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'update',
            'post_status' => 'publish'
        );

        $args['meta_query'] = array('relation' => 'AND');

        if($mypost != '') {
            array_push($args['meta_query'], array(
                'key'     => 'update_post_id',
                'value'   => $mypost,
            ));
        }

        $query = new WP_Query($args);

        $updates = new WP_Query($args);

        while($updates->have_posts()) {
            $updates->the_post();
            $update_id = get_the_ID();
            $author_id = $updates->post_author;
            $status = get_post_status($update_id);
            $link = get_edit_post_link($update_id);
            $title = get_the_title($update_id);
            $excerpt = conikal_get_excerpt_by_id($update_id);
            $date = get_the_date('Y/m/d', $update_id);
            $petition_id =  get_post_meta($update_id, 'update_post_id', true);
            $media = get_post_meta($update_id, 'petition_media', true);
            $gallery = get_post_meta($update_id, 'petition_gallery', true);
            $images = explode("~~~", $gallery);
            $thumb_id = get_post_thumbnail_id($update_id);
            $thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
            $thumb_video = get_post_meta($mypost, 'petition_thumb', true);
            $comments = wp_count_comments($update_id);
            $views = conikal_get_post_views($update_id);


            $update_list .= '<tr id="post-' . esc_html($update_id) . '" class="iedit author-self level-0 post-' . esc_html($update_id) . ' type-update status-publish hentry">';
            $update_list .= '<th class="title column-title has-row-actions column-primary page-title"><strong><a class="row-title" href="' . esc_url($link) . '">' . esc_html($title) . '</a></strong></th>';
            $update_list .= '<th width="50px" class="comments column-comments">' . ($comments->approved ? '<div class="post-com-count-wrapper"><span class="post-com-count post-com-count-approved" href="' . esc_url($link) . '"><span class="comment-count-approved">' . esc_html($comments->approved) . '</span></span></div>' : '—') . '</th>';
            $update_list .= '<th class="date column-date">' . esc_html($status) . '<br/><abbr title="' . esc_html($date) .  '">' . esc_html($date) . '</abbr></th>';
            $update_list .= '<th class="view column-view">' . esc_html($views) . '</th>';
            $update_list .= '</tr>';
        }

        wp_reset_postdata();
        $post = $originalpost;

        print '
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                    <tr>
                        <td class="manage-column">' . __('Title', 'petition') . '</td>
                        <td class="manage-column"><span><span class="vers comment-grey-bubble" title="' . __('Comments', 'petition') . '"><span class="screen-reader-text">' . __('Comments', 'petition') . '</span></span></span></td>
                        <td class="manage-column">' . __('Date', 'petition') . '</td>
                        <td class="manage-column">' . __('Views', 'petition') . '</td>
                    </tr>
                </thead>
                <tbody>
                    ' . $update_list . '
                </tbody>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_video_render') ): 
    function conikal_petition_video_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div class="adminField">
                            <label for="petition_video">' . __('Video URL', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="petition_video" name="petition_video" placeholder="' . __('Enter video URL', 'petition') . '" value="' . esc_attr(get_post_meta($post->ID, 'petition_video', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_gallery_render') ): 
    function conikal_petition_gallery_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');
        $gallery = array();
        $photos_list = esc_html(get_post_meta($post->ID, 'petition_gallery', true));
        $photos = explode('~~~', $photos_list);

        print '<input type="hidden" id="petition_gallery" name="petition_gallery" value="' . esc_attr(get_post_meta($post->ID, 'petition_gallery', true)) . '" />';
        print '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="propGalleryList">';
        foreach($photos as $photo) {
            if($photo != '') {
                print '<tr><td valign="middle" align="left"><img src="' . esc_url($photo) . '" /></td><td valign="middle" align="right"><a href="javascript:void(0);" class="delPhoto">' . __('Delete', 'petition') . '</a></td></tr>';
            }
        }
        print '</table>';
        print '<input id="addPhotoBtn" type="button" class="button" value="' . __('Add photo', 'petition') . '" />';
    }
endif;

if( !function_exists('conikal_petition_featured_render') ): 
    function conikal_petition_featured_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="petition_featured" value="">
                            <input type="checkbox" name="petition_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'petition_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="petition_featured">' . __('Set as Featured', 'petition') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_victory_render') ): 
    function conikal_petition_victory_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'petition_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="petition_victory" value="">
                            <input type="checkbox" name="petition_victory" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'petition_victory', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="petition_victory">' . __('Set as Victory Featured', 'petition') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_petition_meta_save') ): 
    function conikal_petition_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['petition_noncename']) && wp_verify_nonce($_POST['petition_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['petition_city'])) {
            update_post_meta($post_id, 'petition_city', sanitize_text_field($_POST['petition_city']));
        }
        if(isset($_POST['petition_lat'])) {
            update_post_meta($post_id, 'petition_lat', sanitize_text_field($_POST['petition_lat']));
        }
        if(isset($_POST['petition_lng'])) {
            update_post_meta($post_id, 'petition_lng', sanitize_text_field($_POST['petition_lng']));
        }
        if(isset($_POST['petition_address'])) {
            update_post_meta($post_id, 'petition_address', sanitize_text_field($_POST['petition_address']));
        }
        if(isset($_POST['petition_state'])) {
            update_post_meta($post_id, 'petition_state', sanitize_text_field($_POST['petition_state']));
        }
        if(isset($_POST['petition_neighborhood'])) {
            update_post_meta($post_id, 'petition_neighborhood', sanitize_text_field($_POST['petition_neighborhood']));
        }
        if(isset($_POST['petition_zip'])) {
            update_post_meta($post_id, 'petition_zip', sanitize_text_field($_POST['petition_zip']));
        }
        if(isset($_POST['petition_country'])) {
            update_post_meta($post_id, 'petition_country', sanitize_text_field($_POST['petition_country']));
        }
        if(isset($_POST['petition_goal'])) {
            update_post_meta($post_id, 'petition_goal', sanitize_text_field($_POST['petition_goal']));
        }
        if(isset($_POST['petition_sign'])) {
            update_post_meta($post_id, 'petition_sign', sanitize_text_field($_POST['petition_sign']));
        }
        if(isset($_POST['petition_decisionmakers'])) {
            update_post_meta($post_id, 'petition_decisionmakers', sanitize_text_field($_POST['petition_decisionmakers']));
        }
        if(isset($_POST['petition_sendinblue_list'])) {
            update_post_meta($post_id, 'petition_sendinblue_list', sanitize_text_field($_POST['petition_sendinblue_list']));
        }
        if(isset($_POST['petition_receiver'])) {
            update_post_meta($post_id, 'petition_receiver', sanitize_text_field($_POST['petition_receiver']));
        }
        if(isset($_POST['petition_position'])) {
            update_post_meta($post_id, 'petition_position', sanitize_text_field($_POST['petition_position']));
        }
        if(isset($_POST['petition_letter'])) {
            update_post_meta($post_id, 'petition_letter', sanitize_text_field($_POST['petition_letter']));
        }
        if(isset($_POST['petition_video'])) {
            update_post_meta($post_id, 'petition_video', sanitize_text_field($_POST['petition_video']));
        }
        if(isset($_POST['petition_update'])) {
            update_post_meta($post_id, 'petition_update', sanitize_text_field($_POST['petition_update']));
        }
        if(isset($_POST['petition_gallery'])) {
            update_post_meta($post_id, 'petition_gallery', sanitize_text_field($_POST['petition_gallery']));
        }
        if(isset($_POST['petition_featured'])) {
            update_post_meta($post_id, 'petition_featured', sanitize_text_field($_POST['petition_featured']));
        }
        if(isset($_POST['petition_victory'])) {
            update_post_meta($post_id, 'petition_victory', sanitize_text_field($_POST['petition_victory']));
        }
    }
endif;
add_action('save_post', 'conikal_petition_meta_save');

if( !function_exists('conikal_country_list') ): 
    function conikal_country_list($selected) {
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $country_select = '<select id="petition_country" name="petition_country">';

        if ($selected == '') {
            $conikal_general_settings = get_option('conikal_general_settings');
            if(isset($conikal_general_settings['conikal_country_field'])) {
                $selected = $conikal_general_settings['conikal_country_field'];
            }
        }

        foreach ($countries as $country) {
            $country_select .= '<option value="' . esc_attr($country) . '"';
            if ($selected == $country) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }
        $country_select.='</select>';

        return $country_select;
    }
endif;

if( !function_exists('conikal_substr45') ): 
    function conikal_substr45($string) {
        return substr($string, 0, 45);
    }
endif;

if( !function_exists('conikal_change_petition_default_title') ): 
    function conikal_change_petition_default_title($title){
        $screen = get_current_screen();
        if ('petition' == $screen->post_type) {
            $title = __('Enter petition title here', 'petition');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'conikal_change_petition_default_title');


// Add custom image petition category form

if( !function_exists('conikal_petition_category_add_meta_field') ): 
function conikal_petition_category_add_meta_field() {
    wp_nonce_field( basename( __FILE__ ), 'petition_category_nonce' );

    print '
        <div class="form-field petition-category-image-wrap">
            <label for="petition-category-image">' . __('Image', 'petition') . '</label>
            <input type="text" name="petition_category_image" id="petition-category-image" value="" />
            <input id="categoryImageBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />
            <p class="description">' . __('The background image show on category archive and shortcodes', 'petition') . '</p>
        </div>
    ';
}
endif;
add_action( 'petition_category_add_form_fields', 'conikal_petition_category_add_meta_field' );


if( !function_exists('conikal_petition_category_edit_meta_field') ): 
function conikal_petition_category_edit_meta_field($term) {
    wp_nonce_field( basename( __FILE__ ), 'petition_category_nonce' );
    $image = get_term_meta($term->term_id, 'petition_category_image', true);

    print '
    <tr class="form-field petition-category-image-wrap">
        <th scope="row"><label for="petition-category-image">' . __('Image', 'petition') . '</label></th>
        <td>
            <input type="text" name="petition_category_image" id="petition-category-image" value="' . ($image ? esc_attr($image) : '') . '" />
            <input id="categoryImageBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />
            <p class="description">' . __('The background image show on category archive and shortcodes', 'petition') . '</p>
        </td>
    </tr>';
}
endif;
add_action( 'petition_category_edit_form_fields', 'conikal_petition_category_edit_meta_field' );


if( !function_exists('conikal_save_petition_category_image') ): 
function conikal_save_petition_category_image( $term_id ) {

    if ( ! isset( $_POST['petition_category_nonce'] ) || ! wp_verify_nonce( $_POST['petition_category_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    $old_image = get_term_meta($term_id, 'petition_category_image', true);
    $new_image = isset( $_POST['petition_category_image'] ) ? sanitize_text_field( $_POST['petition_category_image'] ) : '';

    if ( $old_image && '' === $new_image ) {
        delete_term_meta($term_id, 'petition_category_image');
    } else if ( $old_image !== $new_image ) {
        update_term_meta($term_id, 'petition_category_image', $new_image);
    }
}
endif;
add_action( 'edit_petition_category',   'conikal_save_petition_category_image' );
add_action( 'create_petition_category', 'conikal_save_petition_category_image' );


// Add custom image petition topics form

if( !function_exists('conikal_petition_topics_add_meta_field') ): 
function conikal_petition_topics_add_meta_field() {
    wp_nonce_field( basename( __FILE__ ), 'petition_topics_nonce' );

    print '
        <div class="form-field petition-topics-image-wrap">
            <label for="petition-topics-image">' . __('Image', 'petition') . '</label>
            <input type="text" name="petition_topics_image" id="petition-topics-image" value="" />
            <input id="topicsImageBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />
            <p class="description">' . __('The background image show on topics archive and shortcodes', 'petition') . '</p>
        </div>
    ';
}
endif;
add_action( 'petition_topics_add_form_fields', 'conikal_petition_topics_add_meta_field' );


if( !function_exists('conikal_petition_topics_edit_meta_field') ): 
function conikal_petition_topics_edit_meta_field($term) {
    wp_nonce_field( basename( __FILE__ ), 'petition_topics_nonce' );
    $image = get_term_meta($term->term_id, 'petition_topics_image', true);

    print '
    <tr class="form-field petition-topics-image-wrap">
        <th scope="row"><label for="petition-topics-image">' . __('Image', 'petition') . '</label></th>
        <td>
            <input type="text" name="petition_topics_image" id="petition-topics-image" value="' . ($image ? esc_attr($image) : '') . '" />
            <input id="topicsImageBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />
            <p class="description">' . __('The background image show on topics archive and shortcodes', 'petition') . '</p>
        </td>
    </tr>';
}
endif;
add_action( 'petition_topics_edit_form_fields', 'conikal_petition_topics_edit_meta_field' );


if( !function_exists('conikal_save_petition_topics_image') ): 
function conikal_save_petition_topics_image( $term_id ) {

    if ( ! isset( $_POST['petition_topics_nonce'] ) || ! wp_verify_nonce( $_POST['petition_topics_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    $old_image = get_term_meta($term_id, 'petition_topics_image', true);
    $new_image = isset( $_POST['petition_topics_image'] ) ? sanitize_text_field( $_POST['petition_topics_image'] ) : '';

    if ( $old_image && '' === $new_image ) {
        delete_term_meta($term_id, 'petition_topics_image');
    } else if ( $old_image !== $new_image ) {
        update_term_meta($term_id, 'petition_topics_image', $new_image);
    }
}
endif;
add_action( 'edit_petition_topics',   'conikal_save_petition_topics_image' );
add_action( 'create_petition_topics', 'conikal_save_petition_topics_image' );

/*********************************
 * Register update custom post type
 *********************************/
if( !function_exists('conikal_register_update_type_init') ): 
    function conikal_register_update_type_init() {
        wp_enqueue_style('conikal_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('update', plugins_url( '/js/update.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('update', 'update_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'browse_text' => __('Browse...', 'petition')
            )
        );
    }
endif;
add_action('init', 'conikal_register_update_type_init');

if( !function_exists('conikal_register_update_type') ): 
    function conikal_register_update_type() {
        register_post_type('update', array(
            'labels' => array(
                'name'                  => __('Updates', 'petition'),
                'singular_name'         => __('Update', 'petition'),
                'add_new'               => __('Add New Update', 'petition'),
                'add_new_item'          => __('Add Update', 'petition'),
                'edit'                  => __('Edit', 'petition'),
                'edit_item'             => __('Edit Update', 'petition'),
                'new_item'              => __('New Update', 'petition'),
                'view'                  => __('View', 'petition'),
                'view_item'             => __('View Update', 'petition'),
                'search_items'          => __('Search Updates', 'petition'),
                'not_found'             => __('No Updates found', 'petition'),
                'not_found_in_trash'    => __('No Updates found in Trash', 'petition'),
                'parent'                => __('Parent Update', 'petition'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'update'),
            'supports'              => array('title', 'author', 'editor', 'comments'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'conikal_add_update_metaboxes',
            'menu_icon'             => plugins_url( '/images/update-icon.png', __FILE__ )
        ));
    }
endif;
add_action('init', 'conikal_register_update_type');

function conikal_add_update_metaboxes() {
    add_meta_box('update-details-section', __('Details', 'petition'), 'conikal_update_details_render', 'update', 'normal', 'default');
    add_meta_box('update-featured-section', __('Featured', 'petition'), 'conikal_update_featured_render', 'update', 'side', 'default');
}


if( !function_exists('conikal_update_details_render') ): 
    function conikal_update_details_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'update_noncename');

        $type = get_post_meta($post->ID, 'update_type', true);
        $petition_id = get_post_meta($post->ID, 'update_post_id', true);
        $media = get_post_meta($post->ID, 'update_media', true);

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div class="adminField">
                            <label for="update_type">' . __('Update type', 'petition') . '</label><br />
                            ' . conikal_update_type($type) . '
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div class="adminField">
                            <label for="update_post_id">' . __('Petition ID', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="update_post_id" name="update_post_id" placeholder="' . __('Enter Petition Id', 'petition') . '" value="' . esc_attr($petition_id) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div class="adminField">
                            <label for="update_media">' . __('URL Meida', 'petition') . '</label><br />
                            <input type="text" class="formInput" id="update_media" name="update_media" placeholder="' . __('Enter URL for an article, image, or video', 'petition') . '" value="' . esc_attr($media) . '" />
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_update_type') ): 
    function conikal_update_type($selected) {
        $update_type = array('update' => __('Update', 'petition'), 'featured' => __('Featured'), 'responsive' => __('Responsive', 'petition'), 'victory' => __('Victory', 'petition'));
        $update_select = '<select id="update_type" name="update_type">';

        if ($selected == '') {
            $selected = 'update';
        }

        foreach ($update_type as $key => $name) {
            $update_select .= '<option value="' . esc_attr($key) . '"';
            if ($selected == $key) {
                $update_select .= 'selected="selected"';
            }
            $update_select .= '>' . esc_html($name) . '</option>';
        }
        $update_select.='</select>';

        return $update_select;
    }
endif;

if( !function_exists('conikal_update_featured_render') ): 
    function conikal_update_featured_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'update_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="update_featured" value="">
                            <input type="checkbox" name="update_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'update_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="update_featured">' . __('Set as Featured', 'petition') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_update_meta_save') ): 
    function conikal_update_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['update_noncename']) && wp_verify_nonce($_POST['update_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['update_type'])) {
            update_post_meta($post_id, 'update_type', sanitize_text_field($_POST['update_type']));
        }
        if(isset($_POST['update_post_id'])) {
            update_post_meta($post_id, 'update_post_id', sanitize_text_field($_POST['update_post_id']));
        }
        if(isset($_POST['update_media'])) {
            update_post_meta($post_id, 'update_media', sanitize_text_field($_POST['update_media']));
        }
        if(isset($_POST['update_featured'])) {
            update_post_meta($post_id, 'update_featured', sanitize_text_field($_POST['update_featured']));
        }
    }
endif;
add_action('save_post', 'conikal_update_meta_save');

if( !function_exists('conikal_change_update_default_title') ): 
    function conikal_change_update_default_title($title) {
        $screen = get_current_screen();
        if ('update' == $screen->post_type) {
            $title = __('Enter update name here', 'petition');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'conikal_change_update_default_title');


/*************************************
 * Register decision maker custom post type
 *************************************/
if( !function_exists('conikal_register_decision_maker_type_init') ): 
    function conikal_register_decision_maker_type_init() {
        wp_enqueue_style('conikal_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
    }
endif;
add_action('init', 'conikal_register_decision_maker_type_init');

if( !function_exists('conikal_register_decision_maker_type') ): 
    function conikal_register_decision_maker_type() {
        register_post_type('decisionmakers', array(
            'labels' => array(
                'name'                  => __('Decision Makers', 'petition'),
                'singular_name'         => __('Decision Maker', 'petition'),
                'add_new'               => __('Add New Decision Maker', 'petition'),
                'add_new_item'          => __('Add Decision Maker', 'petition'),
                'edit'                  => __('Edit', 'petition'),
                'edit_item'             => __('Edit Decision Maker', 'petition'),
                'new_item'              => __('New Decision Maker', 'petition'),
                'view'                  => __('View', 'petition'),
                'view_item'             => __('View Decision Maker', 'petition'),
                'search_items'          => __('Search Decision Makers', 'petition'),
                'not_found'             => __('No Decision Makers found', 'petition'),
                'not_found_in_trash'    => __('No Decision Makers found in Trash', 'petition'),
                'parent'                => __('Parent Decision Maker', 'petition'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'decisionmakers'),
            'supports'              => array('title', 'author', 'editor'),
            'can_export'            => true,
            'menu_icon'             => plugins_url( '/images/decision-maker-icon.png', __FILE__ )
        ));

        // add dicision maker category custom taxonomy
        register_taxonomy('decisionmakers_title', 'decisionmakers', array(
            'labels' => array(
                'name'              => __('Decision Maker Title', 'petition'),
                'add_new_item'      => __('Add New Title', 'petition'),
                'new_item_name'     => __('New Title', 'petition')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'decisionmakers-title')
        ));

        // add dicision maker organization custom taxonomy
        register_taxonomy('decisionmakers_organization', 'decisionmakers', array(
            'labels' => array(
                'name'              => __('Organization', 'petition'),
                'add_new_item'      => __('Add New Organization', 'petition'),
                'new_item_name'     => __('New Organization', 'petition')
            ),
            'hierarchical'  => false,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'decisionmakers-organization')
        ));
    }
endif;
add_action('init', 'conikal_register_decision_maker_type');

if( !function_exists('conikal_change_decision_maker_default_title') ): 
    function conikal_change_decision_maker_default_title($title) {
        $screen = get_current_screen();
        if ('decisionmakers' == $screen->post_type) {
            $title = __('Enter decision maker name here', 'petition');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'conikal_change_decision_maker_default_title');


/*************************************
 * Register testimonials custom post type
 *************************************/
if( !function_exists('conikal_register_testimonials_type_init') ): 
    function conikal_register_testimonials_type_init() {
        wp_enqueue_style('conikal_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('testimonials', plugins_url( '/js/testimonials.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('testimonials', 'testimonials_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'browse_text' => __('Browse...', 'petition')
            )
        );
    }
endif;
add_action('init', 'conikal_register_testimonials_type_init');

if( !function_exists('conikal_register_testimonials_type') ): 
    function conikal_register_testimonials_type() {
        register_post_type('testimonials', array(
            'labels' => array(
                'name'                  => __('Testimonials', 'petition'),
                'singular_name'         => __('Testimonial', 'petition'),
                'add_new'               => __('Add New Testimonial', 'petition'),
                'add_new_item'          => __('Add Testimonial', 'petition'),
                'edit'                  => __('Edit', 'petition'),
                'edit_item'             => __('Edit Testimonial', 'petition'),
                'new_item'              => __('New Testimonial', 'petition'),
                'view'                  => __('View', 'petition'),
                'view_item'             => __('View Testimonial', 'petition'),
                'search_items'          => __('Search Testimonials', 'petition'),
                'not_found'             => __('No Testimonials found', 'petition'),
                'not_found_in_trash'    => __('No Testimonials found in Trash', 'petition'),
                'parent'                => __('Parent Testimonial', 'petition'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'testimonials'),
            'supports'              => array('title', 'editor'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'conikal_add_testimonials_metaboxes',
            'menu_icon'             => plugins_url( '/images/testimonials-icon.png', __FILE__ )
        ));
    }
endif;
add_action('init', 'conikal_register_testimonials_type');

if( !function_exists('conikal_add_testimonials_metaboxes') ): 
    function conikal_add_testimonials_metaboxes() {
        add_meta_box('testimonials-job-section', __('Job', 'petition'), 'conikal_testimonials_job_render', 'testimonials', 'normal', 'default');
        add_meta_box('testimonials-section', __('Avatar', 'petition'), 'conikal_testimonials_avatar_render', 'testimonials', 'normal', 'default');
    }
endif;

if( !function_exists('conikal_testimonials_job_render') ): 
    function conikal_testimonials_job_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'testimonilas_noncename');

        print '<input id="testimonials_job" name="testimonials_job" type="text" size="60" value="' . esc_html(get_post_meta($post->ID, 'testimonials_job', true)) . '" />';
    }
endif;

if( !function_exists('conikal_testimonials_avatar_render') ): 
    function conikal_testimonials_avatar_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'testimonilas_noncename');

        print '
            <input id="testimonials_avatar" name="testimonials_avatar" type="text" size="60" value="' . esc_attr(get_post_meta($post->ID, 'testimonials_avatar', true)) . '" />
            <input id="testimonialsAvatarBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />';
    }
endif;

if( !function_exists('conikal_testimonials_meta_save') ): 
    function conikal_testimonials_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['testimonilas_noncename']) && wp_verify_nonce($_POST['testimonilas_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['testimonials_job'])) {
            update_post_meta($post_id, 'testimonials_job', sanitize_text_field($_POST['testimonials_job']));
        }
        if(isset($_POST['testimonials_avatar'])) {
            update_post_meta($post_id, 'testimonials_avatar', sanitize_text_field($_POST['testimonials_avatar']));
        }
    }
endif;
add_action('save_post', 'conikal_testimonials_meta_save');

if( !function_exists('conikal_change_testimonials_default_title') ): 
    function conikal_change_testimonials_default_title($title) {
        $screen = get_current_screen();
        if ('testimonials' == $screen->post_type) {
            $title = __('Enter customer name here', 'petition');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'conikal_change_testimonials_default_title');


/********************************
 * Register team custom post type
 ********************************/
if( !function_exists('conikal_register_team_type_init') ): 
    function conikal_register_team_type_init() {
        wp_enqueue_style('conikal_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('team', plugins_url( '/js/team.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('team', 'team_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'browse_text' => __('Browse...', 'petition')
            )
        );
    }
endif;
add_action('init', 'conikal_register_team_type_init');

if( !function_exists('conikal_register_team_type') ): 
    function conikal_register_team_type() {
        register_post_type('team', array(
            'labels' => array(
                'name'                  => __('Team', 'petition'),
                'singular_name'         => __('Member', 'petition'),
                'add_new'               => __('Add New Member', 'petition'),
                'add_new_item'          => __('Add Member', 'petition'),
                'edit'                  => __('Edit', 'petition'),
                'edit_item'             => __('Edit Member', 'petition'),
                'new_item'              => __('New Member', 'petition'),
                'view'                  => __('View', 'petition'),
                'view_item'             => __('View Member', 'petition'),
                'search_items'          => __('Search Member', 'petition'),
                'not_found'             => __('No Members found', 'petition'),
                'not_found_in_trash'    => __('No Members found in Trash', 'petition'),
                'parent'                => __('Parent Member', 'petition'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'team'),
            'supports'              => array('title', 'editor'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'conikal_add_team_metaboxes',
            'menu_icon'             => plugins_url( '/images/team-icon.png', __FILE__ )
        ));
    }
endif;
add_action('init', 'conikal_register_team_type');

if( !function_exists('conikal_add_team_metaboxes') ): 
    function conikal_add_team_metaboxes() {
        add_meta_box('team-position-section', __('Position', 'petition'), 'conikal_team_position_render', 'team', 'normal', 'default');
        add_meta_box('team-living-section', __('Living', 'petition'), 'conikal_team_living_render', 'team', 'normal', 'default');
        add_meta_box('team-avatar-section', __('Avatar', 'petition'), 'conikal_team_avatar_render', 'team', 'normal', 'default');
        add_meta_box('team-social-section', __('Social Network', 'petition'), 'conikal_team_social_render', 'team', 'normal', 'default');
    }
endif;

if( !function_exists('conikal_team_position_render') ): 
    function conikal_team_position_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'team_noncename');

        print '<input id="team_position" name="team_position" type="text" size="100" value="' . esc_html(get_post_meta($post->ID, 'team_position', true)) . '" />';
    }
endif;

if( !function_exists('conikal_team_living_render') ): 
    function conikal_team_living_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'team_noncename');

        print '<input id="team_living" name="team_living" type="text" size="100" value="' . esc_html(get_post_meta($post->ID, 'team_living', true)) . '" />';
    }
endif;

if( !function_exists('conikal_team_avatar_render') ): 
    function conikal_team_avatar_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'team_noncename');

        print '
            <input id="team_avatar" name="team_avatar" type="text" size="90" value="' . esc_attr(get_post_meta($post->ID, 'team_avatar', true)) . '" />
            <input id="teamAvatarBtn" type="button"  class="button" value="' . __('Browse...', 'petition') . '" />';
    }
endif;

if( !function_exists('conikal_team_social_render') ): 
    function conikal_team_social_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'team_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="10%">
                        <label for="team_website">' . __('Website', 'petition') . '</label>
                    </td>
                    <td width="90%" valign="top" align="left">
                        <input id="team_website" name="team_website" type="text" size="100" value="' . esc_attr(get_post_meta($post->ID, 'team_website', true)) . '" />
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <label for="team_facebook">' . __('Facebook', 'petition') . '</label>
                    </td>
                    <td width="90%" valign="top" align="left">
                        <input id="team_facebook" name="team_facebook" type="text" size="100" value="' . esc_attr(get_post_meta($post->ID, 'team_facebook', true)) . '" />
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <label for="team_twitter">' . __('Twitter', 'petition') . '</label>
                    </td>
                    <td width="90%" valign="top" align="left">
                        <input id="team_twitter" name="team_twitter" type="text" size="100" value="' . esc_attr(get_post_meta($post->ID, 'team_twitter', true)) . '" />
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <label for="team_googleplus">' . __('Google+', 'petition') . '</label>
                    </td>
                    <td width="90%" valign="top" align="left">
                        <input id="team_googleplus" name="team_googleplus" type="text" size="100" value="' . esc_attr(get_post_meta($post->ID, 'team_googleplus', true)) . '" />
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <label for="team_linkin">' . __('LinkedIn', 'petition') . '</label>
                    </td>
                    <td width="90%" valign="top" align="left">
                        <input id="team_linkin" name="team_linkin" type="text" size="100" value="' . esc_attr(get_post_meta($post->ID, 'team_linkin', true)) . '" />
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('conikal_team_meta_save') ): 
    function conikal_team_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['team_noncename']) && wp_verify_nonce($_POST['team_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['team_position'])) {
            update_post_meta($post_id, 'team_position', sanitize_text_field($_POST['team_position']));
        }
        if(isset($_POST['team_living'])) {
            update_post_meta($post_id, 'team_living', sanitize_text_field($_POST['team_living']));
        }
        if(isset($_POST['team_avatar'])) {
            update_post_meta($post_id, 'team_avatar', sanitize_text_field($_POST['team_avatar']));
        }
        if(isset($_POST['team_website'])) {
            update_post_meta($post_id, 'team_website', sanitize_text_field($_POST['team_website']));
        }
        if(isset($_POST['team_facebook'])) {
            update_post_meta($post_id, 'team_facebook', sanitize_text_field($_POST['team_facebook']));
        }
        if(isset($_POST['team_twitter'])) {
            update_post_meta($post_id, 'team_twitter', sanitize_text_field($_POST['team_twitter']));
        }
        if(isset($_POST['team_googleplus'])) {
            update_post_meta($post_id, 'team_googleplus', sanitize_text_field($_POST['team_googleplus']));
        }
        if(isset($_POST['team_linkin'])) {
            update_post_meta($post_id, 'team_linkin', sanitize_text_field($_POST['team_linkin']));
        }
    }
endif;
add_action('save_post', 'conikal_team_meta_save');

if( !function_exists('conikal_change_team_default_title') ): 
    function conikal_change_team_default_title($title) {
        $screen = get_current_screen();
        if ('team' == $screen->post_type) {
            $title = __('Enter member name here', 'petition');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'conikal_change_team_default_title');


/********************************
 * Add type of Sidebar option
 ********************************/
add_action( 'add_meta_boxes', 'meta_box_sidebar_add' );
function meta_box_sidebar_add()
{
    add_meta_box( 'meta-box-sidebar', 'Sidebar', 'meta_box_sidebar_callback', 'page', 'normal', 'high' );
}

function meta_box_sidebar_callback( $post )
{
    $values = get_post_custom( $post->ID );
    $options = array('none' => 'No Sidebar', 'center' => 'Center', 'left' => 'Left Sidebar', 'right' => 'Right Sidebar');
    $selected = isset( $values['meta_box_sidebar'] ) ? $values['meta_box_sidebar'][0] : '';

    wp_nonce_field( 'conikal_meta_box_sidebar_nonce', 'meta_box_sidebar_nonce' );

    $select = '<select id="meta_box_sidebar" name="meta_box_sidebar">';
    foreach ($options as $option => $label) {
        $select .= '<option value="' . esc_attr($option) . '"';
            if ($selected == $option) {
                $select .= 'selected="selected"';
        }
        $select .= '>' . esc_html($label) . '</option>';
    }
    $select .='</select>';

    print $select; 
}

add_action( 'save_post', 'meta_box_sidebar_save' );
function meta_box_sidebar_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_sidebar_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_sidebar_nonce'], 'conikal_meta_box_sidebar_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // Probably a good idea to make sure your data is set

    if( isset( $_POST['meta_box_sidebar'] ) )
        update_post_meta( $post_id, 'meta_box_sidebar', $_POST['meta_box_sidebar'] );

}

?>