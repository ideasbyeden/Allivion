<?php
	
add_action("wp_ajax_directory_search", "directory_search");
add_action("wp_ajax_nopriv_directory_search", "directory_search"); // will need to be redirected to login or similar

function directory_search($params = null){
		
	foreach($_REQUEST as $k=>$v) $params[$k] = $v;
			
	$type = post_type_exists($params['type']) ? $params['type'] : 'post';
	global $$type;
	$vars = $$type->getVarNames();

	// set up basic query args
	
	$query_args = array(	'post_type' => $type,
							'orderby' => 'date',
							'order' => 'ASC'
							); 
	
	if($params['author']) $query_args['author'] = $params['author'];
	
	// remove unexpected search variables
	
	$clean_params = array();
	foreach($params as $k=>$v){
		if(in_array($k, $vars)){
			$clean_params[$k] = $v;
		}
	}

							
	// set meta query for each valid search param
		
	foreach($clean_params as $k=>$v){
			$query_args['meta_query'][] = array(
				'key' => $k,
				'value' => $v,
				'compare' => '='	
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
	

	
	// run WP query
	
	$result = new WP_Query($query_args);
	
	
	// push meta values into post object
	
	for($i=0; $i<count($result->posts); $i++){
		
		$meta = get_post_custom( $result->posts[$i]->ID );
		foreach($meta as $k=>$v){
			$cleanmeta[$k] = $v[0];
		}
		$result->posts[$i]->meta = $cleanmeta;
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