<?php
	
add_action("wp_ajax_directory_create_user", "directory_create_user");
add_action("wp_ajax_nopriv_directory_create_user", "directory_create_user");

function directory_create_user(){

			
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_create_user_nonce')) {
      exit('You are not authorised to take this action');
	}
	
	$valid = array('user_pass','user_login','user_nicename','user_url','user_email','display_name','nickname','first_name','last_name','description','rich_editing','user_registered','role','jabber','aim','yim');
	
	foreach($_REQUEST as $k=>$v){
		if(in_array($k, $valid)){
			$userdata[$k] = $_REQUEST[$k];
		}
	}
	
	
	if($userdata['first_name'] == '') $error[] = 'First name missing';
	if($userdata['user_email'] == '') $error[] = 'Email missing';
	if($userdata['user_pass'] == '') $error[] = 'Password missing';
	if($userdata['user_pass'] != $_REQUEST['confirm_user_pass']) $error[] = 'Passwords do not match';
	
	

	if(!$error){
		$userdata['user_login'] = strtolower($userdata['first_name']).'_'.strtolower($userdata['last_name']);
		$newuserID = wp_insert_user($userdata);
		if(!is_wp_error($newuserID)){
			if($_REQUEST['group_id']) update_user_meta($newuserID,'group_id',$_REQUEST['group_id']);

			if($_REQUEST['autologin'] == 'true'){
			    wp_set_current_user($id); // set the current wp user
			    wp_set_auth_cookie($id); // start the cookie for the current registered user
			}

			if($_REQUEST['redirect']){
				header('Location: '.$_REQUEST['redirect']);
			} else {
				header('Location: '.$_SERVER['HTTP_REFERER'].'?u='.$newuserID);
			}
		}
	} else {
		session_start();
		$_SESSION['errors'] = $error;
		$_SESSION['userdata'] = $userdata;
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}


	
}


//add_action( 'init', 'directory_create_user_enqueue' );

function directory_create_user_enqueue() {
   wp_register_script( 'directory_create_user', WP_PLUGIN_URL.'/ibe-directory/js/directory_create_user.js', array('jquery') );
   wp_localize_script( 'directory_create_user', 'directory_create_user', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_create_user' );
}