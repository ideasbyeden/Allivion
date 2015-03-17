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
	
	// validate required data or bounce
	
	if($userdata['first_name'] == '') $error[] = 'First name missing';
	if($userdata['user_email'] == '') $error[] = 'Email missing';
	if($userdata['user_pass'] == '') $error[] = 'Password missing';
	if($userdata['user_pass'] != $_REQUEST['confirm_user_pass']) $error[] = 'Passwords do not match';
	
	if(!$error){
		
		$userdata['user_login'] = strtolower($userdata['first_name']).'_'.strtolower($userdata['last_name']);
		
		if($newuserID = wp_insert_user($userdata)){
			update_user_meta($newuserID,'group_id',$_REQUEST['group_id']);
		};		
	} else {
		session_start();
		$_SESSION['errors'] = $error;
		$_SESSION['userdata'] = $userdata;
		header('Location: '.$_SERVER['HTTP_REFERER']);
		die();
	}
	
	


	if($_REQUEST['redirect']){
		header('Location: '.$_REQUEST['redirect']);
	} else {
		die('You did not specify where to go after your item was created. Simply add <input type="hidden" name="redirect" value="/mypage" /> to your form. Do not include any query strings');
	}

	
	die();
	
}


//add_action( 'init', 'directory_create_enqueue' );

function directory_create_user_enqueue() {
   wp_register_script( 'directory_create_user', WP_PLUGIN_URL.'/ibe-directory/js/directory_create_user.js', array('jquery') );
   wp_localize_script( 'directory_create_user', 'directory_create_user', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_create_user' );
}