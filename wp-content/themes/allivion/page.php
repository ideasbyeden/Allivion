<?php
	
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
</div>

<?php 
	
get_footer();

?>