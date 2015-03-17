<?php
	
add_action("wp_ajax_directory_update_user", "directory_update_user");
add_action("wp_ajax_nopriv_directory_update_user", "directory_update_user");

function directory_update_user(){
		
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_update_user_nonce')) {
      exit('You are not authorised to take this action');
	}
	
	$valid = array('ID','user_pass','user_login','user_nicename','user_url','user_email','display_name','nickname','first_name','last_name','description','rich_editing','user_registered','role','jabber','aim','yim');
	
	foreach($_REQUEST as $k=>$v){
		if(in_array($k, $valid)){
			$userdata[$k] = $_REQUEST[$k];
		}
	}
	
	// validate required data or bounce
	if($userdata['user_pass'] != '' && $userdata['user_pass'] != $_REQUEST['confirm_user_pass']) $error[] = 'Passwords do not match';
	
	if(!$error){
		
		$userdata['user_login'] = $userdata['user_nicename'] = strtolower($userdata['first_name']).'_'.strtolower($userdata['last_name']);
		$userdata['display_name'] = $userdata['first_name'].' '.$userdata['last_name'];
		//echo '<pre>'; print_r($userdata); echo '</pre>';
		wp_update_user($userdata);
		
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
		die('You did not specify where to go after your item was updated. Simply add <input type="hidden" name="redirect" value="/mypage" /> to your form. Do not include any query strings');
	}


	
	die();
	
}


//add_action( 'init', 'directory_update_enqueue' );

function directory_update_user_enqueue() {
   wp_register_script( 'directory_update_user', WP_PLUGIN_URL.'/ibe-directory/js/directory_update_user.js', array('jquery') );
   wp_localize_script( 'directory_update_user', 'directory_update_user', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_update_user' );
}