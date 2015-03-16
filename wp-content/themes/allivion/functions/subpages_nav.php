<?php
				 
function subpages_nav() {

	global $post, $thispage;
	
	$thispage = $post->ID;
	$thisparent = $post->post_parent;
	
	$children = get_pages('child_of='.$thispage);
	if( count( $children ) == 0 && $thisparent != 0) { 
	
	// list siblings
	$args = array (	'post_type' => 'page',
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'post_parent' => $thisparent
					);
	
	} else {
	
	// list children
	$args = array (	'post_type' => 'page',
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'post_parent' => $thispage
					);
					
	} ;
					
	 
	$subpages = new WP_Query($args);
	
	if($subpages->post_count > 0) {
	
		global $subnav; $subnav = 'true';
		
		echo '<div id="subnav"><ul>';
		
		while( $subpages->have_posts() ) : $subpages->the_post();
		
			$liclass  = "post-count-".$subpages->current_post; 
			if ($subpages->current_post == 0) $liclass .= ' first'; 
			if ($subpages->post_count == $subpages->current_post+1) $liclass .= ' last';
			if ($subpages->post->ID == $thispage) $liclass .= ' current';
					
			echo '<li class="'.$liclass.'"><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			
		endwhile;
		wp_reset_postdata();
		echo '</ul></div>';
	}

}

?>