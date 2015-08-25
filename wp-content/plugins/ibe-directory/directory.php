<?php 
	
/* 
Plugin Name: ibe Directory 
Description: 
Version: 1.0 
Author: IBE Creative 
*/

require_once('config.php');
require_once('directory_coreclass.php');
require_once('directory_itemclass.php');
require_once('directory_userclass.php');
require_once('directory_taxclass.php');
require_once('user_functions.php');
require_once('item_functions.php');
require_once('dev_functions.php');
require_once('jsapi.php');


global $wp_rewrite;
$dircore = new directoryCore();

foreach(glob(__DIR__ . '/itemdefs/*.php') as $filename)
{
    include($filename);
    global $$type;
    $$type = new itemdef($type,$label,$single_label);
    $$type->setVars($vars);
}

foreach(glob(__DIR__ . '/actions/*.php') as $filename)
{
    include($filename);
}

foreach(glob(__DIR__ . '/userdefs/*.php') as $filename)
{
    include($filename);
    global $$role;
    $$role = new userdef($role,$label);
    $$role->setVars($vars);
    $$role->setAdminRoot($adminroot);
}

foreach(glob(__DIR__ . '/taxdefs/*.php') as $filename)
{
    include($filename);
    global $$type;
    $$type = new taxdef($type,$label,$single_label,$items,$terms);
}



function directory_enqueue() {

   wp_register_script( 'directory_core', WP_PLUGIN_URL.'/ibe-directory/js/directory_core.js', array('jquery') );
   wp_enqueue_script( 'directory_core' );
   
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

}

add_action( 'init', 'directory_enqueue' );

function directoryGetUser(){
	global $user, $usermeta, $wp_roles;
	$user = $usermeta = null;
	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$user_custom = get_user_meta($user->ID);
		foreach($user_custom as $k=>$v){
			$usermeta[$k] = count($v) == 1 ? $v[0] : $v;
		}
		if(!$usermeta['group_id']) $usermeta['group_id'] = $user->ID;
	}
}

add_action( 'init', 'directoryGetUser' );

function directory_deactivate(){
	foreach(glob(__DIR__ . '/userdefs/*.php') as $filename)
	{
	    remove_role( strtok($filename, '.') );
	}

}

register_deactivation_hook( __FILE__, 'directory_deactivate' );