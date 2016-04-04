<?php

/*
Template Name: Recruiter dashboard
*/

$dircore->canAccess(array('roles' => 'recruiter_admin,recruiter'));
	
get_template_part('header','recadmin');
	



/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results
$returnfields = array('job_title','job_ref','location','job_status','publish_from','closing_date');

// Group ID
$group_id = $usermeta['group_id'] ? $usermeta['group_id'] : $user->ID;

$account_level = get_user_meta($group_id,'subscriber',true);
//echo '<pre>'; print_r($account_level); echo '</pre>'

/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

$regcompletion = false;
$required = array('recruiter_name','contact_phone','default_app_email','website','main_address');
foreach($required as $item){
	if($usermeta[$item] == '') $regcompletion = true;
}

?>

<!-- <pre><?php print_r($usermeta); ?></pre> -->

<div class="container a2apad">
	<div class="row">
		
		<div class="col-md-12">
		<h1 class="purple">Advert dashboard</h1>
		<h3><?php echo $account_level == 'annual' ? 'Annual subscriber' : 'Standard account'; ?></h3>
		<?php while (have_posts()) { 
		the_post();
		the_content();
		} ?>
		<div class="alert alert-warning">
			<strong>Need help?</strong> To ask a question, simply get in touch with our support team on 0208 310 3131 or email us at <a href="mailto:info@allivion.com">info@allivion.com</a> 
		</div> 
		</div>
		<div class="clear"></div>
		<?php if($account_level == 'standard'){ ?>
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Become an annual subscriber</strong> Become an annual subscriber to have multiple users and access to our candidate search engine. Email <a href="mailto:subscriptions@allivion.com">subscriptions@allivion.com</a>
			</div>

		<?php } ?>

		<div class="clear"></div>

		<div class="container" id="dashboard_counts" style="padding: 0 30px 12px">
			<div class="qpanel col-sm-12">
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">
				<?php 
					$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&industry=!studentships&job_status=published');
					$items = directory_search($params);
				?>
				<h1><?php echo count($items->posts); ?></h1>
				<h4>Live Jobs</h4>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">
				<?php 
					$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&industry=studentships&job_status=published');
					$items = directory_search($params);
				?>
				<h1><?php echo count($items->posts); ?></h1>
				<h4>Live Studentships</h4>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">
				<?php 
					$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&job_status=draft');
					$items = directory_search($params);
				?>
				<h1><?php echo count($items->posts); ?></h1>
				<h4>Drafts</h4>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">
				<?php 
					$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&job_status=archived');
					$items = directory_search($params);
				?>			
				<h1><?php echo count($items->posts); ?></h1>
				<h4>Archived</h4>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: center;">
				<?php 
					$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job');
					$items = directory_search($params);
				?>
				<h1><?php echo count($items->posts); ?></h1>
				<h4>Total</h4>
			</div>
			<div class="clear"></div>
			</div>
		</div>
			
		</div>
		
			<div class="col-md-6">

				<?php if($regcompletion) { // User needs to complete registration ?>

						<div class="qpanel purplegrad">
							<h2>Please complete your profile</h2>
							<p>You must complete your profile before you can create a job. Make sure you provide:</p>
							<ul>
								<li>Organisation name</li>
								<li>Contact phone number</li>
								<li>Your default application email address</li>
								<li>Website</li>
								<li>Main address</li>
							</ul>
							<a href="/recruiter-profile">
								<button class="btn btn-default fr">Complete profile</button>
							</a>
							<div class="clear"></div>
						</div>

				<?php } else { ?>

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

				<?php } ?>
				
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
				$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&industry=!studentships');
				$params['expire'] = array('publish_from' => 999999999999999);
				$items = directory_search($params);
			?>

			<div class="col-md-12" style="padding-top: 20px; padding: 20px;">
			<h2>Jobs</h2>
			<table class="searchresults recadmin">
				<thead>
					<tr>
						<?php foreach($returnfields as $field){ ?>
						<td><?php $q = $job->getQuestion($field); echo $q['label']; ?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody id="jobslist">
							
				<?php foreach ($items->posts as $item){ ?>
					<tr class="clickable <?php echo $item->meta['ad_type'][0]; ?>" data-href="/job-details?i=<?php echo $item->ID; ?>">
						<?php foreach($returnfields as $field){ ?>
						<td style="padding-top: 2px !important;">
							<?php
								$v = $item->meta[$field];
								echo is_array($v) ? $v[0] : $v;
							?>
						</td>
						<?php } ?>
					</tr>
				<?php } ?>

						

			<?php 
				$params = $_GET ? $_GET : array();
				$params['encrypted'] = $dircore->encrypt('group_id='.$group_id.'&type=job&industry=studentships');
				$items = directory_search($params);
			?>

			<tr style="background-color: white !important"><td colspan="99"><h2>Studentships</h2></td></tr>

							
				<?php foreach ($items->posts as $item){ ?>
					<tr class="clickable <?php echo $item->meta['ad_type'][0]; ?>" data-href="/job-details?i=<?php echo $item->ID; ?>">
						<?php foreach($returnfields as $field){ ?>
						<td style="padding-top: 2px !important;">
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