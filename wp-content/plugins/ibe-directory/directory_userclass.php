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
			
}