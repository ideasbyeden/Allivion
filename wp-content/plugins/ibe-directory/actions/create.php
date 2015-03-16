<?php
	
add_action("wp_ajax_directory_create", "directory_create");

function directory_create(){
		
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_create_nonce')) {
      exit('You are not authorised to take this action');
	} 
	
	$newitem = array(	'post_type' => $_REQUEST['type'],
						'post_title' => $_REQUEST[TITLEFIELD],
						'post_author' => wp_get_current_user()->ID,
						'post_status' => 'publish'
							);
							
	$newitemID = wp_insert_post($newitem);
	
	foreach(explode(',', $_REQUEST['varnames']) as $var){
		update_post_meta($newitemID,$var,$_REQUEST[$var]);
	}

	if($_REQUEST['redirect']){
		header('Location: '.$_REQUEST['redirect'].'?i='.$newitemID);
	} else {
		die('You did not specify where to go after your item was created. Simply add <input type="hidden" name="redirect" value="/mypage" /> to your form. Do not include any query strings');
	}
	
	die();
	
}


//add_action( 'init', 'directory_create_enqueue' );

function directory_create_enqueue() {
   wp_register_script( 'directory_create', WP_PLUGIN_URL.'/ibe-directory/js/directory_create.js', array('jquery') );
   wp_localize_script( 'directory_create', 'directory_create', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_create' );
}