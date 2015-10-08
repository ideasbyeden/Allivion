<?php

class userdef extends directoryCore {
	
	public $role;
	public $label;

	function __construct($role,$label){
		$this->role = $role;
		$this->label = $label;
		
		$this->register_role();
		add_filter( 'editable_roles', 'exclude_role' );
	    
	}


	
	public function register_role(){
		
		$caps = array(	'delete_posts' => true,
				'delete_published_posts' => true,
				'edit_posts' => true,
				'edit_published_posts' => true,
				'publish_posts' => true,
				'read' => true,
				'upload_files' => true
				);
				
					
		add_role( $this->role, $this->label, $caps );
		
	}
	
	function exclude_role($roles) {

	    if (isset($roles['author'])) {
	      unset($roles['author']);
	    }

		if (isset($roles['editor'])) {
	      unset($roles['editor']);
	    }

		if (isset($roles['subscriber'])) {
	      unset($roles['subscriber']);
	    }

		if (isset($roles['contributor'])) {
	      unset($roles['contributor']);
	    }

	    return $roles;
	    
	}
	
	public function getVals($user_id = null){

		global $user, $usermeta;
		if(!$user && (!$user_id || $user_id == 0)) {
			return false;
		}
		
		if($user_id){
			foreach(get_user_meta($user_id) as $k=>$v){
				$vals[$k] = $v[0];
			}
			$vals['user'] = get_user_by('id',$user_id);
			
		} else {
			foreach($usermeta as $k=>$v){
				$vals[$k] = $v[0];
			}
			$vals['user'] = $user;
		}
		return $vals;
		
	}
	
	function getUsers($params){
				
		if($params['keywords']) 	$args['search'] = $_REQUEST['keywords'];
		if($params['ID'])			$args['include'] = array($_REQUEST['ID']);

		// set up core user data (stored in wp_users)
		$valid = array('ID','user_pass','user_login','user_nicename','user_url','user_email','display_name','nickname','first_name','last_name','description','rich_editing','user_registered','role','jabber','aim','yim');
			
		// set up user meta data
		$varnames = $$role->getVarNames();
		$validmeta = array_diff($varnames,$valid);
		
		foreach(array_filter($_REQUEST) as $k=>$v){ 
			if(in_array($k, $validmeta)){
				$args['meta_query'][] = array('key' => $k,'value' => $v,'compare' => '=');
			}
		}
		
		die(print_r($args));
		
	}
			
}