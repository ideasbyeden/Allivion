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
	'candadmin' => 'Candidate Navigation'
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
      if (is_user_logged_in()) {
         $items .= '<li class="fr purple"><a href="'. wp_logout_url('/index.php') .'">Log Out</a></li>';
      } else {
         $items .= '<li class="fr purple"><a href="/log-in" id="show_login">Log In</a></li>';
      }
   return $items;
}

add_filter( 'wp_nav_menu_items', 'loginout_menu_link', 10, 2 );

function menu_logo( $items, $args ) {
	if ($args->theme_location == 'recadmin') {
		$items = '<li class="nav_logo"><img src="'.get_bloginfo('template_url').'/img/nav_logo.png" /></li>'.$items;
	}
    return $items;
}

add_filter( 'wp_nav_menu_items', 'menu_logo', 10, 2 );


//add_filter( 'wp_nav_menu_items', 'loginout_menu_link', 10, 2 );



///////////////////////////////////////////// image functions ///////////////////////////////////////////////


// thumbnails and image sizes
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 60, 60, true );
add_image_size('newsize', 230, 9999);


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


// register new post type
add_action('init', 'project_register_post_type');

function project_register_post_type() {
    register_post_type('project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'add_new' => 'Add new project',
            'edit_item' => 'Edit project',
            'new_item' => 'New project',
            'view_item' => 'View project',
            'search_items' => 'Search projects',
            'not_found' => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash'
        ),
        'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'projects', 'with_front' => true ),
		'query_var' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'custom-fields',
            'comments',
            'page-attributes'
        ),
        'taxonomies' => array('projecttype')
    ));
}

// register new taxonomy
add_action( 'init', 'register_projecttype_taxonomy', 0 );

function register_projecttype_taxonomy() {
  register_taxonomy('projecttype','project', array(
    'hierarchical' => true,
    'labels' => array(
	    'name' => _x( 'Projects types', 'taxonomy general name' ),
	    'singular_name' => _x( 'Project type', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search project types' ),
	    'all_items' => __( 'All project types' ),
	    'parent_item' => __( 'Parent project type' ),
	    'parent_item_colon' => __( 'Parent project type:' ),
	    'edit_item' => __( 'Edit project type' ), 
	    'update_item' => __( 'Update project type' ),
	    'add_new_item' => __( 'Add new project type' ),
	    'new_item_name' => __( 'New project type name' ),
	    'menu_name' => __( 'Project type' )
	    ),
    'show_ui' => true,
    'query_var' => true
  ));

}


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


//create new user roles
$caps = array(	'delete_posts' => true,
				'delete_published_posts' => true,
				'edit_posts' => true,
				'edit_published_posts' => true,
				'publish_posts' => true,
				'read' => true,
				'upload_files' => true
				);
					
add_role( 'recruiter', 'Recruiter', $caps );
add_role( 'recruiter_admin', 'Recruiter admin', $caps );
add_role( 'advertiser', 'Advertiser', $caps );
add_role( 'candidate', 'Candidate', $caps );

///////////////////////////////////////////// script functions ///////////////////////////////////////////////

wp_enqueue_script('jquery');


///////////////////////////////////////////// load other functions ///////////////////////////////////////////////


include ('functions/columns.php');
include ('functions/footer_feed.php');
include ('functions/news.php');
include ('functions/subpages_nav.php');

?>