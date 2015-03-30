<?php

class directoryCore {
	
	public $vars = array();
	public $adminroot = '/';
	
	function __construct(){	
		
	}
	
	public function setAdminRoot($ar){
		$this->adminroot = $ar;
	}
	
	public function AdminRoot(){
		return $this->adminroot;
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
				
				case 'hidden':
					$output .= '<input type="hidden" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= 'value="'.$value.'" ';
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
	
	public function printDetail($name,$value = null){
		
		$q = $this->getQuestion($name);
		
		// is single value or full vals array passed
		if(is_array($value)) $value = $value[$name];
		
		// is value defined by checkbox / radio
		$value_arr = unserialize($value);
		if(is_array($value_arr)) {
			$value = array_search($value_arr[0], $q['value']);
		}
		
		// create output
		$output .= '<p class="detail">';
		$output .= '<span class="detail_label">'.$q['label'].'</span>';
		$output .= '<span class="detail_value">'.$value.'</span>';
		$output .= '</p>';
		
		echo $output;
	}
	
	
	public function canAccess($args){
		
		global $user, $usermeta;
		$usertype = $user->roles[0];
		global $$usertype;
				
		if(!$user) $redirect = true;
		
		if($args['roles']) {
			$roles = explode(',', $args['roles']);
			if(!in_array($user->roles[0], $roles)) $redirect = true;
		}
		
		if($args['id']) {
			$ids = explode(',', $args['id']);
			if(!in_array($user->ID, $ids)) $redirect = true;
		}
		
		if($args['group_id']) {
			if($args['group_id'] != $user->ID && $args['group_id'] != $usermeta['group_id'][0]) $redirect = true;
		}
		
		if($user->roles[0] == 'administrator') $redirect = false;
		
		if($redirect){ // access denied
			if($user){ // no user logged in
				if(rtrim($_SERVER['REQUEST_URI'],'/') != $$usertype->AdminRoot()){ // avoids redirect loop if usertype redirect doesn't specify access permission
					header("Location: ".$$usertype->AdminRoot());
				}
			} else {
				header("Location: ".DIRECTORY_LOGINPATH);
			}
		}
		
	}
	
}