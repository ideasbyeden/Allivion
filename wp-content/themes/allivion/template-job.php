<?php
	


/*
Template Name: Job
Post Template: Job
*/


if(!$_REQUEST['i'] || !$job->itemExists($_REQUEST['i'])) header("Location: /index.php");

include(TEMPLATEPATH.'/includes/LinkedInGetAuth.php');
include(TEMPLATEPATH.'/includes/linkedin.php');



	
get_template_part('header');
	
while (have_posts()) { 
		the_post();
		the_content();
} 

/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Data for job being displayed
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

// Data for employer
$employer = $_REQUEST['i'] ? $recruiter->getVals(get_post_meta($_REQUEST['i'],'group_id',true)) : null;
//echo '<pre>'; print_r($employer); echo '</pre>';

// Data for logged in user to autopopulate
$uservals['first_name'] = $usermeta['first_name'];
$uservals['last_name'] = $usermeta['last_name'];
$uservals['email'] = $user->user_email;


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////


?>

<div class="container">
	<div class="row">
		
		
		<div class="col-md-12">

			<div>
				<?php
					if($vals['ad_type'][0] && $vals['ad_type'][0] != 'standard' && $employer['brand_header']){
						foreach(unserialize($employer['brand_header']) as $image_id) echo '<span id="brand_header">'.wp_get_attachment_image($image_id,'brand_header').'</span>';						
					} else if($employer['logo']) {
						foreach(unserialize($employer['logo']) as $image_id) echo '<span id="logo">'.wp_get_attachment_image($image_id,'recruiter_icon_small').'</span>';
					} ?>
			</div>					
			<h1 class="purple"><?php echo $vals['job_title']; echo $vals['location'] ? ', '.$vals['location'] : ''; ?></h1>
			
			<hr>

			<h4><span id="employer"><?php echo $employer['recruiter_name']; ?></span></h6>
			<h4>
				<span id="salary_details">
					<?php
						echo $job->getCurrencySymbol('en_GB',$vals['salary_currency'][0]);
						echo $vals['salary_details'] ? number_format($vals['salary_details'],0,'.',',') : 'Salary'; ?>
				</span>
			</h6>
			<div>
				<span id="full_description">
					<?php if($vals['ad_type'][0] == 'standard'){
							echo $vals['full_description_limited'] ? $vals['full_description_limited'] : 'Job description'; 
						} else {
							echo $vals['full_description'] ? $vals['full_description'] : 'Job description'; 
						}							
						?>
				</span>
			</div>
			
			<div class="clear" style="margin-bottom: 50px;"></div>

			<form class="directory <?php echo $job->type; ?> create application-form" id="job" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
				<input type="hidden" name="post_id" value="<?php echo $_REQUEST['i']; ?>" />
				<input type="hidden" name="type" value="<?php echo $application->getItemType(); ?>" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_create" />
				<input type="hidden" name="notify" value="<?php echo $employer['default_app_email']; ?>" />
				<input type="hidden" name="notify_subject" value="New application" />
				<input type="hidden" name="notify_template" value="new_application" />
 				<input type="hidden" name="success_message" value="Your application has been submitted" />
 				<input type="hidden" name="formafter" value="hide" />
				
				<div class="qpanel tabbed">
					<h3 class="purple" style="margin-top: 0px;">Apply now</h3>
<!--
					<ul class="tabs">
						<li class="active">Application form</li>
						<?php if(!$user) echo '<li><a href="/log-in" class="show_login" redirect="'.$_SERVER['REQUEST_URI'].'">Log in</a></li>'; ?>
						<li><a href="?linkedin=login">Apply with LinkedIn</a></li>
					</ul>
-->
					
					<?php if(!$user) { ?>
					<h4>Already registered?</h4>
					<p><a href="/log-in" class="show_login" redirect="<?php echo $_SERVER['REQUEST_URI']; ?>">Click here to login and autocomplete this form</a></p>
					<?php } ?>

					<?php $application->printGroup('headline',$uservals); ?>
					<?php $application->printQuestion('job_id',$_REQUEST['i']); ?>
					<?php $application->printQuestion('job_title',$vals['job_title']); ?>
					<?php $application->printQuestion('job_ref',$vals['job_ref']); ?>
					<input type="submit" value="Submit application" />
					<div class="clear"></div>
				</div>

			</form>

			<p class="message"></p>
			
			<form class="directory" id="register_prompt" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" style="display:none;">
			 	
			 	<input type="hidden" name="role" value="candidate" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_user_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_create_user" />
 				<input type="hidden" name="redirect" value="/candidate-dashboard" />
 				<input type="hidden" name="autologin" value="true" />
				
				<div class="qpanel">
					<h4>Why not save your details for next time?</h4>
					<p>By registering with Allivion, your profile can be searched by potential employers</p>
					<?php $candidate->printGroup('basics',json_decode($_COOKIE['allivion_unli'])); ?>
					<input type="submit" value="Register" />
				</div>				
			</form>
		
			
		</div><!-- end threeqtrscol -->
		


		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>