<?php

/*
Template Name: Recruiter Candidate Search
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
$returnfields = array('first_name','last_name','cv_intro');




/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="container a2apad">
	<div class="row">
		


				

				<form class="directory <?php echo $candidate->type; ?> searchuser" id="searchcandidates" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="userslist" clickableurl="/candidate-details">
				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
					<input type="hidden" name="action" value="directory_search_user" />
					
					<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('role=candidate'); ?>" />
				

					<div class="qpanel">
						<div class="container">
						<div class="row">

							<div class="col-md-6">
								<h2>Search candidates</h2>
								<p>Search for candidates using keywords or phrases to find the best matches for your requirements</p>
							
								<label>Keywords&nbsp;</label><input type="text" name="keywords" value="" />
								<input type="submit" value="Search" class="fr btn btn-default"/>
							</div>
						</div>
						</div>
					</div>
					
				</form>
				
			</div>
			
			<div class="clear"></div>
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['encrypted'] = $dircore->encrypt('role=candidate');
				$users = directory_search_user($params);
			?>

			<div class="col-md-12" style="padding-top: 20px; padding: 20px;">
			<table class="searchresults">
				<thead>
					<tr>
						<?php foreach($returnfields as $field){ ?>
						<td><?php $q = $candidate->getQuestion($field); echo $q['label']; ?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody id="userslist">
					
				<tr class="prototype" data-href="/candidate-details?i=">
					<td>[first_name] [last_name]</td>
					<td>[cv_intro]</td>
				</tr>
					
							
				<?php foreach ($users->results as $user){ ?>
					<tr class="clickable rowitem" data-href="/candidate-details?i=<?php echo $user->ID; ?>">
						<td>
							<?php //echo substr($user->meta['first_name'],0,1).substr($user->meta['last_name'],0,1); ?>
							<?php echo $user->meta['first_name'].' '.$user->meta['last_name']; ?>
						</td>
						<td>
							<?php echo $user->meta['cv_intro']; ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			</div>			
							

		
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>