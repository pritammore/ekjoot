<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
// LOAD MORE LEADERSFEED 
if( !function_exists('conikal_load_leadersfeed') ): 
    function conikal_load_leadersfeed() {
        check_ajax_referer('load_petitions_ajax_nonce', 'security');

        $current_user = wp_get_current_user();
		$conikal_appearance_settings = get_option('conikal_appearance_settings','');
		$posts_per_page_setting = isset($conikal_appearance_settings['conikal_petitions_per_page_field']) ? $conikal_appearance_settings['conikal_petitions_per_page_field'] : '';
		$posts_per_page = $posts_per_page_setting != '' ? $posts_per_page_setting : 10;
		$sidebar_position = isset($conikal_appearance_settings['conikal_sidebar_field']) ? $conikal_appearance_settings['conikal_sidebar_field'] : '';
		$show_bc = isset($conikal_appearance_settings['conikal_breadcrumbs_field']) ? $conikal_appearance_settings['conikal_breadcrumbs_field'] : '';
		
		$users = get_users();
		$conikal_general_settings = get_option('conikal_general_settings','');
		$paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 2;
		$keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

		$args = array(
		    'post_type' => 'decisionmakers',
		    'posts_per_page' => $posts_per_page,
		    'post_status' => array('publish'),
		    'paged' => $paged,
		    's' => $keyword
		);

		$decisionmakers = new WP_Query($args);
		wp_reset_query();
		wp_reset_postdata();

		$arrayDecisionmakers = array();
		if($decisionmakers->have_posts()) {
		    while ( $decisionmakers->have_posts() ) {
		        $decisionmakers->the_post();
		        $id = get_the_ID();
		        $link = get_permalink($id);
		        $name = get_the_title($id);
		        $title =  wp_get_post_terms($id, 'decisionmakers_title', true);
		        $title_name = ($title ? $title[0]->name : '');
		        $organization =  wp_get_post_terms($id, 'decisionmakers_organization', true);
		        $organization_name = ($organization ? $organization[0]->name : '');
		        $excerpt = conikal_get_excerpt_by_id($id);
		        $author = get_the_author_meta('ID');
		        $up_bio = conikal_get_biographical_by_id($author);
	         	$up_avatar_orginal = get_user_meta($author, 'avatar_orginal', true);
                $up_avatar_id = get_user_meta($author, 'avatar_id', true);
                    if ($up_avatar_orginal != '') {
                        $avatar = $up_avatar_orginal;
                    } else {
                        $avatar = get_template_directory_uri().'/images/avatar.svg';
                    }
		        $arrayDecision = array(
		                'id' => $id, 
		                'link' => $link,
		                'name' => $name,
		                'title' => $title_name,
		                'organization' => $organization_name,
		                'description' => $title_name . __(' of ', 'petition') . $organization_name,
		                'excerpt' => $excerpt,
		                'avatar' => $avatar,
		                'author' => $author,
		                'up_bio' => $up_bio,
		            );

		        $arrayDecision = (object) $arrayDecision;
		        array_push($arrayDecisionmakers, $arrayDecision);
		    }
		}
        if ($arrayDecisionmakers) {
            echo json_encode(array('status' => true, 'found_posts' => count($arrayDecisionmakers), 'total' => $petitions->post_count, 'per_page' => $posts_per_page, 'decisionmakers' => $arrayDecisionmakers, 'message' => __('Decision Makers was loaded successfully.', 'decisionmakers')));
            exit();
        } else {
            echo json_encode(array('status' => false, 'message' => __('Something went wrong. Not found Decision Makers.', 'decisionmakers')));
            exit();
        }

        die();
    }
endif;

add_action( 'wp_ajax_nopriv_conikal_load_leadersfeed', 'conikal_load_leadersfeed' );
add_action( 'wp_ajax_conikal_load_leadersfeed', 'conikal_load_leadersfeed' );

?>