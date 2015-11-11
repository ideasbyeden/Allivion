<?php
	
add_action("wp_ajax_jsapi", "jsapi");
add_action("wp_ajax_nopriv_jsapi", "jsapi");

function jsapi(){

	$type = $_POST['type'];
	global $$type;
	
	if($_POST['method'] == 'getquestion'){
		if(!$_POST['name']) return false;
		
		$result['question'] = $$type->getQuestion($_POST['name']);
		
		if($_POST['value'] && $result['question']){
			if(is_array($result['question']['value'])){
				$result['value'] = $$type->taxArraySearch($_POST['value'],$result['question']['value']);
			} else {
				$result['value'] = $_POST['value'];
			}
		}
		
		echo 'Found value: '.$result['value'].' endfound';

		echo json_encode($result);
		exit();
	}
	
	if($_POST['method'] == 'time2str'){
		if(!$_POST['date']) return false;
		echo json_encode(time2str($_POST['date']));	
		exit();
	}

}