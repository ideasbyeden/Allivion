<?php

///////////////////////////////////////////// excerpt functions ///////////////////////////////////////////////


// excerpt length
function new_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'new_excerpt_length');

 
// excerpt more
function custom_excerpt($text) {  // custom 'read more' link
   if (strpos($text, '[...]')) {
      $excerpt = strip_tags(str_replace('[...]', '...<a href="'.get_permalink().'">Read more</a>', $text), "<a>");
   } else {
      $excerpt = '' . strip_tags($text) . '...<a href="'.get_permalink().'">Read more</a>';
   }
   return $excerpt;
}
add_filter('the_excerpt', 'custom_excerpt');


// custom excerpt function with word count control and without read more link 
function excerpt_nomore($id,$limit = null) {
	$post_object = get_post($id);
	if(!$limit) { $limit = 25; }
	$excerpt = explode(' ', $post_object->post_content, $limit);
	if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
	} else {
	$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}


// add excerpt function to pages
add_action( 'init', 'add_excerpts_to_pages' );
function add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}


///////////////////////////////////////////// menu and navigation functions ///////////////////////////////////////////////



// enable wordpress menus
register_nav_menus( array(
	'main' => 'Main Navigation',
	'recadmin' => 'Recruiter Navigation',
	'advadmin' => 'Advertiser Navigation',
	'candadmin' => 'Candidate Navigation',
	'sysadmin' => 'Sysadmin Navigation'
) );


// add last_item class to last li in wp_nav_menu lists
function add_last_item_class($strHTML) {
	$intPos = strripos($strHTML,'menu-item');
	printf("%s last_item %s",
		substr($strHTML,0,$intPos),
		substr($strHTML,$intPos,strlen($strHTML))
	);
}
add_filter('wp_nav_menu','add_last_item_class');

// add login / logout items to end of nav
function loginout_menu_link($items) {
	global $user, $usermeta;
	if ($user) {
		$items .= '<li class="fr purple"><a href="'. wp_logout_url('/index.php') .'">Log Out</a></li>';
	} else {
		$items .= '<li class="fr purple"><a href="/log-in" id="show_login">Log In</a></li>';
	}
   return $items;
}

add_filter( 'wp_nav_menu_items', 'loginout_menu_link', 10, 2 );


// add post job to main navigation (if recruiter)
function postjob_menu_link($items) {
	global $user, $usermeta;
	if ($user && ($user->roles[0] == 'recruiter_admin' || $user->roles[0] == 'recruiter')) {
		$items .= '<li class="fr purple"><a href="/recruiter_dashboard">Post a job</a></li>';
	}
	return $items;
}

add_filter( 'wp_nav_menu_items', 'postjob_menu_link', 10, 2 );


// add logo to admin nav
function menu_logo( $items, $args ) {
	if ($args->theme_location == 'recadmin' || $args->theme_location == 'sysadmin') {
		$items = '<li class="nav_logo"><a href="/"><img src="'.get_bloginfo('template_url').'/img/nav_logo.png" /></a></li>'.$items;
	}
    return $items;
}

add_filter( 'wp_nav_menu_items', 'menu_logo', 10, 2 );


//add_filter( 'wp_nav_menu_items', 'loginout_menu_link', 10, 2 );



///////////////////////////////////////////// image functions ///////////////////////////////////////////////


// thumbnails and image sizes
add_theme_support( 'post-thumbnails' );
add_image_size('tinythumb', 50, 50);


// remove default image link
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);


// remove width and height atts from placed images
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );


///////////////////////////////////////////// sidebar functions ///////////////////////////////////////////////


// register dynamic sidebars
$sidebar0 = array(
	'name'          => sprintf(__('Sidebar'), $i ),
	'id'            => 'sidebar0',
	'description'   => '',
	'before_widget' => '<li>',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );

register_sidebar( $sidebar0 );	


///////////////////////////////////////////// CPT and taxonomy functions ///////////////////////////////////////////////




///////////////////////////////////////////// user and security functions ///////////////////////////////////////////////


// disable admin bar for users (except admin)
add_action('init', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}


// disallow access to wp-admin for non admins
add_action( 'admin_init', 'redirect_non_admin_users' );
function redirect_non_admin_users() {
	if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
		wp_redirect( home_url() );
		exit;
	}
}


// remove WordPress version from header
remove_action('wp_header', 'wp_generator');



///////////////////////////////////////////// script functions ///////////////////////////////////////////////

wp_enqueue_script('jquery');


///////////////////////////////////////////// load other functions ///////////////////////////////////////////////


include ('functions/columns.php');
include ('functions/footer_feed.php');
include ('functions/news.php');
include ('functions/subpages_nav.php');

?>