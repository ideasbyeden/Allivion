<?php
	
	function getGroupUsers($group_id = null){
		
		if(!$group_id){
			$meta_group_id = get_user_meta(wp_get_current_user()->ID,'group_id',true);
			$group_id = $meta_group_id != '' ? $meta_group_id : wp_get_current_user()->ID;
		}
		
		//return 'group_users';
		return new WP_User_Query(array('meta_key' => 'group_id', 'meta_value' => $group_id));
		
	}