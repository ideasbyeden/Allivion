<?php
	
add_action("wp_ajax_directory_create", "directory_create");
add_action("wp_ajax_nopriv_directory_create", "directory_create");

function directory_create(){
	
		
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_create_nonce')) {
      exit('You are not authorised to take this action');
	} 
	
	$newitem = array(	'post_type' => $_REQUEST['type'],
						'post_title' => $_REQUEST[POSTTITLEFIELD],
						'post_author' => $user->ID,
						'post_status' => 'publish'
							);
							
	global $user;
	$newitem['post_author'] = $user ? $user->ID : 0;

							
	$newitemID = wp_insert_post($newitem);
	
	$type = $_REQUEST['type'];
	global $$type;
	$varnames = $$type->getVarNames();
	
	//die(print_r($varnames));
	
	foreach($varnames as $var){
		if($_REQUEST[$var]){
			update_post_meta($newitemID,$var,$_REQUEST[$var]);
			$result[$var] = $_REQUEST[$var];
		}
	}
	
	
	if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$result['result'] = 'success';
		if($_REQUEST['success_message']){
			$result['message'] = $_REQUEST['success_message'];
		}
		if($_REQUEST['redirect']){
			$result['redirect'] = $_REQUEST['redirect'].'?i='.$newitemID;
		}
		echo json_encode($result);
	} else {
		if($_REQUEST['redirect']){
			header('Location: '.$_REQUEST['redirect'].'?i='.$newitemID);
		} else {
			header('Location: '.$_SERVER['HTTP_REFERER']);
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