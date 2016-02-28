<?php

/*
Template Name: Unsubscribe
*/
	
get_template_part('header'); ?>

<?php /*
		Need to pass the id of the unsubscriber, and a security check - md5 of email address?
	*/
	
	?>
	
<?php $subscription = new subscription('jobalert');	 ?>

<?php get_footer(); ?>