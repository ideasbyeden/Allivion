<?php
	
//$dircore->canAccess(array('roles' => 'recruiter_admin'));
//
// Should this only allow access for non-logged in users?
	
session_start();


/*
Template Name: Host a visit
*/

//header('Location: '.admin_url('admin-ajax.php'));

	
get_header();
	



/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results



/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="container a2apad">
	<div class="row">
		
		<div class="col-md-6">
			<?php while (have_posts()) { 
		the_post(); ?>
			<h1 class="purple" style="margin-bottom: 0px !important;"><?php the_title(); ?></h1>

		<?php the_content(); 
} ?>
			
		</div>
		
			<div class="col-md-6">
			<div class="qpanel">
			<h2 class="purple">Host a visit</h2>

				<form class="directory notify" id="host_enquiry" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
					

			 	
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_notify"); ?>" />
					<input type="hidden" name="action" value="directory_notify" />
					<input type="hidden" name="successmessage" value="Thank you for your enquiry. We will be in touch shortly." />
					<input type="hidden" name="notify" value="<?php echo NOTIFY_EMAIL; ?>" />
					<input type="hidden" name="notify_subject" value="Host a visit" />
					<input type="hidden" name="notify_template" value="host_visit" />
					<div class="question">
					<label style="width: 100%">Your name</label>
					<input type="text" name="hoster_name" placeholder="Your name" style="width: 100%; margin-bottom: 6px" required/>
					</div>
					<div class="question">
					<label style="width: 100%">Your job title</label>
					<input type="text" name="hoster_jobtitle" placeholder="Your job title" style="width: 100%; margin-bottom: 6px" required/>
					</div>
					<div class="question">
					<label style="width: 100%">Your email</label>
					<input type="email" name="hoster_email" placeholder="Your email" style="width: 100%; margin-bottom: 6px" required/>
					</div>
					<div class="question">
					<label style="width: 100%">Your contact number</label>
					<input type="text" name="hoster_contactno" placeholder="Your contact number" style="width: 100%; margin-bottom: 6px" required/>
					</div>
					<div class="question">
					<label style="width: 100%">Your organisation</label>
					<input type="text" name="hoster_organisation" placeholder="Your organisation" style="width: 100%; margin-bottom: 6px"/ required>
					</div>
					<div class="question">
					<label style="width: 100%">Your message</label>
					<textarea name="hoster_message" placeholder="Your message"></textarea>
					</div>
	 				<input type="submit" class="btn btn-default" value="Send" />
				</form>
				
			</div>
			
						
			<div class="clear"></div>
			
			
<!-- 			<pre>Search results: <?php print_r($items); ?></pre> -->
				

		</div>
		
	</div>
</div>

<?php get_footer(); ?>

<script>
	jQuery(function(){
		jQuery('select[name="role"]').change(function(){
			var dd = jQuery(this);
			jQuery('.'+dd.val()).fadeIn();
			dd.find('option:not(:selected)').each(function(){
				var hideclass = jQuery(this).val();
				//hideclass = this.val();
				jQuery('.'+hideclass).fadeOut();
			});
		});
	});
	
</script>