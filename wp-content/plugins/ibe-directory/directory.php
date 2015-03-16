<?php 
	
/* 
Plugin Name: ibe Directory 
Description: 
Version: 1.0 
Author: IBE Creative 
*/

require_once('config.php');
require_once('directory_class.php');
require_once('user_functions.php');

global $wp_rewrite;

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

add_action( 'init', 'directory_enqueue' );

function directory_enqueue() {

   wp_register_script( 'directory_core', WP_PLUGIN_URL.'/ibe-directory/js/directory_core.js', array('jquery') );
   wp_enqueue_script( 'directory_core' );

}