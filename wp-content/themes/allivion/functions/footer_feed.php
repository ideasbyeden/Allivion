<?php

function footer_feed(){
	
	$args = array('posts_per_page' => 4);
	
	$feed = new WP_Query($args);
	
	while($feed->have_posts()) : $feed->the_post();
	
	$catstring = '';
	$cats = get_the_category();
	foreach($cats as $category) $catstring .=  $category->cat_name.', ';
	?>
	
	
	<div class="feeditem <?php echo $cats[0]->slug; ?>">
		<h5><?php the_title(); ?></h5>
		<p><?php echo 'Posted by '.get_the_author().' on '.get_the_time('jS F, Y').' in '.rtrim($catstring,', '); ?>
	</div>
	
	<?php

	endwhile; wp_reset_postdata();
	
}