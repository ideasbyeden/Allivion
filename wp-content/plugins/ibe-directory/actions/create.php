<?php
	
add_action("wp_ajax_directory_create", "directory_create");
add_action("wp_ajax_nopriv_directory_create", "directory_create");

function directory_create(){
	
	global $user, $allivion;
	
	//die(print_r($_REQUEST));
		
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_create_nonce')) {
      exit('You are not authorised to take this action');
	} 
	
	// insert new post with data
	$newitem = array(	'post_type' => $_REQUEST['type'],
						'post_title' => $_REQUEST[POSTTITLEFIELD],
						'post_status' => 'publish'
					);
							
	$newitem['post_author'] = $result['post_author'] = $user ? $user->ID : 0;
	$newitemID = wp_insert_post($newitem,true);
	
	// Error if item not created correctly
	if(is_wp_error($newitemID)){
    	header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	// iterate through $_REQUEST and create post meta as appropriate
	$type = $_REQUEST['type'];
	global $$type;
	$varnames = $$type->getVarNames();
	//die(print_r($varnames));
		
	foreach($varnames as $var){
		if($_REQUEST[$var]){
			update_post_meta($newitemID,$var,$_REQUEST[$var]);
			$result[$var] = $_REQUEST[$var];
		}
		$q = $$type->getQuestion($var);
		if($q['altfields']){
			foreach(explode(',', $q['altfields']) as $field){
				$result[$field] = $_REQUEST[$var];
			}
		}
	}
	
	// Send notification of item creation to supplied email
	if($_REQUEST['notify']){
		$allivion->notify($_REQUEST);
		$result['notifyuser'] = $_REQUEST['notify'];
	}
	
		
	// post-submission behaviour
	$result['formafter'] = $_REQUEST['formafter'];
	
	// If no logged in user, create cookie with $_REQUEST for registration prompt
	// unli = User Not Logged In
	if(!$user) {
		setcookie('allivion_unli',json_encode($result),time()+3600);
	}

	//echo json_encode($result); die();

	
	// Form submitted by AJAX
	if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$result['result'] = 'success';
		if($_REQUEST['success_message']){
			$result['message'] = $_REQUEST['success_message'];
		}

		if($_REQUEST['redirect']){
			$result['redirect'] = $_REQUEST['redirect'].'?i='.$newitemID.'&u='.$result['post_author'];
		}
		echo json_encode($result);
	
	// Form submitted by HTTP
	} else {
		if($_REQUEST['redirect']){
			header('Location: '.$_REQUEST['redirect'].'?i='.$newitemID.'&u='.$result['post_author']);
		} else {
			header('Location: '.$_SERVER['HTTP_REFERER'].'?u='.$result['post_author']);
		}
	}
		
	die();
	
}


add_action( 'init', 'directory_create_enqueue' );

function directory_create_enqueue() {
   wp_register_script( 'directory_create', WP_PLUGIN_URL.'/ibe-directory/js/directory_create.js', array('jquery') );
   wp_localize_script( 'directory_create', 'directory_create', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_create' );
}