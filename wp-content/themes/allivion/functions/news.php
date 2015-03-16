<?php

function news() { 

	$args = array( 'post_type' => 'news',
					'posts_per_page' => -1
	
	);
			
	$news = new WP_Query($args);
	
	echo '<h2>News</h2>';
	
	while( $news->have_posts() ) : $news->the_post(); ?>
	
		<div class="newsitem">
		<?php the_post_thumbnail(); ?>
		<h4><?php the_title(); ?></h4>
		<p class="news-excerpt"><?php the_excerpt(); ?></p>
		</div>

	<? endwhile;
	wp_reset_postdata();
}

?>