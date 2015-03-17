<?php
	
add_action("wp_ajax_nopriv_directory_login", "directory_login");

function directory_login(){
		
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'directory_login_nonce')) {
      exit('You are not authorised to take this action');
	} 

    $info = array();
    $info['user_login'] = $_REQUEST['username'];
    $info['user_password'] = $_REQUEST['password'];
    $info['remember'] = true;

    $user = wp_signon( $info, false );
    if (!is_wp_error($user) ){
        echo json_encode($user);
    } else {
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    }

	die();
	
}


add_action( 'init', 'directory_login_enqueue' );

function directory_login_enqueue() {
   wp_register_script( 'directory_login', WP_PLUGIN_URL.'/ibe-directory/js/directory_login.js', array('jquery') );
   wp_localize_script( 'directory_login', 'directory_login', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_login' );
}