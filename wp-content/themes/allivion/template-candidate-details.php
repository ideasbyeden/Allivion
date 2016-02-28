<?php

/*
Template Name: Candidate details
*/

$dircore->canAccess(array('roles' => 'recruiter_admin,recruiter'));
	
get_template_part('header','recadmin');

$vals = $_REQUEST['i'] ? $candidate->getVals($_REQUEST['i']) : null;
//echo '<pre>'; print_r($vals); echo '</pre>';

	
while (have_posts()) { 
		the_post();
		the_content();


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

//echo '<pre>'; print_r($usermeta); echo '</pre>';

?>

<div class="container a2apad">
	
<!-- 			<pre><?php print_r($usermeta); ?></pre> -->

	<div class="row">
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>
		</div>
		<div class="col-md-4" style="text-align: right;">
				<form class="directory candidate notify" id="candidate_enquiry" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
					
					<?php
						$secured = array(
										'type' => 'candidate',
										'user_id' => $_REQUEST['i'],
										'cv_intro' => $vals['cv_intro'],
										'notify' => SYSADMIN_EMAIL,
										'requester_id' => $user->ID,
										'requester_email' => $user->user_email
									);
									
						$secured = http_build_query($secured);
											
					 ?>
			 	
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_notify"); ?>" />
					<input type="hidden" name="action" value="directory_notify" />
					<input type="hidden" name="successmessage" value="We have received your request and will be in touch shortly" />
					<input type="hidden" name="notify_subject" value="Candidate enquiry" />
					<input type="hidden" name="notify_template" value="candidate_enquiry" />
					<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt($secured); ?>" />
	 				<input type="submit" class="btn btn-default" value="Buy this CV" />
				</form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">

				<h3 class="purple">Summary</h3>
				<?php echo $vals['cv_summary']; ?>
				
				<h3 class="purple">Introduction</h3>
				<?php echo $vals['cv_intro']; ?>
				
				<h3 class="purple">Career History</h3>
				<?php echo $vals['cv_positions']; ?>

				<h3 class="purple">Education</h3>
				<?php echo $vals['cv_education']; ?>

				<h3 class="purple">Interests</h3>
				<?php echo $vals['cv_interests']; ?>



			</div>
		</div>
			

			
			<div class="clear"></div>

			
			
		
		<div class="clear"></div>
		
	</div>
</div>

<?php } get_footer(); ?>