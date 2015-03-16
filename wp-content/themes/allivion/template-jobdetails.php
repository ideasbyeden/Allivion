<?php

/*
Template Name: Job details
*/

$job->canEdit($_REQUEST['i']);
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

	
get_header();
	
while (have_posts()) { 
		the_post();
		the_content();
} 


?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">Create job advertisement</h1>

			<form class="directory <?php echo $job->type; ?> update" id="jobdetails" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
				<input type="hidden" name="post_id" value="<?php echo $_REQUEST['i']; ?>" />
				<input type="hidden" name="varnames" value="<?php echo implode(',', $job->getVarNames()); ?>" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_update" />
				
				
				<div class="halfcol">

					<div class="qpanel">
						<?php $job->printGroup('headline',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('package',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('industry_location',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('details',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('extra',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('admin',$vals); ?>
					</div>
				
				</div>
				
				<div class="halfcol">
					<div id="adpreview" class="preview">
						<h3>Ad preview</h3>
						<input type="submit" value="Save changes" />
						<hr>
						<h4><span id="job_title"><?php echo $vals['job_title'] ? $vals['job_title'] : 'Job Title'; ?></span>, <span id="location"><?php echo $vals['location'] ? $vals['location'] : 'Location'; ?></span></h4>
						<h6><span id="employer">Employer name</span></h6>
						<h6><span id="salary_details"><?php echo $vals['salary_details'] ? $vals['salary_details'] : 'Salary'; ?></span></h6>
						<div><span id="full_description"><?php echo $vals['full_description'] ? $vals['full_description'] : 'Job description'; ?></span></div>
					</div>
				</div>
				
			</form>
		
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>