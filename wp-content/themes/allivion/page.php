<?php
	
get_header();

echo '<h1>Page.php</h1>';
	
while (have_posts()) { 
		the_post();
		the_content();
}

get_footer();