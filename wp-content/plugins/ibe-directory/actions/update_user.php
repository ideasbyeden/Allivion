<?php
	
add_action("wp_ajax_directory_update_user", "directory_update_user");
add_action("wp_ajax_nopriv_directory_update_user", "directory_update_user");

function directory_update_user(){
	

	// Nonce check
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_update_user_nonce')) {
      exit('You are not authorised to take this action');
	}
	
	
	// supplied role object exists
	$role = $_REQUEST['role'];
	global $$role, $user, $usermeta;
	if(!$$role) die('Role "'.$role.'" does not exist');
	
	
	// Logged in user can edit this entry
	// $$role->canEdit($_REQUEST['ID']);


	// set up core user data (stored in wp_users)
	$valid = array('ID','user_pass','user_login','user_nicename','user_url','user_email','display_name','nickname','first_name','last_name','description','rich_editing','user_registered','role','jabber','aim','yim');
		
	foreach(array_filter($_REQUEST) as $k=>$v){
		if(in_array($k, $valid)){
			$this_user[$k] = $v;
		}
	}

	// set up user meta data
	$varnames = $$role->getVarNames();
	$validmeta = array_diff($varnames,$valid);
	
	foreach(array_filter($_REQUEST) as $k=>$v){ 
		if(in_array($k, $validmeta)){
			$this_usermeta[$k] = $v;
		}
	}	
		
	// assemble / validate data for update user
	if($_REQUEST['origin'] == 'updateuser'){
		if($this_user['user_pass'] != '' && $this_user['user_pass'] != $_REQUEST['confirm_user_pass']) $error[] = 'Passwords do not match';
		$this_user['user_login'] = $this_user['user_nicename'] = strtolower($this_user['first_name']).'_'.strtolower($this_user['last_name']);
		$this_user['display_name'] = $this_user['first_name'].' '.$this_user['last_name'];	
		unset($this_usermeta['confirm_user_pass']);
	}
	
	// assemble / validate supplied data for update profile
	if($_REQUEST['origin'] == 'updateprofile'){
		$this_user['ID'] = $user->ID;
	}	
	
	if(!$this_user['ID']) $error[] = 'No user ID was sent';
	
/*
	echo '<pre>Item var names '; print_r($varnames); echo '</pre>';
	echo '<pre>Valid meta fields '; print_r($validmeta); echo '</pre>';
	echo '<pre>User '; print_r(array_filter($this_user)); echo '</pre>';
	echo '<pre>Usermeta '; print_r($this_usermeta); echo '</pre>';
	die();
*/
	
	// If no errors, update user
	if(!$error){
		wp_update_user($this_user);
		if($this_usermeta){
			foreach($this_usermeta as $k=>$v){
				update_user_meta($this_user['ID'],$k,$v);
			}
		}
	
	// errors found, return to form with error details	
	} else {
		session_start();
		$_SESSION['errors'] = $error;
		$_SESSION['userdata'] = $this_user;
		$_SESSION['usermeta'] = $this_usermeta;
		header('Location: '.$_SERVER['HTTP_REFERER']);
		die();
	}
	
	
	// If we're still here, we've updated the user. Now redirect to URL supplied or error.
	if($_REQUEST['redirect']){
		header('Location: '.$_REQUEST['redirect']);
	} else {
		die('You did not specify where to go after your item was updated. Simply add <input type="hidden" name="redirect" value="/mypage" /> to your form. Do not include any query strings');
	}

	die();
	
}

// AJAX disabled as form redirects after submission
// add_action( 'init', 'directory_update_enqueue' );

/*
function directory_update_user_enqueue() {
   wp_register_script( 'directory_update_user', WP_PLUGIN_URL.'/ibe-directory/js/directory_update_user.js', array('jquery') );
   wp_localize_script( 'directory_update_user', 'directory_update_user', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_update_user' );
}
*/