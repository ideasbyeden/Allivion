<?php

/*
Template Name: Sysadmin promotions
*/

$dircore->canAccess(array('roles' => 'administrator'));
	
get_template_part('header','sysadmin');
	
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

$returnfields = array('job_title','job_ref','promote','promote_from','promote_to','promote_enabled');


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////


?>

<div class="container a2apad">
	<div class="row">
		
		<div class="col-md-8">
			<h1 class="purple">Promotions</h1>
		</div>
		
						
		<div class="col-md-6">
			

			<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job-details">
			
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_search" />
				<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('&type=job'); ?>" />
			

				<div class="qpanel">
					<h2>Filter</h2>
					
					
					<?php $recusers = $recruiter_admin->getUsers(); //echo pre($recusers->results); ?>
						<div class="question">
 						<label>Recruiter</label>
 						<select name="group_id">
	 						<option value="">Select</option>
	 						<?php foreach($recusers->results as $user){ 
		 						$group_id = get_user_meta($user->ID,'group_id',true);
		 						$group_id = $group_id != '' ? $group_id : $user->ID;
	 						?>
	 							<option value="<?php echo $group_id; ?>"><?php echo $user->data->display_name; ?></option>
	 						<?php } ?>
 						</select>
 					</div>
					
					<?php $job->printQuestion('promote'); ?>
					
					
					<input type="submit" value="Search" class="fr"/>
					<div class="clear"></div>
				</div>
				
			</form>
			
		</div>
			
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['type'] = 'job';
				//echo pre($params); 
				$items = directory_search($params);
			?>

		<div class="col-md-12" style="padding-top: 20px; padding-bottom: 20px;">	
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
					<tr class="clickable rowitem" data-href="/job-details?i=<?php echo $item->ID; ?>">
						<?php foreach($returnfields as $field){ ?>
						<td><?php echo $item->meta[$field]; ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>			
			
				

		
		
	</div>
</div>

<?php get_footer(); ?>