<?php
	


/*
Template Name: FAQ
*/
	
get_header();

?>


<div class="container a2apad">
	<div class="row">
		<div class="col-md-12">

		<h1 class="purple">Frequently Asked Questions</h1>

			<h3>For job hunters</h3>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<?php

				$args = array('post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array(
											'taxonomy' => 'faqcategory',
											'field'    => 'slug',
											'terms'    => 'for-job-hunters',
										),
									),
					);

				$faqs = new WP_Query($args);


	
				while($faqs->have_posts() ) : $faqs->the_post(); ?>

				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading<?php echo $post->ID; ?>">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $post->ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $post->ID; ?>">
				          <?php the_title(); ?>
				        </a>
				      </h4>
				    </div>
				    <div id="collapse<?php echo $post->ID; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $post->ID; ?>" style="height: 0px;">
				      <div class="panel-body">
				        <?php the_content(); ?>
				      </div>
				    </div>
				  </div>

				
				<?php endwhile; ?>

				</div>

<!-- for Recruiters -->

		<h3>For recruiters</h3>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<?php

				$args = array('post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array(
											'taxonomy' => 'faqcategory',
											'field'    => 'slug',
											'terms'    => 'for-recruiters',
										),
									),
					);

				$faqs = new WP_Query($args);


	
				while($faqs->have_posts() ) : $faqs->the_post(); ?>

				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading<?php echo $post->ID; ?>">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $post->ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $post->ID; ?>">
				          <?php the_title(); ?>
				        </a>
				      </h4>
				    </div>
				    <div id="collapse<?php echo $post->ID; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $post->ID; ?>" style="height: 0px;">
				      <div class="panel-body">
				        <?php the_content(); ?>
				      </div>
				    </div>
				  </div>

				
				<?php endwhile; ?>

				</div>

<!-- for Annual Subscribers -->

		<h3>For Annual Subscribers</h3>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<?php

				$args = array('post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array(
											'taxonomy' => 'faqcategory',
											'field'    => 'slug',
											'terms'    => 'for-annual-subscribers',
										),
									),
					);

				$faqs = new WP_Query($args);


	
				while($faqs->have_posts() ) : $faqs->the_post(); ?>

				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading<?php echo $post->ID; ?>">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $post->ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $post->ID; ?>">
				          <?php the_title(); ?>
				        </a>
				      </h4>
				    </div>
				    <div id="collapse<?php echo $post->ID; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $post->ID; ?>" style="height: 0px;">
				      <div class="panel-body">
				        <?php the_content(); ?>
				      </div>
				    </div>
				  </div>

				
				<?php endwhile; ?>

				</div>



			</div>
		</div>

	</div>
</div>

<?php 
	
get_footer();

?>