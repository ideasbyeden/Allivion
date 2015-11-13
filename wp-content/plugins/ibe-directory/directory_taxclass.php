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
	        $this->addTaxonomy();
	        
			if(!get_option('_dir_taxonomies_imported')) {
	        	$this->addTerms();
				add_option('_dir_taxonomies_imported',1);
			}
	        	
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
	
	public function addTerms($terms = NULL,$parent = 0){
		
		
			$args = NULL;
			
			// start with terms array from taxdef
			if(!$terms) $terms = $this->terms; // Could be improved?
	
			foreach($terms as $k=>$v){
				
				if(!is_array($v)) {
					$args = array('slug' => $v,
								  'parent' => $parent
								 );
					if(!term_exists($k,$this->type)) $term_reg = wp_insert_term($k,$this->type,$args);
				} else {
					if(!term_exists($k,$this->type)){
						$term_reg = wp_insert_term($k,$this->type);
					} else {
						$term_reg = term_exists($k,$this->type);
					}
					$this->addTerms($v,$term_reg['term_id']);
				}
	
			}
			
		
		//}
		
	}
	
	public function getTerms(){
		

		if(taxonomy_exists($this->type)){
			return get_terms($this->type,array( 'hide_empty' => 0 ));
		} else {
			return array('taxonomy not created','true');
		}
		
	}
	
	
	public function taxTree(){
		


		$taxterms = get_terms($this->type,array( 'hide_empty' => 0, 'parent' => 0 ));


		if(count($taxterms > 0)){
			foreach($taxterms as $term){
				$varr = array('id' => $term->term_id,'slug' => $term->slug);
				// recursive
				$children = get_term_children($term->term_id,$this->type);
				if(count($children) > 0){
					foreach($children as $child){
						$cterm = get_term($child,$this->type);
						$varr['children'][$cterm->name] = array('id' => $child,'slug' => $cterm->slug);
					}
				}
				// end recursive
				$taxtree[$term->name] = $varr;
			}
		}
		
		
		return $taxtree;

		
		
	}
	
}