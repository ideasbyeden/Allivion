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
	
	// put this inside an call action on init?	
	public function setVars($vars){
		$this->vars = $vars;
	}
	
	public function getVars(){
		return $this->vars;
	}
	
	public function prepVars($vars = null){
		if(!$vars) return null;
		foreach($vars as $k=>$v){
			if($v != ''){
				$q = $this->getQuestion($k);
				if(is_array($q['value']) && !is_array($v)){
					$preppedVars[$k][] = $v;
				} else {
					$preppedVars[$k] = $v;
				}
			}
		}
		return $preppedVars ? $preppedVars : null;
	}
	
	public function getVarNames(){
		foreach($this->getVars() as $var){
			$names[] = $var['name'];
		}
		return $names;
	}
	
/*
	public function getVals($id){
		$vals = null;
		foreach(get_post_custom($id) as $k=>$v){
			$vals[$k] = $v[0];
		}
		return $vals;
	}
*/
	
	public function getVals($id){
		$vals = null;
		foreach($this->getVarNames() as $name){
			$q = $this->getQuestion($name);
			if($q['taxonomy']){
				$terms = wp_get_post_terms($id,$q['taxonomy']);
				foreach($terms as $term) $vals[$name][] = $term->slug;				 
			} else {
				$vals[$name] = get_post_meta($id,$name,true);
			}
		}
		return $vals;
	}
	
	public function addQuestion($args){
		array_push($this->vars, $args);
	}
	
	public function getGroup($groupname){
		if(is_array($this->vars)){
			foreach($this->vars as $var){
				if($var['group'] == $groupname){
					$group[] = $var;
				}
			}
		}
		return $group ? $group : false;
	}

	public function getQuestion($name){
		if(is_array($this->vars)){
			foreach($this->vars as $var){
				if($var['name'] == $name){
					return $var;
				}
			}
		}
		return false;
	}
	
	
	public function printQuestion($name,$value = null,$format = null,$add_blank = false){
		if($question = $this->getQuestion($name)){
			
			$value ? $value : ($question['value'] ? $question['value'] : '');
			$question['fieldtype'] = $format ? $format : $question['fieldtype'];
				
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
					//$output .= '<input type="hidden" name="richtext" value="true" />';
				break;
				
				case 'date':
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<input type="text" class="datepicker" ';
					$output .= $question['name'] ? 'name="'.$question['name'].'" ' : '';
					$output .= $question['placeholder'] ? 'placeholder="'.$question['placeholder'].'" ' : '';
					$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
					$output .= 'value="'.$value.'" ';
					$output .= '/>';
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
					if($question['addblank'] || $add_blank){
						$output .= '<option value="">'.$question['label'].'</option>';
					}
					foreach($question['value'] as $k=>$v){
						$output .= '<option value="'.$v['slug'].'" ';
						if($value == $v['slug']){
							$output .= 'SELECTED ';
						}
						$output .= '>'.$k.'</option>';
						if(isset($v['children'])) foreach ($v['children'] as $k=>$v){
							$output .= '<option value="'.$v['slug'].'" ';
							if($value == $v['slug']){
								$output .= 'SELECTED ';
							}
							$output .= '>- '.$k.'</option>';
						}
					}
					$output .= '</select>';
				break;
				
				case 'check':
					$l = 0;
					foreach($question['value'] as $k=>$v){
						if(strlen($k) > $l) $l = strlen($k);
					}
					$cols = round(40/$l, 0, PHP_ROUND_HALF_DOWN);
					$cols = $cols < 4 ? $cols : 4;
					
					$output .= $question['label'] ? '<label>'.$question['label'].'</label>' : '';
					$output .= $question['instructions'] ? '<p class="instructions">'.$question['instructions'].'</p>' : '';
					$output .= '<fieldset class="cc'.$cols.' ">';
					foreach($question['value'] as $k=>$v){
						$output .= '<p>';
						if($question['select_parent'] !== 'false'){
							$output .= '<input type="checkbox" value="'.$v['slug'].'" ';
							$output .= $question['name'] ? 'name="'.$question['name'].'[]" ' : '';
							$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
							if($value && in_array($v['slug'], $value)){
								$output .= 'CHECKED ';
							}
							$output .= '/>';
						}
						$output .= '<label>'.$k.'</label>';
						$output .= '</p>';

						if(isset($v['children'])) foreach($v['children'] as $k=>$v){
							$output .= '<p class="inset1">';
							$output .= '<input type="checkbox" value="'.$v['slug'].'" ';
							$output .= $question['name'] ? 'name="'.$question['name'].'[]" ' : '';
							$output .= $question['required'] ? 'required="'.$question['required'].'" ' : '';
							if($value && in_array($v['slug'], $value)){
							//if($v == $value){
								$output .= 'CHECKED ';
							}
							$output .= '/><label>'.$k.'</label>';
							$output .= '</p>';
						}


					}
					$output .= '</fieldset>';
				break;
				
/*
				case 'check':
					$output = '<pre>'.print_r($question['value'],true).'</pre>';
				break;
*/
				
				case 'radio':
					$l = 0;
					foreach($question['value'] as $k=>$v){
						if(strlen($k) > $l) $l = strlen($k);
					}
					$cols = round(40/$l, 0, PHP_ROUND_HALF_DOWN);
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

				case 'image':
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
		
		//echo '<pre>'; print_r($value); echo '</pre>';
		
		$q = $this->getQuestion($name);
		
		
		// is value defined by checkbox / radio
/*
		$value_arr = unserialize($value) ? unserialize($value) : $value;
		if(is_array($value_arr)) {
			$value = array_search($value_arr[0], $q['value']);
		}
*/
		if(is_array($value)){
			
			if(is_array($q['value'])){
				$foundkeys = array();
				foreach($value as $vitem){
					 if(is_array($vitem)) foreach($vitem as $i){
					
						foreach($q['value'] as $s=>$t){
							if($t['slug'] == $i){
								$foundkeys[] = $s;
							}
							if($t['children']) foreach($t['children'] as $f=>$g){
								if($g['slug'] == $i){
									$foundkeys[] = $f;
								}
							}
						}

					} else {
						
						foreach($q['value'] as $s=>$t){
							if($t['slug'] == $vitem){
								$foundkeys[] = $s;
							}
							if($t['children']) foreach($t['children'] as $f=>$g){
								if($g['slug'] == $vitem){
									$foundkeys[] = $f;
								}
							}
						}
						
					}
						//if($vitem == $v['slug']) $vstring .= $k.',';
						//$vstring .= array_search($vitem,array_column($q['value'],);

				}
				
				$value = implode(',&nbsp;', $foundkeys);
			} else {
				$value = $value[$name];
			}			
			
		}
		

		
		
		// create output
		$output .= '<p class="detail">';
		$output .= '<span class="detail_label">'.$q['label'].'</span>';
		$output .= '<span class="detail_value">'.$value.'</span>';
		$output .= '</p>';
		
		echo $output;
	}
	

	
	
	public function canAccess($args){
		
		//die(print_r($args));
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
			if($args['group_id'] != $user->ID && $args['group_id'] != $usermeta['group_id']) $redirect = true;
		}
		
		if($user->roles[0] == 'administrator') $redirect = false;
		
		if($redirect){ // access denied
			if($user){ // no user logged in
				if(rtrim($_SERVER['REQUEST_URI'],'/') != $$usertype->AdminRoot()){ // avoids redirect loop if usertype redirect doesn't specify access permission
					header("Location: ".$$usertype->AdminRoot());
					//header("Location: ".$_SERVER['HTTP_REFERER']);
				}
			} else {
				header("Location: ".DIRECTORY_LOGINPATH);
			}
		}
		
	}
	
	public function makeFolder($path){
		
		$folder = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_UPLOADPATH.ltrim($path.'\\');
		
		if (!file_exists($folder)) {
			$old = umask(0);
			$result = mkdir($folder,0777,true) ? $folder : false;
			umask($old);
			return $result;
		}
	}
	
	public function fileUpload($files,$path){
		
		$filelist = '';
		$result['completed_upload'] = TRUE;
		$result['uploaded_list'] = array();
		$result['failed_upload'] = array();
	

		foreach($files as $file) {
		
		    $file['name'] = preg_replace('/ /', '_', $file['name']);
			
			if (move_uploaded_file($file['tmp_name'],$path.$file['name'])) {
	           	$result['uploaded_list'][] = $path.$file['name'];
	        } else {
	        	$result['completed_upload'] = FALSE;
		        $result['failed_upload'][] = $file['name'];
	        }
	        	
		}
		

	}
	
	public function formAfter($params){
		
		/* PSEUDO
			
			Could have come from
			- a form processor function
			- login
			- a.n.other front end form
			
			Possible actions
			- hide/fadeout form
			- show a page element
			- refresh some page content
			- redirect
		
			Behaviour paramemeters
			- Submitted by AJAX or HTTP
			- Form action was success or fail
			
			Will need a syntax to carry all data in one field
			
			eg. formafter="hide,update:#contentarea,redirect:/myaccount"
			
			
		*/
		
		
		if(!$params['result']) return false;
		
		if($params['result'] == 'success'){
			if($params['subtype'] == 'AJAX' && $params['formafter']){
				
			}
			
			if($params['redirect']) {
				header('Location: '.$params['redirect']);
			} else {
				header('Location: '.$params['referer'].'?u='.$newuserID);
			}
			
			
		}
		
		if($params['result'] == 'fail'){
			
			
		}
		
		
	}
	
	public function notify($data){
		
		if(!$data['notify']) return false;
		
		// if the notify field does not contain an email address, get the value of the field named by notify
		if(strstr($data['notify'], '@')) {
			$to = $data['notify'];
		} else {
			$to = isset($data[$data['notify']]) ? $data[$data['notify']] : 'no email';
		}
		
		// if the $to does not contain a valid email address
		if (!filter_var($to, FILTER_VALIDATE_EMAIL)) return false;
	
		
		// build email body using template
		$template = $data['notify_template'] ? $data['notify_template'] : 'default';
		$body = file_get_contents(__DIR__ . '/email_templates/'.$template.'.php');
		foreach($data as $k=>$v){
			$body = preg_replace('/\['.$k.'\]/', $v, $body);
		}


		//error_log("To: ".$to.'; Subject: '.$data['notify_subject'].'; Body: '.$body);
			
		// send email
		$this->sendEmail($to,NOTIFY_EMAIL,$data['notify_subject'],$body);
	}
	
	public function sendEmail($toemail,$fromemail = APPLICATION_EMAIL,$subject,$body,$fromname = APPLICATION,$toname = null){
		
		$to = $toname ? $toname.' <'.$toemail.'>' : $toemail;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$fromname.' <'.$fromemail.'>'."\r\n";
		$option   = '-f '.$fromemail;
		
		mail($to, $subject, $body, $headers, $option);
	}
	
	
	public function encrypt($payload) {	
		$iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
		$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, CRYPTKEY, $payload, MCRYPT_MODE_CBC, $iv);
		$combo = $iv . $crypt;
		$garble = base64_encode($iv . $crypt);
		return $garble;
	}
	
	public function decrypt($garble) {
		$combo = base64_decode($garble);
		$iv = substr($combo, 0, IV_SIZE);
		$crypt = substr($combo, IV_SIZE, strlen($combo));
		$payload = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, CRYPTKEY, $crypt, MCRYPT_MODE_CBC, $iv);
		return $payload;
	}
	
	public function sort2d ($array, $index, $order='ASC', $natsort=TRUE, $case_sensitive=FALSE){
        if(is_array($array) && count($array)>0){
            foreach(array_keys($array) as $key)
                $temp[$key]=$array[$key][$index];
                if(!$natsort)($order=='ASC')? asort($temp) : arsort($temp);
                else {
                    ($case_sensitive)? natsort($temp) : natcasesort($temp);
                    if($order!='ASC') $temp=array_reverse($temp,TRUE);
                }
            foreach(array_keys($temp) as $key) (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
            return $sorted;
        }
        return $array;
    }

	
	public function getUsers($params){
		
		$users = new WP_User_Query();
		$users->results = array();
		
		$args = array(	'orderby' => 'name',
						'order' => 'ASC'
		);
		
		if($params['roles']){
			$roles = explode(',', $params['roles']);
			foreach($roles as $role){
				$args['role'] = $role;
				$result = new WP_User_Query($args);
				$users->results = array_merge($users->results,$result->results);
				$users->count_total = $users->count_total + $result->count_total;
			}
		}
		
		return $users;
		
	}
	

	
}