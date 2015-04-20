<?php
	
add_action("wp_ajax_jsapi", "jsapi");
add_action("wp_ajax_nopriv_jsapi", "jsapi");

function jsapi(){

	$type = $_POST['type'];
	global $$type;
	
	if($_POST['method'] == 'getquestion'){
		if(!$_POST['name']) return false;
		echo json_encode($$type->getQuestion($_POST['name']));	
		exit();
	}

}