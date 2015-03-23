<?php

class userdef extends directoryCore {
	
	public $role;
	public $label;
	public $vars = array();

	function __construct($role,$label){
		$this->role = $role;
		$this->label = $label;
		
		if( ! get_role( $this->role ) ) {
	        add_action( 'init', array( &$this, 'register_role' ) );
	    }
	    
	    $this->remove_wp_roles();
	    
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
					
		add_role( $role, $label, $caps );
		
	}
	
	public function remove_wp_roles(){
		remove_role( 'subscriber' );
		remove_role( 'editor' );
		remove_role( 'author' );
		remove_role( 'contributor' );
	}
	
	public function getVals(){
		
		global $user, $usermeta;
		foreach($usermeta as $k=>$v){
			$vals[$k] = $v[0];
		}
		$vals['user'] = $user;
		return $vals;
	}
	
	public function canEdit($edit_user_id = null){

		if(!is_user_logged_in()){
			header("Location: ".DIRECTORY_LOGINPATH);
			die();
		}
		
		if($edit_user_id && is_int($edit_user_id)){
			global $user, $usermeta;
			$edit_usermeta = get_user_meta($edit_user_id);

			if($user->ID != $edit_user_id &&  !in_array($user->ID, $edit_usermeta['group_id'])){
				if($user['roles'][0] == 'recruiter' || $user['roles'][0] == 'recruiter_admin') { header("Location: ".DIRECTORY_RECADMIN); }
				else if($user['roles'][0] == 'advertiser' ) { header("Location: ".DIRECTORY_ADVADMIN); }
				else if($user['roles'][0] == 'candidate' ) { header("Location: ".DIRECTORY_CANDADMIN); }
				else { header("Location: ".DIRECTORY_LOGINPATH); }
				die();
			}
		}
	}
		
}