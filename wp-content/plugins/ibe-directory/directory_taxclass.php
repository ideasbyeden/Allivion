<?php

class taxdef extends directoryCore {
	
	public $type;
	public $label;
	public $single_label;
	public $items;
	public $terms;

	function __construct($type,$label,$single_label,$items,$terms){
		$this->type = $type;
		$this->label = $label;
		$this->single_label = $single_label;
		$this->items = $items;
		$this->terms = $terms;
		
		if( ! taxonomy_exists( $this->type ) )
	    {
	        add_action( 'init', array( $this, 'addTaxonomy' ), 0 );
	        add_action( 'init', array( $this, 'addTerms' ) , 10);
	        //do_action('doterms' , $this->terms);
	    }
	    
	}
		
	public function addTaxonomy(){
						
		register_taxonomy($this->type,$this->items,array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( ucfirst($this->label), 'taxonomy general name' ),
				'singular_name' => _x( ucfirst($this->single_label), 'taxonomy singular name' ),
				'search_items' =>  __( 'Search '.$this->label ),
				'all_items' => __( 'All '.$this->label ),
				'parent_item' => __( 'Parent '.$this->single_label ),
				'parent_item_colon' => __( 'Parent '.$this->single_label.':' ),
				'edit_item' => __( 'Edit '.$this->single_label ), 
				'update_item' => __( 'Update '.$this->single_label ),
				'add_new_item' => __( 'Add new '.$this->single_label ),
				'new_item_name' => __( 'New '.$this->single_label.' name' ),
				'menu_name' => __( ucfirst($this->single_label) )
			),
			'show_ui' => true,
			'query_var' => true
		));
			
	}
	
	public function addTerms($terms = NULL,$parent = NULL){
				
		$args = NULL;
		if(!$terms) $terms = $this->terms; // Could be improved?
		
		foreach($terms as $k=>$v){
			//if(!term_exists($k,$this->type)){
				
				if($parent) $args['parent'] = $parent;
				if(!is_array($v)) $args['slug'] = $v;

/*
				if($args){
					$term_reg = wp_insert_term($k,$this->type,$args);
				} else {
					$term_reg = wp_insert_term($k,$this->type);					
				}
*/

				//echo '<pre>'; print_r($args); echo '</pre>';

				if(is_array($v)) $this->addTerms($v,$term_reg->term_taxonomy_id);
			
			//}
		}
		
	}
		
}