<?php
/*
Template Name: Supporters list
*/

/**
 * @package WordPress
 * @subpackage Petition
 */


global $post;
global $current_user;
global $paged;
get_header();

$conikal_general_settings = get_option('conikal_general_settings');
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
$supporter_per_page_setting = isset($conikal_appearance_settings['conikal_supporter_per_page_field']) ? $conikal_appearance_settings['conikal_supporter_per_page_field'] : '';
$supporter_per_page = $supporter_per_page_setting != '' ? $supporter_per_page_setting : 12;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<div id="wrapper" class="wrapper">
<?php 
if (isset($_GET['petition_id']) && $_GET['petition_id'] != '') {
    $petition_id = isset($_GET['petition_id']) ? sanitize_text_field($_GET['petition_id']) : '';
    $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

    $form_id = get_post_meta($petition_id, 'petition_contribute', true);
    $contribute_approve = get_post_status($form_id);
    if ($contribute_approve === 'pending') {
        $form_id = '';
    }
?>
	<div class="ui container submit-petition">
		<div class="ui center aligned header submit-petition-title">
            <div class="content">
            	<?php if ($type === 'supporter') {
            		_e('Supporters', 'petition');
            	} else if ($type === 'donor') {
            		_e('Donors', 'petition');
            	} else {
            		the_title();
            	} ?>
            </div>
        </div>
		<div class="ui four column stackable grid">
		<?php
			$users = array();
			if ($type === 'supporter') {
				$users = get_post_meta($petition_id, 'petition_users', true);
                $users = array_reverse($users);
			} else {
				if(function_exists('give_get_payments')) {
	                $args = array(
	                	'status'     => 'publish',
	                    'give_forms' => array($form_id),
	                    'order' => 'DESC'
	                );
	                $donations = give_get_payments( $args );

	                foreach($donations as $donation) {
                        $customer_id = give_get_payment_donor_id( $donation->ID );
                        $customer    = new Give_Customer( $customer_id );
                        array_push($users, array('user_id' => $customer->user_id));
                    }
	            }
			}

			// paination calulate
			$total = count( $users ); //total items in array    
			$limit = $supporter_per_page; //per page    
			$pages = ceil( $total / $limit ); //calculate total pages
			$paged = max($paged, 1); //get 1 page when $_GET['page'] <= 0
			$paged = min($paged, $pages); //get last page when $_GET['page'] > $totalPages
			$offset = ($paged - 1) * $limit;
			if( $offset < 0 ) $offset = 0;

			$users = array_slice( $users, $offset, $limit );

		    $current_user_follows = get_user_meta($current_user->ID, 'follow_user', true);
		    foreach ($users as $user) {
		        	$user = get_user_by('ID', $user['user_id']);

		        	if ($user) {
                    $user_id = $user->ID;
		            $user_name = $user->display_name;
		            $user_bio = $user->description;
		            $user_address = get_user_meta($user_id, 'user_address', true);
		            $user_neigborhood = get_user_meta($user_id, 'user_neigborhood', true);
		            $user_city = get_user_meta($user_id, 'user_city', true);
		            $user_state = get_user_meta($user_id, 'user_state', true);
		            $user_country = get_user_meta($user_id, 'user_country', true);
		            $user_lat = get_user_meta($user_id, 'user_lat', true);
		            $user_lng = get_user_meta($user_id, 'user_lng', true);
		            $user_gender = get_user_meta($user_id, 'user_gender', true);
		            $user_birthday = get_user_meta($user_id, 'user_birthday', true);
		            $user_avatar = $user->avatar;
		            $user_petition_count = count_user_posts( $user_id, 'petition' );
		            
		            if (!$user_avatar) {
		                $user_avatar = get_template_directory_uri().'/images/avatar.svg';
		            }
		            $user_avatar = conikal_get_avatar_url( $user_id, array('size' => 35, 'default' => $user_avatar) );
	        	?>
	        	<div class="column">
			        <div class="ui fluid card">
			            <div class="content">
			            	<img class="right floated mini ui circular image" src="<?php echo esc_html($user_avatar); ?>" alt="<?php echo esc_attr($user_name) ?>" />
			                <div class="header truncate">
				                <a href="<?php echo get_author_posts_url($user_id) ?>" class="header" data-bjax><?php echo esc_html($user_name) ?></a>
				            </div>
				            <div class="meta truncate">
				            	<?php if ($user_country || $user_state || $user_city) { ?>
								<?php echo ($user_city ? $user_city . ', ' : '') . ($user_state ? $user_state . ', ' : '') . ($user_country ? $user_country : '') ?>
								<?php } ?>
				            </div>
				            <div class="description" style="height: 32px; overflow: hidden;">
						        <?php echo esc_html($user_bio) ?>
						    </div>
			            </div>
			            <div class="extra content">
					      	<?php if(is_user_logged_in()) {
			                    if($current_user_follows != '') {
			                        if(in_array($user_id, $current_user_follows) === false) { ?>
			                            <a href="javascript:void(0)" id="follow-page-<?php echo esc_html($user_id) ?>" class="ui basic fluid circular button follow-page follow" data-id="<?php echo esc_html($user_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
			                        <?php } else { ?>
			                            <a href="javascript:void(0)" id="follow-page-<?php echo esc_html($user_id) ?>" class="ui primary fluid circular button follow-page following" data-id="<?php echo esc_html($user_id); ?>"><i class="checkmark user icon"></i><?php _e('Following', 'petition') ?></a>
			                    <?php } 
			                        } else { ?>
			                        <a href="javascript:void(0)" id="follow-page-<?php echo esc_html($user_id) ?>" class="ui basic fluid circular button follow-page follow" data-id="<?php echo esc_html($user_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
			                    <?php }
			                } else { ?>
			                	<a href="javascript:void(0)" id="follow-page-<?php echo esc_html($user_id) ?>" class="ui basic fluid circular button signin-btn" data-id="<?php echo esc_html($user_id); ?>"><i class="plus icon"></i><?php _e('Follow', 'petition') ?></a>
			                <?php } ?>
					    </div>
			        </div>
			    </div>
		        <?php }
		    }
		?>
		</div>


		<!-- PAGINATION -->
		<div class="ui two column grid ">
            <div class="column">
                <?php conikal_pagination($pages) ?>
            </div>
            <div class="right aligned column">
                <?php
                    $conikal_appearance_settings = get_option('conikal_appearance_settings');
                    $per_p_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
                    $per_p = $per_p_setting != '' ? intval($per_p_setting) : 10;
                    $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $from_p = ($page_no == 1) ? 1 : $per_p * ($page_no - 1) + 1;
                    $to_p = ($total - ($page_no - 1) * $per_p > $per_p) ? $per_p * $page_no : $total;
                    echo esc_html($from_p) . ' - ' . esc_html($to_p) . __(' of ', 'petition') . esc_html($total) . __(' Petitions', 'petition');
                ?>
            </div>
        </div>
	</div>
<?php
} else {
	get_template_part('404');
}
wp_nonce_field('follow_ajax_nonce', 'securityFollow', true);
?>
</div>


<?php get_footer(); ?>
