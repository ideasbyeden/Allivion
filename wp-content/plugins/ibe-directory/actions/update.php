<?php
	
add_action("wp_ajax_directory_update", "directory_update");

function directory_update(){
	
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_update_nonce')) {
      exit('You are not authorised to take this action');
	} 
	
	if(!$_REQUEST['post_id']) exit('No post ID was supplied');
	
	$type = $_REQUEST['type'];
	$varnames = $$type->getVarNames();
	
	foreach($varnames as $var){
		update_post_meta($_REQUEST['post_id'],$var,$_REQUEST[$var]);
		$result[$var] = $_REQUEST[$var];
	}
	

	if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($result);
	} else {
		header("Location: ".$_SERVER["HTTP_REFERER"]);
	}
	
	die();
	
}


add_action( 'init', 'directory_update_enqueue' );

function directory_update_enqueue() {
   wp_register_script( 'directory_update', WP_PLUGIN_URL.'/ibe-directory/js/directory_update.js', array('jquery') );
   wp_localize_script( 'directory_update', 'directory_update', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_update' );
}