

<?php
	
get_header();

?>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-9">


			<?php
	
				while(have_posts() ) : the_post(); ?>
				
					<h2 class="purple"><?php the_title(); ?></h2>

					<?php the_content(); ?>

				
				<?php endwhile; ?>



		</div>
		<div class="col-md-3" id="sidebar">
			<?php dynamic_sidebar('blog_sidebar'); ?>
		</div>
	</div>
</div>

<?php 
	
get_footer();

?>