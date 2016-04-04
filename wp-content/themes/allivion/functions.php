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
	'secondary' => 'Secondary Navigation',
	'recadmin' => 'Recruiter Admin Navigation',
	'recadminannual' => 'Recruiter Admin Navigation (annual)',
	'recruiter' => 'Recruiter Navigation',
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
//add_filter('wp_nav_menu','add_last_item_class');

// add login / logout items to end of nav
function loginout_menu_link($items,$args) {
    if($args->theme_location != 'secondary'){
		global $user, $usermeta;
		if ($user) {
			$items .= '<li class="fr purple"><a href="'. wp_logout_url('/index.php') .'">Log Out</a></li>';
			if($user->roles[0] == 'administrator') $items .= '<li class="fr purple"><a href="'. DIRECTORY_SYSADMIN .'">Dashboard</a></li>';
			if($user->roles[0] == 'recruiter_admin') $items .= '<li class="fr purple"><a href="'. DIRECTORY_RECADMIN .'">Dashboard</a></li>';
			if($user->roles[0] == 'recruiter') $items .= '<li class="fr purple"><a href="'. DIRECTORY_RECADMIN .'">Dashboard</a></li>';
			if($user->roles[0] == 'candidate') $items .= '<li class="fr purple"><a href="'. DIRECTORY_CANDADMIN .'">Dashboard</a></li>';
		} else {
			$items .= '<li class="fr purple"><a href="/log-in" class="show_login">Log In</a></li>';
			$items .= '<li class="fr purple"><a href="/register">Register</a></li>';
		}
	}
   return $items;
}

add_filter( 'wp_nav_menu_items', 'loginout_menu_link', 10, 2 );


// add post job to main navigation (if recruiter)
function postjob_menu_link($items,$args) {
    if($args->theme_location != 'secondary'){
		global $user, $usermeta;
		if ($user && ($user->roles[0] == 'recruiter_admin' || $user->roles[0] == 'recruiter')) {
			$items .= '<li class="fr purple"><a href="/recruiter-dashboard">Post a job</a></li>';
		} 
		if (!$user) {
			$items .= '<li class="fr purple"><a href="/log-in" class="show_login">Post a job</a></li>';
		} 
	}
	return $items;
}

add_filter( 'wp_nav_menu_items', 'postjob_menu_link', 10, 2 );


// add logo to admin nav
function menu_logo( $items, $args ) {
    if($args->theme_location != 'secondary' && $args->theme_location != 'main'){
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
add_image_size('smallthumb', 80, 80);
add_image_size('recruiter_icon', 300, 300);
add_image_size('recruiter_icon_small', 150, 150);
add_image_size('recruiter_icon_large', 600, 200);
add_image_size('brand_header', 9999, 150);


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

// remove width and height atts from placed images
function remove_width_attribute_ga( $attr ) {
   $attr['width'] = $attr['height'] = '';
   return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'remove_width_attribute_ga', 10);

function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span class="caption">'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}

///////////////////////////////////////////// sidebar functions ///////////////////////////////////////////////


// register dynamic sidebars
for($s=1; $s<=6; $s++){
	$footer = array(
		'name'          => sprintf(__('Footer Column '.$s), $i ),
		'id'            => 'footer_col'.$s,
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '' );
	register_sidebar( $footer );	
}

$blog_sidebar = array(
		'name'          => sprintf(__('Blog Sidebar'), $i ),
		'id'            => 'blog_sidebar',
		'description'   => '',
		'before_widget' => '<div class="qpanel">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="hide">',
		'after_title'   => '</span>' );
	register_sidebar( $blog_sidebar );


// cats sidebar widget
add_filter('widget_categories_args','show_empty_categories_links');
function show_empty_categories_links($args) {

	// show empty cats
	$args['hide_empty'] = 0;

	// exclude uncategorized
	$exclude_arr = array( 1 );
	if( isset( $args['exclude'] ) && !empty( $args['exclude'] ) ) 
		$exclude_arr = array_unique( array_merge( explode( ',', $args['exclude'] ), $exclude_arr ) );
	$args['exclude'] = implode( ',', $exclude_arr );

	return $args;

}



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

function bootstrap_enqueue() {
    wp_register_script( 'bootstrap-js', get_bloginfo('template_url').'/js/bootstrap.min.js', array('jquery'), NULL, true );
    wp_register_script( 'bootstrap-tabcollapse', get_bloginfo('template_url').'/js/bootstrap-tabcollapse.js', array('jquery'), NULL, true );
    wp_register_style( 'bootstrap-css', get_bloginfo('template_url').'/css/bootstrap.min.css', false, NULL, 'all' );

    wp_enqueue_script( 'bootstrap-js' );
    wp_enqueue_script( 'bootstrap-tabcollapse' );
    wp_enqueue_style( 'bootstrap-css' );
}
add_action( 'wp_enqueue_scripts', 'bootstrap_enqueue' );


function scripts_enqueue() {
    wp_register_script( 'moment', get_bloginfo('template_url').'/js/moment.js', array('jquery'), NULL, true );
    wp_enqueue_script( 'moment' );

    wp_enqueue_script( 'tiny_mce' );
    if (function_exists('wp_tiny_mce')) wp_tiny_mce();
    
    wp_register_script( 'mixpanel', get_bloginfo('template_url').'/js/mixpanel.js', array('jquery'), NULL, true );
    wp_enqueue_script( 'mixpanel' );
    
    
}
add_action( 'wp_enqueue_scripts', 'scripts_enqueue' );


/*
add_filter( 'tiny_mce_before_init', 'wpse24113_tiny_mce_before_init' );
function wpse24113_tiny_mce_before_init( $initArray )
    {
        $initArray['setup'] = "
                [function(ed) {
                ed.onKeyDown.add(function(ed, e) {
                   if(tinyMCE.activeEditor.editorId=='full_description_limited') {
	                   console.log('tracking editor');
                        countChar(tinyMCE.activeEditor.getContent());
                     }
                });
            }][0]
            ";
    return $initArray;
    }
*/



///////////////////////////////////////////// load other functions ///////////////////////////////////////////////


include ('functions/columns.php');
include ('functions/footer_feed.php');
include ('functions/news.php');
include ('functions/subpages_nav.php');
include ('functions/taxtree.php');

?>