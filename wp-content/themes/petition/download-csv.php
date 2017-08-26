<?php
/*
Template Name: Download CSV
*/

/**
 * @package WordPress
 * @subpackage Petition
 */
	if (isset($_GET['petition_id']) && $_GET['petition_id'] != '') {
        $petition_id = sanitize_text_field($_GET['petition_id']);
        $type = sanitize_text_field($_GET['download']);
        $users_sign = get_post_meta($petition_id, 'petition_users', true);
        $users_list = array();
        $conlum_name = array(
        	__('User ID', 'petition'),
        	__('Date', 'petition'),
        	__('First Name', 'petition'),
        	__('Last Name', 'petition'),
        	__('Gender', 'petition'),
        	__('Birthday', 'petition'),
        	__('Neigborhood', 'petition'),
        	__('City', 'petition'),
        	__('State', 'petition'),
        	__('Country', 'petition'),
        	__('Reason', 'petition')
        	);
    	array_push($users_list, $conlum_name);

        foreach ($users_sign as $user) {
        	$user_sign_date = $user['date'];
        	$user_sign_reason = $user['reason'];
	        $user_data = get_userdata($user['user_id']);
	        $user_id = $user_data->ID;
	        $user_name = $user_data->display_name;
	        $user_firstname = $user_data->first_name;
	        $user_lastname = $user_data->last_name;
	        $user_address = get_user_meta($user_id, 'user_address', true);
	        $user_neigborhood = get_user_meta($user_id, 'user_neigborhood', true);
	        $user_city = get_user_meta($user_id, 'user_city', true);
	        $user_state = get_user_meta($user_id, 'user_state', true);
	        $user_country = get_user_meta($user_id, 'user_country', true);
	        $user_lat = get_user_meta($user_id, 'user_lat', true);
	        $user_lng = get_user_meta($user_id, 'user_lng', true);
	        $user_gender = get_user_meta($user_id, 'user_gender', true);
	        $user_birthday = get_user_meta($user_id, 'user_birthday', true);
	        $user_petition_count = count_user_posts( $user_id, 'petition' );

	        $user_detail = array($user_id, $user_sign_date, $user_firstname, $user_lastname, $user_gender, $user_birthday, $user_neigborhood, $user_city, $user_state, $user_country, $user_sign_reason);
	        array_push($users_list, $user_detail);
	    }


        // create csv download file
		if (isset($_GET['download']) && $type == 'signatures') {
		    conikal_convert_to_csv($users_list, 'petition-signature-' . $petition_id . '.csv', ',');
		}
    }
?>