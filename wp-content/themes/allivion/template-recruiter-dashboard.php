<?php

/*
Template Name: Recruiter dashboard
*/

$dircore->canAccess(array('roles' => 'recruiter_admin,recruiter'));
	
get_template_part('header','recadmin');
	
while (have_posts()) { 
		the_post();
		the_content();
} 


/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results
$returnfields = array('job_title','job_ref','location','job_status');

// Group ID
$group_id = $usermeta['group_id'] ? $usermeta['group_id'] : $user->ID;


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="container a2apad">
	<div class="row">
		
		<div class="col-md-12">
		<h1 class="purple">Job advertisements</h1>
		</div>
		
			<div class="col-md-6">

				<form class="directory <?php echo $job->type; ?>" id="createjob" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_create" />
 					<input type="hidden" name="redirect" value="/job-details" />
					<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('group_id='.$group_id.'&type=job&job_status=active'); ?>" />

					<div class="qpanel purplegrad">
						<h2>Create a new ad</h2>
						<?php $job->printQuestion('job_title'); ?>
						<?php $job->printQuestion('job_ref'); ?>
						<input type="submit" value="Save and add details" class="fr btn btn-default"/>
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
			<div class="col-md-6">
				

				<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job-details">
				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
					<input type="hidden" name="action" value="directory_search" />
					
					<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('group_id='.$group_id.'&type=job'); ?>" />
				

					<div class="qpanel">
						<h2>Search jobs</h2>
						<label>Keywords</label><input type="text" name="keywords" value="" />
						<div class="clear"></div>
						<div class="halfcol">
						<?php $job->printQuestion('job_status'); ?>
						</div>
						<?php //$user->printQuestion('name'); ?>
						<input type="submit" value="Search" class="fr btn btn-default"/>
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
			<div class="clear"></div>
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job');
				$items = directory_search($params);
			?>

			<div class="col-md-12" style="padding-top: 20px; padding: 20px;">
			<table class="searchresults">
				<thead>
					<tr>
						<?php foreach($returnfields as $field){ ?>
						<td><?php $q = $job->getQuestion($field); echo $q['label']; ?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody id="jobslist">
							
				<?php foreach ($items->posts as $item){ ?>
					<tr class="clickable" data-href="/job-details?i=<?php echo $item->ID; ?>">
						<?php foreach($returnfields as $field){ ?>
						<td>
							<?php
								$v = $item->meta[$field];
								echo is_array($v) ? $v[0] : $v;
							?>
						</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			</div>			
							

		
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>