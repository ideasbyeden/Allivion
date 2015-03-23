<?php

class itemdef extends directoryCore {
	
	public $type;
	public $label;
	public $single_label;
	public $vars = array();

	function __construct($type,$label,$single_label){
		$this->type = $type;
		$this->label = $label;
		$this->single_label = $single_label;
		
		if( ! post_type_exists( $this->type ) )
	    {
	        add_action( 'init', array( &$this, 'register_cpt' ) );
	    }
	    
	}
	
	public function getItemType(){
		return $this->type;
	}
	
	public function register_cpt(){
		
		register_post_type($this->type, array(
	        'labels' => array(
	            'name' => ucfirst($this->label),
	            'singular_name' => ucfirst($this->single_label),
	            'add_new' => 'Add new '.$this->single_label,
	            'edit_item' => 'Edit '.$this->single_label,
	            'new_item' => 'New '.$this->single_label,
	            'view_item' => 'View '.$this->single_label,
	            'search_items' => 'Search '.$this->label,
	            'not_found' => 'No '.$this->label.' found',
	            'not_found_in_trash' => 'No '.$this->label.' found in Trash'
	        ),
	        'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array( 'slug' => $this->label, 'with_front' => true ),
			'query_var' => true,
	        'supports' => array(
	            'title',
	            'editor',
	            'excerpt',
	            'thumbnail',
	            'custom-fields',
	            'page-attributes'
	        )
		));
		
	}
		
}