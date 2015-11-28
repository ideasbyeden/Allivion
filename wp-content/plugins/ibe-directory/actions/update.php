<?php
	
add_action("wp_ajax_directory_update", "directory_update");

function directory_update(){
	
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_update_nonce')) {
      exit('You are not authorised to take this action');
	} 
	
	if(!$_REQUEST['post_id']) exit('No post ID was supplied');
	
	$type = $_REQUEST['type'];
	global $$type;
	$varnames = $$type->getVarNames();
	
	foreach($varnames as $var){
		$q = $$type->getQuestion($var);
		if($q['taxonomy']){
			if($_REQUEST[$var]) foreach($_REQUEST[$var] as $v){
				$term = get_term_by('slug',$v,$q['taxonomy']);
				$terms[] = $term->term_id;
			}
			wp_set_object_terms($_REQUEST['post_id'],$terms,$q['taxonomy']);
		} else {
			if(is_array($q['value']) && !is_array($_REQUEST[$var])){
				$_REQUEST[$var] = array($_REQUEST[$var]);
			}
			update_post_meta($_REQUEST['post_id'],$var,$_REQUEST[$var]);
		}
		$result[$var] = $_REQUEST[$var];
	}
	
	//if($_FILES) die('files found');
	if($_FILES) $$type->uploadFiles($_REQUEST['post_id']);
	

	if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($result);
	} else {
		if($_REQUEST['redirect']){
			header('Location: '.$_REQUEST['redirect']);
		} else {
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	
	die();
	
}



wp_register_script( 'directory_update', WP_PLUGIN_URL.'/ibe-directory/js/directory_update.js', array('jquery') );
wp_localize_script( 'directory_update', 'directory_update', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
wp_enqueue_script( 'directory_update' );