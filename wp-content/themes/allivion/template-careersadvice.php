<?php
	
/*
Template Name: Careers advice
*/
	
get_header();

?>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-9">

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
		<div class="col-md-3">
			<?php dynamic_sidebar('blog_sidebar'); ?>
		</div>
	</div>
</div>

<?php 
	
get_footer();

?>