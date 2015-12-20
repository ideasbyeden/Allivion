<?php
	
add_action("wp_ajax_directory_search", "directory_search");
add_action("wp_ajax_nopriv_directory_search", "directory_search"); 

function directory_search($params = null){
		
	if($_REQUEST) foreach($_REQUEST as $k=>$v) $params[$k] = $v;
	
	
	if($params['encrypted']){
		global $dircore;
		parse_str($dircore->decrypt($params['encrypted']),$safeparams);
		$params = array_merge($params,$safeparams);
	}
	

			
	$type = post_type_exists($params['type']) ? $params['type'] : 'post';
	global $$type;
	$vars = $$type->getVarNames();
	
	$params = $$type->prepVars($params);


	$order = $params['order'] ? $params['order'] : 'DESC';


	// set up basic query args
	$query_args = array(	'post_type' => $type,
							'orderby' => 'date',
							'order' => $order
							); 
	
	if($params['author']) $query_args['author'] = $params['author'];

	
	// add ordering if requested
	if($params['orderby']){
		$query_args['meta_key']	= $params['orderby'];
		$query_args['orderby'] = 'meta_value';
	}
	
	// remove unexpected search variables
	if($params){
		$clean_params = array();
		foreach($params as $k=>$v){
			if(in_array($k, $vars) && $v != ''){
				// (below) supports individual search values presented as array but not multiple values within a search field
				$clean_params[$k] = is_array($v) ? $v[0] : $v; 
			}
		}
	}

	// check which params have multichoice answers
	if($clean_params){
		$mc_params = array();
		foreach($clean_params as $k=>$v){
			$q = $$type->getQuestion($k);
			if(is_array($q['value'])){
				$mc_params[] = $k;
			}
		}
	}		

	// set meta query for each valid search param
	foreach($clean_params as $k=>$v){
		
			$q = $$type->getQuestion($k);
			
			if($q['taxonomy']){
				
				$query_args['tax_query'][] = array( 'taxonomy' => $q['taxonomy'],
													'field' => 'slug',
													'terms' => $v
													);
				
			} else {
				
		
					
	
				if(strstr($v, '!')){
					$v = preg_replace('@!@','',$v);
					if(in_array($k, $mc_params)){
						$compare = 'NOT LIKE';
						$v = '"'.$v.'"';
					} else {
						$compare = '!=';
					}
					
				} else if(strstr($v, '<')) {
					$v = preg_replace('@<@','',$v);
					$compare = '<';
				
					
					
				} else  {
					if(in_array($k, $mc_params)){
						$compare = 'LIKE';
						$v = '"'.$v.'"';
					} else {
						$compare = '=';
					}
				}
			
				$query_args['meta_query'][] = array(
					'key' => $k,
					'value' => $v,
					'compare' => $compare,
					'type' => $fieldtype	
				);
			
			}
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
	
	//die(print_r($query_args));
	//echo '<pre>'; print_r($params); echo '</pre>';
	//echo '<pre>'; print_r($query_args); echo '</pre>';

	
	// run WP query
	$result = new WP_Query($query_args);
	
	//setup posts array
	$posts = array();
	
	// push meta values into post object
	for($i=0; $i<count($result->posts); $i++){
		$cleanmeta = array();
		$thispost = $result->posts[$i];
		$meta = get_post_custom( $thispost->ID );
		foreach($meta as $k=>$v){
			
			$foundkeys = array();
			$q = $$type->getQuestion($k);
			
			if($q['fieldtype'] == 'date') {
				if($v[0]){
					$v[0] = formatDate($v[0],$q);
					$datearr = explode(' ', $v[0]);
					$cleanmeta[$k.'_day'] = $datearr[0];
					$cleanmeta[$k.'_month'] = $datearr[1];
					$cleanmeta[$k.'_year'] = $datearr[2];
				}
			}
			



			// converts salary string to currency format
			// needs better interception of strings already formatted
			// Causes explosion on testing server
/*
			if($k == 'salary_details' && $v[0]){
				$currcode = unserialize($meta['salary_currency'][0]);
				$currsym = $$type->getCurrencySymbol('en_GB',$currcode[0]);
				$salval = preg_replace("/[^0-9.]/", "", $v[0]);
				$v[0] = $$currsym.number_format(floatval($salval),0,'.',',');
			}
*/
			
			$cleanmeta[$k] = unserialize($v[0]) ? unserialize($v[0]) : $v[0];
		}
		$thispost->meta = $cleanmeta;
		
		//push author meta into post object
		$cleanauthormeta = array();
		$authormeta = get_user_meta($thispost->post_author);
		foreach($authormeta as $k=>$v){
			$cleanauthormeta[$k] = unserialize($v[0]) ? unserialize($v[0]) : $v[0];
			$q = $$type->getQuestion($k);
			if($q['fieldtype'] == 'image'){
				foreach($cleanauthormeta[$k] as $img){
					$src = wp_get_attachment_image_src($img,'full');
					$cleanauthormeta[$k.'_image'][] = '<img src="'.$src[0].'" />';
				}
			}
		}
		$thispost->authormeta = $cleanauthormeta;
		
		//push group meta into post object
		
		//$groupid = $thispost->meta['group_id'] ? $thispost->meta['group_id'] : $thispost->post_author;
		$groupmeta = get_user_meta($thispost->meta['group_id']);
		
		if(!$role){
			$querieduser = new WP_User($thispost->meta['group_id']);
			$role = $querieduser->roles[0];
			global $$role;
		}

		$cleangroupmeta = array();
		foreach($groupmeta as $k=>$v){
			$cleangroupmeta[$k] = unserialize($v[0]) ? unserialize($v[0]) : $v[0];


			$q = $$role->getQuestion($k);
			if($q['fieldtype'] == 'image'){
				if(is_array($cleangroupmeta[$k])){
					foreach($cleangroupmeta[$k] as $img){
						$src = wp_get_attachment_image_src($img,'full');
						$cleangroupmeta[$k.'_image'][] = '<img src="'.$src[0].'" />';
					}
				}
			}


		}
		$thispost->groupmeta = $cleangroupmeta;
		
		//push all taxonomy terms into post object
		foreach(get_taxonomies() as $tax){
			$terms = wp_get_post_terms($thispost->ID,$tax);
			if(count($terms > 0)){
				$terms_arr = array();
				foreach($terms as $term){ $terms_arr[] = (array)$term; }
				$cleanterms[$tax] = $terms_arr;
			}
		}
		$thispost->terms = $cleanterms;
		
		// update returned in search count
		if($params['inc_search_count'] == 'true'){
			$search_count = get_post_meta($thispost->ID,'search_count',true);
			//echo 'found post '.$thispost->ID.' with post count '.$search_count;
			if($search_count != ''){
				update_post_meta($thispost->ID,'search_count',intval($search_count)+1);
			} else {
				update_post_meta($thispost->ID,'search_count','1');
			}
		}
		
		// build posts array with promoted items first
		// this smacks of business logic...
		
		if($thispost->meta['promote'][0] == $params['industry'] && $thispost->meta['promote_enabled'][0] != '' && $thispost->meta['ad_type'][0] == 'sponsored'){
			array_unshift($posts, $thispost);	
		} else {
			$posts[] = $thispost;
		}


	}
	
	// add new posts array back into returned object
	$result->posts = $posts;
	
	//if(count($result->posts) == 0) $result['query'] = $query_args;
	
	// choose return path (AJAX or HTTP)
	if($_POST){
		if($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			echo json_encode($result);
		} else {
			header('Location: '.strtok($_SERVER["HTTP_REFERER"],'?').'?'.http_build_query($clean_params, '', '&amp;'));
		}		
	} else {
		return $result;
	}
	
	die();
	
}



wp_register_script( 'directory_search', WP_PLUGIN_URL.'/ibe-directory/js/directory_search.js', array('jquery') );
wp_localize_script( 'directory_search', 'directory_search', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
wp_enqueue_script( 'directory_search' );
