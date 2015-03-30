<?php

class userdef extends directoryCore {
	
	public $role;
	public $label;

	function __construct($role,$label){
		$this->role = $role;
		$this->label = $label;
		
		//if( ! get_role( $this->role ) ) {
	        add_action( 'init', array( &$this, 'register_role' ) );
	    //}
	    
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
				
					
		add_role( $this->role, $this->label, $caps );
		
	}
	
	public function remove_wp_roles(){
		remove_role( 'subscriber' );
		remove_role( 'editor' );
		remove_role( 'author' );
		remove_role( 'contributor' );
	}
	
	public function getVals($user_id = null){
		
		if($user_id){
			foreach(get_user_meta($user_id) as $k=>$v){
				$vals[$k] = $v[0];
			}
			$vals['user'] = get_user_by('id',$user_id);
			
		} else {
			global $user, $usermeta;
			foreach($usermeta as $k=>$v){
				$vals[$k] = $v[0];
			}
			$vals['user'] = $user;
		}
		return $vals;
		
	}
			
}