<?php
	
get_header();

echo '<h1>Page.php</h1>';


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