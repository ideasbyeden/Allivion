<?php
	
add_action("wp_ajax_nopriv_directory_update", "directory_login_redirect");
add_action("wp_ajax_nopriv_directory_search", "directory_login_redirect");

function directory_login_redirect(){
	header("Location: ".$_SERVER["SERVER_NAME"]);
	die();
}