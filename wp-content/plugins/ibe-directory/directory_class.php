<?php

class itemdef {
	
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
	    
	    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ), 99 );
	}
	
	public function enqueue_script() {
		
		wp_enqueue_script( 'formsubmit', plugins_url('ibe-directory/js/form-submit-ajax.js', false ));
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
	
	public function setVars($vars){
		$this->vars = $vars;
	}
	
	public function getVars(){
		return $this->vars;
	}
	
	public function getVarNames(){
		foreach($this->getVars() as $var){
			$names[] = $var['name'];
		}
		return $names;
	}
	
	public function getVals($id){
		foreach(get_post_custom($id) as $k=>$v){
			$vals[$k] = $v[0];
		}
		return $vals;
	}
	
	public function addQuestion($args){
		array_push($this->vars, $args);
	}
	
	public function getGroup($groupname){
		foreach($this->vars as $var){
			if($var['group'] == $groupname){
				$group[] = $var;
			}
		}
		return $group ? $group : false;
	}

	public function getQuestion($name){
		foreach($this->vars as $var){
			if($var['name'] == $name){
				return $var;
			}
		}
		return false;
	}
	
	
	public function printQuestion($name,$value = null){
		if($question = $this->getQuestion($name)){
			
			$value ? $value : ($question['value'] ? $question['value'] : '');
				
			switch($question['fieldtype']){
				
				case 'text':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<input type="text" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= 'value="'.$value.'" ';
					$output .= '/>';
				break;

				case 'textarea':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<textarea ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= '>'.$value.'</textarea>';
				break;

				case 'richtext':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<textarea class="richtext" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= '>'.$value.'</textarea>';
				break;
				
				case 'email':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<input type="email" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= 'value="'.$value.'" ';
					$output .= '/>';
				break;
				
				case 'password':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<input type="password" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= 'value="'.$value.'" ';
					$output .= '/>';
				break;
				
				case 'dropdown':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<select ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= '>';
					foreach($question['value'] as $k=>$v){
						$output .= '<option value="'.$v.'" ';
						if($value == $v){
							$output .= 'SELECTED ';
						}
						$output .= '>'.$k.'</option>';
					}
					$output .= '</select>';
				break;
				
				case 'check':
					$l = 0;
					foreach($question['value'] as $k=>$v){
						if(strlen($k) > $l) $l = strlen($k);
					}
					$cols = round(50/$l, 0, PHP_ROUND_HALF_DOWN);
					$cols = $cols < 4 ? $cols : 4;
					
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<fieldset class="cc'.$cols.' ">';
					foreach($question['value'] as $k=>$v){
						$output .= '<p>';
						$output .= '<input type="checkbox" value="'.$v.'" ';
						$output .= $question['name'] ? 'name="'.$question['name'].'[]" ' : '';
						$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
						if($value && in_array($v, unserialize($value))){
						//if($v == $value){
							$output .= 'CHECKED ';
						}
						$output .= '/><label>'.$k.'</label>';
						$output .= '</p>';
					}
					$output .= '</fieldset>';
				break;
				
				case 'radio':
					$l = 0;
					foreach($question['value'] as $k=>$v){
						if(strlen($k) > $l) $l = strlen($k);
					}
					$cols = round(50/$l, 0, PHP_ROUND_HALF_DOWN);
					$cols = $cols < 4 ? $cols : 4;

					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<fieldset class="cc'.$cols.' ">';
					foreach($question['value'] as $k=>$v){
						$output .= '<input type="radio" value="'.$v.' ';
						$output .= $question['name'] ? 'name="'.$question['name'].'[]" ' : '';
						$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
						if(in_array($v, $value)){
							$output .= 'CHECKED ';
						}
						$output .= '/><label>'.$k.'</label>';
					}
					$output .= '</fieldset>';
				break;

				case 'file':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<input type="file" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= '/>';
				break;
				
				
			}
			
			$el_class = $question['extra_class'] ? $question['extra_class'] : '';
			echo '<div class="question '.$el_class.'">'.$output.'</div>';

		} else {

			echo 'Question not found';

		}
	}
	
	public function printGroup($groupname,$vals = null){
		$group = $this->getGroup($groupname);
		if($group){
			foreach($group as $question) $this->printQuestion($question['name'],$vals[$question['name']]);
		}
	}
	
	public function canEdit($post_id = null){

		if(!is_user_logged_in()){
			header("Location: ".DIRECTORY_LOGINPATH);
			die();
		}
		
		if($post_id){
			if(get_post_field( 'post_author', $post_id ) != wp_get_current_user()->ID){
				header("Location: ".DIRECTORY_ACCOUNTPATH);
				die();
			}
		}
	}
	
}