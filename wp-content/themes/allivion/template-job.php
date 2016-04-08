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
//echo '<pre>'; print_r($employer['user']->ID); echo '</pre>';

// Data for logged in user to autopopulate
$uservals['first_name'] = $usermeta['first_name'];
$uservals['last_name'] = $usermeta['last_name'];
$uservals['email'] = $user->user_email;

/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

$adtype = $vals['ad_type'][0] ? $vals['ad_type'][0] : 'standard';

?>

<div class="container-fluid a2apad single-job-<?php echo $adtype; ?>">
<div class="container">
	<div class="row">
	
		
		<div class="col-md-8">
			<a href="" class="back btn btn-default">
			<i class="fa fa-arrow-left"></i> Back to search results
			</a>
			<div class="whitepanel">

			<div>
				<?php
					if($vals['ad_type'][0] && $vals['ad_type'][0] != 'standard' && $employer['brand_header']){
						foreach($employer['brand_header'] as $image_id) echo '<a href="/jobs/?group_id='.$employer['user']->ID.'"><span id="brand_header">'.wp_get_attachment_image($image_id,'brand_header').'</span></a>';						
					} else if($employer['logo']) {
						echo '<a href="/jobs/?group_id='.$employer['user']->ID.'"><span id="brand_logo">'.wp_get_attachment_image($employer['logo'][0],'recruiter_icon_large').'</span></a>';
					} ?>
			</div>					
			<h1 class="purple"><?php echo $vals['job_title']; ?></h1>
			<h4>
				<span id="employer"><strong><?php echo $employer['recruiter_name']; ?></strong></span>
				<span id="department"><?php echo $vals['department'] ? ' - '.$vals['department'] : ''; ?></h6>
				<h6>Posted: <strong><?php echo $vals['publish_from']; ?></strong></h6>
			
			<div class="row jobspec">
			<div class="col-xs-8">
				<table>
					<tr>
						<td style="padding-right: 10px">Salary:</td>
						<td><strong><?php echo $vals['salary_details']; ?></strong></td>
					</tr>
					<tr>
						<td style="padding-right: 10px">Location:</td>
						<td><strong><?php echo $vals['location'] ? $vals['location'] : ''; ?></strong></td>
					</tr>
					<tr>
						<td style="padding-right: 10px">Hours:</td>
						<td><strong><?php echo $vals['hours'][0]; ?></strong></td>
					</tr>
					<tr>
						<td style="padding-right: 10px">Contract:</td>
						<td><strong><?php echo $vals['contract'][0]; ?></strong></td>
					</tr>
					<tr>
						<td style="padding-right: 10px">Job ref:</td>
						<td><strong><?php echo $vals['job_ref']; ?></strong></td>
					</tr>
				</table>

				
				<p></p>

				<?php if($vals['doc_upload']) { 
					$q = $job->getQuestion('doc_download_label');
					$ddl = $job->recursive_array_search($vals['doc_download_label'][0],$q['value']);
				?>
				<a href="<?php echo $vals['doc_upload']; ?>" target="_blank">
				<input type="button" value="Download <?php echo $ddl; ?>" class="btn btn-default"/>
				</a>
								
				<?php } ?>

				<?php if($employer['video']) { ?>
				<input type="button" value="Recruiter video" class="btn btn-default openswitch" target="videoholder"/>

								
				<?php } ?>
				
				
				
			</div>

			<div class="col-xs-4" style="text-align: center;">
				
				<?php if($vals['closing_date']) {
					$datearr = explode(' ', $vals['closing_date']); ?>
					<h4 class="purple"><span class="hidden-xs">Applications close</span><span class="visible-xs">Closes</span></h4>
				<div class="calpanel">
					<div class="day"><?php echo $datearr[0]; ?></div>
					<div class="month"><?php echo $datearr[1]; ?></div>
				</div>
				<?php } ?>
				
			</div>
			
			<div class="clear"></div>

			<div class="col-md-12">
				<div class="videoholder" id="<?php echo $employer['video']; ?>">
					<?php include('includes/recruiter_video.php'); ?>
				</div>
			</div>
			</div>
			
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
				
				<div class="qpanel">
<!--
					<ul class="tabs">
						<li class="active">Application form</li>
						<?php if(!$user) echo '<li><a href="/log-in" class="show_login" redirect="'.$_SERVER['REQUEST_URI'].'">Log in</a></li>'; ?>
						<li><a href="?linkedin=login">Apply with LinkedIn</a></li>
					</ul>
-->
					
					<?php if($vals['application_method'][0] == 'form') { ?>
						
						<h3 class="purple" style="margin-top: 0px;">Apply now</h3>

						<?php if(!$user) { ?>
						<h4>Already registered?</h4>
						<p><a href="/log-in" class="show_login" redirect="<?php echo $_SERVER['REQUEST_URI']; ?>">Click here to login and autocomplete this form</a></p>
						<?php } ?>
	
						<?php $application->printGroup('headline',$uservals); ?>
						<?php $application->printQuestion('job_id',$_REQUEST['i']); ?>
						<?php $application->printQuestion('job_title',$vals['job_title']); ?>
						<?php $application->printQuestion('job_ref',$vals['job_ref']); ?>
						<input type="submit" value="Submit application" class="btn btn-default"/>
						<div class="clear"></div>
						
					<?php } ?>
					
					<?php if($vals['application_method'][0] == 'website') { 
						
						$weburl = 'http://'.preg_replace('#^https?://#', '', $vals['application_website']);
						echo '<a href="'.$weburl.'"><input type="button" class="btn btn-default btn-lg purplegrad" value="Apply now" /></a>';
					
					} ?>

					<?php if($vals['application_method'][0] == 'email') { 
						
						echo '<a href="mailto:'.$vals['application_email'].'"><input type="button" class="btn btn-default btn-lg purplegrad" value="Apply now" /></a>';

										
					} ?>
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
					<input type="submit" value="Register" class="btn btn-default"/>
				</div>				
			</form>
			
			<?php $terms = wp_get_post_terms($_REQUEST['i'],'sector');
	foreach($terms as $term) $termsarr[] = '<a href="/jobs?industry='.$term->slug.'" class="purple">'.$term->name.'</a>'; ?>
	
	<h6 style="color: #999999;">Listed in <?php echo implode(', ', $termsarr); ?></h6>
		
			</div>
		</div><!-- end threeqtrscol -->
		
		<div class="col-md-4">
			<h3 class="purple">Share this job</h3>
			<?php get_template_part('includes/addtoany'); ?>
			
						<div class="whitepanel" style="padding: 12px;">
			<h3 class="purple" style="margin-top: 0px">Similar jobs</h3>
			
			<?php $similar = similarByString($vals['job_title'],'job_title',array('job_title','location','salary_details'),'job');
					foreach($similar as $sim){ 
						if($_REQUEST['i'] != $sim['ID']){
					?>						<hr style="margin: 8px 0;">

						<h5 class="purple" style="margin-bottom: 0px; font-size: 1.1em;">
							<a href="/job?i=<?php echo $sim['ID']; ?>">
								<?php echo $sim['job_title']; ?>
							</a>
						</h5>
						<p><?php echo $sim['salary_details']; ?>, <?php echo $sim['location']; ?></p>

			<?php }}	?>
						</div>

						<div class="whitepanel" style="padding: 12px;">

			<h3 class="purple" style="margin-top: 0px">Other jobs from <?php echo $employer['recruiter_name']; ?></h3>
			
			<?php 

			// $args = array(
			// 		'post_type' => 'job',
			// 		'meta_query' => array(
			// 			array(
			// 				'key'     => 'group_id',
			// 				'value'   => $vals['group_id'],
			// 			),
			// 		)
			// 	);
				
			// 	$others = new WP_Query($args);


				$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('now'));

					$params['group_id'] = $vals['group_id'];
					$others = directory_search($params);
					//echo '<pre>'; echo count($others->posts); echo '</pre>';

					foreach($others->posts as $other){ if($_REQUEST['i'] != $other->ID){ ?>

						<hr style="margin: 8px 0;">
						<h5 class="purple" style="margin-bottom: 0px; font-size: 1.1em;">
							<a href="/job?i=<?php echo $other->ID; ?>">
								<?php echo $other->meta['job_title']; ?>
							</a>
						</h5>
						<p><?php echo $other->meta['salary_details'] ?>, <?php echo $other->meta['location'] ?></p>

					<?php }} ?>

				
				

						</div>
						
				<div class="whitepanel" style="padding: 12px;">
					<h3 class="purple">Email me jobs like this</h3>
					<form class="directory subscription create" id="jobs_subscribe" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
						
						<input type="hidden" name="type" value="subscription" />
						<input type="hidden" name="subscription_type" value="jobalert" />
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
						<input type="hidden" name="action" value="directory_create" />

						<input type="hidden" name="job_title" value="<?php echo $vals['job_title']; ?>" />
						<?php $subscription->printQuestion('item_type','job'); ?>
						<?php $subscription->printQuestion('status','active'); ?>
						<?php $subscription->printQuestion('industry',$vals['industry'][0]); ?>
						<?php $subscription->printQuestion('subscription_date',strtotime('now')); ?>
						
						<input type="email" name="subscriber_email" value="<?php echo $user->user_email ? $user->user_email : ''; ?>" />
						<input type="hidden" name="expire" value="7" />
						<input type="submit" value="Submit" class="btn btn-default" />
						
					</form>
				</div>

			
				
				<p style="padding-top: 20px;">
				<a href="../job-print?i=<?php echo $_REQUEST['i']; ?>" class="purple" target="_blank">Print job</a>
				</p>

				<p style="padding-top: 15px;">
				<a href="#" class="reportjob purple">Report this job</a>
				</p>
				
				<form class="directory job notify" id="report_job" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" style="display: none;">
					
					<?php
						$secured = array(
										'type' => 'job',
										'post_id' => $_REQUEST['i'],
										'job_title' => $vals['job_title'],
										'job_ref' => $vals['job_ref'],
										'notify' => SYSADMIN_EMAIL
									);
									
						$secured = http_build_query($secured);
											
					 ?>
			 	
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_notify"); ?>" />
					<input type="hidden" name="action" value="directory_notify" />
					<input type="hidden" name="successmessage" value="The job has been reported. If you provided your email address we will notify you of any action we have taken." />
					<input type="hidden" name="notify_subject" value="Report Job" />
					<input type="hidden" name="notify_template" value="report_job" />
					<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt($secured); ?>" />
					<input type="email" name="reporter_email" placeholder="Your email (optional)" style="width: 100%; margin-bottom: 6px"/>
	 				<input type="submit" class="btn btn-default" value="Report this job" />
				</form>
		</div>


		<div class="clear"></div>
		
	</div>
</div>
</div>

<?php $sector->getTermChildren(0); ?>



<?php get_footer(); ?>

<script>
	jQuery(function(){
		jQuery('a.reportjob').click(function(e){
			e.preventDefault();
			jQuery('#report_job').fadeIn();
		});
		
		jQuery('.openswitch').click(function(){
			var target = jQuery(this).attr('target');
			//alert('opening '+target);
			jQuery('.'+target).toggleClass('open');
			
		});
	});
</script>