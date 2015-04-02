<?php
	
add_action("wp_ajax_directory_search", "directory_search");
add_action("wp_ajax_nopriv_directory_search", "directory_search"); // will need to be redirected to login or similar

function directory_search($params = null){
		
	foreach($_REQUEST as $k=>$v) $params[$k] = $v;
	
	if($params['encrypted']){
		global $dircore;
		parse_str($dircore->decrypt($params['encrypted']),$safeparams);
		$params = array_merge($params,$safeparams);
	}
	
	
			
	$type = post_type_exists($params['type']) ? $params['type'] : 'post';
	global $$type;
	$vars = $$type->getVarNames();

	// set up basic query args
	$query_args = array(	'post_type' => $type,
							'orderby' => 'date',
							'order' => 'DESC'
							); 
	
	if($params['author']) $query_args['author'] = $params['author'];

	
	// remove unexpected search variables
	$clean_params = array();
	foreach($params as $k=>$v){
		if(in_array($k, $vars) && $v != ''){
			$clean_params[$k] = $v;
		}
	}

							
	// set meta query for each valid search param
	foreach($clean_params as $k=>$v){
			$compare = strstr($v, '!') ? '!=' : '=';
			$query_args['meta_query'][] = array(
				'key' => $k,
				'value' => preg_replace('@!@','',$v),
				'compare' => $compare	
			);
	}
	
	//echo '<pre>'; print_r($user); echo '</pre>';
	
	// wpdb keyword search
	//
	// Currently searches all non system meta fields
	// next version: loop through $job->getVars to build get_col query for specified fields only
	

	if($params['keywords'] && $params['keywords'] != ''){
		global $wpdb;
		$keywords = sanitize_text_field( $params['keywords'] );
		$post_ids_meta = $wpdb->get_col( " SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key NOT LIKE '\_%' AND meta_value LIKE '%".mysql_real_escape_string($keywords)."%'" );
		$query_args['post__in'] = $post_ids_meta;
	}
	
	//die(print_r($params));

	
	// run WP query
	$result = new WP_Query($query_args);
	
	
	// push meta values into post object
	for($i=0; $i<count($result->posts); $i++){
		$cleanmeta = array();
		$thispost = $result->posts[$i];
		$meta = get_post_custom( $thispost->ID );
		foreach($meta as $k=>$v){
			$cleanmeta[$k] = $v[0];
		}
		$thispost->meta = $cleanmeta;
		
		
		// update returned in search count
		if($params['inc_search_count']){
			$search_count = get_post_meta($thispost->ID,'search_count',true);
			//echo 'found post '.$thispost->ID.' with post count '.$search_count;
			if($search_count != ''){
				update_post_meta($thispost->ID,'search_count',intval($search_count)+1);
			} else {
				update_post_meta($thispost->ID,'search_count','1');
			}
		}
		
	}
	

	
	// choose return path (AJAX or HTTP)
	if($_POST){
		if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			echo json_encode($result);
		} else {
			echo 'request exists';
			header('Location: '.strtok($_SERVER["HTTP_REFERER"],'?').'?'.http_build_query($clean_params, '', '&amp;'));
		}		
	} else {
		return $result;
	}
	
	die();
	
}



add_action( 'init', 'directory_search_enqueue' );

function directory_search_enqueue() {

   wp_register_script( 'directory_search', WP_PLUGIN_URL.'/ibe-directory/js/directory_search.js', array('jquery') );
   wp_localize_script( 'directory_search', 'directory_search', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'directory_search' );

}