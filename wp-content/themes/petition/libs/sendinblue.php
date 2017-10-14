<?php 
/**
 * @package WordPress
 * @subpackage Petition
 */


// CREATING A NEW LIST AND UPDATE LIST
if( !function_exists('conikal_sendinblue_list') ): 
    function conikal_sendinblue_list($petition_id, $list_id, $list_name) {
    	$conikal_auth_settings = get_option('conikal_auth_settings', '');
    	$sendinblue_list_status = isset($conikal_auth_settings['conikal_sendinblue_list_field']) ? $conikal_auth_settings['conikal_sendinblue_list_field'] : '';
    	$sendinblue_key = isset($conikal_auth_settings['conikal_sendinblue_key_field']) ? $conikal_auth_settings['conikal_sendinblue_key_field'] : '';
    	$sendinblue_folder = isset($conikal_auth_settings['conikal_sendinblue_folder_id_field']) ? $conikal_auth_settings['conikal_sendinblue_folder_id_field'] : '';
    	$api_url = 'https://api.sendinblue.com/v2.0';

    	if ($sendinblue_list_status != '' && $sendinblue_key != '' && is_plugin_active('mailin/sendinblue.php')) {
	    	$mailin = new Mailin($api_url, $sendinblue_key);
		    $data = array(
		    	'list_name' => $list_name,
		      	'list_parent' => $sendinblue_folder
		    );

		    if ($list_id != '') {
		    	// update sendinblue list
	    		$data['id'] = $list_id;
	    		$list = $mailin->update_list($data);
	    	} else {
	    		// create new list
	    		$list = $mailin->create_list($data);

	    		// update sendinblue list id to petition
	    		if ($list['code'] == 'success') {
	    			update_post_meta($petition_id, 'petition_sendinblue_list', $list['data']['id']);
	    		}
	    	}
	    } else {
	    	$list = false;
	    }

    	return $list;
    }
endif;


// ADD EXISTING USERS TO LIST AND CREATE NEW USER
if( !function_exists('conikal_sendinblue_users_list') ): 
    function conikal_sendinblue_users_list($list_id, $user_id, $action = 'add') {
    	$conikal_auth_settings = get_option('conikal_auth_settings', '');
    	$sendinblue_list_status = isset($conikal_auth_settings['conikal_sendinblue_list_field']) ? $conikal_auth_settings['conikal_sendinblue_list_field'] : '';
    	$sendinblue_key = isset($conikal_auth_settings['conikal_sendinblue_key_field']) ? $conikal_auth_settings['conikal_sendinblue_key_field'] : '';
    	$sendinblue_folder = isset($conikal_auth_settings['conikal_sendinblue_folder_id_field']) ? $conikal_auth_settings['conikal_sendinblue_folder_id_field'] : '';
    	$sendinblue_name = isset($conikal_auth_settings['conikal_sendinblue_name_field']) ? $conikal_auth_settings['conikal_sendinblue_name_field'] : 'NAME';
    	$sendinblue_firstname = isset($conikal_auth_settings['conikal_sendinblue_firstname_field']) ? $conikal_auth_settings['conikal_sendinblue_firstname_field'] : 'FIRSTNAME';
    	$api_url = 'https://api.sendinblue.com/v2.0';
    	$user = get_user_by('ID', $user_id);

    	if ($sendinblue_list_status != '' && $sendinblue_key != '' && is_plugin_active('mailin/sendinblue.php')) {
	    	$mailin = new Mailin($api_url, $sendinblue_key);
		    $data = array(
		    	'id' => $list_id,
		      	'users' => array($user->user_email),
		    );
	 
	 		if ($action == 'add') {
	 			// add exist user
	 			$list = array();

	 			// check user not exist
 				$new_contact = array(
 					"email" => $user->user_email,
			        "attributes" => array($sendinblue_name => $user->last_name, $sendinblue_firstname => $user->first_name),
			        "listid" => array($list_id),
			    );

 				// create new user
			    $contact = $mailin->create_update_user($new_contact);
			    array_push($list, array('new_user' => $contact));
	 		} else {
	 			// delete exist user
	 			$list = $mailin->delete_users_list($data);
	 		}
	 	} else {
	 		$list = false;
	 	}

    	return $list;
    }
endif;

?>