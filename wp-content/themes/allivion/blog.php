<?php
	


/*
Template Name: Blog
*/


	
get_header();

?>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-12">

<?php
	
while (have_posts()) { 
		the_post();
		the_content();
}

?>

		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			
			<?php
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => -1,
					'cat' => 5
				);
				
				$blogroll = new WP_Query($args);
				while($blogroll->have_posts() ) : $blogroll->the_post(); ?>
				
				<div class="post-item" id="post-<?php echo $post->ID; ?>">
					<h3 class="purple"><?php the_title(); ?></h3>
					<?php the_content(); ?>
				</div>
				
				<?php endwhile; wp_reset_postdata(); ?>
			
			
			
		</div>		
	</div>
</div>

<?php 
	
get_footer();

?>